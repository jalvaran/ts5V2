<?php 
$myPage="backups.php";
include_once("../sesiones/php_control.php");
include_once("css_construct.php");

$obTabla = new Tabla($db);
$sql="";



print("<html>");
print("<head>");
$css =  new CssIni("Realizar Backup en la Nube");

print("</head>");
print("<body>");
    
    if(isset($_REQUEST["LkSubir"])){
    $FechaSinc=date("Y-m-d H:i:s");
    $VectorTraslado["LocalHost"]=$host;
    $VectorTraslado["User"]=$user;
    $VectorTraslado["PW"]=$pw;
    $VectorTraslado["DB"]=$db;
    $VectorTraslado["AutoIncrement"]=0;
    $VectorT["F"]="";
    $Datos=$obVenta->MostrarTablas($db, $VectorT);
    set_time_limit(600);
    
    while($TablasBackup=$obVenta->FetchArray($Datos)){
        $Mensaje="";
        $nombre=explode("_", $TablasBackup[0]);
        if($nombre[0]<>"vista"){
            $VectorTraslado["Tabla"]=$TablasBackup[0];
            $Mensaje=$obVenta->CrearBackup(2,$VectorTraslado);
            if($Mensaje<>"SA"){

                $css->CrearNotificacionNaranja($Mensaje, 16);
            }    
        }
    }
     
     
    $Mensaje="No se encontraron mas datos para sincronizar";
    
}	
    
    $css->CabeceraIni("Realizar Backup en la Nube"); //Inicia la cabecera de la pagina
   
    $css->CabeceraFin(); 
    
    
    ///////////////Creamos el contenedor
    /////
    /////
     
     
    $css->CrearDiv("principal", "container", "center",1,1);
    $css->CrearDiv("DivNotificaciones", "", "center", 1, 1);
        
    $css->CerrarDiv();
    $DatosServer=$obVenta->DevuelveValores("servidores", "ID", 1);
    $VectorCon["Fut"]=0;  //$DatosServer["IP"]
    
    $Mensaje=$obVenta->ConToServer($DatosServer["IP"], $DatosServer["Usuario"], $DatosServer["Password"], $DatosServer["DataBase"], $VectorCon);
    $css->CrearNotificacionAzul($Mensaje, 16);
    //$css->CrearNotificacionAzul($sql, 16);
    print("<strong>Click para Realizar el procedimiento</strong><br>");
    $RutaImage="../images/backup.png";
    $Page="Consultas/BackupsConstruct.php?LkSubir=1&Carry=";
    $Nombre="ImgBackups";
    $FuncionJS="onclick='EnvieObjetoConsulta(`$Page`,`ImgBackups`,`DivNotificaciones`,`5`);return false ;'";
    $css->CrearImage($Nombre, $RutaImage, $RutaImage, 200, 200,$FuncionJS);
     
    $obVenta->ConToServer($host,$user,$pw,$db,$VectorCon);
    $css->CrearDiv("Secundario", "container", "center",1,1);
    $css->Creartabla();
    $css->CrearNotificacionVerde("TABLAS DISPONIBLES PARA REALIZAR BACKUP", 16);
    $VectorT["F"]="";
    $consulta=$obVenta->MostrarTablas($db, $VectorT);
    if($obVenta->NumRows($consulta)){
        $css->FilaTabla(16);
        $css->ColTabla("<strong>Num</strong>", 1);
        $css->ColTabla("<strong>Tabla</strong>", 1);
        
        $css->CierraFilaTabla();
        $i=0;
        while($DatosTablas=$obVenta->FetchArray($consulta)){
            $i++;
            $css->FilaTabla(16);
            $css->ColTabla($i, 1);
            $css->ColTabla($DatosTablas[0], 1);
            
            $css->CierraFilaTabla();
        }
    }else{
        $css->CrearFilaNotificacion("No hay Datos pendientes por subir", 16);
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