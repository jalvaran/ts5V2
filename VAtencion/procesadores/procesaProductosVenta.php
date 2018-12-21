<?php

/* 
 * este archivo recibe las peticiones o envios de impresion 
 */

if(isset($_REQUEST["BtnImprimirBarCode"])){
    $obVenta = new ProcesoVenta(1);
    $idProducto=$_REQUEST["BtnImprimirBarCode"];
    $idCantidad="TxtCantidadCodigos$idProducto";
    $Cantidad=$_REQUEST[$idCantidad];
    $Tabla="productosventa";
    $DatosCB["EmpresaPro"]=1;
    $DatosPuerto=$obVenta->DevuelveValores("config_puertos", "ID", 2);
    if($DatosPuerto["Habilitado"]=="SI"){
        $obVenta->ImprimirCodigoBarras($Tabla,$idProducto,$Cantidad,$DatosPuerto["Puerto"],$DatosCB);
    }
    
}