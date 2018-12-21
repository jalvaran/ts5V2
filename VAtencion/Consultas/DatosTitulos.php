<!DOCTYPE html>
<html>
<head>

</head>
<body>

<?php
$Titulo = intval($_GET['Titulo']);

$myPage="DatosTitulos.php";
include_once("../../modelo/php_conexion.php");
include_once("../css_construct.php");

$css =  new CssIni("");
$obVenta = new ProcesoVenta(1);
$Promocion=$obVenta->normalizar($_GET['idPromocion']);

if($Promocion>1){
    $TablaTitulos="titulos_listados_promocion_".$Promocion;
    $DatosTitulo=$obVenta->DevuelveValores($TablaTitulos,"Mayor1",$Titulo);

    $css->CrearNotificacionAzul("Datos del Titulo", 16);
    $css->CrearTabla();
    
    $css->FilaTabla(16);
    $css->ColTabla('<strong>Mayor2</strong>', 1);
    $css->ColTabla('<strong>Adicional</strong>', 1);
    $css->ColTabla('<strong>NombreColaborador</strong>', 1);
    $css->ColTabla('<strong>FechaEntregaColaborador</strong>', 1);
    $css->ColTabla('<strong>NombreCliente</strong>', 1);
    $css->ColTabla('<strong>idVenta</strong>', 1);
    $css->ColTabla('<strong>FechaVenta</strong>', 1);
    $css->ColTabla('<strong>Saldo</strong>', 1);
    

    $css->CierraFilaTabla();
    
    $css->FilaTabla(16);
    $css->ColTabla($DatosTitulo['Mayor2'], 1);
    $css->ColTabla($DatosTitulo['Adicional'], 1);
    $css->ColTabla($DatosTitulo['NombreColaborador'], 1);
    $css->ColTabla($DatosTitulo['FechaEntregaColaborador'], 1);
    $css->ColTabla($DatosTitulo['NombreCliente'], 1);
    $Consulta=$obVenta->ConsultarTabla("titulos_ventas", " WHERE Promocion='$Promocion' AND Mayor1='$DatosTitulo[Mayor1]'");
    $DatosVenta=$obVenta->FetchArray($Consulta);
    $css->ColTabla($DatosVenta['ID'], 1);
    $css->ColTabla($DatosTitulo['FechaVenta'], 1);
    $css->ColTabla($DatosTitulo['Saldo'], 1);

    $css->CierraFilaTabla();
    $css->CerrarTabla();
}else{
    $css->CrearNotificacionRoja("Seleccione una Promocion", 16);
}

?>
</body>
</html>