<?php
$myPage="MnuInformes.php";
include_once("../sesiones/php_control.php");
?>
<!DOCTYPE html>
<script src="js/funciones.js"></script>
<html lang="es">
     <head>
	 <title>TS5</title>
     <meta charset="utf-8">
	 
	 
	 
	 <?php
	 
	
	include_once("css_construct.php");

	$NombreUser=$_SESSION['nombre'];
	
	
	 ?>
       
     </head>
     <body  class="">

<!--==============================header=================================-->

 <?php 
	
	$css =  new CssIni();

	$css->CabeceraIni(); 
	//$css->BlockMenuIni(); 
	$css->CabeceraFin(); 
	
 ?>
 
 
 

<!--==============================Content=================================-->

<div class="content"><div class="ic">TECHNO SOLUCIONES SAS</div>
  
    
	<?php 
 
	
        $obCon =  new ProcesoVenta($idUser);
        $sql="SELECT TipoUser,Role FROM usuarios WHERE idUsuarios='$idUser'";
        $DatosUsuario=$obCon->Query($sql);
        $DatosUsuario=$obCon->FetchArray($DatosUsuario);
        $TipoUser=$DatosUsuario["TipoUser"];   
	$css->IniciaMenu("Informes"); 
        $i=0;
        $idMenu=17;
        $Datos=$obCon->ConsultarTabla("menu_pestanas", "WHERE idMenu='$idMenu' AND Estado='1' ORDER BY Orden");
        while($DatosPestanas=$obCon->FetchArray($Datos)){
            $Submenus[$i]=$DatosPestanas["ID"];
            if($i==0){
            $css->MenuAlfaIni($DatosPestanas["Nombre"]);
            }else{
                $css->SubMenuAlfa($DatosPestanas["Nombre"],$DatosPestanas["Orden"]);
            }
            $i++;
        }
        $css->MenuAlfaFin();
        $css->IniciaTabs();
            $i=0;
            foreach($Submenus as $idPestana){
               $i++;
                $css->NuevaTabs($i);
                    $Datos=$obCon->ConsultarTabla("menu_submenus", "WHERE idPestana='$idPestana' AND Estado='1' ORDER BY Orden");
                    while ($DatosPaginas=$obCon->FetchArray($Datos)){
                        if($DatosUsuario["TipoUser"]=="administrador"){
                        $Visible=1;
                        }else{
                            $Visible=0;
                            $sql="SELECT ID FROM paginas_bloques WHERE TipoUsuario='$TipoUser' AND Pagina='$DatosPaginas[Pagina]' AND Habilitado='SI'";
                            $DatosUser=$obCon->Query($sql);
                            $DatosUser=$obCon->FetchArray($DatosUser);
                            if($DatosUser["ID"]>0){
                                $Visible=1;
                            }
                        }
                        if($Visible==1){
                            $DatosCarpeta=$obCon->DevuelveValores("menu_carpetas", "ID", $DatosPaginas["idCarpeta"]);
                            $css->SubTabs($DatosCarpeta["Ruta"].$DatosPaginas["Pagina"],$DatosPaginas["Target"],"../images/".$DatosPaginas["Image"],$DatosPaginas["Nombre"]);
                        }
                    }
                $css->FinTabs();
            }
        
        $css->FinMenu();
        /*
	$css->MenuAlfaIni("Financieros");
        $css->SubMenuAlfa("Auxiliares",2);
		$css->SubMenuAlfa("Reporte de Ventas",3);
		$css->SubMenuAlfa("Reporte de Compras",4);
		//$css->SubMenuAlfa("Impuestos",5);
                $css->SubMenuAlfa("Auditoria",5);
	$css->MenuAlfaFin();
	
	$css->IniciaTabs();
	
		$css->NuevaTabs(1);
			$css->SubTabs("../VAtencion/BalanceComprobacion.php","_blank","../images/resultados.png","Balance General y Estado de Resultados");
                        //$css->SubTabs("../VAtencion/BalanceGeneral.php","_blank","../images/resultados.png","Balance General y Estado de Resultados");
		$css->FinTabs();
		$css->NuevaTabs(2);
			$css->SubTabs("../VAtencion/Auxiliares.php","_blank","../images/auxiliar.png","Cuentas Auxiliares");
		$css->FinTabs();
                $css->NuevaTabs(3);
			$css->SubTabs("../VAtencion/InformeVentas.php","_blank","../images/infventas.png","Informe de Ventas");
		$css->FinTabs();
		$css->NuevaTabs(4);
			$css->SubTabs("../VAtencion/InformeCompras.php","_blank","../images/otrosinformes.png","Informe de Compras");
		$css->FinTabs();
                //$css->NuevaTabs(5);
		//	$css->SubTabs("../VAtencion/InformeImpuestos.php","_blank","../images/impuestos.png","Impuestos");
                //$css->FinTabs();
                $css->NuevaTabs(5);
			$css->SubTabs("../VAtencion/AuditoriaDocumentos.php","_blank","../images/auditoria.png","Auditoria de Documentos");
                        $css->SubTabs("../VAtencion/registra_ediciones.php","_blank","../images/registros.png","Historial de Ediciones");
		$css->FinTabs();
		
	$css->FinMenu(); 
	*
         * 
         */
	?>
    
  
 </div>

  
<!--==============================footer=================================-->
<?php 

	$css->Footer();
	
?>



       <script>
      $(document).ready(function(){ 
         $(".bt-menu-trigger").toggle( 
          function(){
            $('.bt-menu').addClass('bt-menu-open'); 
          }, 
          function(){
            $('.bt-menu').removeClass('bt-menu-open'); 
          } 
        ); 
      }) 
    </script>
</body>

</html>