<?php

$myTabla="documentos_contables_control";
$idTabla="ID";
$myPage="documentos_contables_control.php";
$myTitulo="Historial Documentos Contables";

/*
 * Opciones en Acciones
 * 
 */

$Vector["NuevoRegistro"]["Deshabilitado"]=1;            
//$Vector["VerRegistro"]["Deshabilitado"]=1;                      
//$Vector["EditarRegistro"]["Deshabilitado"]=1; 

/////Asigno Datos necesarios para la visualizacion de la tabla en el formato que se desea
////
///
//print($statement);

//Link para la accion ver
$Ruta="PDF_Documentos.php?idDocumento=32&idDocumentoContable=";
$Vector["VerRegistro"]["Link"]=$Ruta;
$Vector["VerRegistro"]["ColumnaLink"]="ID";

$Vector["idDocumento"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["idDocumento"]["TablaVinculo"]="documentos_contables";  //tabla de donde se vincula
$Vector["idDocumento"]["IDTabla"]="ID"; //id de la tabla que se vincula
$Vector["idDocumento"]["Display"]="Nombre"; 
$Vector["idDocumento"]["Predeterminado"]=1;


// Nueva Accion
$Ruta="AnularDocumentoContable.php?idDocumentoContable=";
$Vector["NuevaAccionLink"][1]="Anular";
$Vector["NuevaAccion"]["Anular"]["Titulo"]="Anular";
$Vector["NuevaAccion"]["Anular"]["Link"]=$Ruta;
$Vector["NuevaAccion"]["Anular"]["ColumnaLink"]="ID";
$Vector["NuevaAccion"]["Anular"]["Target"]="_self";

$Vector["Tabla"]=$myTabla;          //Tabla
$Vector["Titulo"]=$myTitulo;        //Titulo
$Vector["VerDesde"]=$startpoint;    //Punto desde donde empieza
$Vector["Limit"]=$limit;            //Numero de Registros a mostrar
$Vector["MyPage"]=$myPage;            //pagina
///Columnas excluidas


///Filtros y orden
$Vector["Order"]=" $idTabla DESC ";   //Orden
?>