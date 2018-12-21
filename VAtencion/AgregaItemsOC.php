<?php 
$myPage="AgregaItemsOC.php";
include_once("../sesiones/php_control.php");
include_once("css_construct.php");

//////Si recibo un cliente
	if(!empty($_REQUEST['idOT'])){
		
		$idOT=$_REQUEST['idOT'];
	}

	
print("<html>");
print("<head>");
$css =  new CssIni("Agregar Items a una Orden de Compra");

print("</head>");
print("<body>");
    
    include_once("procesadores/procesaOC.php");
    
    $css->CabeceraIni("Agregar Items a una Orden de Compra"); //Inicia la cabecera de la pagina
       
    $css->CabeceraFin(); 
    ///////////////Creamos el contenedor
    /////
    /////
    $css->CrearDiv("principal", "container", "center",1,1);
    print("<br>");
    ///////////////Creamos la imagen representativa de la pagina
    /////
    /////	
    $css->CrearImageLink("ordenesdecompra.php", "../images/ordendecompra.png", "_self",200,200);
    
    ///////////////Si se crea una devolucion o una factura
    /////
    /////
    
        if(!empty($_REQUEST["TxtidOT"])){
            
            $idOT=$_REQUEST["TxtidOT"];
            if($idOT<>""){
                $RutaPrint="../tcpdf/examples/ImprimirOT.php?idOT=".$idOT;
                
                $css->CrearTabla();
                $css->CrearFilaNotificacion("Orden de Compra Creada Correctamente <a href='$RutaPrint' target='_blank'>Imprimir OT No. $idOT</a>",16);
                $css->CerrarTabla();
            }else{
                
               $css->AlertaJS("No se pudo crear la OC", 1, "", ""); 
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
        $DatosOT=$obVenta->DevuelveValores("ordenesdecompra","ID",$idOT);
        $idCliente=$DatosOT["Tercero"];
        $DatosCliente=$obVenta->DevuelveValores("proveedores","idProveedores",$idCliente);
        //Creamos el formulario para agregar items al formulario
        
        
        $css->CrearTabla();
            $css->FilaTabla(16);
            print("<td>");
            $css->CreaBotonDesplegable("AgregarItemOC","Agregar un Item a Esta OC");
            print("</td>");
            $css->CierraFilaTabla();
        $css->CerrarTabla();
        
        
        /////////////////Cuadro de dialogo de Clientes create
	$css->CrearCuadroDeDialogo("AgregarItemOC","Agregar un Item a Esta OC"); 
            $css->CrearForm2("FrmAgregaItemsOC", $myPage, "post", "_self");
            $css->CrearInputText("TxtIdOT", "hidden", "", $idOT, "", "", "", "", "", "", "", "");
            
            
           
            $VarSelect["Ancho"]=200;
            $VarSelect["PlaceHolder"]="Seleccione un Producto";
            $css->CrearSelectChosen("CmbProducto", $VarSelect);
            $Consulta=$obVenta->ConsultarTabla("productosventa", "");
            $css->CrearOptionSelect("NO", "SELECCIONE EL PRODUCTO A AGREGAR", 0);
            while($DatosProducto=$obVenta->FetchArray($Consulta)){
                $css->CrearOptionSelect($DatosProducto[0], $DatosProducto["Nombre"]." ".$DatosProducto["Referencia"], 0);
            }
            $css->CerrarSelect();
            
            
            print("<br><br>");
            $css->CrearInputNumber("TxtCantidad", "number", "Cantidad:", 1, "Valor Unitario", "black", "", "", 200, 30, 0, 1, 0, 100000000, "any");
            print("<br><br>");
            $css->CrearInputNumber("TxtValorUnitario", "number", "Valor Unitario:", "", "Valor Unitario", "black", "", "", 200, 30, 0, 1, 0, 100000000, "any");
            print("<br><br>");
            $VarSelect["Ancho"]=200;
            $VarSelect["PlaceHolder"]="Seleccione el IVA";
            $css->CrearSelectChosen("CmbIVA", $VarSelect);
            $Consulta=$obVenta->ConsultarTabla("porcentajes_iva", "");
            $css->CrearOptionSelect("NO", "SELECCIONE EL IVA DE ESTE PRODUCTO", 0);
            while($DatosIVA=$obVenta->FetchArray($Consulta)){
                $css->CrearOptionSelect($DatosIVA[0], $DatosIVA["Nombre"], 0);
            }
            $css->CerrarSelect();
            print("<br><br>");
            $css->CrearBotonVerde("BtnAgregarItemOT", "Agregar Item");
            $css->CerrarForm();
        $css->CerrarCuadroDeDialogo(); 
            
        $css->CrearTabla();
        $css->FilaTabla(16);
        $css->ColTabla('OC:',1);
        $css->ColTabla($idOT,1);
        $css->ColTabla('TERCERO:',1);
        $css->ColTabla($DatosCliente["RazonSocial"],1);

        $css->CierraFilaTabla();
        $css->CerrarTabla();
        
        $css->CrearTabla();
        $css->CrearNotificacionAzul("ITEMS EN ESTA OC",18);
        $css->FilaTabla(16);
			
    ///////////////////////////////////////////
    /////////////Visualizamos la COTIZACION
    ///
    ///
    ///
    $sql="SELECT * FROM ordenesdecompra_items WHERE NumOrden='$idOT'";
    $consulta=$obVenta->Query($sql);              

    if($obVenta->NumRows($consulta)){

        
        
        $css->ColTabla("<strong>Descripcion</strong>", 1);
        $css->ColTabla("<strong>Referencia</strong>", 1);
        $css->ColTabla("<strong>ValorUnitario</strong>", 1);
        $css->ColTabla("<strong>Cantidad</strong>", 1);
        $css->ColTabla("<strong>Subtotal</strong>", 1);
        $css->ColTabla("<strong>IVA</strong>", 1);
        $css->ColTabla("<strong>Total</strong>", 1);
        $css->CierraFilaTabla();

        while($DatosItemsOC=$obVenta->FetchArray($consulta)){
            $idItem=$DatosItemsOC["ID"];
            $css->FilaTabla(16);
            $css->ColTabla($DatosItemsOC["Descripcion"], 1);
            $css->ColTabla($DatosItemsOC["Referencia"], 1);
            
            $css->ColTabla($DatosItemsOC["ValorUnitario"], 1);
            $css->ColTabla($DatosItemsOC["Cantidad"], 1);
            $css->ColTabla($DatosItemsOC["Subtotal"], 1);
            $css->ColTabla($DatosItemsOC["IVA"], 1);
            $css->ColTabla($DatosItemsOC["Total"], 1);          
            $css->ColTablaDel($myPage,"ordenesdecompra_items","ID",$DatosItemsOC['ID'],$idOT);
            $css->CierraFilaTabla();
        }

        $css->CerrarTabla();
        $Ruta="../tcpdf/examples/imprimirOC.php?idOT=$idOT";
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
    $css->AnchoElemento("CmbProducto_chosen", 400);
    $css->AnchoElemento("CmbIVA_chosen", 200);
    print("</body></html>");
?>