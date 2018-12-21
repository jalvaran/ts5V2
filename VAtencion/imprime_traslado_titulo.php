<?php 
$myPage="imprime_traslado_titulo.php";
include_once("../sesiones/php_control.php");
$obVenta = new ProcesoVenta($idUser);
$obTabla = new Tabla($db);

if(isset($_REQUEST["TxtidComprobante"])){
    $idTrasladoTitulo=  $obVenta->normalizar($_REQUEST["TxtidComprobante"]);
    $obTabla->GenerePDFTrasladoTitulo($idTrasladoTitulo,"");
}

?>