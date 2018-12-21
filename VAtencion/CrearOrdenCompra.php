<?php 
$myPage="CrearOrdenCompra.php";
include_once("../sesiones/php_control.php");
include_once("clases/ClasesCompras.php");
include_once("css_construct.php");

print("<html>");
print("<head>");
$css =  new CssIni("Orden de Compra");
$obVenta=new ProcesoVenta($idUser);  
$obCompra=new Compra($idUser);
$idOrden=0;
$TipoMovimiento=0;
if(isset($_REQUEST["idOrden"])){
    $idOrden=$obCompra->normalizar($_REQUEST["idOrden"]);
}

print("</head>");
print("<body>");
    
    $css->CabeceraIni("Registrar Orden de Compra"); //Inicia la cabecera de la pagina
    
    $css->CreaBotonDesplegable("CrearOrden","Nueva");  
    $css->CabeceraFin(); 
    
    
    //Modal para crear la nueva orden
    
    $css->CrearCuadroDeDialogoAmplio("CrearOrden","Crear una Orden de Compra"); 
        $css->CrearForm2("FrmCrearOrden", $myPage, "post", "_self");
        $css->CrearTabla();
        $css->FilaTabla(16);
            $css->ColTabla("<strong>Fecha</strong>", 1);
            $css->ColTabla("<strong>Tercero</strong>", 1);
            $css->ColTabla("<strong>Plazo de entrega Dias</strong>", 1);
            $css->ColTabla("<strong>No. Cotizacion</strong>", 1);
            
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
        print("<td>");
        $css->CrearInputFecha("", "TxtFecha", date("Y-m-d"), 100, 30, "");
        
        print("</td>");        
         print("<td>");
            $VarSelect["Ancho"]="200";
            $VarSelect["PlaceHolder"]="Seleccione el tercero";
            $css->CrearSelectChosen("TxtTerceroCI", $VarSelect);

            $sql="SELECT * FROM proveedores";
            $Consulta=$obVenta->Query($sql);
               while($DatosProveedores=$obVenta->FetchArray($Consulta)){
                   $Sel=0;
                   
                   $css->CrearOptionSelect($DatosProveedores["idProveedores"], "$DatosProveedores[RazonSocial] $DatosProveedores[Num_Identificacion]" , $Sel);
               }
            $css->CerrarSelect();
        print("</td>"); 
        print("<td>");
            $css->CrearInputNumber("TxtDias", "number", "", 1, "Dias", "", "", "", 100, 30, 0, 1, 1, 90, 1);
        print("</td>");
        print("<td>");
            $css->CrearInputText("TxtCotizacion", "text", "", "", "No. Cotización", "", "", "", 200, 30, 0, 0);
        print("</td>");
       
        $css->CierraFilaTabla();
        $css->FilaTabla(16); 
       
            
            $css->ColTabla("<strong>Condiciones</strong>", 1);
            $css->ColTabla("<strong>Descripción</strong>", 1);
            $css->ColTabla("<strong>Solicitante</strong>", 1);
            $css->ColTabla("<strong>Crear</strong>", 1);
            
            
        $css->CierraFilaTabla();
        print("<td>");
            $css->CrearTextArea("TxtCondiciones", "", "", "Condiciones", "", "", "", 200, 60, 0, 1);
        print("</td>"); 
        print("<td>");
            $css->CrearTextArea("TxtDescripcion", "", "", "Descripción", "", "", "", 200, 60, 0, 1);
        print("</td>"); 
         print("<td>");
            $css->CrearInputText("TxtSolicitante", "text", "", "", "Solicita", "", "", "", 300, 30, 0, 0);
        print("</td>");
        print("<td>"); 
            $css->CrearBotonConfirmado("BtnCrear","Crear");
        print("</td>"); 
        
        $css->CierraFilaTabla();
    $css->CerrarTabla();
    $css->CerrarForm();
    $css->CerrarCuadroDeDialogoAmplio(); 
    
    /////
        
    $css->CrearDiv("principal", "container", "center",1,1);
    
    if(isset($_REQUEST["idOrdenCompra"])){
        $idOrdenCompra=$obCompra->normalizar($_REQUEST["idOrdenCompra"]);
        $Link="../tcpdf/examples/imprimirOC.php?idOT=$idOrdenCompra";
        $css->CrearNotificacionAzul("Orden de Compra creada Satisfactoriamente <a href='$Link' target='_blank'>Ver Orden $idOrdenCompra</a>", 16);
        
    }
    
    include_once("procesadores/CrearOrdenCompra.process.php");
    $css->CrearForm2("FrmSeleccionaOrden", $myPage, "post", "_self");
        $css->CrearSelect("idOrden", "EnviaForm('FrmSeleccionaOrden')",400);
             $css->CrearOptionSelect("","Selecciona una Orden de Compra",0);
            
            $consulta = $obVenta->ConsultarTabla("ordenesdecompra","WHERE Estado='ABIERTA'");
            while($DatosComprobante=$obVenta->FetchArray($consulta)){
                if($idOrden==$DatosComprobante['ID']){
                    $Sel=1;
                    
                }else{
                    
                    $Sel=0;
                }
                $DatosTercero=$obCompra->DevuelveValores("proveedores", "idProveedores", $DatosComprobante['Tercero']);
                $css->CrearOptionSelect($DatosComprobante['ID'],$DatosComprobante['ID']." ".$DatosTercero["RazonSocial"]." ".$DatosComprobante['Concepto'],$Sel);							
            }
        $css->CerrarSelect();
    $css->CerrarForm();
     
    ///////////////Se crea el DIV que servirá de contenedor secundario
    /////
    /////
    $css->CrearDiv("Secundario", "container", "center",1,1);
   										
    if($idOrden>0){
        $css->CrearTabla();
            $css->FilaTabla(16);
                $css->ColTabla("<strong>Buscar Producto:<strong>", 1);
                
                print("<td>");
                print("<strong>Datos Orden de Compra: <strong>");
                $css->ImageOcultarMostrar("ImgHidden2", "Click: ", "DivEditFactura", 30, 30, "");
                print("</td>");
                
            $css->CierraFilaTabla();
            $css->FilaTabla(16);
                print("<td>");
                $Page="Consultas/BuscarItemsOrdenesCompras.php?TipoItem=1&myPage=$myPage&idCompra=$idOrden&key=";
                $css->CrearInputText("TxtProducto", "text", "", "", "Buscar Producto", "", "onKeyPress", "EnvieObjetoConsulta(`$Page`,`TxtProducto`,`DivBusquedas`,`5`);", 200, 30, 0, 1);
                print("</td>");
                
                print("<td>");
                $DatosCompra=$obCompra->DevuelveValores("ordenesdecompra", "ID", $idOrden);
                $css->CrearDiv("DivEditFactura", "", "Center", 0, 1);
                $css->CrearForm2("FrmEditarDatos", $myPage, "post", "_self");
                $css->CrearInputText("idOrden", "hidden", "", $idOrden, "", "", "", "", "", "", 1, 1);
                $css->CrearInputFecha("", "TxtFechaEdit", $DatosCompra["Fecha"], 100, 30, "");
                print("<strong>Tercero:</strong><br>");
                $VarSelect["Required"]="1";
                $VarSelect["Ancho"]="200";
                $VarSelect["PlaceHolder"]="Seleccione un Tercero";
                $css->CrearSelectChosen("CmbTerceroEdit", $VarSelect);
                $consulta=$obVenta->ConsultarTabla("proveedores", "");
                while($DatosCuenta=$obVenta->FetchArray($consulta)){
                    $sel=0;
                    if($DatosCuenta["idProveedores"]==$DatosCompra["Tercero"]){
                        $sel=1;
                    }
                    $css->CrearOptionSelect($DatosCuenta["idProveedores"], $DatosCuenta["Num_Identificacion"]." ".$DatosCuenta["RazonSocial"] , $sel);
                }
                $css->CerrarSelect();
                
                print("<br><strong>Concepto:</strong><br>");
                $css->CrearTextArea("TxtConceptoServicioEdit", "", $DatosCompra["Descripcion"], "Escriba el concepto", "", "", "", 200, 60, 0, 1);
                print("<br>");
                print("<br><strong>Condiciones:</strong><br>");
                $css->CrearTextArea("TxtCondicionesEdit", "", $DatosCompra["Condiciones"], "Escriba las condiciones", "", "", "", 200, 60, 0, 1);
                print("<br>");
                $css->CrearBotonConfirmado("BtnEditarFactura", "Editar");
                $css->CerrarForm();
                $css->CerrarDiv();
                print("</td>");
                
            $css->CierraFilaTabla();
            
            
        $css->CerrarTabla();
        
        
    }    
    
    $css->CrearDiv("DivBusquedas", "", "center", 1, 1);
    $css->CerrarDiv();
    
    //Div con los productos
    if($idOrden>0){
    
    //Productos Devueltos
    
    $css->CrearDiv("DivProductos", "", "Center", 1, 1);
    
        $consulta=$obVenta->ConsultarTabla("ordenesdecompra_items", "WHERE NumOrden='$idOrden'");
        if($obVenta->NumRows($consulta)){
            $css->CrearNotificacionRoja("Productos agregados en esta orden", 16);
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
                    $css->ColTabla(number_format($DatosItems["ValorUnitario"]), 1);
                    $css->ColTabla(number_format($DatosItems["Subtotal"]), 1);
                    $css->ColTabla(number_format($DatosItems["IVA"]), 1);
                    $css->ColTabla(number_format($DatosItems["Total"]), 1);
                    $css->ColTabla($DatosIVA["Nombre"], 1);
                    print("<td>");
                    $link="$myPage?DelProducto=$DatosItems[ID]&idOrden=$idOrden";
                    $css->CrearLink($link, "_self", "X");
                    print("</td>");
                    
               $css->CierraFilaTabla();
            }
            $css->CerrarTabla();
        }else{
            $css->CrearNotificacionNaranja("No hay productos agregados a esta orden", 16);
        }
    $css->CerrarDiv();
    print("<div id='DivTotalesNotaCierra'  style='display:block;float: right;position: fixed;width: 200px;top: 50px;right:10px;border-radius: 8px 8px 8px 8px;'>");
        $css->CrearBotonEvento("BtnCerrarDiv", "V/O Totales", 1, "onclick", "MuestraOculta('DivTotalesNota')", "naranja", "");
        
    print("</div>");
    print("<div id='DivTotalesNota'  style='display:block;float: right;position: fixed;width: 200px;background-color: #ffffff;border: 1px solid #D2D2D2;top: 80px;right:10px;border-radius: 8px 8px 8px 8px;'>");
        
       
        //$css->CrearNotificacionVerde("NOTA $idNota:", 14);
        $sql="SELECT SUM(Subtotal) as Subtotal, SUM(IVA) as IVA,SUM(Total) as Total "
                . " FROM ordenesdecompra_items WHERE NumOrden='$idOrden'";
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
                $css->CrearInputText("idOrden", "hidden", "", $idOrden, "", "", "", "", "", "", 0, 0);
                $css->CrearBotonConfirmado("GuardarOrden", "Guardar");
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