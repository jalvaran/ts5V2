<?php
$myPage="crono.php";
$myTitulo="Control de Sesiones";
//include_once("../sesiones/php_control.php");

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

$css->CrearDiv("principal", "container", "left",1,1);

$css->CrearDiv("DivCrono", "", "Center", 1, 1);
include("RelojCronometro.php");
$css->CerrarDiv();//Cerramos contenedor Principal
$css->CerrarDiv();//Cerramos contenedor Principal
$css->Footer();
$css->AgregaJS(); //Agregamos javascripts
//print("<script>window.setInterval('location.reload(DivCrono)',1000)</script>");
//$css->AgregaSubir();    
////Fin HTML  
print("</body></html>");

ob_end_flush();
?>