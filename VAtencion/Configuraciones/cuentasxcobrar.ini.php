<?php

$myTabla="librodiario";
$idTabla="Fecha";
$myPage="CuentasXCobrar.php";
$myTitulo="Cuentas X Cobrar";



/////Asigno Datos necesarios para la visualizacion de la tabla en el formato que se desea
////
///
//print($statement);
$Vector["Tabla"]=$myTabla;          //Tabla
$Vector["Titulo"]=$myTitulo;        //Titulo
$Vector["VerDesde"]=$startpoint;    //Punto desde donde empieza
$Vector["Limit"]=$limit;            //Numero de Registros a mostrar
$Vector["MyPage"]=$myPage;            //Numero de Registros a mostrar

/*
 * Deshabilito Acciones
 * 
 */

        
$Vector["VerRegistro"]["Deshabilitado"]=1; 
$Vector["EditarRegistro"]["Deshabilitado"]=1; 
$Vector["NuevoRegistro"]["Deshabilitado"]=1;  

$Ruta=$myPage;
$Vector["NuevaAccionLink"][0]="ChkID";
$Vector["NuevaAccion"]["ChkID"]["Titulo"]="Sel";
$Vector["NuevaAccion"]["ChkID"]["Link"]=$Ruta;
$Vector["NuevaAccion"]["ChkID"]["ColumnaLink"]="idLibroDiario";
$Vector["NuevaAccion"]["ChkID"]["Target"]="_self";

/*
 * Datos vinculados
 * 
 */


//$Vector["Excluir"]["idLibroDiario"]=1;
$Vector["Excluir"]["Tercero_Tipo_Documento"]=1;
$Vector["Excluir"]["Tercero_DV"]=1;
$Vector["Excluir"]["Tercero_Primer_Apellido"]=1;
$Vector["Excluir"]["Tercero_Segundo_Apellido"]=1;
$Vector["Excluir"]["Tercero_Primer_Nombre"]=1;
$Vector["Excluir"]["Tercero_Otros_Nombres"]=1;
$Vector["Excluir"]["Tercero_Direccion"]=1;
$Vector["Excluir"]["Tercero_Cod_Dpto"]=1;
$Vector["Excluir"]["Tercero_Cod_Mcipio"]=1;

$Vector["Excluir"]["Tercero_Pais_Domicilio"]=1;
$Vector["Excluir"]["Mayor"]=1;
$Vector["Excluir"]["Esp"]=1;
$Vector["Excluir"]["idCentroCosto"]=1;
$Vector["Excluir"]["idEmpresa"]=1;

$Vector["Excluir"]["Debito"]=1;
$Vector["Excluir"]["Credito"]=1;
$Vector["Excluir"]["Estado"]=1;

$Vector["idCentroCosto"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["idCentroCosto"]["TablaVinculo"]="centrocosto";  //tabla de donde se vincula
$Vector["idCentroCosto"]["IDTabla"]="ID"; //id de la tabla que se vincula
$Vector["idCentroCosto"]["Display"]="Nombre"; 
$Vector["idCentroCosto"]["Predeterminado"]=1;

$Vector["idEmpresa"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["idEmpresa"]["TablaVinculo"]="empresapro";  //tabla de donde se vincula
$Vector["idEmpresa"]["IDTabla"]="idEmpresaPro"; //id de la tabla que se vincula
$Vector["idEmpresa"]["Display"]="RazonSocial"; 
$Vector["idEmpresa"]["Predeterminado"]=1;

///Filtros y orden
$Vector["Order"]=" $idTabla ASC ";   //Orden
?>