<?php 
include_once("../modelo/PrintPos.php");	
$obPrint=new PrintPos($idUser);
$obVenta=new ProcesoVenta($idUser);
$css =  new CssIni("Atencion");
////////////////////////////////////(///////////////////////////////
//////////////////////FUNCIONES CALCULAR DIGITO DE VERIFICACION/////////////////////////////////////
///////////////////////////////////////////////////////////////////

    
    function calcularDV($nit) {
        if (! is_numeric($nit)) {
            return false;
        }
     
        $arr = array(1 => 3, 4 => 17, 7 => 29, 10 => 43, 13 => 59, 2 => 7, 5 => 19, 
        8 => 37, 11 => 47, 14 => 67, 3 => 13, 6 => 23, 9 => 41, 12 => 53, 15 => 71);
        $x = 0;
        $y = 0;
        $z = strlen($nit);
        $dv = '';
        
        for ($i=0; $i<$z; $i++) {
            $y = substr($nit, $i, 1);
            $x += ($y*$arr[$z-$i]);
        }
        
        $y = $x%11;
        
        if ($y > 1) {
            $dv = 11-$y;
            return $dv;
        } else {
            $dv = $y;
            return $dv;
        }
        
    }
    
if(isset($_REQUEST['idDel'])){
    
    $idItem=$obVenta->normalizar($_REQUEST["idDel"]);
    $DatosItemBorrado=$obVenta->DevuelveValores("restaurante_pedidos_items", "ID", $idItem);
    $obVenta->BorraReg("restaurante_pedidos_items", "ID", $idItem);
    $css->CrearNotificacionRoja("Se ha borrado $DatosItemBorrado[NombreProducto] del pedido $DatosItemBorrado[idPedido]", 16);
}
if(isset($_REQUEST['del'])){
        $id=$obVenta->normalizar($_REQUEST['del']);
        $obVenta->BorraReg("restaurante_pedidos_items", "ID", $id);
        header("location:$myPage");
    }
//////Se descarta un Pedido
    if(isset($_REQUEST['BtnDescartarDomicilio'])){
        $idPedido=$obVenta->normalizar($_REQUEST['BtnDescartarDomicilio']);
        $obVenta->ActualizaRegistro("restaurante_pedidos", "Estado", "DEDO", "ID", $idPedido);
        $obVenta->ActualizaRegistro("restaurante_pedidos_items", "Estado", "DEDO", "idPedido", $idPedido);
        
        header("location:$myPage");
    }	
    
//Si se recibe la impresion de un pedido

    if(isset($_REQUEST['BtnImprimirDomicilio'])){
        $idPedido=$obVenta->normalizar($_REQUEST['BtnImprimirDomicilio']);
        $DatosImpresora=$obVenta->DevuelveValores("config_puertos", "ID", 1);
        if($DatosImpresora["Habilitado"]=="SI"){
            $obVenta->ImprimeDomicilioRestaurante($idPedido,$DatosImpresora["Puerto"],1,"");
        }
    }

//Si se recibe la impresion de una precuenta

   if(isset($_REQUEST['BtnImprimirPrecuenta'])){
       $idPedido=$obVenta->normalizar($_REQUEST['BtnImprimirPrecuenta']);
       $DatosImpresora=$obVenta->DevuelveValores("config_puertos", "ID", 1);
       if($DatosImpresora["Habilitado"]=="SI"){
           $obVenta->ImprimePrecuentaRestaurante($idPedido,$DatosImpresora["Puerto"],1);
       }
   }
