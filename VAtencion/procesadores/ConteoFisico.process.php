<?php
$css= new CssIni("");
$obVenta=new ProcesoVenta($idUser);  
/* 
 * Este archivo procesa la anulacion de un abono a un titulo
 */

if(!empty($_REQUEST["TxtCodigoBarras"])){
          
    $Codigo=$obVenta->normalizar($_REQUEST["TxtCodigoBarras"]);
    $Cantidad=$obVenta->normalizar($_REQUEST["TxtCantidad"]);
    $Respuesta=$obVenta->RegistrarConteoFisicoInventario($Codigo,$Cantidad,"");
    if(isset($Respuesta["Error"])){
        $css->CrearNotificacionRoja($Respuesta["Error"], 18);
    }
    if(isset($Respuesta["Creado"])){
        $css->CrearNotificacionAzul($Respuesta["Creado"], 18);
    }
    if(isset($Respuesta["Actualizado"])){
        $css->CrearNotificacionVerde($Respuesta["Actualizado"], 18);
    }
}
?>