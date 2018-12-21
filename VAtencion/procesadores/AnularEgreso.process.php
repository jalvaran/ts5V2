<?php

/* 
 * Este archivo procesa la anulacion de un abono a un titulo
 */

if(!empty($_REQUEST["BtnAnular"])){
$obVenta=new ProcesoVenta($idUser);        
$idComprobante=$obVenta->normalizar($_REQUEST["idComprobante"]);
$fecha=$obVenta->normalizar($_REQUEST["TxtFechaAnulacion"]);
$ConceptoAnulacion=$obVenta->normalizar($_REQUEST["TxtConceptoAnulacion"]);
$idAnulacion=$obVenta->RegistraAnulacionComprobanteEgreso($fecha, $ConceptoAnulacion, $idComprobante, "");
header("location:AnularEgreso.php?TxtidComprobante=$idAnulacion");
        
}
?>