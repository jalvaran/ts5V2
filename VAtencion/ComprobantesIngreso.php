<?php 
$myPage="ComprobantesIngreso.php";
include_once("../sesiones/php_control.php");
include_once("css_construct.php");

print("<html>");
print("<head>");
$css =  new CssIni("Comprobantes Ingreso");
$obVenta=new ProcesoVenta($idUser);  
$obTabla = new Tabla($db);
$idComprobante=0;
$TipoMovimiento=0;
if(isset($_REQUEST["idComprobante"])){
    $idComprobante=$obVenta->normalizar($_REQUEST["idComprobante"]);
    
}
if(isset($_REQUEST["TipoMovimiento"])){
    $TipoMovimiento=$obVenta->normalizar($_REQUEST["TipoMovimiento"]);
    
}
print("</head>");
print("<body>");
    
    include_once("procesadores/ComprobantesIngreso.process.php");
    
    $css->CabeceraIni("Registrar Ingreso"); //Inicia la cabecera de la pagina
    $css->CreaBotonDesplegable("CrearComprobanteIngreso","Nuevo");  
    $css->CabeceraFin(); 
    
    //Creo los cuadros de dialogo
    
    $css->CrearCuadroDeDialogo("CrearComprobanteIngreso","Crear un Comprobante de ingreso"); 
        $css->CrearForm2("FrmCreaPreMovimiento", $myPage, "post", "_self");
        $css->CrearTabla();
        $css->FilaTabla(16);
            $css->ColTabla("<strong>Fecha</strong>", 1);
            $css->ColTabla("<strong>Tercero</strong>", 1);
            $css->ColTabla("<strong>Cuenta Destino</strong>", 1);
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
        print("<td>");
        $css->CrearInputFecha("", "TxtFecha", date("Y-m-d"), 100, 30, "");
        
        print("</td>");        
         print("<td>");
            $VarSelect["Ancho"]="200";
            $VarSelect["PlaceHolder"]="Seleccione el tercero";
            $css->CrearSelectChosen("TxtTerceroCI", $VarSelect);
               
               $sql="SELECT * FROM clientes";
            $Consulta=$obVenta->Query($sql);
               while($DatosProveedores=$obVenta->FetchArray($Consulta)){
                   $Sel=0;
                   
                   $css->CrearOptionSelect($DatosProveedores["Num_Identificacion"], "$DatosProveedores[RazonSocial] $DatosProveedores[Num_Identificacion]" , $Sel);
               }
            $css->CerrarSelect();
        print("</td>"); 
         print("<td>");
        
        $css->CrearSelect("CmbCuentaDestino", "");
        $Consulta=$obVenta->ConsultarTabla("subcuentas", "WHERE PUC LIKE '11%'");
            if($obVenta->NumRows($Consulta)){
            while($DatosCuentasFrecuentes=  $obVenta->FetchArray($Consulta)){
                $css->CrearOptionSelect($DatosCuentasFrecuentes["PUC"], $DatosCuentasFrecuentes["Nombre"]." ".$DatosCuentasFrecuentes["PUC"], 0);
            }
            }else{
                print("<script>alert('No hay cuentas frecuentes creadas debe crear al menos una')</script>");
            }
        $css->CerrarSelect();
         print("</td>");
        $css->CierraFilaTabla();
        $css->FilaTabla(16); 
       
            $css->ColTabla("<strong>Monto</strong>", 1);
            $css->ColTabla("<strong>Detalle</strong>", 1);
            $css->ColTabla("<strong>Crear</strong>", 1);
            
            
        $css->CierraFilaTabla();
        
         print("<td>");
        $css->CrearInputNumber("TxtMontoCI", "number", "", "", "Monto", "", "", "", 150, 30, 0, 1, 0, "", 1);
        $css->CrearSelect("CmbCentroCosto"," Centro de Costos:<br>","black","",1);
        //$this->css->CrearOptionSelect("","Seleccionar Centro de Costos",0);

        $Consulta = $obVenta->ConsultarTabla("centrocosto","");
        while($CentroCosto=$obVenta->FetchArray($Consulta)){
                        $css->CrearOptionSelect($CentroCosto['ID'],$CentroCosto['Nombre'],0);							
        }
        $css->CerrarSelect();
         print("<br>");
        $css->CrearSelect("idSucursal"," Sucursal:<br>","black","",1);
        //$this->css->CrearOptionSelect("","Seleccionar Sucursal",0);

        $Consulta = $obVenta->ConsultarTabla("empresa_pro_sucursales","");
        while($CentroCosto=$obVenta->FetchArray($Consulta)){
                        $css->CrearOptionSelect($CentroCosto['ID'],$CentroCosto['Nombre'],0);							
        }
        $css->CerrarSelect();
        print("</td>"); 
        print("<td>");
        $css->CrearTextArea("TxtConceptoComprobante","","","Escriba el detalle","black","","",200,100,0,1);
        print("</td>");
       
        
        print("<td>");
        $css->CrearBotonConfirmado("BtnCrearCI", "Crear");
        print("</td>");   
        $css->CierraFilaTabla();
    $css->CerrarTabla();
    $css->CerrarForm();
    $css->CerrarCuadroDeDialogo(); 
    
    //Fin Cuadros de Dialogo
    ///////////////Creamos el contenedor
        
    $css->CrearDiv("principal", "container", "center",1,1);
    $css->CrearForm2("FrmSeleccionaCom", $myPage, "post", "_self");
    $css->CrearSelect("idComprobante", "EnviaForm('FrmSeleccionaCom')");
        
            $css->CrearOptionSelect("","Selecciona un Comprobante",0);
            
            $consulta = $obVenta->ConsultarTabla("comprobantes_ingreso","WHERE Estado='ABIERTO'");
            while($DatosComprobante=$obVenta->FetchArray($consulta)){
                if($idComprobante==$DatosComprobante['ID']){
                    $Sel=1;
                    
                }else{
                    
                    $Sel=0;
                }
                $css->CrearOptionSelect($DatosComprobante['ID'],$DatosComprobante['ID']." ".$DatosComprobante['Concepto'],$Sel);							
            }
        $css->CerrarSelect();
    $css->CerrarForm();
       
    if($idComprobante>0){
        $css->CrearForm2("FrmSeleccionaTipoComp", $myPage, "post", "_self");
        $css->CrearInputText("idComprobante", "hidden", "", $idComprobante, "", "", "", "", "", "", "", "");
        $css->CrearSelect("TipoMovimiento", "EnviaForm('FrmSeleccionaTipoComp')");
        $sel=0;
            $css->CrearOptionSelect("","Selecciona Tipo de Movimiento",0);
            if($TipoMovimiento==1){
                $sel=1;
            }
            $css->CrearOptionSelect(1,"Movimiento Libre",$sel);
            $sel=0;
            if($TipoMovimiento==2){
                $sel=1;
            }
            $css->CrearOptionSelect(2,"Desde Cuenta X Cobrar",$sel);
        $css->CerrarSelect();
    $css->CerrarForm();
    }
    ///////////////Se crea el DIV que servirá de contenedor secundario
    /////
    /////
    $css->CrearDiv("Secundario", "container", "center",1,1);
   										
    /*
     * Dibujamos el formulario para seleccionar los datos del ingreso
     * 
     */
    if(!empty($_REQUEST["TxtidIngreso"])){
        $RutaPrintIngreso="../tcpdf/examples/imprimiringreso.php?ImgPrintIngreso=".$_REQUEST["TxtidIngreso"];			
        $css->CrearTabla();
        $css->CrearFilaNotificacion("Comprobante de Ingreso Creado Correctamente <a href='$RutaPrintIngreso' target='_blank'>Imprimir Comprobante de Ingreso No. $_REQUEST[TxtidIngreso]</a>",16);
        $css->CerrarTabla();
    }
      
    //movimientos contables
    
    if($idComprobante>0){
        if($TipoMovimiento==1){
            $css->CrearNotificacionAzul("Ingrese los datos para realizar el movimiento", 16);
            $obTabla->DibujeAgregaMovimientoContable($myPage, 1, $idComprobante);  //Dibujo movimiento libre    
        }
        if($TipoMovimiento==2){
            $DatosComprobante=$obVenta->DevuelveValores("comprobantes_ingreso", "ID", $idComprobante);
            $idCliente=$DatosComprobante["Tercero"];
            $css->CrearNotificacionAzul("Busque y seleccione una Cuenta X Cobrar", 16);
            $css->CrearForm2("FrmSelCartera", $myPage, "post", "_self");
            $css->CrearInputText("idComprobante", "hidden", "", $idComprobante, "", "", "", "", "", "", "", "");
            $css->CrearInputText("TipoMovimiento", "hidden", "", 3, "", "", "", "", "", "", "", "");
            $css->CrearTabla();
            $css->FilaTabla(16);
            print("<td style='text-align:center'><strong>Busca y Selecciona una Cuenta X Cobrar:</strong><br><br>");
            $VarSelect["Ancho"]="800";
            $VarSelect["PlaceHolder"]="Seleccione la Cuenta X Cobrar";
            $css->CrearSelectChosen("CmbCuentaXCobrar", $VarSelect);

            $sql="SELECT * FROM cartera c INNER JOIN facturas f ON c.Facturas_idFacturas=f.idFacturas "
                    . "INNER JOIN clientes cl ON c.idCliente=cl.idClientes WHERE c.Saldo>0 AND cl.Num_Identificacion='$idCliente'";
            $Consulta=$obVenta->Query($sql);
               while($DatosCartera=$obVenta->FetchArray($Consulta)){
                   $Sel=0;
                   $DatosCliente=$obVenta->DevuelveValores("clientes", "idClientes", $DatosCartera["idCliente"]);
                   $css->CrearOptionSelect($DatosCartera["idCartera"], "$DatosCartera[RazonSocial] $DatosCliente[Num_Identificacion]; Numero Factura: $DatosCartera[Prefijo] - $DatosCartera[NumeroFactura]; Fecha: $DatosCartera[Fecha]; Total: $DatosCartera[Total]; Abonos: $DatosCartera[TotalAbonos]; Saldo: $DatosCartera[Saldo]" , $Sel);
               }
               $css->CerrarSelect();
               print("<br><br>");
            $css->CrearBoton("BtnSeleccionaCXC", "Enviar"); 
            print("</td>");
            $css->CierraFilaTabla();
            $css->CerrarTabla();
            $css->CerrarForm();   
        }
        if($TipoMovimiento==3){
            $idCartera=$obVenta->normalizar($_REQUEST["CmbCuentaXCobrar"]);
            $Notificacion=$obTabla->DibujePreMovimientoCartera($myPage,$idCartera,$idComprobante,"");
            if($Notificacion>0){
                $css->CrearNotificacionRoja("Esta Cuenta X Cobrar ya esta agregada en el CI $Notificacion, debe cerrar ese comprobante si desea agregar esta Cuenta X Cobrar a Otro", 16);
            }
        }
    $sql="SELECT SUM(Debito) as Debito, SUM(Credito) as Credito FROM comprobantes_ingreso_items WHERE idComprobante='$idComprobante'";
    $consulta=$obVenta->Query($sql);
    $DatosSumas=$obVenta->FetchArray($consulta);    
    $Debitos=$DatosSumas["Debito"];
    $Credito=$DatosSumas["Credito"];
    $Neto=$Debitos-$Credito;
    if($Neto<>0){
        $css->CrearNotificacionRoja("Debitos = $Debitos, Creditos = $Credito, existe una diferencia de $Neto, no podrá guardar hasta que no sean iguales", 14);
        $H=0;
        
    }else{
        $css->CrearNotificacionVerde("Debitos = $Debitos, Creditos = $Credito, Pulse el boton si desea cerrar el comprobante", 14);
        $H=1;
    }
    
    $css->CrearForm2("FrmCerrarCompC", $myPage, "post", "_self");
    $css->CrearInputText("idComprobante","hidden",'',$idComprobante,'',"","","",300,30,0,0);
    $css->CrearBotonConfirmado2("BtnGuardarCI", "Guardar y Cerrar Comprobante",$H,"");
    
    print("<br><br><br>");
    $css->CerrarForm();
    ////Se dibujan los items del movimiento
    $css->CrearSelect("CmbMostrarItems", "MuestraOculta('DivItems')");
        $css->CrearOptionSelect("SI", "Mostrar Movimientos", 0);
        $css->CrearOptionSelect("NO", "Ocultar Movimientos", 0);
    $css->CerrarSelect();
    $css->CrearDiv("DivItems", "", "center", 1, 1);
    $Vector["Tabla"]="comprobantes_ingreso_items";
    $Columnas=$obTabla->ColumnasInfo($Vector);
    $css->CrearTabla();
    $css->FilaTabla(12);
    
    $i=0;
    $ColNames[]="";
    $css->ColTabla("<strong>Borrar</strong>", 1);
    foreach($Columnas["Field"] as $NombresCol ){
        $css->ColTabla("<strong>$NombresCol</strong>", 1);
        $ColNames[$i]=$NombresCol;
        $i++;
    }
    
    $NumCols=$i-1;
    $css->CierraFilaTabla();
    
    $i=0;
    $sql="SELECT * FROM comprobantes_ingreso_items WHERE idComprobante='$idComprobante'";
    $consulta=$obVenta->Query($sql);
    
    while($DatosItems=$obVenta->FetchArray($consulta)){
        
        $css->FilaTabla(12);
        $css->ColTablaDel($myPage,"comprobantes_ingreso_items","ID",$DatosItems['ID'],$idComprobante);
        for($z=0;$z<=$NumCols;$z++){
            $NombreCol=$ColNames[$z];
            print("<td>");
            if($NombreCol=="Soporte"){
                $link=$DatosItems[$NombreCol];
                if($link<>""){
                    $css->CrearLink($link, "_blank", "Ver");
                }
            }else{
                print($DatosItems[$NombreCol]);
            }
            
            print("</td>");
            
        }
        
        $i=0;
        $css->CierraFilaTabla();
        
    }
    
    $css->CerrarTabla();
    $css->CerrarDiv();//Cerramos Div con los items agregados
    }
    $css->CerrarDiv();//Cerramos contenedor Secundario
    $css->CerrarDiv();//Cerramos contenedor Principal
    $css->AgregaJS(); //Agregamos javascripts
    $css->AgregaSubir();
    $css->Footer();
    $css->AnchoElemento("TxtTerceroCI_chosen", 200);
    $css->AnchoElemento("CmbCuentaXCobrar_chosen", 800);
    print("</body></html>");
?>