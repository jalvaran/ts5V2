<?php
$myPage="cuentasxpagar.php";
include_once("../sesiones/php_control.php");

////////// Paginacion
$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);

    	$limit = 10;
    	$startpoint = ($page * $limit) - $limit;
		
/////////


        
        
include_once ('funciones/function.php');  //En esta funcion está la paginacion

include_once("Configuraciones/cuentasxpagar.ini.php");  //Clases de donde se escribirán las tablas
$obTabla = new Tabla($db);
$Tabla=$Vector["Tabla"];
$statement = $obTabla->CreeFiltro($Vector);
if($statement==" $Tabla"){
    $statement.=" WHERE Saldo > 0 ";
    
}else{
    $statement.=" AND Saldo > 0 ";
}
$Vector["statement"]=$statement;   //Filtro necesario para la paginacion


$obTabla->VerifiqueExport($Vector);
//print("<pre>$statement</pre>");
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
include_once("procesadores/cuentasxpagar.process.php");  //Procesador
if(!empty($_REQUEST["TxtidIngreso"])){
        $RutaPrintIngreso="../tcpdf/examples/imprimiringreso.php?ImgPrintIngreso=".$_REQUEST["TxtidIngreso"];			
        $css->CrearTabla();
        $css->CrearFilaNotificacion("Comprobante de Ingreso Creado Correctamente <a href='$RutaPrintIngreso' target='_blank'>Imprimir Comprobante de Ingreso No. $_REQUEST[TxtidIngreso]</a>",16);
        $css->CerrarTabla();
    }

//print($statement);
///////////////Creamos la imagen representativa de la pagina
    /////
    /////	


$PromedioDias=$obVenta->ActualiceDiasCuentasXPagar();
$TotalCuentas=  number_format($obVenta->Sume("cuentasxpagar", "Saldo","$statement"));

$css->CrearNotificacionAzul("Total Cuentas X Pagar: $ $TotalCuentas", 16);

if($PromedioDias>30){
    $css->CrearNotificacionRoja("Promedio de Dias : $PromedioDias", 16);
}else{
    $css->CrearNotificacionVerde("Promedio de Dias : $PromedioDias", 16);
}

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
$css->CrearDiv("DivPreEgreso","container", "left", 1, 1);
include_once 'Consultas/DatosPreEgresos.php';
$css->CerrarDiv();//Cerramos contenedor Principal
$css->Footer();
$css->AgregaJS(); //Agregamos javascripts
//$css->AgregaSubir();    
////Fin HTML  
print("</body></html>");

ob_end_flush();
?>