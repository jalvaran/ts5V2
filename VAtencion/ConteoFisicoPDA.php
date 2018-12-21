<?php
$myPage="ConteoFisico.php";
include_once("../sesiones/php_control.php");
include_once("css_construct.php");
include_once("procesadores/ConteoFisico.process.php");  //Clases de donde se escribirán las tablas
?>
<!DOCTYPE html>
<html>
<head>
<title>TS5</title>
</head>
<body>
    <form name="FrmEnviaCodigo" target="_self" action="ConteoFisicoPDA.php" method="post">
        <input type="hidden" name="TxtCantidad" value="1"></input>
        <input type="text" name="TxtCodigoBarras"></input>
        <input type="submit" name="BtnContar" value="Enviar"></input>
    </form>
</body>  
</html>