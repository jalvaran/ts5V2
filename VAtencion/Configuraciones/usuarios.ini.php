<?php

$myTabla="usuarios";
$idTabla="idUsuarios";
$myPage="usuarios.php";
$myTitulo="Usuarios del Sistema";



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

$Vector["Excluir"]["Password"]=1;   //Indico que esta columna no se mostrará
$Vector["Excluir"]["Role"]=1;   //Indico que esta columna no se mostrará
$Vector["Excluir"]["FechaCreacion"]=1;   //Indico que esta columna no se mostrará

$Vector["TipoUser"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["TipoUser"]["TablaVinculo"]="usuarios_tipo";  //tabla de donde se vincula
$Vector["TipoUser"]["IDTabla"]="Tipo"; //id de la tabla que se vincula
$Vector["TipoUser"]["Display"]="Tipo"; 
///Filtros y orden
$Vector["Order"]=" $idTabla DESC ";   //Orden
?>