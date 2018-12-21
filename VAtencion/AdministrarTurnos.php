<?php 
$myPage="AdministrarTurnos.php";
include_once("../sesiones/php_control.php");
include_once("css_construct.php");

print("<html>");
print("<head>");
$css =  new CssIni("Administrar Turnos");

print("</head>");
print("<body>");
    
    
    $css->CabeceraIni("Administrar Turnos"); //Inicia la cabecera de la pagina
        $css->CrearBotonEvento("BtnCrearCliente", "Cerrar Tercero", 1, "onclick", "ModalCliente()", "verde", "");
      
    $css->CabeceraFin(); 
    ///////////////Creamos el contenedor
    /////
    /////
    $css->CrearDiv("principal", "container", "center",1,1);
   
    $css->CrearDiv("DivButtons", "", "", 0, 0);
    $css->CreaBotonDesplegable("ModalTurnos", "Abrir","BtnAbreModal");
    $css->CerrarDiv();
    $css->CrearModal("ModalTurnos", "TS5", "");
    //$css->CrearCuadroDeDialogoAmplio("DialFacturacion", "Facturar");
        $css->CrearDiv("DivModalTurnos", "", "center", 1, 1);
        $css->CerrarDiv();
    
    //$css->CerrarCuadroDeDialogoAmplio();
    $css->CerrarModal();
    
//////////Se crea el DIV que servirá de contenedor secundario
    /////
    /////
    
    $css->CrearTabla();
        $css->FilaTabla(16);
            $css->ColTabla("<strong>Registrar Turno</strong>", 5,'C');  
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
            $css->ColTabla("<strong>Fecha</strong>", 1);  
            $css->ColTabla("<strong>Sede</strong>", 1);
            $css->ColTabla("<strong>Tercero</strong>", 1);
            $css->ColTabla("<strong>Valor</strong>", 1);
            $css->ColTabla("<strong>Agregar</strong>", 1);
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
            print("<td>");
                $css->CrearInputText("Fecha", "date", "", date("Y-m-d"), "Fecha", "black", "", "", 150, 30, 0, 0);
            print("</td>");  
            print("<td>");
                $css->CrearSelectTable("idSede", "empresa_pro_sucursales", "", "ID", "Nombre", "Ciudad", "", "", "", 1);
            print("</td>");  
            print("<td>");
                $css->CrearSelect("idTercero", "",400);
                    $css->CrearOptionSelect("", "Buscar Tercero", 0);
                $css->CerrarSelect();
            print("</td>");
            print("<td>");
                $css->CrearInputNumber("TxtValor", "number", "", 0, "Valor Turno", "", "", "", 200, 30, 0, 0, 0, "", 1);
            print("</td>");
            print("<td>");
                $css->CrearBotonEvento("BtnAgregar", "Agregar", 1, "OnClick", "RegistrarTurno()", "naranja", "");
            print("</td>");
        $css->CierraFilaTabla();
    $css->CerrarTabla();
    $css->CrearTabla();
        $css->FilaTabla(16);
            $css->ColTabla("<strong>Criterios de Búsqueda</strong>", 5,'C');
        $css->CierraFilaTabla();
        $css->FilaTabla(12);
            $css->ColTabla("<strong>Fecha Inicial</strong>", 1);
            $css->ColTabla("<strong>Fecha Final</strong>", 1);
            $css->ColTabla("<strong>Sede</strong>", 1);
            $css->ColTabla("<strong>Tercero</strong>", 1);
            $css->ColTabla("<strong>Separador</strong>", 1);
            $css->ColTabla("<strong>Filtrar</strong>", 1);
        $css->CierraFilaTabla();
        $css->FilaTabla(12);
            print("<td>");

                $css->CrearInputText("FiltroFechaInicial", "date", "","", "", "", "", "", 130, 30, 0, 0);
            print("</td>");
            print("<td>");
                $css->CrearInputText("FiltroFechaFinal", "date", "", "", "", "", "", "", 130, 30, 0, 0);
            print("</td>");
            print("<td>");
                $css->CrearSelectTable("FiltroidSede", "empresa_pro_sucursales", "", "ID", "Nombre", "Ciudad", "", "", "", 1);
            print("</td>");  
            print("<td>");
                $css->CrearSelect("FiltroTercero", "",400);
                    $css->CrearOptionSelect("", "Buscar X Tercero", 0);
                $css->CerrarSelect();
            print("</td>");
            print("<td>");
                $css->CrearSelect("Separador", "",100);
                    $css->CrearOptionSelect(1, "Punto y Coma (;)", 1);
                    $css->CrearOptionSelect(0, "Coma (,)", 0);
                $css->CerrarSelect();
            print("</td>");
            print("<td>");
                $css->CrearBotonEvento("BtnFiltrar", "Filtrar", 1, "onClick", "DibujeTurnos(1)", "azul", "");
            print("</td>");

        $css->CierraFilaTabla();
    $css->CerrarTabla();
    $css->ProgressBar("PgProgresoCMG", "LyProgresoCMG", "", 0, 0, 100, 0, "0%", "", "");
    $css->CrearDiv("DivMensajes", "container", "center", 1, 1);
    $css->CerrarDiv();
    $css->CrearDiv("DivHistorialTurnos", "container", "center", 1, 1);
    $css->CerrarDiv();
    $css->CerrarDiv();//Cerramos contenedor Principal
    $css->AgregaJS();
    $css->AgregaCssJSSelect2(); //Agregamos CSS y JS de Select2
    $css->AgregaSubir();
    $css->Footer();
    print('<script src="jsPages/AdministrarTurnos.js"></script>');
    print('<script>DibujeTurnos()</script>');
    print("</body></html>");
?>