<?php 
$myPage="facturacionxfecha.php";
include_once("../sesiones/php_control.php");
include_once("../modelo/php_tablas.php");

$obVenta = new ProcesoVenta($idUser);

include_once("css_construct.php");
print("<html>");
print("<head>");
$css =  new CssIni("facturacionxfecha");
print("</head>");
print("<body>");
   
    $css->CabeceraIni("Resumen de Facturacion por Fecha"); //Inicia la cabecera de la pagina
    
    $css->CabeceraFin(); 
    ///////////////Creamos el contenedor
    /////
    /////
    $css->CrearDiv("principal", "container", "center",1,1);
        
    $css->CrearNotificacionAzul("SELECCIONE EL RANGO", 16);
        $css->CrearForm2("FrmFecha", "ProcesadoresJS/GeneradorCSV.php", "post", "_blank");
            $css->CrearInputText("Opcion", "hidden", "", 2, "", "", "", "", "", "", 0, 0);
                
            $css->CrearTabla();
            $css->FilaTabla(16);
                $css->ColTabla("<strong>Fecha Inicial</strong>", 1);
                $css->ColTabla("<strong>Fecha Final</strong>", 1);
                $css->ColTabla("<strong>Generar</strong>", 1);
            $css->CierraFilaTabla();
            $css->FilaTabla(16);
                print("<td style='text-align:center'>");
                   $css->CrearInputText("TxtFechaIni", "date", "", date("Y-m-d"), "Fecha Inicial", "Black", "", "", 200, 30, 0, 1);
                print("</td>");
                print("<td style='text-align:center'>");
                   $css->CrearInputText("TxtFechaFin", "date", "", date("Y-m-d"), "Fecha Inicial", "Black", "", "", 200, 30, 0, 1);
                print("</td>");
                print("<td style='text-align:center'>");
                   $css->CrearBotonNaranja("BtnGenerar", "Generar");
                print("</td>");
            $css->CierraFilaTabla();
                $css->CerrarTabla();
        $css->CerrarForm();
    $css->CerrarDiv();//Cerramos contenedor Principal
    $css->AgregaJS(); //Agregamos javascripts
    $css->AgregaSubir();
    
    $css->Footer();
    
    
    print("</body></html>");
?>