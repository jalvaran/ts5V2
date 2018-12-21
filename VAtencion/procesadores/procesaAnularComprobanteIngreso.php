<?php

/* 
 * Este archivo procesa la anulacion de un abono a un titulo
 */

if(!empty($_REQUEST["BtnAnular"])){
$obVenta=new ProcesoVenta($idUser);        
$idComprobanteIngreso=$obVenta->normalizar($_REQUEST["idComprobante"]);
$fecha=$obVenta->normalizar($_REQUEST["TxtFechaAnulacion"]);
$ConceptoAnulacion=$obVenta->normalizar($_REQUEST["TxtConceptoAnulacion"]);
$DatosAbono=$obVenta->DevuelveValores("comprobantes_ingreso", "ID", $idComprobante);
$Concepto="Anulacion de Comprobante de Ingreso $idComprobanteIngreso por: ".$ConceptoAnulacion;
$idAnulacion=$obVenta->RegistraAnulacionComprobanteIngreso($fecha, $Concepto, $idComprobanteIngreso, $DatosAbono["Valor"]);
//Se actualiza para no anular la misma
$obVenta->ActualizaRegistro("comprobantes_ingreso", "Estado", "ANULADO", "ID", $idComprobanteIngreso);

header("location:AnularAbonoTitulo.php?TxtidComprobante=$idAnulacion");
        
}
?>