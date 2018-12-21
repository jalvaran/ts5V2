
<?php 
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

	
	if(!empty($_REQUEST['BtnGuardarEgreso'])){
		
                $destino="";
                //echo "<script>alert ('entra')</script>";
		if(!empty($_FILES['foto']['name'])){
                    //echo "<script>alert ('entra foto')</script>";
			$Atras="../";
                        $carpeta="SoportesEgresos/";
			opendir($Atras.$carpeta);
                        $Name=str_replace(' ','_',$_FILES['foto']['name']);  
			$destino=$carpeta.$Name;
			move_uploaded_file($_FILES['foto']['tmp_name'],$Atras.$destino);
		}
             	$obVenta=new ProcesoVenta($idUser);
		$CuentaOrigen=$obVenta->normalizar($_REQUEST["CmbCuentaOrigen"]);
		$CuentaDestino=$obVenta->normalizar($_REQUEST["CmbCuentaDestino"]);
		$idProveedor=$obVenta->normalizar($_REQUEST["CmbProveedor"]);
		$Concepto=$obVenta->normalizar($_REQUEST["TxtConcepto"]);
		$TipoEgreso=$obVenta->normalizar($_REQUEST['TxtTipoEgreso']);
                $ReteFuente=$obVenta->normalizar($_REQUEST['TxtRetefuente']);
                $ReteIVA=$obVenta->normalizar($_REQUEST['TxtReteIVA']);
                $ReteICA=$obVenta->normalizar($_REQUEST['TxtReteICA']);
                $Total=$obVenta->normalizar($_REQUEST["TxtTotal"]);
                $fecha=$obVenta->normalizar($_REQUEST['TxtFecha']);
                $FechaProgramada=$obVenta->normalizar($_REQUEST['TxtFechaProgram']);
                $CentroCostos=$obVenta->normalizar($_REQUEST["CmbCentroCosto"]);
                $idSucursal=$obVenta->normalizar($_REQUEST['CmbSucursal']);
                $TipoPago=$obVenta->normalizar($_REQUEST["TipoPago"]);
                $NumFact=$obVenta->normalizar($_REQUEST["TxtNumFactura"]);
                $DatosProveedores=$obVenta->DevuelveValores("proveedores", "idProveedores", $idProveedor);
                $NIT_Proveedor=$DatosProveedores["Num_Identificacion"];
                $CuentaPUCIVA=24081205;
		$idUsuario=$idUser;
		$IVA=0;
                $Sanciones=0;
                $Intereses=0;
                $TotalSanciones=0;
                $Impuestos=0;
		if($TipoEgreso==3){
			
			$Sanciones=$obVenta->normalizar($_REQUEST["TxtSancion"]);
			$Intereses=$obVenta->normalizar($_REQUEST["TxtIntereses"]);
			$TotalSanciones=$Sanciones+$Intereses;
			$Impuestos=$obVenta->normalizar($_REQUEST["TxtImpuesto"]);
			$Subtotal=$Impuestos;
			
								
		}elseif($TipoEgreso==1){
			$Subtotal=$obVenta->normalizar($_REQUEST["TxtTotal"]);
				
		
		}else{
			$Subtotal=$obVenta->normalizar($_REQUEST["TxtSubtotal"]);
			$IVA=$obVenta->normalizar($_REQUEST["TxtIVA"]);
			
		}
                
		//////registramos en egresos
		$idComprobante=$obVenta->RegistrarGasto($fecha,$FechaProgramada,$idUser,$CentroCostos,$TipoPago,$CuentaOrigen,$CuentaDestino,$CuentaPUCIVA,$idProveedor, $Concepto,$NumFact,$destino,$TipoEgreso,$Subtotal,$IVA,$Total,$Sanciones,$Intereses,$Impuestos,$ReteFuente,$ReteIVA,$ReteICA,$idSucursal,"");
		
		if($TipoPago=="Contado"){
                    $RutaPrintComp="../tcpdf/examples/imprimircomp.php?ImgPrintComp=$idComprobante";
                    $DocumentoGenerado="CompEgreso";
                }else{
                    $Parametros=$obVenta->DevuelveValores("parametros_contables", "ID", 14);
                    $VectorCXP["CuentaPUC"]=$Parametros["CuentaPUC"];
                    $RutaPrintComp="../tcpdf/examples/NotaContablePrint.php?ImgPrintComp=$idComprobante";
                    $obVenta->RegistrarCuentaXPagar($fecha, $NumFact, $FechaProgramada, "notascontables", $idComprobante, $Subtotal, $IVA, $Total,$ReteFuente,$ReteIVA,$ReteICA, $NIT_Proveedor,$idSucursal,$CentroCostos,$Concepto,$destino,$VectorCXP);
                    $DocumentoGenerado="NotaContable";
                }
                
                ////////////////////////Ingresamos a Compras Activas para Alimentar el inventario
		
		if($TipoEgreso==50){
                    
                    $NumRegistros=12;
                    $tab="compras_activas";

                    $Columnas[0]="idProveedor";			$Valores[0]=$idProveedor;
                    $Columnas[1]="Usuarios_idUsuarios";		$Valores[1]=$idUsuario;
                    $Columnas[2]="Factura";				$Valores[2]=$NumFact;
                    $Columnas[3]="FormaPago";			$Valores[3]=$TipoPago;
                    $Columnas[4]="NombrePro";			$Valores[4]=$DatosProveedores["RazonSocial"];
                    $Columnas[5]="Fecha";				$Valores[5]=$fecha;
                    $Columnas[6]="FechaProg";			$Valores[6]=$FechaProgramada;
                    $Columnas[7]="CuentaOrigen";			$Valores[7]=$CuentaOrigen;
                    $Columnas[8]="Tipo";				$Valores[8]="FACTURA";
                    $Columnas[9]="TotalCompra";			$Valores[9]=$Total;
                    $Columnas[10]="DocumentoGenerado";		$Valores[10]=$DocumentoGenerado;
                    $Columnas[11]="NumComprobante";		$Valores[11]=$idComprobante;

                    $obVenta->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
			
		}
                $css->CrearTabla();
                $css->CrearFilaNotificacion("Egreso registrado Correctamente <a href='$RutaPrintComp' target='_blank'>Imprimir Comprobante</a>",16);
                $css->CerrarTabla();
	}
	
