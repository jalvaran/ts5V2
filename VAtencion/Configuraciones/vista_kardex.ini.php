<?php

$myTabla="vista_kardex";
$myPage="vista_kardex.php";
$myID="ID";
$myTitulo="Kardex Productos para la Venta";



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
$Vector["VerRegistro"]["Deshabilitado"]=1;       
$Vector["EditarRegistro"]["Deshabilitado"]=1;


///Filtros y orden
$Vector["Order"]=" $myID DESC ";   //Orden
?>