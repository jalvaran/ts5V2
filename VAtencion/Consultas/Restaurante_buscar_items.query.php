<?php
include_once("../../modelo/php_conexion.php");
include_once("../css_construct.php");
include_once("../clases/Restaurante.class.php");

session_start();
$idUser=$_SESSION['idUser'];
$css =  new CssIni("",0);

$obRest=new Restaurante($idUser);

if(isset($_REQUEST["Busqueda"])){
    $key=$obRest->normalizar($_REQUEST["Busqueda"]);
    $sql="SELECT idProductosVenta,Nombre,PrecioVenta FROM productosventa WHERE Nombre like '%$key%' or idProductosVenta='$key' LIMIT 20";
    $Datos=$obRest->Query($sql);
    if($obRest->NumRows($Datos)){
        $css->CrearTabla();
                   
        while($DatosProductos=$obRest->FetchArray($Datos)){
            $css->FilaTabla(16);
            $css->ColTabla($DatosProductos["Nombre"], 1);
            $css->ColTabla($DatosProductos["PrecioVenta"], 1);
            $css->CierraFilaTabla();
        }
        $css->CerrarTabla();
    }else{
        $css->CrearNotificacionAzul("Sin resultados", 16);
    }
}
?>