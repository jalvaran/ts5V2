<?php

/* 
 * Clase donde se realizaran procesos para construir recetas
 * Julian Alvaran
 * Techno Soluciones SAS
 * 2018-09-26
 */
        
class Nomina extends ProcesoVenta{
    
    /**
     * Agrega turnos a una nomina basica
     * @param type $Fecha
     * @param type $idTercero
     * @param type $idSede
     * @param type $Valor
     * @param type $idUser
     * @param type $Vector
     */
    public function AgregarTurnoNominaBasica($Fecha,$idTercero,$idSede,$Valor,$idUser, $Vector) {
        
        $Datos["Tercero"]=$idTercero;
        $Datos["Fecha"]=$Fecha;
        $Datos["Sucursal"]=$idSede;
        $Datos["Valor"]=$Valor;
        $Datos["idUser"]=$idUser;
        $sql=$this->getSQLInsert("nomina_servicios_turnos", $Datos);
        $this->Query($sql);

        
    }
    
    public function NominaCrearDocumentoEquivalente($Fecha,$Tercero,$Concepto,$CuentaOrigen,$Sucursal,$Valor,$ReteFuente,$ReteICA,$idUser, $Vector) {
        
        $Datos["Tercero"]=$Tercero;
        $Datos["Fecha"]=$Fecha;
        $Datos["Concepto"]=$Concepto;
        $Datos["Valor"]=$Valor;
        $Datos["Sucursal"]=$Sucursal;
        $Datos["idUser"]=$idUser;
        $sql=$this->getSQLInsert("nomina_documentos_equivalentes", $Datos);
        $this->Query($sql);
        
        $idDocumento=$this->ObtenerMAX("nomina_documentos_equivalentes","ID", 1,"");
        
        $ValorRetefuente=0;
        $ValorReteICA=0;
        if($ReteFuente=='SI'){
            $DatosParametros= $this->DevuelveValores("nomina_parametros_generales", "ID", 4);//Obtengo el tope de retefuente del valor por servicios
            if($Valor>=$DatosParametros["Valor"]){
                $DatosParametros= $this->DevuelveValores("nomina_parametros_generales", "ID", 3);
                $ValorRetefuente=round($Valor*$DatosParametros["Valor"],2);
            }
            
        }
        
        if($ReteICA=='SI'){
            $DatosParametros= $this->DevuelveValores("nomina_parametros_generales", "ID", 2);//Obtengo el tope de reteica del valor por servicios
            if($Valor>=$DatosParametros["Valor"]){
                $DatosParametros= $this->DevuelveValores("nomina_parametros_generales", "ID", 1);
                $ValorReteICA=round($Valor*$DatosParametros["Valor"],2);
            }
            
        }
        
        //Causo el gasto
        $ParametrosContables= $this->DevuelveValores("nomina_parametros_contables", "ID", 1);
        
        $NombreCuenta=$ParametrosContables["NombreCuenta"];
        $CuentaPUC=$ParametrosContables["CuentaPUC"];
        $Monto=$Valor;
        $TipoMovimiento="DB";
        $this->IngreseMovimientoLibroDiario($Fecha, "DOC_EQUI_NOMINA", $idDocumento, "", $Tercero, $CuentaPUC, $NombreCuenta, "NOMINA", $TipoMovimiento, $Monto, $Concepto, 1, $Sucursal, "");
        
        
        //Causo la retefuente
        if($ValorRetefuente>0){
            $ParametrosContables= $this->DevuelveValores("nomina_parametros_contables", "ID", 2);

            $NombreCuenta=$ParametrosContables["NombreCuenta"];
            $CuentaPUC=$ParametrosContables["CuentaPUC"];
            $Monto=$ValorRetefuente;
            $TipoMovimiento="CR";
            $this->IngreseMovimientoLibroDiario($Fecha, "DOC_EQUI_NOMINA", $idDocumento, "", $Tercero, $CuentaPUC, $NombreCuenta, "NOMINA", $TipoMovimiento, $Monto, $Concepto, 1, $Sucursal, "");
        }
        
        //Causo el reteica
        if($ValorReteICA>0){
            $ParametrosContables= $this->DevuelveValores("nomina_parametros_contables", "ID", 4);

            $NombreCuenta=$ParametrosContables["NombreCuenta"];
            $CuentaPUC=$ParametrosContables["CuentaPUC"];
            $Monto=$ValorReteICA;
            $TipoMovimiento="CR";
            $this->IngreseMovimientoLibroDiario($Fecha, "DOC_EQUI_NOMINA", $idDocumento, "", $Tercero, $CuentaPUC, $NombreCuenta, "NOMINA", $TipoMovimiento, $Monto, $Concepto, 1, $Sucursal, "");
        }
        //Causo la cuenta x pagar
        $ParametrosContables= $this->DevuelveValores("nomina_parametros_contables", "ID", 3);

        $NombreCuenta=$ParametrosContables["NombreCuenta"];
        $CuentaPUC=$ParametrosContables["CuentaPUC"];
        $Monto=$Valor-$ValorReteICA-$ValorRetefuente;
        $TipoMovimiento="CR";
        $this->IngreseMovimientoLibroDiario($Fecha, "DOC_EQUI_NOMINA", $idDocumento, "", $Tercero, $CuentaPUC, $NombreCuenta, "NOMINA", $TipoMovimiento, $Monto, $Concepto, 1, $Sucursal, "");
        $TipoMovimiento="DB"; //Cruzo la cuenta x pagar
        $this->IngreseMovimientoLibroDiario($Fecha, "DOC_EQUI_NOMINA", $idDocumento, "", $Tercero, $CuentaPUC, $NombreCuenta, "NOMINA", $TipoMovimiento, $Monto, $Concepto, 1, $Sucursal, "");
        
        //Se retira el dinero contra la cuenta que se haya seleccionado
        
        $DatosSubcuenta= $this->DevuelveValores("subcuentas", "PUC", $CuentaOrigen);    
        $NombreCuenta=$DatosSubcuenta["Nombre"];
        $CuentaPUC=$CuentaOrigen;
        $Monto=$Valor-$ValorReteICA-$ValorRetefuente;
        $TipoMovimiento="CR";
        $this->IngreseMovimientoLibroDiario($Fecha, "DOC_EQUI_NOMINA", $idDocumento, "", $Tercero, $CuentaPUC, $NombreCuenta, "NOMINA", $TipoMovimiento, $Monto, $Concepto, 1, $Sucursal, "");
        
        return($idDocumento);
    }
    
    //Fin Clases
}
