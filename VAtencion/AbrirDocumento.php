<?php 
$myPage="AbrirDocumento.php";
include_once("../sesiones/php_control.php");
include_once("css_construct.php");
$obVenta = new ProcesoVenta($idUser);
//////Si recibo un cliente
if(!empty($_REQUEST['Doc'])){

    $Documento=$obVenta->normalizar($_REQUEST['Doc']);
    $idDoc=$obVenta->normalizar($_REQUEST['idDoc']);
}

	
print("<html>");
print("<head>");
$css =  new CssIni("Reabrir un documento");

print("</head>");
print("<body>");
    
    include_once("procesadores/AbrirDocumento.process.php");
    
    $css->CabeceraIni("Reabrir un documento"); //Inicia la cabecera de la pagina
    
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
    $css->CrearImageLink("comprobantes_contabilidad_items.php", "../images/abir_doc.jpg", "_self",100,100);
    
    
    ///////////////Se crea el DIV que servirá de contenedor secundario
    /////
    /////
    $css->CrearDiv("Secundario", "container", "center",1,1);
   										
    
    //////////////////////////Se dibujan los campos para la anulacion de la factura
    /////
    /////
    if(!empty($idDoc)){
        
        $css->CrearTabla();
            if($Documento=="CC"){
                $DatosDocumento=$obVenta->DevuelveValores("comprobantes_contabilidad", "ID", $idDoc);
            }
            
            
            $css->CrearNotificacionAzul("Datos del documento $Documento $idDoc", 18);
            $css->FilaTabla(14);
            
            $css->ColTabla("<strong>ID</strong>", 1);
            $css->ColTabla("<strong>Fecha</strong>", 1);
            $css->ColTabla("<strong>Concepto</strong>", 1);
            
            
            $css->CierraFilaTabla();
            
            $css->FilaTabla(14);
            
            $css->ColTabla($DatosDocumento["ID"], 1);
            $css->ColTabla($DatosDocumento["Fecha"], 1);
            $css->ColTabla($DatosDocumento["Concepto"], 1);
                        
            $css->CierraFilaTabla();
            
        $css->CerrarTabla();
        $css->CrearForm2("FrmRegistraApertura", $myPage, "post", "_self");
        $css->CrearInputText("Documento", "hidden", "", $Documento, "", "", "", "", "", "", "", "");
        $css->CrearInputText("idDoc", "hidden", "", $idDoc, "", "", "", "", "", "", "", "");
        $css->CrearTabla();
        $css->CrearNotificacionNaranja("Datos Para Realizar la Apertura", 16);
        print("<td style='text-align:center'>");
        $css->CrearInputFecha("Fecha:<br>", "TxtFechaApertura", date("Y-m-d"), 100, 30, "");
        print("<br>");
        $css->CrearTextArea("TxtConceptoApertura", "", "", "Escriba el por qué se abrirá el documento", "black", "", "", 200, 100, 0, 1);
        print("<br>");
        $css->CrearBotonConfirmado("BtnAbrir","Abrir");	
            
        print("</td>");
        
        $css->CerrarTabla();
        $css->CerrarForm();
        
        
    }else{
        $css->CrearTabla();
        $css->CrearFilaNotificacion("Por favor busque y asocie un documento",16);
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