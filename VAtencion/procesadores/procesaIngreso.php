<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if(!empty($_REQUEST["BtnGuardarPago"])){
        include_once("../modelo/php_tablas.php");  //Clases de donde se escribirán las tablas
    
        $obTabla = new Tabla($db);
        $obVenta = new ProcesoVenta(1);
        
        $idFactura=$obVenta->normalizar($_REQUEST['TxtIdFactura']);
        $fecha=$obVenta->normalizar($_REQUEST['TxtFecha']);
        $ReteFuente=$obVenta->normalizar($_REQUEST["TxtRetefuente"]);
        $CuentaDestino=$obVenta->normalizar($_REQUEST["CmbCuentaDestino"]);
        $ReteICA=$obVenta->normalizar($_REQUEST["TxtReteICA"]);
        $ReteIVA=$obVenta->normalizar($_REQUEST["TxtReteIVA"]);
        $Anticipos=$obVenta->normalizar($_REQUEST["TxtAnticipos"]);
        $OtrosDescuentos=$obVenta->normalizar($_REQUEST["TxtOtrosDescuentos"]);
        $Pago=$obVenta->normalizar($_REQUEST["TxtPagoH"]);
        $Parametros=$obVenta->DevuelveValores("parametros_contables", "ID", 20);
        $VectorIngresos["Anticipos"]=$Anticipos;
        $VectorIngresos["CuentaAnticipos"]=$Parametros["CuentaPUC"];
        $VectorIngresos["NombreCuentaAntipos"]=$Parametros["NombreCuenta"];
        $VectorIngresos["OtrosDescuentos"]=$OtrosDescuentos;
        $VectorIngresos["CuentaReteFuente"]=$obVenta->normalizar($_REQUEST["CmbCuentaReteFuente"]);
        $VectorIngresos["CuentaReteICA"]=$obVenta->normalizar($_REQUEST["CmbCuentaReteICA"]);
        $VectorIngresos["CuentaReteIVA"]=$obVenta->normalizar($_REQUEST["CmbCuentaReteIVA"]);
        $VectorIngresos["CuentaOtros"]=$obVenta->normalizar($_REQUEST["CmbCuentaOtros"]);
        $idIngreso=$obVenta->RegistrePagoFactura($idFactura, $fecha, $Pago, $CuentaDestino, $ReteFuente, $ReteIVA, $ReteICA, $idUser, $VectorIngresos);
        $obVenta->BorraReg("cartera", "Facturas_idFacturas", $idFactura);
        header("location:RegistrarIngreso.php?TxtidIngreso=$idIngreso");
        
    }
?>