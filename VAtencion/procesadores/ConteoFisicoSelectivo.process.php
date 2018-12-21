<?php
$css= new CssIni("");

include_once 'clases/ClasesInventarios.class.php';
$obInventario=new Inventarios($idUser);  
/* 
 * Este archivo procesa la anulacion de un abono a un titulo
 */

if(!empty($_REQUEST["TxtCodigoBarras"])){
          
    $Codigo=$obInventario->normalizar($_REQUEST["TxtCodigoBarras"]);
    $Cantidad=$obInventario->normalizar($_REQUEST["TxtCantidad"]);
    $Respuesta=$obInventario->RegistrarConteoFisicoSelectivo($Codigo,$Cantidad,"");
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