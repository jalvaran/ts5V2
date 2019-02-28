<?php

session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];

include_once("../clases/Cotizaciones.class.php");

if( !empty($_REQUEST["Accion"]) ){
    $obCon = new Cotizaciones($idUser);
    
    switch ($_REQUEST["Accion"]) {
        
        case 1: //Crear una Cotizacion
            $Fecha=$obCon->normalizar($_REQUEST["Fecha"]); 
            $idTercero=$obCon->normalizar($_REQUEST["Tercero"]); 
            
            $Observaciones=$obCon->normalizar($_REQUEST["Observaciones"]); 
            
            $idCotizacion=$obCon->CrearCotizacion($Fecha, $idTercero, $Observaciones, "");
            print("OK;$idCotizacion");            
            
        break; 
        
        case 2: //editar datos generales de una cotizacion
            $idCotizacion=$obCon->normalizar($_REQUEST["idCotizacionActiva"]); 
            $Fecha=$obCon->normalizar($_REQUEST["Fecha"]); 
            $idTercero=$obCon->normalizar($_REQUEST["Tercero"]);           
            $Observaciones=$obCon->normalizar($_REQUEST["Observaciones"]); 
            
            
            $obCon->ActualizaRegistro("cotizacionesv5", "Fecha", $Fecha, "ID", $idCotizacion,0);
            $obCon->ActualizaRegistro("cotizacionesv5", "Clientes_idClientes", $idTercero, "ID", $idCotizacion,0);
            $obCon->ActualizaRegistro("cotizacionesv5", "Observaciones", $Observaciones, "ID", $idCotizacion,0);
            
            $DatosTercero=$obCon->DevuelveValores("clientes", "idClientes", $idTercero);
            
            print("OK;$DatosTercero[RazonSocial]");
            
        break; 
        case 3://Agregar un item
            
            $idCotizacion=$obCon->normalizar($_REQUEST["idCotizacion"]); 
            $CmbListado=$obCon->normalizar($_REQUEST["CmbListado"]); 
            $CmbBusquedas=$obCon->normalizar($_REQUEST["CmbBusquedas"]); 
            $Cantidad=$obCon->normalizar($_REQUEST["Cantidad"]); 
            $ValorUnitario=$obCon->normalizar($_REQUEST["ValorUnitario"]); 
            if($CmbListado==1){
                $TablaItem="productosventa";
            }
            if($CmbListado==2){
                $TablaItem="servicios";
            }
            if($CmbListado==3){
                $TablaItem="productosalquiler";
            }
            $Multiplicador=1;
            $obCon->AgregaItemCotizacion($idCotizacion,$Cantidad,$Multiplicador,$CmbBusquedas,$TablaItem,$ValorUnitario,"");
            
            print("OK");
            
        break;//Fin caso 3
        
        
        case 5://Se elimina un item
            $idItem=$obCon->normalizar($_REQUEST["idItem"]);
            $Tabla=$obCon->normalizar($_REQUEST["Tabla"]);
            if($Tabla==1){
                $Tabla="cot_itemscotizaciones";
            }
            
            $obCon->BorraReg($Tabla, "ID", $idItem);
            print("Item Eliminado");
        break;//Fin caso 5
        
        case 6://Guardo el documento
            $idCotizacion=$obCon->normalizar($_REQUEST["idCotizacion"]);
            $obCon->ActualizaRegistro("cotizacionesv5", "Estado", "Cerrada", "ID", $idCotizacion);            
            $LinkCotizacion="../../VAtencion/ImprimirPDFCotizacion.php?ImgPrintCoti=$idCotizacion";
            $Mensaje="<strong>Cotizacion $idCotizacion Creada Correctamente </strong><a href='$LinkCotizacion'  target='blank'> Imprimir</a>";
            
            print("OK;$Mensaje");
        break;//Fin caso 6
        
        case 7://Edita un item de una cotizacion
            $idItem=$obCon->normalizar($_REQUEST["idItem"]);            
            $ValorUnitario=$obCon->normalizar($_REQUEST["ValorUnitario"]);
            $Multiplicador=$obCon->normalizar($_REQUEST["Multiplicador"]);
            $Cantidad=$obCon->normalizar($_REQUEST["Cantidad"]);
            
            $obCon->EditarItemCotizacion($idItem, $Cantidad, $Multiplicador, $ValorUnitario, "");
            $Mensaje="Item Editado";
            print("OK;$Mensaje");
        break;//Fin caso 7
    
        case 8://realiza un anticipo a una cotizacion
            $idCotizacion=$obCon->normalizar($_REQUEST["idCotizacion"]);       
            $CmbCuentaIngreso=$obCon->normalizar($_REQUEST["CmbCuentaIngreso"]);
            $TxtAnticipo=$obCon->normalizar($_REQUEST["TxtAnticipo"]);
            $TxtFechaAnticipo=$obCon->normalizar($_REQUEST["TxtFechaAnticipo"]);
            $MensajeComprobante="El valor debe ser superior a Cero";
            if($TxtAnticipo>0){
                $CentroCotos=1;
                $idComprobanteIngreso=$obCon->AnticipoCotizacion($TxtFechaAnticipo, $idCotizacion, $TxtAnticipo, $CmbCuentaIngreso, $CentroCotos, "");
                $LinkComprobante="../../VAtencion/PDF_Documentos.php?idDocumento=4&idIngreso=$idComprobanteIngreso";
                $MensajeComprobante="<br><strong>Comprobante de ingreso $idComprobanteIngreso Creado Correctamente </strong><a href='$LinkComprobante'  target='blank'> Imprimir</a>";
           
            }
            
            print("OK;$MensajeComprobante");
        break;//Fin caso 8
        
        case 9://Convierte cotizacion en factura
            include_once("../clases/Facturacion.class.php");
            $obFactura = new Facturacion($idUser);
            
            $idCotizacion=$obCon->normalizar($_REQUEST["idCotizacion"]);       
            $Fecha=$obCon->normalizar($_REQUEST["TxtFechaFactura"]);
            $idCentroCostos=$obCon->normalizar($_REQUEST["CmbCentroCostosFactura"]);
            $CmbResolucion=$obCon->normalizar($_REQUEST["CmbResolucion"]);
            $CmbFormaPago=$obCon->normalizar($_REQUEST["CmbFormaPago"]);
            $CmbFrecuente=$obCon->normalizar($_REQUEST["CmbFrecuente"]);
            $CmbCuentaIngresoFactura=$obCon->normalizar($_REQUEST["CmbCuentaIngresoFactura"]);
            $CmbColaboradores=$obCon->normalizar($_REQUEST["CmbColaboradores"]);
            $Observaciones=$obCon->normalizar($_REQUEST["TxtObservacionesFactura"]);
            
            $idEmpresa=$obCon->normalizar($_REQUEST["CmbEmpresa"]);
            $idSucursal=$obCon->normalizar($_REQUEST["CmbSucursal"]);
            
            $FormaPagoFactura=$CmbFormaPago;
            if($CmbFormaPago<>"Contado"){
                $FormaPagoFactura="Credito a $CmbFormaPago dias";
            }
            
            
            $Hora=date("H:i:s");
            $OrdenCompra="";
            $OrdenSalida="";
            $sql="SELECT SUM(Subtotal) AS Subtotal, SUM(IVA) AS IVA, SUM(Total) as Total,SUM(SubtotalCosto) AS TotalCostos "
                    . "FROM cot_itemscotizaciones WHERE NumCotizacion='$idCotizacion'";
            $Consulta=$obCon->Query($sql);
            $DatosTotalesCotizacion=$obCon->FetchAssoc($Consulta);
            $Subtotal=$DatosTotalesCotizacion["Subtotal"];
            $IVA=$DatosTotalesCotizacion["IVA"];
            $Total=$DatosTotalesCotizacion["Total"];
            $TotalCostos=$DatosTotalesCotizacion["TotalCostos"];
            $SaldoFactura=$Total;
            $Descuentos=0;
            $DatosCotizacion=$obCon->DevuelveValores("cotizacionesv5", "ID", $idCotizacion);
            $idCliente=$DatosCotizacion["Clientes_idClientes"];
            $idFactura=$obFactura->idFactura();
            $NumFactura=$obFactura->CrearFactura($idFactura, $Fecha, $Hora, $CmbResolucion, $OrdenCompra, $OrdenSalida, $FormaPagoFactura, $Subtotal, $IVA, $Total, $Descuentos, $SaldoFactura, $idCotizacion, $idEmpresa, $idCentroCostos, $idSucursal, $idUser, $idCliente, $TotalCostos, $Observaciones, 0, 0, 0, 0, 0, 0, 0, "");
            if($NumFactura=="E1"){
                $Mensaje="La Resolucion está completa";
                print("E1;$Mensaje");
                exit();
            }
            if($NumFactura=="E2"){
                $Mensaje="La Resolucion está ocupada, intentelo nuevamente";
                print("E2;$Mensaje");
                exit();
            }
            $obFactura->CopiarItemsCotizacionAItemsFactura($idCotizacion, $idFactura, $Fecha,$idUser, "");
            $Datos["ID"]=$idFactura;
            $Datos["CuentaDestino"]=$CmbCuentaIngresoFactura;
            $obCon->InsertarFacturaLibroDiario($Datos);
            $obCon->DescargueFacturaInventarios($idFactura, "");
            if($CmbFormaPago=="Contado"){
                $SumaDias=0;
            }else{
                $SumaDias=$CmbFormaPago;
            }
            if($CmbFormaPago=="SisteCredito"){
                $SumaDias=30;
            }
            
            if($CmbFormaPago<>"Contado"){                   //Si es a Credito
                if($CmbFormaPago=="SisteCredito"){
                    $Datos["SisteCredito"]=1;
                }
                $Datos["Fecha"]=$Fecha; 
                $Datos["Dias"]=$SumaDias;
                $FechaVencimiento=$obCon->SumeDiasFecha($Datos);
                $Datos["idFactura"]=$idFactura; 
                $Datos["FechaFactura"]=$Fecha; 
                $Datos["FechaVencimiento"]=$FechaVencimiento;
                $Datos["idCliente"]=$idCliente;
                $obCon->InsertarFacturaEnCartera($Datos);///Inserto La factura en la cartera
            }
            
            if($CmbColaboradores>0){
                $obCon->AgregueVentaColaborador($idFactura,$CmbColaboradores);
            }
            $LinkFactura="../../general/Consultas/PDF_Documentos.draw.php?idDocumento=2&ID=$idFactura";
            $Mensaje="<br><strong>Factura $NumFactura Creada Correctamente </strong><a href='$LinkFactura'  target='blank'> Imprimir</a>";
           
            print("OK;$Mensaje");
        break;//Fin caso 9
        
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>