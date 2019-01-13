<?php

session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];

include_once("../clases/Compras.class.php");

if( !empty($_REQUEST["Accion"]) ){
    $obCon = new Compras($idUser);
    
    switch ($_REQUEST["Accion"]) {
        
        case 1: //Crear una compra
            $Fecha=$obCon->normalizar($_REQUEST["Fecha"]); 
            $idTercero=$obCon->normalizar($_REQUEST["Tercero"]); 
            $CentroCostos=$obCon->normalizar($_REQUEST["ControCosto"]); 
            $idSucursal=$obCon->normalizar($_REQUEST["Sucursal"]); 
            $TipoCompra=$obCon->normalizar($_REQUEST["TipoCompra"]);
            $Concepto=$obCon->normalizar($_REQUEST["Concepto"]); 
            $NumeroFactura=$obCon->normalizar($_REQUEST["NumFactura"]); 
            $Observaciones="";
            $idCompra=$obCon->CrearCompra($Fecha, $idTercero, $Observaciones, $CentroCostos, $idSucursal, $idUser, $TipoCompra, $NumeroFactura, $Concepto, "");
            print("OK;$idCompra");            
            
        break; 
        
        case 2: //editar datos generales de una factura de compra
            $idCompra=$obCon->normalizar($_REQUEST["idCompraActiva"]); 
            $Fecha=$obCon->normalizar($_REQUEST["Fecha"]); 
            $idTercero=$obCon->normalizar($_REQUEST["Tercero"]); 
            $CentroCostos=$obCon->normalizar($_REQUEST["ControCosto"]); 
            $idSucursal=$obCon->normalizar($_REQUEST["Sucursal"]); 
            $TipoCompra=$obCon->normalizar($_REQUEST["TipoCompra"]);
            $Concepto=$obCon->normalizar($_REQUEST["Concepto"]); 
            $NumeroFactura=$obCon->normalizar($_REQUEST["NumFactura"]); 
            
            $obCon->ActualizaRegistro("factura_compra", "Fecha", $Fecha, "ID", $idCompra,0);
            $obCon->ActualizaRegistro("factura_compra", "Tercero", $idTercero, "ID", $idCompra,0);
            $obCon->ActualizaRegistro("factura_compra", "idCentroCostos", $CentroCostos, "ID", $idCompra,0);
            $obCon->ActualizaRegistro("factura_compra", "idSucursal", $idSucursal, "ID", $idCompra,0);
            $obCon->ActualizaRegistro("factura_compra", "TipoCompra", $TipoCompra, "ID", $idCompra,0);
            $obCon->ActualizaRegistro("factura_compra", "Concepto", $Concepto, "ID", $idCompra,0);
            $obCon->ActualizaRegistro("factura_compra", "NumeroFactura", $NumeroFactura, "ID", $idCompra,0);
            
            $destino="";
            $Atras="";
            $carpeta="";
            if(!empty($_FILES['Soporte']['name'])){
                //echo "<script>alert ('entra foto')</script>";
                $Atras="../";
                $carpeta="soportes/";
                opendir($Atras.$carpeta);
                $Name=$idCompra."_".str_replace(' ','_',$_FILES['Soporte']['name']);
                $destino=$carpeta.$Name;
                move_uploaded_file($_FILES['Soporte']['tmp_name'],$Atras.$destino);
                $obCon->ActualizaRegistro("factura_compra", "Soporte", $destino, "ID", $idCompra);
            }
            
            $DatosTercero=$obCon->DevuelveValores("proveedores", "Num_Identificacion", $idTercero);
            
            print("OK;$DatosTercero[RazonSocial];$Concepto;$NumeroFactura");
            
        break; 
    
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>