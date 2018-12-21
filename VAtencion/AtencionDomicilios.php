<?php 
$myPage="AtencionDomicilios.php";
include_once("../sesiones/php_control.php");
////////// Paginacion
$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
$limit = 10;
$startpoint = ($page * $limit) - $limit;
include_once ('funciones/function.php');  //En esta funcion está la paginacion		
/////////

$obVenta = new ProcesoVenta($idUser);
$obTabla = new Tabla($db);

$idDomicilio=0;
$idDepartamento=0;
$statement=" productosventa ";
if(isset($_REQUEST["idDomicilio"])){
    $idDomicilio=$obVenta->normalizar($_REQUEST["idDomicilio"]);
}

if(isset($_REQUEST["idDepartamento"])){
    $idDepartamento=$obVenta->normalizar($_REQUEST["idDepartamento"]);
}

if($idDepartamento>0){
    $statement.=" WHERE Departamento='$idDepartamento'";
}
$url="?idDomicilio=$idDomicilio&idDepartamento=$idDepartamento&";
if(isset($_REQUEST["TxtBusqueda"])){
    $key=$obVenta->normalizar($_REQUEST["TxtBusqueda"]);
    $statement=" productosventa WHERE Nombre LIKE '%$key%' or idProductosVenta='$key' or Referencia LIKE '%$key%' ";
    $url.="&TxtBusqueda=$key&";
}

include_once("css_construct.php");

