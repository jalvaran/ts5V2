<?php
$obVenta = new ProcesoVenta($idUser);
$DatosEmpresa=$obVenta->DevuelveValores("empresapro", "idEmpresaPro", 1);
$myTabla="sistemas";
$idTabla="ID";
$myPage="sistemas.php";
$myTitulo="Sistemas";

/*
 * Opciones en Acciones
 * 
 */
$Vector["ProductosVenta"]=1;
$Vector["PrinterCB_Sistemas"]=1;
$Vector["NuevoRegistro"]["Deshabilitado"]=1;            
$Vector["VerRegistro"]["Deshabilitado"]=1;                      
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


///Filtros y orden
$Vector["Order"]=" $idTabla DESC ";   //Orden
?>