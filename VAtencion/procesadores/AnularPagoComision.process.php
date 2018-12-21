<?php

/* 
 * Este archivo procesa la anulacion de un abono a un titulo
 */

if(!empty($_REQUEST["BtnAnular"])){
$obVenta=new ProcesoVenta($idUser);        
$idPago=$obVenta->normalizar($_REQUEST["idPago"]);
$fecha=$obVenta->normalizar($_REQUEST["TxtFechaAnulacion"]);
$ConceptoAnulacion=$obVenta->normalizar($_REQUEST["TxtConceptoAnulacion"]);

$DatosPago=$obVenta->DevuelveValores("titulos_comisiones", "ID", $idPago);
$DatosVenta=$obVenta->DevuelveValores("titulos_ventas", "ID", $DatosPago["idVenta"]);
$SaldoComision=$DatosVenta["SaldoComision"]+$DatosPago["Monto"];
$TotalPagosComision=$DatosVenta["ComisionAPagar"]-$SaldoComision;
$ListaTitulos="titulos_listados_promocion_".$DatosVenta["Promocion"];
$Concepto="Anulacion de Pago $idPago por valor de  por: $DatosPago[Monto] por concepto: ".$ConceptoAnulacion;
$obVenta->AnularMovimientoLibroDiario("CompEgreso",$DatosPago["idEgreso"],"");
$obVenta->ActualizaRegistro("titulos_ventas", "SaldoComision", $SaldoComision, "ID", $DatosPago["idVenta"]);
$obVenta->ActualizaRegistro($ListaTitulos, "TotalPagoComisiones", $TotalPagosComision, "Mayor1", $DatosVenta["Mayor1"]);
$obVenta->ActualizaRegistro("titulos_comisiones", "Monto", 0, "ID", $idPago);
$obVenta->ActualizaRegistro("titulos_comisiones", "Observaciones", $Concepto, "ID", $idPago);
header("location:anular_pago_comision.php?TxtidComprobante=$idPago");
        
}
?>