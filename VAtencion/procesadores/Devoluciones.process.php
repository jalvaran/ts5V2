<?php 
$obRemision=new Remision($idUser);		
if(!empty($_REQUEST["TxtDias"])){
    
    $idItem=$obRemision->normalizar($_REQUEST["TxtIdItem"]);
    $FechaDevolucion=$obRemision->normalizar($_REQUEST["TxtFechaDevolucion"]);
    $HoraDevolucion=$obRemision->normalizar($_REQUEST["TxtHoraDevolucion"]);
    $CantidadDevolucion=$obRemision->normalizar($_REQUEST["TxtCantidadDevolucion"]);
    $idRemision=$obRemision->normalizar($_REQUEST["TxtAsociarRemision"]);
    $Dias=$obRemision->normalizar($_REQUEST["TxtDias"]);
    $ValorUnitario=$obRemision->normalizar($_REQUEST["TxtSubtotalUnitario"]);
    $SubTotal=$ValorUnitario*$CantidadDevolucion;
    $Total=$SubTotal*$Dias;
    
    $tab="rem_pre_devoluciones";
    $NumRegistros=8; 
    $Columnas[0]="idRemision";		$Valores[0]=$idRemision;
    $Columnas[1]="idItemCotizacion";	$Valores[1]=$idItem;
    $Columnas[2]="Cantidad";		$Valores[2]=$CantidadDevolucion;
    $Columnas[3]="Usuarios_idUsuarios"; $Valores[3]=$idUser;
    $Columnas[4]="ValorUnitario";       $Valores[4]=$ValorUnitario;
    $Columnas[5]="Subtotal";            $Valores[5]=$SubTotal;
    $Columnas[6]="Dias";                $Valores[6]=$Dias;
    $Columnas[7]="Total";               $Valores[7]=$Total;
    
    $obRemision->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
   
    header("location:Devoluciones.php?TxtAsociarRemision=$idRemision");
}

///////////////////////////////
////////Si se solicita borrar algo
////
////

if(!empty($_REQUEST['del'])){
    $id=$obRemision->normalizar($_REQUEST['del']);
    $Tabla=$obRemision->normalizar($_REQUEST['TxtTabla']);
    $IdTabla=$obRemision->normalizar($_REQUEST['TxtIdTabla']);
    $IdPre=$obRemision->normalizar($_REQUEST['TxtIdPre']);
    $obRemision->BorraReg($Tabla, $IdTabla, $id);
    
    header("location:Devoluciones.php?TxtAsociarRemision=$IdPre");
}
	
