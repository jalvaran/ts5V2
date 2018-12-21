<?php 
$obVenta=new ProcesoVenta($idUser);
if(!empty($_REQUEST['del'])){
    $id=$obVenta->normalizar($_REQUEST['del']);
    $IdPre=$obVenta->normalizar($_REQUEST['TxtIdPre']);
    
    $obVenta->Query("DELETE FROM comprobantes_ingreso_items WHERE ID='$id'");
    header("location:$myPage?idComprobante=$IdPre");
}
//print("<script>alert('entra');</script>");		
if(!empty($_REQUEST["BtnGuardarCI"])){
    
    $idComprobante=$obVenta->normalizar($_REQUEST["idComprobante"]);
         
    $obVenta->RegistreComprobanteIngreso($idComprobante);
   
    header("location:ComprobantesIngreso.php?TxtidIngreso=$idComprobante");
}

if(isset($_REQUEST["BtnCrearCI"])){
    $fecha=$obVenta->normalizar($_REQUEST["TxtFecha"]);
    $Tercero=$obVenta->normalizar($_REQUEST["TxtTerceroCI"]);
    $CuentaDestino=$obVenta->normalizar($_REQUEST["CmbCuentaDestino"]);
    $Monto=$obVenta->normalizar($_REQUEST["TxtMontoCI"]);
    $Concepto=$obVenta->normalizar($_REQUEST["TxtConceptoComprobante"]);
    $idSucursal=$obVenta->normalizar($_REQUEST["idSucursal"]);
    $CentroCosto=$obVenta->normalizar($_REQUEST["CmbCentroCosto"]);
    $tab="comprobantes_ingreso";
    $NumRegistros=7;

    $Columnas[0]="Fecha";		$Valores[0]=$fecha;
    $Columnas[1]="Tercero";             $Valores[1]=$Tercero;
    $Columnas[2]="Valor";               $Valores[2]=$Monto;
    $Columnas[3]="Tipo";		$Valores[3]="";
    $Columnas[4]="Concepto";		$Valores[4]=$Concepto;
    $Columnas[5]="Usuarios_idUsuarios";	$Valores[5]=$idUser;
    $Columnas[6]="Estado";      	$Valores[6]="ABIERTO";
    
    $obVenta->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
    $idIngreso=$obVenta->ObtenerMAX($tab,"ID", 1,"");
    $DatosCuentaDestino=$obVenta->DevuelveValores("cuentasfrecuentes", "CuentaPUC", $CuentaDestino);
    $obVenta->AgregueMovimientoCI($fecha, $CentroCosto,$idSucursal, $Tercero, $CuentaDestino, "D", $Monto, $Concepto, "", "", $idIngreso, $DatosCuentaDestino["Nombre"], "");
    header("location:$myPage?idComprobante=$idIngreso");
    
}


if(!empty($_REQUEST["BtnAgregarItemMov"])){
        
    $destino="";
    //echo "<script>alert ('entra')</script>";
    if(!empty($_FILES['foto']['name'])){
        
        $carpeta="../SoportesEgresos/";
        opendir($carpeta);
        $Name=str_replace(' ','_',$_FILES['foto']['name']);  
        $destino=$carpeta.$Name;
        move_uploaded_file($_FILES['foto']['tmp_name'],$destino);
    }
    
    $idComprobante=$obVenta->normalizar($_REQUEST["idComprobante"]);
    $DatosComprobante=$obVenta->DevuelveValores("comprobantes_ingreso", "ID", $idComprobante);
    $fecha=$DatosComprobante["Fecha"];
    
    $Concepto=$obVenta->normalizar($_REQUEST["TxtConceptoMovimiento"]);
    $CentroCosto=$obVenta->normalizar($_REQUEST["CmbCentroCosto"]);
    $idSucursal=$obVenta->normalizar($_REQUEST["idSucursal"]);
    $Tercero=$obVenta->normalizar($_REQUEST["CmbTerceroItem"]);
    $DatosCuentaDestino=$_REQUEST["CmbCuentaDestino"];
    $DatosCuentaDestino=explode(";",$DatosCuentaDestino);
    $CuentaPUC=$DatosCuentaDestino[0];
    $NombreCuenta=str_replace("_"," ",$DatosCuentaDestino[1]);
    
    $Valor=$obVenta->normalizar($_REQUEST["TxtValorItem"]);
    $DC=$obVenta->normalizar($_REQUEST["CmbDebitoCredito"]);
    $NumDocSoporte=$obVenta->normalizar($_REQUEST["TxtNumFactura"]);
    $obVenta->AgregueMovimientoCI($fecha, $CentroCosto,$idSucursal, $Tercero, $CuentaPUC, $DC, $Valor, $Concepto, $NumDocSoporte, $destino, $idComprobante, $NombreCuenta, "");
    //header("location:$myPage?idComprobante=$idComprobante");
}

if(!empty($_REQUEST["BtnAgregarMovCXC"])){
    $idComprobante=$obVenta->normalizar($_REQUEST["idComprobante"]);
    $idCartera=$obVenta->normalizar($_REQUEST["idCartera"]);
    $Monto=$obVenta->normalizar($_REQUEST["TxtMontoAbono"]);
    $DatosComprobante=$obVenta->DevuelveValores("comprobantes_ingreso", "ID", $idComprobante);
    $fecha=$DatosComprobante["Fecha"];
    $DatosCartera=$obVenta->DevuelveValores("cartera", "idCartera", $idCartera);
    $DatosFactura=$obVenta->DevuelveValores("facturas", "idFacturas", $DatosCartera["Facturas_idFacturas"]);
    $DatosCliente=$obVenta->DevuelveValores("clientes", "idClientes", $DatosCartera["idCliente"]);
    $DatosCuentaDestino=$obVenta->DevuelveValores("parametros_contables", "ID", 6);
    $Concepto="Abono a Factura $DatosFactura[Prefijo]-$DatosFactura[NumeroFactura]";
    $obVenta->AgregueMovimientoCI($fecha, $DatosFactura["CentroCosto"],$DatosFactura["idSucursal"], $DatosCliente["Num_Identificacion"], $DatosCuentaDestino["CuentaPUC"], "C", $Monto, $Concepto, "", "", $idComprobante, $DatosCuentaDestino["NombreCuenta"], "","cartera",$idCartera);
}
///////////////fin
?>