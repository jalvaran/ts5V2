<?php 
$myPage="PDF_Cartel_Publicidad.php";
include_once("../sesiones/php_control.php");
include_once("clases/ClasesPDFPublicidad.php");

if(isset($_REQUEST["BtnCrearPDF"])){
    $obVenta = new ProcesoVenta($idUser);
    $obTabla = new Cartel($db);
 
    $obTabla->PDF_CrearCartelPublicidad();    
}
?>