<?php 
$obRemision=new Remision($idUser);
	
if(!empty($_REQUEST['del'])){
    $id=$_REQUEST['del'];
    $Tabla=$_REQUEST['TxtTabla'];
    $IdTabla=$_REQUEST['TxtIdTabla'];
    $IdPre=$_REQUEST['TxtIdPre'];
    $obRemision->BorraReg($Tabla, $IdTabla, $id);

}
		
if(!empty($_REQUEST['TxtSaldo'])){

    
    $Fecha=$obRemision->normalizar($_REQUEST['TxtFechaRemision']);
    $idCliente=$obRemision->normalizar($_REQUEST['TxtidCliente']);
    $Observaciones=$obRemision->normalizar($_REQUEST['TxtObservacionesRemision']);
    $idCotizacion=$obRemision->normalizar($_REQUEST['TxtIdCotizacion']);
    $Obra=$obRemision->normalizar($_REQUEST['TxtObra']);
    $DireccionObra=$obRemision->normalizar($_REQUEST['TxtDireccionObra']);
    $CiudadObra=$obRemision->normalizar($_REQUEST['TxtCiudadObra']);
    $TelefonoObra=$obRemision->normalizar($_REQUEST['TxtTelefonoObra']);
    $ColaboradorRetira=$obRemision->normalizar($_REQUEST['TxtRetira']);
    $FechaDespacho=$obRemision->normalizar($_REQUEST['TxtFecha']);
    $HoraDespacho=$obRemision->normalizar($_REQUEST['TxtHora']);
    $Anticipo=$obRemision->normalizar($_REQUEST['TxtAnticipo']);
    $Dias=$obRemision->normalizar($_REQUEST['TxtDias']);
    $CentroCostos=$obRemision->normalizar($_REQUEST['CmbCentroCostos']);
    $CuentaDestino=$obRemision->normalizar($_REQUEST['CmbCuentaDestino']);
    
    $idRemision=$obRemision->CrearRemision($Fecha, $idCliente, $Observaciones, $idCotizacion, $Obra, $DireccionObra, $CiudadObra, $TelefonoObra, $ColaboradorRetira, $FechaDespacho, $HoraDespacho, $Anticipo, $Dias, $idUser, $CentroCostos, "");
    $VariblesImpresion="TxtidRemision=$idRemision";
    if($_REQUEST['TxtAnticipo']>0){

        //$idIngreso=$obVenta->RegistreAnticipo($_REQUEST['TxtidCliente'],$_REQUEST['TxtAnticipo'],$_REQUEST['CmbCuentaDestino'],$_REQUEST['CmbCentroCostos'],"Anticipo por remision $idRemision",$idUser);
        $Concepto="Anticipo por remision $idRemision";
        $idIngreso=$obVenta->RegistreAnticipo2($Fecha, $CuentaDestino, $idCliente, $Anticipo, $CentroCostos, $Concepto, $idUser, "");
        $VariblesImpresion=$VariblesImpresion."&TxtidIngreso=$idIngreso";

    }
    header("location:Remisiones.php?$VariblesImpresion");	
}
	
?>