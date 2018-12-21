<?php 
$myPage="AnularFactura.php";
include_once("../sesiones/php_control.php");
include_once("css_construct.php");
$obVenta = new ProcesoVenta($idUser);
//////Si recibo un cliente
if(!empty($_REQUEST['idFactura'])){

        $idFactura=$obVenta->normalizar($_REQUEST['idFactura']);
}

	
print("<html>");
print("<head>");
$css =  new CssIni("Anular Factura");

print("</head>");
print("<body>");
    
    include_once("procesadores/procesaAnularFactura.php");
    
    $css->CabeceraIni("Anular Factura"); //Inicia la cabecera de la pagina
    
    //////////Creamos el formulario de busqueda de remisiones
    /////
    /////
    
   
    
    $css->CabeceraFin(); 
    ///////////////Creamos el contenedor
    /////
    /////
    $css->CrearDiv("principal", "container", "center",1,1);
    print("<br>");
    ///////////////Creamos la imagen representativa de la pagina
    /////
    /////	
    $css->CrearImageLink("facturas.php", "../images/anular.png", "_self",200,200);
    
    ///////////////Si se crea una devolucion o una factura
    /////
    /////
    if(!empty($_REQUEST["TxtidComprobante"])){
        $RutaPrintIngreso="../tcpdf/examples/notacredito.php?idComprobante=".$_REQUEST["TxtidComprobante"];			
        $css->CrearTabla();
        $css->CrearFilaNotificacion("Nota Credito Creada Correctamente <a href='$RutaPrintIngreso' target='_blank'>Imprimir Nota Credito No. $_REQUEST[TxtidComprobante]</a>",16);
        $css->CerrarTabla();
    }
    ///////////////Se crea el DIV que servirá de contenedor secundario
    /////
    /////
    $css->CrearDiv("Secundario", "container", "center",1,1);
   										
    
    //////////////////////////Se dibujan los campos para la anulacion de la factura
    /////
    /////
    if(!empty($idFactura)){
        
        $css->CrearTabla();
            
            $DatosFactura=$obVenta->DevuelveValores("facturas", "idFacturas", $idFactura);
            $DatosCliente=$obVenta->DevuelveValores("clientes", "idClientes", $DatosFactura["Clientes_idClientes"]);
                if($DatosFactura["FormaPago"]=="ANULADA"){
                    $css->CrearNotificacionRoja("Error esta factura ya fue anulada", 16);
                    exit();
                }
            $css->CrearNotificacionAzul("Datos de la Factura", 18);
            $css->FilaTabla(14);
            
            $css->ColTabla("<strong>Cliente</strong>", 1);
            $css->ColTabla("<strong>Factura</strong>", 1);
            $css->ColTabla("<strong>Fecha</strong>", 1);
           
            $css->ColTabla("<strong>Total Factura</strong>", 1);
            
            
            $css->CierraFilaTabla();
            
            $css->FilaTabla(14);
            
            $css->ColTabla($DatosCliente["RazonSocial"], 1);
            $css->ColTabla($DatosFactura["Prefijo"].$DatosFactura["NumeroFactura"], 1);
            $css->ColTabla($DatosFactura["Fecha"], 1);
            
            $css->ColTabla($DatosFactura["Total"], 1);
                        
            $css->CierraFilaTabla();
            
        $css->CerrarTabla();
        $css->CrearForm2("FrmRegistraAnulacion", $myPage, "post", "_self");
        $css->CrearInputText("TxtIdFactura", "hidden", "", $DatosFactura["idFacturas"], "", "", "", "", "", "", "", "");
        $css->CrearTabla();
        $css->CrearNotificacionNaranja("Datos Para Realizar la Anulacion", 16);
        print("<td style='text-align:center'>");
        $css->CrearInputText("TxtFechaAnulacion", "text", "Fecha de Anulacion: <br>", date("Y-m-d"), "Fecha", "black", "", "", 100, 30, 0, 1);
        print("<br>");
        $css->CrearTextArea("TxtConceptoAnulacion", "", "", "Escriba el por qué se anulará la factura", "black", "", "", 200, 100, 0, 1);
        print("<br>");
        $css->CrearBotonConfirmado("BtnAnular","Anular");	
            
        print("</td>");
        
        $css->CerrarTabla();
        $css->CerrarForm();
        
        
    }else{
        $css->CrearTabla();
        $css->CrearFilaNotificacion("Por favor busque y asocie una factura",16);
        $css->CerrarTabla();
    }
    $css->CerrarDiv();//Cerramos contenedor Secundario
    $css->CerrarDiv();//Cerramos contenedor Principal
    $css->AgregaJS(); //Agregamos javascripts
    $css->AgregaSubir();
    $css->Footer();
    print("</body></html>");
    ob_end_flush();
?>