<?php 
$myPage="PDF_Informes_Fiscales.php";
include_once("../sesiones/php_control.php");
include_once("clases/ClasesInformes.php");
if(isset($_REQUEST["BtnReporteFiscalIVA"])){
    $obInformes = new Informes($db);      
    $FechaIni=$obVenta->normalizar($_REQUEST["TxtFechaIni"]);
    $FechaFin=$obVenta->normalizar($_REQUEST["TxtFechaFin"]);
    $Empresa=$obVenta->normalizar($_REQUEST["CmbEmpresa"]);
    $CentroCosto=$obVenta->normalizar($_REQUEST["CmbCentroCostos"]);
    $idSucursal=$obVenta->normalizar($_REQUEST["CmbSucursal"]);
    $obInformes->InformeFiscalIVA($FechaIni, $FechaFin, $Empresa, $CentroCosto, $idSucursal, "");
}
?>