<?php
$obVenta=new ProcesoVenta($idUser); 
/* 
 * Este archivo procesa la anulacion de un abono a un titulo
 */

if(isset($_REQUEST["BtnCortarPV"])){
           
    $idDepartamento=$obVenta->normalizar($_REQUEST["idDepartamento"]);
    $Sub1=$obVenta->normalizar($_REQUEST["Sub1"]);
    $Sub2=$obVenta->normalizar($_REQUEST["Sub2"]);
    $Sub3=$obVenta->normalizar($_REQUEST["Sub3"]);
    $Sub4=$obVenta->normalizar($_REQUEST["Sub4"]);
    $Sub5=$obVenta->normalizar($_REQUEST["Sub5"]);
    if($idDepartamento>0){
        $obVenta->CortarProductosVentaInventarioTemporal($idDepartamento,$Sub1,$Sub2,$Sub3,$Sub4,$Sub5,"");
    }
    header("location:inventario_preparacion.php");
        
}
//Cortar Kardex
if(isset($_REQUEST["BtnCortarKardex"])){
    
    $condicion="";
    $BorrarOrigen=1;
    $BorrarDestino=0;
    $obVenta->CopiarTabla("kardexmercancias","kardexmercancias_temporal",$condicion,$BorrarOrigen,$BorrarDestino,$condicion,"");
    $Datos=$obVenta->ConsultarTabla("bodega", "");
        
    while($DatosBodegas=$obVenta->FetchArray($Datos)){
        $tabBodegas="productosventa_bodega_$DatosBodegas[0]";
        $obVenta->VaciarTabla($tabBodegas);
        $tabBodegas="prod_codbarras_bodega_$DatosBodegas[0]";
        $obVenta->VaciarTabla($tabBodegas);
    }
    $obVenta->VaciarTabla("inventarios_diferencias");
    header("location:inventario_preparacion.php");
        
}

//Cortar productos venta 
if(isset($_REQUEST["BtnCortarTodosProductos"])){
    
    $condicion="";
    $BorrarOrigen=1;
    $BorrarDestino=0;
    $obVenta->CopiarTabla("productosventa","inventarios_temporal",$condicion,$BorrarOrigen,$BorrarDestino,$condicion,"");
   
    header("location:inventario_preparacion.php");
        
}

//inicializar productos venta 
if(isset($_REQUEST["BtnInicializarProductosVenta"])){
    
    $condicion="";
    $BorrarOrigen=0;
    $BorrarDestino=0;
    $obVenta->CopiarTabla("productosventa","inventarios_temporal",$condicion,$BorrarOrigen,$BorrarDestino,$condicion,"");
    $obVenta->InicializarProductosVenta();
    header("location:inventario_preparacion.php");
        
}

//Cortar productos venta 
if(isset($_REQUEST["BtnRestarurar"])){
    
    $condicion="";
    $BorrarOrigen=0;
    $BorrarDestino=1;
    $obVenta->CopiarTabla("inventarios_temporal","productosventa",$condicion,$BorrarOrigen,$BorrarDestino,$condicion,"");
    $obVenta->CopiarTabla("kardexmercancias_temporal","kardexmercancias",$condicion,$BorrarOrigen,$BorrarDestino,$condicion,"");
    header("location:inventario_preparacion.php");
        
}
?>