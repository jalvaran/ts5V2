<?php 
$myPage="PDF_Informes_Ventas.php";
include_once("../sesiones/php_control.php");
if(isset($_REQUEST["BtnVerInformeAdmin"])){
    $obVenta = new ProcesoVenta($idUser);
    $obTabla = new Tabla($db);
    $FechaCorte = $obVenta->normalizar($_POST["TxtFechaCorte"]);
    $FechaIni = $obVenta->normalizar($_POST["TxtFechaIni"]);
    $FechaFinal = $obVenta->normalizar($_POST["TxtFechaFinal"]);
    $CentroCostos=$obVenta->normalizar($_POST["CmbCentroCostos"]);
    $EmpresaPro=$obVenta->normalizar($_POST["CmbEmpresaPro"]);
    $TipoReporte=$obVenta->normalizar($_POST["CmbTipoReporte"]);
    $obTabla->PDF_Informe_Ventas_Admin($TipoReporte,$FechaCorte,$FechaIni, $FechaFinal,$CentroCostos,$EmpresaPro,"");
}
?>