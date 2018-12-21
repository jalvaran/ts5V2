<?php 
$myPage="ImprimirPDFCotizacion.php";
include_once("../sesiones/php_control.php");
include_once("../modelo/PrintPos.php");	
$obPrint=new PrintPos($idUser);

if(isset($_REQUEST["ImgPrintCoti"])){
    $obVenta = new ProcesoVenta($idUser);
    $obTabla = new Tabla($db);
    $idCotizacion=$obVenta->normalizar($_REQUEST["ImgPrintCoti"]);
    $obTabla->PDF_Cotizacion($idCotizacion, "");
    
    $DatosImpresora=$obVenta->DevuelveValores("config_puertos", "ID", 1);
    if($DatosImpresora["Habilitado"]=="SI"){
        $obPrint->ImprimeCotizacionPOS($idCotizacion,$DatosImpresora["Puerto"],1);
    }
}
?>