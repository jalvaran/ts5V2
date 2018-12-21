<?php

$myTabla="prod_sub4";
$myPage="prod_sub4.php";
$myID="idSub4";
$myTitulo="SubGrupo 4";



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
//$Vector["NuevoRegistro"]["Deshabilitado"]=1;          
$Vector["VerRegistro"]["Deshabilitado"]=1;       
//$Vector["EditarRegistro"]["Deshabilitado"]=1;

$Vector["idSub3"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["idSub3"]["TablaVinculo"]="prod_sub3";  //tabla de donde se vincula
$Vector["idSub3"]["IDTabla"]="idSub3"; //id de la tabla que se vincula
$Vector["idSub3"]["Display"]="NombreSub3"; 

///Filtros y orden
$Vector["Order"]=" $myID ASC ";   //Orden
?>