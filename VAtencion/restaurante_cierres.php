<?php
$myPage="restaurante_cierres.php";
include_once("../sesiones/php_control.php");
include_once("../modelo/PrintPos.php");	
$obPrint=new PrintPos($idUser);

////////// Paginacion
$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);

    	$limit = 10;
    	$startpoint = ($page * $limit) - $limit;
		
/////////


        
        
include_once ('funciones/function.php');  //En esta funcion está la paginacion

include_once("Configuraciones/restaurante_cierres.ini.php");  //Clases de donde se escribirán las tablas
$obTabla = new Tabla($db);

if(isset($_REQUEST["idCierre"])){
    $idCierre=$_REQUEST["idCierre"];
    $DatosImpresora=$obVenta->DevuelveValores("config_puertos", "ID", 1);
    if($DatosImpresora["Habilitado"]=="SI"){
        $VectorCierre["idCierre"]=$idCierre;
        $obPrint->ImprimirCierreRestaurante($idCierre,$DatosImpresora["Puerto"],1,"");
        
    }
}

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
$sql="SELECT SUM(PedidosFacturados) as PedidosFacturados,SUM(PedidosDescartados) as PedidosDescartados,SUM(DomiciliosFacturados) as DomiciliosFacturados,"
        . "SUM(DomiciliosDescartados) as DomiciliosDescartados, SUM(ParaLlevarFacturado) as ParaLlevarFacturado,"
        . "SUM(ParaLlevarDescartado) as ParaLlevarDescartado FROM $statement ";
$consulta=$obVenta->Query($sql);
$DatosPedidos=$obVenta->FetchArray($consulta);
$css->CrearNotificacionNaranja("Total Pedidos Facturados= ".number_format($DatosPedidos["PedidosFacturados"]).", Total Pedidos Descartados= ".number_format($DatosPedidos["PedidosDescartados"]), 16);
$css->CrearNotificacionRoja("Total Domicilios Facturados= ".number_format($DatosPedidos["DomiciliosFacturados"]).", Total Domicilios Descartados= ".number_format($DatosPedidos["DomiciliosDescartados"]), 16);
$css->CrearNotificacionVerde("Total Para Llevar Facturados= ".number_format($DatosPedidos["ParaLlevarFacturado"]).", Total Pedidos Descartados= ".number_format($DatosPedidos["ParaLlevarDescartado"]), 16);


////Paginacion
////
$Ruta="";
print("<div style='height: 50px;'>");   //Dentro de un DIV para no hacerlo tan grande
print(pagination($Ruta,$statement,$limit,$page));
print("</div>");
////
///Dibujo la tabla
////
///

$obTabla->DibujeTabla($Vector);
$css->CerrarDiv();//Cerramos contenedor Principal
$css->Footer();
$css->AgregaJS(); //Agregamos javascripts
//$css->AgregaSubir();    
////Fin HTML  
print("</body></html>");


?>