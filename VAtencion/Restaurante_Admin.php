<?php 
$myPage="Restaurante_Admin.php";
include_once("../sesiones/php_control.php");
$obTabla = new Tabla($db);
$obVenta = new ProcesoVenta($idUser);
$ConsultaCajas=$obVenta->ConsultarTabla("cajas", "WHERE idUsuario='$idUser' AND Estado='ABIERTA'");
$DatosCaja=$obVenta->FetchArray($ConsultaCajas);

if($DatosCaja["ID"]<=0){
    
   header("location:401.php");
}   
if(isset($_REQUEST["idPedido"])){
    $idPedido=$obVenta->normalizar($_REQUEST["idPedido"]);
}
include_once("css_construct.php");
print("<html>");
print("<head>");
$css =  new CssIni("Admin Restaurante");
print("</head>");
print("<body>");
   
    $css->CabeceraIni("Admin Restaurante"); //Inicia la cabecera de la pagina
        $css->CreaBotonDesplegable("DialCliente","Tercero");
        $css->CreaBotonDesplegable("DialEgreso","Egreso");
        print(" Cerrar Turno  ------------->>>");
        $css->CrearForm("FrmCerrarTurno", $myPage, "post", "_self");
        $css->CrearBotonConfirmado("BtnCerrarTurnoRestaurante", "Cerrar Turno");
        $css->CerrarForm();
        //print("</li>");
    $css->CabeceraFin(); 
    
    ///////////////Creamos el contenedor
    /////
    /////
    $css->CrearDiv("principal", "container", "center",1,1);
    $css->CrearDiv("DivMensajes", "", "center",1,1);
    $css->CerrarDiv();
    //$obTabla->DialVerDomicilios("");
    $idPreventa=1;
    include_once 'CuadroDialogoCrearCliente.php';
    include_once("procesadores/procesa_Restaurante_Admin.php");
    //////Creo una factura a partir de un pedido
    if(isset($_REQUEST['BtnFacturarPedido'])){
        $idPedido=$obVenta->normalizar($_REQUEST['BtnFacturarPedido']);
        $css->CrearDivBusquedas("DivDatosFactura", "", "center", 1, 1);
        $obTabla->DibujeAreaFacturacionRestaurante($idPedido,$myPage,"");
        $css->CerrarDiv(); 
    }
    
    if(!empty($_REQUEST["TxtIdEgreso"])){
        $idEgreso=$obVenta->normalizar($_REQUEST["TxtIdEgreso"]);
        $RutaPrint="../tcpdf/examples/imprimircomp.php?ImgPrintComp=".$idEgreso;
        $css->CrearTabla();
            $css->CrearFilaNotificacion("Egreso Creado Correctamente <a href='$RutaPrint' target='_blank'>Imprimir Egreso No. $idEgreso</a>",16);
        $css->CerrarTabla();
    }
    if(isset($_REQUEST["TxtidFactura"])){
            
        $idFactura=$_REQUEST["TxtidFactura"];
        if($idFactura<>""){
                       
            $RutaPrint="PDF_Factura.php?ImgPrintFactura=".$idFactura;
            $DatosFactura=$obVenta->DevuelveValores("facturas", "idFacturas", $idFactura);
            
            $css->CrearNotificacionVerde("Factura Creada Correctamente <a href='$RutaPrint' target='_blank'>Imprimir Factura No. $DatosFactura[NumeroFactura]</a>",16);
            
        }else{

           $css->AlertaJS("No se pudo crear la factura porque no hay resoluciones disponibles", 1, "", ""); 
        }
            
    }
    
    
    $css->DivPage("Pedidos", "Consultas/DatosPedidos.php?Valida=1", "", "DivPedidos", "onClick", 30, 30, "");
    
    print("<br>");
    	
    
    $css->CrearNotificacionAzul("ADMINISTRACION", 16);
    
    ///////////////Se crea el DIV que servirá de contenedor secundario
    /////
    /////
    $css->CrearDiv("DivPedidos", "", "center",1,1);
   
    $css->CerrarDiv();//Cerramos contenedor Secundario
    
    $css->CerrarDiv();//Cerramos contenedor Principal
    $css->AgregaJS(); //Agregamos javascripts
    $css->AnchoElemento("CmbCodMunicipio_chosen", 200);
    $css->AnchoElemento("CmbClientes_chosen", 200);
    $css->AnchoElemento("TxtidColaborador_chosen", 200);
    $css->AnchoElemento("TxtCliente_chosen", 200);
    
    $css->AnchoElemento("TxtCuentaDestino_chosen", 200);
    $css->AnchoElemento("TxtTipoPago_chosen", 200);
    $css->AnchoElemento("CmbCuentaDestino_chosen", 300);
    $css->AnchoElemento("CmbProveedores_chosen", 300);
    $css->AgregaSubir();
    print("<script>setInterval('BusquedaPedidos()',4000);ClickElement('Pedidos');</script>");
    
    if(isset($_REQUEST['BtnFacturarPedido'])or isset($_REQUEST['BtnFacturarDomicilio'])){
        print("<script>document.getElementById('TxtPaga').select();</script> ");
    }
    
    
    $css->Footer();
    print("</body></html>");
?>