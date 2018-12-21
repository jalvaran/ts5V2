<?php
$myPage="crono_admin_sesiones.php";
$myTitulo="Control de Sesiones";
include_once("../sesiones/php_control.php");
$FechaActual=date("Y-m-d");
include_once("css_construct.php");
print("<html>");
print("<head>");

$css =  new CssIni($myTitulo);
$obVenta =  new ProcesoVenta($idUser);
print("</head>");
print("<body>");
//Cabecera
include_once("procesadores/procesaSesionAdmin.php");
$css->CabeceraIni($myTitulo); //Inicia la cabecera de la pagina
$css->CreaBotonDesplegable("BtnNuevaSesion", "Crear Nueva Sesion");
$css->CabeceraFin(); 

//Agregamos Cuadros de dialogo

include_once("cuadros_dialogo/cuadros_dialogo.php");

$idSesionConcejo=0;
if(isset($_REQUEST["idSesionConcejo"])){
    $idSesionConcejo=$obVenta->normalizar($_REQUEST["idSesionConcejo"]);
}
///////////////Creamos el contenedor
   
$css->CrearDiv("principal", "container", "left",1,1);
$css->CrearNotificacionAzul("Control de Intervenciones en Sesiones del Honorable Concejo de Buga", 16);
$css->CrearForm2("FrmOtorgarTiempo",$myPage,"post","_self");
$css->CrearTabla();
$css->FilaTabla(16);
$css->ColTabla("<strong>Sesion del Concejo</strong>", 1);
$css->ColTabla("<strong>Honorable Concejal</strong>", 1);
$css->ColTabla("<strong>Tiempo Otorgado</strong>", 1);
$css->ColTabla("<strong>Iniciar</strong>", 1);
$css->CierraFilaTabla();
$css->FilaTabla(16);
print("<td>");

    $VectorSel["Nombre"]="idSesionConcejo";
    $VectorSel["Evento"]="";
    $VectorSel["Funcion"]="";
    $VectorSel["Required"]=1;
    $css->CrearSelect2($VectorSel);
    $css->CrearOptionSelect("","Seleccione una Sesion", $Sel);
    $sql="SELECT * FROM concejo_sesiones WHERE Fecha='$FechaActual'";
    $Datos=$obVenta->Query($sql);
    
    while($DatosSesionConcejo=$obVenta->FetchArray($Datos)){
        $Sel=0;
        if($idSesionConcejo==$DatosSesionConcejo["ID"]){
            $Sel=1;
        }
        $css->CrearOptionSelect($DatosSesionConcejo["ID"], $DatosSesionConcejo["Sesion"], $Sel);
    }
$css->CerrarSelect();
print("</td>");
print("<td>");

    $VectorSel["Nombre"]="idConcejal";
    $VectorSel["Evento"]="";
    $VectorSel["Funcion"]="";
    $VectorSel["Required"]=1;
    $css->CrearSelect2($VectorSel);
    $css->CrearOptionSelect("","Seleccione un Honorable Concejal", $Sel);
    $sql="SELECT * FROM concejales WHERE Fecha_Terminacion >= '$FechaActual'";
    $Datos=$obVenta->Query($sql);
    
    while($DatosConcejal=$obVenta->FetchArray($Datos)){
        
        $css->CrearOptionSelect($DatosConcejal["ID"], $DatosConcejal["Nombre"]." ".$DatosConcejal["ID"], 0);
    }
$css->CerrarSelect();
print("</td>");

print("<td>");

    $VectorSel["Nombre"]="idTiempo";
    $VectorSel["Evento"]="";
    $VectorSel["Funcion"]="";
    $VectorSel["Required"]=1;
    $css->CrearSelect2($VectorSel);
    $css->CrearOptionSelect("","Seleccione los minutos que intervendrá", $Sel);
    
    for($i=0;$i<=60;$i++){
        $css->CrearOptionSelect($i, $i." Minutos", 0);
    }
$css->CerrarSelect();
print("</td>");
print("<td>");
$css->CrearBoton("BtnOtorgarTiempo", "Otorgar Palabra");
print("</td>");
$css->CierraFilaTabla();
$css->CerrarTabla();
$css->CerrarForm();

$css->CerrarDiv();//Cerramos contenedor Principal
$css->CerrarDiv();//Cerramos contenedor Principal
$css->Footer();
$css->AgregaJS(); //Agregamos javascripts
 
////Fin HTML  
print("</body></html>");

ob_end_flush();
?>