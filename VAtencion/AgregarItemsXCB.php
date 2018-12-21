<?php
$myPage="AgregaItemsXCB.php";
include_once("../sesiones/php_control.php");
////////// Paginacion
$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);

    	$limit = 10;
    	$startpoint = ($page * $limit) - $limit;
		
/////////
$obVenta = new ProcesoVenta($idUser);
$myTitulo="Agregar Items al Inventario desde CSV";
$MyPage="AgregarItemsXCB.php";
include_once("css_construct.php");



print("<html>");
print("<head>");

$css =  new CssIni($myTitulo);
print("</head>");
print("<body>");
//Cabecera
$css->CabeceraIni($myTitulo); //Inicia la cabecera de la pagina
$css->CabeceraFin(); 

///////////////Creamos el contenedor
    /////
    /////
$css->CrearDiv("principal", "container", "center",1,1);

if(!empty($_REQUEST['BtnCargar'])){
    $destino="";
    if(!empty($_FILES['UplCsv']['type'])){
        
        $TipoArchivo=$_FILES['UplCsv']['type'];
        $NombreArchivo=$_FILES['UplCsv']['name'];
        //if($TipoArchivo=="text/csv"){
            
            
            $handle = fopen($_FILES['UplCsv']['tmp_name'], "r");
            $i=0;
            $css->CrearNotificacionAzul("Productos Agregados desde el archivo $NombreArchivo", 20);
            $css->CrearTabla();
            
            $css->FilaTabla(14);
            $css->ColTabla("<strong>Item</strong>", 1);
            $css->ColTabla("<strong>ID</strong>", 1);
            $css->ColTabla("<strong>CodigoBarras</strong>", 1);
            $css->ColTabla("<strong>Nombre</strong>", 1);
            $css->ColTabla("<strong>Existencias Anterior</strong>", 1);
            $css->ColTabla("<strong>Cantidad Agregada</strong>", 1);
            $css->ColTabla("<strong>Saldo</strong>", 1);
            $css->CierraFilaTabla();
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                
                
                if($i>0){
                
                    $CodigoBarras=str_pad($data[0], 11, "0", STR_PAD_LEFT);
                    $VectorItem["F"]="";
                    $DatosProducto=$obVenta->AgregarItemXCB($CodigoBarras, $data[1], $VectorItem);
                    
                    if($DatosProducto<>"SR"){
                        $css->FilaTabla(14);
                        $css->ColTabla($i, 1);
                        $css->ColTabla($DatosProducto["idProductosVenta"], 1);
                        $css->ColTabla($CodigoBarras, 1);
                        $css->ColTabla($DatosProducto["Nombre"], 1);
                        $css->ColTabla($DatosProducto["Existencias"], 1);
                        $css->ColTabla($data[1], 1);
                        $css->ColTabla($DatosProducto["Existencias"]+$data[1], 1);
                        $css->CierraFilaTabla();
                    }else{
                        if($CodigoBarras>0){
                            $css->CrearFilaNotificacion("No se encontro el producto con el codigo de Barras $CodigoBarras", 16);
                        }
                    }
                   
                }
                 
                $i++; 
                
            }
            $css->CerrarTabla();
            fclose($handle);
            
        //}else{
          //  $css->CrearNotificacionRoja("El archivo seleccionado no es valido", 18);
        //}
        
    }else{
        $css->CrearNotificacionRoja("No se selecciono ningun archivo", 18);
    }
}

