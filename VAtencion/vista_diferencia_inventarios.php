<?php
$myPage="vista_diferencia_inventarios.php";
include_once("../sesiones/php_control.php");
////////// Paginacion
$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);

    	$limit = 10;
    	$startpoint = ($page * $limit) - $limit;
		
/////////


        
        
include_once ('funciones/function.php');  //En esta funcion está la paginacion

include_once("Configuraciones/vista_diferencia_inventarios.ini.php");  //Clases de donde se escribirán las tablas
$obTabla = new Tabla($db);


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
//print($statement);
///////////////Creamos la imagen representativa de la pagina
    /////
    /////	
//$css->CrearImageLink("../VMenu/Menu.php", "../images/cajas.png", "_self",200,200);


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
$Consulta=$obVenta->Query("SELECT SUM(TotalCostosDiferencia) as Total, COUNT(*) as TotalItems FROM $statement");
$DatosConsulta=$obVenta->FetchArray($Consulta);
$TotalItems=  number_format($DatosConsulta["TotalItems"]);
$TotalCostos=  number_format($DatosConsulta["Total"]);
$css->CrearNotificacionVerde("El total de items con diferencias son: $TotalItems, con un costo Total de: $TotalCostos", 16);
$obTabla->DibujeTabla($Vector);
$css->CerrarDiv();//Cerramos contenedor Principal

$css->Footer();
$css->AgregaJS(); //Agregamos javascripts
//$css->AgregaSubir();    
////Fin HTML  
print("</body></html>");


?>