<?php
$myPage="cartera.php";
include_once("../sesiones/php_control.php");
$Restaurar=1;
////////// Paginacion
$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);

    	$limit = 10;
    	$startpoint = ($page * $limit) - $limit;
		
/////////


        
        
include_once ('funciones/function.php');  //En esta funcion está la paginacion

include_once("Configuraciones/Cartera.ini.php");  //Clases de donde se escribirán las tablas
$obTabla = new Tabla($db);

$statement = $obTabla->CreeFiltro($Vector);
//print($statement);
$Vector["statement"]=$statement;   //Filtro necesario para la paginacion


$obTabla->VerifiqueExport($Vector);
include_once("procesadores/procesaCartera.php");  //Clases de donde se escribirán las tablas
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
$Page="Consultas/BuscarCreditos.php?myPage=$myPage&CmbPreVentaAct=0&HabilitaCmbCuentaDestino=1&TxtBuscarCredito=";
$css->CrearInputText("TxtBuscarCredito","text","","","Buscar Credito","black","onKeyUp","EnvieObjetoConsulta(`$Page`,`TxtBuscarCredito`,`DivBusquedas`,`2`);return false;",200,30,0,0);
  
if($Restaurar==1){
    $css->CrearNotificacionRoja("Esta opcion borrará esta tabla y la realizará a partir de las facturas", 16);
    $css->CrearForm2("FrmRestarurar", $myPage, "post", "_self");
        $css->CrearBotonConfirmado("BtnRestaurarCartera", "Restaurar Cartera");
    $css->CerrarForm();
}
$css->DivNotificacionesJS();
if(!empty($_REQUEST["TxtidIngreso"])){
        $RutaPrintIngreso="../tcpdf/examples/imprimiringreso.php?ImgPrintIngreso=".$_REQUEST["TxtidIngreso"];			
        $css->CrearTabla();
        $css->CrearFilaNotificacion("Comprobante de Ingreso Creado Correctamente <a href='$RutaPrintIngreso' target='_blank'>Imprimir Comprobante de Ingreso No. $_REQUEST[TxtidIngreso]</a>",16);
        $css->CerrarTabla();
    }
    
//$VectorCredito["HabilitaCmbCuentaDestino"]=1;
//$obTabla->DibujaCredito($myPage,0,$VectorCredito);
$css->CrearDiv("DivBusquedas", "", "center", 1, 1);
$css->CerrarDiv();
//print($statement);
///////////////Creamos la imagen representativa de la pagina
    /////
    /////	
$css->CrearImageLink("../VMenu/Menu.php", "../images/cartera.png", "_self",200,200);

$PromedioDias=$obVenta->ActualiceDiasCartera();
$TotalCartera=  number_format($obVenta->Sume("cartera", "Saldo",""));

$css->CrearNotificacionAzul("Total en Cartera: $ $TotalCartera", 16);
if($PromedioDias>30){
    $css->CrearNotificacionRoja("Rotacion de Cartera: $PromedioDias", 16);
}else{
    $css->CrearNotificacionVerde("Rotacion de Cartera: $PromedioDias", 16);
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
$css->Footer();
$css->AgregaJS(); //Agregamos javascripts
//$css->AgregaSubir();    
////Fin HTML  
print("</body></html>");

ob_end_flush();
?>