<?php

$myTabla="conceptos";
$MyID="ID";
$myPage="conceptos.php";
$myTitulo="Conceptos Contables";



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
$Ruta="../tcpdf/examples/imprimirFactura.php?ImgPrintFactura=";
$Vector["VerRegistro"]["Link"]=$Ruta;
$Vector["VerRegistro"]["ColumnaLink"]="idFacturas";
/*
 * 
 * Selecciono las Columnas que tendran valores de otras tablas
 */



// Nueva Accion
$Ruta="CreacionConceptos.php?CmbConcepto=";
$Vector["NuevaAccionLink"][1]="Editar";
$Vector["NuevaAccion"]["Editar"]["Titulo"]=" Editar ";
$Vector["NuevaAccion"]["Editar"]["Link"]=$Ruta;
$Vector["NuevaAccion"]["Editar"]["ColumnaLink"]="ID";
$Vector["NuevaAccion"]["Editar"]["Target"]="_blank";

// Nueva Accion
$Ruta="CreacionConceptos.php?BtnCopiarConcepto=1&CmbConcepto=";
$Vector["NuevaAccionLink"][2]="Copiar";
$Vector["NuevaAccion"]["Copiar"]["Titulo"]=" Copiar ";
$Vector["NuevaAccion"]["Copiar"]["Link"]=$Ruta;
$Vector["NuevaAccion"]["Copiar"]["ColumnaLink"]="ID";
$Vector["NuevaAccion"]["Copiar"]["Target"]="_blank";

///Filtros y orden
$Vector["Order"]=" $MyID DESC ";   //Orden
?>