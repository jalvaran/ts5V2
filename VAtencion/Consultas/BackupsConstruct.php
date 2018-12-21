<?php
include_once("../../modelo/php_conexion.php");

include_once("../css_construct.php");

$css =  new CssIni("");

function Backup($db,$VectorTraslado){
    $FechaSinc=date("Y-m-d H:i:s"); 
    set_time_limit(1000);
    $obVenta = new ProcesoVenta(1);
    $css =  new CssIni(""); 
    $VectorT["F"]="";
    $Datos=$obVenta->MostrarTablas($db, $VectorT);
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
     
}

if(isset($_REQUEST["LkSubir"])){
    
    $VectorTraslado["LocalHost"]=$host;
    $VectorTraslado["User"]=$user;
    $VectorTraslado["PW"]=$pw;
    $VectorTraslado["DB"]=$db;
    $VectorTraslado["AutoIncrement"]=0;  
    Backup($db,$VectorTraslado);
        
}	
?>