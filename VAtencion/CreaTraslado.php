<?php 
$myPage="CreaTraslado.php";
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
    $myPage="CreaTraslado.php";
    $css->CabeceraIni("Crear Traslado"); //Inicia la cabecera de la pagina
    $css->CreaBotonDesplegable("CrearTraslado","Nuevo");  
    $css->CabeceraFin(); 
    
         
    if(isset($_REQUEST["TxtBusqueda"])){
        $key=$_REQUEST["TxtBusqueda"];
        $PageReturn="";
        $VectorDI["idPre"]=$idComprobante;
        $obTabla->DibujeItemsBuscadosVentas2($key,$PageReturn,$VectorDI);

    }
    
    ///////////////Creamos el contenedor
    /////
    /////
     print("<br><br><br>");
     
    $css->CrearDiv("principal", "container", "center",1,1);
    ////Menu de historial
    
    
         
         
    if($ImprimeCC>0){
        $RutaPrintCot="../tcpdf/examples/imprimirTraslado.php?idTraslado=$ImprimeCC";			
       
        $css->CrearNotificacionNaranja("Comprobante Creado, <a href='$RutaPrintCot' target='_blank'>Imprimir Comprobante No. $ImprimeCC</a>",16);
        
    }
    
    ///////////////Se crea el DIV que servirá de contenedor secundario
    /////
    /////
    $css->CrearDiv("Secundario", "container", "center",1,1);
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
        $css->CrearInputText("TxtFecha", "date", "", date("Y-m-d"), "Fecha", "black", "", "", 100, 30, 0, 1);
        $css->CrearInputText("TxtHora", "text", "", date("H:i:s"), "Hora", "black", "", "", 100, 30, 0, 1);
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
        print("<td>");
        $css->CrearBotonConfirmado("BtnCrearTraslado", "Crear");
        print("</td>");   
        $css->CierraFilaTabla();
    $css->CerrarTabla();
    $css->CerrarCuadroDeDialogo();
    
    $css->CrearNotificacionAzul("Agregar Items al Traslado", 18);
    $css->CerrarForm();
    $css->CrearForm2("FrmSeleccionaTraslado", $myPage, "post", "_self");
    
    $css->CrearTabla();
    $css->FilaTabla(16);
    print("<td style='text-align:center'>");
    
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
    print("</td>");
    $css->CierraFilaTabla();
    $css->CerrarTabla();
    $css->CerrarForm();
    
    $css->CrearForm2("FrmAgregaItemE", $myPage, "post", "_self");
    $Visible=0;
    if(!empty($idComprobante)){
        $Visible=1;
    }
    $css->CrearDiv("DivDatosItemTraslado", "", "center", $Visible, 1);
    $css->CrearTabla();
    $css->FilaTabla(16);
    $css->ColTabla("<strong>Comprobante:</strong>", 2);
    print("<td>");
       $css->CrearInputText("TxtIdCC", "text", "", $idComprobante, "idEgreso", "black", "", "", 100, 30, 1, 1);
    print("</td>");  
    $css->CierraFilaTabla();   
    $css->FilaTabla(16);
        
        $css->ColTabla("<strong>Busque el Producto</strong>", 3);
        
        
        
    $css->CierraFilaTabla();  
    $css->CerrarForm();
    $css->FilaTabla(16);
        
        
        print("<td colspan='3'>");
	/*			
            $VarSelect["Ancho"]="200";
            $VarSelect["PlaceHolder"]="Seleccione un producto";
            $VarSelect["Required"]=1;
            $css->CrearSelectChosen("CmbProducto", $VarSelect);
            $css->CrearOptionSelect("", "Seleccione un Producto" , 0);
            $sql="SELECT * FROM productosventa";
            $Consulta=$obVenta->Query($sql);
            
               while($DatosProducto=$obVenta->FetchArray($Consulta)){
                   $Sel=0;
                   
                   $css->CrearOptionSelect($DatosProducto["idProductosVenta"], "$DatosProducto[idProductosVenta] $DatosProducto[Referencia] $DatosProducto[Nombre]" , $Sel);
               }
            $css->CerrarSelect();
            */
        
        $VectorCuaBus["F"]=0;
        $obTabla->CrearCuadroBusqueda($myPage,"","","CmbTrasladoID",$idComprobante,$VectorCuaBus);
        print("</td>");
        
        $css->CierraFilaTabla();
    $css->CierraFilaTabla();
    
    
    
    $css->CerrarTabla();
    
    
    $css->CrearForm2("FrmCerrarCompC", $myPage, "post", "_self");
    $css->CrearInputText("TxtIdComprobante","hidden",'',$idComprobante,'',"","","",300,30,0,0);
    $css->CrearBotonConfirmado2("BtnGuardar", "Guardar",1,"");
    
    print("<br>");
    $css->CerrarForm();
    
    $css->CrearDiv("DivItems", "", "center", 1, 1);
    $Vector["Tabla"]="traslados_items";
    $Columnas=$obTabla->ColumnasInfo($Vector);
    $css->CrearTabla();
    $css->FilaTabla(12);
    
    $i=0;
    $ColNames[]="";
    $css->ColTabla("<strong>Borrar</strong>", 1);
    foreach($Columnas["Field"] as $NombresCol ){
        $css->ColTabla("<strong>$NombresCol</strong>", 1);
        $ColNames[$i]=$NombresCol;
        $i++;
    }
    
    $NumCols=$i-1;
    $css->CierraFilaTabla();
    
    $i=0;
    $sql="SELECT * FROM traslados_items WHERE idTraslado='$idComprobante'";
    $consulta=$obVenta->Query($sql);
    
    while($DatosItems=$obVenta->FetchArray($consulta)){
        
        $css->FilaTabla(12);
        $css->ColTablaDel($myPage,"traslados_items","ID",$DatosItems['ID'],$idComprobante);
        for($z=0;$z<=$NumCols;$z++){
            $NombreCol=$ColNames[$z];
            print("<td>");
            if($NombreCol=="Soporte"){
                $link=$DatosItems[$NombreCol];
                if($link<>""){
                    $css->CrearLink($link, "_blank", "Ver");
                }
            }else{
                print($DatosItems[$NombreCol]);
            }
            
            print("</td>");
            
        }
        
        $i=0;
        $css->CierraFilaTabla();
        
    }
    
    
    $css->CerrarTabla();
    $css->CerrarDiv();//Cerramos Div con los items agregados
    $css->CerrarDiv();//Cerramos Div con los datos de los preitems
    $css->CerrarDiv();//Cerramos contenedor Secundario
    $css->CerrarDiv();//Cerramos contenedor Principal
    $css->AgregaJS(); //Agregamos javascripts
    $css->AgregaSubir();
    $css->AnchoElemento("CmbDestino_chosen", 200);
    $css->AnchoElemento("CmbCuentaDestino_chosen", 200);
    if(isset($_REQUEST["TxtBusqueda"])){
        print("<script>MostrarDialogo();</script>");
    }
    print("</body></html>");
    ob_end_flush();
?>