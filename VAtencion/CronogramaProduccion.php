<?php 
$myPage="CronogramaProduccion.php";
include_once("../sesiones/php_control.php");
include_once("css_construct.php");


print("<html>");
print("<head>");

$css =  new CssIni("Cronograma Ordenes de Trabajo");
$obTabla=new Tabla($db);

print("</head>");
print("<body>");
    
    include_once("procesadores/procesaCronogramaProduccion.php");
    
    $css->CabeceraIni("Cronograma Ordenes de Trabajo"); //Inicia la cabecera de la pagina
    print("<li>");
    $css->CrearImageLink("produccion_ordenes_trabajo.php", "../images/trabajos.png", "_self", 30, 30);
    print("</li>");
    print("<li>");
    $css->CrearLink("produccion_ordenes_trabajo.php", "_self", "<strong>Ordenes de Trabajo</strong>");
    print("</li>");
     print("<li>");
    $css->CrearLink("produccion_actividades.php", "_blank", "<strong>Historial de Actividades</strong>");
    print("</li>");
    print("<li>");
    $css->CrearLink("Ejecutar_Actividades.php", "_self", "<strong>Ejecutar Actividad</strong>");
    print("</li>");
    $css->CabeceraFin(); 
    //////////Variables iniciales
    /////
    /////
    $obVenta = new ProcesoVenta($idUser);
   
    include_once("cuadros_dialogo/produccion_cuadros_dialogo.php");
    ///////////////Creamos el contenedor principal
    
    $css->CrearDiv("principal", "container", "center",1,1);
    
    if($idOT<1){
        $css->CrearNotificacionRoja("Debes Seleccionar una Orden de trabajo para agregar Actividades", 16);
    }
    
    $css->CrearForm2("FrmFechaCrono", $myPage, "post", "_self");    
    $css->CrearInputText("idOT", "hidden", "", $idOT, "", "", "", "", "", "", 0, 0);
    $css->CrearInputFecha("<h3>Seleccione la Fecha: </h3>", "TxtFechaCronograma", "$FechaActual", "100", "30", "");
	
    $css->CrearBotonNaranja("BtnBuscar", "Buscar");
    $css->CerrarForm();
    ///////////////Creamos el contenedor secundario
    
    $css->CrearDiv("Secundario", "container", "center",1,1);
    
    $obTabla->DibujCronogramaProduccionHoras("Cronograma Produccion",$FechaActual, $myPage,$idOT,"");
    
    $css->CerrarDiv();//Cerramos contenedor Secundario
    $css->CerrarDiv();//Cerramos contenedor Principal
    $css->AgregaJS(); //Agregamos javascripts
    if(isset($_REQUEST["idMaquina"]) and $idEdit==0){
        print("<script>MostrarDialogoID('ImgCrearActividad');</script>");
    }
    if($idEdit>0){
        print("<script>MostrarDialogoID('ImgEditarActividad');</script>");
    }
    $css->AgregaSubir();
    $css->Footer();
    print("</body></html>");
    ob_end_flush();
?>