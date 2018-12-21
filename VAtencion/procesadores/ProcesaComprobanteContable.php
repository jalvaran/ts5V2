<?php 
include_once 'clases/ClasesMovimientosContables.php';
$obVenta=new ProcesoVenta($idUser);
$obContable=new Contabilidad($idUser);
if(!empty($_REQUEST['del'])){
    $id=$_REQUEST['del'];
    $Tabla=$_REQUEST['TxtTabla'];
    $IdTabla=$_REQUEST['TxtIdTabla'];
    $IdPre=$_REQUEST['TxtIdPre'];
    $DatosItem=$obVenta->DevuelveValores($Tabla, $IdTabla, $id);
    $obVenta->ActualizaRegistro("librodiario", "Estado", "", "idLibroDiario", $DatosItem["idLibroDiario"]);
    $obVenta->Query("DELETE FROM $Tabla WHERE $IdTabla='$id'");
    header("location:CreaComprobanteCont.php?idComprobante=$IdPre");
}

if(!empty($_REQUEST["BtnCrearComC"])){
    
    $fecha=$obContable->normalizar($_REQUEST["TxtFecha"]);
    $hora=date("H:i");
    $Concepto=$obContable->normalizar($_REQUEST["TxtConceptoComprobante"]);
    $idComprobante=$obContable->CrearComprobanteContable($fecha, $Concepto, $hora, $idUser, "");
     ////////////////Creo el comprobante
    /////
    ////
    /*
    $tab="comprobantes_contabilidad";
    $NumRegistros=4; 

    $Columnas[0]="Fecha";                  $Valores[0]=$fecha;
    $Columnas[1]="Concepto";                $Valores[1]=$Concepto;
    $Columnas[2]="Hora";                $Valores[2]=$hora;
    $Columnas[3]="Usuarios_idUsuarios"; $Valores[3]=$idUser;
    
    $obVenta->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
    $idComprobante=$obVenta->ObtenerMAX($tab, "ID", 1, "");
    */
    ////////////////Creo el pre movimiento
    /////
    ////
    
    $tab="comprobantes_pre";
    $NumRegistros=3; 

    $Columnas[0]="Fecha";                       $Valores[0]=$fecha;
    $Columnas[1]="Concepto";                    $Valores[1]=$Concepto;
    $Columnas[2]="idComprobanteContabilidad";   $Valores[2]=$idComprobante;
    
    $obVenta->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
    header("location:$myPage");
}

		
if(!empty($_REQUEST["BtnAgregarItemMov"])){
    
    $obVenta=new ProcesoVenta($idUser);
    
    $destino="";
    //echo "<script>alert ('entra')</script>";
    if(!empty($_FILES['foto']['name'])){
        
        $carpeta="../SoportesEgresos/";
        opendir($carpeta);
        $Name=str_replace(' ','_',$_FILES['foto']['name']);  
        $destino=$carpeta.$Name;
        move_uploaded_file($_FILES['foto']['tmp_name'],$destino);
    }
    
    $idComprobante=$obContable->normalizar($_REQUEST["TxtIdCC"]);
    $DatosComprobante=$obVenta->DevuelveValores("comprobantes_contabilidad", "ID", $idComprobante);
    $fecha=$DatosComprobante["Fecha"];
    
    $Concepto=$obContable->normalizar($_REQUEST["TxtConceptoEgreso"]);
    $CentroCosto=$obContable->normalizar($_REQUEST["CmbCentroCosto"]);
    $Tercero=$obContable->normalizar($_REQUEST["CmbTerceroItem"]);
    $DatosCuentaDestino=$_REQUEST["CmbCuentaDestino"];
    $DatosCuentaDestino=explode(";",$DatosCuentaDestino);
    $CuentaPUC=$DatosCuentaDestino[0];
    $NombreCuenta=str_replace("_"," ",$DatosCuentaDestino[1]);
    
    $Valor=$obContable->normalizar($_REQUEST["TxtValorItem"]);
    $DC=$obContable->normalizar($_REQUEST["CmbDebitoCredito"]);
    $NumDocSoporte=$obContable->normalizar($_REQUEST["TxtNumFactura"]);
    if($DC=="C"){
        $Debito=0;
        $Credito= $Valor;       
    }else{
       $Debito=$Valor;
       $Credito=0; 
    }
    $obContable->IngreseMovimientoComprobanteContable($fecha, $CentroCosto, $Tercero, $CuentaPUC, $Debito, $Credito, $Concepto, $NumDocSoporte, $destino, $idComprobante, $NombreCuenta, "");
     ////////////////Ingreso el Item
    /////
    ////
    /*
    $tab="comprobantes_contabilidad_items";
    $NumRegistros=11;

    $Columnas[0]="Fecha";			$Valores[0]=$fecha;
    $Columnas[1]="CentroCostos";		$Valores[1]=$CentroCosto;
    $Columnas[2]="Tercero";			$Valores[2]=$Tercero;
    $Columnas[3]="CuentaPUC";			$Valores[3]=$CuentaPUC;
    $Columnas[4]="Debito";			$Valores[4]=$Debito;
    $Columnas[5]="Credito";                     $Valores[5]=$Credito;
    $Columnas[6]="Concepto";			$Valores[6]=$Concepto;
    $Columnas[7]="NumDocSoporte";		$Valores[7]=$NumDocSoporte;
    $Columnas[8]="Soporte";			$Valores[8]=$destino;
    $Columnas[9]="idComprobante";		$Valores[9]=$idComprobante;
    $Columnas[10]="NombreCuenta";		$Valores[10]=$NombreCuenta;

    $obVenta->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
     * 
     */
    //header("location:$myPage?idComprobante=$idComprobante");
}

