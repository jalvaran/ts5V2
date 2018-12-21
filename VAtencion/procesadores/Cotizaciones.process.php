<?php 
$obVenta=new ProcesoVenta($idUser);
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
    
    
		
	
	if(!empty($_REQUEST['del'])){
		$id=$obVenta->normalizar($_REQUEST['del']);
		$Tabla=$obVenta->normalizar($_REQUEST['TxtTabla']);
		$IdTabla=$obVenta->normalizar($_REQUEST['TxtIdTabla']);
		$IdPre=$obVenta->normalizar($_REQUEST['TxtIdPre']);
		$obVenta->Query("DELETE FROM $Tabla WHERE $IdTabla='$id'");
		header("location:Cotizaciones.php");
	}
		
	if(!empty($_REQUEST['BtnAgregarItem'])){
		//$idClientes=$obVenta->normalizar($_REQUEST['TxtIdCliente']);
		$idItem=$obVenta->normalizar($_REQUEST['idProducto']);
                $Cantidad=$obVenta->normalizar($_REQUEST['TxtCantidad']);
                $ValorUnitario=$obVenta->normalizar($_REQUEST['TxtValor']);
                $TipoItem=$obVenta->normalizar($_REQUEST['TipoItem']);
                if($TipoItem==1){
                    $TablaItem="productosventa";
                }
                if($TipoItem==2){
                    $TablaItem="servicios";
                }
                if($TipoItem==3){
                    $TablaItem="sistemas";
                }
                if($TipoItem==4){
                    $TablaItem="productosalquiler";
                }
                if($TipoItem<>3){
                    $obVenta->AgregaPrecotizacion($Cantidad,$idItem,$TablaItem,$ValorUnitario,"");
                }else{
                    $DatosProductoGeneral=$obVenta->DevuelveValores("sistemas", "ID", $idItem);
                    $tab="precotizacion";
                    $NumRegistros=13;  
                    $Columnas[0]="Cantidad";						$Valores[0]=$Cantidad;
                    $Columnas[1]="Referencia";						$Valores[1]=$idItem;
                    $Columnas[2]="ValorUnitario";					$Valores[2]=0;
                    $Columnas[3]="SubTotal";						$Valores[3]=0;
                    $Columnas[4]="Descripcion";						$Valores[4]=$DatosProductoGeneral["Nombre"];
                    $Columnas[5]="IVA";							$Valores[5]=0;
                    $Columnas[6]="PrecioCosto";						$Valores[6]=0;
                    $Columnas[7]="SubtotalCosto";					$Valores[7]=0;
                    $Columnas[8]="Total";						$Valores[8]=0;
                    $Columnas[9]="TipoItem";						$Valores[9]="";
                    $Columnas[10]="idUsuario";						$Valores[10]=$idUser;
                    $Columnas[11]="CuentaPUC";						$Valores[11]="";
                    $Columnas[12]="Tabla";			    			$Valores[12]=$TablaItem;

                    $obVenta->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
                    $consulta=$obVenta->ConsultarTabla("vista_sistemas", "WHERE idSistema='$idItem'");
                    $CantidadSistema=$Cantidad;
                    while($DatosSistema=$obVenta->FetchArray($consulta)){
                        $Cantidad=$DatosSistema["Cantidad"]*$CantidadSistema;
                        $idItem=$DatosSistema["CodigoInterno"];
                        $TablaItem=$DatosSistema["TablaOrigen"];
                        $ValorUnitario=$DatosSistema["PrecioUnitario"];
                        $obVenta->AgregaPrecotizacion($Cantidad,$idItem,$TablaItem,$ValorUnitario,"");
                    }
                    
                }
		header("location:Cotizaciones.php");
			
	}
	
	////Se recibe edicion
	
	if(!empty($_REQUEST['TxtEditar'])){
		
		$idItem=$obVenta->normalizar($_REQUEST['TxtPrecotizacion']);
		$Cantidad=$obVenta->normalizar($_REQUEST['TxtEditar']);
                $Multiplicador=$obVenta->normalizar($_REQUEST['TxtMultiplicador']);
		$ValorAcordado=$obVenta->normalizar($_REQUEST['TxtValorUnitario']);
		$obVenta->EditarItemPrecotizacion($idItem, $Cantidad, $Multiplicador, $ValorAcordado, "");
		header("location:Cotizaciones.php");
			
	}
	
	////Se guarda la Cotizacion
	
	if(!empty($_REQUEST['BtnGuardar'])){
		$fecha=date("Y-m-d");
                $obVenta=new ProcesoVenta($idUser);
		$idCliente=$obVenta->normalizar($_REQUEST["TxtIdCliente"]);
		
		if(!empty($_REQUEST['TxtNumOrden']))
			$obVenta->normalizar($NumOrden=$_REQUEST['TxtNumOrden']);
		else
			$NumOrden="";
		
		if(!empty($_REQUEST['TxtNumSolicitud']))
			$obVenta->normalizar($NumSolicitud=$_REQUEST['TxtNumSolicitud']);
		else
			$NumSolicitud="";
		
		if(!empty($_REQUEST['TxtObservaciones'])){
			$Observaciones=$obVenta->normalizar($_REQUEST['TxtObservaciones']);
                        $Observaciones=$obVenta->QuitarAcentos($Observaciones);
                }else{
			$Observaciones="";
                }
		
		$NumCotizacion=$obVenta->ObtenerMAX("cotizacionesv5","ID", "1", "");
		$NumCotizacion++;
		
		///////////////////////////Ingresar a Cotizaciones 
			
		$tab="cotizacionesv5";
		$NumRegistros=7;  
							
		$Columnas[0]="ID";					$Valores[0]=$NumCotizacion;
		$Columnas[1]="Fecha";                                   $Valores[1]=$fecha;
		$Columnas[2]="Clientes_idClientes";			$Valores[2]=$idCliente;
		$Columnas[3]="Usuarios_idUsuarios";			$Valores[3]=$idUser;
		$Columnas[4]="Observaciones";				$Valores[4]=$Observaciones;
		$Columnas[5]="NumSolicitud";				$Valores[5]=$NumSolicitud;
		$Columnas[6]="NumOrden";				$Valores[6]=$NumOrden;
		
		$obVenta->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
			
		///////////////////////////Ingresar a cot_itemscotizaciones 
		
		$Consulta=$obVenta->ConsultarTabla("precotizacion","WHERE idUsuario='$idUser'");
		
	    while($DatosPrecoti=$obVenta->FetchArray($Consulta)){
		
			
			$tab="cot_itemscotizaciones";
			$NumRegistros=17;  
								
			$Columnas[0]="NumCotizacion";				$Valores[0]=$NumCotizacion;
			$Columnas[1]="Descripcion";				$Valores[1]=$DatosPrecoti["Descripcion"];
			$Columnas[2]="Referencia";				$Valores[2]=$DatosPrecoti["Referencia"];
			$Columnas[3]="TablaOrigen";				$Valores[3]=$DatosPrecoti["Tabla"];
			$Columnas[4]="ValorUnitario";				$Valores[4]=$DatosPrecoti["ValorUnitario"];
			$Columnas[5]="Cantidad";                                $Valores[5]=$DatosPrecoti["Cantidad"];
			$Columnas[6]="Subtotal";				$Valores[6]=$DatosPrecoti["SubTotal"];
			$Columnas[7]="IVA";					$Valores[7]=$DatosPrecoti["IVA"];
			$Columnas[8]="Total";					$Valores[8]=$DatosPrecoti["Total"];
			$Columnas[9]="PrecioCosto";				$Valores[9]=$DatosPrecoti["PrecioCosto"];
			$Columnas[10]="SubtotalCosto";				$Valores[10]=$DatosPrecoti["SubtotalCosto"];
			$Columnas[11]="TipoItem";				$Valores[11]=$DatosPrecoti["TipoItem"];
			$Columnas[12]="CuentaPUC";				$Valores[12]=$DatosPrecoti["CuentaPUC"];
			$Columnas[13]="idCliente";				$Valores[13]=$idCliente;
                        $Columnas[14]="Multiplicador";				$Valores[14]=$DatosPrecoti["Multiplicador"];
                        $Columnas[15]="Descuento";				$Valores[15]=$DatosPrecoti["Descuento"];
                        $Columnas[16]="ValorDescuento";				$Valores[16]=$DatosPrecoti["ValorDescuento"];
                        
			$obVenta->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);	
		
		}
		
		$obVenta->BorraReg("precotizacion","idUsuario",$idUser);
		header("location:Cotizaciones.php?TxtIdCotizacion=$NumCotizacion");
		
			
	}
	
	
	
	////Se Crea un Cliente
	
	if(!empty($_REQUEST['BtnCrearCliente'])){
		
		$NIT=$obVenta->normalizar($_REQUEST['TxtNIT']);
                $idMun=$obVenta->normalizar($_REQUEST['CmbCodMunicipio']);
		
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
			$Columnas[7]="RazonSocial";							$Valores[7]=$obVenta->normalizar($_REQUEST['TxtRazonSocial']);
			$Columnas[8]="Direccion";							$Valores[8]=$obVenta->normalizar($_REQUEST['TxtDireccion']);
			$Columnas[9]="Cod_Dpto";							$Valores[9]=$DatosMunicipios["Cod_Dpto"];
			$Columnas[10]="Cod_Mcipio";							$Valores[10]=$DatosMunicipios["Cod_mcipio"];
			$Columnas[11]="Pais_Domicilio";						$Valores[11]=169;
			$Columnas[12]="Telefono";			    			$Valores[12]=$_REQUEST['TxtTelefono'];
			$Columnas[13]="Ciudad";			    				$Valores[13]=$DatosMunicipios["Ciudad"];
			$Columnas[14]="Email";			    				$Valores[14]=$_REQUEST['TxtEmail'];
			
			$obVenta->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
                        $tab="proveedores";
                        $obVenta->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
				
			print("<script language='JavaScript'>alert('Se ha creado el Tercero $_REQUEST[TxtRazonSocial]')</script>");
			
		}else{
			
			print("<script language='JavaScript'>alert('El cliente con Identificacion: $NIT, ya existe y no se puede crear nuevamente')</script>");
		}	

	}
        
        
        //si se recibe la solicitud de crear un servicio
        
        if(!empty($_REQUEST['BtnCrearServicios'])){
            
            $idClientes=$obVenta->normalizar($_REQUEST['TxtIdCliente']);
            $Nombre=$obVenta->normalizar($_REQUEST['TxtNombre']);
            $Nombre=$obVenta->QuitarAcentos2($Nombre);
            $PrecioVenta=$obVenta->normalizar($_REQUEST['TxtPrecioVenta']);
            $CostoUnitario=$obVenta->normalizar($_REQUEST['TxtCostoUnitario']);
            $CuentaPUC=$obVenta->normalizar($_REQUEST['TxtCuentaPUC']);
            $IVA=$obVenta->normalizar($_REQUEST['CmbIVA']);
            $Departamento=$obVenta->normalizar($_REQUEST['CmbDepartamento']);
            $Cantidad=1;
            if(isset($_REQUEST['TxtCantidadPiezas'])){
                $Cantidad=$obVenta->normalizar($_REQUEST['TxtCantidadPiezas']);
            }
            $Tabla="servicios";            
            
            $VectorItem["Servitorno"]=0;
            $idItem=$obVenta->CrearItemServicio($Tabla,$Nombre,$PrecioVenta,$CostoUnitario,$CostoUnitario,$CuentaPUC,$IVA,$Departamento,$VectorItem);
            $VectorPrecoti["F"]=0;
            
            $obVenta->AgregaPrecotizacion($Cantidad,$idItem,$Tabla,$PrecioVenta,$VectorPrecoti);
            header("location:Cotizaciones.php?TxtIdCliente=$idClientes");
			
	}
        
        //Agregar los items de otra cotizacion
        
       if(isset($_REQUEST["TxtIdCotizacionAdd"])){
           $idCliente=$obVenta->normalizar($_REQUEST["TxtIdCliente"]);
           $idCotizacion=$obVenta->normalizar($_REQUEST["TxtIdCotizacionAdd"]);
           $obVenta->AgregueItemsDesdeCotizacionAPrecotizacion($idCotizacion,"");
           header("location:Cotizaciones.php?TxtIdCliente=$idCliente");
           
       }
       
       //Agregar los items de otra cotizacion
        
       if(isset($_REQUEST["BtnAgregarSalto"])){
           $idCliente=$obVenta->normalizar($_REQUEST["TxtIdCliente"]);
           $tab="precotizacion";
            $NumRegistros=13;  
            $Columnas[0]="Cantidad";						$Valores[0]=0;
            $Columnas[1]="Referencia";						$Valores[1]="";
            $Columnas[2]="ValorUnitario";					$Valores[2]=0;
            $Columnas[3]="SubTotal";						$Valores[3]=0;
            $Columnas[4]="Descripcion";						$Valores[4]="<br>";
            $Columnas[5]="IVA";							$Valores[5]=0;
            $Columnas[6]="PrecioCosto";						$Valores[6]=0;
            $Columnas[7]="SubtotalCosto";					$Valores[7]=0;
            $Columnas[8]="Total";						$Valores[8]=0;
            $Columnas[9]="TipoItem";						$Valores[9]="";
            $Columnas[10]="idUsuario";						$Valores[10]=$idUser;
            $Columnas[11]="CuentaPUC";						$Valores[11]="";
            $Columnas[12]="Tabla";			    			$Valores[12]="";

            $obVenta->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
           header("location:Cotizaciones.php?TxtIdCliente=$idCliente");
           
       }

////Se recibe porcentaje general
	
if(!empty($_REQUEST['BtnDescuentoGeneral'])){

        $DescuentoGeneral=$obVenta->normalizar($_REQUEST['TxtDescuentoPorcentaje']);
        $obVenta->DescuentoGeneralPrecotizacion($DescuentoGeneral, $idUser, "");
        header("location:Cotizaciones.php");

}
        
?>