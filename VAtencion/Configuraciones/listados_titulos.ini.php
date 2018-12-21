<?php
$myTitulo="Listado de Titulos";
$myPage="listados_titulos.php";
/////Asigno Datos necesarios para la visualizacion de la tabla en el formato que se desea
////
///
//print($statement);
$Vector["Tabla"]=$myTabla;          //Tabla
$Vector["Titulo"]=$myTitulo;        //Titulo
$Vector["VerDesde"]=$startpoint;    //Punto desde donde empieza
$Vector["Limit"]=$limit;            //Numero de Registros a mostrar
$Vector["MyPage"]="listados_titulos.php?CmbListado=$myTabla";

/*
 * Deshabilito Acciones
 * 
 */
 

$Vector["NuevoRegistro"]["Deshabilitado"]=1;   
$Vector["VerRegistro"]["Deshabilitado"]=1;       

// Nueva Accion
$Ruta="trasladar_titulo.php?CmbListado=$myTabla&Mayor=";
$Vector["NuevaAccionLink"][1]="Traslado";
$Vector["NuevaAccion"]["Traslado"]["Titulo"]=" Trasladar ";
$Vector["NuevaAccion"]["Traslado"]["Link"]=$Ruta;
$Vector["NuevaAccion"]["Traslado"]["ColumnaLink"]="Mayor1";
$Vector["NuevaAccion"]["Traslado"]["Target"]="_blank";
              
///Filtros y orden
$Vector["Order"]=" Mayor1 DESC ";   //Orden
?>