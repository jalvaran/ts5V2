<?php
$myPage="productosventa.php";
include_once("../sesiones/php_control.php");
$Diana=0;  //Exclusivo Diana Carvajal, habilita con 1 la impresion de un label de importacion
////////// Paginacion
$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);

	$limit = 10;
	$startpoint = ($page * $limit) - $limit;
		
/////////


        
        
include_once ('funciones/function.php');  //En esta funcion está la paginacion

include_once("Configuraciones/ProductosVenta.ini.php");  //Clases de donde se escribirán las tablas
include_once("procesadores/procesaProductosVenta.php");  //Clases de donde se escribirán las tablas
$obTabla = new Tabla($db);
$obVenta=new ProcesoVenta($idUser);
$statement = $obTabla->CreeFiltro($Vector);
//print($statement);
$Vector["statement"]=$statement;   //Filtro necesario para la paginacion


$obTabla->VerifiqueExport($Vector);

include_once("css_construct.php");
print("<html>");
print("<head>");

$css =  new CssIni($myTitulo);
print("</head>");
print("<body>");
//Cabecera
$css->CabeceraIni($myTitulo); //Inicia la cabecera de la pagina
$css->CabeceraFin(); 

///////////////Creamos el contenedor
    /////
    /////
$css->CrearDiv("principal", "container", "center",1,1);

$css->DivNotificacionesJS();

//print($statement);
///////////////Creamos la imagen representativa de la pagina
    /////
    /////	
$css->CrearImageLink("CrearProductoVenta.php", "../images/agregar.png", "_self",200,200);

////Paginacion
////
$Ruta="";
print("<div style='height: 50px;'>");   //Dentro de un DIV para no hacerlo tan grande
print(pagination($Ruta,$statement,$limit,$page));
print("</div>");
if($Diana==1){
    print("<br>");
    $RutaPrint="ProcesadoresJS/PrintCodigoBarras.php?TipoCodigo=5&idProducto=Import&TxtCantidad=";
    $css->CrearInputNumber("TxtCantidadImport", "number", "Cantidad", 1, "Cantidad", "black", "", "", 100, 30, 0, 0, 1, "", 1);
    print("<br>");
    $css->CrearBotonEvento("BtnPrintImport", "Imprimir label import", 1, "onclick", "EnvieObjetoConsulta(`$RutaPrint`,`TxtCantidadImport`,`DivRespuestasJS`,`0`)", "verde", "");
    $RutaPrint="ProcesadoresJS/PrintCodigoBarras.php?TipoCodigo=6&idProducto=Import&TxtCantidad=";
    
    $css->CrearBotonEvento("BtnPrintZapatos", "Imprimir label import", 1, "onclick", "EnvieObjetoConsulta(`$RutaPrint`,`TxtCantidadImport`,`DivRespuestasJS`,`0`)", "naranja", "");

    
}
////
///Dibujo la tabla
////
///
if($_SESSION["tipouser"]=="administrador"){
    $sql="SELECT SUM(Existencias) as Items, SUM(CostoTotal) as Costo FROM $statement";
    $Consulta=$obVenta->Query($sql);
    $DatosInventario=$obVenta->FetchArray($Consulta);
    $css->CrearNotificacionVerde("Total Items: ".number_format($DatosInventario["Items"])."; Costo Total: $".number_format($DatosInventario["Costo"]), 16);
}
$obTabla->DibujeTabla($Vector);
$css->CerrarDiv();//Cerramos contenedor Principal
$css->Footer();
$css->AgregaJS(); //Agregamos javascripts
//$css->AgregaSubir();    
////Fin HTML  
print("</body></html>");

ob_end_flush();
?>