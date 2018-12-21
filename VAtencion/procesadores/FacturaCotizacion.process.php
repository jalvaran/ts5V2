<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
///////////////////////////////
////////Si se solicita borrar algo
////
////
$obVenta=new ProcesoVenta($idUser);
if(!empty($_REQUEST['del'])){
    $id=$_REQUEST['del'];
    $Tabla=$_REQUEST['TxtTabla'];
    $IdTabla=$_REQUEST['TxtIdTabla'];
    $IdPre=$_REQUEST['TxtIdPre'];
    $obVenta->Query("DELETE FROM $Tabla WHERE $IdTabla='$id'");
    header("location:FacturaCotizacion.php");
}

/*
 * 
 * Si llega la peticion de crear la factura
 * 
 */

if(!empty($_REQUEST["TxtAsociarCotizacion"])){
    $idCotizacion=$_REQUEST["TxtAsociarCotizacion"];
    
    $Error=$obVenta->AgregarCotizacionPrefactura($idCotizacion);
    if(is_array($Error)){
        foreach ($Error as $Productos){
            $css->CrearNotificacionRoja("El producto con el id $Productos no tiene existencias, no se puede realizar la factura",16);
        }
        $obVenta->VaciarTabla("facturas_pre");
    }
    //header("location:FacturaCotizacion.php");
}
if(isset($_REQUEST["BtnFacturarSinAjuste"])){
    $idRemision=$obVenta->normalizar($_REQUEST["idRemision"]);
    $Multiplicador=$obVenta->normalizar($_REQUEST["TxtMultiplicador"]);
    //print("$idRemision $Multiplicador");
    $Consulta=$obVenta->ConsultarTabla("rem_relaciones", "WHERE idRemision='$idRemision' GROUP BY idItemCotizacion");
    while($DatosItemRemision=$obVenta->FetchArray($Consulta)){
        $DatosItems=$obVenta->DevuelveValores("cot_itemscotizaciones", "ID", $DatosItemRemision["idItemCotizacion"]);
        $Entregas=$obVenta->Sume('rem_relaciones', "CantidadEntregada", " WHERE idItemCotizacion=$DatosItemRemision[idItemCotizacion] AND idRemision='$idRemision'");
        $Salidas=$obVenta->Sume("rem_pre_devoluciones", "Cantidad", " WHERE idItemCotizacion=$DatosItemRemision[idItemCotizacion] AND idRemision='$idRemision'");
        $Salidas2=$obVenta->Sume("rem_devoluciones", "Cantidad", " WHERE idItemCotizacion=$DatosItemRemision[idItemCotizacion] AND idRemision='$idRemision'");
        $PendienteDevolver=$Entregas-$Salidas-$Salidas2;
        $Referencia=$DatosItems["Referencia"];
        $Tabla=$DatosItems["TablaOrigen"];
        $DatosProducto=$obVenta->ValorActual($Tabla, "idProductosVenta", " Referencia='$Referencia'");
		$VectorFacturaCoti["PrecioAcordado"]=$DatosItems["ValorUnitario"];
        $obVenta->AgregarItemPrefactura($Tabla, $DatosProducto["idProductosVenta"], $PendienteDevolver, $Multiplicador, $VectorFacturaCoti);
    }
    
    //header("location:FacturaCotizacion.php");
}
////Se recibe edicion
	
