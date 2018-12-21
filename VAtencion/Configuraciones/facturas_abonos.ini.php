<?php

$myTabla="facturas_abonos";
$MyID="ID";
$myPage="facturas_abonos.php";
$myTitulo="Historial de Abonos a Facturas";



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
$Ruta="$myPage?idAbono=";
$Vector["VerRegistro"]["Link"]=$Ruta;
$Vector["VerRegistro"]["ColumnaLink"]="ID";

/*
 * 
 * Selecciono las Columnas que tendran valores de otras tablas
 */

$Vector["Usuarios_idUsuarios"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["Usuarios_idUsuarios"]["TablaVinculo"]="usuarios";  //tabla de donde se vincula
$Vector["Usuarios_idUsuarios"]["IDTabla"]="idUsuarios"; //id de la tabla que se vincula
$Vector["Usuarios_idUsuarios"]["Display"]="Apellido";                    //Columna que quiero mostrar

$Vector["Facturas_idFacturas"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["Facturas_idFacturas"]["TablaVinculo"]="facturas";  //tabla de donde se vincula
$Vector["Facturas_idFacturas"]["IDTabla"]="idFacturas"; //id de la tabla que se vincula
$Vector["Facturas_idFacturas"]["Display"]="NumeroFactura";                    //Columna que quiero mostrar
$Vector["Facturas_idFacturas"]["Predeterminado"]="N";
///Filtros y orden
$Vector["Order"]=" $MyID DESC ";   //Orden
?>