<?php

$myTabla="cotizaciones_anexos";
$MyID="ID";
$myPage="cotizaciones_anexos.php";
$myTitulo="Anexos a Cotizaciones";



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
//$Vector["VerRegistro"]["Deshabilitado"]=1;                      
//$Vector["EditarRegistro"]["Deshabilitado"]=1; 

//Link para la accion ver
$Ruta="AgregarAnexosCotizacion.php?idCotizacion=";
$Vector["VerRegistro"]["Link"]=$Ruta;
$Vector["VerRegistro"]["ColumnaLink"]="NumCotizacion";

/*
 * 
 * Selecciono las Columnas que tendran valores de otras tablas
 */


///Filtros y orden
$Vector["Order"]=" $MyID DESC ";   //Orden
?>