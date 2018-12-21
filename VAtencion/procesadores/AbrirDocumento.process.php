<?php

/* 
 * Este archivo procesa la anulacion de un abono a un titulo
 */

if(!empty($_REQUEST["BtnAbrir"])){
$obVenta=new ProcesoVenta($idUser);        
$Documento=$obVenta->normalizar($_REQUEST["Documento"]);
$idDoc=$obVenta->normalizar($_REQUEST["idDoc"]);
$fecha=$obVenta->normalizar($_REQUEST["TxtFechaApertura"]);
$ConceptoApertura=$obVenta->normalizar($_REQUEST["TxtConceptoApertura"]);
if($Documento=='CC'){
    $obVenta->ActualizaRegistro("comprobantes_pre", "Estado", "", "idComprobanteContabilidad", $idDoc);
    $obVenta->ActualizaRegistro("comprobantes_contabilidad", "Estado", "", "ID", $idDoc);
    $obVenta->RegistreAperturaDocumento($Documento, $idDoc, $ConceptoApertura, "");
    $sql="DELETE FROM `librodiario` WHERE `Tipo_Documento_Intero`='COMPROBANTE CONTABLE' AND `Num_Documento_Interno`='$idDoc'";
    $obVenta->Query($sql);
    header("location:CreaComprobanteCont.php?idComprobante=$idDoc");
}
        
}
?>