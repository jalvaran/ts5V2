<?php

/* 
 * Este archivo procesa la anulacion de un abono a un titulo
 */
$obCompra=new Compra($idUser);
if(!empty($_REQUEST["BtnAnular"])){

    $idCompra=$obCompra->normalizar($_REQUEST["idCompra"]);
    $fecha=$obCompra->normalizar($_REQUEST["TxtFechaAnulacion"]);
    $ConceptoAnulacion=$obCompra->normalizar($_REQUEST["TxtConceptoAnulacion"]);

    $idAnulacion=$obCompra->AnularCompra($fecha, $ConceptoAnulacion, $idCompra,$idUser);

    header("location:$myPage?TxtidComprobante=$idAnulacion");
        
}

if(!empty($_REQUEST["BtnAnularNotaDevolucion"])){

    $idNota=$obCompra->normalizar($_REQUEST["idNota"]);
    $fecha=$obCompra->normalizar($_REQUEST["TxtFechaAnulacion"]);
    $ConceptoAnulacion="Se reversa anulacion por: ".$obCompra->normalizar($_REQUEST["TxtConceptoAnulacion"]);

    $idAnulacion=$obCompra->AnularComprobanteAnulacion($fecha, $ConceptoAnulacion, $idNota,$idUser);

    header("location:$myPage?TxtidComprobante=$idAnulacion");
        
}
?>