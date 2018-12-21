<?php
session_start();
if (!isset($_SESSION['username']))
{
  exit("No se ha iniciado una sesion <a href='../index.php' >Iniciar Sesion </a>");
  
}

////////// Paginacion
$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);

    	$limit = 10;
    	$startpoint = ($page * $limit) - $limit;
		
/////////


        
        
include_once ('funciones/function.php');  //En esta funcion está la paginacion

include_once("../modelo/php_tablas.php");  //Clases de donde se escribirán las tablas

$obTabla = new Tabla($db);
$obVenta = new ProcesoVenta(1);

include_once("css_construct.php");
print("<html>");
print("<head>");

$myTitulo="Cuadro de Busqueda";
$css =  new CssIni($myTitulo);
print("</head>");
print("<body>");

$css->CrearDiv("principal", "container", "center",1,1);
if(isset($_REQUEST["TxtBusqueda"])){
    $key=$_REQUEST["TxtBusqueda"];
    $PageReturn=$_REQUEST["TxtPageReturn"];
    $Variable="";
    $obTabla->DibujeItemsBuscadosVentas($key,$PageReturn,$Variable);
}else{
    $css->CrearNotificacionAzul("Digite un dato a buscar", 18);
}

$css->CerrarDiv();//Cerramos contenedor Principal


$css->AgregaJS(); //Agregamos javascripts
//$css->Footer(); 
//$css->AgregaSubir();    
////Fin HTML  
print("</body></html>");


?>