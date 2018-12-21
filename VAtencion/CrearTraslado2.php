<?php 
$myPage="CrearTraslado2.php";
include_once("../sesiones/php_control.php");
include_once("css_construct.php");

$obTabla = new Tabla($db);
$idComprobante=0;
$ImprimeCC=0;
if(isset($_REQUEST["CmbTrasladoID"])){
    $idComprobante=$_REQUEST["CmbTrasladoID"];
    
}

if(isset($_REQUEST["ImprimeCC"])){
    $ImprimeCC=$_REQUEST["ImprimeCC"];
    $idComprobante=0;
}
	

print("<html>");
print("<head>");
$css =  new CssIni("Traslados de Mercancia");

print("</head>");
print("<body>");
    
    include_once("procesadores/ProcesaCreaTraslado.php");
    
    $css->CabeceraIni("Crear Traslado"); //Inicia la cabecera de la pagina
        $css->CreaBotonDesplegable("CrearTraslado","Nuevo");  
        $css->CrearForm("FrmSeleccionaTraslado", $myPage, "post", "_self");
        $css->CrearSelect("CmbTrasladoID", "EnviaForm('FrmSeleccionaTraslado')");
        
            $css->CrearOptionSelect("","Selecciona un Traslado",0);
            
            $consulta = $obVenta->ConsultarTabla("traslados_mercancia","WHERE Estado='EN DESARROLLO'");
            while($DatosTraslado=$obVenta->FetchArray($consulta)){
                if($idComprobante==$DatosTraslado['ID']){
                    $Sel=1;
                    
                }else{
                    
                    $Sel=0;
                }
                $css->CrearOptionSelect($DatosTraslado['ID'],$DatosTraslado['Descripcion'],$Sel);							
            }
            $css->CerrarSelect();
   
        $css->CerrarForm();
    $css->CabeceraFin(); 
   
    
    ///////////////Creamos el contenedor
    /////
    /////
     
     
    $css->CrearDiv("principal", "container", "center",1,1);
    ////Menu de historial
    
    
       
    ///////////////Se crea el DIV que servirá de contenedor secundario
    /////
    /////
    $css->CrearDiv("Secundario", "", "center",1,1);
     /////////////////Cuadro de dialogo de Clientes create
    $css->CrearCuadroDeDialogo("CrearTraslado","Crear un Traslado"); 
        $css->CrearForm2("FrmCreaPreTraslado", $myPage, "post", "_self");
        $css->CrearTabla();
        $css->FilaTabla(16);
            $css->ColTabla("<strong>Fecha y Hora</strong>", 1);
            
            $css->ColTabla("<strong>Destino</strong>", 1);
            $css->ColTabla("<strong>Descripcion</strong>", 1);
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
        print("<td>");
        $css->CrearInputText("TxtFecha", "date", "", date("Y-m-d"), "Fecha", "black", "", "", 150, 30, 0, 1);
        $css->CrearInputText("TxtHora", "hidden", "", date("H:i:s"), "Hora", "black", "", "", 100, 30, 0, 1);
        print("</td>");        
        print("<td>"); 
        $VarSelect["Ancho"]="200";
            $VarSelect["PlaceHolder"]="Seleccione el destino";
            $VarSelect["Required"]=1;
            $css->CrearSelectChosen("CmbDestino", $VarSelect);
            $css->CrearOptionSelect("", "Seleccione un destino" , 0);
            $sql="SELECT * FROM empresa_pro_sucursales WHERE Visible='SI'";
            $Consulta=$obVenta->Query($sql);
            
               while($DatosSucursales=$obVenta->FetchArray($Consulta)){
                   $Sel=0;
                   
                   $css->CrearOptionSelect($DatosSucursales["ID"], "$DatosSucursales[Nombre] $DatosSucursales[Ciudad] $DatosSucursales[Direccion]" , $Sel);
               }
            $css->CerrarSelect();
        print("<br><br>"); 
        $VectorSelect["Nombre"]="CmbBodega";
        $VectorSelect["Evento"]="";
        $VectorSelect["Funcion"]="";
        $VectorSelect["Required"]=1;
        $css->CrearSelect2($VectorSelect);
        
            $css->CrearOptionSelect("","Obtener Valores de:",0);
            
            $consulta = $obVenta->ConsultarTabla("bodega","");
            while($DatosBodegas=$obVenta->FetchArray($consulta)){
                
                $css->CrearOptionSelect($DatosBodegas['idBodega'],$DatosBodegas['Nombre'],0);							
            }
        $css->CerrarSelect();    
        print("</td>");
        print("<td>");
        $css->CrearTextArea("TxtDescripcion","","","Escriba la descripcion del traslado","black","","",100,100,0,1);
        print("</td>");
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
        print("<td colspan=3 style=text-align:center>");
        $css->CrearBotonConfirmado("BtnCrearTraslado", "Crear");
        print("</td>");   
        $css->CierraFilaTabla();
        $css->CerrarForm();
    $css->CerrarTabla();
    $css->CerrarCuadroDeDialogo();
    
    $Visible=0;
    if(!empty($idComprobante)){
        $Visible=1;
    }
    $css->CrearDiv("DivDatosItemTraslado", "", "center", $Visible, 1);
    
    $css->CrearTabla();
        $css->FilaTabla(16);
            $css->ColTabla("<strong>Consecutivo</strong>", 1);
            $css->ColTabla("<strong>Código</strong>", 1);
            $css->ColTabla("<strong>Buscar</strong>", 1);
            $css->ColTabla("<strong>Cantidad</strong>", 1);
            $css->ColTabla("<strong>Agregar</strong>", 1);
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
            print("<td>");
                $css->CrearInputText("TxtIdCC", "text", "", $idComprobante, "idTraslado", "black", "", "", 100, 30, 1, 1);
            print("</td>");  
            print("<td>");
                $css->CrearInputText("TxtCodigo", "text", "", "", "Código", "black", "OnChange", "AgregaItem(1)", 200, 30, 0, 0);
            print("</td>");
            print("<td>");
                $css->CrearSelect("idProducto", "",400);
                    $css->CrearOptionSelect("", "Buscar Producto", 0);
                $css->CerrarSelect();
            print("</td>");
            print("<td>");
                $css->CrearInputNumber("TxtCantidad", "number", "", 1, "Cantidad", "", "", "", 100, 30, 0, 0, 0, "", "any");
            print("</td>");
            print("<td>");
                $css->CrearBotonEvento("BtnAgregar", "Agregar", 1, "OnClick", "AgregaItem(2)", "naranja", "");
            print("</td>");
        $css->CierraFilaTabla();
    $css->CerrarTabla();
    $css->CerrarDiv();    
    $css->CrearDiv("DivMensajes", "container", "center", 1, 1);
    $css->CerrarDiv();
    $css->CrearDiv("DivItemsTraslados", "container", "center", 1, 1);
    $css->CerrarDiv();
    $css->CerrarDiv();//Cerramos contenedor Secundario
    $css->CerrarDiv();//Cerramos contenedor Principal
    $css->AgregaJS(); //Agregamos javascripts
    $css->AgregaCssJSSelect2(); //Agregamos CSS y JS de Select2
    $css->AgregaSubir();
    print('<script src="jsPages/CrearTraslado2.js"></script>');
    $css->AnchoElemento("CmbDestino_chosen", 200);
    $css->AnchoElemento("CmbCuentaDestino_chosen", 200);
    print("<script>posiciona('TxtCodigo');</script>");
    if($idComprobante<>''){
        print("<script>DibujeItemsTraslado('$idComprobante');</script>");
    }
    print("</body></html>");
    ob_end_flush();
?>