<?php 
include_once("../modelo/php_conexion.php");
include_once("../modelo/php_tablas.php");
$obTabla = new Tabla($db);
$obVenta = new ProcesoVenta(1);
 if(isset($_REQUEST["BtnVerInterfaz"])){
        
        $FechaIni=$obVenta->normalizar($_REQUEST["TxtFechaIni"]);
        $FechaFin=$obVenta->normalizar($_REQUEST["TxtFechaFinal"]);
        $TipoInforme=$obVenta->normalizar($_REQUEST["TxtTipoInforme"]);
        $Respuesta=$obTabla->GenereInterfaceIngresosEgresos($TipoInforme,$FechaIni,$FechaFin,"");
        
}

?>