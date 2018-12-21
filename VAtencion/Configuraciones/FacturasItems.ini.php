<?php

$myTabla="facturas_items";
$MyID="ID";
$myPage="facturas_items.php";
$myTitulo="Items Facturados";



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
//$Vector["VerRegistro"]["Deshabilitado"]=1;                      
$Vector["EditarRegistro"]["Deshabilitado"]=1;  


//Link para la accion ver
$Ruta="../tcpdf/examples/imprimirFactura.php?ImgPrintFactura=";
$Vector["VerRegistro"]["Link"]=$Ruta;
$Vector["VerRegistro"]["ColumnaLink"]="idFactura";

/*
 * 
 * Selecciono las Columnas que tendran valores de otras tablas
 */


$Vector["Departamento"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["Departamento"]["TablaVinculo"]="prod_departamentos";  //tabla de donde se vincula
$Vector["Departamento"]["IDTabla"]="idDepartamentos"; //id de la tabla que se vincula
$Vector["Departamento"]["Display"]="Nombre";                    //Columna que quiero mostrar
$Vector["Departamento"]["Predeterminado"]="N";

$Vector["SubGrupo1"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["SubGrupo1"]["TablaVinculo"]="prod_sub1";  //tabla de donde se vincula
$Vector["SubGrupo1"]["IDTabla"]="idSub1"; //id de la tabla que se vincula
$Vector["SubGrupo1"]["Display"]="NombreSub1";                    //Columna que quiero mostrar

$Vector["SubGrupo2"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["SubGrupo2"]["TablaVinculo"]="prod_sub2";  //tabla de donde se vincula
$Vector["SubGrupo2"]["IDTabla"]="idSub2"; //id de la tabla que se vincula
$Vector["SubGrupo2"]["Display"]="NombreSub2";                    //Columna que quiero mostrar

$Vector["SubGrupo3"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["SubGrupo3"]["TablaVinculo"]="prod_sub3";  //tabla de donde se vincula
$Vector["SubGrupo3"]["IDTabla"]="idSub3"; //id de la tabla que se vincula
$Vector["SubGrupo3"]["Display"]="NombreSub3";                    //Columna que quiero mostrar

$Vector["SubGrupo4"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["SubGrupo4"]["TablaVinculo"]="prod_sub4";  //tabla de donde se vincula
$Vector["SubGrupo4"]["IDTabla"]="idSub4"; //id de la tabla que se vincula
$Vector["SubGrupo4"]["Display"]="NombreSub4";                    //Columna que quiero mostrar
//
$Vector["SubGrupo5"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["SubGrupo5"]["TablaVinculo"]="prod_sub5";  //tabla de donde se vincula
$Vector["SubGrupo5"]["IDTabla"]="idSub5"; //id de la tabla que se vincula
$Vector["SubGrupo5"]["Display"]="NombreSub5";                    //Columna que quiero mostrar
///Filtros y orden
$Vector["Order"]=" $MyID DESC ";   //Orden
?>