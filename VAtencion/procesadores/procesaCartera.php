<?php 

        /*
         * Registra abonos de creditos 
         */
        
              
        if(!empty($_REQUEST['TxtIdCartera'])){
            
            $obVenta=new ProcesoVenta($idUser);
            $fecha=$obVenta->normalizar($_REQUEST['TxtFecha']);
            $Hora=date("H:i:s");
            $idCartera=$obVenta->normalizar($_REQUEST['TxtIdCartera']);
            $idFactura=$obVenta->normalizar($_REQUEST['TxtIdFactura']);
            $CuentaDestino=$obVenta->normalizar($_REQUEST['CmbCuentaDestino']);
            $Valor=$obVenta->normalizar($_REQUEST["TxtAbonoCredito$idCartera"]);
            $DatosFactura=$obVenta->DevuelveValores("facturas", "idFacturas", $idFactura);
            
            $CentroCosto=$DatosFactura["CentroCosto"];
            $Concepto="ABONO A FACTURA No $DatosFactura[Prefijo] - $DatosFactura[NumeroFactura]";
            $VectorIngreso["fut"]="";
            $idComprobanteAbono=$obVenta->RegistreAbonoCarteraCliente($fecha,$Hora,$CuentaDestino,$idFactura,$Valor,"",$CentroCosto,$Concepto,$idUser,$VectorIngreso);
            $DatosComprobanteAbono=$obVenta->DevuelveValores("facturas_abonos", "ID", $idComprobanteAbono);
            $idComprobanteIngreso=$DatosComprobanteAbono["idComprobanteIngreso"];
            header("location:$myPage?TxtidIngreso=$idComprobanteIngreso");
        }
        //Esta opcion borra la tabla cartera y la restaura a partir de la tabla facturacion
        if(isset($_REQUEST['BtnRestaurarCartera'])){
            $obVenta->VaciarTabla("cartera");
            $consulta=$obVenta->ConsultarTabla("facturas", "WHERE FormaPago<>'Contado' AND FormaPago<>'ANULADA' AND FormaPago<>'Separado' AND SaldoFact>10");
            while($DatosFactura=$obVenta->FetchArray($consulta)){
                $Dias=substr($DatosFactura["FormaPago"], 10, 2);
                $Datos["Fecha"]=$DatosFactura["Fecha"]; 
                $Datos["Dias"]=$Dias;
                $FechaVencimiento=$obVenta->SumeDiasFecha($Datos);
                if($DatosFactura["FormaPago"]=="SisteCredito"){
                    $Datos["SisteCredito"]=1;
                    $Datos["Dias"]=30;
                    $FechaVencimiento=$obVenta->SumeDiasFecha($Datos);
                }else{
                    $Datos["SisteCredito"]=0;
                    $FechaVencimiento=$obVenta->SumeDiasFecha($Datos);
                }
                    $Datos["SaldoFactura"]=$DatosFactura["SaldoFact"]; 
                    $Datos["idFactura"]=$DatosFactura["idFacturas"]; 
                    $Datos["FechaFactura"]=$DatosFactura["Fecha"];
                    $Datos["FechaVencimiento"]=$FechaVencimiento;
                    $Datos["idCliente"]=$DatosFactura["Clientes_idClientes"]; 
                    $obVenta->InsertarFacturaEnCartera($Datos);///Inserto La factura en la cartera
            }
        
        }
        ///////////////Fin
        
	?>