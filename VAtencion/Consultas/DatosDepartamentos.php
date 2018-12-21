<?php
$myPage="DatosDepartamentos.php";
include_once("../../modelo/php_conexion.php");
include_once("../../modelo/php_tablas.php");
include_once("../css_construct.php");
$css =  new CssIni("");
$obVenta = new ProcesoVenta(1);
$Valida=$obVenta->normalizar($_REQUEST['Valida']);

if($Valida==1){
    $idDepartamento=$obVenta->normalizar($_REQUEST['idSel']);
    $Consulta=" WHERE idDepartamento='$idDepartamento'";
    $pageConsulta="Consultas/DatosDepartamentos.php?Valida=2";
    
    $css->DibujeSelectBuscador("CmbSub1", $pageConsulta, "", "DivSub2", "onChange", 30, 100, "prod_sub1",$Consulta, "idSub1", "NombreSub1", "idDepartamento", "");
}
if($Valida==2){
    $idDepartamento=$obVenta->normalizar($_REQUEST['idSel']);
    $Consulta=" WHERE idDepartamento='$idDepartamento'";
    $pageConsulta="DatosSub1.php?Valida=2";
    
    $css->DibujeSelectBuscador("CmbSub1", $pageConsulta, "", "DivSub3", "onChange", 30, 100, "prod_sub1",$Consulta, "idSub1", "NombreSub1", "idDepartamento", "");
}

?>