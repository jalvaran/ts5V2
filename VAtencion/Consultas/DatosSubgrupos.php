<?php
$myPage="DatosSubgrupos.php";
include_once("../../modelo/php_conexion.php");
include_once("../../modelo/php_tablas.php");
include_once("../css_construct.php");
$css =  new CssIni("");
$obVenta = new ProcesoVenta(1);
$Valida=$obVenta->normalizar($_REQUEST['Valida']);
//SubGrupo 1
if($Valida==1){
    $idDepartamento=$obVenta->normalizar($_REQUEST['idSel']);
    $Consulta=" WHERE idDepartamento='$idDepartamento'";
    $Page="Consultas/DatosSubgrupos.php?Valida=2&idSel=";
    $FuncionJS="EnvieObjetoConsulta(`$Page`,`CmbSub1`,`DivSub2`,`99`);";
    print("Subgrupo 1: <br>");
    $css->CrearSelectTable("CmbSub1", "prod_sub1", $Consulta, "idSub1", "idSub1", "NombreSub1", "onChange", $FuncionJS, "", 0);
}
//SubGrupo 2
if($Valida==2){
    $idDepartamento=$obVenta->normalizar($_REQUEST['idSel']);
    $Consulta=" WHERE idSub1='$idDepartamento'";
    $Page="Consultas/DatosSubgrupos.php?Valida=3&idSel=";
    $FuncionJS="EnvieObjetoConsulta(`$Page`,`CmbSub2`,`DivSub3`,`99`);";
    print("Subgrupo 2: <br>");
    $css->CrearSelectTable("CmbSub2", "prod_sub2", $Consulta, "idSub2", "idSub2", "NombreSub2", "onChange", $FuncionJS, "", 0);
}

//SubGrupo 3
if($Valida==3){
    $idDepartamento=$obVenta->normalizar($_REQUEST['idSel']);
    $Consulta=" WHERE idSub2='$idDepartamento'";
    $Page="Consultas/DatosSubgrupos.php?Valida=4&idSel=";
    $FuncionJS="EnvieObjetoConsulta(`$Page`,`CmbSub3`,`DivSub4`,`99`);";
    print("Subgrupo 3: <br>");
    $css->CrearSelectTable("CmbSub3", "prod_sub3", $Consulta, "idSub3", "idSub3", "NombreSub3", "onChange", $FuncionJS, "", 0);
}

//SubGrupo 4
if($Valida==4){
    $idDepartamento=$obVenta->normalizar($_REQUEST['idSel']);
    $Consulta=" WHERE idSub3='$idDepartamento'";
    $Page="Consultas/DatosSubgrupos.php?Valida=5&idSel=";
    $FuncionJS="";
    print("Subgrupo 4: <br>");
    $css->CrearSelectTable("CmbSub4", "prod_sub4", $Consulta, "idSub4", "idSub4", "NombreSub4", "", $FuncionJS, "", 0);
}

//SubGrupo 5
if($Valida==5){
    
    $Consulta="";
    print("Subgrupo 5: <br>");
    $css->CrearSelectTable("CmbSub5", "prod_sub5", $Consulta, "idSub5", "idSub5", "NombreSub5", "", "", "", 0);
}

?>