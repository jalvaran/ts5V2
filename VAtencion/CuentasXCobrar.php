<?php
$myPage="CuentasXCobrar.php";
include_once("../sesiones/php_control.php");
////////// Paginacion
$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);

    	$limit = 10;
    	$startpoint = ($page * $limit) - $limit;
		
/////////


        
        
include_once ('funciones/function.php');  //En esta funcion está la paginacion

include_once("Configuraciones/cuentasxcobrar.ini.php");  //Clases de donde se escribirán las tablas
$obTabla = new Tabla($db);

$idComprobante=0;
$ImprimeCC=0;
if(isset($_REQUEST["idComprobante"])){
    $idComprobante=$_REQUEST["idComprobante"];
    
}

if(isset($_REQUEST["ImprimeCC"])){
    $ImprimeCC=$_REQUEST["ImprimeCC"];
    $idComprobante=0;
}


include_once("procesadores/ProcesaCuentasXCobrar.php");
$statement = $obTabla->CreeFiltroCobros($Vector);
//print($statement);
$Vector["statement"]=$statement;   //Filtro necesario para la paginacion


$obTabla->VerifiqueExport($Vector);

include_once("css_construct.php");
print("<html>");
print("<head>");

$css =  new CssIni($myTitulo);
print("</head>");
print("<body>");
//Cabecera
$css->CabeceraIni($myTitulo); //Inicia la cabecera de la pagina
$css->CreaBotonDesplegable("CrearComprobante","Nuevo Comprobante"); 
$css->CabeceraFin(); 

$css->CreaMenuBasico("Menu"); 
    $css->CreaSubMenuBasico("Historial de Comprobantes","comprobantes_contabilidad_items.php"); 
    $css->CreaSubMenuBasico("Historial de Abonos","abonos_libro.php"); 
$css->CierraMenuBasico(); 
    
///////////////Creamos el contenedor
    /////
    /////
$css->CrearDiv("principal", "container", "center",1,1);

if($ImprimeCC>0){
        $RutaPrintCot="../tcpdf/examples/comprobantecontable.php?idComprobante=$ImprimeCC";			
       
        $css->CrearNotificacionNaranja("Comprobante Creado, <a href='$RutaPrintCot' target='_blank'>Imprimir Comprobante No. $ImprimeCC</a>",16);
        
    }
 
     /////////////////Cuadro de dialogo de Clientes create
    $css->CrearCuadroDeDialogo("CrearComprobante","Crear un Comprobante"); 
        $css->CrearForm2("FrmCreaPreMovimiento", $myPage, "post", "_self");
        $css->CrearTabla();
        $css->FilaTabla(16);
            $css->ColTabla("<strong>Fecha</strong>", 1);
            $css->ColTabla("<strong>Detalle</strong>", 1);
            $css->ColTabla("<strong>Crear</strong>", 1);
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
        print("<td>");
        $css->CrearInputText("TxtFecha", "date", "", date("Y-m-d"), "Fecha", "black", "", "", 100, 30, 0, 1);
        print("</td>");        
            
        print("<td>");
        $css->CrearTextArea("TxtConceptoComprobante","","","Escriba el detalle","black","","",300,100,0,1);
        print("</td>");
        print("<td>");
        $css->CrearBotonConfirmado("BtnCrearComC", "Crear");
        print("</td>");   
        $css->CierraFilaTabla();
    $css->CerrarTabla();
    $css->CerrarForm();
    $css->CerrarCuadroDeDialogo(); 
//print($statement);
///////////////Creamos la imagen representativa de la pagina
    /////
    /////	
//$css->CrearImageLink("../VMenu/Menu.php", "../images/cuentasxpagar.jpg", "_self",200,200);
 //print("<br><br><br>"); 
$css->CrearForm2("FrmSeleccionaCom", $myPage, "post", "_self");
    $css->CrearTabla();
    $css->FilaTabla(16);
    print("<td style='text-align:center'>");
    
        $css->CrearSelect("CmbComprobante", "EnviaForm('FrmSeleccionaCom')");
        
            $css->CrearOptionSelect("","Selecciona un Comprobante",0);
            
            $consulta = $obVenta->ConsultarTabla("comprobantes_pre","WHERE Estado<>'C'");
            while($DatosPreEgreso=$obVenta->FetchArray($consulta)){
                if($idComprobante==$DatosPreEgreso['idComprobanteContabilidad']){
                    $Sel=1;
                    
                }else{
                    
                    $Sel=0;
                }
                $css->CrearOptionSelect($DatosPreEgreso['idComprobanteContabilidad'],$DatosPreEgreso['idComprobanteContabilidad']." ".$DatosPreEgreso['Concepto'],$Sel);							
            }
        $css->CerrarSelect();
    print("</td>");
    $css->CierraFilaTabla();
    $css->CerrarTabla();
    $css->CerrarForm();
 
    
