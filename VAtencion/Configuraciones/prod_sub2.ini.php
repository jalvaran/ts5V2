<?php

$myTabla="prod_sub2";
$myPage="prod_sub2.php";
$myID="idSub2";
$myTitulo="SubGrupo 2";



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

$Vector["idSub1"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["idSub1"]["TablaVinculo"]="prod_sub1";  //tabla de donde se vincula
$Vector["idSub1"]["IDTabla"]="idSub1"; //id de la tabla que se vincula
$Vector["idSub1"]["Display"]="NombreSub1"; 

///Filtros y orden
$Vector["Order"]=" $myID ASC ";   //Orden
?>