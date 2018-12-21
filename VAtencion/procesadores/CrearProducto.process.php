<?php

/* 
 * Este archivo procesa la anulacion de un abono a un titulo
 */

if(!empty($_REQUEST["BtnCrearPV"])){
    $obVenta=new ProcesoVenta($idUser); 
    $sql="UPDATE `productosventa` SET `Referencia`=CONCAT('REF',`idProductosVenta`) WHERE `Referencia`='';";
    $obVenta->Query($sql);
    $idDepartamento=$obVenta->normalizar($_REQUEST["idDepartamento"]);
    $Sub1=$obVenta->normalizar($_REQUEST["Sub1"]);
    $Sub2=$obVenta->normalizar($_REQUEST["Sub2"]);
    $Sub3=$obVenta->normalizar($_REQUEST["Sub3"]);
    $Sub4=$obVenta->normalizar($_REQUEST["Sub4"]);
    $Sub6=$obVenta->normalizar($_REQUEST["Sub6"]);
    $VectorProducto["Sub6"]=$Sub6;
    $Nombre=$obVenta->normalizar($_REQUEST["TxtNombre"]);
    $Existencias=$obVenta->normalizar($_REQUEST["TxtExistencias"]);
    $PrecioVenta=$obVenta->normalizar($_REQUEST["TxtPrecioVenta"]);
    $CostoUnitario=$obVenta->normalizar($_REQUEST["TxtCostoUnitario"]);
    $IVA=$obVenta->normalizar($_REQUEST["CmbIVA"]);
    $CuentaPUC=$obVenta->normalizar($_REQUEST["TxtCuentaPUC"]);
    $PrecioMayor=$obVenta->normalizar($_REQUEST["TxtPrecioMayorista"]);
    $Referencia="";
    $CodigoBarras="";
    $Sub5="";
   
    if(isset($_REQUEST["TxtReferencia"])){
        $Referencia=$obVenta->normalizar($_REQUEST["TxtReferencia"]);
        $Referencia=$obVenta->QuitarAcentos($Referencia);
    }
    if(isset($_REQUEST["TxtCodigoBarras"])){
        $CodigoBarras=$obVenta->normalizar($_REQUEST["TxtCodigoBarras"]);
        
    }
    
    if (isset($_POST["Sub5"])){
        $RefAutomatica=0;
        foreach ( $_POST["Sub5"] as $Sub5 ) {
            $DatosSub5=$obVenta->DevuelveValores("prod_sub5", "idSub5", $Sub5);
            if($Referencia=="" or $RefAutomatica==1){
               $idMax= $obVenta->ObtenerMAX("productosventa", "idProductosVenta", 1, "");
               $Referencia=$idMax+1;
               $RefAutomatica=1;
            }
            $ReferenciaTalla=$Referencia."-".$DatosSub5["NombreSub5"];
            $NombreTalla=$Nombre." ".$DatosSub5["NombreSub5"];
            $idProducto=$obVenta->CrearProductoVenta($NombreTalla,"",$ReferenciaTalla,$PrecioVenta,$PrecioMayor,$Existencias,$CostoUnitario,$IVA,$idDepartamento,$Sub1,$Sub2,$Sub3,$Sub4,$Sub5,$CuentaPUC,$VectorProducto);
            $consulta=$obVenta->ConsultarTabla("productos_lista_precios", "");
            while($DatosListas=$obVenta->FetchArray($consulta)){
                $Lista="TxtLista".$DatosListas["ID"];
                if (isset($_POST[$Lista])){
                    $PrecioLista=$obVenta->normalizar($_POST[$Lista]);
                    if($PrecioLista>0){
                        $obVenta->AgregaPrecioProducto($idProducto, $PrecioLista, "productosventa", $DatosListas["ID"], $idUser, "");
                    }
                    
                }
                    
            }
        }
    }else{
        $idProducto=$obVenta->CrearProductoVenta($Nombre,$CodigoBarras,$Referencia,$PrecioVenta,$PrecioMayor,$Existencias,$CostoUnitario,$IVA,$idDepartamento,$Sub1,$Sub2,$Sub3,$Sub4,$Sub5,$CuentaPUC,$VectorProducto);
        
        $consulta=$obVenta->ConsultarTabla("productos_lista_precios", "");
            while($DatosListas=$obVenta->FetchArray($consulta)){
                $Lista="TxtLista".$DatosListas["ID"];
                if (isset($_POST[$Lista])){
                    $PrecioLista=$obVenta->normalizar($_POST[$Lista]);
                    if($PrecioLista>0){
                        $obVenta->AgregaPrecioProducto($idProducto, $PrecioLista, "productosventa", $DatosListas["ID"], $idUser, "");
                    }
                    
                }
                    
            }
        
    }
        header("location:productosventa.php?idProducto=$idProducto");
    
    
    
    
}
?>