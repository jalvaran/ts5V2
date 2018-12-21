<?php 
$myPage="ConteoFisicoSelectivo.php";
include_once("../sesiones/php_control.php");

$obVenta = new ProcesoVenta($idUser);
$obTabla = new Tabla($db);

include_once("css_construct.php");

print("<html>");
print("<head>");
$css =  new CssIni("Conteo Selectivo");

print("</head>");

print("<body>");
    
    $css->CabeceraIni("Conteo Selectivo"); //Inicia la cabecera de la pagina
    
    
    $css->CabeceraFin(); 
    ///////////////Creamos el contenedor
    /////
    /////
    $css->CrearDiv("principal", "container", "center",1,1);
    include_once("procesadores/ConteoFisicoSelectivo.process.php");  //Clases de donde se escribirán las tablas
    $css->CrearDiv("Secundario", "container", "center",1,1);
    
    $css->CrearNotificacionVerde("Conteo Selectivo", 16);
    $css->CrearForm2("FrmConteoSelectivo", $myPage, "post", "_self");
    $css->CrearTabla();
    $css->FilaTabla(16);
    $css->ColTabla("<strong>Cantidad</strong>", 1);
    $css->ColTabla("<strong>Codigo de Barras o ID</strong>", 1);
    $css->ColTabla("<strong>Enviar</strong>", 1);
    $css->CierraFilaTabla();
    $css->FilaTabla(16);
     print("<td>");
    $css->CrearInputNumber("TxtCantidad", "number", "", 1, "Cantidad", "", "", "", 100, 30, 0, 1, "", 99, "any");
    print("</td>");
     print("<td>");
    $css->CrearInputText("TxtCodigoBarras", "text", "", "", "Codigo de Barras o ID", "", "", "", 200, 30, 0, 1);
    print("</td>");
    print("<td>");
    $css->CrearBoton("BtnContar", "Enviar");
    print("</td>");
    
    $css->CierraFilaTabla();
    $css->CerrarTabla();
    $css->CerrarForm();
    $css->CerrarDiv();//Cerramos contenedor Secundario
    $css->CerrarDiv();//Cerramos contenedor Principal
    $css->AgregaJS(); //Agregamos javascripts
    print("<script>posiciona('TxtCodigoBarras');</script> "); 
    $css->AgregaSubir();
    $css->Footer();
    print("</body></html>");
?>