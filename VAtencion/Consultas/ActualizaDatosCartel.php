<?php
include_once("../../modelo/php_conexion.php");
include_once("../css_construct.php");
$css =  new CssIni("");
$obVenta = new ProcesoVenta(1);
$Caja=$obVenta->normalizar($_REQUEST["TxtCaja"]);
$key=$obVenta->normalizar($_REQUEST["key"]);

if($Caja==1){
    $campo="Titulo";
}
if($Caja==2){
    $campo="Desde";
}
if($Caja==3){
    $campo="Hasta";
}
if($Caja==4){
    $campo="Anio";
}

if($Caja==5){
    $campo="ColorTitulo";
    $key="#".$key;
}
if($Caja==6){
    $campo="ColorRazonSocial";
    $key="#".$key;
}
if($Caja==7){
    $campo="ColorPrecios";
    $key="#".$key;
}
if($Caja==8){
    $campo="ColorBordes";
    $key="#".$key;
}
if($Caja==9){
    $campo="Mes";
}
$obVenta->ActualizaRegistro("publicidad_encabezado_cartel", $campo, $key, "ID", 1);

print("Se ha actualizado el campo $campo con el valor $key del encabezado del cartel");
?>