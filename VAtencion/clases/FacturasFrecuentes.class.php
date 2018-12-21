<?php

/* 
 * Clase donde se realizaran procesos para construir facturas frecuentes
 * Julian Alvaran
 * Techno Soluciones SAS
 * 2018-10-04
 */
        
class FacturasFrecuentes extends ProcesoVenta{
    
    /**
     * Agregar un items a una factura frecuente
     * @param type $idFacturaFrecuente
     * @param type $TablaItem
     * @param type $idTabla
     * @param type $idItemAgregado
     * @param type $Cantidad
     * @param type $idUser
     * @param type $Vector
     */
    public function AgregarItemFacturaFrecuente($idFacturaFrecuente,$TablaItem,$idTabla,$idItemAgregado,$Cantidad,$idUser, $Vector) {
           
        $DatosFacturaFrecuente=$this->ValorActual("facturas_frecuentes_items_adicionales", "ID,idItem,Cantidad", " TablaOrigen='$TablaItem' AND idItem='$idItemAgregado' AND idFacturaFrecuente='$idFacturaFrecuente'");
        if($DatosFacturaFrecuente["ID"]==''){
            $DatosItem=$this->ValorActual($TablaItem, "PrecioVenta", " $idTabla='$idItemAgregado'");
            
            $Datos["TablaOrigen"]=$TablaItem;
            $Datos["idTablaOrigen"]=$idTabla;
            $Datos["idItem"]=$idItemAgregado;
            $Datos["ValorUnitario"]=$DatosItem["PrecioVenta"];
            $Datos["Cantidad"]=$Cantidad;            
            $Datos["idFacturaFrecuente"]=$idFacturaFrecuente;
            $sql=$this->getSQLInsert("facturas_frecuentes_items_adicionales", $Datos);
            $this->Query($sql);
                    
        }else{
            //print_r($DatosFacturaFrecuente);
            $NuevaCantidad=$DatosFacturaFrecuente["Cantidad"]+$Cantidad;
            $this->ActualizaRegistro("facturas_frecuentes_items_adicionales", "Cantidad", $NuevaCantidad, "ID", $DatosFacturaFrecuente["ID"]);
            
        }
        
        
    }
    
    public function GenerarFacturaFrecuente($fecha,$idFacturaFrecuente,$idUser,$Vector) {
        $DatosFacturaFrecuente=$this->DevuelveValores("facturas_frecuentes", "ID", $idFacturaFrecuente);
        $idFacturaBase=$DatosFacturaFrecuente["FacturaBase"];
        $idPreventa=99;// se utiliza esta para no interferir en la operacion
        $sql="SELECT TablaItems,Referencia,Cantidad FROM facturas_items WHERE idFactura='$idFacturaBase'";
        $consulta=$this->Query($sql);
        
        while($DatosFacturaBase=$this->FetchArray($consulta)){
            $Referencia=$DatosFacturaBase["Referencia"];
            $DatosGeneralItem=$this->ValorActual($DatosFacturaBase["TablaItems"],"idProductosVenta"," Referencia='$Referencia'");
            $this->AgregaPreventa($fecha, $DatosFacturaBase["Cantidad"], $idPreventa, $DatosGeneralItem["idProductosVenta"], $DatosFacturaBase["TablaItems"]);
        }
        $sql="SELECT TablaOrigen,idTablaOrigen,idItem,ValorUnitario,Cantidad FROM facturas_frecuentes_items_adicionales WHERE idFacturaFrecuente='$idFacturaFrecuente'";
        $consulta=$this->Query($sql);
        
        while($DatosItemsAdicionales=$this->FetchArray($consulta)){
            $this->AgregaPreventa($fecha, $DatosItemsAdicionales["Cantidad"], $idPreventa, $DatosItemsAdicionales["idItem"], $DatosItemsAdicionales["TablaOrigen"],$DatosItemsAdicionales["ValorUnitario"]);
        }
        
        //Registro la venta y creo la factura
        $Parametros= $this->DevuelveValores("parametros_contables", "ID", 21); // en este registro se encuentra la cuenta por defecto a utilizar en caja
        $CuentaDestino=$Parametros["CuentaPUC"];
        $DatosVentaRapida["PagaCheque"]=0;
        $DatosVentaRapida["PagaTarjeta"]=0;
        $DatosVentaRapida["idTarjeta"]=0;
        $DatosVentaRapida["PagaOtros"]=0;
        $DatosVentaRapida["FechaFactura"]=$fecha;
        $DatosCaja=$this->DevuelveValores("cajas", "idUsuario", $idUser);
        $DatosVentaRapida["CentroCostos"]=$DatosCaja["CentroCostos"];
        $DatosVentaRapida["ResolucionDian"]=$DatosCaja["idResolucionDian"];
        $DatosVentaRapida["Observaciones"]="";
        //$this->RegistreVentaRapida($idPreventa, $idCliente, $TipoPago, $Paga, $Devuelta, $CuentaDestino, $DatosVentaRapida);
        $NumFactura=$this->RegistreVentaRapida($idPreventa, $DatosFacturaFrecuente["idCliente"], 15, 0, 0, $Parametros["CuentaPUC"], $DatosVentaRapida);
        
        
        $this->ActualizaRegistro("facturas_frecuentes", "Realizada", 1, "ID", $idFacturaFrecuente);
        $this->ActualizaRegistro("facturas_frecuentes", "UltimaFactura", $NumFactura, "ID", $idFacturaFrecuente);
        //print("<script>alert('Entra 2')</script>");
        $this->BorraReg("preventa","VestasActivas_idVestasActivas",$idPreventa);
        $this->DescargueFacturaInventarios($NumFactura,"");
        $Datos["ID"]=$NumFactura;
        $Datos["CuentaDestino"]=$CuentaDestino;
        $this->InsertarFacturaLibroDiario($Datos);
        return($NumFactura);
    }
    //Fin Clases
}
