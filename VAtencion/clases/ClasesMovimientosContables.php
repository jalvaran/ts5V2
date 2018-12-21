<?php
/* 
 * Clase donde se realizaran procesos de compras u otros modulos.
 * Julian Alvaran
 * Techno Soluciones SAS
 */
//include_once '../../php_conexion.php';
class Contabilidad extends ProcesoVenta{
    public function CrearComprobanteContable($Fecha, $Concepto, $hora,$idUser,$Vector ) {
        
        $tab="comprobantes_contabilidad";
        $NumRegistros=4; 

        $Columnas[0]="Fecha";                  $Valores[0]=$Fecha;
        $Columnas[1]="Concepto";                $Valores[1]=$Concepto;
        $Columnas[2]="Hora";                $Valores[2]=$hora;
        $Columnas[3]="Usuarios_idUsuarios"; $Valores[3]=$idUser;

        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
        $idComprobante=$this->ObtenerMAX($tab, "ID", 1, "");
        return $idComprobante;
    }
    
    public function IngreseMovimientoComprobanteContable($Fecha, $CentroCosto,$Tercero, $CuentaPUC,$Debito,$Credito,$Concepto,$NumDocSoporte,$destino,$idComprobante,$NombreCuenta,$Vector ) {
        
         ////////////////Ingreso el Item
        /////
        ////

        $tab="comprobantes_contabilidad_items";
        $NumRegistros=11;

        $Columnas[0]="Fecha";			$Valores[0]=$Fecha;
        $Columnas[1]="CentroCostos";		$Valores[1]=$CentroCosto;
        $Columnas[2]="Tercero";			$Valores[2]=$Tercero;
        $Columnas[3]="CuentaPUC";		$Valores[3]=$CuentaPUC;
        $Columnas[4]="Debito";			$Valores[4]=$Debito;
        $Columnas[5]="Credito";                 $Valores[5]=$Credito;
        $Columnas[6]="Concepto";                $Valores[6]=$Concepto;
        $Columnas[7]="NumDocSoporte";		$Valores[7]=$NumDocSoporte;
        $Columnas[8]="Soporte";			$Valores[8]=$destino;
        $Columnas[9]="idComprobante";		$Valores[9]=$idComprobante;
        $Columnas[10]="NombreCuenta";		$Valores[10]=$NombreCuenta;

        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
    }
    //Registra un comprobante contable
    public function RegistreComprobanteContable($idComprobante){
        
        $DatosSucursal=  $this->DevuelveValores("empresa_pro_sucursales", "Actual", 1); 
        $DatosGenerales=$this->DevuelveValores("comprobantes_contabilidad","ID",$idComprobante);
        $Consulta=$this->ConsultarTabla("comprobantes_contabilidad_items", "WHERE idComprobante=$idComprobante");
        while($DatosComprobante=$this->FetchArray($Consulta)){
            $Fecha=$DatosComprobante["Fecha"];
            
            $tab="librodiario";
            $NumRegistros=28;
            $CuentaPUC=$DatosComprobante["CuentaPUC"];
            $NombreCuenta=$DatosComprobante["NombreCuenta"];
            $DatosCliente=$this->DevuelveValores("proveedores", "Num_Identificacion", $DatosComprobante["Tercero"]);
            if($DatosCliente["Num_Identificacion"]==''){
                $DatosCliente=$this->DevuelveValores("clientes", "Num_Identificacion", $DatosComprobante["Tercero"]);
            
            }
            $DatosCentro=$this->DevuelveValores("centrocosto", "ID", $DatosComprobante["CentroCostos"]);
            
            $Columnas[0]="Fecha";			$Valores[0]=$Fecha;
            $Columnas[1]="Tipo_Documento_Intero";	$Valores[1]="COMPROBANTE CONTABLE";
            $Columnas[2]="Num_Documento_Interno";	$Valores[2]=$idComprobante;
            $Columnas[3]="Tercero_Tipo_Documento";	$Valores[3]=$DatosCliente['Tipo_Documento'];
            $Columnas[4]="Tercero_Identificacion";	$Valores[4]=$DatosCliente['Num_Identificacion'];
            $Columnas[5]="Tercero_DV";                  $Valores[5]=$DatosCliente['DV'];
            $Columnas[6]="Tercero_Primer_Apellido";	$Valores[6]=$DatosCliente['Primer_Apellido'];
            $Columnas[7]="Tercero_Segundo_Apellido";    $Valores[7]=$DatosCliente['Segundo_Apellido'];
            $Columnas[8]="Tercero_Primer_Nombre";	$Valores[8]=$DatosCliente['Primer_Nombre'];
            $Columnas[9]="Tercero_Otros_Nombres";	$Valores[9]=$DatosCliente['Otros_Nombres'];
            $Columnas[10]="Tercero_Razon_Social";	$Valores[10]=$DatosCliente['RazonSocial'];
            $Columnas[11]="Tercero_Direccion";          $Valores[11]=$DatosCliente['Direccion'];
            $Columnas[12]="Tercero_Cod_Dpto";           $Valores[12]=$DatosCliente['Cod_Dpto'];
            $Columnas[13]="Tercero_Cod_Mcipio";         $Valores[13]=$DatosCliente['Cod_Mcipio'];
            $Columnas[14]="Tercero_Pais_Domicilio";     $Valores[14]=$DatosCliente['Pais_Domicilio'];

            $Columnas[15]="CuentaPUC";                  $Valores[15]=$CuentaPUC;
            $Columnas[16]="NombreCuenta";		$Valores[16]=$NombreCuenta;
            $Columnas[17]="Detalle";                    $Valores[17]=$DatosGenerales["Concepto"];
            $Columnas[18]="Debito";			$Valores[18]=$DatosComprobante["Debito"];
            $Columnas[19]="Credito";                    $Valores[19]=$DatosComprobante["Credito"];
            $Columnas[20]="Neto";			$Valores[20]=$Valores[18]-$Valores[19];
            $Columnas[21]="Mayor";			$Valores[21]="NO";
            $Columnas[22]="Esp";			$Valores[22]="NO";
            $Columnas[23]="Concepto";                   $Valores[23]=$DatosComprobante["Concepto"];
            $Columnas[24]="idCentroCosto";		$Valores[24]=$DatosComprobante["CentroCostos"];
            $Columnas[25]="idEmpresa";                  $Valores[25]=$DatosCentro["EmpresaPro"];
            $Columnas[26]="idSucursal";                 $Valores[26]=$DatosSucursal["ID"];
            $Columnas[27]="Num_Documento_Externo";      $Valores[27]=$DatosComprobante["NumDocSoporte"];
            $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
            
            
        }
        $this->ActualizaRegistro("comprobantes_contabilidad", "Estado", "C", "ID", $idComprobante);
        $this->ActualizaRegistro("comprobantes_pre", "Estado", "C", "idComprobanteContabilidad", $idComprobante);
    }
    
