<?php

$myTabla="comprobantes_contabilidad_items";
$MyID="ID";
$myPage="comprobantes_contabilidad_items.php";
$myTitulo="Comprobantes de Contabilidad";



/////Asigno Datos necesarios para la visualizacion de la tabla en el formato que se desea
////
///
//print($statement);
$Vector["Tabla"]=$myTabla;          //Tabla
$Vector["Titulo"]=$myTitulo;        //Titulo
$Vector["VerDesde"]=$startpoint;    //Punto desde donde empieza
$Vector["Limit"]=$limit;            //Numero de Registros a mostrar

/*
 * Opciones en Acciones
 * 
 */

$Vector["NuevoRegistro"]["Deshabilitado"]=1;            
//$Vector["VerRegistro"]["Deshabilitado"]=1;                      
$Vector["EditarRegistro"]["Deshabilitado"]=1; 

//Link para la accion ver
$Ruta="../tcpdf/examples/comprobantecontable.php?idComprobante=";
$Vector["VerRegistro"]["Link"]=$Ruta;
$Vector["VerRegistro"]["ColumnaLink"]="idComprobante";


// Nueva Accion
$Ruta="AbrirDocumento.php?Doc=CC&idDoc=";
$Vector["NuevaAccionLink"][1]="Abrir";
$Vector["NuevaAccion"]["Abrir"]["Titulo"]="Abrir Documento";
$Vector["NuevaAccion"]["Abrir"]["Link"]=$Ruta;
$Vector["NuevaAccion"]["Abrir"]["ColumnaLink"]="idComprobante";
$Vector["NuevaAccion"]["Abrir"]["Target"]="_self";
/*
 * 
 * Selecciono las Columnas que tendran valores de otras tablas
 */



$Vector["idCliente"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["idCliente"]["TablaVinculo"]="clientes";  //tabla de donde se vincula
$Vector["idCliente"]["IDTabla"]="idClientes"; //id de la tabla que se vincula
$Vector["idCliente"]["Display"]="RazonSocial"; 
$Vector["idCliente"]["Predeterminado"]=0;

$Vector["Soporte"]["Link"]=1;   //Indico que esta columna tendra un vinculo


$Vector["Excluir"]["ID"]=1;

///Filtros y orden
$Vector["Order"]=" $MyID DESC ";   //Orden
?>