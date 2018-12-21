<?php
$myPage="bodegas_externas.php";
include_once("../sesiones/php_control.php");

////////// Paginacion
$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);

	$limit = 10;
	$startpoint = ($page * $limit) - $limit;
		
/////////


        
        
include_once ('funciones/function.php');  //En esta funcion está la paginacion

$TablaBodega="productosventa_bodega_1";

if(isset($_REQUEST["CmbBodega"])){
   $TablaBodega=$_REQUEST["CmbBodega"];
   $myTabla=$TablaBodega;
}else{
   $myTabla=$TablaBodega;
}
$idBodega=substr($TablaBodega, 22, 3);
$Vector["CodigoBarras"]["TablaVinculo"]="prod_codbarras_bodega_$idBodega";  //tabla de donde se vincula
include_once("Configuraciones/bodegas_externas.ini.php");  //Clases de donde se escribirán las tablas
include_once("procesadores/procesaBodegas_Externas.php");  //Clases de donde se escribirán las tablas

$obTabla = new Tabla($db);

if(isset($_REQUEST["TxtStament"])){
    $statement= base64_decode($_REQUEST["TxtStament"]);
    //print("<script>alert('$statement')</script>");
}else{
    $statement = $obTabla->CreeFiltro($Vector);
    //print("<script>alert('pasa por crear filtro $statement')</script>");
}


//print($statement);
$Vector["statement"]=$statement;   //Filtro necesario para la paginacion


$obTabla->VerifiqueExport($Vector);

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
//print($statement);
///////////////Creamos la imagen representativa de la pagina y el select para la pagina
    /////
    /////	
$css->CrearImageLink("../VMenu/Menu.php", "../images/externas.png", "_self",200,200);


$css->CrearForm2("FrmSeleccionarBodega", $myPage, "post", "_self");
$css->CrearSelect("CmbBodega", "EnviaForm('FrmSeleccionarBodega')");

    $Datos=$obVenta->ConsultarTabla("bodega", "");
    while($DatosBodega=$obVenta->FetchArray($Datos)){
        $sel=0;
        if($DatosBodega["idBodega"]==$idBodega){
            $sel=1;
        }
        $css->CrearOptionSelect("productosventa_bodega_".$DatosBodega["idBodega"], $DatosBodega["Nombre"], $sel);
    }
    
$css->CerrarSelect();
$css->CrearBotonVerde("BtnSeleccionarBodega", "Seleccionar");
print("<strong><br>Descargar Datos de la Bodega:<br></strong>");
$css->CrearBotonConfirmado("BtnDescargarDatos", substr($TablaBodega, 22, 3));
$css->CerrarForm();
/*
 * Si recibimos la solicitud de bajar la informacion de esa bodega 
 * 
 */
if(isset($_REQUEST["BtnDescargarDatos"])){
    $VectorSer["F"]="";
    $idBodega=$_REQUEST["BtnDescargarDatos"];
    $DatosBodega=$obVenta->DevuelveValores("bodega", "idBodega", $idBodega);
    if($DatosBodega["idServidor"]>0){
        $VectorBackup["LocalHost"]=$host;
        $VectorBackup["User"]=$user;
        $VectorBackup["PW"]=$pw;
        $VectorBackup["DB"]=$db;
        $VectorBackup["Tabla"]="productosventa";
        $VectorBackup["AutoIncrement"]=0; 
        $TablaDesc="productosventa_bodega_$idBodega";
        $obVenta->DescargarDesdeServidor($TablaDesc,$DatosBodega["idServidor"] ,$VectorBackup);
        $VectorBackup["Tabla"]="prod_codbarras";
        $TablaDesc="prod_codbarras_bodega_$idBodega";
        $obVenta->DescargarDesdeServidor($TablaDesc,$DatosBodega["idServidor"] ,$VectorBackup);
        //$css->CrearNotificacionRoja("<pre>$Mensaje</pre>", 16);
    }else{
       $css->CrearNotificacionRoja("Esta Bodega no tiene un servidor asignado", 16); 
    }
}

////Paginacion
////
$Ruta="";
print("<div style='height: 50px;'>");   //Dentro de un DIV para no hacerlo tan grande
print(pagination($Ruta,$statement,$limit,$page));
print("</div>");
////
///Dibujo la tabla
////
///

$obTabla->DibujeTabla($Vector);
$css->CerrarDiv();//Cerramos contenedor Principal
$css->Footer();
$css->AgregaJS(); //Agregamos javascripts
//$css->AgregaSubir();    
////Fin HTML  
print("</body></html>");

ob_end_flush();
?>