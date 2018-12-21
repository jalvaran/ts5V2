<?php 
$obVenta=new ProcesoVenta($idUser);
if(!empty($_REQUEST['del'])){
    $id=$obVenta->normalizar($_REQUEST['del']);
    $Tabla=$obVenta->normalizar($_REQUEST['TxtTabla']);
    $IdTabla=$obVenta->normalizar($_REQUEST['TxtIdTabla']);
    $IdPre=$obVenta->normalizar($_REQUEST['TxtIdPre']);
    
    $obVenta->Query("DELETE FROM $Tabla WHERE $IdTabla='$id'");
    header("location:$myPage?CmbConcepto=$IdPre");
}

if(!empty($_REQUEST["BtnCrearConcepto"])){
        
    $NombreConcepto=$obVenta->normalizar($_REQUEST["TxtNombreNuevoConcepto"]);
    $Observaciones=$obVenta->normalizar($_REQUEST["TxtObservacionesNuevoConcepto"]);
    $Genera=$obVenta->normalizar($_REQUEST["CmbDocumentoGenerado"]);
    $obVenta->CrearConceptoContable($NombreConcepto, $Observaciones,$Genera,"");
   
    header("location:$myPage");
}


// Crear un Monto
if(!empty($_REQUEST["BtnCrearMonto"])){
    
    $idConcepto=$obVenta->normalizar($_REQUEST["CmbConcepto"]);
    $Nombre=$obVenta->normalizar($_REQUEST["TxtMonto"]);
    $Dependencia=$obVenta->normalizar($_REQUEST["CmbDependencia"]); 
    $Operacion=$obVenta->normalizar($_REQUEST["CmbOperacion"]); 
    $ValorDependencia=$obVenta->normalizar($_REQUEST["TxtValorDependencia"]); 
    
    $obVenta->CrearMontoConcepto($idConcepto,$Nombre, $Dependencia,$Operacion,$ValorDependencia,"");    
    header("location:$myPage?CmbConcepto=$idConcepto");
    
}

// Crear Movimiento
if(!empty($_REQUEST["BtnCrearMovimiento"])){
    
    $idConcepto=$obVenta->normalizar($_REQUEST["CmbConcepto"]);
    $idMonto=$obVenta->normalizar($_REQUEST["CmbMonto"]);
    $CuentaMovimiento=$_REQUEST["CmbCuentaMovimiento"]; 
    $TipoMovimiento=$obVenta->normalizar($_REQUEST["CmbTipoMovimiento"]); 
    $CuentaMovimiento=explode(";",$CuentaMovimiento);
    $CuentaPUC=$CuentaMovimiento[0];
    $NombreCuentaPUC=str_replace("_"," ",$CuentaMovimiento[1]);
    
    $obVenta->CrearMovimientoConcepto($idConcepto,$idMonto, $CuentaPUC,$NombreCuentaPUC,$TipoMovimiento,"");  
    
    header("location:$myPage?CmbConcepto=$idConcepto");
    
}

// Guardar y Cerrar Concepto
if(!empty($_REQUEST["BtnCerrarConcepto"])){
    
    $idConcepto=$obVenta->normalizar($_REQUEST["CmbConcepto"]);
    $obVenta->ActualizaRegistro("conceptos", "Completo", "SI", "ID", $idConcepto);
    $obVenta->ActualizaRegistro("conceptos", "Activo", "SI", "ID", $idConcepto);
    header("location:$myPage");
    
}


/// Si se recibe la edicion de una cuenta
if(!empty($_REQUEST["BtnEditarCuentaPUC"])){
    
    $idConcepto=$obVenta->normalizar($_REQUEST["CmbConcepto"]);
    $idMovimiento=$obVenta->normalizar($_REQUEST["idMovimiento"]);
    $CuentaPUC=$obVenta->normalizar($_REQUEST["TxtCuentaPUCEdit"]);
    $obVenta->ActualizaRegistro("conceptos_movimientos", "CuentaPUC",$CuentaPUC , "ID", $idMovimiento);
    header("location:$myPage?CmbConcepto=$idConcepto");
    
}

/// Si se recibe la edicion de un nombre de una cuenta
if(!empty($_REQUEST["BtnEditarNombreCuentaPUC"])){
    
    $idConcepto=$obVenta->normalizar($_REQUEST["CmbConcepto"]);
    $idMovimiento=$obVenta->normalizar($_REQUEST["idMovimiento"]);
    $CuentaPUC=$obVenta->normalizar($_REQUEST["TxtNombreCuentaEdit"]);
    $TipoMovimiento=$obVenta->normalizar($_REQUEST["CmbTipoMovimiento"]);
    $obVenta->ActualizaRegistro("conceptos_movimientos", "NombreCuentaPUC",$CuentaPUC , "ID", $idMovimiento);
    $obVenta->ActualizaRegistro("conceptos_movimientos", "TipoMovimiento",$TipoMovimiento , "ID", $idMovimiento);
    header("location:$myPage?CmbConcepto=$idConcepto");
    
}

/// Si se recibe la edicion de un concepto
if(!empty($_REQUEST["BtnEditarConcepto"])){
    
    $idConcepto=$obVenta->normalizar($_REQUEST["CmbConcepto"]);
    $Nombre=$obVenta->normalizar($_REQUEST["TxtNombreConceptoEdit"]);
    $Observaciones=$obVenta->normalizar($_REQUEST["TxtObservacionesConceptoEdit"]);
    $DocumentoGenerado=$obVenta->normalizar($_REQUEST["CmbDocumentoGeneradoEdit"]);
    $obVenta->ActualizaRegistro("conceptos", "Nombre",$Nombre , "ID", $idConcepto);
    $obVenta->ActualizaRegistro("conceptos", "Observaciones",$Observaciones , "ID", $idConcepto);
    $obVenta->ActualizaRegistro("conceptos", "Genera",$DocumentoGenerado , "ID", $idConcepto);
    header("location:$myPage?CmbConcepto=$idConcepto");
    
}

///////////////fin
?>