if(isset($_REQUEST['BtnAgregar'])){
        $fecha=date("Y-m-d");
        $hora=date("H:i:s");
        
        $Cantidad=$obVenta->normalizar($_REQUEST["TxtCantidad"]);
        $idDomicilio=$obVenta->normalizar($_REQUEST["idDomicilio"]);
        $Observaciones=$obVenta->normalizar($_REQUEST["TxtObservaciones"]);
        $idProducto=$obVenta->normalizar($_REQUEST["idProducto"]);
        //$idDepartamento=$obVenta->normalizar($_REQUEST["idDepartamento"]);
        
        $obVenta->AgregueProductoADomicilio($idDomicilio,$fecha,$hora,$Cantidad,$idProducto,$Observaciones,"");
        $css->CrearNotificacionNaranja("Producto agregado al domicilio $idDomicilio", 16);
}

 //Si se Agrega Un Item a un Domicilio
        if(isset($_REQUEST['BtnCrearDomicilio'])){
            $fecha=date("Y-m-d");
            $hora=date("H:i:s");

            $idCliente=$obVenta->normalizar($_REQUEST["TxtClienteDomicilio"]);
            $DireccionEnvio=$obVenta->normalizar($_REQUEST["TxtDireccionEnvio"]);
            $TelefonoContacto=$obVenta->normalizar($_REQUEST["TxtTelefonoContacto"]);
            $Observaciones=$obVenta->normalizar($_REQUEST["TxtObservaciones"]);
            $idDomicilio=$obVenta->CreeDomicilio($fecha,$hora,$idCliente, $DireccionEnvio, $TelefonoContacto, $Observaciones, "");
            
            $css->CrearNotificacionNaranja("Producto agregado al pedido $idPedido", 16);
            header("location:$myPage?idDomicilio=$idDomicilio");
            
        }
        
        ////Se Crea un Cliente
	
	if(!empty($_REQUEST['BtnCrearCliente'])){
		
		
		//$idPreventa=$_REQUEST['CmbPreVentaAct'];
		$NIT=$obVenta->normalizar($_REQUEST['TxtNIT']);
                $idMun=$obVenta->normalizar($_REQUEST['CmbCodMunicipio']);
		$obVenta=new ProcesoVenta($idUser);
		$DatosClientes=$obVenta->DevuelveValores('clientes',"Num_Identificacion",$NIT);
                
                $DatosMunicipios=$obVenta->DevuelveValores('cod_municipios_dptos',"ID",$idMun);
		$DV="";
		
		
		if($DatosClientes["Num_Identificacion"]<>$NIT){
			
			///////////////////////////Ingresar a Clientes 
			
			if($_REQUEST['CmbTipoDocumento']==31){
			
				$DV=calcularDV($NIT);
		
			}
		
			$tab="clientes";
			$NumRegistros=15;  
								
			
			$Columnas[0]="Tipo_Documento";						$Valores[0]=$obVenta->normalizar($_REQUEST['CmbTipoDocumento']);
			$Columnas[1]="Num_Identificacion";					$Valores[1]=$obVenta->normalizar($_REQUEST['TxtNIT']);
			$Columnas[2]="DV";							$Valores[2]=$DV;
			$Columnas[3]="Primer_Apellido";						$Valores[3]=$obVenta->normalizar($_REQUEST['TxtPA']);
			$Columnas[4]="Segundo_Apellido";					$Valores[4]=$obVenta->normalizar($_REQUEST['TxtSA']);
			$Columnas[5]="Primer_Nombre";						$Valores[5]=$obVenta->normalizar($_REQUEST['TxtPN']);
			$Columnas[6]="Otros_Nombres";						$Valores[6]=$obVenta->normalizar($_REQUEST['TxtON']);
			$Columnas[7]="RazonSocial";						$Valores[7]=$obVenta->normalizar($_REQUEST['TxtRazonSocial']);
			$Columnas[8]="Direccion";						$Valores[8]=$obVenta->normalizar($_REQUEST['TxtDireccion']);
			$Columnas[9]="Cod_Dpto";						$Valores[9]=$DatosMunicipios["Cod_Dpto"];
			$Columnas[10]="Cod_Mcipio";						$Valores[10]=$DatosMunicipios["Cod_mcipio"];
			$Columnas[11]="Pais_Domicilio";						$Valores[11]=169;
			$Columnas[12]="Telefono";			    			$Valores[12]=$obVenta->normalizar($_REQUEST['TxtTelefono']);
			$Columnas[13]="Ciudad";			    				$Valores[13]=$DatosMunicipios["Ciudad"];
			$Columnas[14]="Email";			    				$Valores[14]=$obVenta->normalizar($_REQUEST['TxtEmail']);
			
			$obVenta->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
                        $tab="proveedores";
                        $obVenta->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
				
			print("<script language='JavaScript'>alert('Se ha creado el Cliente $_REQUEST[TxtRazonSocial]')</script>");
			
		}else{
			
			print("<script language='JavaScript'>alert('El cliente con Identificacion: $NIT, ya existe y no se puede crear nuevamente')</script>");
		}	

        header("location:$myPage");
		
			
	}
        
        
////Se guarda la Venta

