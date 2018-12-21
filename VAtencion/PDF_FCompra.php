<?php 
$myPage="PDF_FCompra.php";
include_once("../sesiones/php_control.php");


if(isset($_REQUEST["ID"])){
    $obVenta = new ProcesoVenta($idUser);
    $obTabla = new Tabla($db);
    $idCompra=$obVenta->normalizar($_REQUEST["ID"]);
    $obTabla->PDF_FacturaCompra($idCompra, "");    
}
?>