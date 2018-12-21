<?php

$myTabla="titulos_cuentasxcobrar";
$myPage="titulos_cuentasxcobrar.php";
$myTitulo="Cuentas X Cobrar";
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
          
$Vector["VerRegistro"]["Deshabilitado"]=1;       
$Vector["NuevoRegistro"]["Deshabilitado"]=1;                                 
//$Vector["EditarRegistro"]["Deshabilitado"]=1;

// Nueva Accion
$Ruta="$myPage?idCartera=";
$Vector["NuevaAccionLink"][0]="AsociarCoti";
$Vector["NuevaAccion"]["AsociarCoti"]["Titulo"]="Registrar Pago";
$Vector["NuevaAccion"]["AsociarCoti"]["Link"]=$Ruta;
$Vector["NuevaAccion"]["AsociarCoti"]["ColumnaLink"]="ID";
$Vector["NuevaAccion"]["AsociarCoti"]["Target"]="_self";
//Selecciono las Columnas que tendran valores de otras tablas
//
//


///Filtros y orden
$Vector["Order"]=" $idTabla DESC ";   //Orden
?>