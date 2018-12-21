<?php 
include_once 'clases/ClasesMovimientosContables.php';
$obVenta=new ProcesoVenta($idUser);
$obContable=new Contabilidad($idUser);

if(!empty($_REQUEST["BtnGuardar"])){
    
     $destino="";
    $css= new CssIni("");
    if(!empty($_FILES['foto']['name'])){
        
        $carpeta="../SoportesEgresos/";
        opendir($carpeta);
        $Name=str_replace(' ','_',$_FILES['foto']['name']);  
        $destino=$carpeta.$Name;
        move_uploaded_file($_FILES['foto']['tmp_name'],$destino);
    }
    $idConcepto=$obContable->normalizar($_REQUEST["CmbConcepto"]);
    $Fecha=$obContable->normalizar($_REQUEST["TxtFecha"]);
    $Tercero=$obContable->normalizar($_REQUEST["CmbTercero"]);
    $CentroCosto=$obContable->normalizar($_REQUEST["CmbCentroCostos"]);
    $Sede=$obContable->normalizar($_REQUEST["CmbSede"]);
    $Observaciones=$obContable->normalizar($_REQUEST["TxtObservacionesConcepto"]);
    $NumFactura=$obContable->normalizar($_REQUEST["TxtNumFactura"]);
    
    $DatosRetorno=$obContable->EjecutarConceptoContable($idConcepto,$Fecha,$Tercero,$CentroCosto,$Sede, $Observaciones,$NumFactura,$destino,$idUser,"");
    //$Ruta= base64_encode($DatosRetorno["Ruta"]);
    if(isset($DatosRetorno["RutaCuentaCobro"])){
        
        $css->CrearNotificacionNaranja("Se ha creado un modelo de cuenta de cobro para el tercero;<a href='$DatosRetorno[RutaCuentaCobro]' target='_blank'> Imprimir Cuenta de Cobro</a>", 16);
    
    }
    //header("location:$myPage?RutaPrint=$Ruta");
    $css->CrearNotificacionVerde("Concepto ejecutado correctamente;<a href='$DatosRetorno[Ruta]' target='_blank'> Imprimir Comprobante</a>", 16);
    
    //print("<script>history.go(1);</script>");
}

///////////////fin
?>