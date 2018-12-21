<?php
/* 
 * Este archivo procesa el registro de compras
 */

//$obVenta=new ProcesoVenta($idUser); 
$obCompra=new Compra($idUser);
if(!empty($_REQUEST["BtnCrearCompra"])){
      
$Fecha=$obCompra->normalizar($_REQUEST["TxtFecha"]);
$idTercero=$obCompra->normalizar($_REQUEST["TxtTerceroCI"]);
$CentroCosto=$obCompra->normalizar($_REQUEST["CmbCentroCosto"]);
$idSede=$obCompra->normalizar($_REQUEST["idSucursal"]);
$TipoCompra=$obCompra->normalizar($_REQUEST["TipoCompra"]);
$NumeroFactura=$obCompra->normalizar($_REQUEST["TxtNumFactura"]);
$Concepto=$obCompra->normalizar($_REQUEST["TxtConcepto"]);
$idCompra=$obCompra->CrearCompra($Fecha, $idTercero, "", $CentroCosto, $idSede, $idUser,$TipoCompra,$NumeroFactura,$Concepto, "");
if(isset($_REQUEST["TxtIdOrdenOrdenCompra"])){
    $idOrden=$obCompra->normalizar($_REQUEST["TxtIdOrdenOrdenCompra"]);
    $obCompra->AgregueItemDesdeOrdenCompra($idCompra, $idOrden, "");    
}

header("location:$myPage?idCompra=$idCompra");

      
}
//Verificamos si se recibe la peticion de Agregar un item a la compra
if(!empty($_REQUEST["TxtAgregarItemCompra"])){
      
    $idItem=$obCompra->normalizar($_REQUEST["TxtAgregarItemCompra"]);
    $idCompra=$obCompra->normalizar($_REQUEST["TxtAgregarItemCompra"]);
    $idCompra=$obCompra->CrearCompra($Fecha, $idTercero, "", $CentroCosto, $idSede, $idUser,$TipoCompra,$NumeroFactura,$Concepto, $Vector);
    header("location:$myPage?idCompra=$idCompra");
      
}

//Verificamos si se recibe la peticion de Agregar un item a la compra
if(!empty($_REQUEST["BtnEditarFactura"])){
      
    $idCompra=$obCompra->normalizar($_REQUEST["idCompra"]);
    $Fecha=$obCompra->normalizar($_REQUEST["TxtFechaEdit"]);
    $Tercero=$obCompra->normalizar($_REQUEST["CmbTerceroEdit"]);
    $Concepto=$obCompra->normalizar($_REQUEST["TxtConceptoServicioEdit"]);
    $NumFact=$obCompra->normalizar($_REQUEST["TxtNumFacturaEdit"]);
    $obCompra->ActualizaRegistro("factura_compra", "Fecha", $Fecha, "ID", $idCompra);
    $obCompra->ActualizaRegistro("factura_compra", "Tercero", $Tercero, "ID", $idCompra);
    $obCompra->ActualizaRegistro("factura_compra", "Concepto", $Concepto, "ID", $idCompra);
    $obCompra->ActualizaRegistro("factura_compra", "NumeroFactura", $NumFact, "ID", $idCompra);
    header("location:$myPage?idCompra=$idCompra");
      
}

//SI se recibe la solicitud de crear un proveedor

