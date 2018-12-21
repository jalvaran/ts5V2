<?php

$myTabla="requerimientos_proyectos";
$MyID="ID";
$myPage="requerimientos_proyectos.php";
$myTitulo="Proyectos";



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


//Link para la accion ver
$Ruta="$myPage?idAbono=";
$Vector["VerRegistro"]["Link"]=$Ruta;
$Vector["VerRegistro"]["ColumnaLink"]="ID";

// Nueva Accion
$Ruta="AgregarRequerimientos.php?ID=";
$Vector["NuevaAccionLink"][0]="Agregar";
$Vector["NuevaAccion"]["Agregar"]["Titulo"]=" Agregar Requerimientos ";
$Vector["NuevaAccion"]["Agregar"]["Link"]=$Ruta;
$Vector["NuevaAccion"]["Agregar"]["ColumnaLink"]=$MyID;
$Vector["NuevaAccion"]["Agregar"]["Target"]="_self";
///Filtros y orden
$Vector["Order"]=" $MyID DESC ";   //Orden
?>