if(!empty($_REQUEST['BtnEditar'])){

        $idItem=$_REQUEST['TxtIdItemCotizacion'];
        $idCotizacion=$_REQUEST['TxtIdCotizacion'];
        //$Tabla=$_REQUEST['TxtTabla'];
        $Cantidad=$_REQUEST['TxtCantidad'];
        $ValorAcordado=$_REQUEST['TxtValorUnitario'];
        $Multiplicador=$_REQUEST['TxtMultiplicador'];
        $obVenta=new ProcesoVenta($idUser);
        $DatosPreventa=$obVenta->DevuelveValores('facturas_pre',"ID",$idItem);
        $Subtotal=round($ValorAcordado*$Cantidad*$Multiplicador);
        $DatosProductos=$obVenta->DevuelveValores($DatosPreventa["TablaItems"],"Referencia",$DatosPreventa["Referencia"]);
        $IVA=round($Subtotal*$DatosProductos["IVA"]);
        $SubtotalCosto=round($DatosProductos["CostoUnitario"]*$Cantidad);
        $Total=$Subtotal+$IVA;
        $filtro="ID";

        $obVenta->ActualizaRegistro("facturas_pre","SubtotalItem", $Subtotal, $filtro, $idItem);
        $obVenta->ActualizaRegistro("facturas_pre","IVAItem", $IVA, $filtro, $idItem);
        $obVenta->ActualizaRegistro("facturas_pre","SubtotalCosto", $SubtotalCosto, $filtro, $idItem);
        $obVenta->ActualizaRegistro("facturas_pre","TotalItem", $Total, $filtro, $idItem);
        $obVenta->ActualizaRegistro("facturas_pre","ValorUnitarioItem", $ValorAcordado, $filtro, $idItem);
        $obVenta->ActualizaRegistro("facturas_pre","Cantidad", $Cantidad, $filtro, $idItem);
        $obVenta->ActualizaRegistro("facturas_pre","Dias", $Multiplicador, $filtro, $idItem);

        header("location:FacturaCotizacion.php");

}
/*
 * 
 * Si llega la peticion de crear la factura
 * 
 */

if(!empty($_REQUEST["BtnGenerarFactura"])){
        $obVenta=new ProcesoVenta($idUser);
        
        $DatosFactura["CmbCliente"]=$obVenta->normalizar($_REQUEST['CmbCliente']);        
        $DatosFactura["CmbCentroCostos"]=$obVenta->normalizar($_REQUEST["CmbCentroCostos"]);
        $DatosFactura["CmbResolucion"]=$obVenta->normalizar($_REQUEST["CmbResolucion"]);
        $DatosFactura["CmbFormaPago"]=$obVenta->normalizar($_REQUEST["CmbFormaPago"]);
        $DatosFactura["CmbCuentaDestino"]=$obVenta->normalizar($_REQUEST["CmbCuentaDestino"]);
        $DatosFactura["TxtOrdenCompra"]=$obVenta->normalizar($_REQUEST["TxtOrdenCompra"]);
        $DatosFactura["TxtOrdenSalida"]=$obVenta->normalizar($_REQUEST["TxtOrdenSalida"]);
        $DatosFactura["TxtObservacionesFactura"]=$obVenta->normalizar($_REQUEST["TxtObservacionesFactura"]);
        $DatosFactura["TxtFechaFactura"]=$obVenta->normalizar($_REQUEST["TxtFechaFactura"]);
        $DatosFactura["TxtNumeroFactura"]=$obVenta->normalizar($_REQUEST["TxtNumeroFactura"]);
        $DatosFactura["CmbColaborador"]=$obVenta->normalizar($_REQUEST["CmbColaborador"]);
        
        
        $ID=$obVenta->CrearFacturaDesdePrefactura($DatosFactura);
        $obVenta->BorraReg("facturas_pre", "idUsuarios", $idUser);
        if($_REQUEST['CmbFacturaFrecuente']<>'NO'){
            $Periodo=$obVenta->normalizar($_REQUEST['CmbFacturaFrecuente']);
            $Datos["idCliente"]=$DatosFactura["CmbCliente"];
            $Datos["Periodo"]=$Periodo;
            $Datos["FacturaBase"]=$ID;
            $Datos["UltimaFactura"]=$ID;
            $Datos["Habilitado"]=1;
            $sql=$obVenta->getSQLInsert("facturas_frecuentes", $Datos);
            $obVenta->Query($sql);
        }
        header("location:FacturaCotizacion.php?TxtidFactura=$ID");
        
    }
    
    //Si se agrega un item
    if(isset($_REQUEST["BtnAgregar"])){
        $Tabla=$obVenta->normalizar($_REQUEST['TxtTablaItem']); 
        $idProducto=$obVenta->normalizar($_REQUEST['TxtAgregarItemPreventa']);   
        $Cantidad=$obVenta->normalizar($_REQUEST['TxtCantidad']); 
        $Multiplicador=1;
        if(isset($_REQUEST['TxtMultiplicador'])){
            $Multiplicador=$obVenta->normalizar($_REQUEST['TxtMultiplicador']); 
        }
        $obVenta->AgregarItemPrefactura($Tabla,$idProducto,$Cantidad,$Multiplicador,"");
    }
    

?>