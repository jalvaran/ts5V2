<?php

session_start();
$idUser=$_SESSION['idUser'];
$TipoUser=$_SESSION['tipouser'];
//$myPage="titulos_comisiones.php";
include_once("../../modelo/php_conexion.php");
include_once("../css_construct.php");
include_once("../../modelo/PrintPos.php");	
$obPrint=new PrintPos($idUser);
$css =  new CssIni("id");
$obVenta=new ProcesoVenta($idUser);
 
function Kardex(){
    
    $idUser=$_SESSION['idUser'];
    $obVenta = new ProcesoVenta($idUser);
    
    $Consulta=$obVenta->ConsultarTabla("facturas_kardex", "WHERE Kardex='NO' and idUsuario='$idUser'");
    while ($DatosFactura=$obVenta->FetchArray($Consulta)){
        $obVenta->DescargueFacturaInventarios($DatosFactura["idFacturas"],"");
        
        $Datos["ID"]=$DatosFactura["idFacturas"];
        $Datos["CuentaDestino"]=$DatosFactura["CuentaDestino"];
        $obVenta->InsertarFacturaLibroDiario($Datos);
        print("Factura $DatosFactura[idFacturas] Contabilizada<br>");
        print("Factura $DatosFactura[idFacturas] descargada de inventarios<br>");
        $obVenta->BorraReg("facturas_kardex", "idFacturas", $DatosFactura["idFacturas"]);
    }
    
     
}

$fecha=date("Y-m-d");
$TotalVenta=$obVenta->normalizar($_REQUEST['TxtGranTotalH']);
$idCliente=$obVenta->normalizar($_REQUEST["TxtCliente"]);
$idColaborador=$obVenta->normalizar($_REQUEST["TxtidColaborador"]);
$idPreventa=$obVenta->normalizar($_REQUEST["CmbPreVentaAct"]);
$Efectivo=$obVenta->normalizar($_REQUEST["TxtPaga"]);
$Cheque=$obVenta->normalizar($_REQUEST["TxtPagaCheque"]);
$Tarjeta=$obVenta->normalizar($_REQUEST["TxtPagaTarjeta"]);
$idTarjeta=$obVenta->normalizar($_REQUEST["CmbIdTarjeta"]);
$OtrosPaga=$obVenta->normalizar($_REQUEST["TxtPagaOtros"]);
$Devuelta=$obVenta->normalizar($obVenta->normalizar($_REQUEST["TxtDevuelta"]));
$CuentaDestino=$obVenta->normalizar($_REQUEST["TxtCuentaDestino"]);
$TipoPago=$_REQUEST["TxtTipoPago"];
$Anticipo=$obVenta->normalizar($_REQUEST["TxtAnticipo"]);
$idAnticipo=$obVenta->normalizar($_REQUEST["CmbAnticipo"]);
$CmbPrint=$obVenta->normalizar($_REQUEST["CmbPrint"]);
$Observaciones=$obVenta->normalizar($_REQUEST["TxtObservacionesFactura"]);
$myPage=$obVenta->normalizar($_REQUEST["myPage"]);
if($idAnticipo>0){
    $Observaciones.=$Observaciones." Anticipo por $Anticipo con id: $idAnticipo Cruzado con esta Factura";
}