if(!empty($_REQUEST["CmbComprobante"])){
    
    $idComprobante=$_REQUEST["CmbComprobante"];
    header("location:$myPage?idComprobante=$idComprobante");
}

// si se requiere guardar y cerrar
if(!empty($_REQUEST["BtnGuardarMovimiento"])){
    
    $idComprobante=$_REQUEST["TxtIdComprobanteContable"];    
    $obContable->RegistreComprobanteContable($idComprobante);    
    header("location:$myPage?ImprimeCC=$idComprobante");
    
}

// si se requiere importar movimientos
if(!empty($_FILES['UpMovimientos']['name'])){
    $idComprobante=$obVenta->normalizar($_REQUEST["idComprobante"]);
    $DatosComprobante=$obVenta->DevuelveValores("comprobantes_contabilidad", "ID", $idComprobante);
    $handle = fopen($_FILES['UpMovimientos']['tmp_name'], "r");
    $i=0;
    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
        if($i>0){
             ////////////////Ingreso el Item
            /////
            ////

            $tab="comprobantes_contabilidad_items";
            $NumRegistros=11;

            $Columnas[0]="Fecha";			$Valores[0]=$DatosComprobante["Fecha"];
            $Columnas[1]="CentroCostos";		$Valores[1]=$data[0];
            $Columnas[2]="Tercero";			$Valores[2]=$data[1];
            $Columnas[3]="CuentaPUC";			$Valores[3]=$data[2];
            $Columnas[4]="Debito";			$Valores[4]=$data[4];
            $Columnas[5]="Credito";                     $Valores[5]=$data[5];
            $Columnas[6]="Concepto";			$Valores[6]=$data[6];
            $Columnas[7]="NumDocSoporte";		$Valores[7]=$data[7];
            $Columnas[8]="Soporte";			$Valores[8]="";
            $Columnas[9]="idComprobante";		$Valores[9]=$idComprobante;
            $Columnas[10]="NombreCuenta";		$Valores[10]=$data[3];

            $obVenta->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
        }

        $i++; 
    }
    fclose($handle);
    $css->CrearNotificacionNaranja("Importacion Completa",16);
   
    
}
///////////////fin
?>