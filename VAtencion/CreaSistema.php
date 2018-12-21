<?php 
$myPage="CreaSistema.php";
include_once("../sesiones/php_control.php");
include_once("clases/ClasesSistemas.php");
include_once("css_construct.php");

$obTabla = new Tabla($db);
$obVenta = new ProcesoVenta($idUser);
$obSistema=new Sistema($idUser);
$idSistema=0;
if(isset($_REQUEST["idSistema"])){
    $idSistema=$_REQUEST["idSistema"];
    
}	

print("<html>");
print("<head>");
$css =  new CssIni("Creacion de Sistemas");

print("</head>");
print("<body>");
    
    include_once("procesadores/CreaSistema.process.php");
    $css->CabeceraIni("Crear Sistema"); //Inicia la cabecera de la pagina
    $css->CrearImageLink("vista_sistemas.php", "../images/volver2.png", "_self", 30, 30);
   
    $css->CreaBotonDesplegable("CrearSistema","Nuevo");  
    $css->CabeceraFin(); 
   
    ///////////////Creamos el contenedor
    /////
    /////
    //$css->CrearCuadroDeDialogo("CrearSistema", "Crear Sistema");
    $css->CrearCuadroDeDialogoAmplio("CrearSistema", "Crear un Sistema");
     
        $css->CrearForm2("FrmCrearSistema", $myPage, "post", "_self");
        
        $css->CrearTabla();
        $css->FilaTabla(16);
            $css->ColTabla("<strong>Nombre</strong>", 2);
            //$css->ColTabla("<strong>PrecioVenta</strong>", 1);
            //$css->ColTabla("<strong>PrecioMayorista</strong>", 1);
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
        print("<td colspan=2>");
        $css->CrearTextArea("TxtNombre","","","Escriba el Nombre del Sistema","black","","",320,60,0,1);
        
        print("</td>");        
        
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
            $css->ColTabla("<strong>Observaciones</strong>", 1);
            $css->ColTabla("<strong>Imagen y Codigo de Barras</strong>", 1);
            //$css->ColTabla("<strong>CuentaPUC</strong>", 1);
        $css->CierraFilaTabla(); 
        $css->FilaTabla(16);
        print("<td>");
        $css->CrearTextArea("TxtObservaciones","","","Observaciones","black","","",320,60,0,1);
        print("</td>");
        print("<td>");
        $css->CrearUpload("foto");
        print("<br>");
        $css->CrearInputText("TxtCodigoBarras", "text", "", "", "CodigoBarras", "", "", "", 200, 30, 0, 0);
        print("</td>");
        
        $css->CierraFilaTabla();
        
        print("<td colspan=2>");
            $css->CrearBotonConfirmado("BtnCrearSistema", "Crear Sistema");
        print("</td>");
        $css->CierraFilaTabla();   
    
    $css->CerrarTabla();
    
    $css->CerrarForm();
    $css->CerrarCuadroDeDialogoAmplio();
    //$css->CerrarCuadroDeDialogo();
       
    $css->CrearDiv("principal", "container", "center",1,1);
    ////Menu de historial
    $css->CrearNotificacionAzul("Agregar Items al Sistema", 18);  
    ///////////////Se crea el DIV que servirá de contenedor secundario
    /////
    /////
    $css->CrearDiv("Secundario", "container", "center",1,1);
     /////////////////Cuadro de dialogo de Clientes create
    
    
    
    $css->CrearTabla();
    $css->FilaTabla(16);
    print("<td style='text-align:center'>");
    $css->CrearForm2("FrmSeleccionaSistema", $myPage, "post", "_self");
        $css->CrearSelect("idSistema", "EnviaForm('FrmSeleccionaSistema')");
        
            $css->CrearOptionSelect("","Selecciona un Sistema",0);
            
            $consulta = $obVenta->ConsultarTabla("sistemas","WHERE Estado='ABIERTO'");
            while($DatosSistemas=$obVenta->FetchArray($consulta)){
                if($idSistema==$DatosSistemas['ID']){
                    $Sel=1;
                    
                }else{
                    
                    $Sel=0;
                }
                $css->CrearOptionSelect($DatosSistemas['ID'],$DatosSistemas['Nombre'],$Sel);							
            }
        $css->CerrarSelect();
    $css->CerrarForm();
    print("</td>");
    print("<td>");
    $css->CrearDiv("DivActualiza", "", "center", 1, 1);
    if($idSistema>0){
        
        $DatosSistemas=$obSistema->DevuelveValores("sistemas", "ID", $idSistema);
        $TotalSistema=$obSistema->Sume("vista_sistemas", "PrecioVenta", " WHERE idSistema = '$idSistema'");
        /*
        $sql="SELECT SUM(ValorUnitario*Cantidad) AS PrecioVenta FROM sistemas_relaciones WHERE idSistema='$idSistema'";
        $consulta=$obSistema->Query($sql);
        $consulta=$obSistema->FetchArray($consulta);
        $TotalSistema=$consulta["PrecioVenta"];
         * 
         */
        //$TotalSistema=1;
        print("<strong> Precio para el sistema $DatosSistemas[Nombre]: ".number_format($TotalSistema)." </strong><br>");
        $css->CrearForm2("FrmEditaValorSistema", $myPage, "post", "_self");
        $css->CrearInputText("idSistema", "hidden", "", $idSistema, "", "", "", "", "", "", 1, 1);
        
        print("<br>"); 
        $css->ImageOcultarMostrar("ImgOculta", "Mostrar Mas Opciones: ", "DivMasOpciones", 30, 30, "");
        $css->CrearDiv("DivMasOpciones", "", "center", 0, 1);
        print("<strong>Nombre:</strong><br>");
        $css->CrearTextArea("TxtNombre", "", $DatosSistemas["Nombre"], "Nombre", "", "", "", 450, 60, 0, 1);
        print("<br><strong>Observaciones:</strong><br>");
        $css->CrearTextArea("TxtObservaciones", "", $DatosSistemas["Observaciones"], "Observaciones", "", "", "", 450, 60, 0, 1);
        print("<br>");
        $css->CrearBotonConfirmado("BtnEditarSistema", "Actualizar");
        $css->CerrarDiv();
        print("<br>");
        
        
        $css->CerrarForm();
    }else{
        $css->CrearNotificacionAzul("No se ha seleccionado un sistema", 16);
    }
    $css->CerrarDiv();
    print("</td>");
    $css->CierraFilaTabla();
    $css->CerrarTabla();
    
    
    
    $Visible=0;
    if(!empty($idSistema)){
        $Visible=1;
    }
    $css->CrearDiv("DivDatosItemSistema", "", "center", $Visible, 1);
    $css->CrearTabla();
        
    $css->FilaTabla(16);
        
        $css->ColTabla("<strong>Busque un Item para Agregar</strong>", 1);
        $css->ColTabla("<strong>Busque un Servicio para Agregar</strong>", 1);
        $css->ColTabla("<strong>Guardar</strong>", 1);
    $css->CierraFilaTabla();  
    
    $css->FilaTabla(16);
    print("<td>");
    $Page="Consultas/BuscarItemsSistemas.php?TipoItem=1&myPage=$myPage&idSistema=$idSistema&key=";
    $css->CrearInputText("TxtProducto", "text", "", "", "Buscar Producto", "", "onChange", "EnvieObjetoConsulta(`$Page`,`TxtProducto`,`DivBusquedas`);", 200, 30, 0, 1);
    print("</td>");
    print("<td>");
    $Page="Consultas/BuscarItemsSistemas.php?TipoItem=2&myPage=$myPage&idSistema=$idSistema&key=";
    $css->CrearInputText("TxtServicio", "text", "", "", "Buscar Servicio", "", "onChange", "EnvieObjetoConsulta(`$Page`,`TxtServicio`,`DivBusquedas`);", 200, 30, 0, 1);
    print("</td>");
    print("<td>");
    $css->CrearForm2("FrmCerrarSistema", $myPage, "post", "_self");
        $css->CrearInputText("idSistema","hidden",'',$idSistema,'',"","","",300,30,0,0);
        $css->CrearBotonConfirmado2("BtnGuardar", "Guardar",1,"");
    $css->CerrarForm();
    print("</td>");
    $css->CierraFilaTabla();
    $css->CerrarTabla();
    $css->CrearDiv("DivBusquedas", "", "center", 1, 1);
    $css->CerrarDiv();
    
    $css->CrearDiv("DivSistemas", "", "center", 1, 1);
    $css->CrearTabla();
        $consulta=$obSistema->ConsultarTabla("sistemas_relaciones", " WHERE idSistema='$idSistema' ORDER BY ID Desc");
        if($obSistema->NumRows($consulta)){
            $css->FilaTabla(16);
                $css->ColTabla("<strong>Tabla</strong>", 1);
                $css->ColTabla("<strong>Nombre</strong>", 1);
                $css->ColTabla("<strong>Referencia</strong>", 1);
                $css->ColTabla("<strong>Precio Articulo</strong>", 1);
                
                $css->ColTabla("<strong>Cantidad // Precio En Sistema</strong>", 1);
                
                $css->ColTabla("<strong>Total</strong>", 1);
                $css->ColTabla("<strong>Borrar</strong>", 1);
            $css->CierraFilaTabla();
            while($DatosSistemas=$obSistema->FetchArray($consulta)){
                $DatosItem=$obSistema->DevuelveValores($DatosSistemas["TablaOrigen"], "Referencia", $DatosSistemas["Referencia"]);
                $css->FilaTabla(16);
                    
                    $css->ColTabla($DatosSistemas["TablaOrigen"], 1);
                    $css->ColTabla($DatosItem["Nombre"], 1);
                    $css->ColTabla($DatosItem["Referencia"], 1);
                    $css->ColTabla($DatosItem["PrecioVenta"], 1);
                    print("<td>");
                    $css->CrearForm2("FrmEditarCant".$DatosSistemas["ID"], $myPage, "post", "_self");
                    $css->CrearInputText("idSistema", "hidden", "", $idSistema, "", "", "", "", "", "", 0, 0);
                    $css->CrearInputText("idItem", "hidden", "", $DatosSistemas["ID"], "", "", "", "", "", "", 0, 0);
                    $css->CrearInputNumber("TxtCantidadEdit", "number", "", $DatosSistemas["Cantidad"], "Cantidad", "", "", "", 100, 30, 0, 1, 1, "", "any");
                    $css->CrearInputNumber("TxtValorEdit", "number", "", $DatosSistemas["ValorUnitario"], "Precio", "", "", "", 100, 30, 0, 1, 1, "", "any");
                    
                    $css->CrearBotonNaranja("BtnEditarCantidad", "E");
                    $css->CerrarForm();
                    print("</td>");
                    $css->ColTabla($DatosSistemas["ValorUnitario"]*$DatosSistemas["Cantidad"], 1);
                    print("<td>");
                    $link=$myPage."?del=$DatosSistemas[ID]&idSistema=$idSistema";
                    $css->CrearLink($link, "_self", "X");
                    print("</td>");
                $css->CierraFilaTabla();
            }
        }else{
            $css->CrearNotificacionNaranja("No hay items en este Sistema", 16);
        }
    $css->CerrarTabla();
    $css->CerrarDiv();//Cerramos Div con los items agregados
    
    $css->CerrarDiv();//Cerramos contenedor Secundario
    $css->CerrarDiv();//Cerramos contenedor Principal
    $css->AgregaJS(); //Agregamos javascripts
    $css->AnchoElemento("CuentaPUC_chosen", 200);
    $css->AgregaSubir();
    
    if(isset($_REQUEST["TxtBusqueda"])){
        print("<script>MostrarDialogo();</script>");
    }
    print("</body></html>");
    ob_end_flush();
?>