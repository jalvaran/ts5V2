<?php 
$myPage="traslados_mercancia.php";
include_once("../sesiones/php_control.php");
include_once("css_construct.php");

$sql="";
$myPage="DescargarTraslados.php";
if(isset($_REQUEST["LkBajar"])){
    $VectorTraslado["LocalHost"]=$host;
    $VectorTraslado["User"]=$user;
    $VectorTraslado["PW"]=$pw;
    $VectorTraslado["DB"]=$db;
    $Mensaje=$obVenta->DescargarTraslado(1,$VectorTraslado);
    header("location:$myPage");
}	

print("<html>");
print("<head>");
$css =  new CssIni("Descargar Traslados de Mercancia desde la Nube");

print("</head>");
print("<body>");
    
    //include_once("procesadores/ProcesaCreaTraslado.php");
    
    $css->CabeceraIni("Descargar Traslados desde la Nube"); //Inicia la cabecera de la pagina
   
    $css->CabeceraFin(); 
    
    
    ///////////////Creamos el contenedor
    /////
    /////
     
     
    $css->CrearDiv("principal", "container", "center",1,1);
    $DatosSucursal=$obVenta->DevuelveValores("empresa_pro_sucursales", "Actual", 1);
    $DatosServer=$obVenta->DevuelveValores("servidores", "ID", 1);
    $VectorCon["Fut"]=0;  //$DatosServer["IP"]
    
    $Mensaje=$obVenta->ConToServer($DatosServer["IP"], $DatosServer["Usuario"], $DatosServer["Password"], $DatosServer["DataBase"], $VectorCon);
    $css->CrearNotificacionNaranja($Mensaje, 16);
    //$css->CrearNotificacionAzul($sql, 16);
    print("<strong>Click para Descargar</strong><br>");
    $css->CrearImageLink($myPage."?LkBajar=1", "../images/descargar.png", "_self", 200, 200);
    //$obVenta->ConToServer($host,$user,$pw,$db,$VectorCon);
    $css->CrearDiv("Secundario", "container", "center",1,1);
    $css->Creartabla();
    $css->CrearNotificacionNaranja("TRASLADOS PENDIENTES POR DESCARGAR", 16);
    $consulta=$obVenta->ConsultarTabla("traslados_mercancia", "WHERE DestinoSincronizado ='0000-00-00 00:00:00' AND Destino='$DatosSucursal[ID]' AND Estado='PREPARADO'");
    if($obVenta->NumRows($consulta)){
        $css->FilaTabla(16);
        $css->ColTabla("<strong>ID</strong>", 1);
        $css->ColTabla("<strong>Fecha</strong>", 1);
        $css->ColTabla("<strong>Destino</strong>", 1);
        $css->ColTabla("<strong>Descripcion</strong>", 1);
        $css->ColTabla("<strong>Usuario</strong>", 1);
        $css->CierraFilaTabla();
        while($DatosTraslados=$obVenta->FetchArray($consulta)){
            $css->FilaTabla(16);
            $css->ColTabla($DatosTraslados["ID"], 1);
            $css->ColTabla($DatosTraslados["Fecha"], 1);
            $DatosSucursal=$obVenta->DevuelveValores("empresa_pro_sucursales", "ID", $DatosTraslados["Destino"]);
            $css->ColTabla($DatosSucursal["Nombre"], 1);
            $css->ColTabla($DatosTraslados["Descripcion"], 1);
            $css->ColTabla($DatosTraslados["Abre"], 1);
            $css->CierraFilaTabla();
        }
    }else{
        $css->CrearFilaNotificacion("No hay traslados pendientes por descargar", 16);
    }   
    
    $css->CerrarTabla();
    $css->CerrarDiv();//Cerramos contenedor Secundario
    $css->CerrarDiv();//Cerramos contenedor Principal
    $css->AgregaJS(); //Agregamos javascripts
    $css->AgregaSubir();
    $css->AnchoElemento("CmbDestino_chosen", 200);
    $css->AnchoElemento("CmbCuentaDestino_chosen", 200);
    print("</body></html>");
    ob_end_flush();
?>