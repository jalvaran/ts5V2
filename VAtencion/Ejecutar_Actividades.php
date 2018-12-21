<?php
$myPage="Ejecutar_Actividades.php";
include_once("../sesiones/php_control.php");

////////// Paginacion
$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);

    $limit = 10;
    $startpoint = ($page * $limit) - $limit;
		
/////////
       
include_once ('funciones/function.php');  //En esta funcion está la paginacion

include_once("Configuraciones/Ejecutar_Actividades.ini.php");  //Clases de donde se escribirán las tablas
$obTabla = new Tabla($db);
$obVenta = new ProcesoVenta($idUser);
//$statement = $obTabla->CreeFiltro($Vector);
//print($statement);
//$Vector["statement"]=$statement;   //Filtro necesario para la paginacion


//$obTabla->VerifiqueExport($Vector);

include_once("css_construct.php");
print("<html>");
print("<head>");

$css =  new CssIni($myTitulo);
print("</head>");
print("<body>");
//Cabecera
$idActividad=0;
$idMaquina=0;
$idColaborador=0;
if(isset($_REQUEST["idMaquina"])){
    $idMaquina=$_REQUEST["idMaquina"];
    
}

if(isset($_REQUEST["idActividad"])){
    $idActividad=$_REQUEST["idActividad"];
    
}

if(isset($_REQUEST["idColaborador"])){
    $idColaborador=$_REQUEST["idColaborador"];
    
}

$css->CabeceraIni($myTitulo); //Inicia la cabecera de la pagina
$css->CabeceraFin(); 


///////////////Creamos el contenedor
    /////
    /////
$css->CrearDiv("principal", "container", "center",1,1);
if($idMaquina<1){
    $css->CrearNotificacionRoja("Seleccione una Maquina", 18);
    $css->CrearForm2("FrmAsignarMaquina", $myPage, "GET", "_self");
    $css->CrearSelect("idMaquina", "EnviaForm('FrmAsignarMaquina')");
    $css->CrearOptionSelect("0", "Seleccione una Maquina", 0);
    $Datos=$obVenta->ConsultarTabla("maquinas", "");
    while($DatosMaquinas=$obVenta->FetchArray($Datos)){
        $css->CrearOptionSelect($DatosMaquinas["ID"],$DatosMaquinas["Nombre"], 0);
    }
    $css->CerrarSelect();
    $css->CerrarForm();
}

if($idColaborador<1 and $idMaquina>0){
    $css->CrearNotificacionRoja("Seleccione una Colaborador", 18);
    $css->CrearForm2("FrmColaborador", $myPage, "GET", "_self");
    $css->CrearInputText("idMaquina","hidden","",$idMaquina,"","","","",0,0,0,0);
    $css->CrearSelect("idColaborador", "EnviaForm('FrmColaborador')");
    
    $css->CrearOptionSelect("0", "Seleccione un Colaborador", 0);
    $Datos=$obVenta->ConsultarTabla("usuarios", " WHERE idUsuarios >=3");
    while($DatosMaquinas=$obVenta->FetchArray($Datos)){
        $css->CrearOptionSelect($DatosMaquinas["Identificacion"],$DatosMaquinas["Nombre"]." ".$DatosMaquinas["Apellido"], 0);
    }
    $css->CerrarSelect();
    $css->CerrarForm();
}


////Se muestran las actividades
////



if($idColaborador>0 and $idMaquina>0 and $idActividad==0){
    
    $statement=" produccion_actividades WHERE idMaquina='$idMaquina' AND Estado<>'TERMINADA'";
    
    $Ruta="idMaquina=$idMaquina&idColaborador=$idColaborador&";
    print("<div style='height: 50px;'>");   //Dentro de un DIV para no hacerlo tan grande
    print(pagination($Ruta,$statement,$limit,$page));
    print("</div>");
    $css->CrearTabla();
    $css->FilaTabla(20);
    $css->ColTabla("Actividades", "3");
    $css->CierraFilaTabla();
    
    
    $sql="SELECT * FROM $statement ORDER BY Fecha_Planeada_Inicio, Hora_Planeada_Inicio Asc LIMIT $startpoint,$limit ";
    $Datos=$obVenta->Query($sql);
    while($DatosActividades=$obVenta->FetchArray($Datos)){
        $css->FilaTabla(20);
        echo("<td>");
        $link="$myPage?".$Ruta."idActividad=$DatosActividades[ID]";
        $css->CrearLink($link, "_self", "Ver Act $DatosActividades[ID]");
        print(" $DatosActividades[Fecha_Planeada_Inicio] $DatosActividades[Hora_Planeada_Inicio]");
        echo("</td>");
        echo("<td>");
        echo("$DatosActividades[Descripcion]");
        
        echo("</td>");
        $css->CierraFilaTabla();
    }
    
    
    $css->CerrarTabla();
    
    
    
    
}


