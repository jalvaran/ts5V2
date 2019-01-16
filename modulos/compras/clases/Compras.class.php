<?php
if(file_exists("../../../modelo/php_conexion.php")){
    include_once("../../../modelo/php_conexion.php");
}

class Compras extends ProcesoVenta{
    /**
     * Crea una compra
     * @param type $Fecha
     * @param type $idTercero
     * @param type $Observaciones
     * @param type $CentroCostos
     * @param type $idSucursal
     * @param type $idUser
     * @param type $TipoCompra
     * @param type $NumeroFactura
     * @param type $Concepto
     * @param type $Vector
     * @return type
     */
    public function CrearCompra($Fecha, $idTercero, $Observaciones,$CentroCostos, $idSucursal, $idUser,$TipoCompra,$NumeroFactura,$Concepto,$Vector ) {
        
        //////Creo la compra            
        $tab="factura_compra";
        $NumRegistros=11;

        $Columnas[0]="Fecha";		$Valores[0]=$Fecha;
        $Columnas[1]="Tercero";         $Valores[1]=$idTercero;
        $Columnas[2]="Observaciones";   $Valores[2]=$Observaciones;
        $Columnas[3]="Estado";		$Valores[3]="ABIERTA";
        $Columnas[4]="idUsuario";	$Valores[4]=$idUser;
        $Columnas[5]="idCentroCostos";	$Valores[5]=$CentroCostos;
        $Columnas[6]="idSucursal";	$Valores[6]=$idSucursal;
        $Columnas[7]="TipoCompra";	$Valores[7]=$TipoCompra;
        $Columnas[8]="NumeroFactura";	$Valores[8]=$NumeroFactura;
        $Columnas[9]="Soporte";         $Valores[9]="";
        $Columnas[10]="Concepto";        $Valores[10]=$Concepto;
        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);

        $idCompra=$this->ObtenerMAX($tab,"ID", 1,"");
        
