<script src="js/funciones.js"></script>
<?php
print("<meta http-equiv='refresh' content='60' />");
include_once("../modelo/php_conexion.php");
include_once("css_construct.php");

print("<div>");
$obVenta = new ProcesoVenta(1);
$css =  new CssIni("s");
$TipoConsulta=$obVenta->normalizar($_REQUEST["Tipo"]);


$StatusIntervencion="Inactivo";
if($_REQUEST["Tipo"]=="Cronometro"){
    $Color="blue";
    $DatosCrono=$obVenta->DevuelveValores("crono_controles", "ID", 1);
    $HoraActual=date("Y-m-d H:i:s");
    $HoraFin=  date("Y-m-d ").$DatosCrono["Fin"];
    $HoraCrono='00:00';
    $datetime1 = new DateTime($HoraActual);
    $datetime2 = new DateTime($HoraFin);
   
    
    //print('<BUTTON onClick="beep()">Beep!</BUTTON>');
    if($DatosCrono["Estado"]=="PLAY"){
        $Diff=$datetime2->diff($datetime1);
    
        if($datetime1 > $datetime2){
            $HoraCrono='00:00';
            $Color="red";
        }else{
            $HoraCrono=str_pad($Diff->i,2,"0",STR_PAD_LEFT).":".str_pad($Diff->s,2,"0",STR_PAD_LEFT);
            if($HoraCrono <= "00:15"){
                $Color="orange";
                print("<script>beep();</script>");
            }
        }
        $StatusIntervencion="Activo";
        $DatosConcejal=$obVenta->DevuelveValores("concejales", "ID", $DatosCrono["idConcejal"]);
    }
    
    if($DatosCrono["Estado"]=="REINICIO"){
        
        $StatusIntervencion="Inactivo";
        $DatosConcejal=$obVenta->DevuelveValores("concejales", "ID", $DatosCrono["idConcejal"]);
        $Color="red";
    }
    
    if($datetime1>=$datetime2 and $DatosCrono["Estado"]=="PLAY"){
        
        $StatusIntervencion="Finalizada"; 
        $obVenta->ActualizaRegistro("crono_controles", "Estado", "REINICIO", "ID", 1);
    }
    
    print("<div style=' font: 400px sans-serif;color:$Color'>$HoraCrono</div>");
    
    
    
    $css->CrearTabla();
   
    
    
    $css->FilaTabla(30);
    $css->ColTabla("<strong>Status</strong>", 1);
    $css->ColTabla("<strong>$DatosConcejal[Cargo]</strong>", 2);
    $css->ColTabla("<strong>Limite</strong>", 1);
    
    $css->CierraFilaTabla();
    $css->FilaTabla(30);
    $css->ColTabla($StatusIntervencion, 1);
    $css->ColTabla($DatosConcejal["Nombre"], 2);
    $css->ColTabla($DatosCrono["Fin"], 1);
    $css->CierraFilaTabla();
    $css->CerrarTabla();
    print("</div>");
}

?>