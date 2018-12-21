<?php

$myTabla="nomina_documentos_equivalentes";
$MyID="ID";
$myPage="nomina_documentos_equivalentes.php";
$myTitulo="Documentos Equivalentes";



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
$Vector["EditarRegistro"]["Deshabilitado"]=1; 

//Link para la accion ver
$Ruta="PDF_Documentos.php?idDocumento=33&idDocEqui=";
$Vector["VerRegistro"]["Link"]=$Ruta;
$Vector["VerRegistro"]["ColumnaLink"]="ID";
/*
 * 
 * Selecciono las Columnas que tendran valores de otras tablas
 */



// Nueva Accion
$Ruta="ProcesadoresJS/GeneradorCSVReportes.php?Opcion=2&sp=1&idDocumentoEquivalente=";
$Vector["NuevaAccionLink"][0]="Relacion";
$Vector["NuevaAccion"]["Relacion"]["Titulo"]=" Relacion ";
$Vector["NuevaAccion"]["Relacion"]["Link"]=$Ruta;
$Vector["NuevaAccion"]["Relacion"]["ColumnaLink"]="ID";
$Vector["NuevaAccion"]["Relacion"]["Target"]="_blank";


// Nueva Accion
$Ruta="AnularDocumentoEquivalente.php?idDocumento=";
$Vector["NuevaAccionLink"][1]="Anular";
$Vector["NuevaAccion"]["Anular"]["Titulo"]=" Anular ";
$Vector["NuevaAccion"]["Anular"]["Link"]=$Ruta;
$Vector["NuevaAccion"]["Anular"]["ColumnaLink"]="ID";
$Vector["NuevaAccion"]["Anular"]["Target"]="_self";


$Vector["Tercero"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["Tercero"]["TablaVinculo"]="proveedores";  //tabla de donde se vincula
$Vector["Tercero"]["IDTabla"]="Num_Identificacion"; //id de la tabla que se vincula
$Vector["Tercero"]["Display"]="RazonSocial"; 
$Vector["Tercero"]["Predeterminado"]=1;
///Filtros y orden
$Vector["Order"]=" $MyID DESC ";   //Orden
?>