        //Miro si se recibe un archivo
        //
        $destino="";
        $Atras="";
        $carpeta="";
        if(!empty($_FILES['Soporte']['name'])){
            //echo "<script>alert ('entra foto')</script>";
            $Atras="../";
            $carpeta="soportes/";
            opendir($Atras.$carpeta);
            $Name=$idCompra."_".str_replace(' ','_',$_FILES['Soporte']['name']);
            $destino=$carpeta.$Name;
            move_uploaded_file($_FILES['Soporte']['tmp_name'],$Atras.$destino);
	}
        $this->ActualizaRegistro("factura_compra", "Soporte", $destino, "ID", $idCompra);
        return $idCompra;
    }
    
    //Clase para agregar un item a una compra
    public function AgregueProductoCompra($idCompra,$idProducto,$Cantidad,$CostoUnitario,$TipoIVA,$IVAIncluido,$Vector) {
        
        $DatosTipoImpuesto= $this->DevuelveValores("porcentajes_iva", "ID", $TipoIVA);
        $TipoIVA=$DatosTipoImpuesto["Valor"];
        if($IVAIncluido==1){
            if(is_numeric($TipoIVA)){
                $CostoUnitario=round($CostoUnitario/(1+$TipoIVA),2);
            }            
        }
        $Subtotal= round($CostoUnitario*$Cantidad,2);
        if(is_numeric($TipoIVA)){
            $Impuestos=round($Subtotal*$TipoIVA,2);
        }else{
            $Impuestos=0;
        }
        $Total=round($Subtotal+$Impuestos,2);
        //////Agrego el registro           
        $tab="factura_compra_items";
        $NumRegistros=8;

        $Columnas[0]="idFacturaCompra";     $Valores[0]=$idCompra;
        $Columnas[1]="idProducto";          $Valores[1]=$idProducto;
        $Columnas[2]="Cantidad";            $Valores[2]=$Cantidad;
        $Columnas[3]="CostoUnitarioCompra"; $Valores[3]=$CostoUnitario;
        $Columnas[4]="SubtotalCompra";      $Valores[4]=$Subtotal;
        $Columnas[5]="ImpuestoCompra";      $Valores[5]=$Impuestos;
        $Columnas[6]="TotalCompra";         $Valores[6]=$Total;
        $Columnas[7]="Tipo_Impuesto";       $Valores[7]=$TipoIVA;
                    
        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
    }
    
    //Clase para agregar un insumo a una compra
    public function AgregueInsumoCompra($idCompra,$idProducto,$Cantidad,$CostoUnitario,$TipoIVA,$IVAIncluido,$Vector) {
        $DatosTipoImpuesto= $this->DevuelveValores("porcentajes_iva", "ID", $TipoIVA);
        $TipoIVA=$DatosTipoImpuesto["Valor"];
        if($IVAIncluido==1){
            if(is_numeric($TipoIVA)){
                $CostoUnitario=round($CostoUnitario/(1+$TipoIVA),2);
            }            
        }
        $Subtotal= round($CostoUnitario*$Cantidad,2);
        if(is_numeric($TipoIVA)){
            $Impuestos=round($Subtotal*$TipoIVA,2);
        }else{
            $Impuestos=0;
        }
        $Total=round($Subtotal+$Impuestos,2);
        //////Agrego el registro           
        $tab="factura_compra_insumos";
        $NumRegistros=8;

        $Columnas[0]="idFacturaCompra";     $Valores[0]=$idCompra;
        $Columnas[1]="idProducto";          $Valores[1]=$idProducto;
        $Columnas[2]="Cantidad";            $Valores[2]=$Cantidad;
        $Columnas[3]="CostoUnitarioCompra"; $Valores[3]=$CostoUnitario;
        $Columnas[4]="SubtotalCompra";      $Valores[4]=$Subtotal;
        $Columnas[5]="ImpuestoCompra";      $Valores[5]=$Impuestos;
        $Columnas[6]="TotalCompra";         $Valores[6]=$Total;
        $Columnas[7]="Tipo_Impuesto";       $Valores[7]=$TipoIVA;
                    
        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
    }
    
    //Agregar Un Servicio
    public function AgregueServicioCompra($idCompra,$CuentaPUC,$Concepto,$CostoUnitario,$TipoIVA,$IVAIncluido,$Vector) {
        $DatosTipoImpuesto= $this->DevuelveValores("porcentajes_iva", "ID", $TipoIVA);
        $TipoIVA=$DatosTipoImpuesto["Valor"];
        $DatosCuenta= $this->DevuelveValores("subcuentas", "PUC", $CuentaPUC);
        if($IVAIncluido==1){
            if(is_numeric($TipoIVA)){
                $CostoUnitario=round($CostoUnitario/(1+$TipoIVA),2);
            }            
        }
        $Subtotal= round($CostoUnitario,2);
        if(is_numeric($TipoIVA)){
            $Impuestos=round($Subtotal*$TipoIVA,2);
        }else{
            $Impuestos=0;
        }
        $Total=round($Subtotal+$Impuestos,2);
        
        //////Agrego el registro           
        $tab="factura_compra_servicios";
        $NumRegistros=8;

        $Columnas[0]="idFacturaCompra";     $Valores[0]=$idCompra;
        $Columnas[1]="CuentaPUC_Servicio";  $Valores[1]=$CuentaPUC;
        $Columnas[2]="Nombre_Cuenta";       $Valores[2]=$DatosCuenta["Nombre"];
        $Columnas[3]="Concepto_Servicio";   $Valores[3]=$Concepto;
        $Columnas[4]="Subtotal_Servicio";   $Valores[4]=$Subtotal;
        $Columnas[5]="Impuesto_Servicio";   $Valores[5]=$Impuestos;
        $Columnas[6]="Total_Servicio";      $Valores[6]=$Total;
        $Columnas[7]="Tipo_Impuesto";       $Valores[7]=$TipoIVA;
                    
        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
    }
    
    //Clase para devolver un item a una compra
    public function DevolverProductoCompra($Cantidad,$idFacturaItems,$Vector) {
        //Proceso la informacion
        $DatosFacturaItems= $this->DevuelveValores("factura_compra_items", "ID", $idFacturaItems);
        $idCompra=$DatosFacturaItems["idFacturaCompra"];
        $idProducto=$DatosFacturaItems["idProducto"];
        $CostoUnitario=$DatosFacturaItems["CostoUnitarioCompra"];
        $TipoIVA=$DatosFacturaItems["Tipo_Impuesto"];
        $Subtotal=round($CostoUnitario*$Cantidad);
        $Impuestos= round($Subtotal*$TipoIVA);
        $Total=$Subtotal+$Impuestos;
        //////Agrego el registro           
        $tab="factura_compra_items_devoluciones";
        $NumRegistros=8;

        $Columnas[0]="idFacturaCompra";     $Valores[0]=$idCompra;
        $Columnas[1]="idProducto";          $Valores[1]=$idProducto;
        $Columnas[2]="Cantidad";            $Valores[2]=$Cantidad;
        $Columnas[3]="CostoUnitarioCompra"; $Valores[3]=$CostoUnitario;
        $Columnas[4]="SubtotalCompra";      $Valores[4]=$Subtotal;
        $Columnas[5]="ImpuestoCompra";      $Valores[5]=$Impuestos;
        $Columnas[6]="TotalCompra";         $Valores[6]=$Total;
        $Columnas[7]="Tipo_Impuesto";       $Valores[7]=$TipoIVA;
                    
        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
    }
    
    
    //Calcule totales de la compra
    
    public function CalculeTotalesCompra($idCompra) {
        $sql="SELECT SUM(SubtotalDescuento) as SubtotalDescuento,SUM(SubtotalCompra) as Subtotal, sum(ImpuestoCompra) as IVA, SUM(TotalCompra) AS Total FROM factura_compra_items "
                    . " WHERE idFacturaCompra='$idCompra'";
        $consulta= $this->Query($sql);
        $TotalesCompraProductos=$this->FetchArray($consulta);
        
        $sql="SELECT SUM(SubtotalDescuento) as SubtotalDescuento,SUM(SubtotalCompra) as Subtotal, sum(ImpuestoCompra) as IVA, SUM(TotalCompra) AS Total FROM factura_compra_insumos "
                    . " WHERE idFacturaCompra='$idCompra'";
        $consulta= $this->Query($sql);
        $TotalesCompraInsumos=$this->FetchArray($consulta);
        
        $sql="SELECT SUM(SubtotalCompra) as Subtotal, sum(ImpuestoCompra) as IVA, SUM(TotalCompra) AS Total FROM factura_compra_items_devoluciones "
                    . " WHERE idFacturaCompra='$idCompra'";
        $consulta= $this->Query($sql);
        $TotalesItemsDevueltos=$this->FetchArray($consulta);
        $TotalRetenciones= $this->SumeColumna("factura_compra_retenciones", "ValorRetencion", "idCompra", $idCompra);
        
        $sql="SELECT SUM(Subtotal_Servicio) as Subtotal, sum(Impuesto_Servicio) as IVA, SUM(Total_Servicio) AS Total FROM factura_compra_servicios "
                    . " WHERE idFacturaCompra='$idCompra'";
        $consulta= $this->Query($sql);
        $TotalesServicios=$this->FetchArray($consulta);
        $TotalesCompra["Subtotal_Productos_Add"]=$TotalesCompraProductos["Subtotal"];
        $TotalesCompra["Impuestos_Productos_Add"]=$TotalesCompraProductos["IVA"];
        $TotalesCompra["Total_Productos_Add"]=$TotalesCompraProductos["Total"];
        $TotalesCompra["Subtotal_Descuentos_Productos_Add"]=$TotalesCompraProductos["SubtotalDescuento"];
        
        $TotalesCompra["Subtotal_Insumos"]=$TotalesCompraInsumos["Subtotal"];
        $TotalesCompra["Impuestos_Insumos"]=$TotalesCompraInsumos["IVA"];
        $TotalesCompra["Total_Insumos"]=$TotalesCompraInsumos["Total"];
        $TotalesCompra["Subtotal_Descuentos_Insumos"]=$TotalesCompraInsumos["SubtotalDescuento"];
        
        $TotalesCompra["Subtotal_Servicios"]=$TotalesServicios["Subtotal"];
        $TotalesCompra["Impuestos_Servicios"]=$TotalesServicios["IVA"];
        $TotalesCompra["Total_Servicios"]=$TotalesServicios["Total"];
        $TotalesCompra["Total_Retenciones"]=$TotalRetenciones;
        $TotalesCompra["Subtotal_Productos_Dev"]=$TotalesItemsDevueltos["Subtotal"];
        $TotalesCompra["Impuestos_Productos_Dev"]=$TotalesItemsDevueltos["IVA"];
        $TotalesCompra["Total_Productos_Dev"]=$TotalesItemsDevueltos["Total"];
        $TotalesCompra["Subtotal_Productos"]=$TotalesCompra["Subtotal_Productos_Add"]-$TotalesCompra["Subtotal_Productos_Dev"];
        $TotalesCompra["Impuestos_Productos"]=$TotalesCompra["Impuestos_Productos_Add"]-$TotalesCompra["Impuestos_Productos_Dev"];
        $TotalesCompra["Total_Productos"]=$TotalesCompra["Total_Productos_Add"]-$TotalesCompra["Total_Productos_Dev"];
        $TotalesCompra["Gran_Subtotal"]=$TotalesCompra["Subtotal_Productos"]+$TotalesCompra["Subtotal_Servicios"]+$TotalesCompra["Subtotal_Insumos"];
        $TotalesCompra["Gran_Impuestos"]=$TotalesCompra["Impuestos_Productos"]+$TotalesCompra["Impuestos_Servicios"]+$TotalesCompra["Impuestos_Insumos"];
        $TotalesCompra["Gran_Total"]=$TotalesCompra["Total_Productos"]+$TotalesCompra["Total_Servicios"]+$TotalesCompra["Total_Insumos"];
        $TotalesCompra["Total_Pago"]=$TotalesCompra["Gran_Total"]-$TotalesCompra["Total_Retenciones"];
        return($TotalesCompra);
    }
    
    //Clase para agregar un item a una compra
    public function AgregueRetencionCompra($idCompra,$Cuenta,$Valor,$Porcentaje,$Vector) {
        //Proceso la informacion
        $DatosCuentas= $this->DevuelveValores("subcuentas", "PUC", $Cuenta);
        //////Agrego el registro           
        $tab="factura_compra_retenciones";
        $NumRegistros=5;

        $Columnas[0]="idCompra";            $Valores[0]=$idCompra;
        $Columnas[1]="CuentaPUC";           $Valores[1]=$Cuenta;
        $Columnas[2]="NombreCuenta";        $Valores[2]=$DatosCuentas["Nombre"];
        $Columnas[3]="ValorRetencion";      $Valores[3]=$Valor;
        $Columnas[4]="PorcentajeRetenido";  $Valores[4]=$Porcentaje;       
                            
        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
    }
    
    //Clase para agregar un item a una compra
    public function AgregueDescuentoCompra($idCompra,$Cuenta,$Valor,$Porcentaje,$Vector) {
        //Proceso la informacion
        $DatosCuentas= $this->DevuelveValores("subcuentas", "PUC", $Cuenta);
        //////Agrego el registro           
        $tab="factura_compra_descuentos";
        $NumRegistros=5;

        $Columnas[0]="idCompra";                $Valores[0]=$idCompra;
        $Columnas[1]="CuentaPUCDescuento";      $Valores[1]=$Cuenta;
        $Columnas[2]="NombreCuentaDescuento";   $Valores[2]=$DatosCuentas["Nombre"];
        $Columnas[3]="ValorDescuento";          $Valores[3]=$Valor;
        $Columnas[4]="PorcentajeDescuento";     $Valores[4]=$Porcentaje;       
                            
        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
    }
    
    //Clase para agregar un item a una compra
    public function AgregueImpuestoAdicionalCompra($idCompra,$Cuenta,$Valor,$Porcentaje,$Vector) {
        //Proceso la informacion
        $DatosCuentas= $this->DevuelveValores("subcuentas", "PUC", $Cuenta);
        //////Agrego el registro           
        $tab="factura_compra_impuestos_adicionales";
        $NumRegistros=5;

        $Columnas[0]="idCompra";       $Valores[0]=$idCompra;
        $Columnas[1]="CuentaPUC";      $Valores[1]=$Cuenta;
        $Columnas[2]="NombreCuenta";   $Valores[2]=$DatosCuentas["Nombre"];
        $Columnas[3]="Valor";          $Valores[3]=$Valor;
        $Columnas[4]="Porcentaje";     $Valores[4]=$Porcentaje;       
                            
        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
    }
    /**
     * Fin Clase
     */
}
