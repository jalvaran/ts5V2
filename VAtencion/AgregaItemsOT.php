<?php 
$myPage="AgregaItemsOT.php";
include_once("../sesiones/php_control.php");
include_once("css_construct.php");

//////Si recibo un cliente
	if(!empty($_REQUEST['idOT'])){
		
		$idOT=$_REQUEST['idOT'];
	}

	
print("<html>");
print("<head>");
$css =  new CssIni("Agregar Items a una Orden de Trabajo");

print("</head>");
print("<body>");
    
    include_once("procesadores/procesaOT.php");
    
    $css->CabeceraIni("Agregar Items a una Orden de Trabajo"); //Inicia la cabecera de la pagina
       
    $css->CabeceraFin(); 
    ///////////////Creamos el contenedor
    /////
    /////
    $css->CrearDiv("principal", "container", "center",1,1);
    print("<br>");
    ///////////////Creamos la imagen representativa de la pagina
    /////
    /////	
    $css->CrearImageLink("ordenesdetrabajo.php", "../images/ordentrabajo.png", "_self",200,200);
    
    ///////////////Si se crea una devolucion o una factura
    /////
    /////
    
        if(!empty($_REQUEST["TxtidOT"])){
            
            $idOT=$_REQUEST["TxtidOT"];
            if($idOT<>""){
                $RutaPrint="../tcpdf/examples/ImprimirOT.php?idOT=".$idOT;
                
                $css->CrearTabla();
                $css->CrearFilaNotificacion("Orden de Trabajo Creada Correctamente <a href='$RutaPrint' target='_blank'>Imprimir OT No. $idOT</a>",16);
                $css->CerrarTabla();
            }else{
                
               $css->AlertaJS("No se pudo crear la OT", 1, "", ""); 
            }
            
        }
    
    ///////////////Se crea el DIV que servirá de contenedor secundario
    /////
    /////
    $css->CrearDiv("Secundario", "container", "center",1,1);
   										
   	
    //////////////////////////Se dibujan los campos de la cotizacion
    /////
    /////
    if(!empty($idOT)){
        //print("<script>alert('entra')</script>");
        $DatosOT=$obVenta->DevuelveValores("ordenesdetrabajo","ID",$idOT);
        $idCliente=$DatosOT["idCliente"];
        $DatosCliente=$obVenta->DevuelveValores("clientes","idClientes",$idCliente);
        //Creamos el formulario para agregar items al formulario
        
        
        $css->CrearTabla();
            $css->FilaTabla(16);
            print("<td>");
            $css->CreaBotonDesplegable("AgregarItemOT","Agregar un Item a Esta OT");
            print("</td>");
            $css->CierraFilaTabla();
        $css->CerrarTabla();
        
        
        /////////////////Cuadro de dialogo de Clientes create
	$css->CrearCuadroDeDialogo("AgregarItemOT","Agregar un Item a Esta OT"); 
            $css->CrearForm2("FrmAgregaItemsOT", $myPage, "post", "_self");
            $css->CrearInputText("TxtIdOT", "hidden", "Actividad:", $idOT, "", "", "", "", "", "", "", "");
            $css->CrearTextArea("TxtActividad", "", "", "Describa la actividad a realizar", "", "", "", 200, 100, 0, 1);
            print("<br>");
            $css->CrearInputText("TxtFechaIni","text","Fecha de Inicio:",date("Y-m-d"),"Fecha Inicio","black","","",200,30,0,1);
            print("<br>");
            $css->CrearInputText("TxtFechaFin","text","Fecha Final:",date("Y-m-d"),"Fecha Fin","black","","",200,30,0,1);
            print("<br>");
            $css->CrearInputNumber("TxtHoras", "number", "Tiempo Estimado para esta Actividad:", 1, "Tiempo Estimado", "black", "", "", 200, 30, 0, 1, 0, 100000000, "any");
            
            print("<br>");
            $css->CrearTextArea("TxtObservaciones", "", "", "Observaciones a tener en cuenta", "", "", "", 200, 100, 0, 0);
            print("<br>");
            $VarSelect["Ancho"]=200;
            $VarSelect["PlaceHolder"]="Seleccione un Colaborador";
            $css->CrearSelectChosen("CmbColaborador", $VarSelect);
            $Consulta=$obVenta->ConsultarTabla("colaboradores", "");
            while($DatosColaboradores=$obVenta->FetchArray($Consulta)){
                $css->CrearOptionSelect($DatosColaboradores[0], $DatosColaboradores["Nombre"], 0);
            }
            $css->CerrarSelect();
            $css->CrearBotonVerde("BtnAgregarItemOT", "Agregar Item");
            $css->CerrarForm();
        $css->CerrarCuadroDeDialogo(); 
            
        $css->CrearTabla();
        $css->FilaTabla(16);
        $css->ColTabla('OT:',1);
        $css->ColTabla($idOT,1);
        $css->ColTabla('CLIENTE:',1);
        $css->ColTabla($DatosCliente["RazonSocial"],1);

        $css->CierraFilaTabla();
        $css->CerrarTabla();
        
        $css->CrearTabla();
        $css->CrearNotificacionAzul("ITEMS EN ESTA OT",18);
        $css->FilaTabla(16);
			
    ///////////////////////////////////////////
    /////////////Visualizamos la COTIZACION
    ///
    ///
    ///
    $sql="SELECT * FROM ordenesdetrabajo_items WHERE idOT='$idOT'";
    $consulta=$obVenta->Query($sql);              

    if($obVenta->NumRows(consulta)){

        
        
        $css->ColTabla("<strong>Actividad</strong>", 1);
        $css->ColTabla("<strong>FechaInicio</strong>", 1);
        $css->ColTabla("<strong>FechaFin</strong>", 1);
        $css->ColTabla("<strong>TiempoEstimadoHoras</strong>", 1);
        $css->ColTabla("<strong>Observaciones</strong>", 1);
        $css->CierraFilaTabla();

        while($DatosItemsCotizacion=$obVenta->FetchArray($consulta)){
            $idItem=$DatosItemsCotizacion["ID"];
            $css->FilaTabla(16);
            $css->ColTabla($DatosItemsCotizacion["Actividad"], 1);
            $css->ColTabla($DatosItemsCotizacion["FechaInicio"], 1);
            $css->ColTabla($DatosItemsCotizacion["FechaFin"], 1);
            $css->ColTabla($DatosItemsCotizacion["TiempoEstimadoHoras"], 1);
            $css->ColTabla($DatosItemsCotizacion["Observaciones"], 1);
                        
            $css->ColTablaDel($myPage,"ordenesdetrabajo_items","ID",$DatosItemsCotizacion['ID'],$idOT);
            $css->CierraFilaTabla();
        }

        $css->CerrarTabla();
        $Ruta="../tcpdf/examples/imprimirOT.php?idOT=$idOT";
        $css->CrearImageLink($Ruta, "../images/pdf.png", "_blank",100,250);
       
    }else{
        $css->CrearNotificacionNaranja("No se encontraron Items",16);
    }


    }else{
            $css->CrearTabla();
            $css->CrearFilaNotificacion("Por favor busque y asocie una cotizacion",16);
            $css->CerrarTabla();
    }
    $css->CerrarDiv();//Cerramos contenedor Secundario
    $css->CerrarDiv();//Cerramos contenedor Principal
    $css->Footer();
    $css->AgregaJS(); //Agregamos javascripts
    $css->AgregaSubir();
    $css->AnchoElemento("CmbColaborador_chosen", 200);
    print("</body></html>");
?>