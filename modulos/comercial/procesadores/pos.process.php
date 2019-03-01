<?php

session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];
$fecha=date("Y-m-d");

include_once("../clases/Facturacion.class.php");

if( !empty($_REQUEST["Accion"]) ){
    $obCon = new Facturacion($idUser);
    
    switch ($_REQUEST["Accion"]) {
        
        case 1: //Crear una preventa
            //Verifico primero que no tenga mas de 3 preventas creadas
            $sql="SELECT COUNT(*) as Total FROM vestasactivas WHERE Usuario_idUsuario='$idUser'";
            $Consulta=$obCon->Query($sql);
            $CantidadPreventas=$obCon->FetchAssoc($Consulta);
            if($CantidadPreventas["Total"]>=3){
                print("E1;");//Preventas Máximas permitidas
                exit();
            }
            $DatosUsuario=$obCon->ValorActual("usuarios", "Nombre,Apellido", " idUsuarios='$idUser'");
            $TextoPreventa="Venta por: ".$DatosUsuario["Nombre"]." ".$DatosUsuario["Apellido"];
            $idPreventa=$obCon->CrearPreventaPOS($idUser,$TextoPreventa);
            print("OK;$idPreventa;$TextoPreventa");            
            
        break; 
        
        
        case 2://Agregar un producto para la venta
            
            $idPreventa=$obCon->normalizar($_REQUEST["idPreventa"]); 
            $CmbListado=$obCon->normalizar($_REQUEST["CmbListado"]); 
            $Codigo=$obCon->normalizar($_REQUEST["Codigo"]); 
            $Cantidad=$obCon->normalizar($_REQUEST["Cantidad"]); 
            
            if($CmbListado==1){
                $TablaItem="productosventa";
                $idProducto=$obCon->ObtenerIdProducto($Codigo);
                if($idProducto==''){
                    print("E1;El producto no existe en la base de datos, por favor no lo entregue"); //El producto no existe en la base de datos
                    exit();
                }
                $DatosProducto=$obCon->ValorActual("productosventa", "PrecioVenta", "idProductosVenta='$idProducto'");
                $DatosImpuestosAdicionales=$obCon->DevuelveValores("productos_impuestos_adicionales", "idProducto", $idProducto);
                if($DatosProducto["PrecioVenta"]<=0 and $DatosImpuestosAdicionales["ValorImpuesto"]==''){
                    print("E1;Este Producto no tiene precio por favor no lo entregue"); //El producto no tiene precio de venta
                    exit();
                }
                $obCon->POS_AgregaItemPreventa($idProducto, $TablaItem, $Cantidad, $idPreventa);
                print("OK;Item $idProducto Agregado");
                exit();
            }
            if($CmbListado==2){
                $TablaItem="servicios";
            }
            if($CmbListado==3){
                $TablaItem="productosalquiler";
            }
            if($CmbListado==4){
                $TablaItem="sistemas";
            }
            
            $obCon->AgregaItemCotizacion($idCotizacion,$Cantidad,$Multiplicador,$CmbBusquedas,$TablaItem,$ValorUnitario,"");
            
            print("OK");
            
        break;//Fin caso 2
        
        
        case 3://Se elimina un item
            $idItem=$obCon->normalizar($_REQUEST["idItem"]);
            $Tabla="preventa";
            $obCon->BorraReg($Tabla, "idPrecotizacion", $idItem);
            print("Item Eliminado");
        break;//Fin caso 3
        
        
        case 4://Edita una cantidad
             
            $idItem=$obCon->normalizar($_REQUEST["idItem"]);            
            $Cantidad=$obCon->normalizar($_REQUEST["Cantidad"]);
            if($Cantidad==0){
                print("E1,No se puede editar la cantidad en cero");
                exit();
            }
            
            $DatosPreventa=$obCon->DevuelveValores("preventa", "idPrecotizacion", $idItem);
            $ValorAcordado=$DatosPreventa["ValorAcordado"];
            $idProducto=$DatosPreventa["ProductosVenta_idProductosVenta"];
            $Tabla=$DatosPreventa["TablaItem"];
            $Subtotal=$ValorAcordado*$Cantidad;
            $DatosProductos=$obCon->DevuelveValores($Tabla,"idProductosVenta",$idProducto);
            $DatosImpuestosAdicionales=$obCon->DevuelveValores("productos_impuestos_adicionales", "idProducto", $idProducto);
            $IVA=$Subtotal*$DatosProductos["IVA"]+($DatosImpuestosAdicionales["ValorImpuesto"]*$Cantidad);
            $SubtotalCosto=$DatosProductos["CostoUnitario"]*$Cantidad;
            $Total=$Subtotal+$IVA;
            $filtro="idPrecotizacion";

            $obCon->ActualizaRegistro("preventa","Subtotal", $Subtotal, $filtro, $idItem);
            $obCon->ActualizaRegistro("preventa","Impuestos", $IVA, $filtro, $idItem);
            $obCon->ActualizaRegistro("preventa","TotalVenta", $Total, $filtro, $idItem);
            $obCon->ActualizaRegistro("preventa","Cantidad", $Cantidad, $filtro, $idItem);
           
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
            $AnticiposCruzados=$obCon->normalizar($_REQUEST["AnticiposCruzados"]);
            
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
            
            if($AnticiposCruzados>0){
                $DatosCliente=$obCon->DevuelveValores("clientes", "idClientes", $DatosCotizacion["Clientes_idClientes"]);            
                $NIT=$DatosCliente["Num_Identificacion"];
                $ParametrosAnticipos=$obCon->DevuelveValores("parametros_contables", "ID", 20);//Aqui se encuentra la cuenta para los anticipos
                $CuentaAnticipos=$ParametrosAnticipos["CuentaPUC"];
                $sql="SELECT SUM(Debito) as Debito, SUM(Credito) AS Credito FROM librodiario WHERE CuentaPUC='$CuentaAnticipos' AND Tercero_Identificacion='$NIT'";
                $Consulta=$obCon->Query($sql);
                $DatosAnticipos=$obCon->FetchAssoc($Consulta);
                $SaldoAnticiposTercero=$DatosAnticipos["Credito"]-$DatosAnticipos["Debito"];
                
                if($SaldoAnticiposTercero<$AnticiposCruzados){
                    $Mensaje="El Cliente no cuenta con el anticipo registrado";
                    print("E3;$Mensaje");
                    exit();
                }
                
            }
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
            if($CmbFormaPago=='Contado'){
                $DatosCuenta=$obCon->DevuelveValores("subcuentas", "PUC", $CmbCuentaIngresoFactura);
                $CuentaDestino=$CmbCuentaIngresoFactura;
                $NombreCuentaDestino=$DatosCuenta["Nombre"];
            }else{
                $DatosCuenta=$obCon->DevuelveValores("parametros_contables", "ID", 6); //Cuenta Clientes
                $CuentaDestino=$DatosCuenta["CuentaPUC"];
                $NombreCuentaDestino=$DatosCuenta["NombreCuenta"];
            }
            $Datos["ID"]=$idFactura;
            $Datos["CuentaDestino"]=$CmbCuentaIngresoFactura;
            $obCon->InsertarFacturaLibroDiario($Datos);
            $obCon->DescargueFacturaInventarios($idFactura, "");
            if($CmbFormaPago<>'Contado'){
                $obFactura->IngreseCartera($idFactura, $Fecha, $idCliente, $CmbFormaPago, $SaldoFactura, "");
            }
            if($AnticiposCruzados>0){
                
                $obFactura->CruzarAnticipoAFactura($idFactura,$Fecha,$AnticiposCruzados,$CuentaDestino,$NombreCuentaDestino,"");
            }
            
            if($CmbColaboradores>0){
                $obCon->AgregueVentaColaborador($idFactura,$CmbColaboradores);
            }
            $LinkFactura="../../general/Consultas/PDF_Documentos.draw.php?idDocumento=2&ID=$idFactura";
            $Mensaje="<br><strong>Factura $NumFactura Creada Correctamente </strong><a href='$LinkFactura'  target='blank'> Imprimir</a>";
           
            print("OK;$Mensaje");
        break;//Fin caso 9
        
        case 10://Consulta si existe o no una cotizacion
            $idCotizacion=$obCon->normalizar($_REQUEST["idCotizacion"]);
            $DatosCotizacion=$obCon->DevuelveValores("cotizacionesv5", "ID", $idCotizacion);
            if($DatosCotizacion["ID"]==''){
                print("SD;"); //No existe el numero de cotizacion solicitado
            }
            if($DatosCotizacion["ID"]>0 AND $DatosCotizacion["Estado"]<>'Abierta'){
                $obCon->ActualizaRegistro("cotizacionesv5", "Estado", "Abierta", "ID", $idCotizacion);
                $DatosCliente=$obCon->DevuelveValores("clientes", "idClientes", $DatosCotizacion["Clientes_idClientes"]);
                print("OK;".$DatosCliente["RazonSocial"]); //Existe la cotizacion solicitada
            }
            if($DatosCotizacion["Estado"]=='Abierta'){
                print("AB;"); //La Cotizacion ya está abierta
            }
            
        break;//Fin caso 10
        
        case 11://Clonar una cotización
            $Fecha=date("Y-m-d");
            $idCotizacion=$obCon->normalizar($_REQUEST["idCotizacion"]);
            $DatosCotizacion=$obCon->DevuelveValores("cotizacionesv5", "ID", $idCotizacion);
            if($DatosCotizacion["ID"]==''){
                print("SD;"); //No existe el numero de cotizacion solicitado
                exit();
            }
            $idCotizacionNew=$obCon->CrearCotizacion($Fecha, $DatosCotizacion["Clientes_idClientes"], "", "");
            
            $obCon->CopiarItemsCotizacion($idCotizacion, $idCotizacionNew);
            
            $DatosCliente=$obCon->DevuelveValores("clientes", "idClientes", $DatosCotizacion["Clientes_idClientes"]);
            print("OK;$idCotizacionNew;".$DatosCliente["RazonSocial"]); //Existe la cotizacion solicitada
            
        break;//Fin caso 12
        
        case 12://Copiar los items de una cotización a otra
            $Fecha=date("Y-m-d");
            $idCotizacion=$obCon->normalizar($_REQUEST["idCotizacion"]);
            $idCotizacionActual=$obCon->normalizar($_REQUEST["idCotizacionActual"]);
            $DatosCotizacion=$obCon->DevuelveValores("cotizacionesv5", "ID", $idCotizacion);
            if($DatosCotizacion["ID"]==''){
                print("SD;"); //No existe el numero de cotizacion solicitado
                exit();
            }
            
            $obCon->CopiarItemsCotizacion($idCotizacion, $idCotizacionActual);
            
            print("OK;"); //Existe la cotizacion solicitada
            
        break;//Fin caso 12
        
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>