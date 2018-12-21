<?php

$myTabla="produccion_actividades";
$MyID="ID";
$myPage="produccion_actividades.php";
$myTitulo="Actividades Ordenes de trabajo";



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


/*
 * 
 * Selecciono las Columnas que tendran valores de otras tablas
 */





$Vector["idCliente"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["idCliente"]["TablaVinculo"]="clientes";  //tabla de donde se vincula
$Vector["idCliente"]["IDTabla"]="idClientes"; //id de la tabla que se vincula
$Vector["idCliente"]["Display"]="RazonSocial"; 
$Vector["idCliente"]["Predeterminado"]=1;

///Filtros y orden
$Vector["Order"]=" $MyID DESC ";   //Orden
?>