$Visible=0;
    if($idComprobante>0){
        $Visible=1;
    }
    print("<strong>Ocultar/Mostrar Cuentas X Cobrar </strong><image name='imgHidde' id='imgHidde' src='../images/hidde.png' onclick=MuestraOculta('DivDatosItemEgreso2');>");
    $css->CrearDiv("DivDatosItemEgreso2", "", "center", 1, 1);    
////Paginacion
////
 
$Ruta="";
print("<div style='height: 50px;'>");   //Dentro de un DIV para no hacerlo tan grande
print(pagination($Ruta,$statement,$limit,$page));
print("</div>");
////
///Dibujo la tabla
////
///
/*
 * Verifico que haya balance
 */
$Consulta=$obVenta->Query("SELECT SUM(Neto) as Suma FROM $statement");
$Neto=$obVenta->FetchArray($Consulta);
$Neto=  number_format($Neto["Suma"]);
$css->CrearTabla();
$css->CrearFilaNotificacion("Saldo = $Neto", 16);
$css->CerrarTabla();
$Vector["idComprobante"]=$idComprobante;
$Vector["Abonos"]="CuentasXCobrar";
$Vector["TablaAbono"]="abonos_libro";
$Vector["Procesador"]="procesadores/ProcesaCuentasXCobrar.php";
$obTabla->DibujeTabla($Vector);
$css->CerrarDiv();//Cerramos contenedor para agregar items

/*
 * Dibujo interfaz para agregar items
 * 
 */

