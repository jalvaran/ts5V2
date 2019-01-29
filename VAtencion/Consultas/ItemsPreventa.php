<?php

session_start();
$idUser=$_SESSION['idUser'];
$TipoUser=$_SESSION['tipouser'];
//$myPage="titulos_comisiones.php";
include_once("../../modelo/php_conexion.php");
include_once("../css_construct.php");

$css =  new CssIni("id");
$obVenta = new ProcesoVenta($idUser);
$DatosCajas=$obVenta->DevuelveValores("cajas", "idUsuario", $idUser);

//$key=$obVenta->normalizar($_REQUEST['key']);
$myPage=$obVenta->normalizar($_REQUEST['myPage']);
$idPreventa=$obVenta->normalizar($_REQUEST['CmbPreVentaAct']);
$idAnticipo=0;
if(isset($_REQUEST['idAnticipo'])){
    $idAnticipo=$obVenta->normalizar($_REQUEST['idAnticipo']);
}

if(isset($_REQUEST['idClientes'])){
    $idClientes=$obVenta->normalizar($_REQUEST['idClientes']);
}else{
    $idClientes=1;
}

//Si se recibe un codigo de barras
if(isset($_REQUEST['key'])){
		
        $CodBar=$obVenta->normalizar($_REQUEST['key']);
        $obVenta=new ProcesoVenta($idUser);
        $TablaItem="productosventa";
        $Cantidad=1;
        $Salte=0;
        $idSistema=0;
        //$DatosCodigo=$obVenta->DevuelveValores('prod_codbarras',"CodigoBarras",$CodBar);
                
        if(isset($_REQUEST['Pesaje'])){
            $css->CrearNotificacionNaranja("Modo Bascula Activo", 16);
            $Cantidad=$obVenta->ObtenerPesoPCR_phpSerial("");
            $Cantidad=str_replace(' ', '', $Cantidad);            
        }
        $fecha=date("Y-m-d");
        $Comando="";
        
        $Comando=strtolower(substr($CodBar, 0,1));
        
        if($Comando=="s"){
            $CodBar= lcfirst($CodBar);   //Convierte el primer caracter en minusculas
            $idSistema=str_replace("s", '', $CodBar);
            $Datos=$obVenta->ConsultarTabla("prod_codbarras", " WHERE TablaOrigen='sistemas' and CodigoBarras='$idSistema'");
            $DatosCodigoBarras=$obVenta->FetchArray($Datos);
            if($DatosCodigoBarras["ProductosVenta_idProductosVenta"]>0){
                $idSistema=$DatosCodigoBarras["ProductosVenta_idProductosVenta"];
            }else{
                $idSistema=ltrim($idSistema, "0");
            }
            
            $DatosSistema=$obVenta->DevuelveValores("sistemas", "ID", $idSistema);
            if($DatosSistema["ID"]>0){
                $obVenta->AgregueSistemaPreventa($idPreventa,$idSistema,$Cantidad,"");
                goto sale;
            }
            
        }
        if($Cantidad>0){
            $sql="SELECT ProductosVenta_idProductosVenta as idProductosVenta FROM prod_codbarras WHERE CodigoBarras='$CodBar' AND TablaOrigen='productosventa'";
            $consulta=$obVenta->Query($sql);
            $DatosProducto=$obVenta->FetchArray($consulta);
            if($DatosProducto["idProductosVenta"]==''){
                $idProducto=ltrim($CodBar, "0");
                $sql="SELECT idProductosVenta FROM productosventa WHERE idProductosVenta='$CodBar'";
                $consulta=$obVenta->Query($sql);
                $DatosProducto=$obVenta->FetchArray($consulta);
            }
            
            if($DatosProducto["idProductosVenta"]){
                $Error=$obVenta->AgregaPreventa($fecha,$Cantidad,$idPreventa,$DatosProducto['idProductosVenta'],$TablaItem);
                if($Error=="E1"){
                    $css->CrearNotificacionRoja("Este producto no tiene precio de venta, no lo entregue", 16);
                }
            }else{
                $css->CrearNotificacionRoja("Este producto no esta en la base de datos, no lo entregue", 16);
            }
            
        }else{
            $css->CrearNotificacionRoja("No se pueden agregar Cantidades en Cero", 16);
        }
}

sale:

$css->DivGrid("DivTotales", "", "left", 1, 1, 1, 90, 40,5,"transparent");
//$css->CrearNotificacionAzul("Id $Comando", 16);
    //Dibujo cuadro de totales
