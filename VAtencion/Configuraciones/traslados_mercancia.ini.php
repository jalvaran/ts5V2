<?php

$myTabla="traslados_mercancia";
$MyID="ID";
$myPage="traslados_mercancia.php";
$myTitulo="Traslados de Mercancia";



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
$Ruta="../tcpdf/examples/imprimirTraslado.php?idTraslado=";
$Vector["VerRegistro"]["Link"]=$Ruta;
$Vector["VerRegistro"]["ColumnaLink"]="ID";



// Nueva Accion
$Ruta="RegistrarTraslado.php?idTraslado=";
$Vector["NuevaAccionLink"][0]="RegistrarTraslado";
$Vector["NuevaAccion"]["RegistrarTraslado"]["Titulo"]="Registrar";
$Vector["NuevaAccion"]["RegistrarTraslado"]["Link"]=$Ruta;
$Vector["NuevaAccion"]["RegistrarTraslado"]["ColumnaLink"]="ID";
$Vector["NuevaAccion"]["RegistrarTraslado"]["Target"]="_self";

/*
 * 
 * Selecciono las Columnas que tendran valores de otras tablas
 */



$Vector["Origen"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["Origen"]["TablaVinculo"]="empresa_pro_sucursales";  //tabla de donde se vincula
$Vector["Origen"]["IDTabla"]="ID"; //id de la tabla que se vincula
$Vector["Origen"]["Display"]="Nombre"; 

$Vector["Destino"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["Destino"]["TablaVinculo"]="empresa_pro_sucursales";  //tabla de donde se vincula
$Vector["Destino"]["IDTabla"]="ID"; //id de la tabla que se vincula
$Vector["Destino"]["Display"]="Nombre"; 

///Filtros y orden
$Vector["Order"]=" $MyID DESC ";   //Orden
?>