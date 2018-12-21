<?php 
if(!empty($_REQUEST['del'])){
    $obVenta=new ProcesoVenta($idUser);
    $id=$_REQUEST['del'];
    $Tabla=$_REQUEST['TxtTabla'];
    $IdTabla=$_REQUEST['TxtIdTabla'];
    $IdPre=$_REQUEST['TxtIdPre'];
    $DatosItem=$obVenta->DevuelveValores($Tabla, $IdTabla, $id);
    $obVenta->ActualizaRegistro("librodiario", "Estado", "", "idLibroDiario", $DatosItem["idLibroDiario"]);
    $obVenta->Query("DELETE FROM $Tabla WHERE $IdTabla='$id'");
    header("location:CuentasXCobrar.php?idComprobante=$IdPre");
}

if(!empty($_REQUEST["BtnCrearComC"])){
    
    $obVenta=new ProcesoVenta($idUser);
    
    $fecha=$_REQUEST["TxtFecha"];
    $hora=date("H:i");
    $Concepto=$_REQUEST["TxtConceptoComprobante"];
    
     ////////////////Creo el comprobante
    /////
    ////
    
    $tab="comprobantes_contabilidad";
    $NumRegistros=4; 

    $Columnas[0]="Fecha";                  $Valores[0]=$fecha;
    $Columnas[1]="Concepto";                $Valores[1]=$Concepto;
    $Columnas[2]="Hora";                $Valores[2]=$hora;
    $Columnas[3]="Usuarios_idUsuarios"; $Valores[3]=$idUser;
    
    $obVenta->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
    $idComprobante=$obVenta->ObtenerMAX($tab, "ID", 1, "");
    
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
    
    $idComprobante=$_REQUEST["TxtIdCC"];
    $DatosComprobante=$obVenta->DevuelveValores("comprobantes_contabilidad", "ID", $idComprobante);
    $fecha=$DatosComprobante["Fecha"];
    
    $Concepto=$_REQUEST["TxtConceptoEgreso"];
    $CentroCosto=$_REQUEST["CmbCentroCosto"];
    $Tercero=$_REQUEST["CmbTerceroItem"];
    $DatosCuentaDestino=$_REQUEST["CmbCuentaDestino"];
    $DatosCuentaDestino=explode(";",$DatosCuentaDestino);
    $CuentaPUC=$DatosCuentaDestino[0];
    $NombreCuenta=$NombreCuenta=str_replace("_"," ",$DatosCuentaDestino[1]);
    
    $Valor=$_REQUEST["TxtValorItem"];
    $DC=$_REQUEST["CmbDebitoCredito"];
    $NumDocSoporte=$_REQUEST["TxtNumFactura"];
    if($DC=="C"){
        $Debito=0;
        $Credito= $Valor;       
    }else{
       $Debito=$Valor;
       $Credito=0; 
    }
     ////////////////Ingreso el Item
    /////
    ////
    
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
    //header("location:$myPage?idComprobante=$idComprobante");
}

if(!empty($_REQUEST["CmbComprobante"])){
    
    $idComprobante=$_REQUEST["CmbComprobante"];
    $DatosComprobante=$obVenta->DevuelveValores("comprobantes_contabilidad", "ID", $idComprobante);
    $obVenta->ActualizaRegistro("comprobantes_contabilidad_items", "Fecha", $DatosComprobante["Fecha"], "idComprobante", 0);
    $obVenta->ActualizaRegistro("comprobantes_contabilidad_items", "idComprobante", $idComprobante, "idComprobante", 0);
    
    header("location:$myPage?idComprobante=$idComprobante");
}

// si se requiere guardar y cerrar
if(!empty($_REQUEST["BtnGuardarMovimiento"])){
    
    $idComprobante=$_REQUEST["TxtIdComprobanteContable"];    
    $obVenta->RegistreComprobanteContable($idComprobante);    
    header("location:$myPage?ImprimeCC=$idComprobante");
    
}


/*
 * 
 * Agrega items desde libro diario
 * 
 */

if(isset($_REQUEST["ChkID"])){
    
    $obVenta=new ProcesoVenta(1);
    //$Selecciones["ChkID"]=$_REQUEST["ChkID"];
    $idComprobante=$_REQUEST["idComprobante"];
    $DatosComprobante=$obVenta->DevuelveValores("comprobantes_contabilidad", "ID", $idComprobante);
    $fecha=$DatosComprobante["Fecha"];
    foreach($_REQUEST["ChkID"] as $ids){
        
    
    $DatosLibro=$obVenta->DevuelveValores("librodiario", "idLibroDiario", $ids);
    
    $Concepto=$DatosLibro["Concepto"];
    $CentroCosto=$DatosLibro["idCentroCosto"];
    $Tercero=$DatosLibro["Tercero_Identificacion"];
    $CuentaPUC=$DatosLibro["CuentaPUC"];
    $NombreCuenta=$DatosLibro["NombreCuenta"];
    $destino="";
    $AbonosActuales=$obVenta->Sume("abonos_libro", "Cantidad", "WHERE idLibroDiario='$ids'");
    
    $Valor=$DatosLibro["Neto"]-$AbonosActuales;
    $DC="C";
    $NumDocSoporte=$DatosLibro["Num_Documento_Interno"];
    if($DC=="C"){
        $Debito=0;
        $Credito= $Valor;       
    }else{
       $Debito=$Valor;
       $Credito=0; 
    }
     ////////////////Ingreso el Item
    /////
    ////
    
    $tab="comprobantes_contabilidad_items";
    $NumRegistros=12;

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
    $Columnas[11]="idLibroDiario";		$Valores[11]=$ids;

    $obVenta->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
    $obVenta->ActualizaRegistro("librodiario", "Estado", "OC", "idLibroDiario", $ids);
    }
}

/*
 * Registre un abono
 */
if(!empty($_REQUEST["BtnAbonar"])){
   $idLibro=$_REQUEST["BtnAbonar"];
    
    $obVenta=new ProcesoVenta(1);
    $TotalAbono=$_REQUEST["TxtAbono$idLibro"];
    if($TotalAbono<1){
        echo "<script>alert('Valor de Abono no valido')</script>";
        exit(" <a href='CuentasXCobrar.php'> Volver</a> ");
    } 
    if(!isset($_REQUEST["TxtFecha$idLibro"]) or empty($_REQUEST["TxtFecha$idLibro"])){
        echo "<script>alert('Debe escribir una fecha')</script>";
        exit(" <a href='CuentasXCobrar.php'> Volver</a> ");
    } 
    
    $TablaAbonos="abonos_libro";
    $Cuenta=$_REQUEST["CmbAbono$idLibro"];
    $PageReturn="CuentasXCobrar.php";
    
    $Datos["idUser"]=$idUser;
    $Datos["Fecha"]=$_REQUEST["TxtFecha$idLibro"];
    $Datos["TipoAbono"]="CuentasXCobrar";
    $idComprobante=$obVenta->RegistreAbonoLibro($idLibro,$TablaAbonos,$Cuenta,$PageReturn,$TotalAbono,$Datos); 
   
    header("location:$myPage?ImprimeCC=$idComprobante");
    
}
///////////////fin
?>