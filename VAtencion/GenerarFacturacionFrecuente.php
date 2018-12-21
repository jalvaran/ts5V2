<?php 
$myPage="GenerarFacturacionFrecuente.php";
include_once("../sesiones/php_control.php");
include_once("css_construct.php");

$obCon = new ProcesoVenta($idUser);

print("<html>");
print("<head>");
$css =  new CssIni("Facturacion");
$css->AgregarCssGrid();
print("</head>");
print("<body>");
    
        
    $css->CabeceraIni("Generar Facturacion Frecuente"); //Inicia la cabecera de la pagina
    $css->CabeceraFin();    
    
    ///////////////Creamos el contenedor
    /////
    /////
     
     
    $css->CrearDiv("principal", "container", "center",1,1);
    $ConsultaCajas=$obCon->ConsultarTabla("cajas", "WHERE idUsuario='$idUser' AND Estado='ABIERTA'");
    $DatosCaja=$obVenta->FetchArray($ConsultaCajas);
    $idCaja=$DatosCaja["ID"];
    if($DatosCaja["ID"]<=0){
       $css->CrearNotificacionRoja("No tiene asignada una Caja, por favor Asignese a una Caja, <a href='HabilitarUser.php' target='_blank'>Vamos</a>", 16);
       exit();
    }  
    
    ////Menu de historial
    $css->CrearDiv("DivButtons", "", "", 0, 0);
    
        
        $css->CrearInputText("idFacturaActiva", "text", "", "", "", "", "", "", 200, 30, 1, 0);     
    $css->CerrarDiv();
    $css->CrearTabla();
        $css->FilaTabla(14);
            $css->ColTabla("<strong>Buscar X Cliente<strong>", 1);
            $css->ColTabla("<strong>Cargar<strong>", 1);
            $css->ColTabla("<strong>Agregar<strong>", 1);
            $css->ColTabla("<strong>Fecha Facturas<strong>", 1);
            $css->ColTabla("<strong>Generar Facturación<strong>", 1);
        $css->CierraFilaTabla();
        $css->FilaTabla(14);
            print("<td>");
                $css->CrearSelect("idCliente", "DibujeFacturasFrecuentes()",400);
                    $css->CrearOptionSelect("", "Buscar Cliente", 0);
                $css->CerrarSelect();
            print("</td>");
            print("<td>");
                $css->CrearBotonEvento("BtnBuscar", "Todas", 1, "OnClick", "DibujeFacturasFrecuentes('1')", "verde", "");
               
            print("</td>");
            print("<td style='text-align:center'>");
                $css->CrearBotonOcultaDiv("", "DivAgregarConceptos", 20, 20, 0, "");
            print("</td>");
            print("<td>");
                $css->CrearInputText("TxtFecha", "date", "", date("Y-m-d"), "", "", "", "", 150, 30, 0, 0);
                
            print("</td>");
            print("<td>");
                
                $css->CrearBotonEvento("BtnGenerar", "Generar Facturas", 1, "OnClick", "GenereFacturasFrecuentes()", "rojo", "");
               
            print("</td>");
        $css->CierraFilaTabla();
        
    $css->CerrarTabla();
        
        $css->CrearDiv("DivAgregarConceptos", "", "center", 0, 1);
    
        $css->CrearTabla();
             
            $css->FilaTabla(16);
                $css->ColTabla("<strong>Servicio</strong>", 1);
                $css->ColTabla("<strong>Cantidad</strong>", 1);
                $css->ColTabla("<strong>Agregar</strong>", 1);
            $css->CierraFilaTabla();
            $css->FilaTabla(14);

                print("<td>");
                    $css->CrearSelect("idServicio", "",400);
                        $css->CrearOptionSelect("", "Buscar Servicio", 0);
                    $css->CerrarSelect();
                print("</td>");
                print("<td>");
                    $css->CrearInputNumber("TxtCantidadServicio", "number", "", 1, "Cantidad", "", "", "", 100, 30, 0, 0, 0, "", "any");
                print("</td>");
                print("<td>");
                    $css->CrearBotonEvento("BtnAgregar", "Agregar", 1, "OnClick", "AgregaServicio()", "verde", "");
                print("</td>");
            $css->CierraFilaTabla();

            $css->FilaTabla(14);
                $css->ColTabla("<strong>Producto</strong>", 1);
                $css->ColTabla("<strong>Cantidad</strong>", 1);
                $css->ColTabla("<strong>Agregar</strong>", 1);
            $css->CierraFilaTabla();
            $css->FilaTabla(14);

                print("<td>");
                    $css->CrearSelect("idProducto", "",400);
                        $css->CrearOptionSelect("", "Buscar Producto", 0);
                    $css->CerrarSelect();
                print("</td>");
                print("<td>");
                    $css->CrearInputNumber("TxtCantidadProducto", "number", "", 1, "Cantidad", "", "", "", 100, 30, 0, 0, 0, "", "any");
                print("</td>");
                
                print("<td>");
                    $css->CrearBotonEvento("BtnAgregar", "Agregar", 1, "OnClick", "AgregaProducto()", "verde", "");
                print("</td>");
            $css->CierraFilaTabla();
        $css->CerrarTabla();
        $css->CerrarDiv();  
    
       
    ///////////////Se crea el DIV que servirá de contenedor secundario
    /////
    /////
    $css->CrearDiv("Secundario", "", "center",1,1);
    $css->CrearDiv("DivProcesando", "container", "center", 1, 1);
    $css->CerrarDiv();
    $css->ProgressBar("PgProgresoCMG", "LyProgresoCMG", "", 0, 0, 100, 0, "0%", "", "");
    $css->CrearDiv("DivMensajes", "container", "center", 1, 1);
    $css->CerrarDiv();
     /////////////////Cuadro de dialogo de Clientes create
    $css->DivGrid("DivListFacturas", "", "left", 1, 1, 1, 90, 35,5,"transparent");
    
    
    $css->CerrarDiv();
    $css->DivGrid("DivItemsFacturas", "", "center", 1, 1, 3, 90, 64,5,"transparent");
        $css->CrearNotificacionVerde("Items Agregados a esta factura", 16);
    $css->CerrarDiv();
    
      
    
    $css->CrearDiv("DivItemsRecetas", "container", "center", 1, 1);
    $css->CerrarDiv();
    $css->CerrarDiv();//Cerramos contenedor Secundario
    $css->CerrarDiv();//Cerramos contenedor Principal
    $css->AgregaJS(); //Agregamos javascripts
    $css->AgregaCssJSSelect2(); //Agregamos CSS y JS de Select2
    $css->AgregaSubir();
    
    print('<script src="jsPages/FacturacionFrecuente.js"></script>');
    print('<script>DibujeFacturasFrecuentes();</script>');
    print("</body></html>");
    ob_end_flush();
?>