<!DOCTYPE html>
<html>
<head>

</head>
<body>

<?php
$Valida = intval($_GET['Valida']);

$myPage="DatosAuditoria.php";
include_once("../../modelo/php_conexion.php");
include_once("../../modelo/php_tablas.php");
include_once("../css_construct.php");

$css =  new CssIni("");
$obVenta = new ProcesoVenta(1);
$Valida=$obVenta->normalizar($_GET['Valida']);

if($Valida==1){
    
    $sql="SELECT SUM(`Neto`) as Total, `Tipo_Documento_Intero`,`Num_Documento_Interno` FROM `librodiario` "
            . " GROUP BY `Tipo_Documento_Intero`,`Num_Documento_Interno` ORDER BY SUM(`Neto`) DESC LIMIT 100";
    $consulta=$obVenta->Query($sql);
    if($obVenta->NumRows($consulta)){
        $css->CrearNotificacionRoja("Documentos encontrados", 16);
        $css->CrearTabla();
        $css->FilaTabla(16);
        $css->ColTabla('<strong>Tipo De Documento</strong>', 1);
        $css->ColTabla('<strong>Numero</strong>', 1);
        $css->ColTabla('<strong>Diferencia</strong>', 1);
        $css->ColTabla('<strong>Corregir</strong>', 1);
        $css->CierraFilaTabla();
        
        while($DatosDocumento=$obVenta->FetchArray($consulta)){
            if($DatosDocumento["Total"]>(0.01) or $DatosDocumento["Total"]<(-0.01)){
                
                $css->FilaTabla(16);
                $css->ColTabla($DatosDocumento["Tipo_Documento_Intero"], 1);
                $css->ColTabla($DatosDocumento["Num_Documento_Interno"], 1);
                $css->ColTabla($DatosDocumento["Total"], 1);
                print("<td>");
                $link="CorregirLibro.php?TipoDoc=$DatosDocumento[Tipo_Documento_Intero]&NumDoc=$DatosDocumento[Num_Documento_Interno]";
                $css->CrearLink($link, "_blank", "Corregir");
                print("</td>");
                $css->CierraFilaTabla();
            }
        }
        $css->CerrarTabla();
        
    }else{
        $css->CrearNotificacionVerde("No hay documentos sin balance", 16);
    }
    
}else{
    $css->CrearNotificacionRoja("No se ha recibido un parametro valido", 16);
}

?>
</body>
</html>