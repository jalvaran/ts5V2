<?php 
include_once("../modelo/PrintPos.php");	
$obPrint=new PrintPos($idUser);
$obVenta=new ProcesoVenta($idUser);
$obTabla = new Tabla($db);
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
    
    if(isset($_REQUEST['del'])){
        $id=$obVenta->normalizar($_REQUEST['del']);
        $obVenta->BorraReg("restaurante_pedidos_items", "ID", $id);
        header("location:$myPage");
    }
    //////Se descarta un Pedido
    if(isset($_REQUEST['BtnDescartarPedido'])){
        $idPedido=$obVenta->normalizar($_REQUEST['BtnDescartarPedido']);
        $obVenta->ActualizaRegistro("restaurante_pedidos", "Estado", "DEPE", "ID", $idPedido);
        $obVenta->ActualizaRegistro("restaurante_pedidos_items", "Estado", "DEPE", "idPedido", $idPedido);
        header("location:$myPage");
    }
    
    //////Se descarta un Pedido
    if(isset($_REQUEST['BtnCerrarTurnoRestaurante'])){
        
        $idCierre=$obVenta->CierreTurnoRestaurante("");
        
        $DatosImpresora=$obVenta->DevuelveValores("config_puertos", "ID", 1);
        if($DatosImpresora["Habilitado"]=="SI"){
            $obPrint->ImprimirCierreRestaurante($idCierre,$DatosImpresora["Puerto"],1,"");
        }
        header("location:$myPage?idCierre=$idCierre");
    }
    
   
	////Se recibe edicion
	
	if(!empty($_REQUEST['BtnEditarCantidad'])){
		$obVenta=new ProcesoVenta($idUser);
		$idItem=$_REQUEST['TxtPrecotizacion'];
		//$idClientes=$_REQUEST['TxtIdCliente'];
                $idPreventa=$_REQUEST['CmbPreVentaAct'];
		
		$Cantidad=$_REQUEST["TxtEditar$idItem"];
                //echo " $Cantidad $idItem";
		//$ValorAcordado=$_REQUEST['TxtValorUnitario'];
                $VariableURL="";
                if($Cantidad==0){
                    $VariableURL="CantidadCero=1";
                    
                }
                if($Cantidad<>0){
                    $DatosPreventa=$obVenta->DevuelveValores("preventa", "idPrecotizacion", $idItem);
                    $ValorAcordado=$DatosPreventa["ValorAcordado"];
                    $idProducto=$DatosPreventa["ProductosVenta_idProductosVenta"];
                    $Tabla=$DatosPreventa["TablaItem"];
                    $Subtotal=$ValorAcordado*$Cantidad;
                    $DatosProductos=$obVenta->DevuelveValores($Tabla,"idProductosVenta",$idProducto);
                    $IVA=$Subtotal*$DatosProductos["IVA"];
                    $SubtotalCosto=$DatosProductos["CostoUnitario"]*$Cantidad;
                    $Total=$Subtotal+$IVA;
                    $filtro="idPrecotizacion";

                    $obVenta->ActualizaRegistro("preventa","Subtotal", $Subtotal, $filtro, $idItem);
                    $obVenta->ActualizaRegistro("preventa","Impuestos", $IVA, $filtro, $idItem);
                    $obVenta->ActualizaRegistro("preventa","TotalVenta", $Total, $filtro, $idItem);
                    $obVenta->ActualizaRegistro("preventa","Cantidad", $Cantidad, $filtro, $idItem);
                }
		
		header("location:$myPage?CmbPreVentaAct=$idPreventa&$VariableURL");
			
	}
        //Si se recibe la impresion de un pedido
       
	if(isset($_REQUEST['BtnImprimirPedido'])){
            $idPedido=$obVenta->normalizar($_REQUEST['BtnImprimirPedido']);
            $DatosImpresora=$obVenta->DevuelveValores("config_puertos", "ID", 1);
            if($DatosImpresora["Habilitado"]=="SI"){
                $obVenta->ImprimePedidoRestaurante($idPedido,$DatosImpresora["Puerto"],1,"");
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
        
        
        /*
         * 
         * Imprimo el Cierre
         */
        
        ////Se Crea un Cliente
	
        if(!empty($_REQUEST['BtnCerrarTurno'])){
            
            $obVenta=new ProcesoVenta($idUser);
            $fecha=date("Y-m-d");
            $VectorCierre["Fut"]=0;
            $idCaja=1;
            $idCierre=$obVenta->CierreTurno($idUser,$idCaja,$VectorCierre);
            $VectorCierre["idCierre"]=$idCierre;
            $DatosImpresora=$obVenta->DevuelveValores("config_puertos", "ID", 1);
                        
                if($DatosImpresora["Habilitado"]=="SI"){
                    
                    $obVenta->ImprimeCierre($idUser,$VectorCierre,$DatosImpresora["Puerto"],1);
                }
        }
        
        
       
         /*
         * Registra egresos 
         */
        
              
        if(isset($_REQUEST['BtnCrearEgreso'])){
            
            $obVenta=new ProcesoVenta($idUser);
            $fecha=date("Y-m-d");
            $FechaProgramada=$fecha;
            $CuentaDestino=$obVenta->normalizar($_REQUEST['CmbCuentaDestino']);
            $NumFact=$obVenta->normalizar($_REQUEST["TxtNumFactura"]);
            $Concepto=$obVenta->normalizar($_REQUEST["TxtConcepto"]);
            $idProveedor=$obVenta->normalizar($_REQUEST["CmbProveedores"]);
            $Subtotal=$obVenta->normalizar($_REQUEST["TxtSubtotalEgreso"]);
            $IVA=$obVenta->normalizar($_REQUEST["TxtIVAEgreso"]);
            $Total=$obVenta->normalizar($_REQUEST["TxtValorEgreso"]);
            
            if($idProveedor<=0){
                print("<script>alert('Debe seleccionar un Proveedor para poder ejecutar esta accion')</script>");
                exit("<a href='$myPage' ><h1>Volver</h1></a>");
            }
            
            if($CuentaDestino<=0){
                print("<script>alert('Debe seleccionar un egreso para poder ejecutar esta accion')</script>");
                exit("<a href='$myPage' ><h1>Volver</h1></a>");
            }
            $destino="";
            if(!empty($_FILES['foto']['name'])){
                 //echo "<script>alert ('entra foto')</script>";
                $carpeta="../SoportesEgresos/";
                opendir($carpeta);
                $Name=str_replace(' ','_',$_FILES['foto']['name']);  
                $destino=$carpeta.$Name;
                move_uploaded_file($_FILES['foto']['tmp_name'],$destino);
            }
            
            
                
            //Pendientes por definir de donde tomar los valores
            $DatosCaja=$obVenta->DevuelveValores("cajas", "idUsuario", $idUser);
            
            $CuentaOrigen=$DatosCaja["CuentaPUCEfectivo"];
            $CentroCostos=$DatosCaja["CentroCostos"];
            $CuentaPUCIVA=$DatosCaja["CuentaPUCIVAEgresos"];
            ///
            //Constantes para este caso
            $TipoEgreso="VentasRapidas";
            $TipoPago="Contado";
            $Sanciones=0;
            $Intereses=0;
            $Impuestos=0;
            $ReteFuente=0;
            $ReteIVA=0;
            $ReteICA=0;
            $VectorEgreso["Fut"]=0;  //Uso futuro
            ///                
            
            $idEgreso=$obVenta->CrearEgreso($fecha,$FechaProgramada,$idUser,$CentroCostos,$TipoPago,$CuentaOrigen,$CuentaDestino,$CuentaPUCIVA,$idProveedor, $Concepto,$NumFact,$destino,$TipoEgreso,$Subtotal,$IVA,$Total,$Sanciones,$Intereses,$Impuestos,$ReteFuente,$ReteIVA,$ReteICA,$VectorEgreso);
            
            $DatosImpresora=$obVenta->DevuelveValores("config_puertos", "ID", 1);
            $VectorEgresos["Fut"]=1;
            if($DatosImpresora["Habilitado"]=="SI"){
                $obVenta->ImprimeEgresoPOS($idEgreso,$VectorEgresos,$DatosImpresora["Puerto"],1);
                    
            }
            header("location:$myPage?TxtIdEgreso=$idEgreso");
        }
        
       
        
        ///////////////Fin
        
	?>