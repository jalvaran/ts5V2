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

$TipoBusqueda=$obVenta->normalizar($_REQUEST['TipoItem']);

if($key<>""){
    $css->CrearTabla();

    if($TipoBusqueda==1){    
      $sql="SELECT * FROM `productosventa` pv INNER JOIN prod_codbarras cb ON pv.idProductosVenta=cb.ProductosVenta_idProductosVenta 
		WHERE pv.`idProductosVenta`='$key' OR pv.Nombre LIKE '%$key%' or pv.Referencia = '$key' OR cb.CodigoBarras LIKE '%$key%' LIMIT 50";
    }
    if($TipoBusqueda==2){   
      $sql="SELECT * FROM `servicios` pv
		WHERE pv.`idProductosVenta`='$key' OR pv.Nombre LIKE '%$key%' or pv.Referencia = '$key' LIMIT 50";
      
    }
    if($TipoBusqueda==3){   
      $sql="SELECT * FROM `sistemas`
		WHERE `ID`='$key' OR Nombre LIKE '%$key%' LIMIT 50";
      
    } 
    if($TipoBusqueda==4){   
      $sql="SELECT * FROM `productosalquiler` pv
		WHERE pv.`idProductosVenta`='$key' OR pv.Nombre LIKE '%$key%' or pv.Referencia = '$key' LIMIT 50";
      
    } 
        $consulta=$obVenta->Query($sql);
        if($obVenta->NumRows($consulta)){
            $css->FilaTabla(16);
            
            $css->ColTabla("<strong>ID</strong>", 1);
            if($TipoBusqueda<>3){
                $css->ColTabla("<strong>Referencia</strong>", 1);
            }
            $css->ColTabla("<strong>Nombre</strong>", 1);
            if($TipoBusqueda==3){
                $css->ColTabla("<strong>Observaciones</strong>", 1);
            }
            $css->ColTabla("<strong>Agregar</strong>", 1);
            $css->CierraFilaTabla();
            while($DatosProducto=$obVenta->FetchArray($consulta)){
                
                    $css->FilaTabla(16);
                    
                    if($TipoBusqueda<>3){
                        $css->ColTabla($DatosProducto["idProductosVenta"], 1);
                        $css->ColTabla($DatosProducto["Referencia"], 1);
                        $idProducto=$DatosProducto["idProductosVenta"];
                        $PrecioVenta=$DatosProducto["PrecioVenta"];
                        $DesHabilitaPrecio=0;
                    }else{
                        $DesHabilitaPrecio=1;
                        $idProducto=$DatosProducto["ID"];
                        $PrecioVenta=$obVenta->Sume("vista_sistemas", "PrecioVenta", "WHERE idSistema='$idProducto'");
                        $css->ColTabla($DatosProducto["ID"], 1);
                    }
                    $css->ColTabla($DatosProducto["Nombre"], 1);
                    if($TipoBusqueda==3){
                        $css->ColTabla($DatosProducto["Observaciones"], 1);
                    }
                    print("<td>");
                        $css->CrearForm2("FrmAgregaItemCotizacion$idProducto", $myPage, "post", "_self");
                        //$css->CrearInputText("TxtIdCliente", "hidden", "", $idCliente, "", "", "", "", "", "", 0, 0);
                        $css->CrearInputText("idProducto", "hidden", "", $idProducto, "", "", "", "", "", "", 0, 0);
                        $css->CrearInputText("TipoItem", "hidden", "", $TipoBusqueda, "", "", "", "", "", "", 0, 0);
                        $css->CrearInputNumber("TxtCantidad", "number", "Cantidad: <br>", 1, "Cantidad", "Black", "", "", 100, 30, 0, 1, 1, "", "any");
                        $css->CrearInputNumber("TxtValor", "number", "<br>ValorUnitario: <br>", $PrecioVenta, "Valor Unitario", "Black", "", "", 100, 30, $DesHabilitaPrecio, 1, 1, "", "any");
                        
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