if(isset($_REQUEST['TxtTotalH'])){

    $fecha=date("Y-m-d");
    $TotalVenta=$obVenta->normalizar($_REQUEST['TxtGranTotalH']);
    $idCliente=$obVenta->normalizar($_REQUEST["TxtCliente"]);
    $idColaborador=$obVenta->normalizar($_REQUEST["TxtidColaborador"]);
    $idPedido=$obVenta->normalizar($_REQUEST["idPedido"]);
    $Efectivo=$obVenta->normalizar($_REQUEST["TxtPaga"]);
    $Cheque=$obVenta->normalizar($_REQUEST["TxtPagaCheque"]);
    $Tarjeta=$obVenta->normalizar($_REQUEST["TxtPagaTarjeta"]);
    $idTarjeta=$obVenta->normalizar($_REQUEST["CmbIdTarjeta"]);
    $OtrosPaga=$obVenta->normalizar($_REQUEST["TxtPagaOtros"]);
    $Devuelta=$obVenta->normalizar($_REQUEST["TxtDevuelta"]);
    $CuentaDestino=$obVenta->normalizar($_REQUEST["TxtCuentaDestino"]);
    $TipoPago=$obVenta->normalizar($_REQUEST["TxtTipoPago"]);
    $Observaciones=$obVenta->normalizar($_REQUEST["TxtObservacionesFactura"]);
    $Domicilio=$obVenta->normalizar($_REQUEST["TxtDomicilio"]);
    $DatosVentaRapida["PagaCheque"]=$Cheque;
    $DatosVentaRapida["PagaTarjeta"]=$Tarjeta;
    $DatosVentaRapida["idTarjeta"]=$idTarjeta;
    $DatosVentaRapida["PagaOtros"]=$OtrosPaga;
    $DatosCaja=$obVenta->DevuelveValores("cajas", "idUsuario", $idUser);
    $DatosVentaRapida["CentroCostos"]=$DatosCaja["CentroCostos"];
    $DatosVentaRapida["ResolucionDian"]=$DatosCaja["idResolucionDian"];
    $DatosVentaRapida["Observaciones"]=$Observaciones;
    if($TipoPago<>"Contado" AND $idCliente<=1){
        print("<script>alert('Debe seleccionar un Cliente para realizar una venta a credito')</script>");
        exit("<a href='$myPage' ><h1>Volver</h1></a>");
    }
    if($TipoPago<>"Contado"){
        $Efectivo=0;
        $DatosVentaRapida["PagaCheque"]=0;
        $DatosVentaRapida["PagaTarjeta"]=0;
        $DatosVentaRapida["idTarjeta"]=0;
        $DatosVentaRapida["PagaOtros"]=0;
    }
    ///Ojo Modificar esta parte
    $NumFactura=$obVenta->RegistreVentaRestaurante($idPedido, $idCliente, $TipoPago, $Efectivo, $Devuelta, $CuentaDestino, $DatosVentaRapida);


    if($Domicilio==0){ //Con esto le decimos que es una factura producida por un pedido
        $Marca="FAPE";
    }
    if($Domicilio==1){ //Con esto le decimos que es una factura producida por un domicilio
        $Marca="FADO";
    }
    $obVenta->ActualizaRegistro("restaurante_pedidos","Estado", $Marca, "ID", $idPedido);
    $obVenta->ActualizaRegistro("restaurante_pedidos_items","Estado", $Marca, "idPedido", $idPedido);
    $DatosImpresora=$obVenta->DevuelveValores("config_puertos", "ID", 1);
    if($DatosImpresora["Habilitado"]=="SI"){
        $obPrint->ImprimeFacturaPOS($NumFactura,$DatosImpresora["Puerto"],1);
        $DatosTikete=$obVenta->DevuelveValores("config_tiketes_promocion", "ID", 1);
        if($TotalVenta>=$DatosTikete["Tope"] AND $DatosTikete["Activo"]=="SI"){
            $VectorTiket["F"]=0;
            $Copias=1;
            if($DatosTikete["Multiple"]=="SI"){
                $Copias=floor($TotalVenta/$DatosTikete["Tope"]);
            }
            $obPrint->ImprimirTiketePromo($NumFactura,$DatosTikete["NombreTiket"],$DatosImpresora["Puerto"],$Copias,$VectorTiket);
        }
    }

    if(!empty($idColaborador)){
        $obVenta->AgregueVentaColaborador($NumFactura,$idColaborador);
    }
    header("location:$myPage?TxtidFactura=$NumFactura");

}
//Si se pide editar un domicilio

if(isset($_REQUEST["BtnEditarDomicilioGeneral"])){
    $Fecha=$obVenta->normalizar($_REQUEST["TxtFechaEdit"]);
    $idCliente=$obVenta->normalizar($_REQUEST["CmbTerceroEdit"]);
    $DireccionEnvio=$obVenta->normalizar($_REQUEST["TxtDireccionEnvioEdit"]);
    $TelefonoConfirmacion=$obVenta->normalizar($_REQUEST["TxtTelefonoConfirmacionEdit"]);
    $Observaciones=$obVenta->normalizar($_REQUEST["TxtObservacionesEdit"]);
    $idPedido=$obVenta->normalizar($_REQUEST["idDomicilio"]);
    $DatosCliente=$obVenta->DevuelveValores("clientes", "idClientes", $idCliente);
    $obVenta->ActualizaRegistro("restaurante_pedidos", "Fecha", $Fecha, "ID", $idPedido,0);
    $obVenta->ActualizaRegistro("restaurante_pedidos", "DireccionEnvio", $DireccionEnvio, "ID", $idPedido,0);
    $obVenta->ActualizaRegistro("restaurante_pedidos", "TelefonoConfirmacion", $TelefonoConfirmacion, "ID", $idPedido,0);
    $obVenta->ActualizaRegistro("restaurante_pedidos", "Observaciones", $Observaciones, "ID", $idPedido,0);
    $obVenta->ActualizaRegistro("restaurante_pedidos", "NombreCliente", $DatosCliente["RazonSocial"], "ID", $idPedido,0);
    $obVenta->ActualizaRegistro("restaurante_pedidos", "idCliente", $idCliente, "ID", $idPedido,0);
    header("location:$myPage?idDomicilio=$idPedido");
}
?>