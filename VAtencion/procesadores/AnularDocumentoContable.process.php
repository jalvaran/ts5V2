<?php

/* 
 * Este archivo procesa la anulacion de un documento contable
 */

if(!empty($_REQUEST["BtnAnular"])){
    $obVenta=new ProcesoVenta($idUser);        
    $idComprobante=$obVenta->normalizar($_REQUEST["idComprobante"]);
    $NombreDocumento=$obVenta->normalizar($_REQUEST["NombreDocumento"]);
    $ConsecutivoDocumento=$obVenta->normalizar($_REQUEST["ConsecutivoDocumento"]);
    $fecha=$obVenta->normalizar($_REQUEST["TxtFechaAnulacion"]);
    $ConceptoAnulacion=$obVenta->normalizar($_REQUEST["TxtConceptoAnulacion"]);
    $obVenta->AnularMovimientoLibroDiario($NombreDocumento, $ConsecutivoDocumento, "");
    //$idAnulacion=$obVenta->RegistraAnulacionNotaContable($fecha, $ConceptoAnulacion, $idComprobante, "");
    header("location:AnularNota.php?TxtidComprobante=1");
        
}
?>