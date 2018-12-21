<?php 
$myPage="AnularSeparado.php";
include_once("../sesiones/php_control.php");
include_once("css_construct.php");
$obVenta = new ProcesoVenta($idUser);
//////Si recibo un cliente
if(!empty($_REQUEST['idSeparado'])){

        $idSeparado=$obVenta->normalizar($_REQUEST['idSeparado']);
}

	
print("<html>");
print("<head>");
$css =  new CssIni("Anular Separado");

print("</head>");
print("<body>");
    
    include_once("procesadores/AnularSeparado.process.php");
    
    $css->CabeceraIni("Anular Separado"); //Inicia la cabecera de la pagina
    
    //////////Creamos el formulario de busqueda de remisiones
    /////
    /////
    
   
    
    $css->CabeceraFin(); 
    ///////////////Creamos el contenedor
    /////
    /////
    $css->CrearDiv("principal", "container", "center",1,1);
    if(isset($_REQUEST["TxtidComprobante"])){
        $css->CrearNotificacionNaranja("Separado anulado", 16);
    }
    print("<br>");
    ///////////////Creamos la imagen representativa de la pagina
    /////
    /////	
    $css->CrearImageLink("separados.php", "../images/anular.png", "_self",200,200);
    
   
    ///////////////Se crea el DIV que servirá de contenedor secundario
    /////
    /////
    $css->CrearDiv("Secundario", "container", "center",1,1);
   										
    
    //////////////////////////Se dibujan los campos para la anulacion de la factura
    /////
    /////
    if(!empty($idSeparado)){
        
        $css->CrearTabla();
            
            $DatosSeparado=$obVenta->DevuelveValores("separados", "ID", $idSeparado);
            $DatosCliente=$obVenta->DevuelveValores("clientes", "idClientes", $DatosSeparado["idCliente"]);
                if($DatosSeparado["Estado"]=="ANULADO"){
                    $css->CrearNotificacionRoja("Error este separado ya fue anulado", 16);
                    exit();
                }
            $css->CrearNotificacionAzul("Datos del separado", 18);
            $css->FilaTabla(14);
            
            $css->ColTabla("<strong>Cliente</strong>", 1);
            $css->ColTabla("<strong>Separado</strong>", 1);
            $css->ColTabla("<strong>Fecha</strong>", 1);
           
            $css->ColTabla("<strong>Total</strong>", 1);
            $css->ColTabla("<strong>Saldo</strong>", 1);
            
            $css->CierraFilaTabla();
            
            $css->FilaTabla(14);
            
            $css->ColTabla($DatosCliente["RazonSocial"], 1);
            $css->ColTabla($DatosSeparado["ID"], 1);
            $css->ColTabla($DatosSeparado["Fecha"], 1);
            
            $css->ColTabla($DatosSeparado["Total"], 1);
            $css->ColTabla($DatosSeparado["Saldo"], 1);         
            $css->CierraFilaTabla();
            
        $css->CerrarTabla();
        $css->CrearForm2("FrmRegistraAnulacion", $myPage, "post", "_self");
        $css->CrearInputText("idSeparado", "hidden", "", $idSeparado, "", "", "", "", "", "", "", "");
        $css->CrearTabla();
        $css->CrearNotificacionNaranja("Datos Para Realizar la Anulacion", 16);
        print("<td style='text-align:center'>");
        $css->CrearInputText("TxtFechaAnulacion", "date", "Fecha de Anulacion: <br>", date("Y-m-d"), "Fecha", "black", "", "", 100, 30, 0, 1);
        print("<br>");
        $css->CrearTextArea("TxtConceptoAnulacion", "", "", "Escriba el por qué se anulará el separado", "black", "", "", 200, 100, 0, 1);
        print("<br>");
        $css->CrearBotonConfirmado("BtnAnular","Anular");	
            
        print("</td>");
        
        $css->CerrarTabla();
        $css->CerrarForm();
        
        
    }else{
        $css->CrearTabla();
        $css->CrearFilaNotificacion("Por favor busque y asocie un separado",16);
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