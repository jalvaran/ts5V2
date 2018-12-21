<?php

session_start();
$idUser=$_SESSION['idUser'];
$TipoUser=$_SESSION['tipouser'];
//$myPage="titulos_comisiones.php";
include_once("../../modelo/php_conexion.php");
include_once("../css_construct.php");

$css =  new CssIni("id");
$obVenta = new ProcesoVenta($idUser);
//$key=$obVenta->normalizar($_REQUEST['key']);
$myPage=$obVenta->normalizar($_REQUEST['myPage']);
$idPreventa=$obVenta->normalizar($_REQUEST['CmbPreVentaAct']);
$idClientes=1;
//////Si recibo un cliente
if(isset($_REQUEST['idClientes'])){

    $idClientes=$_REQUEST['idClientes'];
}


//Si se recibe un codigo de barras
if(isset($_REQUEST['key'])){
		
        $CodBar=$obVenta->normalizar($_REQUEST['key']);
        $obVenta=new ProcesoVenta($idUser);
        $TablaItem="productosventa";
        $Cantidad=1;
        //$DatosCodigo=$obVenta->DevuelveValores('prod_codbarras',"CodigoBarras",$CodBar);
                
        if(isset($_REQUEST['Pesaje'])){
            $css->CrearNotificacionNaranja("Modo Bascula Activo", 16);
            $Cantidad=$obVenta->ObtenerPesoPCR_phpSerial("");
            $Cantidad=str_replace(' ', '', $Cantidad);            
        }
        $fecha=date("Y-m-d");
        if($Cantidad>0){
            $sql="SELECT ProductosVenta_idProductosVenta as idProductosVenta FROM prod_codbarras WHERE CodigoBarras='$CodBar'";
            $consulta=$obVenta->Query($sql);
            $DatosProducto=$obVenta->FetchArray($consulta);
            if($DatosProducto["idProductosVenta"]==''){
                $idProducto=ltrim($CodBar, "0");
                $sql="SELECT idProductosVenta FROM productosventa WHERE idProductosVenta='$CodBar'";
                $consulta=$obVenta->Query($sql);
                $DatosProducto=$obVenta->FetchArray($consulta);
            }
            /*
            $sql="SELECT pv.`idProductosVenta` FROM `productosventa` pv "
                . " INNER JOIN prod_codbarras k ON pv.`idProductosVenta`=k.ProductosVenta_idProductosVenta "
                . " WHERE pv.`idProductosVenta`='$CodBar' "
                . " OR pv.`CodigoBarras`='$CodBar' "
                . " OR k.`CodigoBarras`='$CodBar' LIMIT 1 ";
            
            $sql="SELECT pv.`idProductosVenta` FROM `productosventa` pv "
                . " INNER JOIN prod_codbarras k ON pv.`idProductosVenta`=k.ProductosVenta_idProductosVenta "
                . " WHERE k.`CodigoBarras`='$CodBar' "
                . " OR pv.`CodigoBarras`='$CodBar' "
                . " OR pv.`idProductosVenta`='$CodBar' ORDER BY pv.`idProductosVenta` DESC LIMIT 1";
            $Consulta=$obVenta->Query($sql);
            $DatosProducto=$obVenta->FetchArray($Consulta);
             * 
             */
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

//Si se recibe una autorizacion

if(isset($_REQUEST['TxtAutorizacion'])){
		
    $Clave=$obVenta->normalizar($_REQUEST['TxtAutorizacion']);
    $sql="SELECT Identificacion FROM usuarios WHERE Password='$Clave' AND (Role='ADMINISTRADOR' or Role='SUPERVISOR') LIMIT 1";
    $Datos=$obVenta->Query($sql);
    $DatosAutorizacion=$obVenta->FetchArray($Datos);
    
    $NoAutorizado="";
    if($DatosAutorizacion["Identificacion"]<>''){
        
        $obVenta->ActualizaRegistro("preventa", "Autorizado", $DatosAutorizacion["Identificacion"], "VestasActivas_idVestasActivas", $idPreventa);
    }else{
        $css->CrearNotificacionRoja("Clave incorrecta o no autorizada", 16);
    }	
}

//Dibujo cuadro de totales
$css->CrearTabla();
$css->FilaTabla(16);
$DatosPersonalesCliente=$obVenta->DevuelveValores("clientes", "idClientes", $idClientes);
print("<td>");
$css->CrearDiv("DivTotales", "", "center", 1, 1);
if($idClientes==1){
    $css->CrearNotificacionVerde("Venta para $DatosPersonalesCliente[RazonSocial]", 14);
}else{
    $css->CrearNotificacionRoja("Venta para $DatosPersonalesCliente[RazonSocial]", 14);
}
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
    $css->CrearForm2("FrmGuarda",$myPage,"post","_self");
    $css->CrearInputText("TxtCliente","hidden","",$idClientes,"","","","",150,30,0,0);
    $css->CrearInputText("CmbPreVentaAct","hidden","",$idPreventa,"","","","",150,30,0,0);
    $css->CrearInputText("TxtSaldoFavor","hidden","",$SaldoFavor,"","","","",150,30,0,0);
    $css->CrearInputText("TxtTotalH","hidden","",$Total,"","","","",150,30,0,0);
    $css->CrearInputText("TxtCuentaDestino","hidden","",11051001,"","","","",150,30,0,0);
    $css->CrearInputText("TxtGranTotalH","hidden","",$GranTotal,"","","","",150,30,0,0);
    $css->DivTable(); 
        $css->DivRowTable();
            $css->DivColTable("left",0,1,"black","150%","");
                print("<strong>Ultima Devuelta : </strong>");
            $css->CerrarDiv();
            $css->DivColTable("right",0,1,"black","150%","");
                print("<strong>".number_format($DatosDevuelta["Devuelve"])."<strong>");
            $css->CerrarDiv();
        $css->CerrarDiv();//Cierro Fila
       
        $css->DivRowTable();
            $css->DivColTable("left",0,1,"black","120%","");
                print("<strong>Cantidad de Productos : </strong>");
            $css->CerrarDiv();
            $css->DivColTable("right",0,1,"black","120%","");
                print("<strong>".number_format($SumaItemsPreventa["NumItems"])."</strong> <br> ");
            $css->CerrarDiv();
        $css->CerrarDiv();//Cierro Fila
    $css->CerrarDiv();//Cierro tabla
    print("<br>");
    $css->DivTable(); 
        
        $css->DivRowTable();
            $css->DivColTable("left",0,1,"black","100%","");
                print("<strong>SUBTOTAL : </strong>");
            $css->CerrarDiv();
            $css->DivColTable("right",0,1,"black","100%","");
                print("<strong>".number_format($Subtotal)."</strong> ");
            $css->CerrarDiv();
        $css->CerrarDiv();//Cierro Fila
        
        $css->DivRowTable();
            $css->DivColTable("left",0,1,"black","100%","");
                print("<strong>IMPUESTOS : </strong>");
            $css->CerrarDiv();
            $css->DivColTable("right",0,1,"black","100%","");
                print("<strong>".number_format($IVA)."</strong> ");
            $css->CerrarDiv();
        $css->CerrarDiv();//Cierro Fila
        $css->DivRowTable();
            
            $css->DivColTable("center",0,1,"gray","10%","");
                print("_");
            $css->CerrarDiv();
        $css->CerrarDiv();//Cierro Fila
        $css->DivRowTable();
            $css->DivColTable("left",0,1,"blue","200%","");
                print("<strong>TOTAL : </strong>");
            $css->CerrarDiv();
            $css->DivColTable("right",0,1,"blue","180%","");
                print("<strong>".number_format($Total)."</strong>");
            $css->CerrarDiv();
            
        $css->CerrarDiv();//Cierro Fila
        $css->DivRowTable();
            
            $css->DivColTable("center",0,1,"gray","100%","");
                print("__");
            $css->CerrarDiv();
        $css->CerrarDiv();//Cierro Fila
        $Visible=0;
        $css->DivRowTable();
            
            $css->DivColTable("center",0,1,"black","100%","");
                $css->CrearInputNumber("TxtPaga","number","Efectivo:",round($Total),"Efectivo","","onkeyup","CalculeDevuelta()",150,30,0,1,"","",1);
                print("<strong>+</strong><image name='imgHidde' id='imgHidde' src='../images/hidde.png' onclick=MuestraOculta('DivOtrasOpcionesPago');>");
                $css->CrearDiv("DivOtrasOpcionesPago", "", "left", $Visible, 1);
                //print("<br>");
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
            $css->CerrarDiv();
        $css->CerrarDiv();//Cierro Fila
        
        $css->DivRowTable();            
            $css->DivColTable("left",0,1,"black","100%","");
                print("<strong>+ Opciones </strong><image name='imgHidde' id='imgHidde' src='../images/hidde.png' onclick=MuestraOculta('DivOtrasOpciones');>");
                $css->CrearDiv("DivOtrasOpciones", "", "center", $Visible, 1);

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

                /*
                $VarSelect["Ancho"]="200";
                $VarSelect["PlaceHolder"]="Busque un Cliente";
                $VarSelect["Title"]="";
                $css->CrearSelectChosen("TxtCliente", $VarSelect);

                    $sql="SELECT * FROM clientes";
                    $Consulta=$obVenta->Query($sql);
                    while($DatosCliente=$obVenta->FetchArray($Consulta)){

                           $css->CrearOptionSelect("$DatosCliente[idClientes]", "$DatosCliente[RazonSocial] / CC $DatosCliente[Num_Identificacion]" , 0);
                       }

                $css->CerrarSelect();
                */
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
            $css->CerrarDiv();
        $css->CerrarDiv();//Cierro Fila
        
        $css->DivRowTable();
            
            $css->DivColTablaInputText("TxtDevuelta","text",0,"<strong>Devolver: <strong>","Devuelta","","","",150,50,1,0);
            
        $css->CerrarDiv();//Cierro Fila
        
        $css->DivRowTable();
            
            
            $css->DivColTable("left",0,1,"blue","180%","");
                $VectorBoton["Fut"]=0;
                $css->CrearBotonEvento("BtnGuardar","Guardar",1,"onclick","EnviaFormVentasRapidas()","naranja",$VectorBoton);
            $css->CerrarDiv();
        $css->CerrarDiv();//Cierro Fila
        
    $css->CerrarDiv();//Cierro tabla
    
    $css->CerrarForm();

///

$css->CerrarDiv();
print("</td>");
print("<td>");

$sql="SELECT * FROM preventa WHERE VestasActivas_idVestasActivas='$idPreventa' ORDER BY Updated DESC";
    $pa=$obVenta->Query($sql);
    if($obVenta->NumRows($pa)){	
        //$css->CrearNotificacionVerde("Items en Esta Preventa",16);
        $css->DivTable();
            $css->DivRowTable();
                $css->DivColTable("center",0,1,"black","100%","");
                    print("<strong>Referencia</strong>");
                $css->CerrarDiv();
                
                $css->DivColTable("center",0,1,"black","100%","");
                    print("<strong>Nombre</strong>");
                $css->CerrarDiv();
                $css->DivColTable("center",0,1,"black","100%","");
                    print("<strong>Cantidad</strong>");
                $css->CerrarDiv();
                $css->DivColTable("center",0,1,"black","100%","");
                    print("<strong>ValorUnitario</strong>");
                $css->CerrarDiv();
                $css->DivColTable("center",0,1,"black","100%","");
                    print("<strong>Subtotal</strong>");
                $css->CerrarDiv();
                $css->DivColTable("center",0,1,"black","100%","");
                    print("<strong>Borrar</strong>");
                $css->CerrarDiv();
            $css->CerrarDiv();//Cierro Fila
            

    while($DatosPreventa=$obVenta->FetchArray($pa)){
            $css->DivRowTable();
            $DatosProducto=$obVenta->DevuelveValores($DatosPreventa["TablaItem"],"idProductosVenta",$DatosPreventa["ProductosVenta_idProductosVenta"]);
            $css->DivColTable("left",0,1,"black","100%","");
                    print("$DatosProducto[Referencia]");
            $css->CerrarDiv();
            $css->DivColTable("left",0,1,"black","100%","");
                    print("$DatosProducto[Nombre]");
            $css->CerrarDiv();
            
            $Autorizado=!$DatosPreventa["Autorizado"];
            $NameTxt="TxtEditar$DatosPreventa[idPrecotizacion]";
            
            if($Autorizado){
                $Evento="ConfirmarFormNegativo(`$NameTxt`);return false;";
                $VectorDatosExtra["JS"]="onclick='ConfirmarFormPass(); return false;'";
            }else{
                $Evento="";
                $VectorDatosExtra["JS"]="";
            }
            $css->DivColTablaFormInputText("FrmEdit$DatosPreventa[idPrecotizacion]",$myPage,"post","_self",$NameTxt,"Number",$DatosPreventa['Cantidad'],"","","","onClick",$Evento,"150","30","","","TxtPrecotizacion",$DatosPreventa['idPrecotizacion'],$idPreventa);
            $PrecioAcordado=round($DatosPreventa['ValorAcordado']);
            
            $css->DivColTablaFormEditarPrecio("FrmEditPrecio$DatosPreventa[idPrecotizacion]",$myPage,"post","_self","TxtEditarPrecio$DatosPreventa[idPrecotizacion]","Number",$PrecioAcordado,"","","","","","","150","30",$Autorizado,0,"TxtPrecotizacion",$DatosPreventa['idPrecotizacion'],$idPreventa,"TxtPrecioMayor",$DatosProducto["PrecioMayorista"]);
            $css->DivColTable("right",0,1,"black","100%","");
                    print("<strong>".number_format($DatosPreventa['TotalVenta'])."</strong>");
            $css->CerrarDiv();
            
            $css->DivColTable("center",0,1,"black","100%","");
            $VectorDatosExtra["ID"]="LinkDel$DatosPreventa[idPrecotizacion]";
            
            $link="$myPage?del=$DatosPreventa[idPrecotizacion]&TxtTabla=preventa&TxtIdTabla=idPrecotizacion&TxtIdPre=$idPreventa";
            $css->CrearLinkID($link,"_self","X",$VectorDatosExtra);
            $css->CerrarDiv();
            
            $css->CerrarDiv();//Cierro la tabla
    }
    $css->CerrarDiv();//Cierro la tabla
    }else{
      $css->CrearNotificacionRoja("No hay items en esta preventa",20);  
    }
$css->AgregaJS(); //Agregamos javascripts
?>