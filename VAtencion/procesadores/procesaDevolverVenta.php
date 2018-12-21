<?php

/* 
 * Este archivo procesa la anulacion de una factura
 */

if(!empty($_REQUEST["BtnAnular"])){
    $obVenta=new ProcesoVenta($idUser);        
    $idVenta=$obVenta->normalizar($_REQUEST["TxtIdVenta"]);
    $fecha=$obVenta->normalizar($_REQUEST["TxtFechaAnulacion"]);
    $ConceptoAnulacion=$obVenta->normalizar($_REQUEST["TxtConceptoAnulacion"]);
    $hora=date("H:i");
    $Concepto="Anulacion de Venta $idVenta por: ".$ConceptoAnulacion;
    
    $idComprobante=$obVenta->AnularVentaTitulo($fecha, $idVenta, $Concepto, 1, $idUser, "");
    header("location:DevolverVenta.php?TxtidComprobante=$idComprobante");
        
    }
?>