<?php
/* 
 * Este archivo procesa el registro de notas de devolucion
 */

$obCompra=new Compra($idUser);
if(!empty($_REQUEST["BtnCrear"])){
      
$Fecha=$obCompra->normalizar($_REQUEST["TxtFecha"]);
$Tercero=$obCompra->normalizar($_REQUEST["TxtTerceroCI"]);
$PlazoEntrega=$obCompra->normalizar($_REQUEST["TxtDias"]);
$NoCotizacion=$obCompra->normalizar($_REQUEST["TxtCotizacion"]);
$Condiciones=$obCompra->normalizar($_REQUEST["TxtCondiciones"]);
$Descripcion=$obCompra->normalizar($_REQUEST["TxtDescripcion"]);
$Solicitante=$obCompra->normalizar($_REQUEST["TxtSolicitante"]);

$idCompra=$obCompra->CrearOrdenCompra($Fecha, $Tercero, $Descripcion, $PlazoEntrega, $NoCotizacion, $Condiciones, $Solicitante, "", $idUser, "");
header("location:$myPage?idOrden=$idCompra");
      
}
if(!empty($_REQUEST["AbrirOrden"])){
    $idOrden=$_REQUEST["AbrirOrden"];
    //$obCompra->ActualizaRegistro("ordenesdecompra", "Estado", "ABIERTA", "ID", $idOrden);
    header("location:$myPage?idOrden=$idOrden");
}
//Verificamos si se recibe la peticion de Agregar un item a la compra
if(!empty($_REQUEST["BtnEditarFactura"])){
      
    $idOrden=$obCompra->normalizar($_REQUEST["idOrden"]);
    $Fecha=$obCompra->normalizar($_REQUEST["TxtFechaEdit"]);
    $Tercero=$obCompra->normalizar($_REQUEST["CmbTerceroEdit"]);
    $Concepto=$obCompra->normalizar($_REQUEST["TxtConceptoServicioEdit"]);
    $Condiciones=$obCompra->normalizar($_REQUEST["TxtCondicionesEdit"]);
    
    $obCompra->ActualizaRegistro("ordenesdecompra", "Fecha", $Fecha, "ID", $idOrden);
    $obCompra->ActualizaRegistro("ordenesdecompra", "Tercero", $Tercero, "ID", $idOrden);
    $obCompra->ActualizaRegistro("ordenesdecompra", "Descripcion", $Concepto, "ID", $idOrden);
    $obCompra->ActualizaRegistro("ordenesdecompra", "Condiciones", $Condiciones, "ID", $idOrden);
    header("location:$myPage?idOrden=$idOrden");
      
}


//Agrega un item a la compra

if(isset($_REQUEST["BtnAgregarItem"])){
    $idOrden=$obCompra->normalizar($_REQUEST["idOrden"]);
    $idProducto=$obCompra->normalizar($_REQUEST["TxtidProducto"]);
    $Referencia=$obCompra->normalizar($_REQUEST["TxtReferencia"]);
    $Nombre=$obCompra->normalizar($_REQUEST["TxtNombre"]);
    $Cantidad=$obCompra->normalizar($_REQUEST["TxtCantidad"]);
    $TipoIVA=$obCompra->normalizar($_REQUEST["TipoIVA"]);
    $IVAIncluido=$obCompra->normalizar($_REQUEST["IVAIncluido"]);
    $CostoUnitario=$obCompra->normalizar($_REQUEST["TxtCosto"]);
    switch ($_REQUEST["TipoItem"]){
        case 1:
            $obCompra->IngresaItemOrdenCompra($idOrden, $idProducto, $Referencia, $Nombre,$Cantidad, $CostoUnitario, $TipoIVA, $IVAIncluido, "");
            break;
    }
    //header("location:$myPage?idOrden=$idOrden");
}


//Guardar Compra

if(isset($_REQUEST["GuardarOrden"])){
    $idOrden=$obCompra->normalizar($_REQUEST["idOrden"]);
    $obCompra->ActualizaRegistro("ordenesdecompra", "Estado", "CERRADA", "ID", $idOrden);    
    header("location:$myPage?idOrdenCompra=$idOrden");
}


//Eliminar un producto devuelto

if(isset($_REQUEST["DelProducto"])){
    $idItem=$obCompra->normalizar($_REQUEST["DelProducto"]);
    $idOrden=$_REQUEST["idOrden"];
    $obCompra->BorraReg("ordenesdecompra_items", "ID", $idItem);
    header("location:$myPage?idOrden=$idOrden");
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