<script>
function allowDrop(ev) {
    ev.preventDefault();
    
}

function drag(ev) {
    ev.dataTransfer.setData("text", ev.target.id);
    
}

function drop(ev,idDiv) {
    ev.preventDefault();
    var data = ev.dataTransfer.getData("text");
    var idProducto=document.getElementById(data).id;
    //alert(idProducto+' '+idDiv);
    ev.target.appendChild(document.getElementById(data));
    Page="Consultas/ActualizaCartel.php?idDiv="+idDiv+"&idProducto="+idProducto+"&key=";
    idTarget="DivNotificaciones";
    EnvieObjetoConsulta(Page,"DivNotificaciones",idTarget);
}
</script>
<?php 
$myPage="CrearCartelPublicitario.php";
include_once("../sesiones/php_control.php");
include_once("css_construct.php");
$obVenta = new ProcesoVenta($idUser);
	
print("<html>");
print("<head>");
$css =  new CssIni("Cartel Publicitario");

print("</head>");
print("<body>");
    
    
    
    $css->CabeceraIni("Cartel Publicitario"); //Inicia la cabecera de la pagina
    
    //////////Creamos el formulario de busqueda de remisiones
    /////
    /////
    
   
    
    $css->CabeceraFin(); 
    ///////////////Creamos el contenedor
    /////
    /////
    $css->CrearDiv("DivTitulos", "container", "center", 1, 1);
    $DatosCabecera=$obVenta->DevuelveValores("publicidad_encabezado_cartel", "ID", 1);
        $css->CrearTabla();
        $css->FilaTabla(16);
            $css->ColTabla("<strong>Titulo</strong>", 1);            
            $css->ColTabla("<strong>Desde</strong>", 1);
            $css->ColTabla("<strong>Hasta</strong>", 1);
            $css->ColTabla("<strong>Mes</strong>", 1);
            $css->ColTabla("<strong>Anio</strong>", 1);
            $css->ColTabla("<strong>Razon Social</strong>", 1);
            $css->ColTabla("<strong>Precios</strong>", 1);
            $css->ColTabla("<strong>Bordes</strong>", 1);
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
            print("<td>");
                $Page="Consultas/ActualizaDatosCartel.php?TxtCaja=1&key=";
                $css->CrearInputText("TxtTitulo", "text", "", $DatosCabecera["Titulo"], "Titulo", "", "OnChange", "EnvieObjetoConsulta(`$Page`,`TxtTitulo`,`DivNotificaciones`,`2`);return false;", 300, 30, 0, 1, "Escriba el titulo del cartel");
                $Page="Consultas/ActualizaDatosCartel.php?TxtCaja=5&key=";
                $css->CrearInputText("TxtTituloColor", "color", "", $DatosCabecera["ColorTitulo"], "", "", "OnChange", "EnvieObjetoConsulta(`$Page`,`TxtTituloColor`,`DivNotificaciones`,`6`);return false;", 90, 30, 0, 1, "Escriba el titulo del cartel");
        
            print("</td>");
            
            
            print("<td>");
                $Page="Consultas/ActualizaDatosCartel.php?TxtCaja=2&key=";
                $css->CrearInputText("TxtDesde", "number", "", $DatosCabecera["Desde"], "Desde", "", "OnChange", "EnvieObjetoConsulta(`$Page`,`TxtDesde`,`DivNotificaciones`,`2`);return false;", 50, 30, 0, 1, "Escriba el dia de inicio de la promocion");
        
            print("</td>");
            print("<td>");
                $Page="Consultas/ActualizaDatosCartel.php?TxtCaja=3&key=";
                $css->CrearInputText("TxtHasta", "number", "", $DatosCabecera["Hasta"], "Hasta", "", "OnChange", "EnvieObjetoConsulta(`$Page`,`TxtHasta`,`DivNotificaciones`,`2`);return false;", 50, 30, 0, 1, "Escriba el dia de fin de la promocion");
        
            print("</td>");
            print("<td>");
                $Page="Consultas/ActualizaDatosCartel.php?TxtCaja=9&key=";
                $css->CrearInputText("TxtMes", "text", "", $DatosCabecera["Mes"], "Mes", "", "OnChange", "EnvieObjetoConsulta(`$Page`,`TxtMes`,`DivNotificaciones`,`2`);return false;", 100, 30, 0, 1, "Escriba el titulo del cartel");
                
            print("</td>");
            print("<td>");
                $Page="Consultas/ActualizaDatosCartel.php?TxtCaja=4&key=";
                $css->CrearInputText("TxtAnio", "number", "", $DatosCabecera["Anio"], "Titulo", "", "OnChange", "EnvieObjetoConsulta(`$Page`,`TxtAnio`,`DivNotificaciones`,`2`);return false;", 70, 30, 0, 1, "Escriba el año ");
        
            print("</td>");
            print("<td>");
                $Page="Consultas/ActualizaDatosCartel.php?TxtCaja=6&key=";
                $css->CrearInputText("TxtColorRazonSocial", "color", "", $DatosCabecera["ColorRazonSocial"], "", "", "OnChange", "EnvieObjetoConsulta(`$Page`,`TxtColorRazonSocial`,`DivNotificaciones`,`6`);return false;", 90, 30, 0, 1, "Escriba el titulo del cartel");
        
            print("</td>");
            print("<td>");
                $Page="Consultas/ActualizaDatosCartel.php?TxtCaja=7&key=";
                $css->CrearInputText("TxtColorPrecio", "color", "", $DatosCabecera["ColorPrecios"], "", "", "OnChange", "EnvieObjetoConsulta(`$Page`,`TxtColorPrecio`,`DivNotificaciones`,`6`);return false;", 90, 30, 0, 1, "Escriba el titulo del cartel");
        
            print("</td>");
            print("<td>");
                $Page="Consultas/ActualizaDatosCartel.php?TxtCaja=8&key=";
                $css->CrearInputText("TxtColorBordes", "color", "", $DatosCabecera["ColorBordes"], "", "", "OnChange", "EnvieObjetoConsulta(`$Page`,`TxtColorBordes`,`DivNotificaciones`,`6`);return false;", 90, 30, 0, 1, "Escriba el titulo del cartel");
        
            print("</td>");
        $css->CierraFilaTabla();
        $css->CerrarTabla();
        
           
    $css->CerrarDiv();
    print("<div name='DivProductos' style='position:fixed !important; left:10px; top:140px; z-index:10 !important;height:400px;width:200px;overflow:auto;border: 1px solid #D2D2D2;' >");
        $Page="Consultas/BuscarItemsCartel.php?key=";
        $css->CrearInputText("TxtBuscarProducto", "text", "", "", "Buscar", "", "OnKeyUp", "EnvieObjetoConsulta(`$Page`,`TxtBuscarProducto`,`DivBusquedasProd`,`2`);return false;", 200, 30, 0, 1, "Busque el producto que desea agregar");
        $css->CrearDiv("DivBusquedasProd", "", "left", 1, 1);
        
    $css->CerrarDiv();
    
    print("<div name='DivGenerar' style='position:fixed !important; left:110px; top:550px; z-index:10 !important;width:150px;' >");
        $css->CrearForm2("FrmCrearPDF", "PDF_Cartel_Publicidad.php", "post", "_blank");
        $css->CrearBotonVerde("BtnCrearPDF", "Crear Cartel");
        $css->CerrarForm();
        
    $css->CerrarDiv();
    print("<div name='Esp99' id='Esp99' ondrop='drop(event,`Esp99`)' ondragover='allowDrop(event)' style='position:fixed !important; left:10px; bottom:10px; z-index:10 !important;width:150px; ' >");
        print('<img id="99" src="../images/papelera.png" draggable="true" ondragstart="drag(event)" width="100px" height="20px">');
            
    print("<img >");    
    $css->CerrarDiv();
                        
        $css->CerrarDiv();
    $css->CrearDiv("Div", "container", "left", 1, 1);
    $css->CrearDiv("DivNotificaciones", "", "center",1,1);
    
    $css->CerrarDiv();
    
    $css->CrearNotificacionAzul("Pagina 1, Arrastre los productos a cada espacio", 14);
    $DatosImagen=$obVenta->DevuelveValores("publicidad_paginas", "ID", 1);
    
    for($i=1;$i<=16;$i++){

            print("<div id='Esp$i' ondrop='drop(event,`Esp$i`)' ondragover='allowDrop(event)' style='text-align:center;float:left;height:150px;width:24%;border: 1px solid;border-color: gray;  '>");
            $DatosImagen=$obVenta->DevuelveValores("publicidad_paginas", "ID", $i);
            $DatosProducto=$obVenta->DevuelveValores("productosventa", "idProductosVenta",$DatosImagen["idProducto"] );
            if($DatosProducto["idProductosVenta"]>0){
                print('<img id="'.$DatosProducto["idProductosVenta"].'" src="../'.$DatosProducto["RutaImagen"].'" draggable="true" ondragstart="drag(event)" width="100px" height="20px">');
            }            
            $css->CerrarDiv();
        if($i==4 or $i==8 or $i==12){
             print("<br>");

        }
    }
    $css->CerrarDiv();  
    $css->CrearDiv("DivPage2", "container", "left", 1, 1);
    print("<br><br>");
    $css->CrearNotificacionAzul("Pagina 2, Arrastre los productos a cada espacio", 14);
    
   
    for($i=17;$i<=32;$i++){

            print("<div id='Esp$i' ondrop='drop(event,`Esp$i`)' ondragover='allowDrop(event)' style='text-align:center;float:left;height:150px;width:24%;border: 1px solid;border-color: gray;  '>");
            $DatosImagen=$obVenta->DevuelveValores("publicidad_paginas", "ID", $i);
            $DatosProducto=$obVenta->DevuelveValores("productosventa", "idProductosVenta",$DatosImagen["idProducto"] );
            if($DatosProducto["idProductosVenta"]>0){
                print('<img id="'.$DatosProducto["idProductosVenta"].'" src="../'.$DatosProducto["RutaImagen"].'" draggable="true" ondragstart="drag(event)" width="100px" height="20px">');
            }            
            $css->CerrarDiv();
        
    }
     
    $css->CerrarDiv();//Cerramos contenedor Principal
    $css->AgregaJS(); //Agregamos javascripts
    $css->AgregaSubir();
    $css->Footer();
    print("</body></html>");
    ob_end_flush();
?>