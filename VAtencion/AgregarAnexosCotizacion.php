<?php 
$myPage="AgregarAnexosCotizacion.php";
include_once("../sesiones/php_control.php");
include_once("css_construct.php");
$obVenta=new ProcesoVenta($idUser);
//////Si recibo una Cotizacion
$idCotizacion="";
if(!empty($_REQUEST['idCotizacion'])){
   $idCotizacion=$obVenta->normalizar($_REQUEST['idCotizacion']);
}

	
print("<html>");
print("<head>");
$css =  new CssIni("Anexos Cotizaciones");

print("</head>");
print("<body>");
    
    include_once("procesadores/ProcesaAgregarAnexos.php");
    
    $css->CabeceraIni("Anexos Cotizacion $idCotizacion"); //Inicia la cabecera de la pagina
       
    $css->CabeceraFin(); 
    ///////////////Creamos el contenedor
    /////
    /////
    $css->CrearDiv("principal", "container", "center",1,1);
   
    $css->CrearDiv("Secundario", "container", "center",1,1);
    if($idCotizacion>0){
        $css->CrearNotificacionVerde("Agregar un Anexo a la Cotizacion No. $idCotizacion", 16);
        $css->CrearForm2("FrmAgregarAnexo", $myPage, "post", "_self");
        $css->CrearInputText("idCotizacion", "hidden", "", $idCotizacion, "", "", "", "", "", "", 0, 1);
        $css->CrearInputText("TxtTitulo", "text", "", "", "Titulo", "", "", "", 400, 30, 0, 1);
        $css->CrearTextAreaEnriquecida("TxtAnexo", "", "", "", "", "", "", "", "", 0, 1, "");
        $css->CrearBotonConfirmado("BtnAgregarAnexo", "Agregar");
        $css->CerrarForm();
        $css->CrearDiv("DivAnexos", "", "left", 1, 1);
        $Consulta=$obVenta->ConsultarTabla("cotizaciones_anexos", "WHERE NumCotizacion='$idCotizacion'");
        while($DatosAnexos=$obVenta->FetchArray($Consulta)){
            $css->CrearNotificacionNaranja($DatosAnexos["Titulo"], 16);
            print($DatosAnexos["Anexo"]);
        }
        $css->CerrarDiv();
    }else{
        $css->CrearNotificacionRoja("No se selecciono una Cotizacion", 16);
    }							
   	
    
    $css->CerrarDiv();//Cerramos contenedor Secundario
    $css->CerrarDiv();//Cerramos contenedor Principal
    $css->Footer();
    $css->AgregaJS(); //Agregamos javascripts
    $css->AgregaSubir();
    $css->IniTextoEnriquecido();
    
    print("</body></html>");
?>