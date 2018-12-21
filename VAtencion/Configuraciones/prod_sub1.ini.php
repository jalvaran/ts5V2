<?php

$myTabla="prod_sub1";
$myPage="prod_sub1.php";
$myID="idSub1";
$myTitulo="SubGrupo 1";



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

$Vector["idDepartamento"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["idDepartamento"]["TablaVinculo"]="prod_departamentos";  //tabla de donde se vincula
$Vector["idDepartamento"]["IDTabla"]="idDepartamentos"; //id de la tabla que se vincula
$Vector["idDepartamento"]["Display"]="Nombre"; 

///Filtros y orden
$Vector["Order"]=" $myID ASC ";   //Orden
?>