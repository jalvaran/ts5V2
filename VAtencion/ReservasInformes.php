<?php 
$myPage="ReservasInformes.php";
include_once("../sesiones/php_control.php");
include_once("css_construct.php");
$obVenta = new ProcesoVenta($idUser);

print("<html>");
print("<head>");
$css =  new CssIni("Informes de Reservas");

print("</head>");
print("<body>");
     
      
    $css->CabeceraIni("Informes de Reservas"); //Inicia la cabecera de la pagina
        $css->CreaBotonDesplegable("DialCliente","Crear Cliente");
    $css->CabeceraFin(); 
    ///////////////Creamos el contenedor
    /////
    /////
    $css->CrearDiv("principal", "container", "center",1,1);
        
    $css->CrearTabla();
        $css->FilaTabla(16);
            $css->ColTabla("<strong>Fecha Inicial</strong>", 1);
            $css->ColTabla("<strong>Fecha Final</strong>", 1);
            
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
           
            print("<td>");
                $Page="Consultas/ReservasInformes.query.php";
                $FuncionJS="EnvieObjetoConsulta2(`$Page`,`TxtFechaInicial`,`DivAgenda`,`7`);return false;";
                //$FuncionJS="EnvieObjetoConsulta2(`$Page`,`CmbEspacio`,`DivAgenda`,`6`);return false;";
                $css->CrearInputText("TxtFechaInicial", "date", "", date("Y-m-d"), "Fecha", "", "OnChange", $FuncionJS, 200, 30, 0, 1);
            print("</td>");
            
            print("<td>");
                $Page="Consultas/ReservasInformes.query.php";
                $FuncionJS="EnvieObjetoConsulta2(`$Page`,`TxtFechaFinal`,`DivAgenda`,`7`);return false;";
                //$FuncionJS="EnvieObjetoConsulta2(`$Page`,`CmbEspacio`,`DivAgenda`,`6`);return false;";
                $css->CrearInputText("TxtFechaFinal", "date", "", date("Y-m-d"), "Fecha", "", "OnChange", $FuncionJS, 200, 30, 0, 1);
            print("</td>");
            
           
            
        $css->CierraFilaTabla();
    $css->CerrarTabla(); 
    //print("<div id='DivAgenda' background-image:url('../images/cancha.jpg');>");
    $css->CrearDiv("DivAgenda", "container", "center",1,1);
   										
    
    $css->CerrarDiv();//Cerramos contenedor Secundario
    $css->CerrarDiv();//Cerramos contenedor Principal
    $css->AgregaJS(); //Agregamos javascripts
    $css->AnchoElemento("CmbCodMunicipio_chosen", 200);
    $css->AgregaSubir();
    $css->Footer();
    print("</body></html>");
    ob_end_flush();
?>