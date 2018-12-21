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
$idDepartamento=0;
$statement="";
$idMesa=0;
if(isset($_REQUEST['idMesa'])){
    $idMesa=$obVenta->normalizar($_REQUEST['idMesa']);
    
}

if(isset($_REQUEST['st'])){
    
    $statement= base64_decode($_REQUEST['st']);
    //print($statement);
}
if(isset($_REQUEST['idDepartamento'])){
    $idDepartamento=$obVenta->normalizar($_REQUEST['idDepartamento']);
    $statement=" productosventa WHERE Departamento=$idDepartamento";
}
if(isset($_REQUEST["TxtBusqueda"])){
    $key=$obVenta->normalizar($_REQUEST["TxtBusqueda"]);
    $statement=" productosventa WHERE Nombre LIKE '%$key%' or idProductosVenta='$key' or Referencia LIKE '%$key%' ";
}       
if(isset($_REQUEST['Page'])){
    $NumPage=$obVenta->normalizar($_REQUEST['Page']);
}else{
    $NumPage=1;
}
if($statement<>""){
    if($idMesa==0){
        $css->CrearNotificacionNaranja("Debes Seleccionar una Mesa", 16);
        exit();
    }
    $css->CrearNotificacionAzul("Agregar a la Mesa $idMesa", 16);
    $css->CrearTabla();
    $limit = 50;
    $startpoint = ($NumPage * $limit) - $limit;
    
    $query = "SELECT COUNT(*) as `num` FROM {$statement}";
    $row = $obVenta->FetchArray($obVenta->Query($query));
    $ResultadosTotales = $row['num'];
     
        $sql=" SELECT Nombre, idProductosVenta,Referencia,RutaImagen,PrecioVenta FROM $statement ORDER BY Nombre LIMIT $startpoint,$limit";
        $consulta=$obVenta->Query($sql);
        $Resultados=$obVenta->NumRows($consulta);
        if($Resultados){
            $st= base64_encode($statement);
            if($ResultadosTotales>$limit){
                
                $css->FilaTabla(16);
                print("<td colspan='2'>");
                if($NumPage>1){
                    $NumPage1=$NumPage-1;
                    $Page="Consultas/BuscarItemsPedido.php?st=$st&Page=$NumPage1&Carry=";
                    $FuncionJS="EnvieObjetoConsulta(`$Page`,`idDepartamento`,`DivBusquedaItems`,`7`);return false ;";
                    
                    $css->CrearBotonEvento("BtnMas", "Page $NumPage1", 1, "onclick", $FuncionJS, "rojo", "");
                    
                }
                print("</td>");
                print("<td>");
                print("<strong>Pagina $NumPage</strong>");
                print("</td>");
                print("<td colspan='2'>");
                if($ResultadosTotales>($startpoint+$limit)){
                    $NumPage1=$NumPage+1;
                    $Page="Consultas/BuscarItemsPedido.php?st=$st&Page=$NumPage1&Carry=";
                    $FuncionJS="EnvieObjetoConsulta(`$Page`,`idDepartamento`,`DivBusquedaItems`,`7`);return false ;";
                    $css->CrearBotonEvento("BtnMas", "Page $NumPage1", 1, "onclick", $FuncionJS, "verde", "");
                }
                print("</td>");
               $css->CierraFilaTabla(); 
            }
            $css->FilaTabla(16);
            $css->ColTabla("<strong>Imagen</strong>", 1);
            $css->ColTabla("<strong>ID</strong>", 1);
            $css->ColTabla("<strong>Referencia</strong>", 1);
            $css->ColTabla("<strong>Nombre</strong>", 1);
            $css->ColTabla("<strong>Precio</strong>", 1);
            
            $css->CierraFilaTabla();
            while($DatosProducto=$obVenta->FetchArray($consulta)){
                
                    
                    
                $css->FilaTabla(16);
                $ImageAlterna="../images/productoalterno.png";
                $RutaImage="../".$DatosProducto["RutaImagen"];
                
                print("<td>");
                $idItem=$DatosProducto["idProductosVenta"];
                $Nombre="ImgAdd".$idItem;
                $Page="Consultas/ItemsPedido.php?BtnAgregarItem=1&idMesa=$idMesa&idItem=$idItem&Carry=";
                $FuncionJS="onclick='EnvieObjetoConsulta(`$Page`,`TxtObservacionesItem`,`DivItemsPedido`,`8`);return false ;'";
                $css->CrearImage($Nombre, $RutaImage, $ImageAlterna, 100, 130,$FuncionJS);
                print("</td>");
                $css->ColTabla($DatosProducto["idProductosVenta"], 1);
                $css->ColTabla($DatosProducto["Referencia"], 1);
                $css->ColTabla($DatosProducto["Nombre"], 1);
                $css->ColTabla(number_format($DatosProducto["PrecioVenta"]), 1);
                $css->CierraFilaTabla();
            }
            if($ResultadosTotales>$limit){
                
                $css->FilaTabla(16);
                print("<td colspan='2'>");
                if($NumPage>1){
                    $NumPage1=$NumPage-1;
                    $Page="Consultas/BuscarItemsPedido.php?st=$st&Page=$NumPage1&Carry=";
                    $FuncionJS="EnvieObjetoConsulta(`$Page`,`idDepartamento`,`DivBusquedaItems`,`7`);return false ;";
                    
                    $css->CrearBotonEvento("BtnMas", "Page $NumPage1", 1, "onclick", $FuncionJS, "rojo", "");
                    
                }
                print("</td>");
                print("<td>");
                print("<strong>Pagina $NumPage</strong>");
                print("</td>");
                print("<td colspan='2'>");
                
                if($ResultadosTotales>($startpoint+$limit)){
                    $NumPage1=$NumPage+1;
                    $Page="Consultas/BuscarItemsPedido.php?st=$st&Page=$NumPage1&Carry=";
                    $FuncionJS="EnvieObjetoConsulta(`$Page`,`idDepartamento`,`DivBusquedaItems`,`7`);return false ;";
                    $css->CrearBotonEvento("BtnMas", "Page $NumPage1", 1, "onclick", $FuncionJS, "verde", "");
                }
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