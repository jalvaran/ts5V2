<?php 
$myPage="modelos_admin.php";
include_once("../sesiones/php_control.php");

include_once("css_construct.php");

$css =  new CssIni("Administracion de modelos");

//css del reloj

print('<style>
    .clockdate-wrapper {
    background-color: #333;
    padding:20px;
    max-width:180px;
    width:100%;
    text-align:center;
    border-radius:5px;
    margin:0 auto;
    margin-top:0%;
}
#clock{
    background-color:#333;
    font-family: sans-serif;
    font-size:40px;
    text-shadow:0px 0px 1px #fff;
    color:#fff;
}
#clock span {
    color:#888;
    text-shadow:0px 0px 1px #333;
    font-size:30px;
    position:relative;
    top:-27px;
    left:-10px;
}
#date {
    letter-spacing:10px;
    font-size:14px;
    font-family:arial,sans-serif;
    color:#fff;
}</style>');


$obVenta =  new ProcesoVenta($idUser);  
$css->CabeceraIni("Administracion de modelos"); 
    
$css->CabeceraFin();

 $ConsultaCajas=$obVenta->ConsultarTabla("cajas", "WHERE idUsuario='$idUser' AND Estado='ABIERTA'");
    $DatosCaja=$obVenta->FetchArray($ConsultaCajas);
    $idCaja=$DatosCaja["ID"];
    if($DatosCaja["ID"]<=0){
       $css->CrearNotificacionRoja("No tiene asignada una Caja, por favor Asignese a una Caja, <a href='HabilitarUser.php' target='_blank'>Vamos</a>", 16);
       exit();
    }  

$css->CrearDiv("Principal", "container", "center", 1, 1);
    $css->CrearTabla();
        $css->FilaTabla(16);
            print("<td>");
                $css->CrearTableChosen("CmbModelos", "modelos_db", "WHERE Estado='A'", "NombreArtistico", "ID", "", "ID", 400, 1, "Selecciona una modelo", "");
            print("</td>");
            print("<td>");
                $css->CrearInputNumber("TxtTarifa", "number", "", "", "Valor Servicio", "", "", "", 200, 40, 0, 1, 10000, "", 1, 'font-size: 16pt;');
            print("</td>");
            print("<td style='text-align:center'>");
                //$css->CrearSelectTable("CmbModelosLiquid", "modelos_db", "WHERE Estado='A'", "ID", "NombreArtistico", "ID", "", "", "", 1);
                //print("<br>");
                $Page="Consultas/modelos_admin.querys.php?Accion=4&"; 
                $funcion="EnvieConsultaModelos(`$Page`,``,`DivAgenda`,`5`);return false;";
                $css->CrearBotonEvento("BtnLiquidar", "Liquidar Modelos", 1, "onclick", $funcion, "naranja", "");
            print("</td>");
            
            print("<td>");
            
                $css->CrearDiv("clockdate", "", "center", 1, 1);
                    $css->CrearDiv("reloj", "clockdate-wrapper", "center", 1, 1);
                        $css->CrearDiv("clock", "", "center", 1, 1);
                        $css->CerrarDiv();
                        $css->CrearDiv("date", "", "center", 1, 1);
                        $css->CerrarDiv();
                    $css->CerrarDiv();
                $css->CerrarDiv();
            
            print("</td>");
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
            print("<td>");
                $Page="Consultas/modelos_admin.querys.php?Tiempo=20&";                
                $funcion="EnvieConsultaModelos(`$Page`,`TxtBuscarSeparado`,`DivAgenda`,`2`);return false;";
                $css->CrearBotonEvento("Btn20", "20 Minutos", 1, "onclick", $funcion, "verde", "");
            print("</td>");
            
            print("<td>");
                $Page="Consultas/modelos_admin.querys.php?Tiempo=30&"; 
                $funcion="EnvieConsultaModelos(`$Page`,`TxtBuscarSeparado`,`DivAgenda`,`2`);return false;";
                $css->CrearBotonEvento("Btn30", "30 Minutos", 1, "onclick", $funcion, "naranja", "");
            print("</td>");
            
            print("<td colspan=3>");
                $Page="Consultas/modelos_admin.querys.php?Tiempo=60&"; 
                $funcion="EnvieConsultaModelos(`$Page`,`TxtBuscarSeparado`,`DivAgenda`,`2`);return false;";
                $css->CrearBotonEvento("Btn1H", "60 Minutos", 1, "onclick", $funcion, "rojo", "");
            print("</td>");
        $css->CierraFilaTabla();
    $css->CerrarTabla();    
$css->CerrarDiv();
$css->CrearDiv("DivAgenda", "container", "center", 1, 1);
$css->CerrarDiv();
$css->AgregaJS(); //Agregamos javascripts

print('<script type="text/javascript" src="jsPages/modelos_admin.js"></script>');

$css->AgregaSubir();
$css->Footer();

ob_end_flush();
?>