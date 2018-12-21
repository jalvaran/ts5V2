<?php

$myTabla="productos_precios_adicionales";
$myPage="productos_precios_adicionales.php";
$myTitulo="Precios adicionales de los productos";
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

$Vector["Excluir"]["idUser"]=1;

$Vector["idListaPrecios"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["idListaPrecios"]["TablaVinculo"]="productos_lista_precios";  //tabla de donde se vincula
$Vector["idListaPrecios"]["IDTabla"]="ID"; //id de la tabla que se vincula
$Vector["idListaPrecios"]["Display"]="Nombre";                    //Columna que quiero mostrar
//
$Vector["TablaVenta"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["TablaVenta"]["TablaVinculo"]="tablas_ventas";  //tabla de donde se vincula
$Vector["TablaVenta"]["IDTabla"]="NombreTabla"; //id de la tabla que se vincula
$Vector["TablaVenta"]["Display"]="NombreTabla";    
///Filtros y orden
$Vector["Order"]=" $idTabla DESC ";   //Orden
?>