
 <script src="js/funciones.js"></script>
<?php 

session_start();

include_once("../modelo/php_conexion.php");

if (!isset($_SESSION['username']))
{
  exit("No se ha iniciado una sesion <a href='../index.php' >Iniciar Sesion </a>");
  
}

$NombreUser=$_SESSION['nombre'];
$idUser=$_SESSION['idUser'];	


	$NumOrden="";

	if(!empty($_REQUEST['CmbOrdenAct'])){
		$NumOrden=$_REQUEST['CmbOrdenAct'];
		
	}
	
	if(!empty($_POST['BtnCrearOrden'])){
		//print("Entra");
		$pa=mysql_query("SELECT MAX(NumOrden) as MaxNum FROM act_ordenes") or die("No se pudo consultar act_ordenes".mysql_error());
		$DatosOrden=mysql_fetch_array($pa);
		$NumOrden=$DatosOrden["MaxNum"]+1;
		mysql_query("INSERT INTO act_ordenes (NumOrden, idAct_Movimiento, Fecha, Entrega, Recibe, Usuarios_idUsuarios, Origen, Destino) 
		VALUES ('$NumOrden', 'INI', '$_REQUEST[TxtFecha]', '$_REQUEST[TxtEntrega]', '$_REQUEST[TxtRecibe]','$idUser', '$_REQUEST[TxtOrigen]', '$_REQUEST[TxtDestino]');") or die("No se pudo agregar la nueva orden a act_ordenes".mysql_error());;
		echo "<script>alert('Orden Creada')</script>";
	}
	
	if(!empty($_POST['BtnAgregarActivo'])){
		//print("Entra");
		$NumOrden=$_REQUEST['TxtNumOrden'];
		$pa=mysql_query("SELECT * FROM act_ordenes WHERE NumOrden='$NumOrden'") or die("No se pudo consultar la orden No $NumOrden ".mysql_error());
		$DatosOrden=mysql_fetch_array($pa);
		
		mysql_query("INSERT INTO act_pre_movimientos (Movimiento, Origen, Destino, Entrega, Recibe, Fecha, Estado, MotivoMovimiento, Observaciones, NumOrden, BodegaDestino, idActivo) 
		VALUES ('$_REQUEST[CmbMovimiento]', '$DatosOrden[Origen]', '$DatosOrden[Destino]', '$DatosOrden[Entrega]','$DatosOrden[Recibe]', '$DatosOrden[Fecha]',
		'$_REQUEST[CmbEstado]','$_REQUEST[TxtMotivo]','$_REQUEST[TxtObservaciones]','$NumOrden','$_REQUEST[CmbBodegaDestino]','$_REQUEST[TxtIdActivo]');") or die("No se pudo agregar la nueva orden a act_ordenes".mysql_error());;
		
	}
	
	
	if(!empty($_POST['BtnGuargarOrden'])){
		
		$NumOrden=$_REQUEST['TxtNumOrden'];
		$pa=mysql_query("SELECT * FROM act_pre_movimientos WHERE NumOrden='$NumOrden'") or die("No se pudo consultar la orden No $NumOrden ".mysql_error());
		
		while($DatosOrden=mysql_fetch_array($pa)){ 
	
		mysql_query("INSERT INTO act_movimientos (Movimiento, Origen, Destino, Entrega, Recibe, Fecha, Estado, MotivoMovimiento, Observaciones, NumOrden, BodegaDestino, idActivo) 
		VALUES ('$DatosOrden[Movimiento]', '$DatosOrden[Origen]', '$DatosOrden[Destino]', '$DatosOrden[Entrega]','$DatosOrden[Recibe]', '$DatosOrden[Fecha]',
		'$DatosOrden[Estado]','$DatosOrden[MotivoMovimiento]','$DatosOrden[Observaciones]','$NumOrden','$DatosOrden[BodegaDestino]','$DatosOrden[idActivo]');") or die("No se pudo agregar la nueva orden a act_ordenes".mysql_error());
		
		mysql_query("DELETE FROM act_pre_movimientos WHERE NumOrden='$NumOrden'") or die(mysql_error());
		mysql_query("UPDATE act_ordenes SET Cerrada=1 WHERE NumOrden='$NumOrden'") or die(mysql_error());
		mysql_query("UPDATE activos SET Bodega=$DatosOrden[BodegaDestino] WHERE idActivos='$DatosOrden[idActivo]'") or die(mysql_error());
		
		
		}
		header("location:../tcpdf/examples/PrintOrden.php?TxtNumOrden=$NumOrden");
	}
	
	
	if(!empty($_GET['del'])){
		$id=$_GET['del'];
		mysql_query("DELETE FROM act_pre_movimientos WHERE idAct_Movimientos='$id'") or die(mysql_error());
		header("location:OrdenesActivos.php?CmbOrdenAct=$NumOrden");
	}
		
	
	
?>
 
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Ordenes Activos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Software de Techno Soluciones Ordenes Activos">
    <meta name="author" content="Techno Soluciones SAS">

    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
    </style>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="ico/favicon.png">
  
  
  

  
  
  
  </head>

  <body>

  
  
  
    <div class="navbar navbar-inverse navbar-fixed-top" >
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="../Menu.php">SoftConTech Ordenes Activos</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
			 <li class="active">
			<a href="#cant2" role="button" class="btn" data-toggle="modal" title="Agregar Orden">
						<span class="badge badge-success">Agregar Orden</span>
                    </a>
			<li>
			
			
			
			
              <li class="active"><a href="index.php">Orden: </a></li>
               <!-- <li><a href="mis_pedidos.php">Mis Pedidos</a></li> -->
			 
			  
			  <li><form name= "FormOrden" action="OrdenesActivos.php" id="FormOrden" method="post" target="_self"> 
					<select name="CmbOrdenAct" onchange="EnviaFormOrden()">
					<?php
						
						$pa=mysql_query("SELECT * FROM act_ordenes act INNER JOIN usuarios us ON act.Usuarios_idUsuarios=us.idUsuarios WHERE act.Cerrada=0 GROUP BY act.NumOrden");	
							print("<option value='NO'>Seleccione una Orden</option>");
							while($DatosOrden=mysql_fetch_array($pa)){  
								if($DatosOrden["NumOrden"]==$NumOrden)
									print("<option value=$DatosOrden[NumOrden] selected>No. $DatosOrden[NumOrden] por $DatosOrden[Nombre] $DatosOrden[Apellido] con destino: $DatosOrden[Destino]</option>");
								else
									print("<option value=$DatosOrden[NumOrden]>No. $DatosOrden[NumOrden] por $DatosOrden[Nombre] $DatosOrden[Apellido] con destino: $DatosOrden[Destino]</option>");
							}
							
					?>
					</select>
					
					<input type="submit" name="BtnDepartamento" value="Cargar" class="btn btn-primary"></input>
				</form>
			  </li>
			  
			  
			  
		
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

	
	
	
	<div id="cant2" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
       	<form name="form" method="post" action="OrdenesActivos.php">
          	
            <div class="modal-header">
	            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    	        <h3 id="myModalLabel">Agregar Orden</h3>
            </div>
            <div class="modal-body">
           	    <div class="row-fluid">
	               
    	            <div class="span6">
                    	<strong>Fecha: <br><input name="TxtFecha" value="<?php echo date("Y-m-d");?>" type="text" autocomplete="off"></strong><br>
		                <strong>Entrega: <input name="TxtEntrega" value="" type="text" autocomplete="off" placeholder="Nombre de quien Entrega" required></strong><br>
                        <strong>Recibe:  <input name="TxtRecibe" value="" type="text" autocomplete="off" placeholder="Nombre de quien Recibe" required></strong><br>
                        <strong>Origen: <input name="TxtOrigen" value="" type="text" autocomplete="off" placeholder="De Donde se retira" required></strong><br>
                        <strong>Destino:  <input name="TxtDestino" value="" type="text" autocomplete="off" placeholder="A donde se lleva" required></strong><br>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
        	    <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i> <strong>Cerrar</strong></button>
            	<input type="submit" name="BtnCrearOrden" value="Crear Orden" class="btn btn-primary">
            </div>
            </form>
        </div>
		
		
		
    <div class="container">

      <!-- Main hero unit for a primary marketing message or call to action -->
      

      <!-- Example row of columns -->
	  
	  <div class="span4" >
            <?php
				if(!empty($_POST['codigo'])){
					$codigo=$_POST['codigo'];
					
					
					$pa=mysql_query("SELECT * FROM atencion_pedidos WHERE Prod_Referencia='$codigo' AND Usuarios_idUsuarios='$idUser' AND Mesas_idMesas = '$_SESSION[idMesaActiva]'");				
					if($row=mysql_fetch_array($pa)){
						$new_cant=$row['Prod_Cantidad']+$_POST['TxtCantidad'];
						mysql_query("UPDATE atencion_pedidos SET Prod_Cantidad='$new_cant' WHERE Prod_Referencia='$codigo'");
					}else{
						
						$pa1=mysql_query("SELECT Prioridad FROM atencion_pedidos WHERE Usuarios_idUsuarios='$idUser' AND Mesas_idMesas = '$_SESSION[idMesaActiva]'");
						if($row1=mysql_fetch_array($pa1)){
							$MaxPri=$row1['Prioridad'];
						}				
						
						//mysql_query("INSERT INTO atencion_pedidos (Prod_Referencia, Prod_Cantidad, Usuarios_idUsuarios, Mesas_idMesas, Prioridad) 
						//VALUES ('$codigo','$_POST[TxtCantidad]','$_SESSION[idUser]','$idMesa','$MaxPri')");
					}
				}
			?>
               
            </div>
	  
	  <div id="ServiciosAgregados" class="container" >
	
		<h2 align="center">
					<?php 
					$pa=mysql_query("SELECT * FROM act_ordenes WHERE NumOrden='$NumOrden'") or die(mysql_error());	
					$DatosOrden=mysql_fetch_array($pa);
					print("Activos agregados a la Orden $NumOrden Entregado por: $DatosOrden[Entrega], Recibido por: $DatosOrden[Recibe] con destino a $DatosOrden[Destino] <br>");
					
					?></h2>
               		<table class="table table-bordered" >
                      <tr>
                        <td>
                        	<table class="table table-bordered table table-hover" >
                            <?php 
								$neto=0;$tneto=0;
								$pa=mysql_query("SELECT * FROM act_pre_movimientos m INNER JOIN activos a ON m.idActivo=a.idActivos 
												WHERE m.NumOrden='$NumOrden'") or die(mysql_error());
								if(mysql_num_rows($pa)){						
								while($row=mysql_fetch_array($pa)){
									
									
							?>
                              <tr style="font-size:14px">
                                <td><?php echo $row['NombreAct']; ?></td>
                                <td><?php echo $row['Referencia']; ?></td>
								<td><?php echo $row['Serie']; ?></td>
								<td><?php echo $row['Marca']; ?></td>
                                <td>Se moverá a bodega: <?php echo $row['BodegaDestino']; ?> por: <?php echo $row['MotivoMovimiento']; ?></td>
                                <td>
                                	<a href="OrdenesActivos.php?del=<?php echo $row['idAct_Movimientos']; ?>&CmbOrdenAct=<?php echo $NumOrden; ?>" title="Eliminar de la Lista">
                                		<i class="icon-remove"></i>
                                    </a>
                                </td>
                              </tr>
                            <?php } 
							?>
                            	<td colspan="4" ><div align="right">
								<form name="FrmGuardarOrden" action="OrdenesActivos.php" method="post" target="_self">
									<input type="submit" name="BtnGuargarOrden" value="Guardar" style="font-size:14px;color:red">
									<input type="hidden" name="TxtNumOrden" value="<?php echo $NumOrden; ?>">
								</form>
								</div></td>
                            <?php }
								$pa=mysql_query("SELECT * FROM act_pre_movimientos WHERE NumOrden='$NumOrden'");				
								if(!$row=mysql_fetch_array($pa)){
							?>
                              <tr><div class="alert alert-success" align="center"><strong>No hay Activos agregados a esta orden</strong></div></tr>
							  <?php } ?>
                            </table>
                        </td>
                      </tr>
		

    </div>
				
				
				
	  
	  
      <div class="row">
      	
      </div>
      <div align="center">
      	
        <div class="row-fluid">
    		<div class="span8">
			<?php
				if($NumOrden>0){
				$sql="SELECT * FROM activos act INNER JOIN bodega b ON act.Bodega=b.idBodega";
				//print($sql);
                $pa=mysql_query($sql) or die ("No se pudo consultar la tabla activos".mysql_error());				
                while($row=mysql_fetch_array($pa)){
				//$ImageRuta=explode("/", $row['Imagen']);
				//$PrecioFinal=$row['PrecioVenta'];
            ?>                       
        	<table class="table table-bordered">
            	<tr><td>
                	<div class="row-fluid">
                    	<div class="span4">
                            <center><strong><?php print("$row[NombreAct] $row[Referencia] Marca $row[Marca] Serie: $row[Serie] Bodega: $row[Nombre]"); ?></strong></center><br>
                            
                        </div>
                        
                        <div class="span4"><br>
                        	<form name="form<?php $row['idActivos']; ?>" method="post" action="">
                            	<input type="hidden" name="TxtIdActivo" value="<?php echo $row['idActivos']; ?>">
								<input type="hidden" name="TxtNumOrden" value="<?php echo $NumOrden; ?>">
								Movimiento:<br><select name="CmbMovimiento">
									<option value="SALIDA">Salida</option>
									<option value="ENTRADA">Entrada</option>
								</select><br>
								Estado:<br><select name="CmbEstado">
									<option value="BUENO">Bueno</option>
									<option value="REGULAR">Regular</option>
									<option value="MALO">Malo</option>
								</select><br>
								Seleccione la bodega destino:<br><select name="CmbBodegaDestino" required>
									<?php
						
									$pa2=mysql_query("SELECT * FROM bodega");	
									print("<option> </option>");
									while($DatosBodega=mysql_fetch_array($pa2)){  
										
										print("<option value=$DatosBodega[idBodega]>$DatosBodega[Nombre]</option>");
									}
							
								?>
								</select><br>
								<br><textarea name="TxtMotivo" placeholder="Motivo del movimiento" style="height:50px;font-size:20;width:200px"></textarea><br>
								<br><textarea name="TxtObservaciones"  placeholder="Observaciones" style="height:50px;font-size:20;width:200px"></textarea><br>
								
                                <input type="submit" name="BtnAgregarActivo" value="Agregar" class="btn btn-primary">
                                   
                               
                            </form>
                        </div>
                    </div>
            	</td></tr>
        	</table>
				<?php }
				
				}else{
					echo "Por favor Selecciona o crea una Orden";
					
				} ?>
        	</div>
            
    	</div>
        
      </div>

      <hr>

      <footer>
        <p>&copy; Techno Soluciones SAS 2015</p>
      </footer>

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
	

   
		
<a style="display:scroll; position:fixed; bottom:10px; right:10px;" href="#" title="Volver arriba"><img src="../iconos/up1_amarillo.png" /></a>
  </body>
  
  
</html>
