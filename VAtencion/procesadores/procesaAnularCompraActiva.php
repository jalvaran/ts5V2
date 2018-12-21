<?php

/* 
 * Este archivo procesa la anulacion de un abono a un titulo
 */

if(!empty($_REQUEST["BtnAnular"])){
$obVenta=new ProcesoVenta($idUser);        
$idCompra=$obVenta->normalizar($_REQUEST["idCompra"]);
$fecha=$obVenta->normalizar($_REQUEST["TxtFechaAnulacion"]);
$ConceptoAnulacion=$obVenta->normalizar($_REQUEST["TxtConceptoAnulacion"]);

$DatosCompra=$obVenta->DevuelveValores("compras_activas", "idComprasActivas",$idCompra);

$Concepto="Anulacion de Compra $idCompra por: ".$ConceptoAnulacion;
$obVenta->AnularMovimientoLibroDiario($DatosCompra["DocumentoGenerado"],$DatosCompra["NumComprobante"],"");

$obVenta->BorraReg("compras_activas", "idComprasActivas", $idCompra);
$idDocumentoCruce=$DatosCompra["NumComprobante"];
$sql="DELETE FROM cuentasxpagar WHERE Origen='notascontables' AND DocumentoCruce='$idDocumentoCruce'";
$obVenta->Query($sql);
header("location:AnularCompraActiva.php?TxtidComprobante=1");
        
}
?>