if(!empty($_REQUEST['BtnCrearProveedor'])){
		
    $NIT=$_REQUEST['TxtNIT'];
    $idCodMunicipio=$_REQUEST['CmbCodMunicipio'];
    $obVenta=new ProcesoVenta($idUser);
    $DatosClientes=$obVenta->DevuelveValores('proveedores',"Num_Identificacion",$NIT);
    $DV="";
    $DatosMunicipios=$obVenta->DevuelveValores('cod_municipios_dptos',"ID",$idCodMunicipio);		
    if($DatosClientes["Num_Identificacion"]<>$NIT){

            ///////////////////////////Ingresar a Clientes 

            if($_REQUEST['CmbTipoDocumento']==31){

                    $DV=$obVenta->CalcularDV($NIT);

            }

            $tab="proveedores";
            $NumRegistros=15;  


            $Columnas[0]="Tipo_Documento";					$Valores[0]=$obVenta->normalizar($_REQUEST['CmbTipoDocumento']);
            $Columnas[1]="Num_Identificacion";					$Valores[1]=$obVenta->normalizar($_REQUEST['TxtNIT']);
            $Columnas[2]="DV";                                                  $Valores[2]=$DV;
            $Columnas[3]="Primer_Apellido";					$Valores[3]=$obVenta->normalizar($_REQUEST['TxtPA']);
            $Columnas[4]="Segundo_Apellido";					$Valores[4]=$obVenta->normalizar($_REQUEST['TxtSA']);
            $Columnas[5]="Primer_Nombre";					$Valores[5]=$obVenta->normalizar($_REQUEST['TxtPN']);
            $Columnas[6]="Otros_Nombres";					$Valores[6]=$obVenta->normalizar($_REQUEST['TxtON']);
            $Columnas[7]="RazonSocial";						$Valores[7]=$obVenta->normalizar($_REQUEST['TxtRazonSocial']);
            $Columnas[8]="Direccion";						$Valores[8]=$obVenta->normalizar($_REQUEST['TxtDireccion']);
            $Columnas[9]="Cod_Dpto";						$Valores[9]=$obVenta->normalizar($DatosMunicipios["Cod_Dpto"]);
            $Columnas[10]="Cod_Mcipio";						$Valores[10]=$obVenta->normalizar($DatosMunicipios["Cod_mcipio"]);
            $Columnas[11]="Pais_Domicilio";					$Valores[11]=169;
            $Columnas[12]="Telefono";			    			$Valores[12]=$obVenta->normalizar($_REQUEST['TxtTelefono']);
            $Columnas[13]="Ciudad";			    			$Valores[13]=$obVenta->normalizar($DatosMunicipios["Ciudad"]);
            $Columnas[14]="Email";			    			$Valores[14]=$obVenta->normalizar($_REQUEST['TxtEmail']);

            $obVenta->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
            $obVenta->InsertarRegistro("clientes",$NumRegistros,$Columnas,$Valores);
            print("<script language='JavaScript'>alert('Se ha creado el Proveedor $_REQUEST[TxtRazonSocial]')</script>");

    }else{

            print("<script language='JavaScript'>alert('El cliente con Identificacion: $NIT, ya existe y no se puede crear nuevamente')</script>");
    }	
		
}

//Agrega un item a la compra

if(isset($_REQUEST["BtnAgregarItem"])){
    $idCompra=$obCompra->normalizar($_REQUEST["idCompra"]);
    $idProducto=$obCompra->normalizar($_REQUEST["TxtidProducto"]);
    $Cantidad=$obCompra->normalizar($_REQUEST["TxtCantidad"]);
    $TipoIVA=$obCompra->normalizar($_REQUEST["TipoIVA"]);
    $IVAIncluido=$obCompra->normalizar($_REQUEST["IVAIncluido"]);
    $CostoUnitario=$obCompra->normalizar($_REQUEST["TxtCosto"]);
    switch ($_REQUEST["TipoItem"]){
        case 1:
            $obCompra->AgregueProductoCompra($idCompra,$idProducto,$Cantidad,$CostoUnitario,$TipoIVA,$IVAIncluido,"");
        break;
        case 2:
            $obCompra->AgregueInsumoCompra($idCompra,$idProducto,$Cantidad,$CostoUnitario,$TipoIVA,$IVAIncluido,"");
        break;
    }
}

//Eliminar un item a la compra

if(isset($_REQUEST["del"])){
    $idItem=$obCompra->normalizar($_REQUEST["del"]);
    $idCompra=$_REQUEST["TxtIdPre"];
    $Tabla=$_REQUEST["TxtTabla"];
    if($Tabla=="factura_compra_items"){
        $DatosItem=$obCompra->DevuelveValores("factura_compra_items", "ID", $idItem);
        $obCompra->BorraReg("factura_compra_items", "ID", $idItem);
        $sql="DELETE FROM factura_compra_items_devoluciones WHERE idProducto='$DatosItem[idProducto]' AND idFacturaCompra='$DatosItem[idFacturaCompra]'";
        $obCompra->Query($sql);   
    }
    if($Tabla=="factura_compra_insumos"){
        $obCompra->BorraReg("factura_compra_insumos", "ID", $idItem);
    }
    
    header("location:$myPage?idCompra=$idCompra");
}


//Agrega una retencion en la fuente a la compra

