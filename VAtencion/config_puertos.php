<?php
$myPage="config_puertos.php";
include_once("../sesiones/php_control.php");
include_once("../modelo/PrintBarras.php");
////////// Paginacion
$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);

    	$limit = 10;
    	$startpoint = ($page * $limit) - $limit;
		
/////////


        
        
include_once ('funciones/function.php');  //En esta funcion está la paginacion

include_once("Configuraciones/config_puertos.ini.php");  //Clases de donde se escribirán las tablas
$obTabla = new Tabla($db);
$obPrintBarras = new Barras(1);
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
$DatosPuerto=$obPrintBarras->DevuelveValores("config_puertos", "ID", 2);
if(isset($_REQUEST["BtnGap"])){
    if($DatosPuerto["Habilitado"]=="SI"){
        $obPrintBarras->ConfigPrintMonarch(1, $DatosPuerto["Puerto"], "");
    }
}

if(isset($_REQUEST["BtnMarcaNegra"])){
    if($DatosPuerto["Habilitado"]=="SI"){
        $obPrintBarras->ConfigPrintMonarch(0, $DatosPuerto["Puerto"], "");
    }
}
$css->DivNotificacionesJS();
//print($statement);
///////////////Creamos la imagen representativa de la pagina
    /////
    /////	
$css->CrearImageLink("../VMenu/Menu.php", "../images/configuracion.png", "_self",200,200);

$css->CrearForm2("FrmConfigPapel", $myPage, "post", "_self");
    $css->CrearNotificacionVerde("Configurar tipo de papel", 16);
    $css->CrearBotonConfirmado("BtnGap", "GAP");
    print("<br><br>");
    $css->CrearBotonConfirmado("BtnMarcaNegra", "Marca Negra");
$css->CerrarForm();
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