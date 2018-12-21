<?php 
$myPage="DevolverVenta.php";
include_once("../sesiones/php_control.php");
include_once("css_construct.php");

//////Si recibo un cliente
	if(!empty($_REQUEST['idVenta'])){
		
		$idVenta=$_REQUEST['idVenta'];
	}

	
print("<html>");
print("<head>");
$css =  new CssIni("Anular Factura");

print("</head>");
print("<body>");
    
    include_once("procesadores/procesaDevolverVenta.php");
    
    $css->CabeceraIni("Anular Venta"); //Inicia la cabecera de la pagina
    
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
    $css->CrearImageLink("titulos_ventas.php", "../images/anular.png", "_self",200,200);
    
    ///////////////Si se crea una devolucion 
    /////
    /////
    /*
    if(!empty($_REQUEST["TxtidComprobante"])){
        $RutaPrintIngreso="../tcpdf/examples/notacredito.php?idComprobante=".$_REQUEST["TxtidComprobante"];			
        $css->CrearTabla();
        $css->CrearFilaNotificacion("Nota Credito Creada Correctamente <a href='$RutaPrintIngreso' target='_blank'>Imprimir Nota Credito No. $_REQUEST[TxtidComprobante]</a>",16);
        $css->CerrarTabla();
    }
     * 
     */
    ///////////////Se crea el DIV que servirá de contenedor secundario
    /////
    /////
    $css->CrearDiv("Secundario", "container", "center",1,1);
   										
    
    //////////////////////////Se dibujan los campos para la anulacion de la factura
    /////
    /////
    if(!empty($idVenta)){
        
        $css->CrearTabla();
            
            $DatosVenta=$obVenta->DevuelveValores("titulos_ventas", "ID", $idVenta);
            //$DatosCliente=$obVenta->DevuelveValores("clientes", "idClientes", $DatosFactura["Clientes_idClientes"]);
                if($DatosVenta["Estado"]=="ANULADA"){
                    $css->CrearNotificacionRoja("Error esta venta ya fue anulada", 16);
                    exit();
                }
            $css->CrearNotificacionAzul("Datos de la Venta", 18);
            $css->FilaTabla(14);
            $css->ColTabla("<strong>idVenta</strong>", 1);
            $css->ColTabla("<strong>Fecha</strong>", 1);
            $css->ColTabla("<strong>Promocion</strong>", 1);
            $css->ColTabla("<strong>Mayor</strong>", 1);
            $css->ColTabla("<strong>Cliente</strong>", 1);
            $css->ColTabla("<strong>Identificacion</strong>", 1);
            $css->ColTabla("<strong>Colaborador</strong>", 1);
            $css->ColTabla("<strong>Identificacion</strong>", 1);
            
            $css->ColTabla("<strong>Valor</strong>", 1);
            $css->ColTabla("<strong>TotalAbonos</strong>", 1);
            
            
            $css->CierraFilaTabla();
            
            $css->FilaTabla(14);
            
            $css->ColTabla($DatosVenta["ID"], 1);
            $css->ColTabla($DatosVenta["Fecha"], 1);
            $css->ColTabla($DatosVenta["Promocion"], 1);
            $css->ColTabla($DatosVenta["Mayor1"], 1);
            $css->ColTabla($DatosVenta["NombreCliente"], 1);
            $css->ColTabla($DatosVenta["idCliente"], 1);
            $css->ColTabla($DatosVenta["NombreColaborador"], 1);
            $css->ColTabla($DatosVenta["idColaborador"], 1);
            $css->ColTabla($DatosVenta["Valor"], 1);
            $css->ColTabla($DatosVenta["TotalAbonos"], 1);
                                  
            $css->CierraFilaTabla();
            
        $css->CerrarTabla();
        $css->CrearForm2("FrmRegistraAnulacion", $myPage, "post", "_self");
        $css->CrearInputText("TxtIdVenta", "hidden", "", $DatosVenta["ID"], "", "", "", "", "", "", "", "");
        $css->CrearTabla();
        $css->CrearNotificacionNaranja("Datos Para Realizar la Anulacion", 16);
        print("<td style='text-align:center'>");
        $css->CrearInputText("TxtFechaAnulacion", "text", "Fecha de Anulacion: <br>", date("Y-m-d"), "Fecha", "black", "", "", 100, 30, 0, 1);
        print("<br>");
        $css->CrearTextArea("TxtConceptoAnulacion", "", "", "Escriba el por qué se anulará la Venta", "black", "", "", 200, 100, 0, 1);
        print("<br>");
        $css->CrearBotonConfirmado("BtnAnular","Anular");	
            
        print("</td>");
        
        $css->CerrarTabla();
        $css->CerrarForm();
        
        
    }else{
        $css->CrearTabla();
        $css->CrearFilaNotificacion("Por favor busque y asocie una Venta",16);
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