////Se Crea un Proveedor
	
	if(!empty($_REQUEST['BtnCrearProveedor'])){
		
		$NIT=$_REQUEST['TxtNIT'];
                $idCodMunicipio=$_REQUEST['CmbCodMunicipio'];
		$obVenta=new ProcesoVenta($idUser);
		$DatosClientes=$obVenta->DevuelveValores('proveedores',"Num_Identificacion",$NIT);
		$DV="";
		$DatosMunicipios=$obVenta->DevuelveValores('cod_municipios_dptos',"ID",$idCodMunicipio);		
		if($DatosClientes["Num_Identificacion"]<>$NIT){
			
			///////////////////////////Ingresar a Clientes 
			
			if($_REQUEST['CmbTipoDocumento']==31){
			
				$DV=calcularDV($NIT);
		
			}
		
			$tab="proveedores";
			$NumRegistros=15;  
								
			
			$Columnas[0]="Tipo_Documento";						$Valores[0]=$_REQUEST['CmbTipoDocumento'];
			$Columnas[1]="Num_Identificacion";					$Valores[1]=$_REQUEST['TxtNIT'];
			$Columnas[2]="DV";                                                      $Valores[2]=$DV;
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
			
			$obVenta->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
			$obVenta->InsertarRegistro("clientes",$NumRegistros,$Columnas,$Valores);
			print("<script language='JavaScript'>alert('Se ha creado el Proveedor $_REQUEST[TxtRazonSocial]')</script>");
			
		}else{
			
			print("<script language='JavaScript'>alert('El cliente con Identificacion: $NIT, ya existe y no se puede crear nuevamente')</script>");
		}	

		//header("location:VentaFacil.php?CmbPreVentaAct=$idPreventa");
		
			
	}
	?>