if(isset($_REQUEST["BtnAgregueReteFuente"])){
    $idCompra=$obCompra->normalizar($_REQUEST["idCompra"]);
    $Cuenta=$obCompra->normalizar($_REQUEST["CmbCuentaReteFuente"]);
    $Porcentaje=$obCompra->normalizar($_REQUEST["TxtPorReteFuente"]);
    $Valor=$obCompra->normalizar($_REQUEST["TxtReteFuenteProductos"]);
    $TotalCompra=$obCompra->SumeColumna("factura_compra_items", "TotalCompra", "idFacturaCompra", $idCompra);
    if($TotalCompra>0 and $TotalCompra>$Valor){
        $obCompra->AgregueRetencionCompra($idCompra, $Cuenta, $Valor, $Porcentaje, "");
    }else{
       $css->CrearNotificacionRoja("No se pueden agregar retenciones sin valor o Mayores a la base", 16);
    }
}

//Agrega reteica a la compra

if(isset($_REQUEST["BtnAgregueReteICA"])){
    $idCompra=$obCompra->normalizar($_REQUEST["idCompra"]);
    $Cuenta=$obCompra->normalizar($_REQUEST["CmbCuentaReteICA"]);
    $Porcentaje=$obCompra->normalizar($_REQUEST["TxtPorReteICA"]);
    $Valor=$obCompra->normalizar($_REQUEST["TxtReteICA"]);
    $TotalCompra=$obCompra->SumeColumna("factura_compra_items", "TotalCompra", "idFacturaCompra", $idCompra);
    if($TotalCompra>0 and $TotalCompra>$Valor){
        $obCompra->AgregueRetencionCompra($idCompra, $Cuenta, $Valor, $Porcentaje, "");
    }else{
       $css->CrearNotificacionRoja("No se pueden agregar retenciones sin valor o Mayores a la base", 16);
    }
}

//Agrega reteiva a la compra

if(isset($_REQUEST["BtnAgregueReteIVA"])){
    $idCompra=$obCompra->normalizar($_REQUEST["idCompra"]);
    $Cuenta=$obCompra->normalizar($_REQUEST["CmbCuentaReteIVA"]);
    $Porcentaje=$obCompra->normalizar($_REQUEST["TxtPorReteIVA"]);
    $Valor=$obCompra->normalizar($_REQUEST["TxtReteIVA"]);
    $TotalCompra=$obCompra->SumeColumna("factura_compra_items", "ImpuestoCompra", "idFacturaCompra", $idCompra);
    if($TotalCompra>0 and $TotalCompra>$Valor){
        $obCompra->AgregueRetencionCompra($idCompra, $Cuenta, $Valor, $Porcentaje, "");
    }else{
       $css->CrearNotificacionRoja("No se pueden agregar retenciones sin valor o Mayores a la base", 16);
    }
}

//Agrega una retencion en la fuente a servicios

if(isset($_REQUEST["BtnAgregueReteFuenteServicios"])){
    $idCompra=$obCompra->normalizar($_REQUEST["idCompra"]);
    $Cuenta=$obCompra->normalizar($_REQUEST["CmbCuentaReteFuenteServicios"]);
    $Porcentaje=$obCompra->normalizar($_REQUEST["TxtPorReteFuenteServicios"]);
    $Valor=$obCompra->normalizar($_REQUEST["TxtReteFuenteServicios"]);
    $TotalCompra=$obCompra->SumeColumna("factura_compra_servicios", "Total_Servicio", "idFacturaCompra", $idCompra);
    if($TotalCompra>0 and $TotalCompra>$Valor){
        $obCompra->AgregueRetencionCompra($idCompra, $Cuenta, $Valor, $Porcentaje, "");
    }else{
       $css->CrearNotificacionRoja("No se pueden agregar retenciones sin valor o Mayores a la base", 16);
    }
}

//Agrega reteica a la compra

if(isset($_REQUEST["BtnAgregueReteICAServicios"])){
    $idCompra=$obCompra->normalizar($_REQUEST["idCompra"]);
    $Cuenta=$obCompra->normalizar($_REQUEST["CmbCuentaReteICAServicios"]);
    $Porcentaje=$obCompra->normalizar($_REQUEST["TxtPorReteICAServicios"]);
    $Valor=$obCompra->normalizar($_REQUEST["TxtReteICAServicios"]);
    $TotalCompra=$obCompra->SumeColumna("factura_compra_servicios", "Total_Servicio", "idFacturaCompra", $idCompra);
    if($TotalCompra>0 and $TotalCompra>$Valor){
        $obCompra->AgregueRetencionCompra($idCompra, $Cuenta, $Valor, $Porcentaje, "");
    }else{
       $css->CrearNotificacionRoja("No se pueden agregar retenciones sin valor o Mayores a la base", 16);
    }
}

//Agrega reteiva a la compra

