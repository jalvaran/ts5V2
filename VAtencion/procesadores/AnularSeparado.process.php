<?php

/* 
 * Este archivo procesa la anulacion de un abono a un titulo
 */

if(!empty($_REQUEST["BtnAnular"])){
    
    $obVenta=new ProcesoVenta($idUser);        
    $idSeparado=$obVenta->normalizar($_REQUEST["idSeparado"]);
    $fecha=$obVenta->normalizar($_REQUEST["TxtFechaAnulacion"]);
    $ConceptoAnulacion=$obVenta->normalizar($_REQUEST["TxtConceptoAnulacion"]);
    $idAnulacion=$obVenta->AnularSeparado($fecha, $ConceptoAnulacion, $idSeparado, "");
    header("location:AnularSeparado.php?TxtidComprobante=$idAnulacion");
        
}
?>