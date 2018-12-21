<?php

/* 
 * Este archivo procesa la anulacion de un documento contable
 */

if(!empty($_REQUEST["BtnAnularDocumento"])){
    $obVenta=new ProcesoVenta($idUser);        
    $idComprobante=$obVenta->normalizar($_REQUEST["idDocumento"]);
    $NombreDocumento="DOC_EQUI_NOMINA";
    $ConsecutivoDocumento=$idComprobante;
    $fecha=$obVenta->normalizar($_REQUEST["TxtFechaAnulacion"]);
    $ConceptoAnulacion=$obVenta->normalizar($_REQUEST["TxtConceptoAnulacion"]);
    $obVenta->AnularMovimientoLibroDiario($NombreDocumento, $idComprobante, "");
    $obVenta->ActualizaRegistro("nomina_documentos_equivalentes", "Estado", "ANULADO", "ID", $idComprobante);
    $obVenta->ActualizaRegistro("nomina_servicios_turnos", "Estado", "", "idDocumentoEquivalente", $idComprobante);
    $obVenta->ActualizaRegistro("nomina_servicios_turnos", "idDocumentoEquivalente", "0", "idDocumentoEquivalente", $idComprobante);
    //$idAnulacion=$obVenta->RegistraAnulacionNotaContable($fecha, $ConceptoAnulacion, $idComprobante, "");
    header("location:$myPage?TxtidComprobante=1");
        
}
?>