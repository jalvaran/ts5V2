<?php
//include_once("../../modelo/php_tablas.php");  //Clases de donde se escribirán las tablas
/* 
 * Este archivo se encarga de eschuchar las peticiones para guardar un archivo
 */

/* 
 * Si se Solicita Guardar un Registro
 */
if($_REQUEST["idKit"]>0){
    include_once("../../modelo/php_tablas.php");  //Clases de donde se escribirán las tablas
    $obTabla = new Tabla($db);
    $obVenta = new ProcesoVenta(1);
    $tablaProducto=$_REQUEST["Tabla"];
    $Cantidad=$_REQUEST["TxtCantidad"];
    $Kit=$_REQUEST["idKit"];
    $idProducto=$_REQUEST["IDProducto"];
    $Page=$_REQUEST["Page"];
    $DatosProducto=$obVenta->DevuelveValores($tablaProducto, "idProductosVenta", $idProducto);
    $Vector["Tabla"]=$tab;
    
    $tab="kits_relaciones";
    $NumRegistros=4;
    $Columnas[0]="TablaProducto";	$Valores[0]=$tablaProducto;
    $Columnas[1]="ReferenciaProducto";  $Valores[1]=$DatosProducto["Referencia"];
    $Columnas[2]="Cantidad";            $Valores[2]=$Cantidad;
    $Columnas[3]="IDKit";               $Valores[3]=$Kit;
       
    $obVenta->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
    header("location:../$Page");
}
?>