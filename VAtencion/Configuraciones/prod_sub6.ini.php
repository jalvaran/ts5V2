<?php

$myTabla="prod_sub6";
$myPage="prod_sub6.php";
$myID="idSub6";
$myTitulo="SubGrupo 6";



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

$Vector["idSub5"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["idSub5"]["TablaVinculo"]="prod_sub4";  //tabla de donde se vincula
$Vector["idSub5"]["IDTabla"]="idSub4"; //id de la tabla que se vincula
$Vector["idSub5"]["Display"]="NombreSub4"; 

///Filtros y orden
$Vector["Order"]=" $myID ASC ";   //Orden
?>