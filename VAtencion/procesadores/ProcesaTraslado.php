<?php 
if(!empty($_REQUEST['del'])){
    $id=$_REQUEST['del'];
    $Tabla=$_REQUEST['TxtTabla'];
    $IdTabla=$_REQUEST['TxtIdTabla'];
    $IdPre= $_REQUEST['TxtIdPre'];
    $DatosItem=$obVenta->DevuelveValores($Tabla, $IdTabla, $id);
    $obVenta->ActualizaRegistro("librodiario", "Estado", "", "idLibroDiario", $DatosItem["idLibroDiario"]);
    $obVenta->Query("DELETE FROM $Tabla WHERE $IdTabla='$id'");
    
    header("location:$MyPage?CmbTrasladoID=$IdPre");
}

// si se requiere guardar y cerrar
if(!empty($_REQUEST["BtnGuardarTraslado"])){
    
    $idTraslado=$_REQUEST["idTraslado"];
    $VectorItem["F"]="";
    $obVenta->GuardarTrasladoDescargado($idTraslado,$VectorItem);
        
    //header("location:$myPage?ImprimeCC=$idComprobante");
    
}
///////////////fin
?>