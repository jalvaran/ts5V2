<?php
session_start();
$idUser=$_SESSION['idUser'];
include_once '../../modelo/php_conexion.php';
include_once("../clases/Restaurante.class.php");
include_once("../../modelo/PrintPos.php");      //Imprime documentos en la impresora pos
$obRest = new Restaurante($idUser);

if( !empty($_REQUEST["idDepartamento"]) and !empty($_REQUEST["Cantidad"]) and !empty($_REQUEST["idProducto"])){
        $idMesa="";
        if(!empty($_REQUEST["idMesa"])){
            $idMesa=$obRest->normalizar($_REQUEST["idMesa"]);
        }
        
        $idPedido="";
        if(!empty($_REQUEST["idPedido"])){
            
            $idPedido=$obRest->normalizar($_REQUEST["idPedido"]);
        }
        $idDepartamento=$obRest->normalizar($_REQUEST["idDepartamento"]);
        $Cantidad=$obRest->normalizar($_REQUEST["Cantidad"]);
        $idProducto=$obRest->normalizar($_REQUEST["idProducto"]);
        $Observaciones="";
        if(isset($_REQUEST["Observaciones"])){
            $Observaciones=$obRest->normalizar($_REQUEST["Observaciones"]);
        }
        $fecha=date("Y-m-d");
        $hora=date("H:i:s");
        
        if(empty($_REQUEST["idPedido"])){
            $idPedido=$obRest->AgregueProductoAPedido($idMesa, $fecha, $hora, $Cantidad, $idProducto, $Observaciones,$idUser, "");
            $Respuesta["msg"]="OK";
            $Respuesta["idPedido"]=$idPedido;
            echo json_encode($Respuesta);
        }
         
        if(!empty($_REQUEST["idPedido"])){
            $obRest->AgregueProductoADomicilio($idPedido, $fecha, $hora, $Cantidad, $idProducto, $Observaciones, $idUser, "");
            $Respuesta["msg"]="OK";
            $Respuesta["idPedido"]=$idPedido;
            echo json_encode($Respuesta);   
        }
    
    
}else{
    if(!isset($_REQUEST["Accion"])){
        $Respuesta["msg"]="SD";
        echo json_encode($Respuesta);
    }
    
}
    

