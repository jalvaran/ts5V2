<?php 
$myPage="AnularCompraActiva.php";
include_once("../sesiones/php_control.php");
include_once("css_construct.php");
$obVenta = new ProcesoVenta($idUser);
//////Si recibo un cliente
	if(!empty($_REQUEST['idCompra'])){
		
		$idCompra=$obVenta->normalizar($_REQUEST['idCompra']);
	}

	
print("<html>");
print("<head>");
$css =  new CssIni("Anular Compra activa");

print("</head>");
print("<body>");
    
    include_once("procesadores/procesaAnularCompraActiva.php");
    
    $css->CabeceraIni("Anular Compra Activa"); //Inicia la cabecera de la pagina
    
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
    $css->CrearImageLink("compras_activas.php", "../images/anular.png", "_self",200,200);
    
    ///////////////Si se crea una devolucion o una factura
    /////
    /////
    if(!empty($_REQUEST["TxtidComprobante"])){
        $css->CrearTabla();
        $css->CrearFilaNotificacion("Se ha registrado la anulacion de la compra activa ID No. $_REQUEST[TxtidComprobante]</a>",16);
        $css->CerrarTabla();
    }
    ///////////////Se crea el DIV que servirá de contenedor secundario
    /////
    /////
    $css->CrearDiv("Secundario", "container", "center",1,1);
   										
    
    //////////////////////////Se dibujan los campos para la anulacion de la factura
    /////
    /////
    if(!empty($idCompra)){
        
        $css->CrearTabla();
            
            $DatosCompra=$obVenta->DevuelveValores("compras_activas", "idComprasActivas", $idCompra);
            //$DatosCliente=$obVenta->DevuelveValores("clientes", "idClientes", $DatosFactura["Clientes_idClientes"]);
            if($DatosCompra["idComprasActivas"]>0){
                   
                
            $css->CrearNotificacionAzul("Datos de la compra", 18);
            $css->FilaTabla(14);
            
            $css->ColTabla("<strong>ID</strong>", 1);
            $css->ColTabla("<strong>Proveedor</strong>", 1);
            $css->ColTabla("<strong>Fecha</strong>", 1);
            $css->ColTabla("<strong>Factura</strong>", 1);
            $css->ColTabla("<strong>Total</strong>", 1);
            
            
            $css->CierraFilaTabla();
            
            $css->FilaTabla(14);
            
            $css->ColTabla($DatosCompra["idComprasActivas"], 1);
            $css->ColTabla($DatosCompra["NombrePro"], 1);
            $css->ColTabla($DatosCompra["Fecha"], 1);
            $css->ColTabla($DatosCompra["Factura"], 1);
            $css->ColTabla($DatosCompra["TotalCompra"], 1);
                        
            $css->CierraFilaTabla();
            
            $css->CerrarTabla();
            $css->CrearForm2("FrmRegistraAnulacion", $myPage, "post", "_self");
            $css->CrearInputText("idCompra", "hidden", "", $idCompra, "", "", "", "", "", "", "", "");
            $css->CrearTabla();
            $css->CrearNotificacionNaranja("Datos Para Realizar la Anulacion", 16);
            print("<td style='text-align:center'>");
            $css->CrearInputFecha("Fecha:<br>", "TxtFechaAnulacion", date("Y-m-d"), 100, 30, "");
            //$css->CrearInputText("TxtFechaAnulacion", "text", "Fecha de Anulacion: <br>", date("Y-m-d"), "Fecha", "black", "", "", 100, 30, 0, 1);
            print("<br>");
            $css->CrearTextArea("TxtConceptoAnulacion", "", "", "Escriba el por qué se anulará la compra", "black", "", "", 200, 100, 0, 1);
            print("<br>");
            $css->CrearBotonConfirmado("BtnAnular","Anular");	

            print("</td>");

            $css->CerrarTabla();
            $css->CerrarForm();
        
        }else{
            $css->CrearNotificacionRoja("No hay datos de este registro", 16);
            exit();
        }
    }else{
        $css->CrearTabla();
        $css->CrearFilaNotificacion("Por favor busque y asocie una compra activa",16);
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