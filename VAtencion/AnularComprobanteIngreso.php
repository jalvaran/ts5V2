<?php 
$myPage="AnularComprobanteIngreso.php";
include_once("../sesiones/php_control.php");
include_once("css_construct.php");
$obVenta = new ProcesoVenta($idUser);
//////Si recibo un cliente
	if(!empty($_REQUEST['idComprobante'])){
		
		$idComprobante=$obVenta->normalizar($_REQUEST['idComprobante']);
	}

	
print("<html>");
print("<head>");
$css =  new CssIni("Anular Comprobante de Ingreso");

print("</head>");
print("<body>");
    
    include_once("procesadores/procesaAnularComprobanteIngreso.php");
    
    $css->CabeceraIni("Anular Comprobante de Ingreso"); //Inicia la cabecera de la pagina
    
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
    $css->CrearImageLink("ComprobantesIngreso.php", "../images/anular.png", "_self",200,200);
    
    ///////////////Si se crea una devolucion o una factura
    /////
    /////
    if(!empty($_REQUEST["TxtidComprobante"])){
        $css->CrearTabla();
        $css->CrearFilaNotificacion("Se ha registrado la anulacion de este abono en el registro con ID No. $_REQUEST[TxtidComprobante]</a>",16);
        $css->CerrarTabla();
    }
    ///////////////Se crea el DIV que servirá de contenedor secundario
    /////
    /////
    $css->CrearDiv("Secundario", "container", "center",1,1);
   										
    
    //////////////////////////Se dibujan los campos para la anulacion de la factura
    /////
    /////
    if(!empty($idComprobante)){
        
        $css->CrearTabla();
            
            $DatosAbono=$obVenta->DevuelveValores("comprobantes_ingreso", "ID", $idComprobante);
            //$DatosCliente=$obVenta->DevuelveValores("clientes", "idClientes", $DatosFactura["Clientes_idClientes"]);
                if($DatosAbono["Estado"]=="ANULADO"){
                    $css->CrearNotificacionRoja("Error comprobante ya fue anulado", 16);
                    exit();
                }
            $css->CrearNotificacionAzul("Datos del Comprobante", 18);
            $css->FilaTabla(14);
            
            $css->ColTabla("<strong>ID</strong>", 1);
            $css->ColTabla("<strong>Monto</strong>", 1);
            $css->ColTabla("<strong>Fecha</strong>", 1);
           
            $css->ColTabla("<strong>Concepto</strong>", 1);
            
            
            $css->CierraFilaTabla();
            
            $css->FilaTabla(14);
            
            $css->ColTabla($DatosAbono["ID"], 1);
            $css->ColTabla($DatosAbono["Valor"], 1);
            $css->ColTabla($DatosAbono["Fecha"], 1);
            
            $css->ColTabla($DatosAbono["Concepto"], 1);
                        
            $css->CierraFilaTabla();
            
        $css->CerrarTabla();
        $css->CrearForm2("FrmRegistraAnulacion", $myPage, "post", "_self");
        $css->CrearInputText("idComprobante", "hidden", "", $idComprobante, "", "", "", "", "", "", "", "");
        $css->CrearTabla();
        $css->CrearNotificacionNaranja("Datos Para Realizar la Anulacion", 16);
        print("<td style='text-align:center'>");
        $css->CrearInputFecha("Fecha:<br>", "TxtFechaAnulacion", date("Y-m-d"), 100, 30, "");
        //$css->CrearInputText("TxtFechaAnulacion", "text", "Fecha de Anulacion: <br>", date("Y-m-d"), "Fecha", "black", "", "", 100, 30, 0, 1);
        print("<br>");
        $css->CrearTextArea("TxtConceptoAnulacion", "", "", "Escriba el por qué se anulará el comprobante", "black", "", "", 200, 100, 0, 1);
        print("<br>");
        $css->CrearBotonConfirmado("BtnAnular","Anular");	
            
        print("</td>");
        
        $css->CerrarTabla();
        $css->CerrarForm();
        
        
    }else{
        $css->CrearTabla();
        $css->CrearFilaNotificacion("Por favor busque y asocie un comprobante",16);
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