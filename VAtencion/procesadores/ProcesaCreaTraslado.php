<?php 
if(!empty($_REQUEST['del'])){
    $id=$_REQUEST['del'];
    $Tabla=$_REQUEST['TxtTabla'];
    $IdTabla=$_REQUEST['TxtIdTabla'];
    $IdPre= $_REQUEST['TxtIdPre'];
   
    
    $obVenta->Query("DELETE FROM $Tabla WHERE $IdTabla='$id'");
    
    header("location:$MyPage?CmbTrasladoID=$IdPre");
}

if(!empty($_REQUEST["BtnCrearTraslado"])){
    
    $obVenta=new ProcesoVenta($idUser);
    
    $fecha=$_REQUEST["TxtFecha"];
    $hora=$_REQUEST["TxtHora"];
    $Concepto=$_REQUEST["TxtDescripcion"];
    $Destino=$_REQUEST["CmbDestino"];
    $VectorTraslado["idBodega"]=$_REQUEST["CmbBodega"];
    $idComprobante=$obVenta->CrearTraslado($fecha,$hora,$Concepto,$Destino,$VectorTraslado);
        
    //$obVenta->CerrarCon();
    header("location:$myPage");
}

		
if(!empty($_REQUEST["BtnAgregarItem"])){
    
   
    $obVenta=new ProcesoVenta($idUser);
        
    $idComprobante=$_REQUEST["TxtidPre"];
    $Cantidad=$_REQUEST["TxtCantidad"];
    
    $idProducto=$_REQUEST["TxtIdItem"];
    $VectorItem["Fut"]=0;
    $obVenta->AgregarItemTraslado($idComprobante,$idProducto,$Cantidad,$VectorItem);
    
    //header("location:$myPage?idComprobante=$idComprobante");
}

// si se requiere guardar y cerrar
if(!empty($_REQUEST["BtnGuardar"])){
    
    $idComprobante=$_REQUEST["TxtIdComprobante"];
    $obVenta->GuardarTrasladoMercancia($idComprobante);
        
    header("location:$myPage?ImprimeCC=$idComprobante");
    
}
///////////////fin
?>