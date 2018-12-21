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
$key=$obVenta->normalizar($_REQUEST['key']);
$myPage=$obVenta->normalizar($_REQUEST['myPage']);
$idSistema=$obVenta->normalizar($_REQUEST['idSistema']);
$TipoBusqueda=$obVenta->normalizar($_REQUEST['TipoItem']);
$PageReturn=$myPage."?idSistema=$idSistema";
if($key<>""){
    $css->CrearTabla();

    if($TipoBusqueda==1){    
        $sql="SELECT * FROM `productosventa` pv INNER JOIN prod_codbarras cb ON pv.idProductosVenta=cb.ProductosVenta_idProductosVenta 
		WHERE pv.`idProductosVenta`='$key' OR pv.Nombre LIKE '%$key%' or pv.Referencia = '$key' OR cb.CodigoBarras LIKE '%$key%' LIMIT 50";
    }else{
      $sql="SELECT * FROM `servicios` pv
		WHERE pv.`idProductosVenta`='$key' OR pv.Nombre LIKE '%$key%' or pv.Referencia = '$key' LIMIT 50";
      
    }    
        $consulta=$obVenta->Query($sql);
        if($obVenta->NumRows($consulta)){
            $css->FilaTabla(16);
            
            $css->ColTabla("<strong>ID</strong>", 1);
            $css->ColTabla("<strong>Referencia</strong>", 1);
            $css->ColTabla("<strong>Nombre</strong>", 1);
            
            $css->ColTabla("<strong>Agregar</strong>", 1);
            $css->CierraFilaTabla();
            while($DatosProducto=$obVenta->FetchArray($consulta)){
                
                    $css->FilaTabla(16);
                    
                    $css->ColTabla($DatosProducto["idProductosVenta"], 1);
                    $css->ColTabla($DatosProducto["Referencia"], 1);
                    $css->ColTabla($DatosProducto["Nombre"], 1);
                    print("<td>");
                        $css->CrearForm2("FrmAgregaItemCompra$DatosProducto[idProductosVenta]", $myPage, "post", "_self");
                        $css->CrearInputText("idSistema", "hidden", "", $idSistema, "", "", "", "", "", "", 0, 0);
                        $css->CrearInputText("idProducto", "hidden", "", $DatosProducto["idProductosVenta"], "", "", "", "", "", "", 0, 0);
                        $css->CrearInputText("TipoItem", "hidden", "", $TipoBusqueda, "", "", "", "", "", "", 0, 0);
                        $css->CrearInputNumber("TxtCantidad", "number", "Cantidad: <br>", 1, "Cantidad", "Black", "", "", 100, 30, 0, 1, 1, "", "any");
                        $css->CrearInputNumber("TxtValor", "number", "<br>ValorUnitario: <br>", $DatosProducto["PrecioVenta"], "Cantidad", "Black", "", "", 100, 30, 0, 1, 1, "", "any");
                        
                        print("<br>");
                        $css->CrearBotonNaranja("BtnAgregarItem", "Agregar");
                        $css->CerrarForm();
                    print("</td>");
                                        
                    $css->CierraFilaTabla();
                
            }
        }else{
            $css->CrearNotificacionRoja("No se encontraron productos relacionados a la busqueda", 16);
        }
    
    
    $css->CerrarTabla();
    
}else{
    $css->CrearNotificacionRoja("Digite un Dato", 16);
}

?>
    
</body>
</html>