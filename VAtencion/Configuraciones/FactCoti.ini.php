<?php

$myTabla="cotizacionesv5";
$idTabla="ID";
$myPage="FactCoti.php";
$myTitulo="Asociar Cotización a Factura";

/*
 * Opciones en Acciones
 * 
 */

$Vector["NuevoRegistro"]["Deshabilitado"]=1;            
//$Vector["VerRegistro"]["Deshabilitado"]=1;                      
$Vector["EditarRegistro"]["Deshabilitado"]=1; 

/////Asigno Datos necesarios para la visualizacion de la tabla en el formato que se desea
////
///
//print($statement);
$Vector["Tabla"]=$myTabla;          //Tabla
$Vector["Titulo"]=$myTitulo;        //Titulo
$Vector["VerDesde"]=$startpoint;    //Punto desde donde empieza
$Vector["Limit"]=$limit;            //Numero de Registros a mostrar
$Vector["MyPage"]=$myPage;            //pagina
///Columnas excluidas

//Link para la accion ver
$Ruta="../tcpdf/examples/imprimircoti.php?ImgPrintCoti=";
$Vector["VerRegistro"]["Link"]=$Ruta;
$Vector["VerRegistro"]["ColumnaLink"]="ID";

//Nueva Accion
$Ruta="FacturaCotizacion.php?TxtAsociarCotizacion=";
$Vector["NuevaAccionLink"][0]="AsociarCoti";
$Vector["NuevaAccion"]["AsociarCoti"]["Titulo"]="Facturar";
$Vector["NuevaAccion"]["AsociarCoti"]["Link"]=$Ruta;
$Vector["NuevaAccion"]["AsociarCoti"]["ColumnaLink"]="ID";
$Vector["NuevaAccion"]["AsociarCoti"]["Target"]="_self";

/*
 * 
 * Selecciono las Columnas que tendran valores de otras tablas
 */


$Vector["Clientes_idClientes"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["Clientes_idClientes"]["TablaVinculo"]="clientes";  //tabla de donde se vincula
$Vector["Clientes_idClientes"]["IDTabla"]="idClientes"; //id de la tabla que se vincula
$Vector["Clientes_idClientes"]["Display"]="RazonSocial";                    //Columna que quiero mostrar

$Vector["CentroCosto"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["CentroCosto"]["TablaVinculo"]="centrocosto";  //tabla de donde se vincula
$Vector["CentroCosto"]["IDTabla"]="ID"; //id de la tabla que se vincula
$Vector["CentroCosto"]["Display"]="Nombre";                    //Columna que quiero mostrar

$Vector["Usuarios_idUsuarios"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["Usuarios_idUsuarios"]["TablaVinculo"]="usuarios";  //tabla de donde se vincula
$Vector["Usuarios_idUsuarios"]["IDTabla"]="idUsuarios"; //id de la tabla que se vincula
$Vector["Usuarios_idUsuarios"]["Display"]="Apellido";                    //Columna que quiero mostrar

///Filtros y orden
$Vector["Order"]=" $idTabla DESC ";   //Orden
?>