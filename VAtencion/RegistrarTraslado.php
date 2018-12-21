<?php 
$myPage="RegistrarTraslado.php";
include_once("../sesiones/php_control.php");
include_once("css_construct.php");

$idTraslado="";
//////Si recibo un cliente
	if(!empty($_REQUEST['idTraslado'])){
		
		$idTraslado=$_REQUEST['idTraslado'];
	}

	
print("<html>");
print("<head>");
$css =  new CssIni("Registrar traslado");

print("</head>");
print("<body>");
    
    include_once("procesadores/ProcesaTraslado.php");
    
    $css->CabeceraIni("Registro de Traslados Recibidos"); //Inicia la cabecera de la pagina
    
   
    
    $css->CabeceraFin(); 
    ///////////////Creamos el contenedor
    /////
    /////
    $css->CrearDiv("principal", "container", "center",1,1);
    print("<br>");
    ///////////////Creamos la imagen representativa de la pagina
    /////
    /////	
    $css->CrearImageLink("../VMenu/MnuVentas.php", "../images/traslados.png", "_self",200,200);
    
    
    ///////////////Se crea el DIV que servirá de contenedor secundario
    /////
    /////
    $css->CrearDiv("Secundario", "container", "center",1,1);
    $DatosSucursal=$obVenta->DevuelveValores("empresa_pro_sucursales", "Actual", 1);										
    $DatosTraslado=$obVenta->DevuelveValores("traslados_mercancia", "ID", $idTraslado);
    if($DatosTraslado["Estado"]=="VERIFICADO" or $DatosTraslado["Origen"]==$DatosSucursal["ID"]){
        $css->CrearNotificacionRoja("El Traslado $idTraslado ya fue registrado", 18);
        exit();
    }
    //////////////////////////Se dibujan los items del traslado
    /////
    /////
    if(!empty($idTraslado)){
        
            $css->CrearTabla();
            $css->CrearFilaNotificacion("Items de este Traslado",18);
            $css->FilaTabla(16);
            
            $css->ColTabla('<strong>CodigoBarras</strong>',1);
            $css->ColTabla('<strong>Referencia</strong>',1);
            $css->ColTabla('<strong>Nombre</strong>',1);
            $css->ColTabla('<strong>Cantidad</strong>',1);
            $css->ColTabla('<strong>PrecioVenta</strong>',1);
            $css->ColTabla('<strong>PrecioMayorista</strong>',1);
            $css->ColTabla('<strong>CostoUnitario</strong>',1);
            $css->ColTabla('<strong>IVA</strong>',1);
            $css->ColTabla('<strong>Departamento</strong>',1);
            $css->ColTabla('<strong>Sub1</strong>',1);
            $css->ColTabla('<strong>Sub2</strong>',1);
            $css->ColTabla('<strong>Sub3</strong>',1);
            $css->ColTabla('<strong>Sub4</strong>',1);
            $css->ColTabla('<strong>Sub5</strong>',1);
            $css->ColTabla('<strong>CuentaPUC</strong>',1);

            $css->CierraFilaTabla();
            $Consulta=$obVenta->ConsultarTabla("traslados_items","WHERE idTraslado='$idTraslado'");
            
            while($DatosItemTraslado=$obVenta->FetchArray($Consulta)){

                ///////////////Creo Formulario para edicion
                $css->FilaTabla(14);
                $css->ColTabla($DatosItemTraslado["CodigoBarras"],1);
                $css->ColTabla($DatosItemTraslado["Referencia"],1);
                $css->ColTabla($DatosItemTraslado["Nombre"],1);
                $css->ColTabla($DatosItemTraslado["Cantidad"],1);
                $css->ColTabla($DatosItemTraslado["PrecioVenta"],1);
                $css->ColTabla($DatosItemTraslado["PrecioMayorista"],1);
                $css->ColTabla($DatosItemTraslado["CostoUnitario"],1);
                $css->ColTabla($DatosItemTraslado["IVA"],1);
                $css->ColTabla($DatosItemTraslado["Departamento"],1);
                $css->ColTabla($DatosItemTraslado["Sub1"],1);
                $css->ColTabla($DatosItemTraslado["Sub2"],1);
                $css->ColTabla($DatosItemTraslado["Sub3"],1);
                $css->ColTabla($DatosItemTraslado["Sub4"],1);
                $css->ColTabla($DatosItemTraslado["Sub5"],1);
                $css->ColTabla($DatosItemTraslado["CuentaPUC"],1);

                $css->CierraFilaTabla();
            }
    
    $css->CerrarTabla();
			
    }
    
    $css->CrearForm2("FormGuardarTraslados", $myPage, "post", "_self");
    $css->CrearInputText("idTraslado", "hidden", "", $idTraslado, "", "", "", "", "", "", 0, 0);
    $css->CrearBotonConfirmado("BtnGuardarTraslado", "Guardar este Traslado");
    $css->CerrarForm();
    $css->CerrarDiv();//Cerramos contenedor Secundario
    $css->CerrarDiv();//Cerramos contenedor Principal
    $css->AgregaJS(); //Agregamos javascripts
    $css->AgregaSubir();
    print("</body></html>");
?>