    // Clase para Ejecutar un Concepto Contable
        public function EjecutarConceptoContable($idConcepto,$Fecha,$Tercero,$CentroCosto,$Sede, $Observaciones,$NumFactura,$destino,$idUser,$Vector){
            $DatosConcepto=$this->DevuelveValores("conceptos", "ID", $idConcepto);
            $TipoDocInterno=$DatosConcepto["Genera"];
            $DatosProveedor=$this->DevuelveValores("proveedores", "Num_Identificacion", $Tercero);
            $Consulta=$this->ConsultarTabla("conceptos_montos", " WHERE idConcepto='$idConcepto'");
            $Subtotal=0;
            $IVA=0;
            
            while($DatosMonto=  $this->FetchArray($Consulta)){
                $idMonto=$DatosMonto["ID"];
                $Monto[$idMonto]=round($this->normalizar($_REQUEST["Monto$idMonto"]));
                if($DatosMonto["NombreMonto"]=="Subtotal"){
                    $Subtotal=$Monto[$idMonto];
                }
                
                if($DatosMonto["NombreMonto"]=="IVA"){
                    $IVA=$Monto[$idMonto];
                }
            }
            $Total=$Subtotal+$IVA;
            if($TipoDocInterno=="CE"){
                $TipoDocInterno="CompEgreso";
                       
                $DocumentoInterno=$this->CrearEgreso($Fecha, $Fecha, $idUser, $CentroCosto, "Contado", 0, 0, 0, $DatosProveedor["idProveedores"], $Observaciones, $NumFactura, $destino, 20, $Subtotal, $IVA, $Total, 0, 0, 0, 0, 0, 0, "");
                $DatosRetorno["Ruta"]="../tcpdf/examples/imprimircomp.php?ImgPrintComp=$DocumentoInterno";
                
            }
            if($TipoDocInterno=="CC"){
                
                $idComprobante=$this->CrearComprobanteContable($Fecha, $DatosConcepto["Nombre"], date("H:i"), $idUser, "");
                
                $Consulta=$this->ConsultarTabla("conceptos_movimientos", " WHERE idConcepto='$idConcepto'");
                while($DatosMovimientos=$this->FetchArray($Consulta)){
                    $CuentaPUC=$DatosMovimientos["CuentaPUC"];
                    $idMonto=$DatosMovimientos["idMonto"];
                    $NombreCuenta=$DatosMovimientos["NombreCuentaPUC"];
                    $Valor=$Monto[$idMonto];
                    $TipoMovimiento=$DatosMovimientos["TipoMovimiento"];
                    if($TipoMovimiento=="CR"){
                        $Debito=0;
                        $Credito= $Valor;       
                    }else{
                       $Debito=$Valor;
                       $Credito=0; 
                    }
                    $this->IngreseMovimientoComprobanteContable($Fecha, $CentroCosto, $Tercero, $CuentaPUC, $Debito, $Credito, $Observaciones, $NumFactura, $destino, $idComprobante, $NombreCuenta, "");
                    
                }
                $this->RegistreComprobanteContable($idComprobante);
                
                $SubtotalCuentaXPagar=$Subtotal;
                $TotalIVACXP=$IVA;
                $TotalCompraCXP=$Total;
                $sql="SELECT CuentaPUC FROM conceptos_movimientos WHERE idConcepto='$idConcepto' AND CuentaPUC LIKE '23%' limit 1";
                $consulta=$this->Query($sql);
                $DatosCuenta=$this->FetchArray($consulta);
                $VectorCuentas["CuentaPUC"]=$DatosCuenta["CuentaPUC"];
                $this->RegistrarCuentaXPagar($Fecha, $NumFactura, $Fecha, "conceptos", $idConcepto, $SubtotalCuentaXPagar, $TotalIVACXP, $TotalCompraCXP, 0, 0, 0, $Tercero, $Sede, $CentroCosto, $Observaciones, $destino, $VectorCuentas);
        
                
                //$TipoDocInterno="NotaContable";
                
                //$DocumentoInterno=$this->CrearEgreso($Fecha, $Fecha, $this->idUser, $CentroCosto, "Programado", 0, 0, 0, $DatosProveedor["idProveedores"], $Observaciones, $NumFactura, $destino, 20, $Subtotal, $IVA, $Total, 0, 0, 0, 0, 0, 0, "");
                $DatosRetorno["Ruta"]="../tcpdf/examples/comprobantecontable.php?idComprobante=$idComprobante";
                
            }
            $Detalle=$DatosConcepto["Observaciones"];
            if($DatosConcepto["TerceroCuentaCobro"]=='SI'){
                $idCuenta=$this->CrearCuentaCobroXTercero($Fecha, $Tercero, $idConcepto, $Valor,$Detalle, $idUser, "");
                $DatosRetorno["RutaCuentaCobro"]="PDF_Documentos.php?idDocumento=30&idCuenta=$idCuenta";
            }
            /*
            $Consulta=$this->ConsultarTabla("conceptos_movimientos", " WHERE idConcepto='$idConcepto'");
            while($DatosMovimientos=$this->FetchArray($Consulta)){
                $CuentaPUC=$DatosMovimientos["CuentaPUC"];
                $idMonto=$DatosMovimientos["idMonto"];
                $NombreCuenta=$DatosMovimientos["NombreCuentaPUC"];
                $Valor=$Monto[$idMonto];
                $TipoMovimiento=$DatosMovimientos["TipoMovimiento"];
                $this->IngreseMovimientoLibroDiario($Fecha,$TipoDocInterno,$DocumentoInterno,$NumFactura,$Tercero,$CuentaPUC,$NombreCuenta,$Detalle,$TipoMovimiento,$Valor,$Observaciones,$CentroCosto,$Sede,"");
            }
             * 
             */
            return($DatosRetorno);
        }
        //Crear cuenta de cobro para un tercero
        public function CrearCuentaCobroXTercero($Fecha,$Tercero,$idConcepto,$Valor,$Observaciones,$idUser,$Vector) {
            $tab="terceros_cuentas_cobro";
            $NumRegistros=6;

            $Columnas[0]="Fecha";		   $Valores[0]=$Fecha;
            $Columnas[1]="Tercero";                $Valores[1]=$Tercero;
            $Columnas[2]="idConceptoContable";     $Valores[2]=$idConcepto;
            $Columnas[3]="Valor";		   $Valores[3]=$Valor;
            $Columnas[4]="idUser";                 $Valores[4]=$idUser;
            $Columnas[5]="Observaciones";          $Valores[5]=$Observaciones;
                        
            $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
            $idComprobante=$this->ObtenerMAX($tab, "ID", 1, "");
            return $idComprobante;
        }
        
