<?php
$myPage="separados_items.php";
include_once("../sesiones/php_control.php");

////////// Paginacion
$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);

    	$limit = 10;
    	$startpoint = ($page * $limit) - $limit;
		
/////////


        
        
include_once ('funciones/function.php');  //En esta funcion está la paginacion

include_once("Configuraciones/separados_items.ini.php");  //Clases de donde se escribirán las tablas
$obTabla = new Tabla($db);

if(isset($_REQUEST["idSeparado"])){
    $idSeparado=$_REQUEST["idSeparado"];
    $DatosImpresora=$obVenta->DevuelveValores("config_puertos", "ID", 1);
    if($DatosImpresora["Habilitado"]=="SI"){
        $VectorCierre["idSeparado"]=$idSeparado;
       
        $obVenta->ImprimeSeparado($idSeparado, $DatosImpresora["Puerto"], 1);
        
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
$css->CreaMenuBasico("Menu"); 
            $css->CreaSubMenuBasico("Historial de Abonos","separados_abonos.php");
         $css->CierraMenuBasico(); 
///////////////Creamos el contenedor
    /////
    /////
$css->CrearDiv("principal", "container", "center",1,1);
$css->DivNotificacionesJS();
//print($statement);
///////////////Creamos la imagen representativa de la pagina
    /////
    /////	
$css->CrearImageLink("../VMenu/Menu.php", "../images/separados.png", "_self",200,200);


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