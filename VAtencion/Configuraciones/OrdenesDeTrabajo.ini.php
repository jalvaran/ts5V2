<?php

$myTabla="ordenesdetrabajo";
$idTabla="ID";
$myPage="ordenesdetrabajo.php";
$myTitulo="Ordenes de Servicio";

/*
 * Opciones en Acciones
 * 
 */

//$Vector["NuevoRegistro"]["Deshabilitado"]=1;            
//$Vector["VerRegistro"]["Deshabilitado"]=1;                      
//$Vector["EditarRegistro"]["Deshabilitado"]=1; 

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
$Ruta="../tcpdf/examples/imprimirOT.php?idOT=";
$Vector["VerRegistro"]["Link"]=$Ruta;
$Vector["VerRegistro"]["ColumnaLink"]="ID";

$Vector["Excluir"]["Estado"]=1;
$Vector["Excluir"]["Hora"]=1;
$Vector["Excluir"]["idUsuarioCreador"]=1;
$Vector["Required"]["TipoOrden"]=1;

//Nueva Accion
$Ruta="AgregaItemsOT.php?idOT=";
$Vector["NuevaAccionLink"][0]="AsociarCoti";
$Vector["NuevaAccion"]["AsociarCoti"]["Titulo"]="Agregar Actividades";
$Vector["NuevaAccion"]["AsociarCoti"]["Link"]=$Ruta;
$Vector["NuevaAccion"]["AsociarCoti"]["ColumnaLink"]="ID";
$Vector["NuevaAccion"]["AsociarCoti"]["Target"]="_self";

/*
 * 
 * Selecciono las Columnas que tendran valores de otras tablas
 */


$Vector["idCliente"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["idCliente"]["TablaVinculo"]="clientes";  //tabla de donde se vincula
$Vector["idCliente"]["IDTabla"]="idClientes"; //id de la tabla que se vincula
$Vector["idCliente"]["Display"]="RazonSocial";                    //Columna que quiero mostrar

$Vector["idUsuarioCreador"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["idUsuarioCreador"]["TablaVinculo"]="usuarios";  //tabla de donde se vincula
$Vector["idUsuarioCreador"]["IDTabla"]="idUsuarios"; //id de la tabla que se vincula
$Vector["idUsuarioCreador"]["Display"]="Apellido";                    //Columna que quiero mostrar

$Vector["TipoOrden"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["TipoOrden"]["TablaVinculo"]="ordenesdetrabajo_tipo";  //tabla de donde se vincula
$Vector["TipoOrden"]["IDTabla"]="ID"; //id de la tabla que se vincula
$Vector["TipoOrden"]["Display"]="Tipo";                    //Columna que quiero mostrar

///Filtros y orden
$Vector["Order"]=" $idTabla DESC ";   //Orden
?>