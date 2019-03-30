<?php

session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];
include_once("../../../modelo/PrintBarras.php");
include_once("../clases/Compras.class.php");

if( !empty($_REQUEST["Accion"]) ){
    $obCon = new Compras($idUser);
    
    switch ($_REQUEST["Accion"]) {
        
        case 1: //Crear una orden de compra
            $Fecha=$obCon->normalizar($_REQUEST["Fecha"]); 
            $idTercero=$obCon->normalizar($_REQUEST["Tercero"]); 
            $CentroCostos=$obCon->normalizar($_REQUEST["ControCosto"]); 
            $idSucursal=$obCon->normalizar($_REQUEST["Sucursal"]); 
            $PlazoEntrega=$obCon->normalizar($_REQUEST["PlazoEntrega"]);
            $Concepto=$obCon->normalizar($_REQUEST["Concepto"]); 
            $TxtCondiciones=$obCon->normalizar($_REQUEST["TxtCondiciones"]); 
            $TxtSolicitante=$obCon->normalizar($_REQUEST["TxtSolicitante"]); 
            $TxtNumCotizacion=$obCon->normalizar($_REQUEST["TxtNumCotizacion"]); 
            
            $idCompra=$obCon->CrearOrdenDeCompra($Fecha, $idTercero, $Concepto, $PlazoEntrega, $TxtNumCotizacion, $TxtCondiciones, $TxtSolicitante, $CentroCostos, $idSucursal, "");
            
            print("OK;$idCompra");            
            
        break; 
        
        case 2: //editar datos generales de una orden de compra
            $idCompra=$obCon->normalizar($_REQUEST["idCompraActiva"]); 
            $Fecha=$obCon->normalizar($_REQUEST["Fecha"]); 
            $idTercero=$obCon->normalizar($_REQUEST["Tercero"]); 
            $CentroCostos=$obCon->normalizar($_REQUEST["ControCosto"]); 
            $idSucursal=$obCon->normalizar($_REQUEST["Sucursal"]); 
            $PlazoEntrega=$obCon->normalizar($_REQUEST["PlazoEntrega"]);
            $Concepto=$obCon->normalizar($_REQUEST["Concepto"]); 
            $TxtCondiciones=$obCon->normalizar($_REQUEST["TxtCondiciones"]); 
            $TxtSolicitante=$obCon->normalizar($_REQUEST["TxtSolicitante"]); 
            $TxtNumCotizacion=$obCon->normalizar($_REQUEST["TxtNumCotizacion"]); 
            
            $obCon->ActualizaRegistro("ordenesdecompra", "Fecha", $Fecha, "ID", $idCompra,0);
            $obCon->ActualizaRegistro("ordenesdecompra", "Tercero", $idTercero, "ID", $idCompra,0);
            $obCon->ActualizaRegistro("ordenesdecompra", "idCentroCostos", $CentroCostos, "ID", $idCompra,0);
            $obCon->ActualizaRegistro("ordenesdecompra", "idSucursal", $idSucursal, "ID", $idCompra,0);
            $obCon->ActualizaRegistro("ordenesdecompra", "Descripcion", $Concepto, "ID", $idCompra,0);
            $obCon->ActualizaRegistro("ordenesdecompra", "PlazoEntrega", $PlazoEntrega, "ID", $idCompra,0);
            $obCon->ActualizaRegistro("ordenesdecompra", "NoCotizacion", $TxtNumCotizacion, "ID", $idCompra,0);
            $obCon->ActualizaRegistro("ordenesdecompra", "Condiciones", $TxtCondiciones, "ID", $idCompra,0);
            $obCon->ActualizaRegistro("ordenesdecompra", "Solicitante", $TxtSolicitante, "ID", $idCompra,0);
            
            $DatosTercero=$obCon->DevuelveValores("proveedores", "idProveedores", $idTercero);
            
            print("OK;$DatosTercero[RazonSocial];$Concepto");
            
        break; 
        case 3://Agregar un item
            
            $idCompra=$obCon->normalizar($_REQUEST["idCompra"]); 
            $CmbListado=$obCon->normalizar($_REQUEST["CmbListado"]); 
            $CmbBusquedas=$obCon->normalizar($_REQUEST["CmbBusquedas"]); 
            $CmbImpuestosIncluidos=$obCon->normalizar($_REQUEST["CmbImpuestosIncluidos"]); 
            $CmbTipoImpuesto=$obCon->normalizar($_REQUEST["CmbTipoImpuesto"]); 
            $CodigoBarras=$obCon->normalizar($_REQUEST["CodigoBarras"]);
            $TxtDescripcion=$obCon->normalizar($_REQUEST["TxtDescripcion"]); 
            $Cantidad=$obCon->normalizar($_REQUEST["Cantidad"]); 
            $ValorUnitario=$obCon->normalizar($_REQUEST["ValorUnitario"]); 
            
            if($CmbListado==1){ //Productosventa
                $idProducto=$CodigoBarras;
                $DatosCodigos=$obCon->DevuelveValores("prod_codbarras", "CodigoBarras", $CodigoBarras);
                if($DatosCodigos["ProductosVenta_idProductosVenta"]<>''){
                    $idProducto=$DatosCodigos["ProductosVenta_idProductosVenta"];
                }
                $DatosProducto=$obCon->DevuelveValores("productosventa", "idProductosVenta", $idProducto);
                if($DatosProducto["idProductosVenta"]==''){
                    exit("Este producto no existe en la base de datos");
                }
                $obCon->IngresaItemOrdenCompra($idCompra, $idProducto, $Cantidad, $ValorUnitario, $CmbTipoImpuesto, $CmbImpuestosIncluidos, "");
                
            }
            /*
            if($CmbListado==3){ //Insumos
                $idProducto=$CodigoBarras;
                $DatosProducto=$obCon->DevuelveValores("insumos", "ID", $idProducto);
                if($DatosProducto["ID"]==''){
                    exit("Este insumo no existe en la base de datos");
                }
                $obCon->AgregueInsumoCompra($idCompra, $idProducto, $Cantidad, $ValorUnitario, $CmbTipoImpuesto, $CmbImpuestosIncluidos, "");
            }
            
            if($CmbListado==2){ //Servicios
                $CuentaPUC=$CodigoBarras;                
                $obCon->AgregueServicioCompra($idCompra, $CuentaPUC, $TxtDescripcion, $ValorUnitario, $CmbTipoImpuesto,$CmbImpuestosIncluidos, "");
            }
             * 
             */
            print("OK");
            
        break;//Fin caso 3
        
        case 4://Se envia a imprimir un tiquete para codigo de barras
            $obPrintBarras = new Barras($idUser);
            $idProducto=$obCon->normalizar($_REQUEST["idProducto"]);
            $Cantidad=$obCon->normalizar($_REQUEST["Cantidad"]);
            $Tabla="productosventa";
            $DatosCB["EmpresaPro"]=1;
            $DatosPuerto=$obCon->DevuelveValores("config_puertos", "ID", 2);
            if($DatosPuerto["Habilitado"]=='SI'){
                $obPrintBarras->ImprimirCodigoBarrasMonarch9416TM($Tabla,$idProducto,$Cantidad,$DatosPuerto["Puerto"],$DatosCB);
           
            }
            print("$Cantidad Tiquetes impresos para el producto $idProducto ");
        break;//fin caso 4
        case 5://Se elimina un item
            $idItem=$obCon->normalizar($_REQUEST["idItem"]);
            $Tabla=$obCon->normalizar($_REQUEST["Tabla"]);
            if($Tabla==1){
                $Tabla="ordenesdecompra_items";
            }
            /*
            if($Tabla==2){
                $Tabla="factura_compra_servicios";
            }
            if($Tabla==3){
                $Tabla="factura_compra_insumos";
            }
            if($Tabla==4){
                $Tabla="factura_compra_items_devoluciones";
            }
            if($Tabla==5){
                $Tabla="factura_compra_retenciones";
            }
            if($Tabla==6){
                $Tabla="factura_compra_descuentos";
            }
            if($Tabla==7){
                $Tabla="factura_compra_impuestos_adicionales";
            }
             * 
             */
            $obCon->BorraReg($Tabla, "ID", $idItem);
            print("Item Eliminado");
        break;//Fin caso 5
        
        case 6://Se devuelve un producto
            $idItem=$obCon->normalizar($_REQUEST["idItem"]);
            $Cantidad=$obCon->normalizar($_REQUEST["Cantidad"]);
            $obCon->DevolverProductoCompra($Cantidad, $idItem, "");
            print("Item Devuelto");
        break;//Fin caso 6
        
        case 7://Se registra un cargo adicional para los totales en compra de productos
            $idCompra=$obCon->normalizar($_REQUEST["idCompra"]);
            $Selector=$obCon->normalizar($_REQUEST["Selector"]);
            $CuentaPUC=$obCon->normalizar($_REQUEST["CuentaPUC"]);
            $Porcentaje=$obCon->normalizar($_REQUEST["Porcentaje"]);
            $Valor=$obCon->normalizar($_REQUEST["Valor"]);
            if($Selector==1 or $Selector==2){ //Retefuente o ReteICA
                $obCon->AgregueRetencionCompra($idCompra, $CuentaPUC, $Valor, $Porcentaje, "");
            }
            if($Selector==3){ //Descuentos Comerciales en compras
                $obCon->AgregueDescuentoCompra($idCompra, $CuentaPUC, $Valor, $Porcentaje, "");
            }
            if($Selector==4){ //Agrega un impuesto adicional
                $obCon->AgregueImpuestoAdicionalCompra($idCompra, $CuentaPUC, $Valor, $Porcentaje, "");
            }
            print("OK");
        break;//Fin caso 7
        
        case 8://Se registra cargos adicionales al iva de los productos
            $idCompra=$obCon->normalizar($_REQUEST["idCompra"]);
            $Selector=$obCon->normalizar($_REQUEST["Selector"]);
            $CuentaPUC=$obCon->normalizar($_REQUEST["CuentaPUC"]);
            $Porcentaje=$obCon->normalizar($_REQUEST["Porcentaje"]);
            $Valor=$obCon->normalizar($_REQUEST["Valor"]);
            if($Selector==1){ //Retefuente o ReteICA
                $obCon->AgregueRetencionCompra($idCompra, $CuentaPUC, $Valor, $Porcentaje, "");
            }
            
            print("OK");
        break;//Fin caso 8
        
        case 9://Guardo la factura
            $idCompra=$obCon->normalizar($_REQUEST["idCompra"]);
            
            $TipoPago=$obCon->normalizar($_REQUEST["CmbTipoPago"]);
            $CuentaOrigen=$obCon->normalizar($_REQUEST["CmbCuentaOrigen"]);
            $CuentaPUCCXP=$obCon->normalizar($_REQUEST["CmbCuentaPUCCXP"]);
            $FechaProgramada=$obCon->normalizar($_REQUEST["TxtFechaProgramada"]);
            $obCon->GuardarFacturaCompra($idCompra, $TipoPago, $CuentaOrigen,$CuentaPUCCXP, $FechaProgramada,"");
            $obCon->ActualicePreciosVentaFacturaCompra($idCompra);
            $LinkTraslado="";
            $LinkFactura="../../VAtencion/PDF_FCompra.php?ID=$idCompra";
            $MensajeTraslado="";
            if($_REQUEST["CmbTraslado"]>0){
                $idSede=$obCon->normalizar($_REQUEST["CmbTraslado"]);
                $idTraslado=$obCon->CrearTrasladoDesdeCompra($idCompra,$idSede, "");
                $LinkTraslado="../../tcpdf/examples/imprimirTraslado.php?idTraslado=$idTraslado";
                $MensajeTraslado="<br><strong>Traslado $idTraslado Creado Correctamente </strong><a href='$LinkTraslado'  target='blank'> Imprimir</a>";
            }
            $Mensaje="<strong>Factura $idCompra Creada Correctamente </strong><a href='$LinkFactura'  target='blank'> Imprimir</a>";
            $Mensaje.=$MensajeTraslado;
            print("OK;$Mensaje");
        break;//Fin caso 9
        
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>