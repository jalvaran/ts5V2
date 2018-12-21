<?php

$myTabla="vista_titulos_comisiones";
$myPage="titulos_comisiones.php";
$myTitulo="Comisiones X Pagar";
$idTabla="ID";
$Vector["MyPage"]=$myPage;

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
          
//$Vector["VerRegistro"]["Deshabilitado"]=1;       
$Vector["NuevoRegistro"]["Deshabilitado"]=1;                                 
$Vector["EditarRegistro"]["Deshabilitado"]=1;

//Link para la accion ver
$Ruta="../tcpdf/examples/imprimircomp.php?ImgPrintComp=";
$Vector["VerRegistro"]["Link"]=$Ruta;
$Vector["VerRegistro"]["ColumnaLink"]="idEgreso";
//Selecciono las Columnas que tendran valores de otras tablas
//
//

// Nueva Accion
$Ruta="anular_pago_comision.php?idPagoCom=";
$Vector["NuevaAccionLink"][0]="AnulaComi";
$Vector["NuevaAccion"]["AnulaComi"]["Titulo"]=" Anular ";
$Vector["NuevaAccion"]["AnulaComi"]["Link"]=$Ruta;
$Vector["NuevaAccion"]["AnulaComi"]["ColumnaLink"]="ID";
$Vector["NuevaAccion"]["AnulaComi"]["Target"]="_self";

///Filtros y orden
$Vector["Order"]=" $idTabla DESC ";   //Orden
?>