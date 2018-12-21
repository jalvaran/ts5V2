<?php

$myTabla="vista_totales_facturacion";
$idTabla="FechaFactura";
$myPage="vista_totales_facturacion.php";
$myTitulo="Totales en Facturacion";



/////Asigno Datos necesarios para la visualizacion de la tabla en el formato que se desea
////
///
//print($statement);
$Vector["Tabla"]=$myTabla;          //Tabla
$Vector["Titulo"]=$myTitulo;        //Titulo
$Vector["VerDesde"]=$startpoint;    //Punto desde donde empieza
$Vector["Limit"]=$limit;            //Numero de Registros a mostrar
/*
 * Deshabilito Acciones
 * 
 */
$Vector["NuevoRegistro"]["Deshabilitado"]=1; 
$Vector["EditarRegistro"]["Deshabilitado"]=1;        
$Vector["VerRegistro"]["Deshabilitado"]=1; 


$Vector["Order"]=" $idTabla DESC";   //Orden
?>