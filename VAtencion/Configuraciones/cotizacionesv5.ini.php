<?php

$myTabla="cotizacionesv5";
$MyID="ID";
$myPage="cotizacionesv5.php";
$myTitulo="Seguimiento de cotizaciones";



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
$Ruta="ImprimirPDFCotizacion.php?ImgPrintCoti=";
$Vector["VerRegistro"]["Link"]=$Ruta;
$Vector["VerRegistro"]["ColumnaLink"]="ID";

// Nueva Accion
$Ruta="AgregarAnexosCotizacion.php?idCotizacion=";
$Vector["NuevaAccionLink"][1]="Anexos";
$Vector["NuevaAccion"]["Anexos"]["Titulo"]=" Anexos ";
$Vector["NuevaAccion"]["Anexos"]["Link"]=$Ruta;
$Vector["NuevaAccion"]["Anexos"]["ColumnaLink"]="ID";
$Vector["NuevaAccion"]["Anexos"]["Target"]="_blank";
/*
 * 
 * Selecciono las Columnas que tendran valores de otras tablas
 */



$Vector["Usuarios_idUsuarios"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["Usuarios_idUsuarios"]["TablaVinculo"]="usuarios";  //tabla de donde se vincula
$Vector["Usuarios_idUsuarios"]["IDTabla"]="idUsuarios"; //id de la tabla que se vincula
$Vector["Usuarios_idUsuarios"]["Display"]="Apellido"; 

$Vector["Clientes_idClientes"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["Clientes_idClientes"]["TablaVinculo"]="clientes";  //tabla de donde se vincula
$Vector["Clientes_idClientes"]["IDTabla"]="idClientes"; //id de la tabla que se vincula
$Vector["Clientes_idClientes"]["Display"]="RazonSocial"; 



$Vector["Excluir"]["NumSolicitud"]=1;
$Vector["Excluir"]["NumOrden"]=1;
///Filtros y orden
$Vector["Order"]=" $MyID DESC ";   //Orden
?>