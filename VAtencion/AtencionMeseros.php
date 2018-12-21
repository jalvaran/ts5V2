<?php 
$myPage="AtencionMeseros.php";
include_once("../sesiones/php_control.php");
////////// Paginacion
$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
$limit = 20;
$startpoint = ($page * $limit) - $limit;
include_once ('funciones/function.php');  //En esta funcion está la paginacion		
/////////

$obVenta = new ProcesoVenta($idUser);
$obTabla = new Tabla($db);

$idMesa=0;
$idDepartamento=0;
$statement=" productosventa ";
if(isset($_REQUEST["idMesa"])){
    $idMesa=$obVenta->normalizar($_REQUEST["idMesa"]);
}

if(isset($_REQUEST["idDepartamento"])){
    $idDepartamento=$obVenta->normalizar($_REQUEST["idDepartamento"]);
}

if($idDepartamento>0){
    $statement.=" WHERE Departamento='$idDepartamento'";
}
$url="?idMesa=$idMesa&idDepartamento=$idDepartamento&";
if(isset($_REQUEST["TxtBusqueda"])){
    $key=$obVenta->normalizar($_REQUEST["TxtBusqueda"]);
    $statement=" productosventa WHERE Nombre LIKE '%$key%' or idProductosVenta='$key' or Referencia LIKE '%$key%' ";
    $url.="&TxtBusqueda=$key&";
}

include_once("css_construct.php");

print("<html>");
print("<head>");
$css =  new CssIni("Atencion");
print("</head>");
print("<body>");
    
    $css->CabeceraIni("Atencion"); //Inicia la cabecera de la pagina
    $css->CabeceraFin(); 
    ///////////////Creamos el contenedor
    /////
    /////
    $css->CrearDiv("principal", "container", "center",1,1);   
    include_once("procesadores/procesaAtencionMeseros.php");
    $css->CrearForm2("FrmSelMesa", $myPage, "post", "_self");
    $css->CrearTabla();
    $css->FilaTabla(16);
    $css->ColTabla("<strong>Seleccione una mesa</strong>", 1);
    $css->CierraFilaTabla();
    $css->FilaTabla(16);
    print("<td style='text-align:center;'>");
    $css->CrearSelect("idMesa", "EnviaForm('FrmSelMesa')");
    $css->CrearOptionSelect("", "Seleccione una Mesa", 0);
    $consulta=$obVenta->ConsultarTabla("restaurante_mesas", "");
    
    while($DatosMesas=$obVenta->FetchArray($consulta)){
        $sel=0;
        if($idMesa==$DatosMesas["ID"]){
            $sel=1;
        }
        $css->CrearOptionSelect($DatosMesas["ID"], $DatosMesas["Nombre"], $sel);
    }
    $css->CerrarSelect();
    print("</td>");
    $css->CierraFilaTabla();
    $css->CerrarTabla();
    $css->CerrarForm();
    
    $css->CrearDiv("secundario", "", "center",1,1);
    
    if($idMesa>0){
        $obTabla->CrearSubtotalCuentaRestaurante($idMesa,$idDepartamento,$idUser,$myPage,"");
        $css->CrearNotificacionVerde("Lista de Productos", 16);
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
        $css->CrearInputText("idMesa", "hidden", "", $idMesa, "", "", "", "", "", "", "", "");
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
            $css->CrearInputText("idMesa", "hidden", "", $idMesa, "", "", "", "", "", "", "", "");
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
    }  
    
    $css->CerrarDiv();//Cerramos contenedor secundario
    
    $css->CerrarDiv();//Cerramos contenedor Principal
    $css->AgregaJS(); //Agregamos javascripts
    $css->AgregaSubir();
    $css->Footer();
    print("</body></html>");
?>