        public function CrearDocumentoContable($idDocumento,$Fecha, $Descripcion,$idUser,$Vector ) {
        
            $Consecutivo=$this->ObtenerMAX("documentos_contables_control", "Consecutivo", "idDocumento", $idDocumento);   
            $Consecutivo=$Consecutivo+1;

            $tab="documentos_contables_control";        
            $NumRegistros=6; 

            $Columnas[0]="idDocumento";     $Valores[0]=$idDocumento;
            $Columnas[1]="Fecha";           $Valores[1]=$Fecha;
            $Columnas[2]="Consecutivo";     $Valores[2]=$Consecutivo;
            $Columnas[3]="Descripcion";     $Valores[3]=$Descripcion;
            $Columnas[4]="Estado";          $Valores[4]="Abierto";
            $Columnas[5]="idUser";          $Valores[5]=$idUser;

            $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
            $idComprobante=$this->ObtenerMAX($tab, "ID", 1, "");
            return $idComprobante;
        }
        
        public function IngreseMovimientoDocumentoContable($Fecha,$idComprobante,$NombreDocumento, $Consecutivo,$CentroCosto,$Tercero, $CuentaPUC,$Debito,$Credito,$Concepto,$NumDocSoporte,$destino,$NombreCuenta,$Vector ) {
        
            $tab="documentos_contables_items";
            $NumRegistros=13;

            $Columnas[0]="Fecha";			$Valores[0]=$Fecha;
            $Columnas[1]="CentroCostos";		$Valores[1]=$CentroCosto;
            $Columnas[2]="Tercero";			$Valores[2]=$Tercero;
            $Columnas[3]="CuentaPUC";		$Valores[3]=$CuentaPUC;
            $Columnas[4]="Debito";			$Valores[4]=$Debito;
            $Columnas[5]="Credito";                 $Valores[5]=$Credito;
            $Columnas[6]="Concepto";                $Valores[6]=$Concepto;
            $Columnas[7]="NumDocSoporte";		$Valores[7]=$NumDocSoporte;
            $Columnas[8]="Soporte";			$Valores[8]=$destino;
            $Columnas[9]="idDocumento";		$Valores[9]=$idComprobante;
            $Columnas[10]="NombreCuenta";		$Valores[10]=$NombreCuenta;
            $Columnas[11]="Numero_Documento";	$Valores[11]=$Consecutivo;
            $Columnas[12]="Nombre_Documento";	$Valores[12]=$NombreDocumento;

            $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
        }
        