///////////////Se muestran las opciones para ejecutar
    /////
    /////



if($idActividad>0){
    $idPausa="";
    if(isset($_REQUEST["BtnTerminar"])){
        $idPausa="NO";
        $obVenta->ProceseEjecucionActividad($idActividad, $idMaquina,$idColaborador,4,$idPausa,"");
    }
    if($idPausa<>"NO"){
        if(isset($_REQUEST["BtnEjecutar"])){
            $idEjecucion=$obVenta->normalizar($_REQUEST["BtnEjecutar"]);
            $idPausa=$obVenta->normalizar($_REQUEST["CmbPausa"]);
            $obVenta->ProceseEjecucionActividad($idActividad, $idMaquina,$idColaborador,$idEjecucion,$idPausa,"");
        }
    }
    
    
    $DatosActividad=$obVenta->DevuelveValores("produccion_actividades", "ID", $idActividad);
    $css->CrearNotificacionRoja("Actividad: $idActividad $DatosActividad[Descripcion], Observaciones: $DatosActividad[Observaciones], Estado: $DatosActividad[Estado]", 16);
    switch ($DatosActividad["Estado"]){
        case "NO_INICIADA":
            $Image="../images/play.png";
            $Link="$myPage?idMaquina=$idMaquina&idColaborador=$idColaborador&idActividad=$idActividad&BtnEjecutar=1&CmbPausa=0";
            break;
        case "EJECUCION":
            $Image="../images/process.gif";
            $Link="#";
            break;
        case "PAUSA_OPERATIVA":
            $Image="../images/pause.png";
            $Link="$myPage?idMaquina=$idMaquina&idColaborador=$idColaborador&idActividad=$idActividad&BtnEjecutar=3&CmbPausa=0";
            break;
        case "PAUSA_NO_OPERATIVA":
            $Image="../images/pause2.jpg";
            $Link="$myPage?idMaquina=$idMaquina&idColaborador=$idColaborador&idActividad=$idActividad&BtnEjecutar=5&CmbPausa=0";
            break;
        case "TERMINADA":
            $Image="../images/terminado.png";
            $Link="$myPage?idMaquina=$idMaquina&idColaborador=$idColaborador";
            break;
        
    }
    $css->CrearImageLink($Link, $Image, "_self",80,80);
    $css->CrearImageLink($myPage, "../images/home.png", "_self",80,80);
    if($DatosActividad["Estado"]=="EJECUCION"){
        $css->CrearForm2("FrmPausas", $myPage, "get", "_self");
        $css->CrearInputText("idMaquina", "hidden", "", $idMaquina, "", "", "", "", "", "", 0, 0);
        $css->CrearInputText("idColaborador", "hidden", "", $idColaborador, "", "", "", "", "", "", 0, 0);
        $css->CrearInputText("idActividad", "hidden", "", $idActividad, "", "", "", "", "", "", 0, 0);
        $css->CrearInputText("BtnEjecutar", "hidden", "", 2, "", "", "", "", "", "", 0, 0);
        
        $css->CrearTabla();
        $css->FilaTabla(16);
        print("<td style='text-align:center'>");
        print("<strong>Pausar</strong>");
        print("</td>");
        print("<td style='text-align:center'>");
        print("<strong>Terminar</strong>");
        print("</td>");
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
        print("<td style='text-align:center'>");
            $css->CrearSelect("CmbPausa", "EnviaForm('FrmPausas')");
            $css->CrearOptionSelect("0", "Seleccione un causal", 1);
            $Datos=$obVenta->ConsultarTabla("produccion_pausas_predefinidas", "");
            while($DatosPausasPre=$obVenta->FetchArray($Datos)){
                $css->CrearOptionSelect($DatosPausasPre["ID"], $DatosPausasPre["Nombre"], 0);
            }
            $css->CerrarSelect();
        print("</td>");
        
        print("<td style='text-align:center'>");
        $enabled=0;
        if($DatosActividad["Estado"]=="EJECUCION"){
            $enabled=1;
        }
        $css->CrearBotonConfirmado2("BtnTerminar", "Terminar", $enabled, "");
        print("</td>");
        $css->CierraFilaTabla();    
        
        $css->CerrarTabla();
        $css->CerrarForm();
        
    }
}

$css->CerrarDiv();//Cerramos contenedor Principal
$css->Footer();
$css->AgregaJS(); //Agregamos javascripts
//$css->AgregaSubir();    
////Fin HTML  
print("</body></html>");


?>