<?php 
$myPage="AnularEgreso.php";
include_once("../sesiones/php_control.php");
include_once("css_construct.php");
$obVenta = new ProcesoVenta($idUser);
//////Si recibo un cliente
if(!empty($_REQUEST['idEgreso'])){

        $idComprobante=$obVenta->normalizar($_REQUEST['idEgreso']);
}

	
print("<html>");
print("<head>");
$css =  new CssIni("Anular Egreso");

print("</head>");
print("<body>");
    
    include_once("procesadores/AnularEgreso.process.php");
    
    $css->CabeceraIni("Anular Comprobante de Egreso"); //Inicia la cabecera de la pagina
    
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
    $css->CrearImageLink("egresos.php", "../images/anular.png", "_self",200,200);
    
    ///////////////Si se crea una devolucion o una factura
    /////
    /////
    if(!empty($_REQUEST["TxtidComprobante"])){
        $css->CrearTabla();
        $css->CrearFilaNotificacion("Se ha registrado la anulacion del comprobante de egreso en el registro No. $_REQUEST[TxtidComprobante]</a>",16);
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
            
            $DatosEgreso=$obVenta->DevuelveValores("egresos", "idEgresos", $idComprobante);
            //$DatosCliente=$obVenta->DevuelveValores("clientes", "idClientes", $DatosFactura["Clientes_idClientes"]);
                if($DatosEgreso["PagoProg"]=="ANULADO"){
                    $css->CrearNotificacionRoja("Error, el comprobante ya fue anulado", 16);
                    exit();
                }
            $css->CrearNotificacionAzul("Datos del Comprobante", 18);
            $css->FilaTabla(14);
            
            $css->ColTabla("<strong>ID</strong>", 1);
            $css->ColTabla("<strong>Fecha</strong>", 1);
            $css->ColTabla("<strong>Beneficiario</strong>", 1);
            $css->ColTabla("<strong>NIT</strong>", 1);
            $css->ColTabla("<strong>Valor</strong>", 1);
            $css->ColTabla("<strong>Concepto</strong>", 1);
            
            
            $css->CierraFilaTabla();
            
            $css->FilaTabla(14);
            
            $css->ColTabla($DatosEgreso["idEgresos"], 1);
            $css->ColTabla($DatosEgreso["Fecha"], 1);
            $css->ColTabla($DatosEgreso["Beneficiario"], 1);
            $css->ColTabla($DatosEgreso["NIT"], 1);
            $css->ColTabla($DatosEgreso["Valor"], 1);
            $css->ColTabla($DatosEgreso["Concepto"], 1);
                        
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