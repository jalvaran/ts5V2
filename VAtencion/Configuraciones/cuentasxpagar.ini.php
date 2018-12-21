<?php

$myTabla="cuentasxpagar";
$myPage="cuentasxpagar.php";
$myTitulo="Cuentas X Pagar";
$idTabla="ID";


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
          
$Vector["VerRegistro"]["Deshabilitado"]=1;       
//$Vector["NuevoRegistro"]["Deshabilitado"]=1;                                 
//$Vector["EditarRegistro"]["Deshabilitado"]=1;

// Nueva Accion
$Ruta="$myPage?idCuentaXPagar=";
$Vector["NuevaAccionLink"][0]="AgregarPreEgreso";
$Vector["NuevaAccion"]["AgregarPreEgreso"]["Titulo"]="Agregar a PreEgreso";
$Vector["NuevaAccion"]["AgregarPreEgreso"]["Link"]=$Ruta;
$Vector["NuevaAccion"]["AgregarPreEgreso"]["ColumnaLink"]="ID";
$Vector["NuevaAccion"]["AgregarPreEgreso"]["Target"]="_self";

$Vector["idSucursal"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["idSucursal"]["TablaVinculo"]="empresa_pro_sucursales";  //tabla de donde se vincula
$Vector["idSucursal"]["IDTabla"]="ID"; //id de la tabla que se vincula
$Vector["idSucursal"]["Display"]="Nombre";                    //Columna que quiero mostrar
$Vector["idSucursal"]["Predeterminado"]=1;

$Vector["idCentroCostos"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["idCentroCostos"]["TablaVinculo"]="centrocosto";  //tabla de donde se vincula
$Vector["idCentroCostos"]["IDTabla"]="ID"; //id de la tabla que se vincula
$Vector["idCentroCostos"]["Display"]="Nombre";                    //Columna que quiero mostrar
$Vector["idCentroCostos"]["Predeterminado"]=1;
///Filtros y orden
$Vector["Order"]=" $idTabla DESC ";   //Orden
?>