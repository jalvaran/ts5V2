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
        
        case 1: //Crear una compra
            $Fecha=$obCon->normalizar($_REQUEST["Fecha"]); 
            $idTercero=$obCon->normalizar($_REQUEST["Tercero"]); 
            $CentroCostos=$obCon->normalizar($_REQUEST["ControCosto"]); 
            $idSucursal=$obCon->normalizar($_REQUEST["Sucursal"]); 
            $TipoCompra=$obCon->normalizar($_REQUEST["TipoCompra"]);
            $Concepto=$obCon->normalizar($_REQUEST["Concepto"]); 
            $NumeroFactura=$obCon->normalizar($_REQUEST["NumFactura"]); 
            $Observaciones="";
            $idCompra=$obCon->CrearCompra($Fecha, $idTercero, $Observaciones, $CentroCostos, $idSucursal, $idUser, $TipoCompra, $NumeroFactura, $Concepto, "");
            print("OK;$idCompra");            
            
        break; 
        
        case 2: //editar datos generales de una factura de compra
            $idCompra=$obCon->normalizar($_REQUEST["idCompraActiva"]); 
            $Fecha=$obCon->normalizar($_REQUEST["Fecha"]); 
            $idTercero=$obCon->normalizar($_REQUEST["Tercero"]); 
            $CentroCostos=$obCon->normalizar($_REQUEST["ControCosto"]); 
            $idSucursal=$obCon->normalizar($_REQUEST["Sucursal"]); 
            $TipoCompra=$obCon->normalizar($_REQUEST["TipoCompra"]);
            $Concepto=$obCon->normalizar($_REQUEST["Concepto"]); 
            $NumeroFactura=$obCon->normalizar($_REQUEST["NumFactura"]); 
            
            $obCon->ActualizaRegistro("factura_compra", "Fecha", $Fecha, "ID", $idCompra,0);
            $obCon->ActualizaRegistro("factura_compra", "Tercero", $idTercero, "ID", $idCompra,0);
            $obCon->ActualizaRegistro("factura_compra", "idCentroCostos", $CentroCostos, "ID", $idCompra,0);
            $obCon->ActualizaRegistro("factura_compra", "idSucursal", $idSucursal, "ID", $idCompra,0);
            $obCon->ActualizaRegistro("factura_compra", "TipoCompra", $TipoCompra, "ID", $idCompra,0);
            $obCon->ActualizaRegistro("factura_compra", "Concepto", $Concepto, "ID", $idCompra,0);
            $obCon->ActualizaRegistro("factura_compra", "NumeroFactura", $NumeroFactura, "ID", $idCompra,0);
            
            $destino="";
            $Atras="";
            $carpeta="";
            if(!empty($_FILES['Soporte']['name'])){
                //echo "<script>alert ('entra foto')</script>";
                $Atras="../";
                $carpeta="soportes/";
                opendir($Atras.$carpeta);
                $Name=$idCompra."_".str_replace(' ','_',$_FILES['Soporte']['name']);
                $destino=$carpeta.$Name;
                move_uploaded_file($_FILES['Soporte']['tmp_name'],$Atras.$destino);
                $obCon->ActualizaRegistro("factura_compra", "Soporte", $destino, "ID", $idCompra);
            }
            
            $DatosTercero=$obCon->DevuelveValores("proveedores", "Num_Identificacion", $idTercero);
            
            print("OK;$DatosTercero[RazonSocial];$Concepto;$NumeroFactura");
            
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
            if($CmbListado==1){
                $idProducto=$CodigoBarras;
                $DatosCodigos=$obCon->DevuelveValores("prod_codbarras", "CodigoBarras", $CodigoBarras);
                if($DatosCodigos["ProductosVenta_idProductosVenta"]<>''){
                    $idProducto=$DatosCodigos["ProductosVenta_idProductosVenta"];
                }
                $DatosProducto=$obCon->DevuelveValores("productosventa", "idProductosVenta", $idProducto);
                if($DatosProducto["idProductosVenta"]==''){
                    exit("Este producto no existe en la base de datos");
                }
                $obCon->AgregueProductoCompra($idCompra, $idProducto, $Cantidad, $ValorUnitario, $CmbTipoImpuesto, $CmbImpuestosIncluidos, "");
            
            }
            
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
                $Tabla="factura_compra_items";
            }
            if($Tabla==2){
                $Tabla="factura_compra_servicios";
            }
            if($Tabla==3){
                $Tabla="factura_compra_insumos";
            }
            if($Tabla==4){
                $Tabla="factura_compra_items_devoluciones";
            }
            $obCon->BorraReg($Tabla, "ID", $idItem);
            print("Item Eliminado");
        break;//Fin caso 5
        
        case 6://Se devuelve un producto
            $idItem=$obCon->normalizar($_REQUEST["idItem"]);
            $Cantidad=$obCon->normalizar($_REQUEST["Cantidad"]);
            $obCon->DevolverProductoCompra($Cantidad, $idItem, "");
            print("Item Devuelto");
        break;//Fin caso 6
        
        
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>