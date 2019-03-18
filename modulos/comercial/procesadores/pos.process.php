<?php

session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];
$fecha=date("Y-m-d");

include_once("../clases/Facturacion.class.php");
include_once("../../../modelo/PrintPos.php");
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
            
            if($CmbListado==1 or $CmbListado==5){
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
                $DatosProducto=$obCon->ValorActual($TablaItem, "PrecioVenta", "idProductosVenta='$Codigo'");
                if($DatosProducto["PrecioVenta"]==''){
                    print("E1;El Servicio $Codigo no Existe");
                    exit();
                }
                
                if($DatosProducto["PrecioVenta"]<=0){
                    print("E1;El precio de venta del Servicio $Codigo es menor o igual a Cero");
                    exit();
                }
                $obCon->POS_AgregaItemPreventa($Codigo, $TablaItem, $Cantidad, $idPreventa);
                print("OK;Servicio $Codigo Agregado");
                exit();
            }
            if($CmbListado==3){
                $TablaItem="productosalquiler";
                $DatosProducto=$obCon->ValorActual($TablaItem, "PrecioVenta", "idProductosVenta='$Codigo'");
                if($DatosProducto["PrecioVenta"]==''){
                    print("E1;El Producto para alquilar $Codigo no Existe");
                    exit();
                }
                
                if($DatosProducto["PrecioVenta"]<=0){
                    print("E1;El precio de venta del Producto para alquilar $Codigo es menor o igual a Cero");
                    exit();
                }
                $obCon->POS_AgregaItemPreventa($Codigo, $TablaItem, $Cantidad, $idPreventa);
                print("OK;Producto para alquilar $Codigo Agregado");
                exit();
                
            }
            if($CmbListado==4){
                $TablaItem="sistemas";
                $DatosProducto=$obCon->ValorActual($TablaItem, "Nombre", "ID='$Codigo'");
                if($DatosProducto["Nombre"]==''){
                    print("E1;El sistema $Codigo no Existe");
                    exit();
                }
                
                $obCon->POS_AgregueSistemaPreventa($idPreventa,$Codigo, $Cantidad, "");
                print("OK;Producto para alquilar $Codigo Agregado");
                exit();
            }
            
                       
        break;//Fin caso 2
        
        
        case 3://Se elimina un item
            $idItem=$obCon->normalizar($_REQUEST["idItem"]);
            $Tabla="preventa";
            $DatosPreventa=$obCon->DevuelveValores("preventa", "idPrecotizacion", $idItem);
            $DatoGenerales=$obCon->DevuelveValores("configuracion_general", "ID", 4); //Determina si se debe pedir autoirzacion para retornar un item
            if($DatoGenerales["Valor"]>0){ //Si está en 1 pedirá autorización
                if($DatosPreventa["Autorizado"]=='0'){
                    print("E1;Esta acción requiere autorización");
                    exit();
                }
            }
            
            $obCon->BorraReg($Tabla, "idPrecotizacion", $idItem);
            print("OK;Item Eliminado");
        break;//Fin caso 3
        
        
        case 4://Edita una cantidad
             
            $idItem=$obCon->normalizar($_REQUEST["idItem"]);            
            $Cantidad=$obCon->normalizar($_REQUEST["Cantidad"]);
            if($Cantidad==0){
                print("E1;No se puede editar la cantidad en cero");
                exit();
            }
            
            $DatosPreventa=$obCon->DevuelveValores("preventa", "idPrecotizacion", $idItem);
            $DatoGenerales=$obCon->DevuelveValores("configuracion_general", "ID", 3); //Determina si se debe pedir autoirzacion para retornar un item
            if($DatoGenerales["Valor"]>0){ //Si está en 1 pedirá autorización
                if($DatosPreventa["Autorizado"]=='0' and $Cantidad<0){
                    print("E1;Esta acción requiere autorización");
                    exit();
                }
            }
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
            
        break;//Fin caso 4
        
        case 5:// Editar el precio de venta de un item
            $idItem=$obCon->normalizar($_REQUEST['idItem']);            
            $ValorAcordado=$obCon->normalizar($_REQUEST["PrecioVenta"]);
            $Mayorista=$obCon->normalizar($_REQUEST["Mayorista"]);
            if($ValorAcordado<=0){
                print("OK;El Valor del producto debe ser mayor a cero");
                exit();
            }
            
            $DatosPreventa=$obCon->DevuelveValores("preventa", "idPrecotizacion", $idItem);
            $DatoGenerales=$obCon->DevuelveValores("configuracion_general", "ID", 5); //Determina si se debe pedir autoirzacion para retornar un item
            if($DatoGenerales["Valor"]>0){ //Si está en 1 pedirá autorización
                if($DatosPreventa["Autorizado"]=='0'){
                    print("E1;Esta acción requiere autorización");
                    exit();
                }
            }
            
            $obCon->POS_EditarPrecio($idItem,$ValorAcordado, $Mayorista);
            
            print("OK;Valor Editado");
        break;//Fin caso 5
        
                
        case 6://Obtiene los datos de la bascula
            
            $DatosCaja=$obCon->DevuelveValores("cajas", "idUsuario", $idUser);
            $idBascula=$DatosCaja["idBascula"];
            if($idBascula==''){
                print("E1;Usted no tiene una Caja Asignada");//No tiene caja asignada
                exit();
            }
            if($idBascula==0){
                print("E1;Usted No tiene una báscula asignada");//No tiene bascula asignada
                exit();
            }
            $DatosBascula=$obCon->DevuelveValores("registro_basculas", "idBascula", $idBascula);
            if($DatosBascula["Gramos"]==''){
                print("E1;No hay registros de la bascula");//No tiene bascula asignada
                exit();
            }
            
            print("OK;".$DatosBascula["Gramos"]); //Devuelve el dato registrado por la bascula en la base de datos
            
        break;//Fin caso 13
        
        case 7: //Guarda la factura
            $obPrint = new PrintPos($idUser);
            $obFactura = new Facturacion($idUser);
            
            $idPreventa=$obCon->normalizar($_REQUEST["idPreventa"]);       
            $Fecha=date("Y-m-d");
            $DatosCaja=$obCon->DevuelveValores("cajas", "idUsuario", $idUser);
            $idCentroCostos=$DatosCaja["CentroCostos"];
            $CmbResolucion=$DatosCaja["idResolucionDian"];
            $CmbFormaPago=$obCon->normalizar($_REQUEST["CmbFormaPago"]);
            $CmbFrecuente="NO";
            $CmbCuentaIngresoFactura=$DatosCaja["CuentaPUCEfectivo"];
            $CmbColaboradores=$obCon->normalizar($_REQUEST["CmbColaboradores"]);
            $Observaciones=$obCon->normalizar($_REQUEST["TxtObservacionesFactura"]);
            $AnticiposCruzados=$obCon->normalizar($_REQUEST["AnticiposCruzados"]);
            $idCliente=$obCon->normalizar($_REQUEST["idCliente"]);
            $idEmpresa=$DatosCaja["idEmpresa"];
            $idSucursal=$DatosCaja["idSucursal"];
            $Devuelta=$obCon->normalizar($_REQUEST["Devuelta"]);
            $Efectivo=$obCon->normalizar($_REQUEST["Efectivo"]);
            $Cheques=$obCon->normalizar($_REQUEST["Cheque"]);
            $Otros=$obCon->normalizar($_REQUEST["Otros"]);
            $Tarjetas=$obCon->normalizar($_REQUEST["Tarjetas"]);
            $CmbPrint=$obCon->normalizar($_REQUEST["CmbPrint"]);
            $FormaPagoFactura=$CmbFormaPago;
            if($CmbFormaPago<>"Contado"){
                $FormaPagoFactura="Credito a $CmbFormaPago dias";
            }
            
            
            $Hora=date("H:i:s");
            
            $sql="SELECT SUM(ValorAcordado) AS Subtotal, SUM(Impuestos) AS IVA, SUM(TotalVenta) as Total,SUM(CostoUnitario*Cantidad) AS TotalCostos "
                    . "FROM preventa WHERE VestasActivas_idVestasActivas='$idPreventa'";
            $Consulta=$obCon->Query($sql);
            $DatosTotalesCotizacion=$obCon->FetchAssoc($Consulta);
            $Subtotal=$DatosTotalesCotizacion["Subtotal"];
            $IVA=$DatosTotalesCotizacion["IVA"];
            $Total=$DatosTotalesCotizacion["Total"];
            $TotalCostos=$DatosTotalesCotizacion["TotalCostos"];
            $SaldoFactura=$Total;
            $Descuentos=0;
            
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
                        
            $NumFactura=$obFactura->CrearFactura($idFactura, $Fecha, $Hora, $CmbResolucion, "", "", $FormaPagoFactura, $Subtotal, $IVA, $Total, $Descuentos, $SaldoFactura, "", $idEmpresa, $idCentroCostos, $idSucursal, $idUser, $idCliente, $TotalCostos, $Observaciones, $Efectivo, $Devuelta, $Cheques, $Otros, $Tarjetas, 0, 0, "");
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
            
            $Datos["idPreventa"]=$idPreventa;
            $Datos["NumFactura"]=$NumFactura;
            $Datos["FechaFactura"]=$Fecha;
            $Datos["ID"]=$idFactura;
            $Datos["CuentaDestino"]=$CmbCuentaIngresoFactura;
            $Datos["EmpresaPro"]=$idEmpresa;
            $Datos["CentroCostos"]=$idCentroCostos;
            $obFactura->InsertarItemsPreventaAItemsFactura($Datos);
                
            //$obFactura->CopiarItemsCotizacionAItemsFactura($idCotizacion, $idFactura, $Fecha,$idUser, "");
            if($CmbFormaPago=='Contado'){
                $DatosCuenta=$obCon->DevuelveValores("subcuentas", "PUC", $CmbCuentaIngresoFactura);
                $CuentaDestino=$CmbCuentaIngresoFactura;
                $NombreCuentaDestino=$DatosCuenta["Nombre"];
            }else{
                $DatosCuenta=$obCon->DevuelveValores("parametros_contables", "ID", 6); //Cuenta Clientes
                $CuentaDestino=$DatosCuenta["CuentaPUC"];
                $NombreCuentaDestino=$DatosCuenta["NombreCuenta"];
            }
            
            $obFactura->InsertarFacturaLibroDiarioV2($idFactura,$CmbCuentaIngresoFactura,$idUser);
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
            $obFactura->BorraReg("preventa", "VestasActivas_idVestasActivas", $idPreventa);
            
            $DatosImpresora=$obCon->DevuelveValores("config_puertos", "ID", 1);
            if($DatosImpresora["Habilitado"]=="SI" AND $CmbPrint=='SI'){
                $obPrint->ImprimeFacturaPOS($idFactura,$DatosImpresora["Puerto"],1);
                $DatosTikete=$obVenta->DevuelveValores("config_tiketes_promocion", "ID", 1);
                if($TotalVenta>=$DatosTikete["Tope"] AND $DatosTikete["Activo"]=="SI"){
                    $VectorTiket["F"]=0;
                    $Copias=1;
                    if($DatosTikete["Multiple"]=="SI"){
                        $Copias=floor($TotalVenta/$DatosTikete["Tope"]);
                    }
                    $obPrint->ImprimirTiketePromo($idFactura,$DatosTikete["NombreTiket"],$DatosImpresora["Puerto"],$Copias,$VectorTiket);
                }
            }
            
            $LinkFactura="../../general/Consultas/PDF_Documentos.draw.php?idDocumento=2&ID=$idFactura";
            $Mensaje="<br><strong>Factura $NumFactura Creada Correctamente </strong><a href='$LinkFactura'  target='blank'> Imprimir</a>";
            $Mensaje.="<br><h3>Devuelta: ".number_format($Devuelta)."</h3>";
            
            
            print("OK;$Mensaje");
            
            
            
        break;//fin case 7
        
        case 8:
            $obPrint = new PrintPos($idUser);            
            $fecha=date("Y-m-d");
            $idPreventa=$obCon->normalizar($_REQUEST['idPreventa']);
            $Observaciones="";
            $idCliente=$obCon->normalizar($_REQUEST['idCliente']);
            $idCotizacion=$obCon->CotizarDesdePreventa($idPreventa,$fecha,$idCliente,$Observaciones,"");
            $obCon->BorraReg("preventa","VestasActivas_idVestasActivas",$idPreventa);
            $DatosImpresora=$obCon->DevuelveValores("config_puertos", "ID", 1);
            if($DatosImpresora["Habilitado"]=="SI"){
                $obPrint->ImprimeCotizacionPOS($idCotizacion,$DatosImpresora["Puerto"],1);
            }
            
            $RutaPrintCot="../../general/Consultas/PDF_Documentos.draw.php?idDocumento=1&ID=".$idCotizacion;			
            print("Cotización almacenada Correctamente <a href='$RutaPrintCot' target='_blank'>Imprimir Cotización No. $idCotizacion</a>");
            
        break;//fin caso 8
        
        case 9:
            
            $idPreventa=$obCon->normalizar($_REQUEST['idPreventa']);            
            $pw=$obCon->normalizar($_REQUEST['TxtAutorizaciones']);
            $pw=md5($pw);
            $sql="SELECT Identificacion FROM usuarios WHERE Password='$pw' AND (Role='ADMINISTRADOR' or Role='SUPERVISOR') LIMIT 1";
            $Datos=$obCon->Query($sql);
            $DatosAutorizacion=$obCon->FetchArray($Datos);

            if($DatosAutorizacion["Identificacion"]==''){
                print("E1;Clave incorrecta");
                exit();
            }
            $obCon->ActualizaRegistro("preventa", "Autorizado", $DatosAutorizacion["Identificacion"], "VestasActivas_idVestasActivas", $idPreventa);
        
            print("OK;Preventa $idPreventa Autorizada");
            
        break;//fin caso 9
        
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>