        //Registra un comprobante contable
    public function GuardeDocumentoContable($idComprobante){
        
        $DatosSucursal=  $this->DevuelveValores("empresa_pro_sucursales", "Actual", 1); 
        $DatosGenerales=$this->DevuelveValores("documentos_contables_control","ID",$idComprobante);
        $Consulta=$this->ConsultarTabla("documentos_contables_items", "WHERE idDocumento=$idComprobante");
        while($DatosComprobante=$this->FetchArray($Consulta)){
            $Fecha=$DatosComprobante["Fecha"];
            
            $tab="librodiario";
            $NumRegistros=28;
            $CuentaPUC=$DatosComprobante["CuentaPUC"];
            $NombreCuenta=$DatosComprobante["NombreCuenta"];
            $DatosCliente=$this->DevuelveValores("proveedores", "Num_Identificacion", $DatosComprobante["Tercero"]);
            if($DatosCliente["Num_Identificacion"]==''){
                $DatosCliente=$this->DevuelveValores("clientes", "Num_Identificacion", $DatosComprobante["Tercero"]);
            
            }
            $DatosCentro=$this->DevuelveValores("centrocosto", "ID", $DatosComprobante["CentroCostos"]);
            
            $Columnas[0]="Fecha";			$Valores[0]=$Fecha;
            $Columnas[1]="Tipo_Documento_Intero";	$Valores[1]=$DatosComprobante["Nombre_Documento"];
            $Columnas[2]="Num_Documento_Interno";	$Valores[2]=$DatosComprobante["Numero_Documento"];
            $Columnas[3]="Tercero_Tipo_Documento";	$Valores[3]=$DatosCliente['Tipo_Documento'];
            $Columnas[4]="Tercero_Identificacion";	$Valores[4]=$DatosCliente['Num_Identificacion'];
            $Columnas[5]="Tercero_DV";                  $Valores[5]=$DatosCliente['DV'];
            $Columnas[6]="Tercero_Primer_Apellido";	$Valores[6]=$DatosCliente['Primer_Apellido'];
            $Columnas[7]="Tercero_Segundo_Apellido";    $Valores[7]=$DatosCliente['Segundo_Apellido'];
            $Columnas[8]="Tercero_Primer_Nombre";	$Valores[8]=$DatosCliente['Primer_Nombre'];
            $Columnas[9]="Tercero_Otros_Nombres";	$Valores[9]=$DatosCliente['Otros_Nombres'];
            $Columnas[10]="Tercero_Razon_Social";	$Valores[10]=$DatosCliente['RazonSocial'];
            $Columnas[11]="Tercero_Direccion";          $Valores[11]=$DatosCliente['Direccion'];
            $Columnas[12]="Tercero_Cod_Dpto";           $Valores[12]=$DatosCliente['Cod_Dpto'];
            $Columnas[13]="Tercero_Cod_Mcipio";         $Valores[13]=$DatosCliente['Cod_Mcipio'];
            $Columnas[14]="Tercero_Pais_Domicilio";     $Valores[14]=$DatosCliente['Pais_Domicilio'];

            $Columnas[15]="CuentaPUC";                  $Valores[15]=$CuentaPUC;
            $Columnas[16]="NombreCuenta";		$Valores[16]=$NombreCuenta;
            $Columnas[17]="Detalle";                    $Valores[17]=$DatosGenerales["Concepto"];
            $Columnas[18]="Debito";			$Valores[18]=$DatosComprobante["Debito"];
            $Columnas[19]="Credito";                    $Valores[19]=$DatosComprobante["Credito"];
            $Columnas[20]="Neto";			$Valores[20]=$Valores[18]-$Valores[19];
            $Columnas[21]="Mayor";			$Valores[21]="NO";
            $Columnas[22]="Esp";			$Valores[22]="NO";
            $Columnas[23]="Concepto";                   $Valores[23]=$DatosComprobante["Concepto"];
            $Columnas[24]="idCentroCosto";		$Valores[24]=$DatosComprobante["CentroCostos"];
            $Columnas[25]="idEmpresa";                  $Valores[25]=$DatosCentro["EmpresaPro"];
            $Columnas[26]="idSucursal";                 $Valores[26]=$DatosSucursal["ID"];
            $Columnas[27]="Num_Documento_Externo";      $Valores[27]=$DatosComprobante["NumDocSoporte"];
            $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
            
            
        }
        $this->ActualizaRegistro("documentos_contables_control", "Estado", "Cerrado", "ID", $idComprobante);
    }
    //Fin Clases
}