print("<html>");
print("<head>");
$css =  new CssIni("Domicilios");
print("</head>");
print("<body>");
    
    $css->CabeceraIni("Domicilios"); //Inicia la cabecera de la pagina
    $css->CreaBotonDesplegable("DialCliente","Tercero");
    $css->CreaBotonDesplegable("DialDomicilio","Nuevo Domicilio");
    $css->CabeceraFin(); 
    ///////////////Creamos el Dialogo de toma de domicilios
    /////
    /////
    $css->CrearCuadroDeDialogo("DialDomicilio", "Crear un Domicilo");
        $css->CrearForm2("FrmCreaDomicilio", $myPage, "post", "_self");
        $VarSelect["Ancho"]="200";
        $VarSelect["PlaceHolder"]="Busque un Cliente";
        $VarSelect["Title"]="";
        $css->CrearSelectChosen("TxtClienteDomicilio", $VarSelect);
    
        $sql="SELECT * FROM clientes";
        $Consulta=$obVenta->Query($sql);
        while($DatosCliente=$obVenta->FetchArray($Consulta)){
               
               $css->CrearOptionSelect("$DatosCliente[idClientes]", "$DatosCliente[Telefono] / $DatosCliente[RazonSocial] / $DatosCliente[Direccion] / $DatosCliente[Num_Identificacion]" , 0);
           }
           
    $css->CerrarSelect();
    print("<br><br>");
    $css->CrearInputText("TxtDireccionEnvio", "text", "", "", "Direccion de envio", "", "", "", 500, 30, 0, 0);
    print("<br>");
    $css->CrearInputText("TxtTelefonoContacto", "text", "", "", "Telefono de Contacto", "", "", "", 500, 30, 0, 0);
    print("<br>");
    $css->CrearTextArea("TxtObservaciones", "", "", "Observaciones", "", "", "", 500, 60, 0, 0);
    print("<br>");
    $css->CrearBoton("BtnCrearDomicilio", "Crear");
        $css->CerrarForm();
    $css->CerrarCuadroDeDialogo();
    ///////////////Creamos el contenedor
    /////
    /////
    $css->CrearDiv("principal", "container", "center",1,1);  
    $css->CrearDiv("DivMensajes", "", "center",1,1);
    $css->CerrarDiv();
    $idPreventa=1;
    include_once 'CuadroDialogoCrearCliente.php';
    include_once("procesadores/procesaAtencionDomicilios.php");
    //////Creo una factura a partir de un domicilio
    if(isset($_REQUEST['BtnFacturarDomicilio'])){
        $idPedido=$obVenta->normalizar($_REQUEST['BtnFacturarDomicilio']);
        $VectorDomicilio["Domicilio"]=1;
        $obTabla->DibujeAreaFacturacionRestaurante($idPedido,$myPage,$VectorDomicilio);
         
    }
    //Si se recibe una factura
    if(isset($_REQUEST["TxtidFactura"])){
            
        $idFactura=$_REQUEST["TxtidFactura"];
        if($idFactura<>""){
            $RutaPrint="PDF_Factura.php?ImgPrintFactura=".$idFactura;
            $DatosFactura=$obVenta->DevuelveValores("facturas", "idFacturas", $idFactura);
            
            $css->CrearNotificacionVerde("Factura Creada Correctamente <a href='$RutaPrint' target='_blank'>Imprimir Factura No. $DatosFactura[NumeroFactura]</a>",16);
            
        }else{

           $css->AlertaJS("No se pudo crear la factura porque no hay resoluciones disponibles", 1, "", ""); 
        }
            
    }
    
    $css->CrearTabla();
    $css->FilaTabla(16);
    $css->ColTabla("<strong>Seleccione un Domicilio para agregar items</strong>", 1);
    $css->CierraFilaTabla();
    $css->FilaTabla(16);
    print("<td style='text-align:center;'>");
    $css->CrearForm2("FrmSelDomicilio", $myPage, "post", "_self");
    $css->CrearSelect("idDomicilio", "EnviaForm('FrmSelDomicilio')");
    $css->CrearOptionSelect("", "Seleccione un Domicilio", 0);
    $consulta=$obVenta->ConsultarTabla("restaurante_pedidos", " WHERE Estado='DO'");
    
    while($DatosDomicilio=$obVenta->FetchArray($consulta)){
        $sel=0;
        if($idDomicilio==$DatosDomicilio["ID"]){
            $sel=1;
        }
        $css->CrearOptionSelect($DatosDomicilio["ID"],$DatosDomicilio["ID"]." ".$DatosDomicilio["NombreCliente"], $sel);
    }
    $css->CerrarSelect();
    $css->CerrarForm();
    print("</td>");
    $css->CierraFilaTabla();
    $css->CerrarTabla();
    if($idDomicilio>0){
    $css->CrearTabla();
    $css->FilaTabla(16);
    print("<td style='text-align:center;'>");
        $DatosDomicilio=$obVenta->DevuelveValores("restaurante_pedidos", "ID", $idDomicilio);
        $css->CrearForm2("FrmEditarDatos", $myPage, "post", "_self");
        $css->CrearInputText("idDomicilio", "hidden", "", $idDomicilio, "", "", "", "", "", "", 1, 1);
        print("<strong>Fecha:</strong><br>");
        $css->CrearInputFecha("", "TxtFechaEdit", $DatosDomicilio["Fecha"], 100, 30, "");
        print("</td>");
        print("<td style='text-align:center;'>");
        $VarSelect["Required"]="1";
        $VarSelect["Ancho"]="200";
        $VarSelect["PlaceHolder"]="Seleccione un Cliente";
        $css->CrearSelectChosen("CmbTerceroEdit", $VarSelect);
        $consulta=$obVenta->ConsultarTabla("clientes", "");
        while($DatosClientes=$obVenta->FetchArray($consulta)){
            $sel=0;
            if($DatosClientes["idClientes"]==$DatosDomicilio["idCliente"]){
                $sel=1;
            }
            $css->CrearOptionSelect($DatosClientes["idClientes"], $DatosClientes["Telefono"]." ".$DatosClientes["RazonSocial"]." ".$DatosClientes["Num_Identificacion"] , $sel);
        }
        $css->CerrarSelect();
        print("<td style='text-align:center;'>");
        print("<strong>Direccion de Envio:</strong><br>");
        $css->CrearInputText("TxtDireccionEnvioEdit", "text", "", $DatosDomicilio["DireccionEnvio"], "DireccionEnvio", "", "", "", 200, 30, 0, 0);
        print("</td>");
        print("<td style='text-align:center;'>");
        print("<strong>Telefono Confirmacion:</strong><br>");
        $css->CrearInputText("TxtTelefonoConfirmacionEdit", "text", "", $DatosDomicilio["TelefonoConfirmacion"], "TelefonoConfirmacion", "", "", "", 200, 30, 0, 0);
        print("</td>");
        print("<td style='text-align:center;'>");
        print("<strong>Observaciones:</strong><br>");
        $css->CrearTextArea("TxtObservacionesEdit", "", $DatosDomicilio["Observaciones"], "Observaciones", "", "", "", 200, 60, 0, 0);
        print("</td>");
        print("<td style='text-align:center;'>");
        $css->CrearBotonVerde("BtnEditarDomicilioGeneral", "Editar");
        print("</td>");
        
    
    $css->CierraFilaTabla();
    $css->CerrarTabla();
    $css->CerrarForm();
    }
    
    
    
    $css->CrearDiv("secundario", "", "center",1,1);
    
    if($idDomicilio>0){
        $css->CrearDivBusquedas("DivBusqueda", "", "center", 1, 1);
        $obTabla->CrearSubtotalCuentaDomicilio($idDomicilio,$idDepartamento,$idUser,$myPage,"");
        $css->CrearNotificacionRoja("Lista de Productos para agregar al domicilio $idDomicilio", 16);
        ////Paginacion
        ////
        $Ruta="";
        //$css->CrearDiv("DivPage", "", "left", 1, 1);
        //print("<div style='height: 50px;'>");   //Dentro de un DIV para no hacerlo tan grande
        print(pagination($Ruta,$statement,$limit,$page,$url));
        //print("</div>");
        $css->CrearTabla();
        
        $css->FilaTabla(16);
        print("<td  style='text-align:center;' colspan='4'>");
        $css->CrearForm2("FrmSelDepartamento", $myPage, "post", "_self");
        $css->CrearInputText("idDomicilio", "hidden", "", $idDomicilio, "", "", "", "", "", "", "", "");
        $css->CrearSelect("idDepartamento", "EnviaForm('FrmSelDepartamento')");
        $css->CrearOptionSelect("", "Seleccione un deparmento", 0);
        $consulta=$obVenta->ConsultarTabla("prod_departamentos", "");

        while($DatosDepartamento=$obVenta->FetchArray($consulta)){
            $sel=0;
            if($idDepartamento==$DatosDepartamento["idDepartamentos"]){
                $sel=1;
            }
            $css->CrearOptionSelect($DatosDepartamento["idDepartamentos"], $DatosDepartamento["Nombre"], $sel);
        }
        $css->CerrarSelect();
        $css->CerrarForm();
        print("</td>");
        
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
        $css->ColTabla("<strong>Producto</strong>", 1);
        
        $css->ColTabla("<strong>Imagen</strong>", 1);
        $css->ColTabla("<strong>Agregar</strong>", 1);
        $css->CierraFilaTabla();
        $sql=" SELECT Nombre, idProductosVenta,Referencia,RutaImagen,PrecioVenta FROM $statement ORDER BY Nombre LIMIT $startpoint,$limit";
        $consulta=$obVenta->Query($sql);
        while($DatosProducto=$obVenta->FetchArray($consulta)){
            $css->FilaTabla(16);
            $css->ColTabla("$DatosProducto[Referencia]<br>$DatosProducto[Nombre]<br><h2><strong>$".number_format($DatosProducto["PrecioVenta"])."</h2></strong>", 1);
            print("<td>");
            
            $RutaImage="../$DatosProducto[RutaImagen]";
            $ImagenAlterna="../images/productoalterno.png";
            $css->CrearImage("Img$DatosProducto[idProductosVenta]",$RutaImage,$ImagenAlterna,150,150);
            
            print("</td>");
            
            print("<td>");
            
            $css->CrearForm2("FrmAgregarItem$DatosProducto[idProductosVenta]", $myPage, "post", "_self");
            $css->CrearInputText("idDomicilio", "hidden", "", $idDomicilio, "", "", "", "", "", "", "", "");
            $css->CrearInputText("idDepartamento", "hidden", "", $idDepartamento, "", "", "", "", "", "", "", "");
            $css->CrearInputText("idProducto", "hidden", "", $DatosProducto["idProductosVenta"], "", "", "", "", "", "", "", "");
            $css->CrearInputNumber("TxtCantidad", "number", "", 1, "Cantidad", "black", "", "", 100, 30, 0, 1, 1, "", 1);
            print("<br>");
            $css->CrearTextArea("TxtObservaciones", "", "", "Observaciones", "black", "", "", 100, 50, 0, 0);
            print("<br>");
            $css->CrearBoton("BtnAgregar", "Agregar");
            $css->CerrarForm();
            
            print("</td>");
            $css->CierraFilaTabla();
        }
        $css->CerrarTabla();
        $css->CerrarDiv();
    }  
    
    $css->CerrarDiv();//Cerramos contenedor secundario
    $css->DivPage("Domicilios", "Consultas/DatosDomicilios.php?Valida=1", "", "DivDomicilios", "onClick", 1, 1, "");
    $css->CrearDiv("DivDomicilios", "", "center", 1, 1);
    $css->CerrarDiv();//Cerramos contenedor Domicilio
    $css->CerrarDiv();//Cerramos contenedor Principal
    $css->AgregaJS(); //Agregamos javascripts
    $css->AnchoElemento("TxtClienteDomicilio_chosen", 500);
    $css->AnchoElemento("CmbCodMunicipio_chosen", 200);
    $css->AnchoElemento("CmbClientes_chosen", 200);
    $css->AnchoElemento("TxtidColaborador_chosen", 200);
    $css->AnchoElemento("TxtCliente_chosen", 200);
    $css->AnchoElemento("TxtCuentaDestino_chosen", 200);
    $css->AnchoElemento("TxtTipoPago_chosen", 200);
    $css->AnchoElemento("CmbCuentaDestino_chosen", 300);
    $css->AnchoElemento("CmbProveedores_chosen", 300);
    print("<script>setInterval('BusquedaDomicilios()',4000);ClickElement('Domicilios');</script>");
    if(isset($_REQUEST['BtnFacturarPedido'])or isset($_REQUEST['BtnFacturarDomicilio'])){
        print("<script>document.getElementById('TxtPaga').select();</script> ");
    }
    $css->AgregaSubir();
    $css->Footer();
    print("</body></html>");
?>