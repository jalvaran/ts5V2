<script src="../shortcuts.js" type="text/javascript">
</script>
<script src="js/funciones.js"></script>


<?php 

$myPage="InformeAdministracion.php";
include_once("../sesiones/php_control.php");
include_once("css_construct.php");

$fecha=date("Y-m-d");
	

?>
 
<!DOCTYPE html>
<html>
  
	<head>
	
	
	
	
	 <?php $css =  new CssIni("Informes de Administrador"); ?>
	</head>
 
	<body>
   
	 <?php 
	 
	 $css->CabeceraIni("SoftConTech Informe de Administracion"); 
	 $css->CabeceraFin(); 
	  
	  
	 ?>
	

	

	
    <div class="container">
	<br>
	
	
     	  
	  <div id="Usuarios" class="container" >
	
		<h2 align="center">
                    <?php 

                    $imagerute="../images/informes.png";
                    $Ruta=$myPage;			
                    $css->CrearImageLink($Ruta,$imagerute,"_self",150,150);

                    ?></h2>
               		<table class="table table-bordered" >
                      <tr>
                        <td>
                        	
                            <?php 
								$css->CrearForm("FrmInformeVentas","../tcpdf/examples/InformeAdmin.php","post","_blank");
								
								
								
								$css->CrearTabla();
								
								$css->ColTabla("<h4>Seleccione el Rango de Fechas</h4>",3);
								$css->CierraColTabla();
								print("</tr>");
								print("<tr>");
									print("<td>");
									$css->CrearInputText("TxtFechaIni","date","Fecha Inicial: ",$fecha,"","","","",150,30,0,0);
									print("</td>");
									print("<td>");
									$css->CrearInputText("TxtFechaFinal","date","Fecha Final: ",$fecha,"","","","",150,30,0,0);
									print("</td>");
									$css->ColTablaBoton("BtnEnviar","Enviar");
								
								print("</tr>");
								$css->CierraFilaTabla();
								$css->CerrarForm();
							?>
                              
                                
                              </tr>
                           
                            	
                            <?php  $css->CerrarTabla();
								
							?>
                              
							 
                           
                        </td>
                      </tr>
		</table>
		
		
								
			

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
