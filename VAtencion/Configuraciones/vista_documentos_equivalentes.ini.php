<?php

$myTabla="vista_documentos_equivalentes";
$idTabla="ID";
$myPage="vista_documentos_equivalentes.php";
$myTitulo="Historial Documentos Equivalentes";



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
$Vector["EditarRegistro"]["Deshabilitado"]=1;        
//$Vector["VerRegistro"]["Deshabilitado"]=1; 


//Link para la accion ver
$Ruta="ProcesadoresJS/GeneradorExcel.php?idDocumento=3&idDocumentoEquivalente=";
$Vector["VerRegistro"]["Link"]=$Ruta;
$Vector["VerRegistro"]["ColumnaLink"]="ID";
///Columnas excluidas

$Vector["Order"]=" $idTabla DESC ";   //Orden
?>