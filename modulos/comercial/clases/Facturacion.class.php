<?php
if(file_exists("../../../modelo/php_conexion.php")){
    include_once("../../../modelo/php_conexion.php");
}

class Facturacion extends ProcesoVenta{
    /**
     * Crear una factura
     * @param type $idFactura -> identificador de la factura
     * @param type $Fecha
     * @param type $Hora
     * @param type $idResolucion
     * @param type $TipoFactura     -> Tipo de Factura según Resolucion
     * @param type $Prefijo         ->Prefijo de la Factura
     * @param type $NumeroFactura   ->Numero de la factura
     * @param type $OrdenCompra
     * @param type $OrdenSalida
     * @param type $FormaPago       ->Si es de contado, a credito, sistecredito, 
     * @param type $Subtotal
     * @param type $IVA
     * @param type $Total
     * @param type $Descuentos
     * @param type $SaldoFactura    
     * @param type $idCotizacion    ->Si viene de una cotizacion
     * @param type $idEmpresa       ->Empresa a la que pertecene la factura
     * @param type $idCentroCostos  ->Centro de costos
     * @param type $idSucursal      ->Sucursal de la factura    
     * @param type $idUsuario       ->id del Usuario
     * @param type $idCliente
     * @param type $TotalCostos     ->Total costos de la factura
     * @param type $Observaciones   ->Observaciones de la factura
     * @param type $Efectivo        ->Con cuanto en efectivo se pagó
     * @param type $Devuelta        ->Cuanto devuelve
     * @param type $Cheques         ->Cuanto se pagó en cheques
     * @param type $Otros           ->En bonos u otros
     * @param type $Tarjetas        ->Cuanto en tarjeta de credito
     * @param type $idTarjetas      ->El tipo de tarjeta proveniente de tarjetas tipo
     * @param type $ReportarFacturaElectronica -> 0 para reportar a factura electronica 1 para no
     * @param type $Vector
     */
    public function CrearFactura($idFactura,$Fecha,$Hora,$idResolucion,$OrdenCompra,$OrdenSalida,$FormaPago,$Subtotal,$IVA,$Total,$Descuentos,$SaldoFactura,$idCotizacion,$idEmpresa,$idCentroCostos,$idSucursal,$idUsuario,$idCliente,$TotalCostos,$Observaciones,$Efectivo,$Devuelta,$Cheques,$Otros,$Tarjetas,$idTarjetas,$ReportarFacturaElectronica,$Vector) {
        
        $DatosResolucion=$this->ValorActual("empresapro_resoluciones_facturacion", "Estado,Completada,Prefijo,Tipo,Desde,Hasta", " ID='$idResolucion'");        
        $Disponibilidad=$DatosResolucion["Estado"];
        if($DatosResolucion["Completada"]=="SI"){
            return("E1"); //Error 1, la resolucion ya fue completada
        }
        if($DatosResolucion["Estado"]=="OC"){
            return("E2"); //Error 2, resolucion ocupada
        }
        $this->ActualizaRegistro("empresapro_resoluciones_facturacion", "Estado", "OC", "ID", $idResolucion);
        $NumeroFactura=$this->ObtenerMAX("facturas", "NumeroFactura", "idResolucion", $idResolucion);
        $NumeroFactura++;
        if($NumeroFactura==1){ //Se verifica si es la primer factura
            $NumeroFactura=$DatosResolucion["Desde"];
        }
        if($NumeroFactura>$DatosResolucion["Hasta"]){
            $this->ActualizaRegistro("empresapro_resoluciones_facturacion", "Estado", "", "ID", $idResolucion);
            $this->ActualizaRegistro("empresapro_resoluciones_facturacion", "Completada", "SI", "ID", $idResolucion);
            return("E1"); //Error 1, resolucion Completa
           
        }
        if($NumeroFactura==$DatosResolucion["Hasta"]){
            $this->ActualizaRegistro("empresapro_resoluciones_facturacion", "Completada", "SI", "ID", $idResolucion);
        }
        
        $Prefijo=$DatosResolucion["Prefijo"];
        $TipoFactura=$DatosResolucion["Tipo"];
        
        $Datos["idFacturas"]=$idFactura;
        $Datos["idResolucion"]=$idResolucion;
        $Datos["TipoFactura"]=$TipoFactura;
        $Datos["Prefijo"]=$Prefijo;
        $Datos["NumeroFactura"]=$NumeroFactura;
        $Datos["Fecha"]=$Fecha;
        $Datos["Hora"]=$Hora;
        $Datos["OCompra"]=$OrdenCompra;
        $Datos["OSalida"]=$OrdenSalida;
        $Datos["FormaPago"]=$FormaPago;
        $Datos["Subtotal"]=$Subtotal;
        $Datos["IVA"]=$IVA;
        $Datos["Descuentos"]=$Descuentos;
        $Datos["Total"]=$Total;
        $Datos["SaldoFact"]=$SaldoFactura;
        $Datos["Cotizaciones_idCotizaciones"]=$idCotizacion;
        $Datos["EmpresaPro_idEmpresaPro"]=$idEmpresa;
        $Datos["CentroCosto"]=$idCentroCostos;
        $Datos["idSucursal"]=$idSucursal;
        $Datos["Usuarios_idUsuarios"]=$idUsuario;
        $Datos["Clientes_idClientes"]=$idCliente;
        $Datos["TotalCostos"]=$TotalCostos;
        $Datos["ObservacionesFact"]=$Observaciones;
        $Datos["Efectivo"]=$Efectivo;
        $Datos["Devuelve"]=$Devuelta;        
        $Datos["Cheques"]=$Cheques;
        $Datos["Otros"]=$Otros;
        $Datos["Tarjetas"]=$Tarjetas;
        $Datos["ReporteFacturaElectronica"]=$ReportarFacturaElectronica;
        
        $sql= $this->getSQLInsert("facturas", $Datos);
        $this->Query($sql);
        $this->ActualizaRegistro("empresapro_resoluciones_facturacion", "Estado", "", "ID", $idResolucion);
        return($NumeroFactura);
    }
    /**
     * Crea un id único para una factura
     * @return type
     */
    public function idFactura() {
        $ID=date("YmdHis").microtime(false);
        $ID= str_replace(" ", "_", $ID);
        $ID= str_replace(".", "_", $ID);
        return($ID);
    }
    
