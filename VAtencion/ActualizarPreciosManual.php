<?php
$myPage="ActualizarPreciosManual.php";
include_once("../sesiones/php_control.php");

////////// Paginacion
$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);

    	$limit = 10;
    	$startpoint = ($page * $limit) - $limit;
		
/////////


        
        
include_once ('funciones/function.php');  //En esta funcion está la paginacion

include_once("css_construct.php");
print("<html>");
print("<head>");

$css =  new CssIni("Actualizacion manual de precios");
$obVenta= new ProcesoVenta($idUser);
print("</head>");
print("<body>");
//Cabecera
$css->CabeceraIni("Actualizacion manual de precios"); //Inicia la cabecera de la pagina
$css->CabeceraFin(); 
$idDepartamento=1;
if(isset($_REQUEST["CmbDepartamento"])){
    $idDepartamento=$obVenta->normalizar($_REQUEST["CmbDepartamento"]);
    
}
///////////////Creamos el contenedor
    /////
    /////
$css->CrearDiv("principal", "container", "center",1,1);
print("<div id='DivNotificaPrecio'>");
    
print("</div>");
//css->DivNotificacionesJS();
//print($statement);
///////////////Creamos la imagen representativa de la pagina
    /////
    /////	

///Dibujo la tabla
////
///
$css->CrearForm2("FrmDepartamento", $myPage, "post", "_self");
    $css->CrearSelect("CmbDepartamento", "EnviaForm('FrmDepartamento')");
    $DatosConsulta=$obVenta->ConsultarTabla("prod_departamentos", "");
    while ($DatosDepartamentos=$obVenta->FetchArray($DatosConsulta)){
        $sel=0;
        if($idDepartamento==$DatosDepartamentos["idDepartamentos"]){
            $sel=1;
        }
        $css->CrearOptionSelect($DatosDepartamentos["idDepartamentos"], $DatosDepartamentos["Nombre"], $sel);
    }
        
    $css->CerrarSelect();
    $css->CrearBoton("BtnEnviar", "Enviar"); 
$css->CerrarForm();
$css->CrearTabla();
        $css->FilaTabla(16);
            $css->ColTabla("<strong>ID</strong>", 1);
            //$css->ColTabla("<strong>Referencia</strong>", 1);
            $css->ColTabla("<strong>Nombre</strong>", 1);
            $css->ColTabla("<strong>Precio de Venta</strong>", 1);
        $css->CierraFilaTabla();
$sql="SELECT idProductosVenta as ID,Nombre, Referencia, PrecioVenta FROM productosventa WHERE Departamento='$idDepartamento' LIMIT 500";        
$consulta=$obVenta->Query($sql);
//$consulta=$obVenta->ValorActual("productosventa", "idProductosVenta as ID, Referencia, PrecioVenta", "  LIMIT 50");
while ($DatosProductos=$obVenta->FetchArray($consulta)){
    $idProducto=$DatosProductos["ID"];
        $css->FilaTabla(16);
            $css->ColTabla($DatosProductos["ID"], 1);
            //$css->ColTabla($DatosProductos["Referencia"], 1);
            $css->ColTabla($DatosProductos["Nombre"], 1);
            print("<td>");
                $Page="ProcesadoresJS/ProcesaUpdateJS.php?NoConfirma=2&BtnEditarRegistro=1&TxtTabla=productosventa&TxtIDEdit=$idProducto&TxtIdTabla=idProductosVenta&TxtColumna=PrecioVenta&TxtValorEdit=";
                $TxtFuncion="EnvieObjetoConsulta(`$Page`,`TxtPrecioVenta$idProducto`,`DivNotificaPrecio`,`2`);return false;";
                $css->CrearInputNumber("TxtPrecioVenta$idProducto", "number", "", $DatosProductos["PrecioVenta"], "PrecioVenta", "", "OnChange", $TxtFuncion, 100, 30, 0, 0, 1, "", 1);
                //$css->ColTabla($DatosProductos["PrecioVenta"], 1);
            print("</td>");
            
        $css->CierraFilaTabla();
    
}
$css->CerrarTabla();
$css->CerrarDiv();//Cerramos contenedor Principal

$css->Footer();
$css->AgregaJS(); //Agregamos javascripts
$css->AgregaSubir();    
////Fin HTML  
print("</body></html>");

ob_end_flush();
?>