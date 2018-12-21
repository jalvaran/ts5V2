<?php 
$obVenta=new ProcesoVenta($idUser);
            
if(isset($_REQUEST['idCuentaXPagar'])){

    $fecha=date("Y-m-d");
    $Hora=date("H:i:s");
    
    $idCuentaXPagar=$obVenta->normalizar($_REQUEST['idCuentaXPagar']);
    $DatosPreEgreso=$obVenta->DevuelveValores("egresos_pre", "idCuentaXPagar", $idCuentaXPagar);
    if($DatosPreEgreso["idCuentaXPagar"]<>$idCuentaXPagar){
        $DatosCuentaXPagar=$obVenta->DevuelveValores("cuentasxpagar", "ID", $idCuentaXPagar);

        $tab="egresos_pre";
        $NumRegistros=3;
        $Columnas[0]="idCuentaXPagar";      $Valores[0]=$idCuentaXPagar;
        $Columnas[1]="Abono";               $Valores[1]=0;
        $Columnas[2]="idUsuario";           $Valores[2]=$idUser;

        $obVenta->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
    }else{
       $css->CrearNotificacionRoja("Esta cuenta no se puede agregar porque ya está ocupada por el Usuario ".$DatosPreEgreso["idUsuario"], 16); 
    }
}

// se edita un abono
if(isset($_REQUEST['BtnEditar'])){
    $idPreEgreso=$obVenta->normalizar($_REQUEST['idPre']);
    $Saldo=$obVenta->normalizar($_REQUEST['TxtSaldo']);
    $Abono=$obVenta->normalizar($_REQUEST['TxtAbonoEdit']);
    $Descuento=$obVenta->normalizar($_REQUEST['TxtDescuentoProntoPago']);
    $Cruces=0;
    if(isset($_REQUEST["CmbNotaDevolucion"])){
        $idNotaDevolucion=$obVenta->normalizar($_REQUEST["CmbNotaDevolucion"]);
        $DatosNota=$obVenta->DevuelveValores("vista_notas_devolucion", "ID", $idNotaDevolucion);
        $Cruces=$DatosNota["Total"];
        $obVenta->ActualizaRegistro("egresos_pre", "CruceNota", $Cruces, "ID", $idPreEgreso);
        $obVenta->ActualizaRegistro("factura_compra_notas_devolucion", "Estado", "CRUZADA", "ID", $idNotaDevolucion);
    }
    $AbonoTotal=$Abono+$Descuento+$Cruces;
    if($AbonoTotal<=$Saldo){
        $obVenta->ActualizaRegistro("egresos_pre", "Abono", $Abono, "ID", $idPreEgreso);
        $obVenta->ActualizaRegistro("egresos_pre", "Descuento", $Descuento, "ID", $idPreEgreso);
    }else {
        $css->CrearNotificacionRoja("El abono + el descuento no pueden superar al saldo: Abonos + Movimiento = $AbonoTotal, Saldo= $Saldo, por favor corrija los valores", 16);         
    }
}

// se elimina un abono
if(isset($_REQUEST['del'])){
    $idDel=$obVenta->normalizar($_REQUEST['del']);
    $obVenta->BorraReg("egresos_pre", "ID", $idDel);
}

// se elimina un abono
if(isset($_REQUEST['BtnGuardar'])){
    $Fecha=$obVenta->normalizar($_REQUEST['TxtFecha']);
    $CuentaOrigen=$obVenta->normalizar($_REQUEST['CmbCuentaOrigen']);
    $Observaciones=$obVenta->normalizar($_REQUEST['TxtObservaciones']);
    $Egresos=$obVenta->EgresosDesdePre($Fecha,$CuentaOrigen,$idUser,$Observaciones,"");
    $obVenta->BorraReg("egresos_pre", "idUsuario", $idUser);
    foreach ($Egresos as $idEgreso) {
        $RutaPrintComp="../tcpdf/examples/imprimircomp.php?ImgPrintComp=$idEgreso";
        $css->CrearNotificacionVerde("Se ha creado el egreso No. $idEgreso <a href='$RutaPrintComp' target='_blank'>Imprimir</a>",16);
    }
}
///////////////Fin

?>