$DatosPersonalesCliente=$obVenta->DevuelveValores("clientes", "idClientes", $idClientes);
if($idClientes==1){
    $css->CrearNotificacionVerde("Venta para $DatosPersonalesCliente[RazonSocial]", 14);
}else{
    $css->CrearNotificacionRoja("Venta para $DatosPersonalesCliente[RazonSocial]", 14);
}
$css->CrearForm2("FrmGuarda",$myPage,"post","_self");
    $Subtotal=$obVenta->SumeColumna("preventa","Subtotal", "VestasActivas_idVestasActivas",$idPreventa);
    $IVA=$obVenta->SumeColumna("preventa","Impuestos", "VestasActivas_idVestasActivas",$idPreventa);
    $DatosPreventa=$obVenta->DevuelveValores("vestasactivas","idVestasActivas", $idPreventa);
    $SaldoFavor=$DatosPreventa["SaldoFavor"];
    $sql="SELECT SUM(Cantidad) as NumItems FROM preventa WHERE VestasActivas_idVestasActivas='$idPreventa'";
    $consulta=$obVenta->Query($sql);
    $SumaItemsPreventa=$obVenta->FetchArray($consulta);
    $sql="SELECT Devuelve FROM facturas WHERE Usuarios_idUsuarios='$idUser' ORDER BY idFacturas DESC LIMIT 1";
    $consulta=$obVenta->Query($sql);
    $DatosDevuelta=$obVenta->FetchArray($consulta);
    if($SaldoFavor>0)
            $SaldoFavor=$SaldoFavor;
    else
            $SaldoFavor=0;

    $Total=$Subtotal+$IVA;
    $GranTotal=round($Total-$SaldoFavor);
    
    $css->CrearInputText("TxtCliente","hidden","",$idClientes,"","","","",150,30,0,0);
    $css->CrearInputText("CmbPreVentaAct","hidden","",$idPreventa,"","","","",150,30,0,0);
    $css->CrearInputText("TxtSaldoFavor","hidden","",$SaldoFavor,"","","","",150,30,0,0);
    $css->CrearInputText("TxtTotalH","hidden","",$Total,"","","","",150,30,0,0);
    $css->CrearInputText("TxtCuentaDestino","hidden","",$DatosCajas["CuentaPUCEfectivo"],"","","","",150,30,0,0);
    $css->CrearInputText("TxtGranTotalH","hidden","",$GranTotal,"","","","",150,30,0,0);
    $css->CrearInputText("CmbAnticipo","hidden","",$idAnticipo,"","","","",150,30,0,0);
    $css->CrearTabla();
    $css->FilaTabla(16);
        $css->ColTabla("<strong>Ultima Devuelta: </strong>", 1);
        $css->ColTabla("<strong>Productos: </strong>", 1);
        $css->ColTabla("<strong>Efectivo: </strong>", 1);
    $css->CierraFilaTabla();
    $css->FilaTabla(20);
        $css->ColTabla("<strong>$ ".number_format($DatosDevuelta["Devuelve"])."<strong>", 1);
        $css->ColTabla("<strong>".number_format($SumaItemsPreventa["NumItems"])."<strong>", 1); 
        print("<td>");
        $Visible=0;
        $Anticipo=0;
        if($idAnticipo>0){
            $Visible=1;
            $DatosAnticipos=$obVenta->DevuelveValores("comprobantes_ingreso", "ID", $idAnticipo);
            $Anticipo=$DatosAnticipos["Valor"];
        }
        $css->CrearDiv("DivAnticipo", "", "center", $Visible, 1);
            
            $css->CrearInputNumber("TxtAnticipo","number","Anticipos:<br>",$Anticipo,"Efectivo","","onkeyup","CalculeDevuelta()",150,30,1,1,"","",1);
        
        $css->CerrarDiv();
        $css->CrearInputNumber("TxtPaga","number","",round($Total),"Efectivo","","onkeyup","CalculeDevuelta()",150,30,0,1,"","",1);
        print("</td>");
    $css->CierraFilaTabla();
    $css->FilaTabla(14);
        $css->ColTabla("<strong>SUBTOTAL: </strong>", 1);
        $css->ColTabla("<strong>IMPUESTOS: </strong>", 1);
        $css->ColTabla("<strong>TOTAL : </strong>", 1);
         
    $css->CierraFilaTabla();
    $css->FilaTabla(14);
        $css->ColTabla("<strong> $".number_format($Subtotal)."<strong>", 1);
        $css->ColTabla("<strong> $".number_format($IVA)."<strong>", 1); 
        $css->ColTabla("<strong><H3> $".number_format($Total)."<H3><strong>", 1); 
    $css->CierraFilaTabla();
    
    $Visible=0;
    $css->FilaTabla(14);
        
        print("<td>");
        print("<strong>Formas de Pago: </strong><image name='imgHidde' id='imgHidde' src='../images/hidde.png' onclick=MuestraOculta('DivOtrasOpcionesPago');>");
        
        $css->CrearDiv("DivOtrasOpcionesPago", "", "left", $Visible, 1);
                print("<br>");
                $css->CrearInputNumber("TxtPagaTarjeta","number","Tarjeta: <br>",0,"Tarjeta","","onkeyup","CalculeDevuelta()",150,30,0,0,0,"",1);
                
                $VectorSelect["Nombre"]="CmbIdTarjeta";
                $VectorSelect["Evento"]="";
                $VectorSelect["Funcion"]="";
                $VectorSelect["Required"]=0;
                $css->CrearSelect2($VectorSelect);

                    $sql="SELECT * FROM tarjetas_forma_pago";
                    $Consulta=$obVenta->Query($sql);
                    //$css->CrearOptionSelect("", "Seleccione una tarjeta" , 0);
                    while($DatosCuenta=$obVenta->FetchArray($Consulta)){

                        $css->CrearOptionSelect("$DatosCuenta[ID]", "$DatosCuenta[Tipo] / $DatosCuenta[Nombre]" , 0);
                       }
                $css->CerrarSelect();
                print("<br>");

                $css->CrearInputNumber("TxtPagaCheque","number","Cheque: <br>",0,"Cheque","","onkeyup","CalculeDevuelta()",150,30,0,0,0,"",1);
                print("<br>");
                $css->CrearInputNumber("TxtPagaOtros","number","Otros: <br>",0,"Otros","","onkeyup","CalculeDevuelta()",150,30,0,0,0,"",1);
            $css->CerrarDiv();
        print("</td>");
        print("<td>");
        print("<strong>+ Opciones: </strong> <image name='imgHidde' id='imgHidde' src='../images/hidde.png' onclick=MuestraOculta('DivOtrasOpciones');>");
        $css->CrearDiv("DivOtrasOpciones", "", "center", $Visible, 1);
                $css->CrearSelect("CmbPrint", "");
                $sel=0;
                    if($PrintAutomatico=="SI"){
                        $sel=1;
                    }
                    $css->CrearOptionSelect("SI", "Imprimir", $sel);
                    $sel=0;
                    if($PrintAutomatico=="NO"){
                        $sel=1;
                    }
                    $css->CrearOptionSelect("NO", "NO Imprimir", $sel);
                $css->CerrarSelect();
                $VarSelect["Ancho"]="200";
                $VarSelect["PlaceHolder"]="Colaborador";
                $VarSelect["Title"]="";
                $css->CrearSelectChosen("TxtidColaborador", $VarSelect);

                    $sql="SELECT Nombre, Identificacion FROM colaboradores";
                    $Consulta=$obVenta->Query($sql);
                    $css->CrearOptionSelect("", "Colaborador: " , 0);
                    while($DatosColaborador=$obVenta->FetchArray($Consulta)){

                           $css->CrearOptionSelect("$DatosColaborador[Identificacion]", " $DatosColaborador[Nombre] $DatosColaborador[Identificacion]" , 0);
                       }
                $css->CerrarSelect();
                $VarSelect["Ancho"]="200";
                $VarSelect["PlaceHolder"]="Forma de Pago";
                $VarSelect["Title"]="";
                $css->CrearSelectChosen("TxtTipoPago", $VarSelect);

                    $sql="SELECT * FROM repuestas_forma_pago";
                    $Consulta=$obVenta->Query($sql);
                    while($DatosTipoPago=$obVenta->FetchArray($Consulta)){

                           $css->CrearOptionSelect("$DatosTipoPago[DiasCartera]", " $DatosTipoPago[Etiqueta]" , 0);
                       }
                $css->CerrarSelect();

                print("<br>");
                $css->CrearTextArea("TxtObservacionesFactura","","","Observaciones Factura","black","","",200,60,0,0);

                $css->CerrarDiv();
        print("</td>");
        print("<td>");
            $css->CrearInputText("TxtDevuelta","text","Devuelta : ",$Anticipo,"Devuelta","black","","",150,50,1,0,$ToolTip='Esta es la Devuelta');
            
	print("</td>");
    $css->CierraFilaTabla(); 
        $css->FilaTabla(14);
        
        print("<td colspan='3' style='text-align:center'>");
            $Nombre="BtnGuardar";
            $Page="Consultas/PreventaProcess.php?myPage=$myPage&CmbPreVentaAct=$idPreventa&TxtCliente=$idClientes&Carry=";
            $FuncionJS="EnvieObjetoConsulta(`$Page`,`$Nombre`,`DivItemsPreventa`,`11`);return false ;";
            $css->CrearBotonEvento($Nombre,"Guardar",1,"onclick",$FuncionJS,"naranja","");
	print("</td>");
        $css->CierraFilaTabla(); 
        
    $css->CerrarTabla();
    $css->CerrarForm();
    