$DatosVentaRapida["PagaCheque"]=$Cheque;
$DatosVentaRapida["PagaTarjeta"]=$Tarjeta;
$DatosVentaRapida["idTarjeta"]=$idTarjeta;
$DatosVentaRapida["PagaOtros"]=$OtrosPaga;
$DatosCaja=$obVenta->DevuelveValores("cajas", "idUsuario", $idUser);
$DatosVentaRapida["CentroCostos"]=$DatosCaja["CentroCostos"];
$DatosVentaRapida["ResolucionDian"]=$DatosCaja["idResolucionDian"];
$DatosVentaRapida["Observaciones"]=$Observaciones;
if($TipoPago<>"Contado" AND $idCliente<=1){
    $css->CrearNotificacionRoja("Debe Selecccionar un cliente para poder vender a Credito", 20);
    exit();
}
if($TipoPago<>"Contado"){
    $Deuda=$obVenta->Sume("cartera", "Saldo", "WHERE idCliente='$idCliente'");
    $DatosClientes=$obVenta->DevuelveValores("clientes", "idClientes", $idCliente);
    $CupoDisponible=$DatosClientes["Cupo"]-$Deuda;
    $CapacidadCompra=$CupoDisponible-$TotalVenta;
    if($CapacidadCompra<=100){
        //print("<script>alert('El cliente $DatosClientes[RazonSocial] No cuenta con cupo Disponible para realizar esta compra a credito')</script>");
        $css->CrearNotificacionRoja("El Cliente $DatosClientes[RazonSocial] $DatosClientes[Num_Identificacion] cuenta con un cupo de $".number_format($DatosClientes["Cupo"]).", Debe $".number_format($Deuda).", Tiene un cupo disponible de: ".number_format($CupoDisponible).", No tiene cupo para el total de la Factura: $". number_format($TotalVenta), 18);
        exit();
    }
}
if($TipoPago<>"Contado"){
    $Efectivo=0;
    $DatosVentaRapida["PagaCheque"]=0;
    $DatosVentaRapida["PagaTarjeta"]=0;
    $DatosVentaRapida["idTarjeta"]=0;
    $DatosVentaRapida["PagaOtros"]=0;
}
//print("<script>alert('Entra 1')</script>");
$NumFactura=$obVenta->RegistreVentaRapida($idPreventa, $idCliente, $TipoPago, $Efectivo, $Devuelta, $CuentaDestino, $DatosVentaRapida);
$obVenta->FacturaKardex($NumFactura,$CuentaDestino, $idUser, "");
$sql="INSERT INTO `registro_autorizaciones_pos`( `Fecha`, `idProducto`, `TablaItem`, `ValorUnitario`, `ValorAcordado`, `Cantidad`, `PorcentajeIVA`, `Total`, `idUser`,`idFactura`) "
        . "SELECT  `Updated`,`ProductosVenta_idProductosVenta`,`TablaItem`,`ValorUnitario`,`ValorAcordado`,`Cantidad`,`PorcentajeIVA`,`TotalVenta`,`Autorizado`,'$NumFactura' "
        . "FROM preventa WHERE Autorizado>0 AND VestasActivas_idVestasActivas='$idPreventa'";
$obVenta->Query($sql);
//print("<script>alert('Entra 2')</script>");
$obVenta->BorraReg("preventa","VestasActivas_idVestasActivas",$idPreventa);
//$obVenta->ActualizaRegistro("vestasactivas","SaldoFavor", 0, "idVestasActivas", $idPreventa);
if($idAnticipo>0){
    $obVenta->CruceAnticipoFactura($fecha,$idAnticipo,$NumFactura,$CuentaDestino,"");
}
$DatosImpresora=$obVenta->DevuelveValores("config_puertos", "ID", 1);
if($DatosImpresora["Habilitado"]=="SI" AND $CmbPrint=='SI'){
    $obPrint->ImprimeFacturaPOS($NumFactura,$DatosImpresora["Puerto"],1);
    $DatosTikete=$obVenta->DevuelveValores("config_tiketes_promocion", "ID", 1);
    if($TotalVenta>=$DatosTikete["Tope"] AND $DatosTikete["Activo"]=="SI"){
        $VectorTiket["F"]=0;
        $Copias=1;
        if($DatosTikete["Multiple"]=="SI"){
            $Copias=floor($TotalVenta/$DatosTikete["Tope"]);
        }
        $obPrint->ImprimirTiketePromo($NumFactura,$DatosTikete["NombreTiket"],$DatosImpresora["Puerto"],$Copias,$VectorTiket);
    }
}
if($CmbPrint=='NO'){
    $ip=$_SERVER['REMOTE_ADDR'];
    $ipServer=$_SERVER['SERVER_ADDR'];
    if($ip==$ipServer){
        $obPrint->AbreCajon("");        
    }
    
}

if(!empty($idColaborador)){
    $obVenta->AgregueVentaColaborador($NumFactura,$idColaborador);
}
$RutaPrint="PDF_Factura.php?ImgPrintFactura=".$NumFactura;
$DatosFactura=$obVenta->DevuelveValores("facturas", "idFacturas", $NumFactura);
$css->CrearNotificacionNaranja("Por favor devolver: ". number_format($Devuelta),30);
$css->CrearNotificacionVerde("Factura Creada Correctamente <a href='$RutaPrint' target='_blank'>Imprimir Factura No. $DatosFactura[NumeroFactura]</a>",16);
if($TipoKardex=="Caja"){
    register_shutdown_function('Kardex');
}
?>