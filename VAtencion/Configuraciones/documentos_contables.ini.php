<?php

$myTabla="documentos_contables";
$idTabla="ID";
$myPage="documentos_contables.php";
$myTitulo="Documentos Contables";

/*
 * Opciones en Acciones
 * 
 */

//$Vector["NuevoRegistro"]["Deshabilitado"]=1;            
//$Vector["VerRegistro"]["Deshabilitado"]=1;                      
//$Vector["EditarRegistro"]["Deshabilitado"]=1; 

/////Asigno Datos necesarios para la visualizacion de la tabla en el formato que se desea
////
///
//print($statement);
$Vector["Tabla"]=$myTabla;          //Tabla
$Vector["Titulo"]=$myTitulo;        //Titulo
$Vector["VerDesde"]=$startpoint;    //Punto desde donde empieza
$Vector["Limit"]=$limit;            //Numero de Registros a mostrar
$Vector["MyPage"]=$myPage;            //pagina



///Filtros y orden
$Vector["Order"]=" $idTabla DESC ";   //Orden
?>