if(!empty($_REQUEST['BtnCargarInventario'])){
    $destino="";
    if(!empty($_FILES['UplCsv2']['type'])){
        
        $TipoArchivo=$_FILES['UplCsv2']['type'];
        $NombreArchivo=$_FILES['UplCsv2']['name'];
        //if($TipoArchivo=="text/csv"){
            
            
            $handle = fopen($_FILES['UplCsv2']['tmp_name'], "r");
            $i=0;
            $css->CrearNotificacionAzul("Productos Agregados desde el archivo $NombreArchivo", 20);
            
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                $css->CrearNotificacionAzul($data[0], 15);
                print("<br>".$data[0]);
                $DatosProducto=$obVenta->DevuelveValores("productosventa", "idProductosVenta", $data[0]);
                if($i>0 and $DatosProducto["idProductosVenta"]==""){
                    //print($data[0]);
                    $DatosProducto=$obVenta->DevuelveValores("productosventa", "Referencia", $data[2]);
                    $Referencia=$data[2];
                    if($DatosProducto["idProductosVenta"]>=1){
                        $Referencia="REF$data[0]";
                        
                    }
                    //$ID=str_pad($data[0], 11, "0", STR_PAD_LEFT);
                    //$obVenta->CrearProductoVentaXCSV($ID, $Nombre, $CodigoBarras, $Referencia, $PrecioVenta, $PrecioMayor, $Existencias, $CostoUnitario, $IVA, $idDepartamento, $Sub1, $Sub2, $Sub3, $Sub4, $Sub5, $CuentaPUC, $Vector)
                    $obVenta->CrearProductoVentaXCSV($data[0], $data[3], $data[1], $Referencia, $data[5], $data[6], $data[4], $data[7], $data[9], $data[11], $data[12], $data[13], $data[14], $data[15], $data[16], $data[20], "");
                    
                     $css->CrearFilaNotificacion("producto $data[0] // $data[3] // $data[2] // $data[6] // $data[5] // $data[6] // $data[7] // $data[8] // Creado", 16);
                        
                   
                }
                 
                $i++; 
                
            }
            
            fclose($handle);
            
        //}else{
          //  $css->CrearNotificacionRoja("El archivo seleccionado no es valido", 18);
        //}
        
    }else{
        $css->CrearNotificacionRoja("No se selecciono ningun archivo", 18);
        
    }
}

if(!empty($_REQUEST['BtnAgregarCodigosBarras'])){
    $destino="";
    if(!empty($_FILES['UplCsv3']['type'])){
        
        $TipoArchivo=$_FILES['UplCsv3']['type'];
        $NombreArchivo=$_FILES['UplCsv3']['name'];
        //if($TipoArchivo=="text/csv"){
            
            
            $handle = fopen($_FILES['UplCsv3']['tmp_name'], "r");
            $i=0;
            $css->CrearNotificacionAzul("Codigos de Barras Agregados desde el archivo $NombreArchivo", 20);
            
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                $DatosCodigo=$obVenta->DevuelveValores("prod_codbarras", "CodigoBarras", $data[1]);
                if($i>0 and $DatosCodigo["CodigoBarras"]==''){
                     $obVenta->AgregarCodigoBarrasAItem($data[0], $data[1], "");
                    
                     $css->CrearFilaNotificacion("Codigo $data[0] // $data[1] // Agregado", 16);
                        
                   
                }
                 
                $i++; 
                
            }
            
            fclose($handle);
            
        //}else{
          //  $css->CrearNotificacionRoja("El archivo seleccionado no es valido", 18);
        //}
        
    }else{
        $css->CrearNotificacionRoja("No se selecciono ningun archivo", 18);
        
    }
}
//print($statement);
///////////////Creamos la imagen representativa de la pagina
    /////
    /////	
$css->CrearImageLink("../VMenu/Menu.php", "../images/inventarios.png", "_self",200,200);
$css->CrearNotificacionNaranja("Seleccione el archivo", 16);
print("<br> Subir por Codigo de Barras");

$css->CrearForm2("FrmUploadCsv", $MyPage, "post", "_self");
$css->CrearUpload("UplCsv");
print("<br><br>");
$css->CrearBotonConfirmado("BtnCargar", "Enviar Archivo");
$css->CerrarForm();

print("<br> Subir por Archivo de Inventarios");

$css->CrearForm2("FrmUploadInventario", $MyPage, "post", "_self");
$css->CrearUpload("UplCsv2");
print("<br><br>");
$css->CrearBotonConfirmado("BtnCargarInventario", "Enviar Archivo");
$css->CerrarForm();


print("<br> Agregar Codigos de Barras a Items");

$css->CrearForm2("FrmUploadInventario", $MyPage, "post", "_self");
$css->CrearUpload("UplCsv3");
print("<br><br>");
$css->CrearBotonConfirmado("BtnAgregarCodigosBarras", "Enviar Archivo");
$css->CerrarForm();
$css->CerrarDiv();//Cerramos contenedor Principal

$css->Footer();
$css->AgregaJS(); //Agregamos javascripts
//$css->AgregaSubir();    
////Fin HTML  
print("</body></html>");


?>