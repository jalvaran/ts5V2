<?php

$myTabla="comprobantes_ingreso";
$MyID="ID";
$myPage="comprobantes_ingreso.php";
$myTitulo="Historial Comprobantes de Ingreso";



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
$Ruta="PDF_Documentos.php?idDocumento=4&idIngreso=";
$Vector["VerRegistro"]["Link"]=$Ruta;
$Vector["VerRegistro"]["ColumnaLink"]="ID";
/*
 * 
 * Selecciono las Columnas que tendran valores de otras tablas
 */

$Vector["Usuarios_idUsuarios"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["Usuarios_idUsuarios"]["TablaVinculo"]="usuarios";  //tabla de donde se vincula
$Vector["Usuarios_idUsuarios"]["IDTabla"]="idUsuarios"; //id de la tabla que se vincula
$Vector["Usuarios_idUsuarios"]["Display"]="Apellido"; 
$Vector["Usuarios_idUsuarios"]["Predeterminado"]=1;

// Nueva Accion
$Ruta="AnularComprobanteIngreso.php?idComprobante=";
$Vector["NuevaAccionLink"][0]="Anular";
$Vector["NuevaAccion"]["Anular"]["Titulo"]=" Anular ";
$Vector["NuevaAccion"]["Anular"]["Link"]=$Ruta;
$Vector["NuevaAccion"]["Anular"]["ColumnaLink"]="ID";
$Vector["NuevaAccion"]["Anular"]["Target"]="_self";

$Vector["Soporte"]["Link"]=1;   //Indico que esta columna tendra un vinculo

///Filtros y orden
$Vector["Order"]=" $MyID DESC ";   //Orden
?>