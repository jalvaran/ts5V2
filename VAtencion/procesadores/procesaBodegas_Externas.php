<?php

/* 
 * este archivo recibe las peticiones o envios de impresion 
 */

if(isset($_REQUEST["BtnImprimirBarCode"])){
    $obVenta = new ProcesoVenta(1);
    $idProducto=$_REQUEST["BtnImprimirBarCode"];
    $idCantidad="TxtCantidadCodigos$idProducto";
    $Cantidad=$_REQUEST[$idCantidad];
    $Tabla=$myTabla;
    $TablaCodigoBarras="prod_codbarras_bodega_$idBodega";
    $sql="SELECT CodigoBarras FROM $TablaCodigoBarras WHERE ProductosVenta_idProductosVenta='$idProducto' LIMIT 1";
    $Consulta =  $obVenta->Query($sql);
    $DatosCodigo=  $obVenta->FetchArray($Consulta);  
    $Codigo=$DatosCodigo["CodigoBarras"];
    $DatosCB["EmpresaPro"]=1;
    $DatosCB["CodigoBarras"]=$Codigo;
    $DatosPuerto=$obVenta->DevuelveValores("config_puertos", "ID", 2);
    if($DatosPuerto["Habilitado"]=="SI"){
        $obVenta->ImprimirCodigoBarras($Tabla,$idProducto,$Cantidad,$DatosPuerto["Puerto"],$DatosCB);
    }
    
}