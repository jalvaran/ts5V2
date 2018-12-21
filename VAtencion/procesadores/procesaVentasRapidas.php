<?php 
include_once("../modelo/PrintPos.php");	
$obPrint=new PrintPos($idUser);
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
    
    
   
	

	//////Creo una Preventa
	if(!empty($_REQUEST['BtnAgregarPreventa'])){
		
		$obVenta=new ProcesoVenta($idUser);
		$obVenta->CrearPreventa($idUser);// Crea otra preventa
		header("location:$myPage");
	}
	
	if(!empty($_REQUEST['TxtCodigoBarras'])){
		
		$CodBar=$_POST['TxtCodigoBarras'];
		$obVenta=new ProcesoVenta($idUser);
                $TablaItem="productosventa";
		$DatosCodigo=$obVenta->DevuelveValores('prod_codbarras',"CodigoBarras",$CodBar);
		//$DatosPreventa=$obVenta->DevuelveValores('vestasactivas',"idVestasActivas",$idPreventa);
		$fecha=date("Y-m-d");
		$Cantidad=1;
		if($DatosCodigo['ProductosVenta_idProductosVenta']>0){
			
			$obVenta->AgregaPreventa($fecha,$Cantidad,$idPreventa,$DatosCodigo['ProductosVenta_idProductosVenta'],$TablaItem);
		}else{
                        $DatosProducto=$obVenta->DevuelveValores("productosventa", "idProductosVenta", $CodBar);
                        if($DatosProducto["idProductosVenta"]){
                            $obVenta->AgregaPreventa($fecha,$Cantidad,$idPreventa,$DatosProducto['idProductosVenta'],$TablaItem);
                        }
			print('<script language="JavaScript">alert("Este producto no esta en la base de datos por favor no lo entregue")</script>');
			
		}
		header("location:$myPage?CmbPreVentaAct=$idPreventa");	
	}
	
	if(!empty($_REQUEST['del'])){
		$id=$_REQUEST['del'];
		$Tabla=$_REQUEST['TxtTabla'];
		$IdTabla=$_REQUEST['TxtIdTabla'];
		$IdPre=$_REQUEST['TxtIdPre'];
		$obVenta->Query("DELETE FROM $Tabla WHERE $IdTabla='$id'");
		header("location:$myPage?CmbPreVentaAct=$IdPre");
	}
		
	if(!empty($_REQUEST['TxtAgregarItemPreventa'])){
		
		
                $obVenta=new ProcesoVenta($idUser);
                $idItem=$obVenta->normalizar($_REQUEST['TxtAgregarItemPreventa']);
		$TablaItem=$obVenta->normalizar($_REQUEST['TxtTablaItem']);
                $Cantidad=$obVenta->normalizar($_REQUEST['TxtCantidad']);
                $fecha=date("Y-m-d");
                $ValorAcordado=0;
                if(isset($_REQUEST['TxtValorAcordadoBascula'])){
                    $ValorAcordado=$obVenta->normalizar($_REQUEST['TxtValorAcordadoBascula']);
                }
                
                if(isset($_REQUEST['Bascula'])){
                    $obVenta->update("registro_basculas", "Leido", 1, "WHERE idBascula='1'");
                    
                }
                if($TablaItem=="sistemas"){
                    $obVenta->AgregueSistemaPreventa($idPreventa, $idItem, $Cantidad, "");
                }else{
                    $obVenta->AgregaPreventa($fecha,$Cantidad,$idPreventa,$idItem,$TablaItem,$ValorAcordado);
                }
                
                
		header("location:$myPage?CmbPreVentaAct=$idPreventa");
			
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
                    $DatosImpuestosAdicionales=$obVenta->DevuelveValores("productos_impuestos_adicionales", "idProducto", $idProducto);
                    $IVA=$Subtotal*$DatosProductos["IVA"]+($DatosImpuestosAdicionales["ValorImpuesto"]*$Cantidad);
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
        
        ////Se recibe edicion
	
	if(!empty($_REQUEST['BtnEditar']) or isset($_REQUEST['BtnMayorista'])){
		$obVenta=new ProcesoVenta($idUser);
		$idItem=$_REQUEST['TxtPrecotizacion'];
		//$idClientes=$_REQUEST['TxtIdCliente'];
                $idPreventa=$_REQUEST['CmbPreVentaAct'];
		
		$ValorAcordado=$_REQUEST["TxtEditarPrecio$idItem"];
                //echo "<script>alert('Item $idItem VA $ValorAcordado')</script>";
		//$ValorAcordado=$_REQUEST['TxtValorUnitario'];
                $DatosPreventa=$obVenta->DevuelveValores("preventa", "idPrecotizacion", $idItem);
		$Cantidad=$DatosPreventa["Cantidad"];
		$idProducto=$DatosPreventa["ProductosVenta_idProductosVenta"];
                
		$Tabla=$DatosPreventa["TablaItem"];
                $DatosProductos=$obVenta->DevuelveValores($Tabla,"idProductosVenta",$idProducto);
                if(isset($_REQUEST['BtnMayorista'])){
                    $ValorAcordado=$DatosProductos["PrecioMayorista"];
                }
                $DatosTablaItem=$obVenta->DevuelveValores("tablas_ventas", "NombreTabla", $Tabla);
                if($DatosTablaItem["IVAIncluido"]=="SI"){
                    
                    $ValorAcordado=$ValorAcordado/($DatosProductos["IVA"]+1);
                    
                }
		$Subtotal=$ValorAcordado*$Cantidad;
		
                
		$IVA=$Subtotal*$DatosProductos["IVA"];
		//$SubtotalCosto=$DatosProductos["CostoUnitario"]*$Cantidad;
		$Total=$Subtotal+$IVA;
		$filtro="idPrecotizacion";
		
		$obVenta->ActualizaRegistro("preventa","Subtotal", $Subtotal, $filtro, $idItem);
		$obVenta->ActualizaRegistro("preventa","Impuestos", $IVA, $filtro, $idItem);
		$obVenta->ActualizaRegistro("preventa","TotalVenta", $Total, $filtro, $idItem);
		$obVenta->ActualizaRegistro("preventa","ValorAcordado", $ValorAcordado, $filtro, $idItem);
		
		
		header("location:$myPage?CmbPreVentaAct=$idPreventa");
			
	}
	
	////Se guarda la Venta
	
	if(isset($_REQUEST['TxtGranTotalH'])){
            //print("<script>alert('Entra 2')</script>");
            $obVenta=new ProcesoVenta($idUser);
            
            $fecha=date("Y-m-d");
            $TotalVenta=$_REQUEST['TxtGranTotalH'];
            $idCliente=$_REQUEST["TxtCliente"];
            $idColaborador=$_REQUEST["TxtidColaborador"];
            $idPreventa=$_REQUEST["CmbPreVentaAct"];
            $Efectivo=$_REQUEST["TxtPaga"];
            $Cheque=$_REQUEST["TxtPagaCheque"];
            $Tarjeta=$_REQUEST["TxtPagaTarjeta"];
            $idTarjeta=$_REQUEST["CmbIdTarjeta"];
            $OtrosPaga=$_REQUEST["TxtPagaOtros"];
            $Devuelta=$_REQUEST["TxtDevuelta"];
            $CuentaDestino=$_REQUEST["TxtCuentaDestino"];
            $TipoPago=$_REQUEST["TxtTipoPago"];
            $Anticipo=$obVenta->normalizar($_REQUEST["TxtAnticipo"]);
            $idAnticipo=$obVenta->normalizar($_REQUEST["CmbAnticipo"]);
            $Observaciones=$_REQUEST["TxtObservacionesFactura"];
            if($idAnticipo>0){
                $Observaciones.=$Observaciones." Anticipo por $Anticipo con id: $idAnticipo Cruzado con esta Factura";
            }
            
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
                exit("<a href='$myPage?CmbPreVentaAct=$idPreventa' ><h1>Volver</h1></a>");
            }
            if($TipoPago<>"Contado"){
                $Deuda=$obVenta->Sume("cartera", "Saldo", "WHERE idCliente='$idCliente'");
                $DatosClientes=$obVenta->DevuelveValores("clientes", "idClientes", $idCliente);
                $CupoDisponible=$DatosClientes["Cupo"]-$Deuda;
                $CapacidadCompra=$CupoDisponible-$TotalVenta;
                if($CapacidadCompra<=100){
                    print("<script>alert('El cliente $DatosClientes[RazonSocial] No cuenta con cupo Disponible para realizar esta compra a credito')</script>");
                    $css->CrearNotificacionRoja("El Cliente $DatosClientes[RazonSocial] $DatosClientes[Num_Identificacion] cuenta con un cupo de $".number_format($DatosClientes["Cupo"]).", Debe $".number_format($Deuda).", Tiene un cupo disponible de: ".number_format($CupoDisponible).", No tiene cupo para el total de la Factura: $". number_format($TotalVenta), 18);
                    exit("<a href='$myPage?CmbPreVentaAct=$idPreventa' ><h1>Volver</h1></a>");
                }
            }
            if($TipoPago<>"Contado"){
                $Efectivo=0;
                $DatosVentaRapida["PagaCheque"]=0;
                $DatosVentaRapida["PagaTarjeta"]=0;
                $DatosVentaRapida["idTarjeta"]=0;
                $DatosVentaRapida["PagaOtros"]=0;
            }
            //print("<script>alert('Entra 1')</script>");
            $NumFactura=$obVenta->RegistreVentaRapida($idPreventa, $idCliente, $TipoPago, $Efectivo, $Devuelta, $CuentaDestino, $DatosVentaRapida);
            $obVenta->FacturaKardex($NumFactura, $idUser, "");
            //print("<script>alert('Entra 2')</script>");
            $obVenta->BorraReg("preventa","VestasActivas_idVestasActivas",$idPreventa);
            //$obVenta->ActualizaRegistro("vestasactivas","SaldoFavor", 0, "idVestasActivas", $idPreventa);
            if($idAnticipo>0){
                $obVenta->CruceAnticipoFactura($fecha,$idAnticipo,$NumFactura,$CuentaDestino,"");
            }
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
            header("location:$myPage?CmbPreVentaAct=$idPreventa&TxtidFactura=$NumFactura");	
			
	}
	
	////Se guarda un separado
	
	if(isset($_REQUEST['BtnCrearSeparado'])){
            $obVenta=new ProcesoVenta($idUser);
            $fecha=date("Y-m-d");
		$Hora=date("H:i:s");
		
		$idPreventa=$_REQUEST['CmbPreVentaAct'];
                $idCliente=$_REQUEST['CmbClientes'];
                $Abono=$obVenta->normalizar($_REQUEST['TxtAbono']);
                $TotalSeparado=$obVenta->Sume("preventa", "TotalVenta", " WHERE VestasActivas_idVestasActivas='$idPreventa'");
                if($Abono<$TotalSeparado){
                    if($idCliente<=1){
                        print("<script>alert('Debe seleccionar un Cliente para poder ejecutar esta accion')</script>");
                        exit("<a href='$myPage?CmbPreVentaAct=$idPreventa' ><h1>Volver</h1></a>");
                    }
                    $consulta=$obVenta->ConsultarTabla("preventa", " WHERE VestasActivas_idVestasActivas='$idPreventa'");
                    if($obVenta->NumRows($consulta)){
                        $DatosCaja=$obVenta->DevuelveValores("cajas", "idUsuario", $idUser);
                        $CentroCosto=$DatosCaja["CentroCostos"];
                        $CuentaDestino=$DatosCaja["CuentaPUCEfectivo"];
                        $Concepto="ANTICIPO POR SEPARADO";
                        $VectorIngreso["Separado"]=1;
                        
                        $idComprobanteIngreso=$obVenta->RegistreAnticipo2($fecha,$CuentaDestino,$idCliente,$Abono,$CentroCosto,$Concepto,$idUser,$VectorIngreso);

                        $DatosSeparado["idCompIngreso"]=$idComprobanteIngreso;
                        $idSeparado=$obVenta->RegistreSeparado($fecha,$Hora,$idPreventa,$idCliente,$Abono,$DatosSeparado);
                        $DatosImpresora=$obVenta->DevuelveValores("config_puertos", "ID", 1);
                        if($DatosImpresora["Habilitado"]=="SI"){
                            $obPrint->ImprimeSeparado($idSeparado, $DatosImpresora["Puerto"], 3);
                        }


                        header("location:$myPage?CmbPreVentaAct=$idPreventa&Separado=$idSeparado");
                    }else{
                        header("location:$myPage?CmbPreVentaAct=$idPreventa&E=Separado");	
                    }
                }else{
                    $css->CrearNotificacionRoja("El abono debe ser menor al total del separado, verifique",16);
                }
	}
	
	
	////Se Crea un Cliente
	
	if(!empty($_REQUEST['BtnCrearCliente'])){
		
		
		//$idPreventa=$_REQUEST['CmbPreVentaAct'];
		$NIT=$_REQUEST['TxtNIT'];
                $idMun=$_REQUEST['CmbCodMunicipio'];
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
			$NumRegistros=16;  
								
			
			$Columnas[0]="Tipo_Documento";						$Valores[0]=$_REQUEST['CmbTipoDocumento'];
			$Columnas[1]="Num_Identificacion";					$Valores[1]=$_REQUEST['TxtNIT'];
			$Columnas[2]="DV";							$Valores[2]=$DV;
			$Columnas[3]="Primer_Apellido";						$Valores[3]=$_REQUEST['TxtPA'];
			$Columnas[4]="Segundo_Apellido";					$Valores[4]=$_REQUEST['TxtSA'];
			$Columnas[5]="Primer_Nombre";						$Valores[5]=$_REQUEST['TxtPN'];
			$Columnas[6]="Otros_Nombres";						$Valores[6]=$_REQUEST['TxtON'];
			$Columnas[7]="RazonSocial";						$Valores[7]=$_REQUEST['TxtRazonSocial'];
			$Columnas[8]="Direccion";						$Valores[8]=$_REQUEST['TxtDireccion'];
			$Columnas[9]="Cod_Dpto";						$Valores[9]=$DatosMunicipios["Cod_Dpto"];
			$Columnas[10]="Cod_Mcipio";						$Valores[10]=$DatosMunicipios["Cod_mcipio"];
			$Columnas[11]="Pais_Domicilio";						$Valores[11]=169;
			$Columnas[12]="Telefono";			    			$Valores[12]=$_REQUEST['TxtTelefono'];
			$Columnas[13]="Ciudad";			    				$Valores[13]=$DatosMunicipios["Ciudad"];
			$Columnas[14]="Email";			    				$Valores[14]=$_REQUEST['TxtEmail'];
			$Columnas[15]="Cupo";			    				$Valores[15]=$_REQUEST['TxtCupo'];
			$obVenta->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
                        $tab="proveedores";
                        $obVenta->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
				
			print("<script language='JavaScript'>alert('Se ha creado el Cliente $_REQUEST[TxtRazonSocial]')</script>");
			
		}else{
			
			print("<script language='JavaScript'>alert('El cliente con Identificacion: $NIT, ya existe y no se puede crear nuevamente')</script>");
		}	

		//header("location:VentaFacil.php?CmbPreVentaAct=$idPreventa");
		
			
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
                    
                    $obPrint->ImprimeCierre($idUser,$VectorCierre,$DatosImpresora["Puerto"],1);
                }
        }
        
        
        /*
         * Registra abonos de separados 
         */
        
              
        if(!empty($_REQUEST['TxtIdSeparado'])){
            
            $obVenta=new ProcesoVenta($idUser);
            $fecha=date("Y-m-d");
            $Hora=date("H:i:s");
            $idSeparado=$_REQUEST['TxtIdSeparado'];
            $idPreventa=$_REQUEST['CmbPreVentaAct'];
            $Valor=$_REQUEST["TxtAbonoSeparado$idSeparado"];
            $DatosCaja=$obVenta->DevuelveValores("cajas", "idUsuario", $idUser);
            $CuentaDestino=$DatosCaja["CuentaPUCEfectivo"];
            $CentroCosto=$DatosCaja["CentroCostos"];
            $Concepto="ABONO A SEPARADO No $idSeparado";
            $VectorIngreso["Separado"]=1;
            $idCliente=$_REQUEST['TxtIdClientes'];
            $idIngreso=$obVenta->RegistreAnticipo2($fecha,$CuentaDestino,$idCliente,$Valor,$CentroCosto,$Concepto,$idUser,$VectorIngreso);
            
            
            
            $VectorSeparados["idCompIngreso"]=$idIngreso;
            $Saldo=$obVenta->RegistreAbonoSeparado($idSeparado,$Valor,$fecha,$Hora,$VectorSeparados);
            
            
            
            $DatosImpresora=$obVenta->DevuelveValores("config_puertos", "ID", 1);
            $Impresiones=3;
            if($Saldo==0){
		$Impresiones=1;
                $VectorSeparados["Ft"]="";
                $CuentaDestino=$DatosCaja["CuentaPUCEfectivo"];
                $NumFactura=$obVenta->CreaFacturaDesdeSeparado($idSeparado,$CuentaDestino,$VectorSeparados);
               if($DatosImpresora["Habilitado"]=="SI"){
                $obPrint->ImprimeFacturaPOS($NumFactura,$DatosImpresora["Puerto"],1);
               }
            }
            
                if($DatosImpresora["Habilitado"]=="SI"){
                    $obPrint->ImprimeSeparado($idSeparado, $DatosImpresora["Puerto"], $Impresiones);
                    
            }
            header("location:$myPage?CmbPreVentaAct=$idPreventa&TxtidFactura=$NumFactura");
        }
        
         /*
         * Registra egresos 
         */
        
              
        if(isset($_REQUEST['BtnCrearEgreso'])){
            
            $obVenta=new ProcesoVenta($idUser);
            $fecha=date("Y-m-d");
            $FechaProgramada=$fecha;
            $CuentaDestino=$_REQUEST['CmbCuentaDestino'];
            $NumFact=$_REQUEST["TxtNumFactura"];
            $Concepto=$_REQUEST["TxtConcepto"];
            $idProveedor=$_REQUEST["CmbProveedores"];
            $Subtotal=$_REQUEST["TxtSubtotalEgreso"];
            $IVA=$_REQUEST["TxtIVAEgreso"];
            $Total=$_REQUEST["TxtValorEgreso"];
            
            if($idProveedor<=0){
                print("<script>alert('Debe seleccionar un Proveedor para poder ejecutar esta accion')</script>");
                exit("<a href='$myPage?CmbPreVentaAct=$idPreventa' ><h1>Volver</h1></a>");
            }
            
            if($CuentaDestino<=0){
                print("<script>alert('Debe seleccionar un egreso para poder ejecutar esta accion')</script>");
                exit("<a href='$myPage?CmbPreVentaAct=$idPreventa' ><h1>Volver</h1></a>");
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
                $obPrint->ImprimeEgresoPOS($idEgreso,$VectorEgresos,$DatosImpresora["Puerto"],1);
                    
            }
            header("location:$myPage?CmbPreVentaAct=$idPreventa&TxtIdEgreso=$idEgreso");
        }
        
        if(!empty($_REQUEST['TxtAutorizacion'])){
		
		
		$obVenta=new ProcesoVenta($idUser);
                $Clave=$obVenta->normalizar($_POST['TxtAutorizacion']);
                $sql="SELECT Identificacion FROM usuarios WHERE Password='$Clave' AND (Role='ADMINISTRADOR' OR Role='SUPERVISOR')";
                $Datos=$obVenta->Query($sql);
                $DatosAutorizacion=$obVenta->FetchArray($Datos);
                
                $NoAutorizado="";
                if($DatosAutorizacion["Identificacion"]>0){
                    
                    $obVenta->ActualizaRegistro("preventa", "Autorizado", $DatosAutorizacion["Identificacion"], "VestasActivas_idVestasActivas", $idPreventa);
                }else{
                    $NoAutorizado="NoAutorizado=1";
                    
                }
		header("location:$myPage?CmbPreVentaAct=$idPreventa&$NoAutorizado");	
	}
        
        
        /*
         * Registra abonos de creditos 
         */
        
              
        if(!empty($_REQUEST['TxtIdCartera'])){
            
            $obVenta=new ProcesoVenta($idUser);
            $fecha=date("Y-m-d");
            $Hora=date("H:i:s");
            $idCartera=$obVenta->normalizar($_REQUEST['TxtIdCartera']);
            $idFactura=$obVenta->normalizar($_REQUEST['TxtIdFactura']);
            $idPreventa=$obVenta->normalizar($_REQUEST['CmbPreVentaAct']);
            $Valor=$obVenta->normalizar($_REQUEST["TxtAbonoCredito$idCartera"]);
            $Intereses=$obVenta->normalizar($_REQUEST["TxtInteresCredito$idCartera"]);
            $AbonoTarjetas=$obVenta->normalizar($_REQUEST["TxtAbonoTarjeta$idCartera"]);
            $AbonoCheques=$obVenta->normalizar($_REQUEST["TxtAbonoCheques$idCartera"]);
            $AbonoOtros=$obVenta->normalizar($_REQUEST["TxtAbonoOtros$idCartera"]);
            $TotalAbono=$Valor+$AbonoTarjetas+$AbonoCheques;
            $DatosFactura=$obVenta->DevuelveValores("facturas", "idFacturas", $idFactura);
            if($TotalAbono<=$DatosFactura["SaldoFact"]){
                $DatosCaja=$obVenta->DevuelveValores("cajas", "idUsuario", $idUser);
                $CuentaDestino=$DatosCaja["CuentaPUCEfectivo"];
                $CentroCosto=$DatosCaja["CentroCostos"];
                $idTerceroInteres=$DatosCaja["idTerceroIntereses"];
                $CentroCosto=$DatosCaja["CentroCostos"];
                $Concepto="ABONO A FACTURA No $DatosFactura[Prefijo] - $DatosFactura[NumeroFactura]";
                $VectorIngreso["fut"]="";
                $TipoPago="";
                $idComprobanteAbono=$obVenta->RegistreAbonoCarteraCliente($fecha,$Hora,$CuentaDestino,$idFactura,$Valor,$TipoPago,$CentroCosto,$Concepto,$idUser,$VectorIngreso);
                if($AbonoTarjetas>0){
                    $TipoPago="Tarjetas";
                    $DatosParametros=$obVenta->DevuelveValores("parametros_contables", "ID", 17);
                    $idComprobanteAbono=$obVenta->RegistreAbonoCarteraCliente($fecha,$Hora,$DatosParametros["CuentaPUC"],$idFactura,$AbonoTarjetas,$TipoPago,$CentroCosto,$Concepto,$idUser,$VectorIngreso);
                }
                if($AbonoCheques>0){
                    $TipoPago="Cheques";
                    $DatosParametros=$obVenta->DevuelveValores("parametros_contables", "ID", 18);
                    $idComprobanteAbono=$obVenta->RegistreAbonoCarteraCliente($fecha,$Hora,$DatosParametros["CuentaPUC"],$idFactura,$AbonoCheques,$TipoPago,$CentroCosto,$Concepto,$idUser,$VectorIngreso);
                }
                if($AbonoOtros>0){
                    $TipoPago="Bonos";
                    $idComprobanteAbono=$obVenta->RegistreAbonoCarteraCliente($fecha,$Hora,$DatosCaja["CuentaPUCEfectivo"],$idFactura,$AbonoCheques,$TipoPago,$CentroCosto,$Concepto,$idUser,$VectorIngreso);
                }
                if($Intereses>0){
                    $obVenta->RegistrePagoInteresesSisteCredito($fecha,$Hora,$Intereses,$idFactura,$idUser,$idTerceroInteres,$DatosCaja["CuentaPUCEfectivo"],$CentroCosto,"");
                }
                $DatosImpresora=$obVenta->DevuelveValores("config_puertos", "ID", 1);

                if($DatosImpresora["Habilitado"]=="SI"){
                    $obPrint->ImprimeComprobanteAbonoFactura($idComprobanteAbono, $DatosImpresora["Puerto"], 2);

                }
                $DatosAbono=$obVenta->DevuelveValores("facturas_abonos", "ID", $idComprobanteAbono);
                $idComprobanteIngreso=$DatosAbono["idComprobanteIngreso"];
                $css->CrearNotificacionVerde("Abono Registrado Exitosamente <a href='PDF_Documentos.php?idDocumento=4&idIngreso=$idComprobanteIngreso' target='_blank'> Imprimir</a>",16);
           
            }else{
                $css->CrearNotificacionRoja("El Saldo de la Factura es inferior a los abonos digitados, vuelva a intentarlo",16);
            }
             
            //header("location:$myPage?CmbPreVentaAct=$idPreventa&TxtidFactura=$idFactura");
        }
        
        
        /*
         * Registra abonos de creditos 
         */
        
              
        if(!empty($_REQUEST['BtnDescuentoGeneral'])){
            
            $obVenta=new ProcesoVenta($idUser);
            $fecha=date("Y-m-d");
            $Hora=date("H:i:s");
            $Descuento=(100-$obVenta->normalizar($_REQUEST['TxtDescuento']))/100;
            $idPreventa=$obVenta->normalizar($_REQUEST['TxtidPreventa']);
            $sql="UPDATE preventa SET Subtotal=round(Subtotal*$Descuento), Impuestos=round(Impuestos*$Descuento),"
                    . " TotalVenta=round(TotalVenta*$Descuento), ValorAcordado=round(ValorAcordado*$Descuento) "
                    . " WHERE VestasActivas_idVestasActivas='$idPreventa'";
            $obVenta->Query($sql);
            header("location:$myPage?CmbPreVentaAct=$idPreventa");
        }
        
        //Si se recibe hacer descuento a costo
        if(!empty($_REQUEST['BtnDescuentoCosto'])){
            
            $obVenta=new ProcesoVenta($idUser);
            $fecha=date("Y-m-d");
            $Hora=date("H:i:s");
            
            $idPreventa=$obVenta->normalizar($_REQUEST['TxtidPreventa']);
            $sql="UPDATE `preventa` "
                    . "SET `ValorAcordado`=((`CostoUnitario`)/(`PorcentajeIVA`+1)), "
                    . "`Impuestos`=(`PorcentajeIVA`*(`ValorAcordado`*`Cantidad`)),"
                    . "`Subtotal`=(`ValorAcordado`*`Cantidad`), `TotalVenta`=(`Subtotal`+`Impuestos`) "
                    . "WHERE `VestasActivas_idVestasActivas`='$idPreventa' ";
            $obVenta->Query($sql);
            header("location:$myPage?CmbPreVentaAct=$idPreventa");
        }
        
        //Si se recibe hacer descuento a costo
        if(!empty($_REQUEST['BtnDescuentoMayor'])){
            
            $obVenta=new ProcesoVenta($idUser);
            $fecha=date("Y-m-d");
            $Hora=date("H:i:s");
            
            $idPreventa=$obVenta->normalizar($_REQUEST['TxtidPreventa']);
            $sql="UPDATE `preventa` "
                    . "SET `ValorAcordado`=((`PrecioMayorista`)/(`PorcentajeIVA`+1)), "
                    . "`Impuestos`=(`PorcentajeIVA`*(`ValorAcordado`*`Cantidad`)),"
                    . "`Subtotal`=(`ValorAcordado`*`Cantidad`), `TotalVenta`=(`Subtotal`+`Impuestos`) "
                    . "WHERE `VestasActivas_idVestasActivas`='$idPreventa' ";
            $obVenta->Query($sql);
            header("location:$myPage?CmbPreVentaAct=$idPreventa");
        }
        
        //////Verifico el cupo de una persona
	if(!empty($_REQUEST['TxtConsultaCupo'])){
		
            $obVenta=new ProcesoVenta($idUser);
            $idPreventa=$obVenta->normalizar($_REQUEST['CmbPreVentaAct']);
            $key=$obVenta->normalizar($_REQUEST['TxtConsultaCupo']);
            if(strlen($key)>3){
                $sql="SELECT idClientes,Num_Identificacion, RazonSocial, Cupo FROM clientes WHERE Num_Identificacion='$key' or RazonSocial LIKE '%$key%'";
                $Consulta=$obVenta->Query($sql);
                while($DatosCliente=$obVenta->FetchArray($Consulta)){                
                    $Deuda=$obVenta->Sume("cartera", "Saldo", "WHERE idCliente='$DatosCliente[idClientes]'");
                    $CupoDisponible=$DatosCliente["Cupo"]-$Deuda;
                    if($CupoDisponible > 100){
                        $css->CrearNotificacionVerde("El Cliente $DatosCliente[RazonSocial] $DatosCliente[Num_Identificacion] cuenta con un cupo de $".number_format($DatosCliente["Cupo"]).", Debe $".number_format($Deuda).", Tiene un cupo disponible de: ".number_format($CupoDisponible), 18);
                    }else{
                        $css->CrearNotificacionRoja("El Cliente $DatosCliente[RazonSocial] $DatosCliente[Num_Identificacion] cuenta con un cupo de $".number_format($DatosCliente["Cupo"]).", Debe $".number_format($Deuda).", Tiene un cupo disponible de: ".number_format($CupoDisponible).", No tiene Acceso a mas creditos", 18);
                    }
                }
            }else{
                $css->CrearNotificacionNaranja("Debes introducir al menos 4 caracteres", 18);
            }
		
	}
        
        //////Si se pide facturar un items
	if(isset($_REQUEST['BtnFacturarItemSeparado'])){
            $idItemSeparado=$obVenta->normalizar($_REQUEST['idItemSeparado']);
            $idPreventa=$obVenta->normalizar($_REQUEST['CmbPreVentaAct']);
            $NumFactura=$obVenta->FacturarItemSeparado($idItemSeparado,"");
            header("location:$myPage?CmbPreVentaAct=$idPreventa&TxtidFactura=$NumFactura");
        }
        
        /// Si se Cotiza
       	
	if(isset($_REQUEST['BtnCotizar'])){
            
            $obVenta=new ProcesoVenta($idUser);
            $fecha=date("Y-m-d");
            $idPreventa=$obVenta->normalizar($_REQUEST['CmbPreVentaAct']);
            $Observaciones=$obVenta->normalizar($_REQUEST['TxtObservaciones']);
            $idCliente=$obVenta->normalizar($_REQUEST['CmbClienteCotizacion']);
            $idCotizacion=$obVenta->CotizarDesdePreventa($idPreventa,$fecha,$idCliente,$Observaciones,"");
            $obVenta->BorraReg("preventa","VestasActivas_idVestasActivas",$idPreventa);
            $DatosImpresora=$obVenta->DevuelveValores("config_puertos", "ID", 1);
            if($DatosImpresora["Habilitado"]=="SI"){
                $obPrint->ImprimeCotizacionPOS($idCotizacion,$DatosImpresora["Puerto"],1);
            }
            
            header("location:$myPage?CmbPreVentaAct=$idPreventa&TxtidCotizacion=$idCotizacion");	
			
	}
        
        //Si se recibe cambiar precio de venta por listado
        if(!empty($_REQUEST['BtnListados'])){
            
            $obVenta=new ProcesoVenta($idUser);
            $fecha=date("Y-m-d");
            $Hora=date("H:i:s");
            $Listado=$obVenta->normalizar($_REQUEST['CmbListaPrecio']);
            $idPreventa=$obVenta->normalizar($_REQUEST['TxtidPreventa']);
            $consulta=$obVenta->ConsultarTabla("preventa", " WHERE VestasActivas_idVestasActivas='$idPreventa'");
            while ($DatosPreventa=$obVenta->FetchArray($consulta)){
                $Cantidad=$DatosPreventa["Cantidad"];
                $idProducto=$DatosPreventa["ProductosVenta_idProductosVenta"];
                $idItem=$DatosPreventa["idPrecotizacion"];
                $Tabla=$DatosPreventa["TablaItem"];
                $Datos=$obVenta->ConsultarTabla("productos_precios_adicionales", " WHERE idProducto='$idProducto' AND idListaPrecios='$Listado' AND TablaVenta='$Tabla'");
                $DatosListado=$obVenta->FetchArray($Datos);
                if($DatosListado["PrecioVenta"]>0){
                    $DatosProductos=$obVenta->DevuelveValores($Tabla,"idProductosVenta",$idProducto);
                    $ValorAcordado=$DatosListado["PrecioVenta"];
                    $DatosTablaItem=$obVenta->DevuelveValores("tablas_ventas", "NombreTabla", $Tabla);
                    if($DatosTablaItem["IVAIncluido"]=="SI"){

                        $ValorAcordado=$ValorAcordado/($DatosProductos["IVA"]+1);

                    }
                    $Subtotal=$ValorAcordado*$Cantidad;


                    $IVA=$Subtotal*$DatosProductos["IVA"];
                    //$SubtotalCosto=$DatosProductos["CostoUnitario"]*$Cantidad;
                    $Total=$Subtotal+$IVA;
                    $filtro="idPrecotizacion";

                    $obVenta->ActualizaRegistro("preventa","Subtotal", $Subtotal, $filtro, $idItem);
                    $obVenta->ActualizaRegistro("preventa","Impuestos", $IVA, $filtro, $idItem);
                    $obVenta->ActualizaRegistro("preventa","TotalVenta", $Total, $filtro, $idItem);
                    $obVenta->ActualizaRegistro("preventa","ValorAcordado", $ValorAcordado, $filtro, $idItem);
                }
                
            }
                            
            header("location:$myPage?CmbPreVentaAct=$idPreventa");
        }
        ///////////////Fin
?>