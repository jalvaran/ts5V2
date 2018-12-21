<?php 
$myPage="PDF_Factura.php";
include_once("../sesiones/php_control.php");
include_once("../modelo/PrintPos.php");	
$obPrint=new PrintPos($idUser);

if(isset($_REQUEST["ImgPrintFactura"])){
    $obVenta = new ProcesoVenta($idUser);
    $obTabla = new Tabla($db);
    $idFactura=$obVenta->normalizar($_REQUEST["ImgPrintFactura"]);
    $TipoFactura="ORIGINAL";
    if(isset($_REQUEST["TipoFactura"])){
        $TipoFactura=$obVenta->normalizar($_REQUEST["TipoFactura"]);
    }
    //$html=$obTabla->HTML_Totales_Factura($idFactura, "", "");
    //print($html);
    $obTabla->PDF_Factura($idFactura,$TipoFactura, "");
    
    $DatosImpresora=$obVenta->DevuelveValores("config_puertos", "ID", 1);
    if($DatosImpresora["Habilitado"]=="SI"){
        $obPrint->ImprimeFacturaPOS($idFactura,$DatosImpresora["Puerto"],1,0);
    }
}
?>