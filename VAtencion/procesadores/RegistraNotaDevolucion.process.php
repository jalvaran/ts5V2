<?php
/* 
 * Este archivo procesa el registro de notas de devolucion
 */

$obCompra=new Compra($idUser);
if(!empty($_REQUEST["BtnCrear"])){
      
$Fecha=$obCompra->normalizar($_REQUEST["TxtFecha"]);
$idTercero=$obCompra->normalizar($_REQUEST["TxtTerceroCI"]);
$CentroCosto=$obCompra->normalizar($_REQUEST["CmbCentroCosto"]);
$idSede=$obCompra->normalizar($_REQUEST["idSucursal"]);

$Concepto=$obCompra->normalizar($_REQUEST["TxtConcepto"]);
$idNota=$obCompra->CrearNotaDevolucion($Fecha, $idTercero, $Concepto, $CentroCosto, $idSede, $idUser, "");
header("location:$myPage?idNota=$idNota");
      
}

//Verificamos si se recibe la peticion de Agregar un item a la compra
if(!empty($_REQUEST["BtnEditarFactura"])){
      
    $idNota=$obCompra->normalizar($_REQUEST["idNota"]);
    $Fecha=$obCompra->normalizar($_REQUEST["TxtFechaEdit"]);
    $Tercero=$obCompra->normalizar($_REQUEST["CmbTerceroEdit"]);
    $Concepto=$obCompra->normalizar($_REQUEST["TxtConceptoServicioEdit"]);
    
    $obCompra->ActualizaRegistro("factura_compra_notas_devolucion", "Fecha", $Fecha, "ID", $idNota);
    $obCompra->ActualizaRegistro("factura_compra_notas_devolucion", "Tercero", $Tercero, "ID", $idNota);
    $obCompra->ActualizaRegistro("factura_compra_notas_devolucion", "Concepto", $Concepto, "ID", $idNota);
    
    header("location:$myPage?idNota=$idNota");
      
}


//Agrega un item a la compra

if(isset($_REQUEST["BtnAgregarItem"])){
    $idNota=$obCompra->normalizar($_REQUEST["idCompra"]);
    $idProducto=$obCompra->normalizar($_REQUEST["TxtidProducto"]);
    $Cantidad=$obCompra->normalizar($_REQUEST["TxtCantidad"]);
    $TipoIVA=$obCompra->normalizar($_REQUEST["TipoIVA"]);
    $IVAIncluido=$obCompra->normalizar($_REQUEST["IVAIncluido"]);
    $CostoUnitario=$obCompra->normalizar($_REQUEST["TxtCosto"]);
    switch ($_REQUEST["TipoItem"]){
        case 1:
            $obCompra->IngresaItemNotaDevolucion($idNota, $idProducto, $Cantidad, $CostoUnitario, $TipoIVA, $IVAIncluido, "");
            
            break;
    }
    header("location:$myPage?idNota=$idNota");
}


//Guardar Compra

if(isset($_REQUEST["GuardarNota"])){
    $idNota=$obCompra->normalizar($_REQUEST["idNota"]);
    
    $obCompra->GuardarNotaDevolucion($idNota,"");
    
    header("location:$myPage?idNotaDevolucion=$idNota");
}


//Eliminar un producto devuelto

if(isset($_REQUEST["DelProductoDevuelto"])){
    $idItem=$obCompra->normalizar($_REQUEST["DelProductoDevuelto"]);
    $idCompra=$_REQUEST["idNota"];
    $obCompra->BorraReg("factura_compra_items_devoluciones", "ID", $idItem);
    header("location:$myPage?idNota=$idCompra");
}

//Devolver un item 

if(isset($_REQUEST["BtnAplicaDescuento"])){
    $idCompra=$obCompra->normalizar($_REQUEST["idCompra"]);
    $idProducto=$obCompra->normalizar($_REQUEST["idProducto"]);
    $Descuento=$obCompra->normalizar($_REQUEST["TxtDescuentoCompra"]);
    $idFacturaItems=$obCompra->normalizar($_REQUEST["idFacturaItems"]);
    $DatosItem=$obCompra->DevuelveValores("factura_compra_items", "ID", $idFacturaItems);
    
    $ValorDescuento=round($DatosItem["CostoUnitarioCompra"]*($Descuento/100),2);
    $SubtotalDescuento=$ValorDescuento*$DatosItem["Cantidad"];
    $ValorUnitario=$DatosItem["CostoUnitarioCompra"]-$ValorDescuento;
    $Subtotal=$ValorUnitario*$DatosItem["Cantidad"];
    $IVA=round($Subtotal*$DatosItem["Tipo_Impuesto"],2);
    $Total=$Subtotal+$IVA;
    $obCompra->ActualizaRegistro("factura_compra_items", "ProcentajeDescuento", $Descuento, "ID", $idFacturaItems); 
    $obCompra->ActualizaRegistro("factura_compra_items", "ValorDescuento", $ValorDescuento, "ID", $idFacturaItems);
    $obCompra->ActualizaRegistro("factura_compra_items", "SubtotalDescuento", $SubtotalDescuento, "ID", $idFacturaItems);
    $obCompra->ActualizaRegistro("factura_compra_items", "CostoUnitarioCompra", $ValorUnitario, "ID", $idFacturaItems); 
    $obCompra->ActualizaRegistro("factura_compra_items", "SubtotalCompra", $Subtotal, "ID", $idFacturaItems); 
    $obCompra->ActualizaRegistro("factura_compra_items", "ImpuestoCompra", $IVA, "ID", $idFacturaItems); 
    $obCompra->ActualizaRegistro("factura_compra_items", "TotalCompra", $Total, "ID", $idFacturaItems); 
    header("location:$myPage?idCompra=$idCompra");
}

//Copiar una factura de compra

if(isset($_REQUEST["BtnCopiarFactura"])){
    $idCompra=$obCompra->normalizar($_REQUEST["BtnCopiarFactura"]);
    $idCompraNew=$obCompra->CopiarFacturaCompra($idCompra,$idUser, "");
    header("location:$myPage?idCompra=$idCompraNew");
}
?>