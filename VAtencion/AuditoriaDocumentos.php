<?php 
$myPage="BalanceComprobacion.php";
include_once("../sesiones/php_control.php");
include_once("../modelo/php_tablas.php");
$obTabla = new Tabla($db);
$obVenta = new ProcesoVenta($idUser);

include_once("css_construct.php");
print("<html>");
print("<head>");
$css =  new CssIni("Auditoria de Documentos");
print("</head>");
print("<body>");
   
    $css->CabeceraIni("Auditoría de Documentos"); //Inicia la cabecera de la pagina
    
    $css->CabeceraFin(); 
    ///////////////Creamos el contenedor
    /////
    /////
    $css->CrearDiv("principal", "container", "center",1,1);
    
    $css->DivPage("TxtTitulo", "Consultas/DatosAuditoria.php?Valida=1", "", "DivBusqueda", "onClick", 30, 30, "");
    //$css->DibujeCuadroBusqueda("TxtTitulo", "Consultas/DatosTitulos.php?Titulo", "idPromocion=", "DivInfoTitulo", "onKeyup", 30, 100, "");
    print("<br>");
    ///////////////Creamos la imagen representativa de la pagina
    /////
    /////	
    
    $css->CrearNotificacionAzul("AUDITORÍA DE DOCUMENTOS", 16);
    
    ///////////////Se crea el DIV que servirá de contenedor secundario
    /////
    /////
    $css->CrearDiv("DivBusqueda", "", "center",1,1);
   
    $css->CerrarDiv();//Cerramos contenedor Secundario
    $css->CrearImageLink("../VMenu/MnuInformes.php", "../images/auditoria.png", "_self",200,200);
    $css->CerrarDiv();//Cerramos contenedor Principal
    $css->AgregaJS(); //Agregamos javascripts
    $css->AgregaSubir();
    print("<script>setInterval('BusquedaTxtTitulo()',5000)</script>");
    $css->Footer();
    
    
    print("</body></html>");
?>