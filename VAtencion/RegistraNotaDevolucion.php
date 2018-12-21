<?php 
$myPage="RegistraNotaDevolucion.php";
include_once("../sesiones/php_control.php");
include_once("clases/ClasesCompras.php");
include_once("css_construct.php");

print("<html>");
print("<head>");
$css =  new CssIni("Notas Devolucion");
$obVenta=new ProcesoVenta($idUser);  
$obCompra=new Compra($idUser);
$idNota=0;
$TipoMovimiento=0;
if(isset($_REQUEST["idNota"])){
    $idNota=$obCompra->normalizar($_REQUEST["idNota"]);
}

print("</head>");
print("<body>");
    
    $css->CabeceraIni("Registrar Nota de Devolucion"); //Inicia la cabecera de la pagina
    
    $css->CreaBotonDesplegable("CrearNota","Nueva");  
    $css->CabeceraFin(); 
    
    include_once 'cuadros_dialogo/NotasDevolucion.dialogo.php';
    ///////////////Creamos el contenedor
        
    $css->CrearDiv("principal", "container", "center",1,1);
    
    if(isset($_REQUEST["idNotaDevolucion"])){
        $idNotaDevolucion=$obCompra->normalizar($_REQUEST["idNotaDevolucion"]);
        $Link="PDF_Documentos.php?idDocumento=31&idNotaDevolucion=$idNotaDevolucion";
        $css->CrearNotificacionAzul("Nota creada Satisfactoriamente <a href='$Link' target='_blank'>Ver Nota</a>", 16);
    }
    
    include_once("procesadores/RegistraNotaDevolucion.process.php");
    $css->CrearForm2("FrmSeleccionaNota", $myPage, "post", "_self");
    $css->CrearSelect("idNota", "EnviaForm('FrmSeleccionaNota')");
        
            $css->CrearOptionSelect("","Selecciona una Nota",0);
            
            $consulta = $obVenta->ConsultarTabla("factura_compra_notas_devolucion","WHERE Estado='ABIERTA'");
            while($DatosComprobante=$obVenta->FetchArray($consulta)){
                if($idNota==$DatosComprobante['ID']){
                    $Sel=1;
                    
                }else{
                    
                    $Sel=0;
                }
                $DatosTercero=$obCompra->DevuelveValores("proveedores", "Num_Identificacion", $DatosComprobante['Tercero']);
                $css->CrearOptionSelect($DatosComprobante['ID'],$DatosComprobante['ID']." ".$DatosTercero["RazonSocial"]." ".$DatosComprobante['Concepto'],$Sel);							
            }
        $css->CerrarSelect();
    $css->CerrarForm();
     
    ///////////////Se crea el DIV que servirá de contenedor secundario
    /////
    /////
    $css->CrearDiv("Secundario", "container", "center",1,1);
   										
    if($idNota>0){
        $css->CrearTabla();
            $css->FilaTabla(16);
                $css->ColTabla("<strong>Buscar Producto:<strong>", 1);
                
                print("<td>");
                print("<strong>Datos Nota: <strong>");
                $css->ImageOcultarMostrar("ImgHidden2", "Click: ", "DivEditFactura", 30, 30, "");
                print("</td>");
                
            $css->CierraFilaTabla();
            $css->FilaTabla(16);
                print("<td>");
                $Page="Consultas/BuscarItemsCompras.php?TipoItem=1&myPage=$myPage&idCompra=$idNota&key=";
                $css->CrearInputText("TxtProducto", "text", "", "", "Buscar Producto", "", "onKeyPress", "EnvieObjetoConsulta(`$Page`,`TxtProducto`,`DivBusquedas`,`5`);", 200, 30, 0, 1);
                print("</td>");
                
                print("<td>");
                $DatosNota=$obCompra->DevuelveValores("factura_compra_notas_devolucion", "ID", $idNota);
                $css->CrearDiv("DivEditFactura", "", "Center", 0, 1);
                $css->CrearForm2("FrmEditarDatos", $myPage, "post", "_self");
                $css->CrearInputText("idNota", "hidden", "", $idNota, "", "", "", "", "", "", 1, 1);
                $css->CrearInputFecha("", "TxtFechaEdit", $DatosNota["Fecha"], 100, 30, "");
                print("<strong>Tercero:</strong><br>");
                $VarSelect["Required"]="1";
                $VarSelect["Ancho"]="200";
                $VarSelect["PlaceHolder"]="Seleccione un Tercero";
                $css->CrearSelectChosen("CmbTerceroEdit", $VarSelect);
                $consulta=$obVenta->ConsultarTabla("proveedores", "");
                while($DatosCuenta=$obVenta->FetchArray($consulta)){
                    $sel=0;
                    if($DatosCuenta["Num_Identificacion"]==$DatosNota["Tercero"]){
                        $sel=1;
                    }
                    $css->CrearOptionSelect($DatosCuenta["Num_Identificacion"], $DatosCuenta["Num_Identificacion"]." ".$DatosCuenta["RazonSocial"] , $sel);
                }
                $css->CerrarSelect();
                
                print("<br><strong>Concepto:</strong><br>");
                $css->CrearTextArea("TxtConceptoServicioEdit", "", $DatosNota["Concepto"], "Escriba el concepto", "", "", "", 200, 60, 0, 1);
                print("<br>");
                $css->CrearBotonConfirmado("BtnEditarFactura", "Editar");
                $css->CerrarForm();
                $css->CerrarDiv();
                print("</td>");
                
            $css->CierraFilaTabla();
            
            
        $css->CerrarTabla();
        
        
        $css->CrearBotonEvento("BtnMostrarProductos", "V/O Productos Devueltos", 1, "onclick", "MuestraOculta('DivProductosDevueltos')", "verde", "");
        
        $css->CrearTabla();
           
        $css->CerrarTabla();
       
    }    
    
    $css->CrearDiv("DivBusquedas", "", "center", 1, 1);
    $css->CerrarDiv();
    
    //Div con los productos
    if($idNota>0){
    
    //Productos Devueltos
    
    $css->CrearDiv("DivProductosDevueltos", "", "Center", 1, 1);
    
        $consulta=$obVenta->ConsultarTabla("factura_compra_items_devoluciones", "WHERE idNotaDevolucion='$idNota'");
        if($obVenta->NumRows($consulta)){
            $css->CrearNotificacionRoja("Productos devueltos en esta Nota", 16);
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
                    $link="$myPage?DelProductoDevuelto=$DatosItems[ID]&idNota=$idNota";
                    $css->CrearLink($link, "_self", "X");
                    print("</td>");
                    
               $css->CierraFilaTabla();
            }
            $css->CerrarTabla();
        }else{
            $css->CrearNotificacionNaranja("No hay productos devueltos en esta Nota", 16);
        }
    $css->CerrarDiv();
    print("<div id='DivTotalesNotaCierra'  style='display:block;float: right;position: fixed;width: 200px;top: 50px;right:10px;border-radius: 8px 8px 8px 8px;'>");
        $css->CrearBotonEvento("BtnCerrarDiv", "V/O Totales", 1, "onclick", "MuestraOculta('DivTotalesNota')", "naranja", "");
        
    print("</div>");
    print("<div id='DivTotalesNota'  style='display:block;float: right;position: fixed;width: 200px;background-color: #ffffff;border: 1px solid #D2D2D2;top: 80px;right:10px;border-radius: 8px 8px 8px 8px;'>");
        
       
        //$css->CrearNotificacionVerde("NOTA $idNota:", 14);
        $sql="SELECT SUM(SubtotalCompra) as Subtotal, SUM(ImpuestoCompra) as IVA,SUM(TotalCompra) as Total "
                . " FROM factura_compra_items_devoluciones WHERE idNotaDevolucion='$idNota'";
        $Datos=$obVenta->Query($sql);
        $DatosTotalesNota=$obVenta->FetchArray($Datos);
        $css->CrearTabla();
            
            $css->FilaTabla(14);
                $css->ColTabla("<strong>SUBTOTAL:</strong>", 1);
                $css->ColTabla(number_format($DatosTotalesNota["Subtotal"]), 1);
                
            $css->CierraFilaTabla();
            $css->FilaTabla(14);
                $css->ColTabla("<strong>IVA:</strong>", 1);
                $css->ColTabla(number_format($DatosTotalesNota["IVA"]), 1);
                
            $css->CierraFilaTabla();
            $css->FilaTabla(14);
                $css->ColTabla("<strong>TOTAL:</strong>", 1);
                $css->ColTabla(number_format($DatosTotalesNota["Total"]), 1);
                
            $css->CierraFilaTabla();
        $css->CerrarTabla();
        $css->CrearDiv("DivTotalNota", "", "center", 1, 1);
        if($DatosTotalesNota["Total"]>0){
            $css->CrearForm2("FrmGuardar", $myPage, "post", "_self");
                $css->CrearInputText("idNota", "hidden", "", $idNota, "", "", "", "", "", "", 0, 0);
                $css->CrearBotonConfirmado("GuardarNota", "Guardar");
            $css->CerrarForm();
        }
        $css->CerrarDiv();
        print("<br>");
    print("</div>");
    }
    $css->CerrarDiv();//Cerramos contenedor Secundario
    
    $css->CerrarDiv();//Cerramos contenedor Principal
    
    
    $css->AgregaJS(); //Agregamos javascripts
    $css->AgregaSubir();
    $css->Footer();
    $css->AnchoElemento("TxtTerceroCI_chosen", 200);
    
    $css->AnchoElemento("CmbTerceroEdit_chosen", 200); 
    
    print("</body></html>");
?>