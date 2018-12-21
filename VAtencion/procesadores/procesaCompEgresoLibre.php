<?php 
$obVenta=new ProcesoVenta($idUser);
if(!empty($_REQUEST['del'])){
    $id=$obVenta->normalizar($_REQUEST['del']);
    $IdPre=$obVenta->normalizar($_REQUEST['TxtIdPre']);
    $DatosItem=$obVenta->DevuelveValores("comprobantes_egreso_items", "ID", $id);
    $obVenta->ActualizaRegistro("cuentasxpagar", "Estado", "", "ID", $DatosItem["idOrigen"]);
    $obVenta->Query("DELETE FROM comprobantes_egreso_items WHERE ID='$id'");
    
    header("location:$myPage?idComprobante=$IdPre");
}
//print("<script>alert('entra');</script>");		
if(!empty($_REQUEST["BtnGuardarCI"])){
    
    $idComprobante=$obVenta->normalizar($_REQUEST["idComprobante"]);
         
    $obVenta->RegistreComprobanteEgresoLibre($idComprobante);
   
    header("location:$myPage?TxtidIngreso=$idComprobante");
}

if(isset($_REQUEST["BtnCrearCI"])){
    $fecha=$obVenta->normalizar($_REQUEST["TxtFecha"]);
    $Tercero=$obVenta->normalizar($_REQUEST["TxtTerceroCI"]);
    $DatosTercero=$obVenta->DevuelveValores("proveedores", "Num_Identificacion", $Tercero);
    if($DatosTercero==''){
        $DatosTercero=$obVenta->DevuelveValores("clientes", "Num_Identificacion", $Tercero);
    }
    $CuentaDestino=$obVenta->normalizar($_REQUEST["CmbCuentaDestino"]);
    $Monto=$obVenta->normalizar($_REQUEST["TxtMontoCI"]);
    $Concepto=$obVenta->normalizar($_REQUEST["TxtConceptoComprobante"]);
    $idSucursal=$obVenta->normalizar($_REQUEST["idSucursal"]);
    $CentroCosto=$obVenta->normalizar($_REQUEST["CmbCentroCosto"]);
    
    $NumRegistros=21;

    $Columnas[0]="Fecha";			$Valores[0]=$fecha;
    $Columnas[1]="Beneficiario";		$Valores[1]=$DatosTercero["RazonSocial"];
    $Columnas[2]="NIT";				$Valores[2]=$DatosTercero["Num_Identificacion"];
    $Columnas[3]="Concepto";			$Valores[3]=$Concepto;
    $Columnas[4]="Valor";			$Valores[4]=$Monto;
    $Columnas[5]="Usuario_idUsuario";           $Valores[5]=$idUser;
    $Columnas[6]="PagoProg";			$Valores[6]="contado";
    $Columnas[7]="FechaPagoPro";		$Valores[7]=$fecha;
    $Columnas[8]="TipoEgreso";			$Valores[8]="ABIERTO";
    $Columnas[9]="Direccion";			$Valores[9]=$DatosTercero["Direccion"];
    $Columnas[10]="Ciudad";			$Valores[10]=$DatosTercero["Ciudad"];
    $Columnas[11]="Subtotal";			$Valores[11]=$Monto;
    $Columnas[12]="IVA";			$Valores[12]=0;
    $Columnas[13]="NumFactura";			$Valores[13]="EL";
    $Columnas[14]="idProveedor";		$Valores[14]="";
    $Columnas[15]="Cuenta";			$Valores[15]=$CuentaDestino;
    $Columnas[16]="CentroCostos";		$Valores[16]=$CentroCosto;	
    $Columnas[17]="EmpresaPro";                 $Valores[17]= 1;	
    $Columnas[18]="Soporte";                    $Valores[18]= "";
    $Columnas[19]="Retenciones";                $Valores[19]= 0;
    $Columnas[20]="idSucursal";                 $Valores[20]= $idSucursal;
    $obVenta->InsertarRegistro("egresos",$NumRegistros,$Columnas,$Valores);

    $NumEgreso=$obVenta->ObtenerMAX("egresos","idEgresos", 1, "");
   
    $DatosCuentaDestino=$obVenta->DevuelveValores("cuentasfrecuentes", "CuentaPUC", $CuentaDestino);
    $obVenta->AgregueMovimientoCE($fecha, $CentroCosto,$idSucursal, $Tercero, $CuentaDestino, "C", $Monto, $Concepto, "", "", $NumEgreso, $DatosCuentaDestino["Nombre"], "");
    header("location:$myPage?idComprobante=$NumEgreso");
    
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
    $DatosComprobante=$obVenta->DevuelveValores("egresos", "idEgresos", $idComprobante);
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
    $obVenta->AgregueMovimientoCE($fecha, $CentroCosto,$idSucursal, $Tercero, $CuentaPUC, $DC, $Valor, $Concepto, $NumDocSoporte, $destino, $idComprobante, $NombreCuenta, "");
    //header("location:$myPage?idComprobante=$idComprobante");
}

if(!empty($_REQUEST["BtnAgregarMovCXP"])){
    $idComprobante=$obVenta->normalizar($_REQUEST["idComprobante"]);
    $idCartera=$obVenta->normalizar($_REQUEST["idCartera"]);
    $Monto=$obVenta->normalizar($_REQUEST["TxtMontoAbono"]);
    $DatosComprobante=$obVenta->DevuelveValores("egresos", "idEgresos", $idComprobante);
    $fecha=$DatosComprobante["Fecha"];
    $DatosCuentaXPagar=$obVenta->DevuelveValores("cuentasxpagar", "ID", $idCartera);
    
    $DatosCuentaDestino=$obVenta->DevuelveValores("parametros_contables", "ID", 14);
    $Concepto="Abono a Cuenta X Pagar a Factura $DatosCuentaXPagar[DocumentoReferencia] con ID: $idCartera";
    $obVenta->AgregueMovimientoCE($fecha, $DatosCuentaXPagar["idCentroCostos"],$DatosCuentaXPagar["idSucursal"], $DatosCuentaXPagar["idProveedor"], $DatosCuentaDestino["CuentaPUC"], "D", $Monto, $Concepto, $DatosCuentaXPagar["DocumentoReferencia"], "", $idComprobante, $DatosCuentaDestino["NombreCuenta"], "","cartera",$idCartera);
    $obVenta->ActualizaRegistro("cuentasxpagar", "Estado", "ABIERTO", "ID", $idCartera);
    
}
///////////////fin
?>