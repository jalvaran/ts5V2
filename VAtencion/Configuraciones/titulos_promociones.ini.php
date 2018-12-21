<?php

$myTabla="titulos_promociones";
$idTabla="ID";
$myPage="titulos_promociones.php";
$myTitulo="Promociones";



/////Asigno Datos necesarios para la visualizacion de la tabla en el formato que se desea
////
///
//print($statement);
$Vector["Tabla"]=$myTabla;          //Tabla
$Vector["Titulo"]=$myTitulo;        //Titulo
$Vector["VerDesde"]=$startpoint;    //Punto desde donde empieza
$Vector["Limit"]=$limit;            //Numero de Registros a mostrar

        
$Vector["VerRegistro"]["Deshabilitado"]=1; 
///Columnas excluidas

$Vector["Activo"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["Activo"]["TablaVinculo"]="respuestas_condicional";  //tabla de donde se vincula
$Vector["Activo"]["IDTabla"]="Valor"; //id de la tabla que se vincula
$Vector["Activo"]["Display"]="Valor";                    //Columna que quiero mostrar
$Vector["Activo"]["Predeterminado"]="SI";

$Vector["Order"]=" $idTabla DESC ";   //Orden
?>