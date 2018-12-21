<?php
$obVenta = new ProcesoVenta($idUser);

$DatosEmpresa=$obVenta->DevuelveValores("empresapro", "idEmpresaPro", 1);
$myTabla="productosventa";
$myPage="productosventa.php";
$myTitulo="Productos Venta";



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
 
$Vector["ProductosVenta"]=1;
$Vector["NuevoRegistro"]["Deshabilitado"]=1;      
$Vector["VerRegistro"]["Deshabilitado"]=1;       

$Vector["Enabled_PrinterCB"]=1;  //Habilita la impresion de los codigos de barras
//$Vector["Enabled_PrinterLB"]=1;  //Habilita la impresion de los labels
$Vector["Enabled_PrinterCC"]=1;  //Habilita la impresion de los codigos cortos


///Columnas excluidas

$Vector["Excluir"]["ImagenesProductos_idImagenesProductos"]=1;   //Indico que esta columna no se mostrará
//$Vector["Excluir"]["Especial"]=1;
//$Vector["Excluir"]["PrecioMayorista"]=1;
//$Vector["Excluir"]["Kit"]=1;
///Columnas requeridas al momento de una insercion
$Vector["Required"]["Departamento"]=1;   
$Vector["Required"]["Nombre"]=1; 
$Vector["Required"]["PrecioVenta"]=1;
$Vector["Required"]["CostoUnitario"]=1;
$Vector["Required"]["CostoTotal"]=1;
$Vector["Required"]["IVA"]=1;
$Vector["Required"]["Bodega_idBodega"]=1;
$Vector["Required"]["CuentaPUC"]=1;

//
//Nuevo link dentro de una columna
/*
$RutaNewLink="procesadores/ProcesadorAgregaKits.php?Tabla=productosventa&IDProducto=";
$Vector["Kit"]["NewLink"]=$RutaNewLink;
$Vector["Kit"]["NewLinkTitle"]="Agregar a Kit";
$Vector["Kit"]["Page"]="productosventa.php";
$Vector["NewText"]["Kit"]="TxtCantidad";
*/
//Selecciono las Columnas que tendran valores de otras tablas
//
//
$Vector["CodigoBarras"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["CodigoBarras"]["TablaVinculo"]="prod_codbarras";  //tabla de donde se vincula
$Vector["CodigoBarras"]["IDTabla"]="ProductosVenta_idProductosVenta"; //id de la tabla que se vincula
$Vector["CodigoBarras"]["Display"]="CodigoBarras";                    //Columna que quiero mostrar
$Vector["CodigoBarras"]["Predeterminado"]="N";

$Vector["IVA"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["IVA"]["TablaVinculo"]="porcentajes_iva";  //tabla de donde se vincula
$Vector["IVA"]["IDTabla"]="Valor"; //id de la tabla que se vincula
$Vector["IVA"]["Display"]="Nombre"; 
$Vector["IVA"]["Predeterminado"]=0;

$Vector["Bodega_idBodega"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["Bodega_idBodega"]["TablaVinculo"]="bodega";  //tabla de donde se vincula
$Vector["Bodega_idBodega"]["IDTabla"]="idBodega"; //id de la tabla que se vincula
$Vector["Bodega_idBodega"]["Display"]="Nombre";                    //Columna que quiero mostrar
$Vector["Bodega_idBodega"]["Predeterminado"]=1;

$Vector["Departamento"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["Departamento"]["TablaVinculo"]="prod_departamentos";  //tabla de donde se vincula
$Vector["Departamento"]["IDTabla"]="idDepartamentos"; //id de la tabla que se vincula
$Vector["Departamento"]["Display"]="Nombre";                    //Columna que quiero mostrar
$Vector["Departamento"]["Predeterminado"]="N";

$Vector["Sub1"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["Sub1"]["TablaVinculo"]="prod_sub1";  //tabla de donde se vincula
$Vector["Sub1"]["IDTabla"]="idSub1"; //id de la tabla que se vincula
$Vector["Sub1"]["Display"]="NombreSub1";                    //Columna que quiero mostrar

$Vector["Sub2"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["Sub2"]["TablaVinculo"]="prod_sub2";  //tabla de donde se vincula
$Vector["Sub2"]["IDTabla"]="idSub2"; //id de la tabla que se vincula
$Vector["Sub2"]["Display"]="NombreSub2";                    //Columna que quiero mostrar

$Vector["Sub3"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["Sub3"]["TablaVinculo"]="prod_sub3";  //tabla de donde se vincula
$Vector["Sub3"]["IDTabla"]="idSub3"; //id de la tabla que se vincula
$Vector["Sub3"]["Display"]="NombreSub3";                    //Columna que quiero mostrar

$Vector["Sub4"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["Sub4"]["TablaVinculo"]="prod_sub4";  //tabla de donde se vincula
$Vector["Sub4"]["IDTabla"]="idSub4"; //id de la tabla que se vincula
$Vector["Sub4"]["Display"]="NombreSub4";                    //Columna que quiero mostrar
//
$Vector["Sub6"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["Sub6"]["TablaVinculo"]="prod_sub6";  //tabla de donde se vincula
$Vector["Sub6"]["IDTabla"]="idSub6"; //id de la tabla que se vincula
$Vector["Sub6"]["Display"]="NombreSub6";                    //Columna que quiero mostrar
//
$Vector["Sub5"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["Sub5"]["TablaVinculo"]="prod_sub5";  //tabla de donde se vincula
$Vector["Sub5"]["IDTabla"]="idSub5"; //id de la tabla que se vincula
$Vector["Sub5"]["Display"]="NombreSub5";                    //Columna que quiero mostrar
///Filtros y orden
if($DatosEmpresa["Regimen"]=="COMUN"){
    $Vector["IVA"]["Predeterminado"]='0.19';
}else{
    $Vector["IVA"]["Predeterminado"]='0';
}
//$Vector["RutaImagen"]["Link"]=1;   //Indico que esta columna tendra un vinculo
$Vector["Order"]=" idProductosVenta DESC ";   //Orden
?>