<?php

session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];

include_once("../clases/Compras.class.php");
include_once("../../../constructores/paginas_constructor.php");

if( !empty($_REQUEST["Accion"]) ){
    $css =  new PageConstruct("", "", 1, "", 1, 0);
    $obCon = new Compras($idUser);
    
    switch ($_REQUEST["Accion"]) {
        case 1: //dibujar el formulario para crear una compra nueva
            $css->input("hidden", "idAccion", "", "TxtOpcionGuardarEditar", "", "1", "", "", "", "");        
           
            $css->CrearDiv("", "col-md-2", "center", 1, 1);
                print("<h4><strong>Fecha:</strong></h4>");
                $css->input("date", "TxtFecha", "form-control", "TxtFecha", "Fecha", date("Y-m-d"), "Fecha", "off", "", "","style='line-height: 15px;'");
            $css->CerrarDiv();
            $css->CrearDiv("", "col-md-4", "center", 1, 1);
                print("<h4><strong>Tercero:</strong></h4>");
                $css->select("CmbTerceroCrearCompra", "form-control", "CmbTerceroCrearCompra", "", "", "", "style=width:300px");
                    $css->option("", "", "", "", "", "");
                        print("Seleccione un tercero");
                    $css->Coption();
                $css->Cselect();
            $css->CerrarDiv();
            $css->CrearDiv("", "col-md-3", "center", 1, 1); 
                print("<h4><strong>Centro de costos:</strong></h4>");
                $css->select("CmbCentroCosto", "form-control", "CmbCentroCosto", "", "", "", "");
                $Consulta = $obCon->ConsultarTabla("centrocosto","");
                while($CentroCosto=$obCon->FetchArray($Consulta)){
                    $css->option("", "", "", $CentroCosto['ID'], "", "");
                        print($CentroCosto['ID']." ".$CentroCosto['Nombre']);
                    $css->Coption();
                    							
                }
                $css->Cselect();
            $css->CerrarDiv();
            
            $css->CrearDiv("", "col-md-3", "center", 1, 1); 
                print("<h4><strong>Sucursal:</strong></h4>");
                $css->select("idSucursal", "form-control", "idSucursal", "", "", "", "");
                $Consulta = $obCon->ConsultarTabla("empresa_pro_sucursales","");
                while($CentroCosto=$obCon->FetchArray($Consulta)){
                    $css->option("", "", "", $CentroCosto['ID'], "", "");
                        print($CentroCosto['ID']." ".$CentroCosto['Nombre']);
                    $css->Coption();
                    							
                }
                $css->Cselect();
            $css->CerrarDiv();
            
            $css->CrearDiv("", "col-md-2", "center", 1, 1);
                print("<h4><strong>Tipo:</strong></h4>");
                $css->select("TipoCompra", "form-control", "TipoCompra", "", "", "", "");
                    $css->option("", "", "", "FC", "", "");
                        print("FC");
                    $css->Coption();
                    $css->option("", "", "", "RM", "", "");
                        print("RM");
                    $css->Coption();
                $css->Cselect();
            $css->CerrarDiv();
            
            $css->CrearDiv("", "col-md-4", "center", 1, 1);
                print("<h4><strong>Concepto:</strong></h4>");
                $css->textarea("TxtConcepto", "form-control", "TxtConcepto", "Concepto", "Concepto", "", "");
                $css->Ctextarea();
            $css->CerrarDiv();
            
            $css->CrearDiv("", "col-md-3", "center", 1, 1);
                print("<h4><strong>No. Comprobante:</strong></h4>");
                $css->input("text", "TxtNumFactura", "form-control", "TxtNumFactura", "Comprobante", "", "Comprobante", "off", "", "");
            $css->CerrarDiv();
            
            $css->CrearDiv("", "col-md-3", "center", 1, 1);
                print("<h4><strong>Soporte:</strong></h4>");
                $css->input("file", "UpSoporte", "", "UpSoporte", "Soporte", "", "Soporte", "off", "", "style=width:100%");
            $css->CerrarDiv();
            
            print("<br><br><br><br><br><br><br><br><br><br>");
            
        break; 
        case 2:// se dibuja el formulario para editar los datos generales de la compra
            $idCompra=$obCon->normalizar($_REQUEST["idCompra"]);
            $DatosCompra=$obCon->DevuelveValores("factura_compra", "ID", $idCompra);
            $DatosTercero=$obCon->DevuelveValores("proveedores", "Num_Identificacion", $DatosCompra["Tercero"]);
            $css->input("hidden", "idAccion", "", "TxtOpcionGuardarEditar", "", "2", "", "", "", "");        
            $css->CrearDiv("", "col-md-2", "center", 1, 1);
                print("<h4><strong>Fecha:</strong></h4>");
                $css->input("date", "TxtFecha", "form-control", "TxtFecha", "Fecha", $DatosCompra["Fecha"], "Fecha", "off", "", "","style='line-height: 15px;'");
            $css->CerrarDiv();
            $css->CrearDiv("", "col-md-4", "center", 1, 1);
                print("<h4><strong>Tercero:</strong></h4>");
                $css->select("CmbTerceroCrearCompra", "form-control", "CmbTerceroCrearCompra", "", "", "", "style=width:300px");
                    $css->option("", "", "", $DatosCompra["Tercero"], "", "");
                        print($DatosTercero["RazonSocial"]." ".$DatosCompra["Tercero"]);
                    $css->Coption();
                $css->Cselect();
            $css->CerrarDiv();
            $css->CrearDiv("", "col-md-3", "center", 1, 1); 
                print("<h4><strong>Centro de costos:</strong></h4>");
                $css->select("CmbCentroCosto", "form-control", "CmbCentroCosto", "", "", "", "");
                $Consulta = $obCon->ConsultarTabla("centrocosto","");
                while($CentroCosto=$obCon->FetchArray($Consulta)){
                    $Sel=0;
                    if($CentroCosto["ID"]==$DatosCompra["idCentroCostos"]){
                        $Sel=1;
                    }
                    $css->option("", "", "", $CentroCosto['ID'], "", "",$Sel);
                        print($CentroCosto['ID']." ".$CentroCosto['Nombre']);
                    $css->Coption();
                    							
                }
                $css->Cselect();
            $css->CerrarDiv();
            
            $css->CrearDiv("", "col-md-3", "center", 1, 1); 
                print("<h4><strong>Sucursal:</strong></h4>");
                $css->select("idSucursal", "form-control", "idSucursal", "", "", "", "");
                $Consulta = $obCon->ConsultarTabla("empresa_pro_sucursales","");
                while($CentroCosto=$obCon->FetchArray($Consulta)){
                    $Sel=0;
                    if($CentroCosto["ID"]==$DatosCompra["idSucursal"]){
                        $Sel=1;
                    }
                    $css->option("", "", "", $CentroCosto['ID'], "", "",$Sel);
                        print($CentroCosto['ID']." ".$CentroCosto['Nombre']);
                    $css->Coption();
                    							
                }
                $css->Cselect();
            $css->CerrarDiv();
            
            $css->CrearDiv("", "col-md-2", "center", 1, 1);
                print("<h4><strong>Tipo:</strong></h4>");
                $css->select("TipoCompra", "form-control", "TipoCompra", "", "", "", "");
                    $css->option("", "", "", "FC", "", "");
                        print("FC");
                    $css->Coption();
                    $css->option("", "", "", "RM", "", "");
                        print("RM");
                    $css->Coption();
                $css->Cselect();
            $css->CerrarDiv();
            
            $css->CrearDiv("", "col-md-4", "center", 1, 1);
                print("<h4><strong>Concepto:</strong></h4>");
                $css->textarea("TxtConcepto", "form-control", "TxtConcepto", "Concepto", "Concepto", "", "");
                    print($DatosCompra["Concepto"]);
                $css->Ctextarea();
            $css->CerrarDiv();
            
            $css->CrearDiv("", "col-md-3", "center", 1, 1);
                print("<h4><strong>No. Comprobante:</strong></h4>");
                $css->input("text", "TxtNumFactura", "form-control", "TxtNumFactura", "Comprobante", $DatosCompra["NumeroFactura"], "Comprobante", "off", "", "");
            $css->CerrarDiv();
            
            $css->CrearDiv("", "col-md-3", "center", 1, 1);
                print("<h4><strong>Soporte:</strong></h4>");
                $css->input("file", "UpSoporte", "", "UpSoporte", "Soporte", "", "Soporte", "off", "", "style=width:100%");
            $css->CerrarDiv();
            
            print("<br><br><br><br><br><br><br><br><br><br>");
            
        break;  
        
        case 3://Dibuja los items de una compra
            $idCompra=$obCon->normalizar($_REQUEST["idCompra"]);
            $css->CrearTabla();
                $css->FilaTabla(12);
                    $css->ColTabla("<strong>ID</strong>", 1, "C");
                    
                    print("<td style=text-align:center;width:100px>");
                        print("<strong>Tiquetes</strong>");
                        $css->input("number", "CantidadTiquetes", "form-control", "CantidadTiquetes", "Tiquetes", 1, "Tiquetes", "off", "", "min=1 max=100");
                    print("</td>");
                    
                    $css->ColTabla("<strong>Nombre</strong>", 1, "C");
                    $css->ColTabla("<strong>Cantidad</strong>", 1, "C");
                    $css->ColTabla("<strong>Costo Unitario</strong>", 1, "C");
                    $css->ColTabla("<strong>Subtotal</strong>", 1, "C");
                    $css->ColTabla("<strong>Impuestos</strong>", 1, "C");
                    $css->ColTabla("<strong>Total</strong>", 1, "C");
                    $css->ColTabla("<strong>% Impuestos</strong>", 1, "C");
                    print("<td style=text-align:center;width:100px>");
                        print("<strong>Devolver</strong>");
                        $css->input("number", "CantidadDevolucion", "form-control", "CantidadDevolucion", "Devolver", 0, "Devolver", "off", "", "min=1 max=100");
                    print("</td>");
                    $css->ColTabla("<strong>Eliminar</strong>", 1, "C");
                    
                $css->CierraFilaTabla();
                //Dibujo los productos
                $sql="SELECT *,(SELECT Nombre FROM productosventa WHERE idProductosVenta=factura_compra_items.idProducto) as NombreProducto
                         FROM factura_compra_items WHERE idFacturaCompra='$idCompra' ORDER BY ID DESC";
                $Consulta=$obCon->Query($sql);
                while ($DatosItems = $obCon->FetchAssoc($Consulta)) {
                    $idItem=$DatosItems["ID"];
                    $idProducto=$DatosItems["idProducto"];
                    $css->FilaTabla(12);
                        $css->ColTabla($DatosItems["idProducto"], 1, "C");
                        
                        print("<td onclick=PrintEtiqueta($idProducto) style='font-size:16px;cursor:pointer;text-align:center;color:green' title='Imprimir Tiquete'>");
                        
                            $css->li("", "fa fa-print", "", "");
                            $css->Cli();
                        print("</td>");
                        if(is_numeric($DatosItems["Tipo_Impuesto"])){
                            $PorcentajeImpuestos=$DatosItems["Tipo_Impuesto"]*100;
                            $PorcentajeImpuestos=$PorcentajeImpuestos."%";
                        }else{
                            $PorcentajeImpuestos=$DatosItems["Tipo_Impuesto"];
                        }
                        $css->ColTabla($DatosItems["NombreProducto"], 1, "C");
                        $css->ColTabla(number_format($DatosItems["Cantidad"]), 1, "C");
                        $css->ColTabla(number_format($DatosItems["CostoUnitarioCompra"],2,",","."), 1, "C");
                        $css->ColTabla(number_format($DatosItems["SubtotalCompra"],2,",","."), 1, "C");
                        $css->ColTabla(number_format($DatosItems["ImpuestoCompra"],2,",","."), 1, "C");
                        $css->ColTabla(number_format($DatosItems["TotalCompra"],2,",","."), 1, "C");
                        $css->ColTabla($PorcentajeImpuestos, 1, "C");
                        
                       print("<td style='font-size:16px;text-align:center;color:red' title='Devolver'>");   
                            
                            $css->li("", "fa fa-reply-all", "", "onclick=DevolverItem(`$idItem`) style=font-size:16px;cursor:pointer;text-align:center;color:red");
                            $css->Cli();
                        print("</td>");
                        
                        print("<td style='font-size:16px;text-align:center;color:red' title='Borrar'>");   
                            
                            $css->li("", "fa  fa-remove", "", "onclick=EliminarItem(`1`,`$idItem`) style=font-size:16px;cursor:pointer;text-align:center;color:red");
                            $css->Cli();
                        print("</td>");
                    $css->CierraFilaTabla();
                }
                //Dibujo los insumos
                $sql="SELECT *,(SELECT Nombre FROM insumos WHERE ID=factura_compra_insumos.idProducto) as NombreProducto
                         FROM factura_compra_insumos WHERE idFacturaCompra='$idCompra' ORDER BY ID DESC";
                $Consulta=$obCon->Query($sql);
                while ($DatosItems = $obCon->FetchAssoc($Consulta)) {
                    $idItem=$DatosItems["ID"];
                    $idProducto=$DatosItems["idProducto"];
                    $css->FilaTabla(12);
                        $css->ColTabla($DatosItems["idProducto"], 1, "C");
                        
                        print("<td style='font-size:16px;cursor:pointer;text-align:center;color:green' title='Insumos'>");
                        
                           print("Insumo");
                        print("</td>");
                        if(is_numeric($DatosItems["Tipo_Impuesto"])){
                            $PorcentajeImpuestos=$DatosItems["Tipo_Impuesto"]*100;
                            $PorcentajeImpuestos=$PorcentajeImpuestos."%";
                        }else{
                            $PorcentajeImpuestos=$DatosItems["Tipo_Impuesto"];
                        }
                        $css->ColTabla($DatosItems["NombreProducto"], 1, "C");
                        $css->ColTabla(number_format($DatosItems["Cantidad"]), 1, "C");
                        $css->ColTabla(number_format($DatosItems["CostoUnitarioCompra"],2,",","."), 1, "C");
                        $css->ColTabla(number_format($DatosItems["SubtotalCompra"],2,",","."), 1, "C");
                        $css->ColTabla(number_format($DatosItems["ImpuestoCompra"],2,",","."), 1, "C");
                        $css->ColTabla(number_format($DatosItems["TotalCompra"],2,",","."), 1, "C");
                        $css->ColTabla($PorcentajeImpuestos, 1, "C");
                        $css->ColTabla("NA", 1, "C");
                        print("<td style='font-size:16px;text-align:center;color:red' title='Borrar'>");   
                            
                            $css->li("", "fa  fa-remove", "", "onclick=EliminarItem(`3`,`$idItem`) style=font-size:16px;cursor:pointer;text-align:center;color:red");
                            $css->Cli();
                        print("</td>");
                    $css->CierraFilaTabla();
                }
                
                //Dibujo los servicios
                
                $sql="SELECT * FROM factura_compra_servicios WHERE idFacturaCompra='$idCompra' ORDER BY ID DESC";
                $Consulta=$obCon->Query($sql);
                while ($DatosItems = $obCon->FetchAssoc($Consulta)) {
                    $idItem=$DatosItems["ID"];
                    
                    $css->FilaTabla(12);
                        $css->ColTabla($DatosItems["CuentaPUC_Servicio"], 1, "C");
                        
                        print("<td style='font-size:16px;cursor:pointer;text-align:center;color:blue' title='Servicios'>");
                        
                            print("Servicio");
                        print("</td>");
                        if(is_numeric($DatosItems["Tipo_Impuesto"])){
                            $PorcentajeImpuestos=$DatosItems["Tipo_Impuesto"]*100;
                            $PorcentajeImpuestos=$PorcentajeImpuestos."%";
                        }else{
                            $PorcentajeImpuestos=$DatosItems["Tipo_Impuesto"];
                        }
                        $css->ColTabla($DatosItems["Concepto_Servicio"], 1, "C");
                        $css->ColTabla(1, 1, "C");
                        $css->ColTabla(number_format($DatosItems["Subtotal_Servicio"],2,",","."), 1, "C");
                        $css->ColTabla(number_format($DatosItems["Subtotal_Servicio"],2,",","."), 1, "C");
                        $css->ColTabla(number_format($DatosItems["Impuesto_Servicio"],2,",","."), 1, "C");
                        $css->ColTabla(number_format($DatosItems["Total_Servicio"],2,",","."), 1, "C");
                        $css->ColTabla($PorcentajeImpuestos, 1, "C");
                        $css->ColTabla("NA", 1, "C");
                        print("<td style='font-size:16px;text-align:center;color:red' title='Borrar'>");   
                            
                            $css->li("", "fa  fa-remove", "", "onclick=EliminarItem(`2`,`$idItem`) style=font-size:16px;cursor:pointer;text-align:center;color:red");
                            $css->Cli();
                        print("</td>");
                    $css->CierraFilaTabla();
                }
                //dibujo los productos devueltos
                $sql="SELECT *,(SELECT Nombre FROM productosventa WHERE idProductosVenta=factura_compra_items_devoluciones.idProducto) as NombreProducto
                         FROM factura_compra_items_devoluciones WHERE idFacturaCompra='$idCompra' ORDER BY ID DESC";
                $Consulta=$obCon->Query($sql);
                $FlagTitulo=1;
                while ($DatosItems = $obCon->FetchAssoc($Consulta)) {
                    if($FlagTitulo==1){
                        $css->FilaTabla(12);
                            $css->ColTabla("<strong>Devoluciones</strong>", 11, "C");
                        $css->CierraFilaTabla(); 
                        $FlagTitulo=0;
                    }
                    $idItem=$DatosItems["ID"];
                    $idProducto=$DatosItems["idProducto"];
                    $css->FilaTabla(12);
                        $css->ColTabla($DatosItems["idProducto"], 1, "C");
                        
                        print("<td style='font-size:16px;cursor:pointer;text-align:center;color:red' title='Insumos'>");
                        
                           print("Devolución");
                        print("</td>");
                        if(is_numeric($DatosItems["Tipo_Impuesto"])){
                            $PorcentajeImpuestos=$DatosItems["Tipo_Impuesto"]*100;
                            $PorcentajeImpuestos=$PorcentajeImpuestos."%";
                        }else{
                            $PorcentajeImpuestos=$DatosItems["Tipo_Impuesto"];
                        }
                        $css->ColTabla($DatosItems["NombreProducto"], 1, "C");
                        $css->ColTabla(number_format($DatosItems["Cantidad"]), 1, "C");
                        $css->ColTabla(number_format($DatosItems["CostoUnitarioCompra"],2,",","."), 1, "C");
                        $css->ColTabla(number_format($DatosItems["SubtotalCompra"],2,",","."), 1, "C");
                        $css->ColTabla(number_format($DatosItems["ImpuestoCompra"],2,",","."), 1, "C");
                        $css->ColTabla(number_format($DatosItems["TotalCompra"],2,",","."), 1, "C");
                        $css->ColTabla($PorcentajeImpuestos, 1, "C");
                        
                       print("<td style='text-align:center' title=''>");   
                            
                            print("NA");
                        print("</td>");
                        
                        print("<td style='font-size:16px;text-align:center;color:red' title='Borrar'>");   
                            
                            $css->li("", "fa  fa-remove", "", "onclick=EliminarItem(`4`,`$idItem`) style=font-size:16px;cursor:pointer;text-align:center;color:red");
                            $css->Cli();
                        print("</td>");
                    $css->CierraFilaTabla();
                }
                
            $css->CerrarTabla();
        break;// fin caso 3
        
        case 4://Dibujo los Totales
            $idCompra=$obCon->normalizar($_REQUEST["idCompra"]);
            $TotalesCompras=$obCon->CalculeTotalesCompra($idCompra);
            $css->div("", "col-md-2", "", "", "","", "style=text-align:center;color:blue;font-size:18px");
               
            $css->Cdiv();
            $css->div("", "col-md-10", "", "", "","", "style=text-align:right");
                $css->CrearTabla();
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>PRODUCTOS</strong>", 7,'C');
                    $css->CierraFilaTabla();
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>Subtotal:</strong>", 1,'R');
                        $css->input("hidden", "TxtSubtotalProductos", "", "", "", $TotalesCompras["Subtotal_Productos_Add"], "", "", "", "");
                        $css->ColTabla(number_format($TotalesCompras["Subtotal_Productos_Add"]), 1,'R');
                        print("<td>");
                            
                            $css->select("CmbImpRetDesProductos", "form-control", "CmbImpRetDesProductos", "", "", "", "onclick=MuestreOpcionesEnTotales(1)");
                                $css->option("", "", "", "", "", "");
                                    print("Elija una opción para aplicar:");
                                $css->Coption();
                                $Parametros=$obCon->DevuelveValores("parametros_contables", "ID", 24);
                                $css->option("", "", "", $Parametros["CuentaPUC"], "", "");
                                    print("Retefuente ".$Parametros["CuentaPUC"]);
                                $css->Coption();
                                $Parametros=$obCon->DevuelveValores("parametros_contables", "ID", 25);
                                $css->option("", "", "", $Parametros["CuentaPUC"], "", "");
                                    print("ReteICA ".$Parametros["CuentaPUC"]);
                                $css->Coption();   
                                $Parametros=$obCon->DevuelveValores("parametros_contables", "ID", 28);
                                $css->option("", "", "", $Parametros["CuentaPUC"], "", "");
                                    print("Descuentos Generales ".$Parametros["CuentaPUC"]);
                                $css->Coption();
                                $Parametros=$obCon->DevuelveValores("parametros_contables", "ID", 29);
                                $css->option("", "", "", $Parametros["CuentaPUC"], "", "");
                                    print("Impoconsumo ".$Parametros["CuentaPUC"]);
                                $css->Coption();
                            $css->Cselect();
                                
                        print("</td>");
                            
                                                
                        print("<td>");
                            $css->CrearDiv("DivImpRetDesPro2", "", "", 0, 0);
                            
                                $css->CrearInputText("TxtCargosPorcentajeProductos", "text", "", "", "%", "", "onkeyup", "CalculeRetencionDescuento(1)", 60, 30, 0, 1);
                            $css->CerrarDiv();    
                        print("</td>");                        
                        print("<td>"); 
                            $css->CrearDiv("DivImpRetDesPro3", "", "", 0, 0);
                                $css->CrearInputText("TxtCargosValorProductos", "text", "", "", "Valor", "", "onkeyup", "CalculeRetencionDescuento(2)", 100, 30, 0, 1);
                            $css->CerrarDiv();
                        print("</td>");
                        print("<td>"); 
                            $css->CrearDiv("DivImpRetDesPro4", "", "", 0, 0);
                                $css->CrearBotonEvento("BtnAgregarCargosProductos", "Agregar", 1, "onclick", "AgregarCargosProductos(event)", "naranja", "");
                            $css->CerrarDiv();
                        print("</td>");
                    $css->CierraFilaTabla();
                $css->CerrarTabla();
                
            $css->Cdiv();
            
        break;    
        
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>