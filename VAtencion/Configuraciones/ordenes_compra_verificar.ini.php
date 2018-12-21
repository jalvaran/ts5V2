<?php

$myTabla="ordenesdecompra";
$idTabla="ID";
$myPage="ordenes_compra_verificar.php";
$myTitulo="Ordenes de Compra X Verficar";

/*
 * Opciones en Acciones
 * 
 */

$Vector["NuevoRegistro"]["Deshabilitado"]=1;            
//$Vector["VerRegistro"]["Deshabilitado"]=1;                      
$Vector["EditarRegistro"]["Deshabilitado"]=1; 

/////Asigno Datos necesarios para la visualizacion de la tabla en el formato que se desea
////
///
//print($statement);
$Vector["Tabla"]=$myTabla;          //Tabla
$Vector["Titulo"]=$myTitulo;        //Titulo
$Vector["VerDesde"]=$startpoint;    //Punto desde donde empieza
$Vector["Limit"]=$limit;            //Numero de Registros a mostrar
$Vector["MyPage"]=$myPage;            //pagina
///Columnas excluidas

//Link para la accion ver
$Ruta="../tcpdf/examples/imprimirOC.php?idOT=";
$Vector["VerRegistro"]["Link"]=$Ruta;
$Vector["VerRegistro"]["ColumnaLink"]="ID";



//Nueva Accion
$Ruta="VerificarOrdenCompra.php?idOrden=";
$Vector["NuevaAccionLink"][0]="Verificar";
$Vector["NuevaAccion"]["Verificar"]["Titulo"]="Verificar";
$Vector["NuevaAccion"]["Verificar"]["Link"]=$Ruta;
$Vector["NuevaAccion"]["Verificar"]["ColumnaLink"]="ID";
$Vector["NuevaAccion"]["Verificar"]["Target"]="_blank";

/*
 * 
 * Selecciono las Columnas que tendran valores de otras tablas
 */


$Vector["Tercero"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["Tercero"]["TablaVinculo"]="proveedores";  //tabla de donde se vincula
$Vector["Tercero"]["IDTabla"]="idProveedores"; //id de la tabla que se vincula
$Vector["Tercero"]["Display"]="RazonSocial";                    //Columna que quiero mostrar

$Vector["UsuarioCreador"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["UsuarioCreador"]["TablaVinculo"]="usuarios";  //tabla de donde se vincula
$Vector["UsuarioCreador"]["IDTabla"]="idUsuarios"; //id de la tabla que se vincula
$Vector["UsuarioCreador"]["Display"]="Apellido";                    //Columna que quiero mostrar
//
///Filtros y orden
$Vector["Order"]=" $idTabla DESC ";   //Orden
?>