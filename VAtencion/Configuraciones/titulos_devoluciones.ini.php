<?php

$myTabla="vista_titulos_devueltos";
$MyID="ID";
$myPage="titulos_devoluciones.php";
$myTitulo="Historial de Titulos Devueltos";
$Vector["MyPage"]=$myPage;


/////Asigno Datos necesarios para la visualizacion de la tabla en el formato que se desea
////
///
//print($statement);
$Vector["Tabla"]=$myTabla;          //Tabla
$Vector["Titulo"]=$myTitulo;        //Titulo
$Vector["VerDesde"]=$startpoint;    //Punto desde donde empieza
$Vector["Limit"]=$limit;            //Numero de Registros a mostrar

/*
 * Opciones en Acciones
 * 
 */

$Vector["NuevoRegistro"]["Deshabilitado"]=1;            
$Vector["VerRegistro"]["Deshabilitado"]=1;                      
$Vector["EditarRegistro"]["Deshabilitado"]=1; 

//Link para la accion ver
$Ruta="../tcpdf/examples/ImprimaAsignacionTitulos.php?idAsignacion=";
$Vector["VerRegistro"]["Link"]=$Ruta;
$Vector["VerRegistro"]["ColumnaLink"]="ID";

///Filtros y orden
$Vector["Order"]=" $MyID DESC ";   //Orden
?>