<?php

$myTabla="prod_departamentos";
$myPage="prod_departamentos.php";
$myID="idDepartamentos";
$myTitulo="Clasificacion del Inventario por Departamentos";



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
//$Vector["NuevoRegistro"]["Deshabilitado"]=1;          
$Vector["VerRegistro"]["Deshabilitado"]=1;       
//$Vector["EditarRegistro"]["Deshabilitado"]=1;

$Vector["TablaOrigen"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["TablaOrigen"]["TablaVinculo"]="tablas_ventas";  //tabla de donde se vincula
$Vector["TablaOrigen"]["IDTabla"]="NombreTabla"; //id de la tabla que se vincula
$Vector["TablaOrigen"]["Display"]="NombreTabla"; 
$Vector["TablaOrigen"]["Predeterminado"]=1;

$Vector["ManejaExistencias"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["ManejaExistencias"]["TablaVinculo"]="respuestas_condicional";  //tabla de donde se vincula
$Vector["ManejaExistencias"]["IDTabla"]="Valor"; //id de la tabla que se vincula
$Vector["ManejaExistencias"]["Display"]="Valor"; 
$Vector["ManejaExistencias"]["Predeterminado"]=1;

$Vector["TipoItem"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["TipoItem"]["TablaVinculo"]="respuestas_tipo_item";  //tabla de donde se vincula
$Vector["TipoItem"]["IDTabla"]="Valor"; //id de la tabla que se vincula
$Vector["TipoItem"]["Display"]="Valor"; 
$Vector["TipoItem"]["Predeterminado"]=1;
///Filtros y orden
$Vector["Order"]=" $myID ASC ";   //Orden
?>