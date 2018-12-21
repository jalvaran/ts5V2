<?php
$myPage="Cotizaciones.php";
include_once("../sesiones/php_control.php");

include_once("css_construct.php");

$idUser=$_SESSION['idUser'];	
	
/////////

include_once ('funciones/function.php');
include_once("procesadores/Cotizaciones.process.php");
	
print("<html><head>");	
$css =  new CssIni("Cotizaciones");
print("</head><body align='center'>");	
         
	 $obVenta=new ProcesoVenta($idUser);
         $obTabla = new Tabla($db);
	 $myPage="Cotizaciones.php";
	 $css->CabeceraIni("TS5 Cotizaciones"); 
	 $css->CreaBotonDesplegable("DialCliente","Tercero");
	 $css->CabeceraFin();
         //Espacio para Crear Botonos y Cuadros de dialogo
         $css->CrearDiv("principal", "container", "center", 1, 1);
         
         $Titulo="Crear Item En servicios";
         $Nombre="ImgShowMenu";
         $RutaImage="../images/pop_servicios.png";
         $javascript="";
         $VectorBim["f"]=0;
         $target="#DialCrearItemServicios";
         $css->CrearBotonImagen($Titulo,$Nombre,$target,$RutaImage,"",80,80,"fixed","left:10px;top:50",$VectorBim);
         
         $VectorCDC["F"]=0;
         
         $obTabla->CrearCuadroClientes("DialCliente","Crear Cliente",$myPage,$VectorCDC);
	 $VectorCDSer["servitorn"]=1;
         $obTabla->CrearCuadroCrearServicios("DialCrearItemServicios","Crear Nuevo Item Servicios",$myPage,"",$VectorCDSer); 
	 
	//$css->CrearImageLink("../VMenu/MnuVentas.php", "../images/cotizacion.png", "_self",200,200);
	if(!empty($_REQUEST["TxtIdCotizacion"])){
            $idCotizacion=$obVenta->normalizar($_REQUEST["TxtIdCotizacion"]);
		$RutaPrintCot="ImprimirPDFCotizacion.php?ImgPrintCoti=".$idCotizacion;			
		$css->CrearTabla();
		$css->CrearFilaNotificacion("Cotizacion almacenada Correctamente <a href='$RutaPrintCot' target='_blank'>Imprimir Cotizacion No. $_REQUEST[TxtIdCotizacion]</a>",16);
		$css->CerrarTabla();
	}
	
	
            
            $css->CrearNotificacionAzul("Precotizacion, Agregue Los items", 16);
            $css->CrearTabla();
            $css->FilaTabla(16);
            print("<td style='text-align:center'>");
            $Page="Consultas/CotizacionesBusquedaItems.php?TipoItem=1&myPage=$myPage&key=";
            $css->CrearInputText("TxtProducto", "text", "", "", "Buscar Producto", "", "onKeyUp", "EnvieObjetoConsulta(`$Page`,`TxtProducto`,`DivBusquedas`,`0`);", 200, 30, 0, 1);
            print("<br>");
            $Page="Consultas/CotizacionesBusquedaItems.php?TipoItem=2&myPage=$myPage&key=";
            $css->CrearInputText("TxtServicio", "text", "", "", "Buscar Servicio", "", "onKeyUp", "EnvieObjetoConsulta(`$Page`,`TxtServicio`,`DivBusquedas`,`0`);", 200, 30, 0, 1);
            print("<br>");
            $Page="Consultas/CotizacionesBusquedaItems.php?TipoItem=3&myPage=$myPage&key=";
            $css->CrearInputText("TxtSistema", "text", "", "", "Buscar Sistema", "", "onKeyUp", "EnvieObjetoConsulta(`$Page`,`TxtSistema`,`DivBusquedas`,`0`);", 200, 30, 0, 1);
            print("<br>");
            $Page="Consultas/CotizacionesBusquedaItems.php?TipoItem=4&myPage=$myPage&key=";
            $css->CrearInputText("TxtAlquiler", "text", "", "", "Buscar Alquiler", "", "onKeyUp", "EnvieObjetoConsulta(`$Page`,`TxtAlquiler`,`DivBusquedas`,`0`);", 200, 30, 0, 1);
            print("<br>");
            print("</td>");
            print("<td style='text-align:center'>");
            $css->CrearForm2("FrmAgregarItemsToCotiza", $myPage, "post", "_self");
            //$css->CrearInputText("TxtIdCliente", "hidden", "", $idClientes, "", "", "", "", "", "", 0, 1);
            $css->CrearInputNumber("TxtIdCotizacionAdd", "number", "", "", "Asociar cotizacion", "", "", "", 200, 30, 0, 1, 1, "", 1);
            $css->CerrarForm();
            $css->CrearForm2("FrmAgregarSalto", $myPage, "post", "_self");
            
            $css->CrearBoton("BtnAgregarSalto", "Agregar Salto de Linea");
            $css->CerrarForm();
            $css->CrearForm2("FrmAgregarDescuento", $myPage, "post", "_self");
                $css->CrearInputNumber("TxtDescuentoPorcentaje", "number", "Descuento %:", 0, "Descuento", "black", "Evento", "Funcion", 50, 30, 0, 0, 0, 100, "any");
                print("<br>");
                $css->CrearBotonConfirmado("BtnDescuentoGeneral", "Aplicar");
            $css->CerrarForm();   
            print("</td>");
            $css->CerrarTabla();
	
        $css->CrearDiv("DivBusquedas", "", "center", 1, 1);
        $css->CerrarDiv();
        $css->CrearDiv("Productos Agregados", "container", "center", 1, 1);
        //////////////////////////Se dibujan los items en la precotizacion

                

                $css->CrearTabla();
                $sql="SELECT * FROM  precotizacion WHERE idUsuario='$idUser' ORDER BY ID DESC";
                $pa=$obVenta->Query($sql);
                
                if($obVenta->NumRows($pa)){	

                        $css->FilaTabla(18);
                        $css->ColTabla('Referencia',1);
                        $css->ColTabla('Descripcion',1);
                        $css->ColTabla('Cantidad _ Multiplicador _ ValorUnitario',2);
                        $css->ColTabla('Subtotal',1);
                        $css->ColTabla('Borrar',1);
                        $css->CierraFilaTabla();

                while($row=$obVenta->FetchArray($pa)){
                        $css->FilaTabla(16);
                        $css->ColTabla($row['Referencia'],1);
                        $css->ColTabla($row['Descripcion'],1);
                        print("<td colspan=2>");
                        $css->CrearForm2("FrmEdit$row[ID]",$myPage,"post","_self");
                        
                        $css->CrearInputText("TxtTabla","hidden","",$row["Tabla"],"","","","",0,0,0,0);
                        $css->CrearInputText("TxtPrecotizacion","hidden","",$row["ID"],"","","","",0,0,0,0);
                        $css->CrearInputNumber("TxtEditar","number","",$row["Cantidad"],"","black","","",100,30,0,1,0, "","any");
                        $css->CrearInputNumber("TxtMultiplicador","number","",$row["Multiplicador"],"","black","","",100,30,0,1,1, "","any");
                        $css->CrearInputNumber("TxtValorUnitario","number","",$row["ValorUnitario"],"","black","","",150,30,0,1,$row["PrecioCosto"], $row["ValorUnitario"]*10,"any");
                        $css->CrearBoton("BtnEditar", "E");
                        $css->CerrarForm();
                        print("</td>");
                        $css->ColTabla(number_format($row['SubTotal']),1);
                        $css->ColTablaDel($myPage,"precotizacion","ID",$row['ID'],"");
                        $css->CierraFilaTabla();


                }
                $Visible=1;
                }else{
                    $css->CrearNotificacionRoja("No hay productos agregados a esta Cotizacion", 16);
                    $Visible=0;
                }

                $css->CerrarTabla();



                $Subtotal=$obVenta->SumeColumna("precotizacion","SubTotal", "idUsuario",$idUser);
                $IVA=$obVenta->SumeColumna("precotizacion","IVA", "idUsuario",$idUser);
                $Descuento=$obVenta->SumeColumna("precotizacion","ValorDescuento", "idUsuario",$idUser);
                $Total=$Subtotal+$IVA;
                $css->CrearDiv("DivTotales", "", "center", $Visible, 1);
                $css->CrearForm2("FrmGuarda",$myPage,"post","_self");
                
                
                $css->CrearTabla();
                $css->FilaTabla(14);
                $css->ColTabla("Esta Cotizacion:",4);
                $css->CierraFilaTabla();
                $css->FilaTabla(14);
                print("<td colspan='2'>");
                     print("<strong>Seleccione un Cliente:<br>");
                    $VarSelect["Ancho"]="200";
                    $VarSelect["PlaceHolder"]="Seleccione un Cliente";
                    $VarSelect["Required"]=1;
                    $css->CrearSelectChosen("TxtIdCliente", $VarSelect);
                    //$css->CrearOptionSelect("", "Seleccione un Cliente" , 0);
                    $sql="SELECT * FROM clientes";
                    $Consulta=$obVenta->Query($sql);

                       while($DatosClientes=$obVenta->FetchArray($Consulta)){
                           $Sel=0;

                           $css->CrearOptionSelect($DatosClientes["idClientes"], "$DatosClientes[Num_Identificacion] $DatosClientes[RazonSocial] $DatosClientes[Ciudad]" , $Sel);
                       }
                    $css->CerrarSelect();
                print("</td>");
                $css->CierraFilaTabla();
                $css->FilaTabla(14);
                $css->ColTabla("SUBTOTAL:",1);
                $css->ColTabla(number_format($Subtotal+$Descuento),3);
                $css->CierraFilaTabla();
                
                $css->FilaTabla(14);
                $css->ColTabla("DESCUENTOS:",1);
                $css->ColTabla(number_format($Descuento),3);
                $css->CierraFilaTabla();
                
                $css->FilaTabla(18);
                $css->ColTabla("SUBTOTAL DESPUES DE DESCUENTOS:",1);
                $css->ColTabla(number_format($Subtotal),3);
                $css->CierraFilaTabla();
                
                $css->FilaTabla(18);
                $css->ColTabla("IMPUESTOS:",1);
                $css->ColTabla(number_format($IVA),3);
                $css->CierraFilaTabla();
                
                
                
                $css->FilaTabla(18);
                $css->ColTabla("TOTAL:",1);
                $css->ColTabla(number_format($Total),3);
                $css->FilaTabla(18);
                print("<td colspan=4>");
                $css->CrearInputText("TxtNumOrden","text","","","Numero de Orden","black","","",150,30,0,0);

                $css->CrearInputText("TxtNumSolicitud","text","","","Numero de Solicitud","black","","",150,30,0,0);
                print("<br>");
                $css->CrearTextArea("TxtObservaciones","","","Observaciones para esta Cotizacion","black","","",300,100,0,0);
                
                print("<br>");
               
                $css->CrearBotonConfirmado("BtnGuardar","Guardar");
                print("</td>");
                $css->CierraFilaTabla();

                $css->CerrarTabla(); 
                $css->CerrarForm();
                $css->CerrarDiv();
                
        
$css->CerrarTabla();
$css->CerrarDiv();//Cerramos contenedor Secundario
$css->CerrarDiv();//Cerramos contenedor Principal
$css->AgregaJS();

$css->AgregaSubir();
$css->AnchoElemento("CmbCodMunicipio_chosen", 200);
$css->AnchoElemento("CmbDepartamento_chosen", 200);
$css->AnchoElemento("CmbIVA_chosen", 200);
$css->AnchoElemento("TxtCuentaPUC_chosen", 200);
$css->Footer();
if(isset($_REQUEST["TxtBusqueda"])){
    print("<script>MostrarDialogo();</script>");
}

print("</body></html>");

ob_end_flush();
?>