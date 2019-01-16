<?php 
$myPage="RegistraCompra.php";
include_once("../sesiones/php_control.php");
include_once("clases/ClasesCompras.php");
include_once("clases/Recetas.class.php");
include_once("css_construct.php");

print("<html>");
print("<head>");
$css =  new CssIni("Compras");
$obVenta=new ProcesoVenta($idUser);  
$obTabla = new Tabla($db);
$obCompra=new Compra($idUser);
$obInsumos=new Recetas($idUser);
$idCompra=0;
$TipoMovimiento=0;
if(isset($_REQUEST["idCompra"])){
    $idCompra=$obVenta->normalizar($_REQUEST["idCompra"]);
}

print("</head>");
print("<body>");
    
    $css->CabeceraIni("Registrar Compra"); //Inicia la cabecera de la pagina
    $css->CreaBotonDesplegable("Proveedor","Crear Tercero");
    $css->CreaBotonDesplegable("CrearCompra","Nueva");  
    $css->CabeceraFin(); 
    
    include_once 'cuadros_dialogo/RegistraCompraCuadrosDialogo.php';
    ///////////////Creamos el contenedor
    $css->DivNotificacionesJS();    
    $css->CrearDiv("principal", "container", "center",1,1);
    //si se creó la compra se crea el link para verla
    if(isset($_REQUEST["idCompraCreada"])){
        $idCompraCreada=$_REQUEST["idCompraCreada"];
        $css->CrearNotificacionVerde("Compra $idCompraCreada Creada Satisfactoriamente <a target='_blank'  href='PDF_FCompra.php?ID=$idCompraCreada'>ver</a>", 16);
    }
    //si se creó el traslado se crea el link para verlo
    if(isset($_REQUEST["idTrasladoCreado"]) and !empty($_REQUEST["idTrasladoCreado"])){
        $idTrasladoCreado=$_REQUEST["idTrasladoCreado"];
        $Ruta="../tcpdf/examples/imprimirTraslado.php?idTraslado=$idTrasladoCreado";
        $css->CrearNotificacionAzul("Traslado $idTrasladoCreado Creado Satisfactoriamente <a target='_blank' href='$Ruta'>ver</a>", 16);
    }
    
    
    include_once("procesadores/RegistraCompra.process.php");
    $css->CrearForm2("FrmSeleccionaCom", $myPage, "post", "_self");
    $css->CrearSelect("idCompra", "EnviaForm('FrmSeleccionaCom')");
        
            $css->CrearOptionSelect("","Selecciona una Compra",0);
            
            $consulta = $obVenta->ConsultarTabla("factura_compra","WHERE Estado='ABIERTA'");
            while($DatosComprobante=$obVenta->FetchArray($consulta)){
                if($idCompra==$DatosComprobante['ID']){
                    $Sel=1;
                    
                }else{
                    
                    $Sel=0;
                }
                $DatosTercero=$obCompra->DevuelveValores("proveedores", "Num_Identificacion", $DatosComprobante['Tercero']);
                $css->CrearOptionSelect($DatosComprobante['ID'],$DatosComprobante['ID']." ".$DatosTercero["RazonSocial"]." ".$DatosComprobante['Concepto']." ".$DatosComprobante['NumeroFactura'],$Sel);							
            }
        $css->CerrarSelect();
    $css->CerrarForm();
     
    ///////////////Se crea el DIV que servirá de contenedor secundario
    /////
    /////
    $css->CrearDiv("Secundario", "container", "center",1,1);
   										
    if($idCompra>0){
        $css->CrearTabla();
            $css->FilaTabla(16);
                $css->ColTabla("<strong>Buscar Producto:<strong>", 1);
                $css->ColTabla("<strong>Buscar Insumo:<strong>", 1);
                print("<td>");
                print("<strong>Agregar Servicio: <strong>");
                $css->ImageOcultarMostrar("ImgHidden", "Click: ", "DivAgregaServicio", 30, 30, "");
                print("</td>");
                print("<td>");
                print("<strong>Datos Compra: <strong>");
                $css->ImageOcultarMostrar("ImgHidden2", "Click: ", "DivEditFactura", 30, 30, "");
                print("</td>");
                
                
            $css->CierraFilaTabla();
            $css->FilaTabla(16);
                print("<td>");
                $Page="Consultas/BuscarItemsCompras.php?TipoItem=1&myPage=$myPage&idCompra=$idCompra&key=";
                $css->CrearInputText("TxtProducto", "text", "", "", "Buscar Producto", "", "onKeyPress", "EnvieObjetoConsulta(`$Page`,`TxtProducto`,`DivBusquedas`,`0`);", 200, 30, 0, 1);
                print("</td>");
                print("<td>");
                $Page="Consultas/BuscarItemsCompras.php?TipoItem=2&myPage=$myPage&idCompra=$idCompra&key=";
                $css->CrearInputText("TxtInsumos", "text", "", "", "Buscar Insumos", "", "onKeyPress", "EnvieObjetoConsulta(`$Page`,`TxtInsumos`,`DivBusquedas`,`0`);", 200, 30, 0, 1);
                print("</td>");
                print("<td>");
                $css->CrearDiv("DivAgregaServicio", "", "Center", 0, 1);
                $css->CrearForm2("FrmAgregarServicio", $myPage, "post", "_Self");
                $css->CrearInputText("idCompra", "hidden", "", $idCompra, "", "", "", "", "", "", 1, 1);
                
                $VarSelect["Required"]="1";
                $VarSelect["Ancho"]="200";
                $VarSelect["PlaceHolder"]="Seleccione la cuenta del servicio";
                $css->CrearSelectChosen("CmbCuentaServicio", $VarSelect);
                $consulta=$obVenta->ConsultarTabla("subcuentas", "WHERE PUC NOT LIKE '4%' ORDER BY Cuentas_idPUC");
                while($DatosCuenta=$obVenta->FetchArray($consulta)){
                    $sel=0;
                    if($DatosCuenta["PUC"]=="513530"){
                        $sel=1;
                    }
                    $css->CrearOptionSelect($DatosCuenta["PUC"], $DatosCuenta["PUC"]." ".$DatosCuenta["Nombre"] , $sel);
                }
                $css->CerrarSelect();
                print("<br>");
                $css->CrearTextArea("TxtConceptoServicio", "", "", "Escriba el concepto", "", "", "", 200, 60, 0, 1);
                print("<br>");
                $css->CrearInputNumber("TxtValor", "number", "", "", "Valor", "", "", "", 200, 30, 0, 1, 1, "", "any");
                print("<br>");
                $css->CrearSelectTable("CmbTipoIva", "porcentajes_iva", "", "Valor", "Nombre", "", "", "", "", 1);
                print("<br>");
                $css->CrearBotonConfirmado("BtnAgregarServicio", "Agregar");
                $css->CerrarForm();
                $css->CerrarDiv();
                print("</td>");
                print("<td>");
                $DatosFacturaCompra=$obCompra->DevuelveValores("factura_compra", "ID", $idCompra);
                $css->CrearDiv("DivEditFactura", "", "Center", 0, 1);
                $css->CrearForm2("FrmEditarDatos", $myPage, "post", "_self");
                $css->CrearInputText("idCompra", "hidden", "", $idCompra, "", "", "", "", "", "", 1, 1);
                $css->CrearInputFecha("", "TxtFechaEdit", $DatosFacturaCompra["Fecha"], 100, 30, "");
                print("<strong>Tercero:</strong><br>");
                $VarSelect["Required"]="1";
                $VarSelect["Ancho"]="200";
                $VarSelect["PlaceHolder"]="Seleccione un Tercero";
                $css->CrearSelectChosen("CmbTerceroEdit", $VarSelect);
                $consulta=$obVenta->ConsultarTabla("proveedores", "");
                while($DatosCuenta=$obVenta->FetchArray($consulta)){
                    $sel=0;
                    if($DatosCuenta["Num_Identificacion"]==$DatosFacturaCompra["Tercero"]){
                        $sel=1;
                    }
                    $css->CrearOptionSelect($DatosCuenta["Num_Identificacion"], $DatosCuenta["Num_Identificacion"]." ".$DatosCuenta["RazonSocial"] , $sel);
                }
                $css->CerrarSelect();
                print("<br><strong>Num Factura:</strong><br>");
                $css->CrearInputText("TxtNumFacturaEdit", "text", "", $DatosFacturaCompra["NumeroFactura"], "NumFactura", "", "", "", 200, 30, 0, 1);
                //$css->CrearTextArea("TxtNumFacturaEdit", "", $DatosFacturaCompra["Concepto"], "Escriba el concepto", "", "", "", 200, 60, 0, 1);
                
                print("<br><strong>Concepto:</strong><br>");
                $css->CrearTextArea("TxtConceptoServicioEdit", "", $DatosFacturaCompra["Concepto"], "Escriba el concepto", "", "", "", 200, 60, 0, 1);
                print("<br>");
                $css->CrearBotonConfirmado("BtnEditarFactura", "Editar");
                $css->CerrarForm();
                $css->CerrarDiv();
                print("</td>");
                
            $css->CierraFilaTabla();
            
            
        $css->CerrarTabla();
        
        $css->CrearBotonEvento("BtnRetenciones", "+ Retenciones a Productos", 1, "onclick", "MuestraOculta('DivRetenciones')", "naranja", "");
        $css->CrearBotonEvento("BtnRetenciones", "+ Retenciones a Servicios", 1, "onclick", "MuestraOculta('DivRetencionesServicios')", "verde", "");
        $css->CrearBotonEvento("BtnMostrarProductos", "V/O Productos Agregados", 1, "onclick", "MuestraOculta('DivProductos')", "rojo", "");
        $css->CrearBotonEvento("BtnMostrarProductos", "V/O Productos Devueltos", 1, "onclick", "MuestraOculta('DivProductosDevueltos')", "verde", "");
        
        $css->CrearBotonEvento("BtnMostrarServicios", "V/O Servicios", 1, "onclick", "MuestraOculta('DivServicios')", "naranja", "");
        $css->CrearBotonEvento("BtnMostrarProductos", "V/O Retenciones", 1, "onclick", "MuestraOculta('DivRetencionesPracticadas')", "rojo", "");
        $TotalesCompra=$obCompra->CalculeTotalesCompra($idCompra);
        $css->CrearDiv("DivRetenciones", "", "center", 0, 1);
        $css->CrearTabla();
                       
            $Subtotal=$TotalesCompra["Subtotal_Productos_Add"];
            $IVA=$TotalesCompra["Impuestos_Productos_Add"];
            $Total=$TotalesCompra["Total_Productos_Add"];
            
            $SubtotalDev=$TotalesCompra["Subtotal_Productos_Dev"];
            $IVADev=$TotalesCompra["Impuestos_Productos_Dev"];
            $TotalDev=$TotalesCompra["Total_Productos_Dev"];
            $GranSubTotal=$TotalesCompra["Gran_Subtotal"];
            $GranIVA=$TotalesCompra["Gran_Impuestos"];
            $GranTotal=$TotalesCompra["Gran_Total"];
            
            $TotalAPagar=$TotalesCompra["Total_Pago"];
            $css->FilaTabla(16);
                $css->ColTabla("<strong>Agregar Retenciones productos a esta Compra, Subtotal=$". number_format($TotalesCompra["Subtotal_Productos"]).", Impuestos=$". number_format($TotalesCompra["Impuestos_Productos"])." , Total=$". number_format($TotalesCompra["Total_Productos"])."<strong>", 4);
            $css->CierraFilaTabla();
            $css->FilaTabla(16);
                $css->ColTabla("<strong>Retefuente:<strong>", 1);
                $css->ColTabla("<strong>ReteICA:<strong>", 1);
                $css->ColTabla("<strong>ReteIVA:<strong>", 1);
                
            $css->CierraFilaTabla();
            $css->FilaTabla(16);
                print("<td>");
                $css->CrearForm2("FrmReteFuente", $myPage, "post", "_self");
                    $css->CrearInputText("idCompra", "hidden", "", $idCompra, "", "", "", "", "", "", "", 1);
                    $VarSelect["Required"]="200";
                    $VarSelect["Ancho"]="200";
                    $VarSelect["PlaceHolder"]="Seleccione la cuenta de la retencion";
                    $css->CrearSelectChosen("CmbCuentaReteFuente", $VarSelect);
                    $consulta=$obVenta->ConsultarTabla("subcuentas", "WHERE PUC LIKE '2365%' ");
                    while($DatosCuentaRete=$obVenta->FetchArray($consulta)){
                        $sel=0;
                        if($DatosCuentaRete["PUC"]=="236540"){
                            $sel=1;
                        }
                        $css->CrearOptionSelect($DatosCuentaRete["PUC"], $DatosCuentaRete["PUC"]." ".$DatosCuentaRete["Nombre"] , $sel);
                    }
                    $css->CerrarSelect();
                    $SubtotalProductos=$TotalesCompra["Subtotal_Productos"];
                    $ImpuestoProductos=$TotalesCompra["Impuestos_Productos"];
                    $css->CrearInputNumber("TxtPorReteFuente", "text", "<br><br>Porcentaje: ", 0, "Porcentaje ReteFuente", "Black", "onkeyup", "CalculeReteFuenteCompra($SubtotalProductos)", 70, 30, 0, 0, 0, 100, "any");
                    $css->CrearInputNumber("TxtReteFuenteProductos", "number", " Valor: ", 0, "ReteFuente", "Black", "onkeyup", "CalculePorcentajeReteFuenteCompra($SubtotalProductos)", 100, 30, 0, 0, 1,$GranSubTotal, "any");
                    $css->CrearBotonConfirmado("BtnAgregueReteFuente", "Agregar");
                $css->CerrarForm();    
                print("</td>");
                print("<td>");
                $css->CrearForm2("FrmReteICA", $myPage, "post", "_self");
                    $css->CrearInputText("idCompra", "hidden", "", $idCompra, "", "", "", "", "", "", "", 1);
                    $VarSelect["Required"]="200";
                    $VarSelect["Ancho"]="200";
                    $VarSelect["PlaceHolder"]="Seleccione la cuenta de la retencion";
                    $css->CrearSelectChosen("CmbCuentaReteICA", $VarSelect);
                    $consulta=$obVenta->ConsultarTabla("subcuentas", "WHERE PUC LIKE '2368%'");
                    while($DatosCuentaRete=$obVenta->FetchArray($consulta)){
                        $sel=0;
                        
                        $css->CrearOptionSelect($DatosCuentaRete["PUC"], $DatosCuentaRete["PUC"]." ".$DatosCuentaRete["Nombre"] , $sel);
                    }
                    $css->CerrarSelect();
                    $css->CrearInputNumber("TxtPorReteICA", "text", "<br><br>Porcentaje: ", 0, "Porcentaje ReteFuente", "Black", "onkeyup", "CalculeReteICACompra($SubtotalProductos)", 70, 30, 0, 0, 0, 100, "any");
                    $css->CrearInputNumber("TxtReteICA", "number", " Valor: ", 0, "ReteICA", "Black", "onkeyup", "CalculePorcentajeICACompra($SubtotalProductos)", 100, 30, 0, 0, 1, $SubtotalProductos, "any");
                    $css->CrearBotonConfirmado("BtnAgregueReteICA", "Agregar");
                $css->CerrarForm();    
                print("</td>");
                print("<td>");
                $css->CrearForm2("FrmReteIVA", $myPage, "post", "_self");
                    $css->CrearInputText("idCompra", "hidden", "", $idCompra, "", "", "", "", "", "", "", 1);
                    $VarSelect["Required"]="200";
                    $VarSelect["Ancho"]="200";
                    $VarSelect["PlaceHolder"]="Seleccione la cuenta de la retencion";
                    $css->CrearSelectChosen("CmbCuentaReteIVA", $VarSelect);
                    $consulta=$obVenta->ConsultarTabla("subcuentas", "WHERE PUC LIKE '2367%'");
                    while($DatosCuentaRete=$obVenta->FetchArray($consulta)){
                        $sel=0;
                        
                        $css->CrearOptionSelect($DatosCuentaRete["PUC"], $DatosCuentaRete["PUC"]." ".$DatosCuentaRete["Nombre"] , $sel);
                    }
                    $css->CerrarSelect();
                    $css->CrearInputNumber("TxtPorReteIVA", "text", "<br><br>Porcentaje: ", 0, "Porcentaje ReteFuente", "Black", "onkeyup", "CalculeReteIVACompra($ImpuestoProductos)", 70, 30, 0, 0, 0, 100, "any");
                    $css->CrearInputNumber("TxtReteIVA", "number", " Valor: ", 0, "ReteIVA", "Black", "onkeyup", "CalculePorcentajeIVACompra($ImpuestoProductos)", 100, 30, 0, 0, 1, $ImpuestoProductos, "any");
                    $css->CrearBotonConfirmado("BtnAgregueReteIVA", "Agregar");
                $css->CerrarForm();    
                print("</td>");
                
            $css->CierraFilaTabla();
        $css->CerrarTabla();
        $css->CerrarDiv();
        ///Div agregar retenciones servicios
        
        $css->CrearDiv("DivRetencionesServicios", "", "center", 0, 1);
        $css->CrearTabla();
            $SubtotalServicios=$TotalesCompra["Subtotal_Servicios"];
            $ImpuestosServicios=$TotalesCompra["Impuestos_Servicios"];
            $css->FilaTabla(16);
                $css->ColTabla("<strong>Agregar Retenciones en servicios, Subtotal=$". number_format($TotalesCompra["Subtotal_Servicios"]).", Impuestos=$". number_format($TotalesCompra["Impuestos_Servicios"])." , Total=$". number_format($TotalesCompra["Total_Servicios"])."<strong>", 4);
            $css->CierraFilaTabla();
            $css->FilaTabla(16);
                $css->ColTabla("<strong>Retefuente:<strong>", 1);
                $css->ColTabla("<strong>ReteICA:<strong>", 1);
                $css->ColTabla("<strong>ReteIVA:<strong>", 1);
                
            $css->CierraFilaTabla();
            $css->FilaTabla(16);
                print("<td>");
                $css->CrearForm2("FrmReteFuenteSer", $myPage, "post", "_self");
                    $css->CrearInputText("idCompra", "hidden", "", $idCompra, "", "", "", "", "", "", "", 1);
                    $VarSelect["Required"]="200";
                    $VarSelect["Ancho"]="200";
                    $VarSelect["PlaceHolder"]="Seleccione la cuenta de la retencion";
                    $css->CrearSelectChosen("CmbCuentaReteFuenteServicios", $VarSelect);
                    $consulta=$obVenta->ConsultarTabla("subcuentas", "WHERE PUC LIKE '2365%'");
                    while($DatosCuentaRete=$obVenta->FetchArray($consulta)){
                        $sel=0;
                        if($DatosCuentaRete["PUC"]=="236525"){
                            $sel=1;
                        }
                        $css->CrearOptionSelect($DatosCuentaRete["PUC"], $DatosCuentaRete["PUC"]." ".$DatosCuentaRete["Nombre"] , $sel);
                    }
                    $css->CerrarSelect();
                    $css->CrearInputNumber("TxtPorReteFuenteServicios", "text", "<br><br>Porcentaje: ", 0, "Porcentaje ReteFuente", "Black", "onkeyup", "CalculeReteFuenteCompra(`$SubtotalServicios`,`1`)", 70, 30, 0, 0, 0, 100, "any");
                    $css->CrearInputNumber("TxtReteFuenteServicios", "number", " Valor: ", 0, "ReteFuente", "Black", "onkeyup", "CalculePorcentajeReteFuenteCompra(`$SubtotalServicios`,1)", 100, 30, 0, 0, 1,$SubtotalServicios, "any");
                    $css->CrearBotonConfirmado("BtnAgregueReteFuenteServicios", "Agregar");
                $css->CerrarForm();    
                print("</td>");
                print("<td>");
                $css->CrearForm2("FrmReteICAServicios", $myPage, "post", "_self");
                    $css->CrearInputText("idCompra", "hidden", "", $idCompra, "", "", "", "", "", "", "", 1);
                    $VarSelect["Required"]="200";
                    $VarSelect["Ancho"]="200";
                    $VarSelect["PlaceHolder"]="Seleccione la cuenta de la retencion";
                    $css->CrearSelectChosen("CmbCuentaReteICAServicios", $VarSelect);
                    $consulta=$obVenta->ConsultarTabla("subcuentas", "WHERE PUC LIKE '2368%'");
                    while($DatosCuentaRete=$obVenta->FetchArray($consulta)){
                        $sel=0;
                        
                        $css->CrearOptionSelect($DatosCuentaRete["PUC"], $DatosCuentaRete["PUC"]." ".$DatosCuentaRete["Nombre"] , $sel);
                    }
                    $css->CerrarSelect();
                    $css->CrearInputNumber("TxtPorReteICAServicios", "text", "<br><br>Porcentaje: ", 0, "Porcentaje ReteFuente", "Black", "onkeyup", "CalculeReteICACompra(`$SubtotalServicios`,`1`)", 70, 30, 0, 0, 0, 100, "any");
                    $css->CrearInputNumber("TxtReteICAServicios", "number", " Valor: ", 0, "ReteICA", "Black", "onkeyup", "CalculePorcentajeICACompra(`$SubtotalServicios`,`1`)", 100, 30, 0, 0, 1, $SubtotalServicios, "any");
                    $css->CrearBotonConfirmado("BtnAgregueReteICAServicios", "Agregar");
                $css->CerrarForm();    
                print("</td>");
                print("<td>");
                $css->CrearForm2("FrmReteIVAServicios", $myPage, "post", "_self");
                    $css->CrearInputText("idCompra", "hidden", "", $idCompra, "", "", "", "", "", "", "", 1);
                    $VarSelect["Required"]="200";
                    $VarSelect["Ancho"]="200";
                    $VarSelect["PlaceHolder"]="Seleccione la cuenta de la retencion";
                    $css->CrearSelectChosen("CmbCuentaReteIVAServicios", $VarSelect);
                    $consulta=$obVenta->ConsultarTabla("subcuentas", "WHERE PUC LIKE '2367%'");
                    while($DatosCuentaRete=$obVenta->FetchArray($consulta)){
                        $sel=0;
                        
                        $css->CrearOptionSelect($DatosCuentaRete["PUC"], $DatosCuentaRete["PUC"]." ".$DatosCuentaRete["Nombre"] , $sel);
                    }
                    $css->CerrarSelect();
                    $css->CrearInputNumber("TxtPorReteIVAServicios", "text", "<br><br>Porcentaje: ", 0, "Porcentaje ReteFuente", "Black", "onkeyup", "CalculeReteIVACompra(`$ImpuestosServicios`,`1`)", 70, 30, 0, 0, 0, 100, "any");
                    $css->CrearInputNumber("TxtReteIVAServicios", "number", " Valor: ", 0, "ReteIVA", "Black", "onkeyup", "CalculePorcentajeIVACompra(`$ImpuestosServicios`,`1`)", 100, 30, 0, 0, 1, $ImpuestosServicios, "any");
                    $css->CrearBotonConfirmado("BtnAgregueReteIVAServicios", "Agregar");
                $css->CerrarForm();    
                print("</td>");
                
            $css->CierraFilaTabla();
        $css->CerrarTabla();
        $css->CerrarDiv();
        
        $DivVisible=0;
        //print_r($TotalesCompra);
        if($TotalesCompra["Total_Servicios"]>0 or $TotalesCompra["Total_Productos"]>0 or $TotalesCompra["Total_Insumos"]>0){
            $DivVisible=1;
        }
        $css->CrearDiv("DivTotales", "", "center", $DivVisible, 0);
        $css->CrearNotificacionAzul("Esta Compra:", 16);
        $css->CrearForm2("FrmGuardarCompra", $myPage, "post", "_self");
        $css->CrearInputText("idCompra", "hidden", "", $idCompra, "", "", "", "", "", "", 0, 1);
            $css->CrearTabla();
                $css->FilaTabla(14);
                    $css->ColTabla("<strong>Subtotal:</strong>", 1);
                    $css->ColTabla("<strong>Descuentos:</strong>", 1);
                    $css->ColTabla("<strong>Valor:</strong>", 1);
                    $css->ColTabla("<strong>Impuestos:</strong>", 1);
                    $css->ColTabla("<strong>Total:</strong>", 1);
                    $css->ColTabla("<strong>Retenciones:</strong>", 1);
                    $css->ColTabla("<strong>Devoluciones:</strong>", 1);
                    $css->ColTabla("<strong>Impuestos Devueltos:</strong>", 1);
                    $css->ColTabla("<strong>Total a Pagar:</strong>", 1);
                    $css->ColTabla("<strong>Tipo Pago:</strong>", 1);
                    $css->ColTabla("<strong>Opciones</strong>", 1);
                $css->CierraFilaTabla();
                $css->FilaTabla(14);
                    $css->ColTabla(number_format($TotalesCompra["Subtotal_Descuentos_Productos_Add"]+$TotalesCompra["Subtotal_Productos_Add"]+$TotalesCompra["Subtotal_Servicios"]+$TotalesCompra["Subtotal_Insumos"]), 1);
                    $css->ColTabla(number_format($TotalesCompra["Subtotal_Descuentos_Productos_Add"]), 1);
                    $css->ColTabla(number_format($TotalesCompra["Subtotal_Productos_Add"]+$TotalesCompra["Subtotal_Servicios"]+$TotalesCompra["Subtotal_Insumos"]), 1);
                    $css->ColTabla(number_format($TotalesCompra["Impuestos_Productos_Add"]+$TotalesCompra["Impuestos_Servicios"]+$TotalesCompra["Impuestos_Insumos"]), 1);
                    $css->ColTabla(number_format($TotalesCompra["Total_Productos_Add"]+$TotalesCompra["Total_Servicios"]+$TotalesCompra["Total_Insumos"]), 1);
                    $css->ColTabla(number_format($TotalesCompra["Total_Retenciones"]), 1);
                    $css->ColTabla(number_format($TotalesCompra["Subtotal_Productos_Dev"]), 1);
                    $css->ColTabla(number_format($TotalesCompra["Impuestos_Productos_Dev"]), 1);
                    $css->ColTabla(number_format($TotalesCompra["Total_Pago"]), 1);
                    print("<td>");
                        $css->CrearSelect("CmbTipoPago", "MuestraOculta('DivCuentaOrigen');MuestraOculta('DivCuentaXPagar')");
                            $css->CrearOptionSelect("Contado", "Contado", 1);
                            $css->CrearOptionSelect("Credito", "Credito", 0);
                        $css->CerrarSelect();
                        $css->CrearDiv("DivCuentaOrigen", "", "left", 1, 1);
                        print("<strong>Cuenta Origen: </strong><br>");
                            $css->CrearSelect("CmbCuentaOrigen", "");
                            $consulta=$obVenta->ConsultarTabla("subcuentas", " WHERE PUC LIKE '11%'");
                            while($DatosCuenta=$obVenta->FetchArray($consulta)){
                                $sel=0;
                                if($DatosCuenta["PUC"]==1105){
                                    $sel=1;
                                }
                                $css->CrearOptionSelect($DatosCuenta["PUC"], $DatosCuenta["Nombre"]." ".$DatosCuenta["PUC"], $sel);
                            }
                            
                        $css->CerrarSelect();
                        $css->CerrarDiv();
                        $css->CrearDiv("DivCuentaXPagar", "", "left", 0, 1);
                            
                            print("<strong>Llevar Cuenta X Pagar a: </strong><br>");
                            $css->CrearSelect("CmbCuentaPUCCXP", "");
                            $consulta=$obVenta->ConsultarTabla("subcuentas", " WHERE PUC LIKE '22%' or PUC LIKE '23%' or PUC LIKE '24%'");
                            while($DatosCuenta=$obVenta->FetchArray($consulta)){
                                $sel=0;
                                if($DatosCuenta["PUC"]==220505){
                                    $sel=1;
                                }
                                $css->CrearOptionSelect($DatosCuenta["PUC"], $DatosCuenta["Nombre"]." ".$DatosCuenta["PUC"], $sel);
                            }
                            
                        $css->CerrarSelect();
                        $css->CrearInputText("TxtFechaProgramada", "date", "Fecha Programada <br>", date("Y-m-d"), "Fecha Programada", "", "", "", 150, 30, 0, 0);
                        $css->CerrarDiv();
                    print("</td>");
                    print("<td>");
                    print("<strong>Traslado?</strong><br>");
                    $css->CrearSelectTable("CmbTraslado", "empresa_pro_sucursales", "", "ID", "Nombre", "Ciudad", "", "", "", 0);
                    
                    $css->CrearBotonConfirmado("BtnGuardarCompra", "Guardar");
                    print("</td>");
                $css->CierraFilaTabla();
            $css->CerrarTabla();
        $css->CerrarForm();
        $css->CerrarDiv();
    }
    
    $css->CrearDiv("DivBusquedas", "", "center", 1, 1);
    $css->CerrarDiv();
    //Div retenciones aplicadas
    $css->CrearDiv("DivRetencionesPracticadas", "", "center", 0, 1);
        $consulta=$obVenta->ConsultarTabla("factura_compra_retenciones", "WHERE idCompra='$idCompra'");
        if($obVenta->NumRows($consulta)){
            $css->CrearNotificacionAzul("Retenciones practicadas a esta compra", 16);
            $css->CrearTabla();
            while ($DatosRetenciones=$obVenta->FetchArray($consulta)){
                $css->FilaTabla(14);
                $css->ColTabla($DatosRetenciones["CuentaPUC"], 1);
                $css->ColTabla($DatosRetenciones["NombreCuenta"], 1);
                $css->ColTabla(number_format($DatosRetenciones["ValorRetencion"]), 1);
                $css->ColTabla($DatosRetenciones["PorcentajeRetenido"], 1);
                print("<td>");
                $link="$myPage?DelRetencion=$DatosRetenciones[ID]&idCompra=$idCompra";
                $css->CrearLink($link, "_self", "X");
                print("</td>");
                $css->CierraFilaTabla();
            }
            $css->CerrarTabla();
        }else{
            $css->CrearNotificacionAzul("No hay retenciones practicadas a esta compra", 16);
        }
        
    $css->CerrarDiv();
    //Div con los productos
    if($idCompra>0){
    $css->CrearDiv("DivProductos", "", "Center", 1, 1);
    
        $consulta=$obVenta->ConsultarTabla("factura_compra_items", "WHERE idFacturaCompra='$idCompra'");
        if($obVenta->NumRows($consulta)){
            $css->CrearNotificacionVerde("Productos agregados a esta Compra", 16);
            $css->CrearTabla();
            $css->FilaTabla(14);
               
               $css->ColTabla("<strong>idProducto</strong>", 1);
               $css->ColTabla("<strong>Imprimir</strong>", 1);
               $css->ColTabla("<strong>Nombre</strong>", 1);
               $css->ColTabla("<strong>Cantidad</strong>", 1);
               $css->ColTabla("<strong>CostoUnitario</strong>", 1);
               
               $css->ColTabla("<strong>Subtotal</strong>", 1);
               $css->ColTabla("<strong>Impuestos</strong>", 1);
               $css->ColTabla("<strong>Total</strong>", 1);
               $css->ColTabla("<strong>% Impuestos</strong>", 1);
               $css->ColTabla("<strong>% Descuento</strong>", 1);
               $css->ColTabla("<strong>Borrar</strong>", 1);
               $css->ColTabla("<strong>Devolucion</strong>", 1);
               $css->CierraFilaTabla();
            while($DatosItems=$obVenta->FetchAssoc($consulta)){
               $css->FilaTabla(14);
               $idProducto=$DatosItems["idProducto"];
               $DatosProducto=$obVenta->DevuelveValores("productosventa", "idProductosVenta", $idProducto);
               $DatosIVA=$obVenta->DevuelveValores("porcentajes_iva", "Valor", $DatosItems["Tipo_Impuesto"]);
                    $css->ColTabla($idProducto, 1);
                    print("<td>");
                        $css->CrearInputNumber("TxtCantidadCodigos$idProducto", "number", "Cantidad:", 1, "Cantidad", "black", "", "", 100, 30, 0, 0, 1, 1000, 1);
                        $RutaPrint="ProcesadoresJS/PrintCodigoBarras.php?TipoCodigo=1&idProducto=$idProducto&TxtCantidad=";
                        $css->CrearBotonEvento("BtnPrintCB$idProducto", "BARRAS", 1, "onclick", "EnvieObjetoConsulta(`$RutaPrint`,`TxtCantidadCodigos$idProducto`,`DivRespuestasJS`,`0`)", "naranja", "");
                
                    print("</td>");
                    $css->ColTabla($DatosProducto["Nombre"], 1);
                    $css->ColTabla(number_format($DatosItems["Cantidad"]), 1);
                    
                    $css->ColTabla(number_format($DatosItems["CostoUnitarioCompra"]), 1);
                    $css->ColTabla(number_format($DatosItems["SubtotalCompra"]), 1);
                    $css->ColTabla(number_format($DatosItems["ImpuestoCompra"]), 1);
                    $css->ColTabla(number_format($DatosItems["TotalCompra"]), 1);
                    $css->ColTabla($DatosIVA["Nombre"], 1);
                    print("<td>");
                        
                        $css->CrearForm2("FrmDescuentos".$DatosItems["ID"], $myPage, "post", "_self");
                            $css->CrearInputText("idCompra", "hidden", "", $idCompra, "", "", "", "", "", "", 0, 1);
                            $css->CrearInputText("idProducto", "hidden", "", $DatosItems["idProducto"], "", "", "", "", "", "", 0, 1);
                            $css->CrearInputText("idFacturaItems", "hidden", "", $DatosItems["ID"], "", "", "", "", "", "", 0, 1);
                            $css->CrearInputNumber("TxtDescuentoCompra", "number", "", 0, "Dev", "", "", "", 100, 30, 0, 1, 0, 100, "any");
                            $css->CrearBotonConfirmado("BtnAplicaDescuento", "Descuento");
                        $css->CerrarForm();
                    print("</td>");
                    $css->ColTablaDel($myPage, "factura_compra_items", "ID", $DatosItems["ID"], $idCompra);
                    print("<td>");
                        $TotalItemsDevueltos=$obVenta->Sume("factura_compra_items_devoluciones", "Cantidad", "WHERE idFacturaCompra='$idCompra'");
                        $MaxCantidad=$DatosItems["Cantidad"]-$TotalItemsDevueltos;
                        $css->CrearForm2("FrmDevolverItem".$DatosItems["ID"], $myPage, "post", "_self");
                            $css->CrearInputText("idCompra", "hidden", "", $idCompra, "", "", "", "", "", "", 0, 1);
                            $css->CrearInputText("idProducto", "hidden", "", $DatosItems["idProducto"], "", "", "", "", "", "", 0, 1);
                            $css->CrearInputText("idFacturaItems", "hidden", "", $DatosItems["ID"], "", "", "", "", "", "", 0, 1);
                            $css->CrearInputNumber("TxtCantidadDev", "number", "", 0, "Dev", "", "", "", 100, 30, 0, 1, 0, "", "any");
                            $css->CrearBotonConfirmado("BtnDevolverItem", "Devolver");
                        $css->CerrarForm();
                    print("</td>");
               $css->CierraFilaTabla();
            }
            $css->CerrarTabla();
        }else{
            $css->CrearNotificacionNaranja("No hay productos agregados a esta Compra", 16);
        }
        
        
        $consulta=$obVenta->ConsultarTabla("factura_compra_insumos", "WHERE idFacturaCompra='$idCompra'");
        if($obVenta->NumRows($consulta)){
            $css->CrearNotificacionAzul("Insumos agregados a esta Compra", 16);
            $css->CrearTabla();
            $css->FilaTabla(14);
               
               $css->ColTabla("<strong>idInsumo</strong>", 1);
               //$css->ColTabla("<strong>Imprimir</strong>", 1);
               $css->ColTabla("<strong>Nombre</strong>", 1);
               $css->ColTabla("<strong>Cantidad</strong>", 1);
               $css->ColTabla("<strong>CostoUnitario</strong>", 1);
               
               $css->ColTabla("<strong>Subtotal</strong>", 1);
               $css->ColTabla("<strong>Impuestos</strong>", 1);
               $css->ColTabla("<strong>Total</strong>", 1);
               $css->ColTabla("<strong>% Impuestos</strong>", 1);
               //$css->ColTabla("<strong>% Descuento</strong>", 1);
               $css->ColTabla("<strong>Borrar</strong>", 1);
               //$css->ColTabla("<strong>Devolucion</strong>", 1);
               $css->CierraFilaTabla();
            while($DatosItems=$obVenta->FetchAssoc($consulta)){
               $css->FilaTabla(14);
               $idProducto=$DatosItems["ID"];
               $DatosProducto=$obVenta->DevuelveValores("insumos", "ID", $idProducto);
               $DatosIVA=$obVenta->DevuelveValores("porcentajes_iva", "Valor", $DatosItems["Tipo_Impuesto"]);
                    $css->ColTabla($idProducto, 1);
                    
                    $css->ColTabla($DatosProducto["Nombre"], 1);
                    $css->ColTabla(number_format($DatosItems["Cantidad"]), 1);
                    
                    $css->ColTabla(number_format($DatosItems["CostoUnitarioCompra"]), 1);
                    $css->ColTabla(number_format($DatosItems["SubtotalCompra"]), 1);
                    $css->ColTabla(number_format($DatosItems["ImpuestoCompra"]), 1);
                    $css->ColTabla(number_format($DatosItems["TotalCompra"]), 1);
                    $css->ColTabla($DatosIVA["Nombre"], 1);
                    
                    $css->ColTablaDel($myPage, "factura_compra_insumos", "ID", $DatosItems["ID"], $idCompra);
                    
               $css->CierraFilaTabla();
            }
            $css->CerrarTabla();
        }else{
            $css->CrearNotificacionNaranja("No hay insumos agregados a esta Compra", 16);
        }
    $css->CerrarDiv();
    //DivServicios
    $css->CrearDiv("DivServicios", "", "Center", 1, 1);
    
        $consulta=$obVenta->ConsultarTabla("factura_compra_servicios", "WHERE idFacturaCompra='$idCompra'");
        if($obVenta->NumRows($consulta)){
            $css->CrearNotificacionVerde("Servicios agregados a esta Compra", 16);
            $css->CrearTabla();
            $css->FilaTabla(14);
               
               $css->ColTabla("<strong>Cuenta</strong>", 1);
               $css->ColTabla("<strong>Nombre</strong>", 1);
               $css->ColTabla("<strong>Concepto</strong>", 1);
               
               $css->ColTabla("<strong>Subtotal</strong>", 1);
               $css->ColTabla("<strong>Impuestos</strong>", 1);
               $css->ColTabla("<strong>Total</strong>", 1);
               $css->ColTabla("<strong>% Impuestos</strong>", 1);
               $css->ColTabla("<strong>Borrar</strong>", 1);
            $css->CierraFilaTabla();
            while($DatosItems=$obVenta->FetchAssoc($consulta)){
               $css->FilaTabla(14);
               
               $DatosIVA=$obVenta->DevuelveValores("porcentajes_iva", "Valor", $DatosItems["Tipo_Impuesto"]);
                    $css->ColTabla($DatosItems["CuentaPUC_Servicio"], 1);
                    $css->ColTabla($DatosItems["Nombre_Cuenta"], 1);
                    $css->ColTabla($DatosItems["Concepto_Servicio"], 1);
                    $css->ColTabla(number_format($DatosItems["Subtotal_Servicio"]), 1);
                    $css->ColTabla(number_format($DatosItems["Impuesto_Servicio"]), 1);
                    $css->ColTabla(number_format($DatosItems["Total_Servicio"]), 1);
                    
                    $css->ColTabla($DatosIVA["Nombre"], 1);
                    print("<td>");
                    $link="$myPage?DelServicio=$DatosItems[ID]&idCompra=$idCompra";
                    $css->CrearLink($link, "_self", "X");
                    print("</td>");
                    
               $css->CierraFilaTabla();
            }
            $css->CerrarTabla();
        }else{
            $css->CrearNotificacionNaranja("No hay Servicios agregados a esta Compra", 16);
        }
    $css->CerrarDiv();
    //Productos Devueltos
    
    $css->CrearDiv("DivProductosDevueltos", "", "Center", 1, 1);
    
        $consulta=$obVenta->ConsultarTabla("factura_compra_items_devoluciones", "WHERE idFacturaCompra='$idCompra'");
        if($obVenta->NumRows($consulta)){
            $css->CrearNotificacionRoja("Productos devueltos en esta Compra", 16);
            $css->CrearTabla();
            $css->FilaTabla(14);
               
               $css->ColTabla("<strong>idProducto</strong>", 1);
               $css->ColTabla("<strong>Referencia</strong>", 1);
               $css->ColTabla("<strong>Nombre</strong>", 1);
               $css->ColTabla("<strong>Cantidad</strong>", 1);
               $css->ColTabla("<strong>CostoUnitario</strong>", 1);
               $css->ColTabla("<strong>Subtotal</strong>", 1);
               $css->ColTabla("<strong>Impuestos</strong>", 1);
               $css->ColTabla("<strong>Total</strong>", 1);
               $css->ColTabla("<strong>% Impuestos</strong>", 1);
               $css->ColTabla("<strong>Borrar</strong>", 1);
               
               $css->CierraFilaTabla();
            while($DatosItems=$obVenta->FetchAssoc($consulta)){
               $css->FilaTabla(14);
               $DatosProducto=$obVenta->DevuelveValores("productosventa", "idProductosVenta", $DatosItems["idProducto"]);
               $DatosIVA=$obVenta->DevuelveValores("porcentajes_iva", "Valor", $DatosItems["Tipo_Impuesto"]);
                    $css->ColTabla($DatosItems["idProducto"], 1);
                    $css->ColTabla($DatosProducto["Referencia"], 1);
                    $css->ColTabla($DatosProducto["Nombre"], 1);
                    $css->ColTabla(number_format($DatosItems["Cantidad"]), 1);
                    $css->ColTabla(number_format($DatosItems["CostoUnitarioCompra"]), 1);
                    $css->ColTabla(number_format($DatosItems["SubtotalCompra"]), 1);
                    $css->ColTabla(number_format($DatosItems["ImpuestoCompra"]), 1);
                    $css->ColTabla(number_format($DatosItems["TotalCompra"]), 1);
                    $css->ColTabla($DatosIVA["Nombre"], 1);
                    print("<td>");
                    $link="$myPage?DelProductoDevuelto=$DatosItems[ID]&idCompra=$idCompra";
                    $css->CrearLink($link, "_self", "X");
                    print("</td>");
                    
               $css->CierraFilaTabla();
            }
            $css->CerrarTabla();
        }else{
            $css->CrearNotificacionNaranja("No hay productos devueltos en esta Compra", 16);
        }
    $css->CerrarDiv();
    }
    $css->CerrarDiv();//Cerramos contenedor Secundario
    $css->CerrarDiv();//Cerramos contenedor Principal
    $css->AgregaJS(); //Agregamos javascripts
    $css->AgregaSubir();
    $css->Footer();
    $css->AnchoElemento("TxtTerceroCI_chosen", 200);
    $css->AnchoElemento("CmbCodMunicipio_chosen", 200);    
    $css->AnchoElemento("CmbCuentaXPagar_chosen", 800);
    $css->AnchoElemento("CmbCuentaReteFuente_chosen", 200);
    $css->AnchoElemento("CmbCuentaReteIVA_chosen", 200);
    $css->AnchoElemento("CmbCuentaReteICA_chosen", 200);
    $css->AnchoElemento("CmbCuentaReteFuenteServicios_chosen", 200);
    $css->AnchoElemento("CmbCuentaReteIVAServicios_chosen", 200);
    $css->AnchoElemento("CmbCuentaReteICAServicios_chosen", 200);
    $css->AnchoElemento("CmbCuentaServicio_chosen", 200);
    $css->AnchoElemento("CmbTerceroEdit_chosen", 200); 
    
    print("</body></html>");
?>