if(isset($_REQUEST["BtnAgregueReteIVAServicios"])){
    $idCompra=$obCompra->normalizar($_REQUEST["idCompra"]);
    $Cuenta=$obCompra->normalizar($_REQUEST["CmbCuentaReteIVAServicios"]);
    $Porcentaje=$obCompra->normalizar($_REQUEST["TxtPorReteIVAServicios"]);
    $Valor=$obCompra->normalizar($_REQUEST["TxtReteIVAServicios"]);
    $TotalCompra=$obCompra->SumeColumna("factura_compra_servicios", "Impuesto_Servicio", "idFacturaCompra", $idCompra);
    if($TotalCompra>0 and $TotalCompra>$Valor){
        $obCompra->AgregueRetencionCompra($idCompra, $Cuenta, $Valor, $Porcentaje, "");
    }else{
       $css->CrearNotificacionRoja("No se pueden agregar retenciones sin valor o Mayores a la base", 16);
    }
}

//Eliminar una retencion

if(isset($_REQUEST["DelRetencion"])){
    $idItem=$obCompra->normalizar($_REQUEST["DelRetencion"]);
    $idCompra=$_REQUEST["idCompra"];
    $obCompra->BorraReg("factura_compra_retenciones", "ID", $idItem);
    header("location:$myPage?idCompra=$idCompra");
}
//Guardar Compra

if(isset($_REQUEST["BtnGuardarCompra"])){
    
    $idCompra=$obCompra->normalizar($_REQUEST["idCompra"]);
    $TipoPago=$obCompra->normalizar($_REQUEST["CmbTipoPago"]);
    $CuentaOrigen=$obCompra->normalizar($_REQUEST["CmbCuentaOrigen"]);
    $CuentaPUCCXP=$obCompra->normalizar($_REQUEST["CmbCuentaPUCCXP"]);
    $FechaProgramada=$obCompra->normalizar($_REQUEST["TxtFechaProgramada"]);
    $obCompra->GuardarFacturaCompra($idCompra, $TipoPago, $CuentaOrigen,$CuentaPUCCXP, $FechaProgramada,"");
    $idTraslado="";
    if($_REQUEST["CmbTraslado"]>0){
        $idSede=$obCompra->normalizar($_REQUEST["CmbTraslado"]);
        $idTraslado=$obCompra->CrearTrasladoDesdeCompra($idCompra,$idSede, "");
    }
    
    header("location:$myPage?idCompraCreada=$idCompra&idTrasladoCreado=$idTraslado");
}

//Devolver un item 

if(isset($_REQUEST["BtnDevolverItem"])){
    $idCompra=$obCompra->normalizar($_REQUEST["idCompra"]);
    $idProducto=$obCompra->normalizar($_REQUEST["idProducto"]);
    $Cantidad=$obCompra->normalizar($_REQUEST["TxtCantidadDev"]);
    $idFacturaItems=$obCompra->normalizar($_REQUEST["idFacturaItems"]);
    $obCompra->DevolverProductoCompra($idCompra,$idProducto,$Cantidad,$idFacturaItems,"");          
    header("location:$myPage?idCompra=$idCompra");
}

//Agregar un Servicio

if(isset($_REQUEST["BtnAgregarServicio"])){
    $idCompra=$obCompra->normalizar($_REQUEST["idCompra"]);
    $CuentaPUC=$obCompra->normalizar($_REQUEST["CmbCuentaServicio"]);
    $Concepto=$obCompra->normalizar($_REQUEST["TxtConceptoServicio"]);
    $Valor=$obCompra->normalizar($_REQUEST["TxtValor"]);
    $TipoIVA=$obCompra->normalizar($_REQUEST["CmbTipoIva"]);
    $obCompra->AgregueServicioCompra($idCompra,$CuentaPUC,$Concepto,$Valor,$TipoIVA,"");
    header("location:$myPage?idCompra=$idCompra");
}

//Eliminar un servicio

if(isset($_REQUEST["DelServicio"])){
    $idItem=$obCompra->normalizar($_REQUEST["DelServicio"]);
    $idCompra=$_REQUEST["idCompra"];
    $obCompra->BorraReg("factura_compra_servicios", "ID", $idItem);
    header("location:$myPage?idCompra=$idCompra");
}

//Eliminar un producto devuelto

if(isset($_REQUEST["DelProductoDevuelto"])){
    $idItem=$obCompra->normalizar($_REQUEST["DelProductoDevuelto"]);
    $idCompra=$_REQUEST["idCompra"];
    $obCompra->BorraReg("factura_compra_items_devoluciones", "ID", $idItem);
    header("location:$myPage?idCompra=$idCompra");
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