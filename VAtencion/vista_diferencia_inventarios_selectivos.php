<?php
$myPage="vista_diferencia_inventarios_selectivos.php";
include_once("../sesiones/php_control.php");
////////// Paginacion
$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);

    	$limit = 10;
    	$startpoint = ($page * $limit) - $limit;
		
/////////


        
        
include_once ('funciones/function.php');  //En esta funcion está la paginacion

include_once("Configuraciones/vista_diferencia_inventarios_selectivos.ini.php");  //Clases de donde se escribirán las tablas
$obTabla = new Tabla($db);


$statement = $obTabla->CreeFiltro($Vector);
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
$obVenta=new ProcesoVenta($idUser);
///////////////Creamos el contenedor
    /////
    /////
$css->CrearDiv("principal", "container", "center",1,1);
if(isset($_REQUEST["BtnVaciar"])){ //Si se desea reiniciar los conteos
    
    $obVenta->VaciarTabla("inventarios_conteo_selectivo");
    $css->CrearNotificacionNaranja("Inventario Reiniciado", 16);
}
//Si se elige la opcion de actualizar 
if(isset($_REQUEST["BtnActualizar"])){ //Si se desea reiniciar los conteos
    $Consulta=$obVenta->ConsultarTabla("vista_diferencia_inventarios_selectivos", "WHERE Diferencia<>0");
    while($DatosVista=$obVenta->FetchArray($Consulta)){
        $Existencias=$DatosVista["ExistenciaActual"];
        $idProducto=$DatosVista["idProductosVenta"];
        $sql="UPDATE productosventa SET Existencias=$Existencias,CostoTotal=Existencias*CostoUnitario, CostoTotalPromedio=Existencias*CostoUnitarioPromedio "
                . "WHERE idProductosVenta='$idProducto'";
        $obVenta->Query($sql);
        $obVenta->BorraReg("inventarios_conteo_selectivo", "Referencia", $DatosVista["Referencia"]);
    }
    $css->CrearNotificacionVerde("Productos actualizados", 16);
}
//Creo el menú para los inventarios selectivos
    $Titulo="Opciones";
    $Nombre="ImgShowMenu";
    $RutaImage="../images/options.png";
    $javascript="";
    $VectorBim["f"]=0;
    $target="#DialOpciones";
    $css->CrearBotonImagen($Titulo,$Nombre,$target,$RutaImage,"",80,80,"fixed","left:10px;top:150",$VectorBim);

    $css->CrearCuadroDeDialogo("DialOpciones", "Opciones para el Inventario Selectivo");
        
        $css->CrearForm2("FrmVaciar", $myPage, "post", "_self");
            $css->CrearNotificacionNaranja("Click para Reiniciar un conteo Selectivo", 16);
            $css->CrearBotonConfirmado("BtnVaciar", "Reiniciar Conteo Selectivo");
            print("<br><br><br>");
            $css->CrearNotificacionNaranja("Click para Actualizar productos Segun el conteo", 16);
            $css->CrearBotonConfirmado("BtnActualizar", "Actualizar Productos Segun el conteo");
            print("<br><br><br>");
            $css->CrearNotificacionRoja("Click para Ajustar Diferencias en el inventario, Por medio de Altas y Bajas", 16);
            $css->CrearBotonConfirmado("BtnAltasBajas", "Ajustar Inventario segun Diferencias");
        $css->CerrarForm();
    $css->CerrarCuadroDeDialogo();
            
//print($statement);
///////////////Creamos la imagen representativa de la pagina
    /////
    /////	
//$css->CrearImageLink("../VMenu/Menu.php", "../images/cajas.png", "_self",200,200);


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
$Consulta=$obVenta->Query("SELECT SUM(TotalCostosDiferencia) as Total, COUNT(*) as TotalItems FROM $statement");
$DatosConsulta=$obVenta->FetchArray($Consulta);
$TotalItems=  number_format($DatosConsulta["TotalItems"]);
$TotalCostos=  number_format($DatosConsulta["Total"]);
$css->CrearNotificacionVerde("El total de items con diferencias son: $TotalItems, con un costo Total de: $TotalCostos", 16);

$obTabla->DibujeTabla($Vector);
$css->CerrarDiv();//Cerramos contenedor Principal

$css->Footer();
$css->AgregaJS(); //Agregamos javascripts
//$css->AgregaSubir();    
////Fin HTML  
print("</body></html>");


?>