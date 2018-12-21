<?php
$myPage="listados_titulos.php";
include_once("../sesiones/php_control.php");

////////// Paginacion
$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);

	$limit = 10;
	$startpoint = ($page * $limit) - $limit;
		
/////////


        
        
include_once ('funciones/function.php');  //En esta funcion está la paginacion
$obVenta = new ProcesoVenta($idUser);
$ListadoTitulo="titulos_listados_promocion_1";

if(isset($_REQUEST["CmbListado"])){
   $ListadoTitulo=$_REQUEST["CmbListado"];
   $myTabla=$ListadoTitulo;
}else{
   $DatosTabla=$obVenta->DevuelveValores("titulos_promociones", "Activo", "SI");
   $myTabla="titulos_listados_promocion_".$DatosTabla["ID"];
   $ListadoTitulo=$myTabla;
}

$idListado=substr($ListadoTitulo, 27, 3);
include_once("Configuraciones/listados_titulos.ini.php");  //Clases de donde se escribirán las tablas


$obTabla = new Tabla($db);

if(isset($_REQUEST["TxtStament"])){
    $statement= base64_decode($_REQUEST["TxtStament"]);
    
}else{
    $statement = $obTabla->CreeFiltro($Vector);
    //print("<script>alert('pasa por crear filtro $statement')</script>");
}
$Vector["TablaListado"]=$ListadoTitulo;
//print($ListadoTitulo);
//print($statement);
$Vector["statement"]=$statement;   //Filtro necesario para la paginacion


$obTabla->VerifiqueExport($Vector);
//$obTabla->VerifiqueExportPDF($Vector);
include_once("css_construct.php");
print("<html>");
print("<head>");

$css =  new CssIni($myTitulo);
print("</head>");
print("<body>");
include_once("procesadores/procesaListados_Titulos.php");  //Clases de donde se escribirán las tablas
//Cabecera
$css->CabeceraIni($myTitulo); //Inicia la cabecera de la pagina
$css->CabeceraFin(); 

///////////////Creamos el contenedor
    /////
    /////
$css->CrearDiv("principal", "container", "center",1,1);
$css->DivNotificacionesJS();
//print($statement);
///////////////Creamos la imagen representativa de la pagina y el select para la pagina
    /////
    /////	
$css->CrearImageLink("../VMenu/Menu.php", "../images/inventarios_titulos.png", "_self",200,200);


$css->CrearForm2("FrmSeleccionarListado", $myPage, "post", "_self");
print("<strong>Promocion: </strong>");
$css->CrearSelect("CmbListado", "EnviaForm('FrmSeleccionarListado')");

    $Datos=$obVenta->ConsultarTabla("titulos_promociones", " WHERE Activo='SI'");
    while($DatosPromociones=$obVenta->FetchArray($Datos)){
        $sel=0;
        if($DatosPromociones["ID"]==$idListado){
            $sel=1;
        }
        $css->CrearOptionSelect("titulos_listados_promocion_".$DatosPromociones["ID"], $DatosPromociones["Nombre"], $sel);
    }
    
$css->CerrarSelect();
$css->CrearBotonVerde("BtnSeleccionarListado", "Seleccionar");

$css->CerrarForm();



//Solicito la carga del archivo o dibujo el formulario para asignar un titulo
//

$Datos=$obVenta->ConsultarTabla($ListadoTitulo, "");
if(!$obVenta->NumRows($Datos)){
    $css->CrearForm2("FrmCargaListado", $myPage, "post", "_self");
    $css->CrearInputText("TablaUpload", "hidden", "", $ListadoTitulo, "", "", "", "", "", "", 0, 0);
    $css->CrearUpload("UplListado");
    $css->CrearBotonConfirmado("BtnCargar", "Cargar");
    $css->CerrarForm();
}else{
    $sql="SELECT MIN(Mayor1) as Min, MAX(Mayor1) as Max FROM $ListadoTitulo";
    $consulta=$obVenta->Query($sql);
    $ExtremosTitulos=$obVenta->FetchArray($consulta);
    $css->CrearForm2("FrmAsignarTitulos", $myPage, "post", "_self");
    $css->CrearInputText("TablaTitulo", "hidden", "", $ListadoTitulo, "", "", "", "", "", "", 0, 0);
    $css->CrearInputText("idListado", "hidden", "", $idListado, "", "", "", "", "", "", 0, 0);
    $css->CrearTabla();
    $css->FilaTabla(14);
    $css->ColTabla("<strong>Asignar Titulos: </strong>", 5);
    $css->CierraFilaTabla();
    $css->FilaTabla(14);
    print("<td>");
    $css->CrearInputFecha("Fecha: ", "TxtFechaAsignacion", date("Y-m-d"), 100, 30, "");
    print("</td>");
    print("<td>");
    $css->CrearInputNumber("TxtTituloDesde", "number", "Desde: ",$ExtremosTitulos["Min"] , "Desde", "black", "", "", 100, 30, 0, 1, $ExtremosTitulos["Min"], $ExtremosTitulos["Max"], 1);
    print("</td>");
    print("<td>");
    $css->CrearInputNumber("TxtTituloHasta", "number", "Hasta: ",$ExtremosTitulos["Min"] , "Hasta", "black", "", "", 100, 30, 0, 1, $ExtremosTitulos["Min"], $ExtremosTitulos["Max"], 1);
    print("</td>");
    print("<td>");
    $VarSelect["Ancho"]=200;
    $VarSelect["PlaceHolder"]="Seleccione Colaborador";
    $VarSelect["Required"]=1;
    $css->CrearSelectChosen("CmbColaboradorAsignado", $VarSelect);
    $css->CrearOptionSelect("", "Seleccione un Colaborador", 0);
    $Datos=$obVenta->ConsultarTabla("colaboradores", "");
        while($DatosColaboradores=$obVenta->FetchArray($Datos)){
            $css->CrearOptionSelect($DatosColaboradores["Identificacion"], $DatosColaboradores["Nombre"]." ".$DatosColaboradores["Identificacion"], 0);
        }
    $css->CerrarSelect();
    print("</td>");
    print("<td>");
    $css->CrearTextArea("TxtObservacionesAsignacion", "", "", "Observaciones", "black", "", "", 200, 60, 0, 0);
    print("</td>");
    print("<td>");
    $css->CrearBotonConfirmado("BtnAsignarTitulo", "Asignar");
    print("</td>");
    $css->CerrarTabla();
    $css->CerrarForm();
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