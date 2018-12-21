<?php

$myTabla="cartera";
$myPage="cartera.php";
$myTitulo="Cartera";
$idTabla="idCartera";


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
//$Vector["EditarRegistro"]["Deshabilitado"]=1;

// Nueva Accion
$Ruta="RegistrarIngreso.php?idFactura=";
$Vector["NuevaAccionLink"][1]="AsociarCoti";
$Vector["NuevaAccion"]["AsociarCoti"]["Titulo"]="Registrar Pago";
$Vector["NuevaAccion"]["AsociarCoti"]["Link"]=$Ruta;
$Vector["NuevaAccion"]["AsociarCoti"]["ColumnaLink"]="Facturas_idFacturas";
$Vector["NuevaAccion"]["AsociarCoti"]["Target"]="_self";

// Nueva Accion
$Ruta="../tcpdf/examples/imprimirFactura.php?ImgPrintFactura=";
$Vector["NuevaAccionLink"][0]="VerFactura";
$Vector["NuevaAccion"]["VerFactura"]["Titulo"]="Ver Factura";
$Vector["NuevaAccion"]["VerFactura"]["Link"]=$Ruta;
$Vector["NuevaAccion"]["VerFactura"]["ColumnaLink"]="Facturas_idFacturas";
$Vector["NuevaAccion"]["VerFactura"]["Target"]="_blank";
//Selecciono las Columnas que tendran valores de otras tablas
//
//
$Vector["Facturas_idFacturas"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["Facturas_idFacturas"]["TablaVinculo"]="facturas";  //tabla de donde se vincula
$Vector["Facturas_idFacturas"]["IDTabla"]="idFacturas"; //id de la tabla que se vincula
$Vector["Facturas_idFacturas"]["Display"]="NumeroFactura";                    //Columna que quiero mostrar
$Vector["Facturas_idFacturas"]["Predeterminado"]="N";


///Filtros y orden
$Vector["Order"]=" $idTabla DESC ";   //Orden
?>