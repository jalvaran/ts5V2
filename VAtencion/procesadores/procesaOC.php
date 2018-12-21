<?php

/* 
 * Este archivo se encarga de agregar items a las ordenes de trabajo
 * 
 */
include_once("../modelo/php_tablas.php");
///////////////////////////////
////////Si se solicita borrar algo
////
////

if(!empty($_REQUEST['del'])){
    $id=$_REQUEST['del'];
    $Tabla=$_REQUEST['TxtTabla'];
    $IdTabla=$_REQUEST['TxtIdTabla'];
    $IdPre=$_REQUEST['TxtIdPre'];
    $obVenta->Query("DELETE FROM $Tabla WHERE $IdTabla='$id'");
    header("location:AgregaItemsOC.php?idOT=$IdPre");
}


/*
 * 
 * Si llega la peticion de crear la factura
 * 
 */

if(!empty($_REQUEST["BtnAgregarItemOT"])){
        $obTabla= NEW Tabla($db);
        $idOT=$_REQUEST['TxtIdOT'];
        $idProducto=$_REQUEST['CmbProducto'];
        $TablaOrigen="productosventa";
        $idIVA=$_REQUEST['CmbIVA'];
        $Cantidad=$_REQUEST["TxtCantidad"];
        $ValorUnitario=$_REQUEST["TxtValorUnitario"];
        $DatosProducto=$obVenta->DevuelveValores($TablaOrigen,"idProductosVenta",$idProducto);
        $DatosIVA=$obVenta->DevuelveValores("porcentajes_iva","ID",$idIVA);
        $Subtotal=$ValorUnitario*$Cantidad;
        $IVA=  round($Subtotal*$DatosIVA["Valor"]);
        $Total=$Subtotal+$IVA;
       
        ////////////////Inserto datos de ot items
       /////
       ////
       $ID=$obTabla->ObtengaID();
       $tab="ordenesdecompra_items";
       $NumRegistros=10; 

       $Columnas[0]="ID";		    $Valores[0]=$ID;
       $Columnas[1]="NumOrden";             $Valores[1]=$idOT;
       $Columnas[2]="Descripcion";          $Valores[2]=$DatosProducto["Nombre"];
       $Columnas[3]="Referencia";           $Valores[3]=$DatosProducto["Referencia"];
       $Columnas[4]="Cantidad";             $Valores[4]=$Cantidad;
       $Columnas[5]="ValorUnitario";        $Valores[5]=$ValorUnitario;
       $Columnas[6]="IVA";                  $Valores[6]=$IVA;
       $Columnas[7]="Total";                $Valores[7]=$Total;
       $Columnas[8]="TablaOrigen";          $Valores[8]=$TablaOrigen;
       $Columnas[9]="Subtotal";             $Valores[9]=$Subtotal;
       
       $obVenta->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
       header("location:AgregaItemsOC.php?idOT=$idOT");
        
    }
?>