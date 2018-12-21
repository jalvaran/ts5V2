<script src="../shortcuts.js" type="text/javascript">
</script>
<script src="js/funciones.js"></script>
<?php 

$myPage="Remisiones.php";
include_once("../sesiones/php_control.php");
include_once("clases/ClasesRemisiones.php");	
include_once("css_construct.php");
	
$idCotizacion="";



//////Si recibo un cliente
	if(!empty($_REQUEST['TxtAsociarCotizacion'])){
		
		$idCotizacion=$_REQUEST['TxtAsociarCotizacion'];
	}

	////////// Paginacion
$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);

    	$limit = 8;
    	$startpoint = ($page * $limit) - $limit;
		
/////////

include_once ('funciones/function.php');
include_once("procesadores/Remisiones.process.php");
	
	
?>
 
<!DOCTYPE html>
<html>
  
	<head>
	
	 <?php $css =  new CssIni("Remisiones"); ?>
	</head>
 
	<body>
   
	 <?php 
	 
	 
	 $css->CabeceraIni("TS5 Remisiones"); 
	 
	 	
	 $css->CrearForm("FrmBuscarCotizacion",$myPage,"post","_self");
	 $css->CrearInputText("TxtBuscarCotizacion","text","Buscar Cotizacion: ","","Digite el numero de una cotizacion","white","","",300,30,0,0);
	 $css->CrearBoton("BtnBuscarCotizacion", "Buscar");
	 $css->CerrarForm();
	 
	 $css->CabeceraFin(); 
	 $css->CreaMenuBasico("Menu"); 
            $css->CreaSubMenuBasico("Historial de Remisiones","historialremisiones.php");
         $css->CierraMenuBasico(); 
	 ?>
	

	

	
    <div class="container" align="center">
	<br>
	<?php	
	
        $css->CrearImageLink("../VMenu/MnuVentas.php", "../images/remision.png", "_self",200,200);
	if(!empty($_REQUEST["TxtidRemision"])){
            $RutaPrintCot="../tcpdf/examples/imprimiremision.php?ImgPrintRemi=".$_REQUEST["TxtidRemision"];			
            $css->CrearTabla();
            $css->CrearFilaNotificacion("Remision almacenada Correctamente <a href='$RutaPrintCot' target='_blank'>Imprimir Remision No. $_REQUEST[TxtidRemision]</a>",16);
            $css->CerrarTabla();
            if(!empty($_REQUEST["TxtidIngreso"])){
                $RutaPrintIngreso="PDF_Documentos.php?idDocumento=4&idIngreso=".$_REQUEST["TxtidIngreso"];			
                $css->CrearTabla();
                $css->CrearFilaNotificacion("Comprobante de Ingreso Creado Correctamente <a href='$RutaPrintIngreso' target='_blank'>Imprimir Comprobante de Ingreso No. $_REQUEST[TxtidIngreso]</a>",16);
                $css->CerrarTabla();
            }
	}
	
	
	
	?>	
	
     	  
	  <div id="Productos Agregados" class="container" >
	
		<h2 align="center">
					<?php 
										
					////////////////////////////////////Si se solicita buscar una cotizacion
	
	if(!empty($_REQUEST["TxtBuscarCotizacion"])){
		
		$Key=$_REQUEST["TxtBuscarCotizacion"];
		$pa=$obVenta->Query("SELECT * FROM cotizacionesv5 c INNER JOIN clientes cl ON c.Clientes_idClientes = cl.idClientes WHERE cl.RazonSocial LIKE '%$Key%' OR c.ID = '$Key' ORDER BY c.ID DESC LIMIT 20");
		if($obVenta->NumRows($pa)){
			print("<br>");
			$css->CrearTabla();
			$css->FilaTabla(18);
			$css->ColTabla("Cotizaciones Encontradas para Asociar:",4);
			$css->CierraFilaTabla();
			
			$css->FilaTabla(18);
				$css->ColTabla("ID",1);
				$css->ColTabla('Fecha',1);
				$css->ColTabla('RazonSocial',1);
				$css->ColTabla('Usuario',1);
				$css->ColTabla('Observaciones',1);
				$css->ColTabla('NumSolicitud',1);
				$css->ColTabla('NumOrden',1);
				$css->ColTabla('Visualizar',1);
				$css->ColTabla('Asociar',1);
			$css->CierraFilaTabla();
			while($DatosCotizacion=$obVenta->FetchArray($pa)){
				$css->FilaTabla(14);
				$css->ColTabla($DatosCotizacion['ID'],1);
				$css->ColTabla($DatosCotizacion['Fecha'],1);
				$css->ColTabla($DatosCotizacion['RazonSocial'],1);
				$css->ColTabla($DatosCotizacion['Usuarios_idUsuarios'],1);
				$css->ColTabla($DatosCotizacion['Observaciones'],1);
				$css->ColTabla($DatosCotizacion['NumSolicitud'],1);
				$css->ColTabla($DatosCotizacion['NumOrden'],1);
				print("<td>");
				$RutaPrintCot="../tcpdf/examples/imprimircoti.php?ImgPrintCoti=".$DatosCotizacion["ID"];
				$css->CrearLink($RutaPrintCot,"_blank","Ver");
				print("</td>");
				$css->ColTablaVar($myPage,"TxtAsociarCotizacion",$DatosCotizacion['ID'],"","Asociar Cotizacion");
				$css->CierraFilaTabla();
			}
			
			$css->CerrarTabla(); 
		}else{
			print("<h3>No hay resultados</h3>");
		}
		
	}
					
					//////////////////////////Se dibujan los campos para crear la remision
					
	if(!empty($idCotizacion)){
                //print("<script>alert('entra')</script>");
		$DatosCotizacion=$obVenta->DevuelveValores("cotizacionesv5","ID",$idCotizacion);
		$DatosCliente=$obVenta->DevuelveValores("clientes","idClientes",$DatosCotizacion["Clientes_idClientes"]);
		$css->CrearFormularioEvento("FrmCrearRemision",$myPage,"post","_self","onKeypress='DeshabilitaEnter()'");
                print("REMISION<br><br>");
                        $css->CrearInputText("TxtidCliente","hidden","",$DatosCotizacion["Clientes_idClientes"],"","black","","",150,30,0,0);
			$css->CrearTabla();
			$css->FilaTabla(18);
                        print("<td colspan=3>");
			print("FECHA: ");
                        $css->CrearInputText("TxtFechaRemision","text","",date("Y-m-d"),"","black","","",150,30,0,1); 
                        print("</td>"); 
			$css->ColTabla("COTIZACION:",1);
			$css->ColTablaInputText("TxtIdCotizacion","text",$DatosCotizacion["ID"],"","","black","","",150,30,1,1);
			$css->CierraFilaTabla();
			$css->FilaTabla(16);
			$css->ColTabla('CLIENTE:',1);
			$css->ColTabla($DatosCliente["RazonSocial"],1);
			$css->ColTabla(' ',1);
			$css->ColTabla('OBRA:',1);
			$css->ColTablaInputText("TxtObra","text","","","Nombre de la Obra","black","","",300,30,0,1);
			$css->CierraFilaTabla();
			
			$css->FilaTabla(16);
			$css->ColTabla('DIRECCION:',1);
			$css->ColTabla($DatosCliente["Direccion"],1);
			$css->ColTabla(' ',1);
			$css->ColTabla('DIRECCION OBRA:',1);
			$css->ColTablaInputText("TxtDireccionObra","text","","","Direccion de la Obra","black","","",300,30,0,1);
			$css->CierraFilaTabla();
			
			$css->FilaTabla(16);
			$css->ColTabla('TELEFONO:',1);
			$css->ColTabla($DatosCliente["Telefono"],1);
			$css->ColTabla(' ',1);
			$css->ColTabla('CIUDAD Y TELEFONO:',1);
			print("<td>");
			$css->CrearInputText("TxtCiudadObra","text","","","Ciudad","black","","",300,30,0,1);
			print("<br>");
			$css->CrearInputText("TxtTelefonoObra","text","","","Telefono","black","","",300,30,0,1);
			print("</td>");
			$css->CierraFilaTabla();
			
			$css->FilaTabla(16);
			$css->ColTabla('CIUDAD:',1);
			$css->ColTabla($DatosCliente["Ciudad"],1);
			$css->ColTabla(' ',1);
			$css->ColTabla('RETIRA:',1);
			$css->ColTablaInputText("TxtRetira","text","","","Retira","black","","",300,30,0,1);
			$css->CierraFilaTabla();
			
			$css->FilaTabla(16);
			$css->ColTabla('NIT:',1);
			$css->ColTabla($DatosCliente["Num_Identificacion"],1);
			$css->ColTabla(' ',1);
			$css->ColTabla('FECHA Y HORA:',1);
			$Fecha=date("Y-m-d");
			$Hora=date("H:i:s");
			print("<td>");
			$css->CrearInputText("TxtFecha","text","",$Fecha,"Fecha y Hora","black","","",150,30,0,1);
			$css->CrearInputText("TxtHora","text","",$Hora,"Fecha y Hora","black","","",150,30,0,1);
			print("</td>");
			$css->CierraFilaTabla();
			
			$css->FilaTabla(16);
			print("<td colspan=5 style='text-align: center'>");
			$css->CrearTextArea("TxtObservacionesRemision","","","Observaciones","black","","",500,150,0,0);
			print("</td>");
			$css->CierraFilaTabla();
			
			$css->CerrarTabla();
			
			$css->CrearTabla();
			$Consulta=$obVenta->ConsultarTabla("cot_itemscotizaciones","WHERE NumCotizacion=$idCotizacion");
			
			$css->FilaTabla(16);
			$css->ColTabla('REFERENCIA',1);
			$css->ColTabla('DESCRIPCION',1);
			$css->ColTabla('CANTIDAD',1);
                        $css->ColTabla('MULTIPLICADOR',1);
			$css->ColTabla('VALOR',1);
			$css->CierraFilaTabla();
			
			$Total=0;
			$Subtotal=0;
			$IVA=0;
			while($DatosItems=$obVenta->FetchArray($Consulta)){
				
				
				$Subtotal=$Subtotal+$DatosItems["Subtotal"];
				$IVA=round($IVA+$DatosItems["IVA"]);
				$Total=round($Total+$DatosItems["Total"]);
				
				$css->FilaTabla(14);
				$css->ColTabla($DatosItems["Referencia"],1);
				$css->ColTabla($DatosItems["Descripcion"],1);
				$css->ColTabla($DatosItems["Cantidad"],1);
                                $css->ColTabla($DatosItems["Multiplicador"],1);
				$css->ColTabla(number_format($DatosItems["Subtotal"]),1);
				$css->CierraFilaTabla();
				
			}
			
			
			$css->FilaTabla(16);
			
			//$css->ColTabla('AGREGAR UNIDADES AL MULTIPLICADOR',3);
			//print("<td>");
			$css->CrearInputText("TxtSubtotalH","hidden","",$Subtotal,"","","","",300,30,0,1);
			$css->CrearInputText("TxtIVAH","hidden","",$IVA,"","","","",300,30,0,1);
			$css->CrearInputText("TxtTotalH","hidden","",$Total,"","","","",300,30,0,1);
			$css->CrearInputNumber("TxtDias","hidden","",1,"Dias","black","onchange","calculetotaldias()",80,30,0,1,1,1000,"any");
			//print("</td>");
			
			$css->CierraFilaTabla();
			
			
			$css->FilaTabla(16);
			$css->ColTabla('SUBTOTAL',3);
			print("<td>");
			$css->CrearInputNumber("TxtSubtotal","number","",$Subtotal,"Subtotal","black","","",200,30,1,1,0,"","any");
			print("</td>");
			$css->CierraFilaTabla();
			$css->FilaTabla(16);
			$css->ColTabla('IVA',3);
			print("<td>");
			$css->CrearInputNumber("TxtIVA","number","",$IVA,"IVA","black","","",200,30,1,1,0,"","any");
			print("</td>");
			$css->CierraFilaTabla();
			$css->FilaTabla(16);
			$css->ColTabla('TOTAL',3);
			print("<td>");
			$css->CrearInputNumber("TxtTotal","number","",$Total,"Subtotal","black","","",200,30,1,1,0,"","any");
			print("</td>");
			$css->CierraFilaTabla();
			
			$css->FilaTabla(16);
			$css->ColTabla('ANTICIPO:',3);
			print("<td>");
			$css->CrearInputNumber("TxtAnticipo","number","",0,"Anticipo","black","onkeyup","calculetotaldias()",200,30,0,1,0,"","any");
                        print("<br>Seleccione una Cuenta destino para el anticipo:<br>");
                        $css->CrearSelect("CmbCuentaDestino", "");
                            $Consulta=$obVenta->ConsultarTabla("cuentasfrecuentes","WHERE ClaseCuenta='ACTIVOS'");
                            while($DatosCuentasFrecuentes=$obVenta->FetchArray($Consulta)){
                                if($DatosCuentasFrecuentes["CuentaPUC"]=='110510')
                                    $Sel=1;
                                else
                                    $Sel=0;
                                $css->CrearOptionSelect($DatosCuentasFrecuentes["CuentaPUC"], $DatosCuentasFrecuentes["Nombre"], $Sel);
                                
                            }
                        $css->CerrarSelect(); 
                        print("<br>Seleccione un Centro de Costos:<br>");
                        $css->CrearSelect("CmbCentroCostos", "");
                            $Consulta=$obVenta->ConsultarTabla("centrocosto","");
                            while($DatosCentroCostos=$obVenta->FetchArray($Consulta)){
                               
                                $css->CrearOptionSelect($DatosCentroCostos["ID"], $DatosCentroCostos["Nombre"], 0);
                                
                            }
                        $css->CerrarSelect(); 
                            
			print("</td>");
			$css->CierraFilaTabla();
			
			$css->FilaTabla(16);
			$css->ColTabla('SALDO:',3);
			print("<td>");
			$css->CrearInputNumber("TxtSaldo","number","",$Total,"Saldo","black","","",200,30,1,1,0,"","any");
                                               
			print("<br>");
			$css->CrearBotonConfirmado("BtnGuardarRemision","Guardar");
			print("</td>");
			$css->CierraFilaTabla();
			
			$css->CerrarTabla();
		$css->CerrarForm();	
	}else{
		$css->CrearTabla();
		$css->CrearFilaNotificacion("Por favor busque y asocie una cotizacion",16);
		$css->CerrarTabla();
	}
					
				
					?></h2>
               		<table class="table table-bordered" >
                      <tr>
                        <td>
                        	
                            <?php 
							
								
							?>
                              
                                
                              </tr>
                           
                            	
                            
                           
                        </td>
                      </tr>
		

    </div>
	
      			
</div> <!-- /container -->
     

    

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap-transition.js"></script>
    <script src="js/bootstrap-alert.js"></script>
    <script src="js/bootstrap-modal.js"></script>
    <script src="js/bootstrap-dropdown.js"></script>
    <script src="js/bootstrap-scrollspy.js"></script>
    <script src="js/bootstrap-tab.js"></script>
    <script src="js/bootstrap-tooltip.js"></script>
    <script src="js/bootstrap-popover.js"></script>
    <script src="js/bootstrap-button.js"></script>
    <script src="js/bootstrap-collapse.js"></script>
    <script src="js/bootstrap-carousel.js"></script>
    <script src="js/bootstrap-typeahead.js"></script>
	

   
		
<a style="display:scroll; position:fixed; bottom:10px; right:10px;" href="#" title="Volver arriba"><img src="../images/up1_amarillo.png" /></a>

	
 
  </body>
  
  
</html>

<script language="JavaScript"> 
atajos();
posiciona('TxtCodigoBarras');
</script> 
