<?php

$myTabla="relacioncompras";
$idTabla="idRelacionCompras";
$myPage="relacioncompras.php";
$myTitulo="Relacion de compras";



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
$Vector["NuevoRegistro"]["Deshabilitado"]=1;
$Vector["EditarRegistro"]["Deshabilitado"]=1;
///Columnas excluidas

 //Indico que esta columna no se mostrará

$Vector["ProductosVenta_idProductosVenta"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["ProductosVenta_idProductosVenta"]["TablaVinculo"]="productosventa";  //tabla de donde se vincula
$Vector["ProductosVenta_idProductosVenta"]["IDTabla"]="idProductosVenta"; //id de la tabla que se vincula
$Vector["ProductosVenta_idProductosVenta"]["Display"]="Nombre"; 


$Vector["idProveedor"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["idProveedor"]["TablaVinculo"]="proveedores";  //tabla de donde se vincula
$Vector["idProveedor"]["IDTabla"]="idProveedores"; //id de la tabla que se vincula
$Vector["idProveedor"]["Display"]="RazonSocial"; 

$Vector["idUsuario"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["idUsuario"]["TablaVinculo"]="usuarios";  //tabla de donde se vincula
$Vector["idUsuario"]["IDTabla"]="idUsuarios"; //id de la tabla que se vincula
$Vector["idUsuario"]["Display"]="Apellido"; 

///Filtros y orden
$Vector["Order"]=" $idTabla DESC ";   //Orden
?>