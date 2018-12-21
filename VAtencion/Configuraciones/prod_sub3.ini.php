<?php

$myTabla="prod_sub3";
$myPage="prod_sub3.php";
$myID="idSub3";
$myTitulo="SubGrupo 3";



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

$Vector["idSub2"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["idSub2"]["TablaVinculo"]="prod_sub2";  //tabla de donde se vincula
$Vector["idSub2"]["IDTabla"]="idSub2"; //id de la tabla que se vincula
$Vector["idSub2"]["Display"]="NombreSub2"; 

///Filtros y orden
$Vector["Order"]=" $myID ASC ";   //Orden
?>