$css->CerrarDiv();

$css->DivGrid("DivItems", "", "center", 1, 1, 3, 90, 58,5,"transparent");

/*
 * DIV con las autorizaciones
 */
//Si se recibe una autorizacion

if(isset($_REQUEST['TxtAutorizacion'])){
    	
    $Clave=md5($obVenta->normalizar($_REQUEST['TxtAutorizacion']));
    $sql="SELECT Identificacion FROM usuarios WHERE Password='$Clave' AND (Role='ADMINISTRADOR' or Role='SUPERVISOR') LIMIT 1";
    $Datos=$obVenta->Query($sql);
    $DatosAutorizacion=$obVenta->FetchArray($Datos);
    
    $NoAutorizado="";
    if($DatosAutorizacion["Identificacion"]<>''){
        
        $obVenta->ActualizaRegistro("preventa", "Autorizado", $DatosAutorizacion["Identificacion"], "VestasActivas_idVestasActivas", $idPreventa);
        
        $css->CrearBotonOcultaDiv("Opciones: ", "DivDescuentos", 20, 20,0, "");
        $css->CrearDiv("DivDescuentos", "", "center", 0, 1);
        $css->CrearTabla();
        $css->FilaTabla(16);
        $css->ColTabla("<strong>DESCUENTO GENERAL POR PORCENTAJE</strong>", 1);
        $css->ColTabla("<strong>DESCUENTO GENERAL AL POR MAYOR</strong>", 1);
        $css->ColTabla("<strong>LISTAS DE PRECIOS</strong>", 1);
        $css->ColTabla("<strong>DESCUENTO GENERAL A COSTO</strong>", 1);
        
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
        print("<td style='text-align:center;'>");
        $css->CrearForm2("FrmAutorizacionDescuento", $myPage, "post", "_self");
        $css->CrearInputText("TxtidPreventa", "hidden", "", $idPreventa, "", "", "", "", "", "", "", "");
        $css->CrearInputNumber("TxtDescuento", "number", "", "", "Descuento", "", "", "", 100,30, 0, 1, 1, 30, 1);
        print("<br>");
        $css->CrearBotonConfirmado("BtnDescuentoGeneral", "Descuento %");

        $css->CerrarForm();
        print("</td>");
        
        print("<td style='text-align:center;'>");
        $css->CrearForm2("FrmAutorizacionMayor", $myPage, "post", "_self");
        $css->CrearInputText("TxtidPreventa", "hidden", "", $idPreventa, "", "", "", "", "", "", "", "");
        
        $css->CrearBotonConfirmado("BtnDescuentoMayor", "Descuento al por Mayor");

        $css->CerrarForm();
        print("</td>");
        print("<td>");
            $css->CrearForm2("FrmListados", $myPage, "post", "_self");
            $css->CrearInputText("TxtidPreventa", "hidden", "", $idPreventa, "", "", "", "", "", "", "", "");
            $css->CrearSelectTable("CmbListaPrecio", "productos_lista_precios", "", "ID", "Nombre", "", "", "", "", 1);
            $css->CrearBotonConfirmado("BtnListados", "Aplicar");
            $css->CerrarForm();
        print("</td>");
        print("<td style='text-align:center;'>");
        $css->CrearForm2("FrmAutorizacionDescuento", $myPage, "post", "_self");
        $css->CrearInputText("TxtidPreventa", "hidden", "", $idPreventa, "", "", "", "", "", "", "", "");
        
        $css->CrearBotonConfirmado("BtnDescuentoCosto", "Descuento A Precio Costo");

        $css->CerrarForm();
        print("</td>");
        

        $css->CierraFilaTabla();
        $css->CerrarTabla();
        $css->CerrarDiv();
        
    }else{
        $css->CrearNotificacionRoja("Clave incorrecta o no autorizada", 16);
    }	
}

