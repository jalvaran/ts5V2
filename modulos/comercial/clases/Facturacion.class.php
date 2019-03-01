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
     * Crear una preventa
     * @param type $idUser
     * @param type $TextPreventa
     * @return type
     */
    public function CrearPreventaPOS($idUser,$TextPreventa) {
        
        $Datos["Nombre"]=$TextPreventa;
        $Datos["Usuario_idUsuario"]=$idUser;
        $Datos["Clientes_idClientes"]=1;
        $sql=$this->getSQLInsert("vestasactivas", $Datos);
        $this->Query($sql);
        $idPreventa=$this->ObtenerMAX("vestasactivas", "idVestasActivas", "Usuario_idUsuario", $idUser);
        return($idPreventa);
    }
    /**
     * Obtiene el id de un producto revisando primero los codigos de barras
     * @param type $CodigoBarras
     * @return type
     */
    public function ObtenerIdProducto($CodigoBarras) {
        $sql="SELECT ProductosVenta_idProductosVenta as idProductosVenta FROM prod_codbarras WHERE CodigoBarras='$CodigoBarras' AND TablaOrigen='productosventa'";
        $consulta=$this->Query($sql);
        $DatosProducto=$this->FetchAssoc($consulta);
        if($DatosProducto["idProductosVenta"]==''){
            $idProducto=ltrim($CodigoBarras, "0");
            $sql="SELECT idProductosVenta FROM productosventa WHERE idProductosVenta='$CodigoBarras'";
            $consulta=$this->Query($sql);
            $DatosProducto=$this->FetchArray($consulta);
        }
        $idProducto=$DatosProducto["idProductosVenta"];
        return($idProducto);
    }
    
    public function POS_AgregaItemPreventa($idProducto,$TablaItem,$Cantidad,$idPreventa,$ValorAcordado=0,$idSistema=0) {
        $DatosProductoGeneral=$this->DevuelveValores($TablaItem, "idProductosVenta", $idProducto);
        $CostoUnitario=0;
        $PrecioMayor=0;
        
        if(isset($DatosProductoGeneral["CostoUnitario"])){
            $CostoUnitario=$DatosProductoGeneral["CostoUnitario"];
        }
        
        if(isset($DatosProductoGeneral["PrecioMayorista"])){
            $PrecioMayor=$DatosProductoGeneral["PrecioMayorista"];
        }
        
        $DatosImpuestosAdicionales=$this->DevuelveValores("productos_impuestos_adicionales", "idProducto", $idProducto);
	
        $DatosDepartamento=$this->DevuelveValores("prod_departamentos", "idDepartamentos", $DatosProductoGeneral["Departamento"]);
        $DatosTablaItem=$this->DevuelveValores("tablas_ventas", "NombreTabla", $TablaItem);
        $TipoItem=$DatosDepartamento["TipoItem"];
        $consulta=$this->ConsultarTabla("preventa", "WHERE TablaItem='$TablaItem' AND ProductosVenta_idProductosVenta='$idProducto' AND VestasActivas_idVestasActivas='$idPreventa' AND idSistema='$idSistema' ORDER BY idPrecotizacion DESC");
        $DatosProduto=$this->FetchArray($consulta);
        
        if($DatosProduto["Cantidad"]>0){ //Si ya hay un producto agregado
            if($DatosProductoGeneral["IVA"]=="E"){
                $DatosProductoGeneral["IVA"]=0;
            }
            
            $Cantidad=$DatosProduto["Cantidad"]+$Cantidad;
            $Subtotal=round($DatosProduto["ValorAcordado"]*$Cantidad,2);
            $Impuestos=round($DatosProductoGeneral["IVA"]*$Subtotal+$DatosImpuestosAdicionales["ValorImpuesto"],2);
            $TotalVenta=$Subtotal+$Impuestos;
            $sql="UPDATE preventa SET Subtotal='$Subtotal', Impuestos='$Impuestos', TotalVenta='$TotalVenta', Cantidad='$Cantidad' WHERE idPrecotizacion='$DatosProduto[idPrecotizacion]'";
            
            $this->Query($sql);
        }else{
            $reg=$this->Query("select * from fechas_descuentos where (Departamento = '$DatosProductoGeneral[Departamento]' OR Departamento ='0') AND (Sub1 = '$DatosProductoGeneral[Sub1]' OR Sub1 ='0') AND (Sub2 = '$DatosProductoGeneral[Sub2]' OR Sub2 ='0')  ORDER BY idFechaDescuentos DESC LIMIT 1");
            $reg=$this->FetchArray($reg);
            $Porcentaje=$reg["Porcentaje"];
            $Departamento=$reg["Departamento"];
            $FechaDescuento=$reg["Fecha"];
            if($DatosProductoGeneral["IVA"]=="E"){
                $DatosProductoGeneral["IVA"]=0;
            }
            $impuesto=$DatosProductoGeneral["IVA"];
            $PorcentajeIVA=$impuesto;
            $DatosImpuestosAdicionales["ValorImpuesto"];
            $impuesto=$impuesto+1;
            if($ValorAcordado>0){
                $DatosProductoGeneral["PrecioVenta"]=$ValorAcordado;
            }
            
            // buscar si tiene habilitado precio de descuento 
            
            $DatosFechasPreciosEspeciales= $this->DevuelveValores("ventas_fechas_especiales", "ID", 1);
            
            if($DatosFechasPreciosEspeciales["Habilitado"]==1){
                
                $fecha_inicio=$DatosFechasPreciosEspeciales["FechaInicial"];
                $fecha_fin=$DatosFechasPreciosEspeciales["FechaFinal"];
                $fecha_inicio = strtotime($fecha_inicio);
                $fecha_fin = strtotime($fecha_fin);
                $fecha = strtotime(date("Y-m-d"));
                if(($fecha >= $fecha_inicio) and ($fecha <= $fecha_fin)) {
                    $DatosPreciosEspeciales=$this->DevuelveValores("ventas_fechas_especiales_precios", "Referencia", $DatosProductoGeneral["Referencia"]);
                    
                    if($DatosPreciosEspeciales["PrecioVenta"]<>''){
                        $PrecioEspecial=$DatosPreciosEspeciales["PrecioVenta"];
                        $DatosProductoGeneral["PrecioVenta"]=$PrecioEspecial;
                    }
                }
                
              
            }
            
           
            if($DatosImpuestosAdicionales["Incluido"]=='SI'){
               $DatosProductoGeneral["PrecioVenta"]=$DatosProductoGeneral["PrecioVenta"] - $DatosImpuestosAdicionales["ValorImpuesto"];
            }
            
            if($DatosTablaItem["IVAIncluido"]=="SI"){
                
                $ValorUnitario=round($DatosProductoGeneral["PrecioVenta"]/$impuesto,2);
                
            }else{
                $ValorUnitario=$DatosProductoGeneral["PrecioVenta"];
                
            }
            
            if($Porcentaje>0 and $FechaDescuento==$fecha){

                    $Porcentaje=(100-$Porcentaje)/100;
                    $ValorUnitario=round($ValorUnitario*$Porcentaje,2);

            }
            
            
            
            $Subtotal=$ValorUnitario*$Cantidad;
            //Para colocarle el valor totoal al producto especial
            if(isset($DatosProductoGeneral["Especial"])){
                if($DatosProductoGeneral["Especial"]=="SI"){
                    $Subtotal=$ValorUnitario;
                }
            }
            
            $impuesto=($impuesto-1)*$Subtotal +($DatosImpuestosAdicionales["ValorImpuesto"]*$Cantidad);
            
            
            $Total=$Subtotal+$impuesto;
            
            $Insert["Fecha"]=$fecha;
            $Insert["Cantidad"]=$Cantidad;
            $Insert["VestasActivas_idVestasActivas"]=$idPreventa;
            $Insert["ProductosVenta_idProductosVenta"]=$idProducto;
            $Insert["ValorUnitario"]=$ValorUnitario;
            $Insert["ValorAcordado"]=$ValorUnitario;
            $Insert["Subtotal"]=$Subtotal;
            $Insert["Impuestos"]=$impuesto;
            $Insert["TotalVenta"]=$Total;            
            $Insert["TablaItem"]=$TablaItem;
            $Insert["TipoItem"]=$TipoItem;
            $Insert["CostoUnitario"]=$CostoUnitario;
            $Insert["PrecioMayorista"]=$PrecioMayor;
            $Insert["PorcentajeIVA"]=$PorcentajeIVA;
            $Insert["idSistema"]=$idSistema;
            
            $sql=$this->getSQLInsert("preventa", $Insert);
            
            $this->Query($sql);	
	
        }
        
    }
        
    /**
     * Fin Clase
     */
}
