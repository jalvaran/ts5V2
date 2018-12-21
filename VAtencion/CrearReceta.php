<?php 
$myPage="CrearReceta.php";
include_once("../sesiones/php_control.php");
include_once("css_construct.php");

$obCon = new ProcesoVenta($idUser);

print("<html>");
print("<head>");
$css =  new CssIni("Recetas");

print("</head>");
print("<body>");
    
    //include_once("procesadores/ProcesaCreaTraslado.php");
    
    $css->CabeceraIni("Crear Receta"); //Inicia la cabecera de la pagina
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
    
    
    $css->CrearDiv("DivDatosItemTraslado", "", "center", 1, 1);
    
    $css->CrearTabla();
        $css->FilaTabla(16);            
            $css->ColTabla("<strong>Producto a construir</strong>", 3,'C');
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
            print("<td colspan=3 style=text-align:center>");
                $css->CrearSelect("idProducto", "DibujeItemsReceta()",400);
                    $css->CrearOptionSelect("", "Buscar Producto", 0);
                $css->CerrarSelect();
                $css->CrearBotonEvento("BtnMostrar", "Mostrar Receta", 1, "OnClick", "DibujeItemsReceta()", "azul", "");
            print("</td>");
        $css->CierraFilaTabla();   
        $css->FilaTabla(16);
            $css->ColTabla("<strong>Insumo</strong>", 1);
            $css->ColTabla("<strong>Cantidad</strong>", 1);
            $css->ColTabla("<strong>Agregar</strong>", 1);
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
            
            print("<td>");
                $css->CrearSelect("idInsumo", "",400);
                    $css->CrearOptionSelect("", "Buscar Insumo", 0);
                $css->CerrarSelect();
            print("</td>");
            print("<td>");
                $css->CrearInputNumber("TxtCantidadInsumo", "number", "", 1, "Cantidad", "", "", "", 100, 30, 0, 0, 0, "", "any");
            print("</td>");
            print("<td>");
                $css->CrearBotonEvento("BtnAgregar", "Agregar", 1, "OnClick", "AgregaInsumo()", "verde", "");
            print("</td>");
        $css->CierraFilaTabla();
        
        $css->FilaTabla(16);
            $css->ColTabla("<strong>Servicio</strong>", 1);
            $css->ColTabla("<strong>Cantidad</strong>", 1);
            $css->ColTabla("<strong>Agregar</strong>", 1);
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
            
            print("<td>");
                $css->CrearSelect("idServicio", "",400);
                    $css->CrearOptionSelect("", "Buscar Servicio", 0);
                $css->CerrarSelect();
            print("</td>");
            print("<td>");
                $css->CrearInputNumber("TxtCantidadServicio", "number", "", 1, "Cantidad", "", "", "", 100, 30, 0, 0, 0, "", "any");
            print("</td>");
            print("<td>");
                $css->CrearBotonEvento("BtnAgregar", "Agregar", 1, "OnClick", "AgregaServicio()", "verde", "");
            print("</td>");
        $css->CierraFilaTabla();
        
        $css->FilaTabla(16);
            $css->ColTabla("<strong>Producto para receta</strong>", 1);
            $css->ColTabla("<strong>Cantidad</strong>", 1);
            $css->ColTabla("<strong>Agregar</strong>", 1);
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
            
            print("<td>");
                $css->CrearSelect("idProductoReceta", "",400);
                    $css->CrearOptionSelect("", "Buscar Producto para Receta", 0);
                $css->CerrarSelect();
            print("</td>");
            print("<td>");
                $css->CrearInputNumber("TxtCantidadProducto", "number", "", 1, "Cantidad", "", "", "", 100, 30, 0, 0, 0, "", "any");
            print("</td>");
            print("<td>");
                $css->CrearBotonEvento("BtnAgregar", "Agregar", 1, "OnClick", "AgregaProducto()", "verde", "");
            print("</td>");
        $css->CierraFilaTabla();
    $css->CerrarTabla();
    $css->CerrarDiv();    
    $css->CrearDiv("DivMensajes", "container", "center", 1, 1);
    $css->CerrarDiv();
    $css->CrearDiv("DivItemsRecetas", "container", "center", 1, 1);
    $css->CerrarDiv();
    $css->CerrarDiv();//Cerramos contenedor Secundario
    $css->CerrarDiv();//Cerramos contenedor Principal
    $css->AgregaJS(); //Agregamos javascripts
    $css->AgregaCssJSSelect2(); //Agregamos CSS y JS de Select2
    $css->AgregaSubir();
    print('<script src="jsPages/CrearRecetas.js"></script>');
    
    print("</body></html>");
    ob_end_flush();
?>