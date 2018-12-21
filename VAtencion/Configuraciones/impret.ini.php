<?php

$myTabla="impret";
$idTabla="idImpRet";
$myPage="impret.php";
$myTitulo="Impuestos y retenciones";



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

        
$Vector["VerRegistro"]["Deshabilitado"]=1;       

///Filtros y orden
$Vector["Order"]=" $idTabla DESC ";   //Orden
?>