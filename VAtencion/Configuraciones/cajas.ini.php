<?php

$myTabla="cajas";
$idTabla="ID";
$myPage="cajas.php";
$myTitulo="Gestión de Cajas";



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
///Columnas excluidas

 //Indico que esta columna no se mostrará

$Vector["CentroCostos"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["CentroCostos"]["TablaVinculo"]="centrocosto";  //tabla de donde se vincula
$Vector["CentroCostos"]["IDTabla"]="ID"; //id de la tabla que se vincula
$Vector["CentroCostos"]["Display"]="Nombre"; 

//Indico que esta columna no se mostrará

$Vector["idResolucionDian"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["idResolucionDian"]["TablaVinculo"]="empresapro_resoluciones_facturacion";  //tabla de donde se vincula
$Vector["idResolucionDian"]["IDTabla"]="ID"; //id de la tabla que se vincula
$Vector["idResolucionDian"]["Display"]="NombreInterno"; 


$Vector["CuentaPUCEfectivo"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["CuentaPUCEfectivo"]["TablaVinculo"]="cuentasfrecuentes";  //tabla de donde se vincula
$Vector["CuentaPUCEfectivo"]["IDTabla"]="CuentaPUC"; //id de la tabla que se vincula
$Vector["CuentaPUCEfectivo"]["Display"]="Nombre"; 


$Vector["CuentaPUCCheques"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["CuentaPUCCheques"]["TablaVinculo"]="subcuentas";  //tabla de donde se vincula
$Vector["CuentaPUCCheques"]["IDTabla"]="PUC"; //id de la tabla que se vincula
$Vector["CuentaPUCCheques"]["Display"]="Nombre"; 

$Vector["CuentaPUCOtros"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["CuentaPUCOtros"]["TablaVinculo"]="subcuentas";  //tabla de donde se vincula
$Vector["CuentaPUCOtros"]["IDTabla"]="PUC"; //id de la tabla que se vincula
$Vector["CuentaPUCOtros"]["Display"]="Nombre"; 

$Vector["CuentaPUCIVAEgresos"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["CuentaPUCIVAEgresos"]["TablaVinculo"]="subcuentas";  //tabla de donde se vincula
$Vector["CuentaPUCIVAEgresos"]["IDTabla"]="PUC"; //id de la tabla que se vincula
$Vector["CuentaPUCIVAEgresos"]["Display"]="Nombre"; 
///Filtros y orden
$Vector["Order"]=" $idTabla DESC ";   //Orden
?>