if(!empty($_REQUEST["BtnGuardarDevolucion"])){
   
    $FechaDevolucion=$obRemision->normalizar($_REQUEST["TxtFechaDevolucion"]);
    $HoraDevolucion=$obRemision->normalizar($_REQUEST["TxtHoraDevolucion"]);
    $idRemision=$obRemision->normalizar($_REQUEST["TxtIdRemision"]);
    $Observaciones=$obRemision->normalizar($_REQUEST["TxtObservacionesDevolucion"]);
    $TotalDevolucion=$obRemision->normalizar($_REQUEST["TxtTotalDevolucion"]);
    
    $DatosRemision=$obRemision->DevuelveValores("remisiones", "ID", $idRemision);
    $idCliente=$DatosRemision["Clientes_idClientes"];
    ////Guardamos en la tabla devoluciones
    ////
    ////
    
    $tab="rem_devoluciones_totalizadas";
    $NumRegistros=8; 
    $Columnas[0]="FechaDevolucion";         $Valores[0]=$FechaDevolucion;
    $Columnas[1]="idRemision";              $Valores[1]=$idRemision;
    $Columnas[2]="TotalDevolucion";         $Valores[2]=$TotalDevolucion;
    $Columnas[3]="ObservacionesDevolucion"; $Valores[3]=$Observaciones;
    $Columnas[4]="Usuarios_idUsuarios";     $Valores[4]=$idUser;
    $Columnas[5]="Clientes_idClientes";     $Valores[5]=$DatosRemision["Clientes_idClientes"];
    $Columnas[6]="Facturas_idFacturas";     $Valores[6]="";
    $Columnas[7]="HoraDevolucion";          $Valores[7]=$HoraDevolucion;
    
    $obRemision->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
    
    $idDevolucion=$obRemision->ObtenerMAX("rem_devoluciones_totalizadas", "ID", 1, "");
    
    $Consulta=$obRemision->ConsultarTabla("rem_pre_devoluciones", " WHERE idRemision='$idRemision'");
    
    while($DatosPreDevolucion= $obRemision->FetchArray($Consulta)){
        
        $tab="rem_devoluciones";
        $NumRegistros=11; 
        $Columnas[0]="idRemision";          $Valores[0]=$idRemision;
        $Columnas[1]="idItemCotizacion";    $Valores[1]=$DatosPreDevolucion["idItemCotizacion"];
        $Columnas[2]="Cantidad";            $Valores[2]=$DatosPreDevolucion["Cantidad"];
        $Columnas[3]="ValorUnitario";       $Valores[3]=$DatosPreDevolucion["ValorUnitario"];
        $Columnas[4]="Subtotal";            $Valores[4]=$DatosPreDevolucion["Subtotal"];
        $Columnas[5]="Dias";                $Valores[5]=$DatosPreDevolucion["Dias"];
        $Columnas[6]="Total";               $Valores[6]=$DatosPreDevolucion["Total"];
        $Columnas[7]="NumDevolucion";       $Valores[7]=$idDevolucion;
        $Columnas[8]="FechaDevolucion";     $Valores[8]=$FechaDevolucion;
        $Columnas[9]="HoraDevolucion";      $Valores[9]=$HoraDevolucion;
        $Columnas[10]="Usuarios_idUsuarios";$Valores[10]=$DatosPreDevolucion["Usuarios_idUsuarios"];
        
        $obRemision->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
        $DatosItemsCotizacion=$obRemision->DevuelveValores("cot_itemscotizaciones", "ID", $DatosPreDevolucion["idItemCotizacion"]);
        if($DatosItemsCotizacion["TablaOrigen"]=="productosalquiler"){
            $DatosProducto= $obRemision->DevuelveValores("productosalquiler", "Referencia", $DatosItemsCotizacion["Referencia"]);
            $DatosClientes= $obRemision->DevuelveValores("clientes","idClientes",$DatosItemsCotizacion["idCliente"]);
            $obRemision->KardexAlquiler($FechaDevolucion, "ENTRADA", $DatosPreDevolucion["Cantidad"], $DatosProducto["Nombre"],$DatosProducto["idProductosVenta"],$DatosProducto["Existencias"],$DatosProducto["EnAlquiler"],$DatosProducto["EnBodega"], $DatosClientes["Num_Identificacion"], $DatosClientes["RazonSocial"],"Devolucion", $idDevolucion,$DatosProducto["CostoUnitario"], $DatosProducto["CostoUnitario"]*$DatosPreDevolucion["Cantidad"],$idUser, "");
        }
    }
   
    
    ////Iniciamos registro de facturas si aplica
    ////
    ////
    
    if($_REQUEST["CmbFactura"]=="SI"){
        
        $CentroCostos=$obRemision->normalizar($_REQUEST["CmbCentroCostos"]);
        $ResolucionDian=$obRemision->normalizar($_REQUEST["CmbResolucion"]);
        $TipoPago=$obRemision->normalizar($_REQUEST["CmbFormaPago"]);
        $CuentaDestino=$obRemision->normalizar($_REQUEST["CmbCuentaDestino"]);
        $OrdenCompra=$obRemision->normalizar($_REQUEST["TxtOrdenCompra"]);
        $OrdenSalida=$obRemision->normalizar($_REQUEST["TxtOrdenSalida"]);
        $ObservacionesFactura=$obRemision->normalizar($_REQUEST["TxtObservacionesFactura"]);
        $FechaFactura=$obRemision->normalizar($_REQUEST["TxtFechaFactura"]);
        $Consulta=$obRemision->DevuelveValores("centrocosto", "ID", $CentroCostos);
        $EmpresaPro=$Consulta["EmpresaPro"];
        if($TipoPago=="Contado"){
            $SumaDias=0;
        }else{
            $SumaDias=$TipoPago;
        }
        ////////////////////////////////Preguntamos por disponibilidad
        ///////////
        ///////////
        $ID="";
        $DatosResolucion=$obRemision->DevuelveValores("empresapro_resoluciones_facturacion", "ID", $ResolucionDian);
        if($DatosResolucion["Completada"]=="NO"){           ///Pregunto si la resolucion ya fue completada
            $Disponibilidad=$DatosResolucion["Estado"];
                                              //si entra a verificar es porque estaba ocupada y cambiará a 1
            while($Disponibilidad=="OC"){                   //miro que esté disponible para facturar, esto para no crear facturas dobles
                print("Esperando disponibilidad<br>");
                usleep(300);
                $DatosResolucion=$obRemision->DevuelveValores("empresapro_resoluciones_facturacion", "ID", $ResolucionDian);
                $Disponibilidad=$DatosResolucion["Estado"];
                
            }
            
            $DatosResolucion=$obRemision->DevuelveValores("empresapro_resoluciones_facturacion", "ID", $ResolucionDian);
            if($DatosResolucion["Completada"]<>"SI"){
                $obRemision->ActualizaRegistro("empresapro_resoluciones_facturacion", "Estado", "OC", "ID", $ResolucionDian); //Ocupo la resolucion
                $Datos["NumDevolucion"]=$idDevolucion;
                
                $sql="SELECT MAX(NumeroFactura) as FacturaActual FROM facturas WHERE Prefijo='$DatosResolucion[Prefijo]' "
                        . "AND TipoFactura='$DatosResolucion[Tipo]' AND idResolucion='$ResolucionDian'";
                $Consulta=$obRemision->Query($sql);
                $Consulta=$obRemision->FetchArray($Consulta);
                $FacturaActual=$Consulta["FacturaActual"];
                $idFactura=$FacturaActual+1;
                //Verificamos si ya se completó el numero de la resolucion y si es así se cambia su estado
                if($DatosResolucion["Hasta"]==$idFactura){ 
                    $obRemision->ActualizaRegistro("empresapro_resoluciones_facturacion", "Completada", "SI", "ID", $ResolucionDian);
                }
                //Verificamos si es la primer factura que se creará con esta resolucion
                //Si es así se inicia desde el numero autorizado
                if($idFactura==1){
                   $idFactura=$DatosResolucion["Desde"];
                }
                //Convertimos los dias en credito
                $FormaPagoFactura=$TipoPago;
                if($TipoPago<>"Contado"){
                    $FormaPagoFactura="Credito a $TipoPago dias";
                }
                ////////////////Inserto datos de la factura
                /////
                ////
                $ID=date("YmdHis").microtime(false);
                $tab="facturas";
                $NumRegistros=25; 
                
                $Columnas[0]="TipoFactura";		    $Valores[0]=$DatosResolucion["Tipo"];
                $Columnas[1]="Prefijo";                     $Valores[1]=$DatosResolucion["Prefijo"];
                $Columnas[2]="NumeroFactura";               $Valores[2]=$idFactura;
                $Columnas[3]="Fecha";                       $Valores[3]=$FechaFactura;
                $Columnas[4]="OCompra";                     $Valores[4]=$OrdenCompra;
                $Columnas[5]="OSalida";                     $Valores[5]=$OrdenSalida;
                $Columnas[6]="FormaPago";                   $Valores[6]=$FormaPagoFactura;
                $Columnas[7]="Subtotal";                    $Valores[7]="";
                $Columnas[8]="IVA";                         $Valores[8]="";
                $Columnas[9]="Descuentos";                  $Valores[9]="";
                $Columnas[10]="Total";                      $Valores[10]="";
                $Columnas[11]="SaldoFact";                  $Valores[11]="";
                $Columnas[12]="Cotizaciones_idCotizaciones";$Valores[12]="";
                $Columnas[13]="EmpresaPro_idEmpresaPro";    $Valores[13]=$EmpresaPro;
                $Columnas[14]="Usuarios_idUsuarios";        $Valores[14]=$idUser;
                $Columnas[15]="Clientes_idClientes";        $Valores[15]=$idCliente;
                $Columnas[16]="TotalCostos";                $Valores[16]="";
                $Columnas[17]="CerradoDiario";              $Valores[17]="";
                $Columnas[18]="FechaCierreDiario";          $Valores[18]="";
                $Columnas[19]="HoraCierreDiario";           $Valores[19]="";
                $Columnas[20]="ObservacionesFact";          $Valores[20]=$ObservacionesFactura;
                $Columnas[21]="CentroCosto";                $Valores[21]=$CentroCostos;
                $Columnas[22]="idResolucion";               $Valores[22]=$ResolucionDian;
                $Columnas[23]="idFacturas";                 $Valores[23]=$ID;
                $Columnas[24]="Hora";                       $Valores[24]=date("H:i:s");
                
                $obRemision->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
                
                //libero la resolucion
                $obRemision->ActualizaRegistro("empresapro_resoluciones_facturacion", "Estado", "", "ID", $ResolucionDian);
                
                //////////////////////Agrego Items a la Factura desde la devolucion
                /////
                /////
                $Datos["NumDevolucion"]=$idDevolucion;
                $Datos["NumFactura"]=$idFactura;
                $Datos["FechaFactura"]=$FechaFactura;
                $Datos["ID"]=$ID;
                $Datos["CuentaDestino"]=$CuentaDestino;
                $Datos["EmpresaPro"]=$EmpresaPro;
                $Datos["CentroCostos"]=$CentroCostos;
                $obRemision->InsertarItemsDevolucionAItemsFactura($Datos);///Relaciono los items de la factura
                $obRemision->ActualizaRegistro("rem_devoluciones_totalizadas", "Facturas_idFacturas", $ID, "ID", $idDevolucion);
                $obRemision->InsertarFacturaLibroDiario($Datos);///Inserto Items en el libro diario
               
                if($TipoPago<>"Contado"){                   //Si es a Credito
                    $Datos["Fecha"]=$FechaFactura; 
                    $Datos["Dias"]=$SumaDias;
                    $FechaVencimiento=$obRemision->SumeDiasFecha($Datos);
                    $Datos["idFactura"]=$Datos["ID"]; 
                    $Datos["FechaFactura"]=$FechaFactura; 
                    $Datos["FechaVencimiento"]=$FechaVencimiento;
                    $Datos["idCliente"]=$idCliente;
                    $obRemision->InsertarFacturaEnCartera($Datos);///Inserto La factura en la cartera
                }
                
            }    
           
        }
        
        
        
    }
    
    $obRemision->BorraReg("rem_pre_devoluciones", "idRemision", $idRemision);
    header("location:Devoluciones.php?TxtidDevolucion=$idDevolucion&TxtidFactura=$ID");
}        


///////////////fin
?>