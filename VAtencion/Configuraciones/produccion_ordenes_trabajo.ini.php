<?php

$myTabla="produccion_ordenes_trabajo";
$MyID="ID";
$myPage="produccion_ordenes_trabajo.php";
$myTitulo="Ordenes de Trabajo";



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

//$Vector["NuevoRegistro"]["Deshabilitado"]=1;            
//$Vector["VerRegistro"]["Deshabilitado"]=1;                      
//$Vector["EditarRegistro"]["Deshabilitado"]=1; 

//Link para la accion ver
$Ruta="../tcpdf/examples/imprimirOT.php?ImgPrintFactura=";
$Vector["VerRegistro"]["Link"]=$Ruta;
$Vector["VerRegistro"]["ColumnaLink"]="ID";
/*
 * 
 * Selecciono las Columnas que tendran valores de otras tablas
 */



// Nueva Accion
$Ruta="CronogramaProduccion.php?idOT=";
$Vector["NuevaAccionLink"][1]="AddAct";
$Vector["NuevaAccion"]["AddAct"]["Titulo"]=" Agregar Actividades ";
$Vector["NuevaAccion"]["AddAct"]["Link"]=$Ruta;
$Vector["NuevaAccion"]["AddAct"]["ColumnaLink"]="ID";
$Vector["NuevaAccion"]["AddAct"]["Target"]="_self";

$Vector["idCliente"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["idCliente"]["TablaVinculo"]="clientes";  //tabla de donde se vincula
$Vector["idCliente"]["IDTabla"]="idClientes"; //id de la tabla que se vincula
$Vector["idCliente"]["Display"]="RazonSocial"; 
$Vector["idCliente"]["Predeterminado"]=1;

///Filtros y orden
$Vector["Order"]=" $MyID DESC ";   //Orden
?>