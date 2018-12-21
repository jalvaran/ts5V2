<?php

$myTabla="ordenesdecompra";
$idTabla="ID";
$myPage="ordenesdecompra.php";
$myTitulo="Ordenes de Compra";

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
$Ruta="CrearOrdenCompra.php?AbrirOrden=";
$Vector["NuevaAccionLink"][0]="Editar";
$Vector["NuevaAccion"]["Editar"]["Titulo"]="Editar";
$Vector["NuevaAccion"]["Editar"]["Link"]=$Ruta;
$Vector["NuevaAccion"]["Editar"]["ColumnaLink"]="ID";
$Vector["NuevaAccion"]["Editar"]["Target"]="_blank";


//Nueva Accion
$Ruta="CrearCompraDesdeOrden.php?idOrden=";
$Vector["NuevaAccionLink"][1]="CrearCompra";
$Vector["NuevaAccion"]["CrearCompra"]["Titulo"]="Crear Compra";
$Vector["NuevaAccion"]["CrearCompra"]["Link"]=$Ruta;
$Vector["NuevaAccion"]["CrearCompra"]["ColumnaLink"]="ID";
$Vector["NuevaAccion"]["CrearCompra"]["Target"]="_blank";

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