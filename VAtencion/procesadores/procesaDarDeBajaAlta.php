<?php

/* 
 * Este archivo procesa la anulacion de una factura
 */

if(!empty($_REQUEST["BtnBaja"])){
$obVenta=new ProcesoVenta($idUser);        
$RefProducto=$_REQUEST["CmbProducto"];
$fecha=$_REQUEST["TxtFecha"];
$Observaciones=$_REQUEST["TxtConcepto"];
$Cantidad=$_REQUEST["TxtCantidad"];
$TipoMovimiento=$_REQUEST["CmbTipoMovimiento"];
$VectorBA["f"]="";
$idBaja=$obVenta->DarDeBajaAltaProducto($TipoMovimiento,$fecha, $Observaciones,$RefProducto,$Cantidad,$VectorBA);

header("location:$myPage?TxtidComprobante=$idBaja");
        
    }
?>