<?php 
    $myPage="AtencionMeseros2.php";
    include_once("../sesiones/php_control.php");
    $obVenta = new ProcesoVenta($idUser);
    $obTabla = new Tabla($db);
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
    $Titulo="Buscar";
    $Nombre="ImgBuscar";
    $RutaImage="../images/buscar.png";
    $javascript="";
    $VectorBim["f"]=0;
    $target="#DialBusquedaItems";
    $css->CrearBotonImagen($Titulo,$Nombre,$target,$RutaImage,"",50,50,"fixed","right:10px;bottom:80",$VectorBim);
    $css->CrearDiv("principal", "container", "center",1,1);
    $css->CrearDiv("DivMensajes", "", "center", 1, 1);
    $css->CerrarDiv();
    $css->DivNotificacionesJS();
    $css->CrearCuadroDeDialogo("DialBusquedaItems","Buscar Producto");
        $css->CrearTabla();
            $css->FilaTabla(16);
                $css->ColTabla("<strong>Buscar</strong>", 1);
                $css->ColTabla("<strong>Cantidad</strong>", 1);
                $css->ColTabla("<strong>Observaciones</strong>", 1);
            $css->CierraFilaTabla();
            $css->FilaTabla(16);
                print("<td>");
                $Page="Consultas/BuscarItemsPedido.php?TxtBusqueda=";
                $FuncionJS="EnvieObjetoConsulta(`$Page`,`TxtBusqueda`,`DivBusquedaItems`,`7`);return false ;";
                $css->CrearInputText("TxtBusqueda", "text", "", "", "Buscar Producto", "", "onkeyup", $FuncionJS, 150, 40, 0, 0);
                print("</td>");
                print("<td>");
                $css->CrearInputNumber("TxtCantidadItem", "number", "", 1, "Cantidad", "", "", "", 50, 40, 0, 0, 0, "", "any");
                print("</td>");
                print("<td>");
                $css->CrearTextArea("TxtObservacionesItem", "", "", "Observaciones", "", "", "", 150, 40, 0, 1);
                print("</td>");
            $css->CierraFilaTabla();
        $css->CerrarTabla();
        $css->CrearDiv("DivBusquedaItems", "", "center", 1, 1);
        $css->CerrarDiv();
            
    $css->CerrarCuadroDeDialogo();
        include_once("procesadores/AtencionMeseros.process.php");  
        $css->CrearTabla();
            $css->FilaTabla(14);
                print("<td>");
                    $Page="Consultas/ItemsPedido.php?myPage=$myPage&idMesa=";
                    $FuncionJS="EnvieObjetoConsulta(`$Page`,`idMesa`,`DivItemsPedido`,`7`);return false ;";
                    $css->CrearSelectTable("idMesa", "restaurante_mesas", "", "ID", "Nombre", "", "onchange", $FuncionJS, "", 1,"Seleccione una Mesa");
                    $css->CrearBotonImagen("", "imgCargarItems", "_Self", "../images/busqueda.png", "onclick=".$FuncionJS, 30, 30, "static", "", "");

                print("</td>");
                $css->CierraFilaTabla();
                $css->FilaTabla(14);
                print("<td>");
                    $Page="Consultas/BuscarItemsPedido.php?idDepartamento=";
                    $FuncionJS="MostrarDialogoID(`ImgBuscar`);EnvieObjetoConsulta(`$Page`,`idDepartamento`,`DivBusquedaItems`,`7`);return false ;";
                    $css->CrearSelectTable("idDepartamento", "prod_departamentos", "", "idDepartamentos", "Nombre", "", "onchange", $FuncionJS, "", 1,"Seleccione un Departamento");
                    $css->CrearBotonImagen("", "imgCargarItems", "_Self", "../images/busqueda.png", "onclick=".$FuncionJS, 30, 30, "static", "", "");

                print("</td>");
            $css->CierraFilaTabla();
            $css->CerrarTabla();
    $css->DivGrid("DivItemsPedido", "", "left", 1, 1, 1, 80, 100,5,"transparent");
    $css->CerrarDiv();
    $css->CerrarDiv();//Cerramos contenedor secundario
    
    $css->AgregaJS(); //Agregamos javascripts
   
    $css->AgregaSubir();
    $css->Footer();
    print("</body></html>");
?>