    /**
     * Copia los items de una cotizacion a una factura
     * @param type $idCotizacion
     * @param type $idFactura
     * @param type $FechaFactura
     * @param type $Vector
     */
    
    public function CopiarItemsCotizacionAItemsFactura($idCotizacion,$idFactura,$FechaFactura,$idUsuario,$Vector) {
        
        $sql="INSERT INTO facturas_items (FechaFactura,idFactura, TablaItems,Referencia,Nombre,ValorUnitarioItem,Cantidad,Dias,SubtotalItem,IVAItem,TotalItem,Departamento,SubGrupo1,SubGrupo2,SubGrupo3,SubGrupo4,SubGrupo5,PorcentajeIVA,idPorcentajeIVA,PrecioCostoUnitario,SubtotalCosto,TipoItem,CuentaPUC,GeneradoDesde,NumeroIdentificador,idUsuarios) 
            SELECT '$FechaFactura','$idFactura', TablaOrigen,Referencia,Descripcion,ValorUnitario,Cantidad,Multiplicador,Subtotal,IVA,Total,Departamento,SubGrupo1,SubGrupo2,SubGrupo3,SubGrupo4,SubGrupo5,PorcentajeIVA,idPorcentajeIVA,PrecioCosto,SubtotalCosto,TipoItem,CuentaPUC,'cotizacionesv5','$idCotizacion','$idUsuario'
            FROM cot_itemscotizaciones WHERE NumCotizacion='$idCotizacion'";
        $this->Query($sql);
        
    }
    
    /**
     * Ingresa una factura a la cartera
     * @param type $idFactura
     * @param type $Fecha
     * @param type $idCliente
     * @param type $CmbFormaPago -> trae el numero de dias que tiene de plazo la factura
     * @param type $SaldoFactura -> El saldo con el que ingresará a cartera
     * @param type $Vector
     */    
    public function IngreseCartera($idFactura,$Fecha,$idCliente,$CmbFormaPago,$SaldoFactura,$Vector) {
        
        $SumaDias=$CmbFormaPago;        
        if($CmbFormaPago=="SisteCredito"){
            $SumaDias=30;
            $Datos["SisteCredito"]=1;
        }
           
        $Datos["Fecha"]=$Fecha; 
        $Datos["Dias"]=$SumaDias;
        $FechaVencimiento=$this->SumeDiasFecha($Datos);
        $Datos["idFactura"]=$idFactura; 
        $Datos["FechaFactura"]=$Fecha; 
        $Datos["FechaVencimiento"]=$FechaVencimiento;
        $Datos["idCliente"]=$idCliente;
        $Datos["SaldoFactura"]=$SaldoFactura;
        if($SaldoFactura>0){
            $this->InsertarFacturaEnCartera($Datos);///Inserto La factura en la cartera
        }
        
            
    }
    
    /**
     * Cruza un anticipo en una factura
     * @param type $idFactura
     * @param type $Fecha
     * @param type $ValorAnticipo
     * @param type $CuentaDestino        ->Podrá ser la cuenta de clientes (Si es a credito) o la que cuenta donde ingrese el dinero recibido para el caso de ser de contado
     * @param type $NombreCuentaDestino
     * @param type $vector
     */
    public function CruzarAnticipoAFactura($idFactura,$Fecha,$ValorAnticipo,$CuentaDestino,$NombreCuentaDestino,$vector) {
        
        $DatosFactura=$this->DevuelveValores("facturas", "idFacturas", $idFactura);
        $DatosCliente=$this->DevuelveValores("clientes", "idClientes", $DatosFactura["Clientes_idClientes"]);
        $ParametrosAnticipos=$this->DevuelveValores("parametros_contables", "ID", 20);
        $this->IngreseMovimientoLibroDiario($Fecha, "FACTURA", $idFactura, "", $DatosCliente["Num_Identificacion"], $CuentaDestino, $NombreCuentaDestino, "Cruce de Anticipos", "CR", $ValorAnticipo, "Cruce Anticipos Relaizados por Clientes", $DatosFactura["CentroCosto"], $DatosFactura["idSucursal"], "");
        $this->IngreseMovimientoLibroDiario($Fecha, "FACTURA", $idFactura, "", $DatosCliente["Num_Identificacion"], $ParametrosAnticipos["CuentaPUC"], $ParametrosAnticipos["NombreCuenta"], "Cruce de Anticipos", "DB", $ValorAnticipo, "Cruce Anticipos Relaizados por Clientes", $DatosFactura["CentroCosto"], $DatosFactura["idSucursal"], "");
        
        $NuevoSaldo=$DatosFactura["SaldoFact"]-$ValorAnticipo;
        $AbonosTotales=$DatosFactura["Total"]-$NuevoSaldo;
        $this->ActualizaRegistro("facturas", "SaldoFact", $NuevoSaldo, "idFacturas", $idFactura);
        $this->ActualizaRegistro("cartera", "Saldo", $NuevoSaldo, "Facturas_idFacturas", $idFactura);
        $this->ActualizaRegistro("cartera", "TotalAbonos", $AbonosTotales, "Facturas_idFacturas", $idFactura);
        
    }
        
    /**
     * Fin Clase
     */
}
