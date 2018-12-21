<?php 
$myPage="VentasRestaurante.php";
include_once("../sesiones/php_control.php");
include_once("clases/Restaurante.class.php");

include_once("css_construct.php");
$obRest=new Restaurante($idUser);	
print("<html>");
print("<head>");

$css =  new CssIni("Ventas Restaurante");

print("</head>");
print("<body>");

    $css->CabeceraIni("Ventas Restaurante"); //Inicia la cabecera de la pagina
    
    //////////Creamos el formulario de busqueda de remisiones
    /////
    /////
    $css->CrearBotonEvento("BtnCrearCliente", "Cerrar Cliente", 1, "onclick", "ModalCliente()", "verde", "");
    print(" ");
    $css->CrearBotonEvento("BtnCerrarTurno", "Cerrar Turno", 1, "onclick", "CerrarTurnoRestaurante()", "rojo", "");
    
    $css->CabeceraFin(); 
    //$css->BotonNotificaciones("");
    ///////////////Creamos el contenedor
    /////
    /////
   // print("<div id='DivAlertasTS5' style='position: absolute;left: 10px;'>");
    $css->CrearDiv('DivAlertasTS5', "container", "center", 1, 1);    
    $css->CerrarDiv();
    
    $css->CrearDiv("DivButtons", "", "", 0, 0);
    $css->CreaBotonDesplegable("DialFacturacion", "Abrir","BtnAbreModalFact");
    $css->CerrarDiv();
    $css->CrearModal("DialFacturacion", "TS5", "");
    //$css->CrearCuadroDeDialogoAmplio("DialFacturacion", "Facturar");
        $css->CrearDiv("DivFacturacion", "", "center", 1, 1);
        $css->CerrarDiv();
    
    //$css->CerrarCuadroDeDialogoAmplio();
    $css->CerrarModal();
   //$css->DivGrid("DivOpciones", "", "left", 1, 1, 1, 100, 8,1,"transparent");
    $css->CrearDiv("DivOpciones", "container", "center", 1, 1);
        $evento="onClick";
        $Page="Consultas/Restaurante_pedidos.query.php?TipoPedido=AB&CuadroAdd=1&Carry=";
        $funcion="MostrarPedidos()";
        
        $css->CrearBotonEvento("BtnPedidos", "-Pedidos-", 1, $evento, $funcion, "naranja", "");
        print(" ");
        $Page="Consultas/Restaurante_pedidos.query.php?TipoPedido=DO&CuadroAdd=1&Carry=";
        $funcion="EnvieObjetoConsulta(`$Page`,`BtnPedidos`,`DivPedidos`,`99`);TimersPedidos(2);";
        
        $css->CrearBotonEvento("BtnDomicilios", "Domicilios", 1, $evento, $funcion, "rojo", "");
        print(" ");
        $Page="Consultas/Restaurante_pedidos.query.php?TipoPedido=LL&CuadroAdd=1&Carry=";
        $funcion="EnvieObjetoConsulta(`$Page`,`BtnPedidos`,`DivPedidos`,`99`);TimersPedidos(3);";
        
        $css->CrearBotonEvento("BtnLlevar", "<-Llevar->", 1, $evento, $funcion, "verde", "");
        
        print(" ");
        $Page="Consultas/Restaurante_pedidos.query.php?DatosTurnoActual=1&Carry=";
        $funcion="EnvieObjetoConsulta(`$Page`,`BtnPedidos`,`DivPedidos`,`99`);TimersPedidos(99);";
        if($TipoUser=="administrador"){
            $css->CrearBotonEvento("BtnVerTotales", "Este Turno", 1, $evento, $funcion, "naranja", "");
        }
        
        
   $css->CerrarDiv();
   $css->CrearDiv("DivPedidos", "container", "center", 1, 1);
   //$css->DivGrid("DivPedidos", "", "center", 1, 1, 2, 100, 90,1,"transparent");
    
   $css->CerrarDiv();
   //$css->DivGrid("DivItems", "", "center", 1, 1, 2, 100, 30,1,"transparent");
    
   /*
    print('<audio id="audio" controls style="display: none">
        <source type="audio/mp3" src="../sounds/sms-alert-4.mp3">
        </audio>');
    * 
    */
    $css->AgregaJS(); //Agregamos javascripts
    $css->AgregaCssJSSelect2(); //Agregamos CSS y JS de Select2
    $css->AgregaSubir();
    $css->Footer();
    print('<script src="jsPages/restaurante_ventas.js"></script>');
    
    print("</body></html>");
    ob_end_flush();
?>