if(isset($_REQUEST["Accion"])){
    switch($_REQUEST["Accion"]){
        //Eliminar un item de un pedido
        case 'DEL':
            $idItemDel=$obRest->normalizar($_REQUEST["idItem"]);
            $Observaciones=$obRest->normalizar($_REQUEST["Observaciones"]);
            $idPedido=$obRest->normalizar($_REQUEST["idPedido"]);
            $obRest->ElimineItemPedido($idItemDel, $idPedido, $Observaciones,$idUser, "");
            $Respuesta["msg"]="OK";
            $Respuesta["idPedido"]=$idPedido;
            $Respuesta["idItem"]=$idItemDel;
            $Respuesta["Observaciones"]=$Observaciones;
            echo json_encode($Respuesta); 
        break;
        //Crear un Domicilio
        case 'ADD_DOM':
            $Telefono=$obRest->normalizar($_REQUEST["Telefono"]);
            $Nombre=$obRest->normalizar($_REQUEST["Nombre"]);
            $Direccion=$obRest->normalizar($_REQUEST["Direccion"]);
            if($Telefono=="" or $Nombre=="" or $Direccion==""){
                $Respuesta["msg"]="SD";
                $Respuesta["idPedido"]=$idDomicilio;
                exit();
            }
            $Observaciones=$obRest->normalizar($_REQUEST["Observaciones"]);
            $fecha=date("Y-m-d");
            $hora=date("H:i:s");

            $idDomicilio=$obRest->CreeDomicilio($fecha, $hora, 1, $Nombre,$Direccion, $Telefono, $Observaciones,$idUser, "");
            $Respuesta["msg"]="OK";
            $Respuesta["idPedido"]=$idDomicilio;
            
            echo json_encode($Respuesta); 
        break;
    
    //Crear un para llevar
        case 'ADD_LLE':
            $Telefono=$obRest->normalizar($_REQUEST["Telefono"]);
            $Nombre=$obRest->normalizar($_REQUEST["Nombre"]);
            $Direccion=$obRest->normalizar($_REQUEST["Direccion"]);
            if($Telefono=="" or $Nombre=="" or $Direccion==""){
                $Respuesta["msg"]="SD";
                $Respuesta["idPedido"]=$idDomicilio;
                exit();
            }
            $Observaciones=$obRest->normalizar($_REQUEST["Observaciones"]);
            $fecha=date("Y-m-d");
            $hora=date("H:i:s");
            $Vector["Llevar"]=1;
            $idDomicilio=$obRest->CreeDomicilio($fecha, $hora, 1, $Nombre,$Direccion, $Telefono, $Observaciones,$idUser, $Vector);
            $Respuesta["msg"]="OK";
            $Respuesta["idPedido"]=$idDomicilio;
            
            echo json_encode($Respuesta); 
        break;
        case 'Alertas':
            $DatosAlertas=$obRest->ConsulteAlertasPedidos("");
            if($DatosAlertas<>""){
                echo json_encode($DatosAlertas); 
            }
            
        break;
    
        //Descartar pedido 
        case 1:
            //$obPrint=new PrintPos($idUser);
            $idPedido=$obRest->normalizar($_REQUEST["idPedido"]);
            $Observaciones=$obRest->normalizar($_REQUEST["Observaciones"]);
            $obRest->ActualizaRegistro("restaurante_pedidos", "Estado", "DEPE", "ID", $idPedido);
            $obRest->ActualizaRegistro("restaurante_pedidos", "Observaciones", $Observaciones, "ID", $idPedido);
            $obRest->ActualizaRegistro("restaurante_pedidos_items", "Estado", "DEPE", "idPedido", $idPedido);
            $Respuesta["msg"]="OK";
            
            echo json_encode($Respuesta); 
        break;
    
        //Descartar Domicilio 
        case 2:
            //$obPrint=new PrintPos($idUser);
            $idPedido=$obRest->normalizar($_REQUEST["idPedido"]);
            $Observaciones=$obRest->normalizar($_REQUEST["Observaciones"]);
            $obRest->ActualizaRegistro("restaurante_pedidos", "Estado", "DEDO", "ID", $idPedido);
            $obRest->ActualizaRegistro("restaurante_pedidos", "Observaciones", $Observaciones, "ID", $idPedido);
            $obRest->ActualizaRegistro("restaurante_pedidos_items", "Estado", "DEDO", "idPedido", $idPedido);
            $Respuesta["msg"]="OK";
            
            echo json_encode($Respuesta); 
        break;
    
        //Descartar Un Para LLevar 
        case 3:
            //$obPrint=new PrintPos($idUser);
            $idPedido=$obRest->normalizar($_REQUEST["idPedido"]);
            $Observaciones=$obRest->normalizar($_REQUEST["Observaciones"]);
            $obRest->ActualizaRegistro("restaurante_pedidos", "Estado", "DELL", "ID", $idPedido);
            $obRest->ActualizaRegistro("restaurante_pedidos", "Observaciones", $Observaciones, "ID", $idPedido);
            $obRest->ActualizaRegistro("restaurante_pedidos_items", "Estado", "DELL", "idPedido", $idPedido);
            $Respuesta["msg"]="OK";
            
            echo json_encode($Respuesta); 
        break;
    
    //imprimir un pedido
        case 4:
            $obPrint=new PrintPos($idUser);
            $idPedido=$obRest->normalizar($_REQUEST["idPedido"]);
            $obPrint->ImprimePedidoRestaurante($idPedido,"",1,"");
            $Respuesta["msg"]="OK";
            
            echo json_encode($Respuesta); 
        break;
    
    //imrpimir un Domicilio 
        case 5:
            $obPrint=new PrintPos($idUser);
            $idPedido=$obRest->normalizar($_REQUEST["idPedido"]);
            $obPrint->ImprimeDomicilioRestaurante($idPedido,"",2,"");
            $Respuesta["msg"]="OK";
            
            echo json_encode($Respuesta); 
        break;
    
    //imrpimir un para llevar 
        case 6:
            $obPrint=new PrintPos($idUser);
            $idPedido=$obRest->normalizar($_REQUEST["idPedido"]);
            $obPrint->ImprimeDomicilioRestaurante($idPedido,"",1,"");
            $Respuesta["msg"]="OK";
            
            echo json_encode($Respuesta); 
        break;
    
        //imrpimir precuenta
        case 7:
            $obPrint=new PrintPos($idUser);
            $idPedido=$obRest->normalizar($_REQUEST["idPedido"]);
            $obPrint->ImprimePrecuentaRestaurante($idPedido,"",1,"");
            $Respuesta["msg"]="OK";
            
            echo json_encode($Respuesta); 
        break;
    
    //Crear la factura
        case 8:
            $obPrint=new PrintPos($idUser);
            $fecha=date("Y-m-d");
            $DatosCaja=$obRest->DevuelveValores("cajas", "idUsuario", $idUser);
            
            $idCliente=$obRest->normalizar($_REQUEST["idCliente"]);
            if($idCliente==""){
                $idCliente=1;
            }
            $idColaborador=$obRest->normalizar($_REQUEST["CmbColaboradores"]);
            $idPedido=$obRest->normalizar($_REQUEST["idPedido"]);
            $DatosPedido=$obRest->DevuelveValores("restaurante_pedidos", "ID", $idPedido);
            $Efectivo=$obRest->normalizar($_REQUEST["TxtEfectivo"]);
            $PropinaEfectivo=$obRest->normalizar($_REQUEST["TxtPropinaEfectivo"]);
            $PropinaTarjetas=$obRest->normalizar($_REQUEST["TxtPropinaTarjetas"]);
            
            $Print="S";
            if($Efectivo=="NA"){
                $DatosVistaPedido=$obRest->DevuelveValores("vista_pedidos_restaurante", "ID", $idPedido);
                $Efectivo=$DatosVistaPedido["Total"];
                $Print="N";
            }
            $Cheque=$obRest->normalizar($_REQUEST["TxtCheques"]);
            $Tarjeta=$obRest->normalizar($_REQUEST["TxtTarjetas"]);
            
            $OtrosPaga=$obRest->normalizar($_REQUEST["TxtBonos"]);
            $Devuelta=$obRest->normalizar($_REQUEST["TxtDevuelta"]);
            $CuentaDestino=$DatosCaja["CuentaPUCEfectivo"];
            $TipoPago=$obRest->normalizar($_REQUEST["CmbTipoPago"]);
            $Observaciones="";
            if(isset($_REQUEST["TxtObservaciones"])){
                $Observaciones=$obRest->normalizar($_REQUEST["TxtObservaciones"]);
            }
            
            
            $DatosVentaRapida["PagaCheque"]=$Cheque;
            $DatosVentaRapida["PagaTarjeta"]=$Tarjeta;
            $DatosVentaRapida["idTarjeta"]=1;
            $DatosVentaRapida["PagaOtros"]=$OtrosPaga;
            
            $DatosVentaRapida["CentroCostos"]=$DatosCaja["CentroCostos"];
            $DatosVentaRapida["ResolucionDian"]=$DatosCaja["idResolucionDian"];
            $DatosVentaRapida["Observaciones"]=$Observaciones;
            if($TipoPago<>"Contado" AND $idCliente<=1){
                $Respuesta["msg"]="E";
                $Respuesta["Error"]="Para poder hacer una venta a credito se ddebe seleccionar un cliente";
                echo json_encode($Respuesta);
                exit();
            }
            if($TipoPago<>"Contado"){
                $Efectivo=0;
                $DatosVentaRapida["PagaCheque"]=0;
                $DatosVentaRapida["PagaTarjeta"]=0;
                $DatosVentaRapida["idTarjeta"]=0;
                $DatosVentaRapida["PagaOtros"]=0;
            }
            $idFactura=$obRest->RegistreVentaRestaurante($idPedido, $idCliente, $TipoPago, $Efectivo, $Devuelta, $CuentaDestino,$idUser, $DatosVentaRapida);
            if($DatosPedido["Estado"]=="DO"){
                $Estado="FADO";
            }
            if($DatosPedido["Estado"]=="AB"){
                $Estado="FAPE";
            }
            if($DatosPedido["Estado"]=="LL"){
                $Estado="FALL";
            }
            
            $obRest->ActualizaRegistro("restaurante_pedidos", "Estado", $Estado, "ID", $idPedido);
            $obRest->ActualizaRegistro("restaurante_pedidos_items", "Estado", $Estado, "idPedido", $idPedido);
            
            
            if($PropinaEfectivo>0 or $PropinaTarjetas>0){
                $obRest->PropinasRegistro($CuentaDestino,$idFactura,$idColaborador,$PropinaEfectivo,$PropinaTarjetas,"");
            }
			
			if($Print=="S"){
                $obPrint->ImprimeFacturaPOS($idFactura, "", 1);
            }
            
            $Respuesta["msg"]="OK";
            $Respuesta["TipoPedido"]=$DatosPedido["Estado"];
            echo json_encode($Respuesta); 
            
        break;
        
        case 9:
            $obPrint=new PrintPos($idUser);
            $idCierre=$obRest->CierreTurnoRestaurante("",$idUser);
            $obPrint->ImprimirCierreRestaurante($idCierre,"",1,"");
            $Respuesta["msg"]="OK";
            $Respuesta["idCierre"]=$idCierre;
            echo json_encode($Respuesta);
        break;
    
    }
}
