<?php

$myTabla="vista_factura_compra_totales";
$idTabla="idFacturaCompra";
$myPage="vista_factura_compra_totales.php";
$myTitulo="Totales Factura Compras";



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
$Vector["EditarRegistro"]["Deshabilitado"]=1;        
//$Vector["VerRegistro"]["Deshabilitado"]=1; 


//Link para la accion ver
$Ruta="PDF_FCompra.php?ID=";
$Vector["VerRegistro"]["Link"]=$Ruta;
$Vector["VerRegistro"]["ColumnaLink"]="idFacturaCompra";
///Columnas excluidas

$Vector["Order"]=" $idTabla DESC ";   //Orden
?>