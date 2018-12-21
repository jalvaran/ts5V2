<?php

$myTabla="proveedores";
$idTabla="idProveedores";
$myPage="proveedores.php";
$myTitulo="Proveedores";



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
///Columnas excluidas

$Vector["Cod_Dpto"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["Cod_Dpto"]["TablaVinculo"]="cod_municipios_dptos";  //tabla de donde se vincula
$Vector["Cod_Dpto"]["IDTabla"]="Cod_Dpto"; //id de la tabla que se vincula
$Vector["Cod_Dpto"]["Display"]="Departamento";//Columna que quiero mostrar
$Vector["Cod_Dpto"]["Predeterminado"]="76";

//$Vector["Excluir"]["Cod_Mcipio"]=1;
$Vector["Cod_Mcipio"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["Cod_Mcipio"]["TablaVinculo"]="cod_municipios_dptos";  //tabla de donde se vincula
$Vector["Cod_Mcipio"]["IDTabla"]="Cod_mcipio"; //id de la tabla que se vincula
$Vector["Cod_Mcipio"]["Display"]="Ciudad"; 
$Vector["Cod_Mcipio"]["Predeterminado"]="";

$Vector["Pais_Domicilio"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["Pais_Domicilio"]["TablaVinculo"]="cod_paises";  //tabla de donde se vincula
$Vector["Pais_Domicilio"]["IDTabla"]="Codigo"; //id de la tabla que se vincula
$Vector["Pais_Domicilio"]["Display"]="Pais"; 
$Vector["Pais_Domicilio"]["Predeterminado"]="169";

$Vector["Tipo_Documento"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["Tipo_Documento"]["TablaVinculo"]="cod_documentos";  //tabla de donde se vincula
$Vector["Tipo_Documento"]["IDTabla"]="Codigo"; //id de la tabla que se vincula
$Vector["Tipo_Documento"]["Display"]="Descripcion"; 
//$Vector["Cod_Dpto"]["Predeterminado"]=1004;
$Vector["Soporte"]["Link"]=1;   //Indico que esta columna tendra un vinculo
///Filtros y orden
$Vector["Order"]=" $idTabla DESC ";   //Orden
?>