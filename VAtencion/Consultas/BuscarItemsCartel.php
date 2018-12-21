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

if($key<>""){
    $css->CrearTabla();

        $sql="SELECT * FROM `productosventa`
		WHERE (`idProductosVenta`='$key' OR Nombre LIKE '%$key%' or Referencia = '$key') and RutaImagen<>'' and RutaImagen<>'0' LIMIT 50";
        $consulta=$obVenta->Query($sql);
        if($obVenta->NumRows($consulta)){
            $css->FilaTabla(16);
            $css->ColTabla("<strong>Imagen</strong>", 1);
            $css->ColTabla("<strong>ID</strong>", 1);
            $css->ColTabla("<strong>Referencia</strong>", 1);
            $css->ColTabla("<strong>Nombre</strong>", 1);
            $css->ColTabla("<strong>Precio</strong>", 1);
            
            $css->CierraFilaTabla();
            while($DatosProducto=$obVenta->FetchArray($consulta)){
                
                    
                    
                        $css->FilaTabla(16);
                        print("<td>");
                        
                        print('<img id="'.$DatosProducto["idProductosVenta"].'" src="../'.$DatosProducto["RutaImagen"].'" draggable="true" ondragstart="drag(event)" width="100px" height="20px">');
                        print("</td>");
                        $css->ColTabla($DatosProducto["idProductosVenta"], 1);
                        $css->ColTabla($DatosProducto["Referencia"], 1);
                        $css->ColTabla($DatosProducto["Nombre"], 1);
                        $css->ColTabla($DatosProducto["PrecioVenta"], 1);
                        $css->CierraFilaTabla();
                    
                    
                    
                    //$css->ColTabla($DatosProducto["RutaImagen"], 1);
                   
                                        
                    
                
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