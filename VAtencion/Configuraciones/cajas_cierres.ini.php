<?php

$myTabla="cajas_aperturas_cierres";
$MyID="ID";
$myPage="cajas_aperturas_cierres.php";
$myTitulo="Historial de Cierres";



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
//$Vector["VerRegistro"]["Deshabilitado"]=1;                      
$Vector["EditarRegistro"]["Deshabilitado"]=1;  


//Link para la accion ver
$Ruta="$myPage?idCierre=";
$Vector["VerRegistro"]["Link"]=$Ruta;
$Vector["VerRegistro"]["ColumnaLink"]="ID";

// Nueva Accion
$Ruta="ProcesadoresJS/GeneradorExcel.php?idDocumento=2&idCierre=";
$Vector["NuevaAccionLink"][2]="Resumen";
$Vector["NuevaAccion"]["Resumen"]["Titulo"]=" Resumen ";
$Vector["NuevaAccion"]["Resumen"]["Link"]=$Ruta;
$Vector["NuevaAccion"]["Resumen"]["ColumnaLink"]="ID";
$Vector["NuevaAccion"]["Resumen"]["Target"]="_blank";
/*
 * 
 * Selecciono las Columnas que tendran valores de otras tablas
 */

$Vector["Usuario"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["Usuario"]["TablaVinculo"]="usuarios";  //tabla de donde se vincula
$Vector["Usuario"]["IDTabla"]="idUsuarios"; //id de la tabla que se vincula
$Vector["Usuario"]["Display"]="Apellido";                    //Columna que quiero mostrar

///Filtros y orden
$Vector["Order"]=" $MyID DESC ";   //Orden
?>