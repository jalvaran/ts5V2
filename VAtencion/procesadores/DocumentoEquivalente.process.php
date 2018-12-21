<?php

/* 
 * Este archivo procesa la anulacion de un abono a un titulo
 */
//Si se recibe la opcion de crear
    if(isset($_REQUEST["BtnCrear"])){
        $Fecha=$obDocumento->normalizar($_REQUEST["TxtFecha"]);
        $Tercero=$obDocumento->normalizar($_REQUEST["CmbProveedor"]);
        $idDocumento=$obDocumento->CrearDocumentoEquivalente($Fecha, $Tercero, "");
        $css->CrearNotificacionAzul("Se ha creado exitosamente el documento No. $idDocumento", 16);
    }
    
    //Si se recibe la opcion de agregar item
    if(isset($_REQUEST["BtnAgregar"])){
        $Cantidad=$obDocumento->normalizar($_REQUEST["TxtCantidad"]);
        $Descripcion=$obDocumento->normalizar($_REQUEST["TxtDescripcion"]);
        $ValorUnitario=$obDocumento->normalizar($_REQUEST["TxtValorUnitario"]);
        $idDocumento=$obDocumento->normalizar($_REQUEST["CmbDocumento"]);
        $obDocumento->AgregarItemADocumento($idDocumento,$Descripcion,$Cantidad,$ValorUnitario,"");
        $css->CrearNotificacionAzul("Se ha agredo exitosamente $Cantidad unidades de $Descripcion al documento $idDocumento", 16);
    }
    //Si se recibe la opcion de guardar
    if(isset($_REQUEST["BtnGuardar"])){
        
        $idDocumento=$obDocumento->normalizar($_REQUEST["CmbDocumento"]);
        $obDocumento->GuardarDocumento($idDocumento,"");
        $css->CrearNotificacionVerde("Se ha Guardado exitosamente el documento <a href='ProcesadoresJS/GeneradorExcel.php?idDocumento=3&idDocumentoEquivalente=$idDocumento'> Abrir</a>", 16);
        $idDocumento=0;
    }
    
    //Si se recibe la opcion de eliminar item
    if(isset($_REQUEST["del"])){
        $idDel=$obDocumento->normalizar($_REQUEST["del"]);
        $idDocumento=$obDocumento->normalizar($_REQUEST["TxtIdPre"]);
        $obDocumento->BorraReg("documento_equivalente_items", "ID", $idDel);
        $css->CrearNotificacionRoja("Se ha borrado exitosamente el registro  $idDel", 16);
    
    }
?>