<?php

$myTabla="compras_activas";
$MyID="idComprasActivas";
$myPage="compras_activas.php";
$myTitulo="Historial de Compras Activas";



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

$Vector["NuevoRegistro"]["Deshabilitado"]=1;            
$Vector["VerRegistro"]["Deshabilitado"]=1;                      
$Vector["EditarRegistro"]["Deshabilitado"]=1;  


//Link para la accion ver
$Ruta="$myPage?idAbono=";
$Vector["VerRegistro"]["Link"]=$Ruta;
$Vector["VerRegistro"]["ColumnaLink"]="ID";

// Nueva Accion
$Ruta="AnularCompraActiva.php?idCompra=";
$Vector["NuevaAccionLink"][0]="Anular";
$Vector["NuevaAccion"]["Anular"]["Titulo"]=" Anular ";
$Vector["NuevaAccion"]["Anular"]["Link"]=$Ruta;
$Vector["NuevaAccion"]["Anular"]["ColumnaLink"]=$MyID;
$Vector["NuevaAccion"]["Anular"]["Target"]="_self";
///Filtros y orden
$Vector["Order"]=" $MyID DESC ";   //Orden
?>