$css->CrearDiv("DivDatosItemEgreso", "", "center", $Visible, 1);    
$css->CrearForm2("FrmAgregaItemE", $myPage, "post", "_self");
$css->CrearTabla();
    $css->FilaTabla(16);
    $css->ColTabla("<strong>Comprobante:</strong>", 1);
    print("<td>");
       $css->CrearInputText("TxtIdCC", "text", "", $idComprobante, "idEgreso", "black", "", "", 100, 30, 1, 1);
    print("</td>");  
    $css->CierraFilaTabla();   
    $css->FilaTabla(16);
        
        $css->ColTabla("<strong>Centro de Costo</strong>", 1);
        $css->ColTabla("<strong>Tercero</strong>", 1);
        $css->ColTabla("<strong>Cuenta Destino</strong>", 1);
        
    $css->CierraFilaTabla();    
    $css->FilaTabla(16);
        
        
        print("<td>");
					
            $css->CrearSelect("CmbCentroCosto"," Centro de Costos:<br>","black","",1);
            $css->CrearOptionSelect("","Seleccionar Centro de Costos",0);

            $Consulta = $obVenta->ConsultarTabla("centrocosto","");
            while($CentroCosto=$obVenta->FetchArray($Consulta)){
                            $css->CrearOptionSelect($CentroCosto['ID'],$CentroCosto['Nombre'],0);							
            }
            $css->CerrarSelect();

        print("</td>");
        print("<td>");
            $VarSelect["Ancho"]="200";
            $VarSelect["PlaceHolder"]="Seleccione el tercero";
            $css->CrearSelectChosen("CmbTerceroItem", $VarSelect);
            $css->CrearOptionSelect("", "Seleccione un tercero" , 0);
            $sql="SELECT * FROM proveedores";
            $Consulta=$obVenta->Query($sql);
            
               while($DatosProveedores=$obVenta->FetchArray($Consulta)){
                   $Sel=0;
                   
                   $css->CrearOptionSelect($DatosProveedores["Num_Identificacion"], "$DatosProveedores[RazonSocial] $DatosProveedores[Num_Identificacion]" , $Sel);
               }
            $css->CerrarSelect();
        print("</td>");
        print("<td>");
            $VarSelect["Ancho"]="200";
            $VarSelect["PlaceHolder"]="Seleccione la cuenta destino";
            $css->CrearSelectChosen("CmbCuentaDestino", $VarSelect);
            $css->CrearOptionSelect("", "Seleccione la cuenta destino" , 0);
            
            //Solo para cuando el PUC no está todo en subcuentas
            $sql="SELECT * FROM cuentas";
            $Consulta=$obVenta->Query($sql);
            
               while($DatosProveedores=$obVenta->FetchArray($Consulta)){
                   $Sel=0;
                   $NombreCuenta=str_replace(" ","_",$DatosProveedores['Nombre']);
                   $css->CrearOptionSelect($DatosProveedores['idPUC'].';'.$NombreCuenta, "$DatosProveedores[idPUC] $DatosProveedores[Nombre]" , $Sel);
               }
            
            //En subcuentas se debera cargar todo el PUC
            $sql="SELECT * FROM subcuentas";
            $Consulta=$obVenta->Query($sql);
            
               while($DatosProveedores=$obVenta->FetchArray($Consulta)){
                   $Sel=0;
                   $NombreCuenta=str_replace(" ","_",$DatosProveedores['Nombre']);
                   $css->CrearOptionSelect($DatosProveedores['PUC'].';'.$NombreCuenta, "$DatosProveedores[PUC] $DatosProveedores[Nombre]" , $Sel);
               }
            
            $css->CerrarSelect();
        print("</td>");
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
        print("<td>");
        $css->CrearInputNumber("TxtValorItem", "number", "<strong>Valor:</strong><br>", "", "Valor", "black", "", "", 220, 30, 0, 1, 1, "", 1);
        print("<br>");
       
        $css->CrearSelect("CmbDebitoCredito", "");
            $css->CrearOptionSelect("D", "Debito", 1);
            $css->CrearOptionSelect("C", "Credito", 0);
        $css->CerrarSelect();
        print("</td>");
    
       
        print("<td>");
        $css->CrearTextArea("TxtConceptoEgreso","<strong>Concepto:</strong><br>","","Escriba el Concepto","black","","",300,100,0,1);
        print("</td>");
        print("<td>");
        $css->CrearInputText("TxtNumFactura","text",'Numero del Documento soporte:<br>',"","Numero del documento","black","","",300,30,0,1);
        echo"<br>";
        $css->CrearUpload("foto");
        echo"<br>";
        echo"<br>";
        
        $css->CrearBotonVerde("BtnAgregarItemMov", "Agregar Concepto");
        print("</td>");
        
    $css->CierraFilaTabla();
    
    
    
    $css->CerrarTabla();
    $css->CerrarForm();
    $sql="SELECT SUM(Debito) as Debito, SUM(Credito) as Credito FROM comprobantes_contabilidad_items WHERE idComprobante='$idComprobante'";
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
    $css->CrearInputText("TxtIdComprobanteContable","hidden",'',$idComprobante,'',"","","",300,30,0,0);
    $css->CrearBotonConfirmado2("BtnGuardarMovimiento", "Guardar y Cerrar Comprobante",$H,"");
    
    print("<br><br><br>");
    $css->CerrarForm();
    ////Se dibujan los items del movimiento
    $css->CrearSelect("CmbMostrarItems", "MuestraOculta('DivItems')");
        $css->CrearOptionSelect("SI", "Mostrar Movimientos", 0);
        $css->CrearOptionSelect("NO", "Ocultar Movimientos", 0);
    $css->CerrarSelect();
    $css->CrearDiv("DivItems", "", "center", 1, 1);
    $Vector["Tabla"]="comprobantes_contabilidad_items";
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
    $sql="SELECT * FROM comprobantes_contabilidad_items WHERE idComprobante='$idComprobante'";
    $consulta=$obVenta->Query($sql);
    
    while($DatosItems=$obVenta->FetchArray($consulta)){
        
        $css->FilaTabla(12);
        $css->ColTablaDel($myPage,"comprobantes_contabilidad_items","ID",$DatosItems['ID'],$idComprobante);
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
    $css->CerrarDiv();//Cerramos Div con los datos de los preitems
$css->CerrarDiv();//Cerramos contenedor Principal
$css->Footer();
$css->AgregaJS(); //Agregamos javascripts
//$css->AgregaSubir();    
////Fin HTML  
print("</body></html>");


?>