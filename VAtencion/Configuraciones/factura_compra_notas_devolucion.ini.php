<?php

$myTabla="factura_compra_notas_devolucion";
$myPage="factura_compra_notas_devolucion.php";
$myTitulo="factura_compra_notas_devolucion";
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
          
//$Vector["VerRegistro"]["Deshabilitado"]=1;       
$Vector["NuevoRegistro"]["Deshabilitado"]=1;                                 
$Vector["EditarRegistro"]["Deshabilitado"]=1;

//Link para la accion ver
$Ruta="PDF_Documentos.php?idDocumento=31&idNotaDevolucion=";
$Vector["VerRegistro"]["Link"]=$Ruta;
$Vector["VerRegistro"]["ColumnaLink"]="ID";


// Nueva Accion
$Ruta="AnularNotaDevolucion.php?idNota=";
$Vector["NuevaAccionLink"][2]="Anular";
$Vector["NuevaAccion"]["Anular"]["Titulo"]="Anular";
$Vector["NuevaAccion"]["Anular"]["Link"]=$Ruta;
$Vector["NuevaAccion"]["Anular"]["ColumnaLink"]="ID";
$Vector["NuevaAccion"]["Anular"]["Target"]="_self";

///Filtros y orden
$Vector["Order"]=" $idTabla DESC ";   //Orden
?>