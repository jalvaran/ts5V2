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
            
        break;//Fin caso 4
        
        case 5:// Editar el precio de venta de un item
            $idItem=$obCon->normalizar($_REQUEST['idItem']);            
            $ValorAcordado=$obCon->normalizar($_REQUEST["PrecioVenta"]);
            $Mayorista=$obCon->normalizar($_REQUEST["Mayorista"]);
            if($ValorAcordado<=0){
                print("OK;El Valor del producto debe ser mayor a cero");
                exit();
            }
            
            $obCon->POS_EditarPrecio($idItem,$ValorAcordado, $Mayorista);
            
            print("OK;Valor Editado");
        break;//Fin caso 5
        
        
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