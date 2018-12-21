<?php
include_once("../../modelo/php_conexion.php");
include_once("../css_construct.php");
$css =  new CssIni("");
$obVenta = new ProcesoVenta(1);
$idEspacio=$obVenta->normalizar($_REQUEST["idDiv"]);
$idEspacio= str_replace("Esp", "", $idEspacio);
$idProducto=$obVenta->normalizar($_REQUEST["idProducto"]);
$obVenta->BorraReg("publicidad_paginas", "idProducto", $idProducto);
$sql="REPLACE INTO publicidad_paginas (ID,idProducto) VALUES ($idEspacio,$idProducto)";
$obVenta->Query($sql);

print("Se ha ubicado el producto $idProducto en el espacio $idEspacio");
?>