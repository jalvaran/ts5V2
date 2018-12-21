<?php

$myTabla="modelos_agenda";
$myPage="modelos_agenda.php";
$myTitulo="Agenda de las Modelos";
$idTabla="ID";


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
  //Link para la accion ver
$Ruta="$myPage?idCierre=";
$Vector["VerRegistro"]["Link"]=$Ruta;
$Vector["VerRegistro"]["ColumnaLink"]="ID";

$Vector["VerRegistro"]["Deshabilitado"]=1;       
$Vector["NuevoRegistro"]["Deshabilitado"]=1;                                 
$Vector["EditarRegistro"]["Deshabilitado"]=1;


///Filtros y orden
$Vector["Order"]=" $idTabla DESC ";   //Orden
?>