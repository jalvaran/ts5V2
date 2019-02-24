<?php
if(file_exists("../../../modelo/php_conexion.php")){
    include_once("../../../modelo/php_conexion.php");
}

class Cotizaciones extends ProcesoVenta{
    /**
     * Crea una compra
     * @param type $Fecha
     * @param type $idTercero
     * @param type $Observaciones     
     * @param type $Vector
     * @return type
     */
    public function CrearCotizacion($Fecha, $idTercero, $Observaciones,$Vector ) {
        
        //////Creo la compra            
        $tab="cotizacionesv5";
        $Datos["Fecha"]=$Fecha;
        $Datos["Clientes_idClientes"]=$idTercero;
        $Datos["Usuarios_idUsuarios"]=$_SESSION['idUser'];
        $Datos["Observaciones"]=$Observaciones;
        $Datos["Estado"]="Abierta";
        $sql=$this->getSQLInsert($tab, $Datos);
        $this->Query($sql);
        $idCotizacion=$this->ObtenerMAX($tab,"ID", 1,"");       
        
        return $idCotizacion;
    }
    
    public function AgregaItemCotizacion($idCotizacion,$Cantidad,$Multiplicador,$idProducto,$TablaItem,$ValorUnitario,$Vector){
        
            $DatosProductoGeneral=$this->DevuelveValores($TablaItem, "idProductosVenta", $idProducto);
            $DatosDepartamento=$this->DevuelveValores("prod_departamentos", "idDepartamentos", $DatosProductoGeneral["Departamento"]);
            $DatosTablaItem=$this->DevuelveValores("tablas_ventas", "NombreTabla", $TablaItem);
            $TipoItem=$DatosDepartamento["TipoItem"];
            $sql="select * from fechas_descuentos where (Departamento = '$DatosProductoGeneral[Departamento]' OR Departamento ='0') AND (Sub1 = '$DatosProductoGeneral[Sub1]' OR Sub1 ='0') AND (Sub2 = '$DatosProductoGeneral[Sub2]' OR Sub2 ='0') ORDER BY idFechaDescuentos DESC LIMIT 1 ";
            $reg=$this->Query($sql);
            $reg=$this->FetchArray($reg);
            $Porcentaje=$reg["Porcentaje"];
            $Departamento=$reg["Departamento"];
            $FechaDescuento=$reg["Fecha"];

            $impuesto=$DatosProductoGeneral["IVA"];
            $impuesto=$impuesto+1;
            if($DatosTablaItem["IVAIncluido"]=="SI"){
                $ValorUnitario=round($ValorUnitario/$impuesto,2);

            }
            if($Porcentaje>0 and $FechaDescuento==$fecha){

                    $Porcentaje=(100-$Porcentaje)/100;
                    $ValorUnitario=round($ValorUnitario*$Porcentaje,2);

            }
            
            $Subtotal=$ValorUnitario*$Cantidad*$Multiplicador;
            $IVA=(($impuesto-1)*$Subtotal);
            $Total=$Subtotal+$IVA;
            
            $tab="cot_itemscotizaciones";
            $Datos["NumCotizacion"]=$idCotizacion;
            $Datos["Descripcion"]=$DatosProductoGeneral["Nombre"];
            $Datos["Referencia"]=$DatosProductoGeneral["Referencia"];
            $Datos["TablaOrigen"]=$TablaItem;
            $Datos["ValorUnitario"]=$ValorUnitario;
            $Datos["Cantidad"]=$Cantidad;
            $Datos["Multiplicador"]=$Multiplicador;
            $Datos["Subtotal"]=$Subtotal;
            $Datos["IVA"]=$IVA;
            $Datos["Total"]=$Total;
            $Datos["Descuento"]=0;
            $Datos["ValorDescuento"]=0;
            $Datos["PrecioCosto"]=$DatosProductoGeneral["CostoUnitario"];
            $Datos["SubtotalCosto"]=$DatosProductoGeneral["CostoUnitario"]*$Cantidad*$Multiplicador;
            $Datos["TipoItem"]=$DatosDepartamento["TipoItem"];
            $Datos["Devuelto"]="";
            $Datos["CuentaPUC"]=$DatosProductoGeneral["CuentaPUC"];
            $sql=$this->getSQLInsert($tab, $Datos);
            $this->Query($sql);
            
            
        }
        /**
         * Registra el anticipo o abono a una cotizacion
         * @param type $fecha
         * @param type $idCotizacion
         * @param type $CuentaDestino
         * @param type $Vector
         */
        public function AnticipoCotizacion($Fecha,$idCotizacion,$ValorAnticipo,$CuentaDestino,$CentroCosto,$Vector) {
            $DatosCotizacion=$this->DevuelveValores("cotizacionesv5", "ID", $idCotizacion);
            $DatosCliente=$this->DevuelveValores("clientes", "idClientes", $DatosCotizacion["Clientes_idClientes"]);
            $Concepto="Anticipo a la cotizacion $idCotizacion";
            $idComprobanteIngreso=$this->RegistreAnticipo($DatosCotizacion["Clientes_idClientes"], $ValorAnticipo, $CuentaDestino, $CentroCosto, $Concepto, $_SESSION["idUser"]);
            
            $Tabla="cotizaciones_anticipos";
            $Datos["Fecha"]=$Fecha;
            $Datos["Valor"]=$ValorAnticipo;
            $Datos["idCotizacion"]=$idCotizacion;
            $Datos["idComprobanteIngreso"]=$idComprobanteIngreso;
            $Datos["idUsuario"]=$_SESSION["idUser"];
            $Datos["Estado"]="Abierto";
            $sql=$this->getSQLInsert($Tabla, $Datos);
            $this->Query($sql);            
            return($idComprobanteIngreso);
            
        }
    
    /**
     * Fin Clase
     */
}
