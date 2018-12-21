<?php 
$myPage="anular_pago_comision.php";
include_once("../sesiones/php_control.php");
include_once("css_construct.php");
$obVenta = new ProcesoVenta($idUser);
//////Si recibo un cliente
if(!empty($_REQUEST['idPagoCom'])){

        $idPago=$obVenta->normalizar($_REQUEST['idPagoCom']);
}

	
print("<html>");
print("<head>");
$css =  new CssIni("Anular Pago de Comision");

print("</head>");
print("<body>");
    
    include_once("procesadores/AnularPagoComision.process.php");
    
    $css->CabeceraIni("Anular Pago de Comision"); //Inicia la cabecera de la pagina
    
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
    $css->CrearImageLink("titulos_comisiones.php", "../images/anular.png", "_self",200,200);
    
    ///////////////Si se crea una devolucion o una factura
    /////
    /////
    if(!empty($_REQUEST["TxtidComprobante"])){
        $css->CrearTabla();
        $css->CrearFilaNotificacion("Se ha registrado la anulacion del pago con el ID No. $_REQUEST[TxtidComprobante]</a>",16);
        $css->CerrarTabla();
    }
    ///////////////Se crea el DIV que servirá de contenedor secundario
    /////
    /////
    $css->CrearDiv("Secundario", "container", "center",1,1);
   										
    
    //////////////////////////Se dibujan los campos para la anulacion de la factura
    /////
    /////
    if(!empty($idPago)){
        
        $css->CrearTabla();
            
            $DatosPago=$obVenta->DevuelveValores("titulos_comisiones", "ID", $idPago);
            
            if($DatosPago["ID"]>0){
                   
                
            $css->CrearNotificacionAzul("Datos del pago", 18);
            $css->FilaTabla(14);
            
            $css->ColTabla("<strong>ID</strong>", 1);
            $css->ColTabla("<strong>Fecha</strong>", 1);
            $css->ColTabla("<strong>Venta</strong>", 1);
            $css->ColTabla("<strong>Monto</strong>", 1);
            $css->ColTabla("<strong>CC</strong>", 1);
            $css->ColTabla("<strong>Colaborador</strong>", 1);
            $css->ColTabla("<strong>Observaciones</strong>", 1);
            
            $css->CierraFilaTabla();
            
            $css->FilaTabla(14);
            
            $css->ColTabla($DatosPago["ID"], 1);
            $css->ColTabla($DatosPago["Fecha"], 1);
            $css->ColTabla($DatosPago["idVenta"], 1);
            $css->ColTabla($DatosPago["Monto"], 1);
            $css->ColTabla($DatosPago["idColaborador"], 1);
            $css->ColTabla($DatosPago["NombreColaborador"], 1);  
            $css->ColTabla($DatosPago["Observaciones"], 1);  
            $css->CierraFilaTabla();
            
            $css->CerrarTabla();
            $css->CrearForm2("FrmRegistraAnulacion", $myPage, "post", "_self");
            $css->CrearInputText("idPago", "hidden", "", $idPago, "", "", "", "", "", "", "", "");
            $css->CrearTabla();
            $css->CrearNotificacionNaranja("Datos Para Realizar la Anulacion", 16);
            print("<td style='text-align:center'>");
            $css->CrearInputFecha("Fecha:<br>", "TxtFechaAnulacion", date("Y-m-d"), 100, 30, "");
            //$css->CrearInputText("TxtFechaAnulacion", "text", "Fecha de Anulacion: <br>", date("Y-m-d"), "Fecha", "black", "", "", 100, 30, 0, 1);
            print("<br>");
            $css->CrearTextArea("TxtConceptoAnulacion", "", "", "Escriba el por qué se anulará el pago", "black", "", "", 200, 100, 0, 1);
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
        $css->CrearFilaNotificacion("Por favor busque y asocie un pago",16);
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