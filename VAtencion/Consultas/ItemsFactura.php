<!DOCTYPE html>
<html>
<head>

</head>
<body>

<?php
session_start();
$idUser=$_SESSION['idUser'];
$TipoUser=$_SESSION['tipouser'];
include_once("../../modelo/php_conexion.php");
include_once("../css_construct.php");

$css =  new CssIni("");
$obVenta = new ProcesoVenta($idUser);
$idCartera=$obVenta->normalizar($_REQUEST['idCartera']);

if($idCartera<>""){
    $css->CrearTabla();
    $css->FilaTabla(12);
        $css->ColTabla("<strong>REFERENCIA</strong>", 1);
        $css->ColTabla("<strong>NOMBRE</strong>", 1);
        $css->ColTabla("<strong>VALOR UNITARIO</strong>", 1);
        $css->ColTabla("<strong>CANTIDAD</strong>", 1);
        $css->ColTabla("<strong>SUBTOTAL</strong>", 1);
        $css->ColTabla("<strong>IVA</strong>", 1);
        $css->ColTabla("<strong>TOTAL</strong>", 1);
    $css->CierraFilaTabla();
    $sql="SELECT Facturas_idFacturas FROM cartera WHERE idCartera='$idCartera'";
    $Consulta=$obVenta->Query($sql);
    $DatosCartera=$obVenta->FetchArray($Consulta);
    $idFactura=$DatosCartera["Facturas_idFacturas"];
    $sql="SELECT Referencia,Nombre,ValorUnitarioItem,Cantidad,SubtotalItem,IVAItem,TotalItem FROM facturas_items "
            . " WHERE idFactura='$idFactura' LIMIT 100";
    $Consulta=$obVenta->Query($sql);
    while ($DatosFactura=$obVenta->FetchArray($Consulta)){
        $css->FilaTabla(12);
            $css->ColTabla($DatosFactura["Referencia"], 1);
            $css->ColTabla($DatosFactura["Nombre"], 1);
            $css->ColTabla($DatosFactura["ValorUnitarioItem"], 1);
            $css->ColTabla($DatosFactura["Cantidad"], 1);
            $css->ColTabla($DatosFactura["SubtotalItem"], 1);
            $css->ColTabla($DatosFactura["IVAItem"], 1);
            $css->ColTabla($DatosFactura["TotalItem"], 1);
        $css->CierraFilaTabla();
        
    }
    $css->CerrarTabla();
    
    
}else{
    $css->CrearNotificacionRoja("Sin Datos de la Cartera", 16);
}

?>
    
</body>
</html>