<?php

/* 
 * Este archivo procesa la anulacion de un abono a un titulo
 */

if(!empty($_REQUEST["BtnAnular"])){
$obVenta=new ProcesoVenta($idUser);        
$idAbono=$obVenta->normalizar($_REQUEST["idAbono"]);
$fecha=$obVenta->normalizar($_REQUEST["TxtFechaAnulacion"]);
$ConceptoAnulacion=$obVenta->normalizar($_REQUEST["TxtConceptoAnulacion"]);

$DatosAbono=$obVenta->DevuelveValores("titulos_abonos", "ID",$idAbono);
$idComprobanteIngreso=$DatosAbono["idComprobanteIngreso"];

$Concepto="Anulacion de Abono de titulo $idAbono por: ".$ConceptoAnulacion;
$idAnulacion=$obVenta->RegistraAnulacionComprobanteIngreso($fecha, $Concepto, $idComprobanteIngreso, $DatosAbono["Monto"]);
//Se actualiza para no anular la misma
$obVenta->ActualizaRegistro("titulos_abonos", "Estado", "ANULADO", "ID", $idAbono);
$idVenta=$DatosAbono["idVenta"];
$DatosCuentasXCobrar=$obVenta->DevuelveValores("titulos_cuentasxcobrar", "idDocumento", $DatosAbono["idVenta"]);
$NewTotalAbonos=$DatosCuentasXCobrar["TotalAbonos"]-$DatosAbono["Monto"];
$NewSaldo=$DatosCuentasXCobrar["Saldo"]+$DatosAbono["Monto"];
$sql="UPDATE titulos_cuentasxcobrar SET TotalAbonos='$NewTotalAbonos', Saldo='$NewSaldo' WHERE idDocumento='$idVenta'";
$obVenta->Query($sql);
$TablaTitulos="titulos_listados_promocion_".$DatosCuentasXCobrar["Promocion"];
$Mayor=$DatosCuentasXCobrar["Mayor"];
$sql="UPDATE $TablaTitulos SET TotalAbonos='$NewTotalAbonos', Saldo='$NewSaldo' WHERE Mayor1='$Mayor'";
$obVenta->Query($sql);
header("location:AnularAbonoTitulo.php?TxtidComprobante=$idAnulacion");
        
}
?>