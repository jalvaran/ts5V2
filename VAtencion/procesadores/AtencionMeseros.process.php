<?php 
$obVenta=new ProcesoVenta($idUser);
$css =  new CssIni("Atencion");
if(isset($_REQUEST['idDel'])){
    
    $idItem=$obVenta->normalizar($_REQUEST["idDel"]);
    $DatosItemBorrado=$obVenta->DevuelveValores("restaurante_pedidos_items", "ID", $idItem);
    $obVenta->BorraReg("restaurante_pedidos_items", "ID", $idItem);
    $css->CrearNotificacionRoja("Se ha borrado $DatosItemBorrado[NombreProducto] del pedido $DatosItemBorrado[idPedido]", 16);
}
if(isset($_REQUEST['BtnAgregar'])){
        $fecha=date("Y-m-d");
        $hora=date("H:i:s");
        
        $Cantidad=$obVenta->normalizar($_REQUEST["TxtCantidad"]);
        $idMesa=$obVenta->normalizar($_REQUEST["idMesa"]);
        $Observaciones=$obVenta->normalizar($_REQUEST["TxtObservaciones"]);
        $idProducto=$obVenta->normalizar($_REQUEST["idProducto"]);
        //$idDepartamento=$obVenta->normalizar($_REQUEST["idDepartamento"]);
        
        $idPedido=$obVenta->AgregueProductoAPedido($idMesa,$fecha,$hora,$Cantidad,$idProducto,$Observaciones,"");
        $css->CrearNotificacionNaranja("Producto agregado al pedido $idPedido", 16);
}
?>