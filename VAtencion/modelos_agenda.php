<?php
$myPage="modelos_agenda.php";
include_once("../sesiones/php_control.php");
include_once("../modelo/PrintPos.php");	
$obPrint=new PrintPos($idUser);
////////// Paginacion
$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);

    	$limit = 10;
    	$startpoint = ($page * $limit) - $limit;
		
/////////


        
        
include_once ('funciones/function.php');  //En esta funcion está la paginacion

include_once("Configuraciones/modelos_agenda.ini.php");  //Clases de donde se escribirán las tablas
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
$obVenta=new ProcesoVenta($idUser);
///////////////Creamos el contenedor
    /////
    /////
$css->CrearDiv("principal", "container", "center",1,1);

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
$Consulta=$obVenta->Query("SELECT SUM(ValorPagado) as Total, COUNT(*) as TotalServicios, "
        .           "SUM(ValorModelo) as TotalModelo,SUM(ValorCasa) as TotalCasa FROM $statement");
$DatosConsulta=$obVenta->FetchArray($Consulta);
$TotalServicios=  number_format($DatosConsulta["TotalServicios"]);
$Total=  number_format($DatosConsulta["Total"]);
$TotalModelo=  number_format($DatosConsulta["TotalModelo"]);
$TotalCasa=  number_format($DatosConsulta["TotalCasa"]);
$css->CrearNotificacionVerde("Datos incluyendo servicios Anulados <br> Cantidad de servicios: $TotalServicios //Total Modelos: $TotalModelo // Total Casa: $TotalCasa // Gran Total: $Total", 16);

$obTabla->DibujeTabla($Vector);
$css->CerrarDiv();//Cerramos contenedor Principal

$css->Footer();
$css->AgregaJS(); //Agregamos javascripts
//$css->AgregaSubir();    
////Fin HTML  
print("</body></html>");


?>