/*
 * Empieza a dibujar items
 */

$sql="SELECT * FROM preventa WHERE VestasActivas_idVestasActivas='$idPreventa' ORDER BY Updated DESC";
    $pa=$obVenta->Query($sql);
    if($obVenta->NumRows($pa)){	
        
        $css->CrearTabla();
        $css->CrearNotificacionAzul("Items en Esta Preventa",16);
            $css->FilaTabla(14);
                $css->ColTabla("<strong>Referencia</strong>", 1);
                $css->ColTabla("<strong>Nombre</strong>", 1);
                $css->ColTabla("<strong>Cantidad</strong>", 1);
                $css->ColTabla("<strong>ValorUnitario</strong>", 1);
                $css->ColTabla("<strong>Subtotal</strong>", 1);
                $css->ColTabla("<strong>Borrar</strong>", 1);
            $css->CierraFilaTabla();
        
        
    while($DatosPreventa=$obVenta->FetchArray($pa)){
            
            $css->FilaTabla(16);
            $idTabla='idProductosVenta';
            if($DatosPreventa["TablaItem"]=='sistemas'){
                $idTabla='ID';
            }
            $DatosProducto=$obVenta->DevuelveValores($DatosPreventa["TablaItem"],$idTabla,$DatosPreventa["ProductosVenta_idProductosVenta"]);
            
            if($DatosPreventa["TablaItem"]=='sistemas'){
                $Ref=$DatosPreventa["ProductosVenta_idProductosVenta"];
            } else {
                $Ref=$DatosProducto["Referencia"];
            }
            $css->ColTabla($Ref, 1);
            $css->ColTabla("$DatosProducto[Nombre]", 1);       
            
            $Autorizado=!$DatosPreventa["Autorizado"];
            $NameTxt="TxtEditar$DatosPreventa[idPrecotizacion]";
            
            if($Autorizado){
                $Evento="ConfirmarFormNegativo(`$NameTxt`);return false;";
                $VectorDatosExtra["JS"]="onclick='ConfirmarFormPass(); return false;'";
            }else{
                $Evento="";
                $VectorDatosExtra["JS"]="";
            }
            print("<td>");
                $css->DivColTablaFormInputText("FrmEdit$DatosPreventa[idPrecotizacion]",$myPage,"post","_self",$NameTxt,"Number",$DatosPreventa['Cantidad'],"","","","onClick",$Evento,"70","30","","","TxtPrecotizacion",$DatosPreventa['idPrecotizacion'],$idPreventa);
            print("</td>");
            $PrecioAcordado=round($DatosPreventa['ValorAcordado']);
            print("<td>");
              $css->DivColTablaFormEditarPrecio("FrmEditPrecio$DatosPreventa[idPrecotizacion]",$myPage,"post","_self","TxtEditarPrecio$DatosPreventa[idPrecotizacion]","Number",$PrecioAcordado,"","","","","","","150","30",$Autorizado,0,"TxtPrecotizacion",$DatosPreventa['idPrecotizacion'],$idPreventa,"TxtPrecioMayor",$DatosPreventa["PrecioMayorista"]); 
            print("</td>");
            $css->ColTabla("<strong>".number_format($DatosPreventa['TotalVenta'])."</strong>", 1);    
            
            print("<td>");
            $css->DivColTable("center",0,1,"black","100%","");
            $VectorDatosExtra["ID"]="LinkDel$DatosPreventa[idPrecotizacion]";
            
            $link="$myPage?del=$DatosPreventa[idPrecotizacion]&TxtTabla=preventa&TxtIdTabla=idPrecotizacion&TxtIdPre=$idPreventa";
            $css->CrearLinkID($link,"_self","X",$VectorDatosExtra);
           print("</td>");
            
           
    }
    $css->CerrarTabla();
    $css->CerrarDiv();//Cierro la tabla
    }else{
      $css->CrearNotificacionRoja("No hay items en esta preventa",20);  
    }
   $css->CerrarDiv();
$css->AgregaJS(); //Agregamos javascripts
?>