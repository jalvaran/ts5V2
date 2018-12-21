<?php
header('Content-Type: application/json');
$myPage="DatosActividades.php";
include_once("../sesiones/php_control.php");
$obVenta = new ProcesoVenta($idUser);

switch($_GET['q']){
		// Buscar Último Dato
		case 1:
                    $sql="SELECT humedad,temperatura FROM tblsensores ORDER BY id DESC LIMIT 0,1";
		    $Consulta=$obVenta->Query($sql);
                    $Datos=$obVenta->FetchAssoc($Consulta);
                    
                    $json=json_encode($Datos);
                    echo $json;
		break; 
		// Buscar Todos los datos
		default:
			
                    $sql="SELECT humedad,temperatura FROM tblsensores ORDER BY id DESC LIMIT 0,1";
		    $Consulta=$obVenta->Query($sql);
                    $Datos=$obVenta->FetchAssoc($Consulta);
			
                    $json=json_encode($Datos);
                    echo $json;
		break;

}
?>