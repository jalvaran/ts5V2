<!DOCTYPE html>
<html>
<head>

</head>
<body>

<?php
session_start();
$idUser=$_SESSION['idUser'];
$TipoUser=$_SESSION['tipouser'];
$myPage="VentasRapidasV2.php";
include_once("../../modelo/php_conexion.php");
include_once("../css_construct.php");

$css =  new CssIni("");
$obVenta = new ProcesoVenta($idUser);
$key=$obVenta->normalizar($_REQUEST['key']);
$myPage=$obVenta->normalizar($_REQUEST['myPage']);
$idPreventa=$obVenta->normalizar($_REQUEST['CmbPreVentaAct']);
$PageReturn=$myPage."?CmbPreVentaAct=$idPreventa&TxtAgregarItemPreventa=";
if($key<>""){
 $css->CrearDivBusquedas("BuscarItems", "", "left", 1, 1);
 $css->CrearTabla();
    $tab="productosventa";
    $Condicion=" WHERE idProductosVenta='$key' OR Nombre LIKE '%$key%' OR Referencia LIKE '%$key%' LIMIT 50";
    $consulta=$obVenta->ConsultarTabla($tab,$Condicion);
    if($obVenta->NumRows($consulta)){
        $css->FilaTabla(16);
        $css->ColTabla("<strong>Agregar</strong>", 1);
        $css->ColTabla("<strong>ID</strong>", 1);
            $css->ColTabla("<strong>Referencia</strong>", 1);
            $css->ColTabla("<strong>Nombre</strong>", 1);
            $css->ColTabla("<strong>PrecioVenta</strong>", 1);
            $css->ColTabla("<strong>Mayorista</strong>", 1);
            $css->ColTabla("<strong>Existencias</strong>", 1);
            $css->CierraFilaTabla();
        while($DatosProducto=$obVenta->FetchArray($consulta)){
            $css->FilaTabla(16);
             print("<td>");
            $css->CrearForm2("Frm$tab$DatosProducto[idProductosVenta]", $myPage, "post", "_self");
            $css->CrearInputText("CmbPreVentaAct", "hidden", "", $idPreventa, "", "", "", "", "", "", 0, 0);
            $css->CrearInputText("TxtTablaItem", "hidden", "", $tab, "", "", "", "", "", "", 0, 0);
            $css->CrearInputText("TxtAgregarItemPreventa", "hidden", "", $DatosProducto["idProductosVenta"], "", "", "", "", "", "", 0, 0);
            $CantidadPre=1;
            $DatosCajas=$obVenta->DevuelveValores("cajas", "idUsuario", $idUser);
            $idBascula=$DatosCajas["idBascula"];
            $sql="SELECT Gramos FROM registro_basculas WHERE idBascula='$idBascula' AND Leido=0";
            $DatosBascula=$obVenta->Query($sql);
            $DatosBascula=$obVenta->FetchArray($DatosBascula);
            if($DatosBascula["Gramos"]<>"" and $DatosBascula["Gramos"]>0){
                $CantidadPre=$DatosBascula["Gramos"];
            }
            $css->CrearInputNumber("TxtCantidad", "number", "", $CantidadPre, "Cantidad", "", "", "", 100, 30, 0, 1, 0, "", "any");
            
            if($myPage<>'VentasRapidasV2.php'){
                $css->CrearInputNumber("TxtMultiplicador", "number", "X", 1, "Dias", "", "", "", 100, 30, 0, 1, 0, "", "any");
            }
            if($DatosProducto["Especial"]=="SI"){
                    print(" //Precio: ");
                    $css->CrearInputNumber("TxtValorAcordadoBascula", "number", "", "1", "Precio de Venta", "", "", "", 100, 30, 0, 0, 50, "", "1");
                }
            $css->CrearBotonNaranja("BtnAgregar", "Agregar");
            $css->CerrarForm();
            //$target="$PageReturn$DatosProducto[idProductosVenta]&TxtTablaItem=$tab";
            //$css->CrearLink($target, "_self", "Agregar");
            print("</td>");
            $css->ColTabla($DatosProducto["idProductosVenta"], 1);
            $css->ColTabla($DatosProducto["Referencia"], 1);
            $css->ColTabla($DatosProducto["Nombre"], 1);
            print("<td>");
                
                print($DatosProducto["PrecioVenta"]);
                
                
            print("</td>");
            $css->ColTabla($DatosProducto["PrecioMayorista"], 1);
            $css->ColTabla($DatosProducto["Existencias"], 1);
           
            $css->CierraFilaTabla();
        }
    }
    
    $tab="servicios";
    $Condicion=" WHERE idProductosVenta='$key' OR Nombre LIKE '%$key%' OR Referencia LIKE '%$key%'";
    $consulta=$obVenta->ConsultarTabla($tab,$Condicion);
    if($obVenta->NumRows($consulta)){
        
        while($DatosProducto=$obVenta->FetchArray($consulta)){
            $css->FilaTabla(16);
             print("<td>");
            //$target="$PageReturn$DatosProducto[idProductosVenta]&TxtTablaItem=$tab&TxtCantidad=1";
            //$css->CrearLink($target, "_self", "Agregar");
			$css->CrearForm2("Frm$tab$DatosProducto[idProductosVenta]", $myPage, "post", "_self");
            $css->CrearInputText("CmbPreVentaAct", "hidden", "", $idPreventa, "", "", "", "", "", "", 0, 0);
            $css->CrearInputText("TxtTablaItem", "hidden", "", $tab, "", "", "", "", "", "", 0, 0);
            $css->CrearInputText("TxtAgregarItemPreventa", "hidden", "", $DatosProducto["idProductosVenta"], "", "", "", "", "", "", 0, 0);
            
            $css->CrearInputNumber("TxtCantidad", "number", "", 1, "Cantidad", "", "", "", 100, 30, 0, 1, 0, "", "any");
            if($myPage<>'VentasRapidasV2.php'){
                $css->CrearInputNumber("TxtMultiplicador", "number", "X", 1, "Dias", "", "", "", 100, 30, 0, 1, 0, "", "any");
            }
            $css->CrearBotonNaranja("BtnAgregar", "Agregar");
            $css->CerrarForm();
            print("</td>");
            $css->ColTabla($DatosProducto["idProductosVenta"], 1);
            $css->ColTabla($DatosProducto["Referencia"], 1);
            $css->ColTabla($DatosProducto["Nombre"], 1);
            print("<td>");
                print($DatosProducto["PrecioVenta"]);
            print("</td>");
            //$css->ColTabla($DatosProducto["PrecioVenta"], 1);
            $css->ColTabla($DatosProducto["PrecioMayorista"], 1);
            //$css->ColTabla($DatosProducto["Existencias"], 1);
           
            $css->CierraFilaTabla();
        }
    }
    
    $tab="productosalquiler";
    $Condicion=" WHERE idProductosVenta='$key' OR Nombre LIKE '%$key%' OR Referencia LIKE '%$key%'";
    $consulta=$obVenta->ConsultarTabla($tab,$Condicion);
    if($obVenta->NumRows($consulta)){
        
        while($DatosProducto=$obVenta->FetchArray($consulta)){
            $css->FilaTabla(16);
             print("<td>");
            //$target="$PageReturn$DatosProducto[idProductosVenta]&TxtTablaItem=$tab&TxtCantidad=1";
            //$css->CrearLink($target, "_self", "Agregar");
			
            $css->CrearForm2("Frm$tab$DatosProducto[idProductosVenta]", $myPage, "post", "_self");
            $css->CrearInputText("CmbPreVentaAct", "hidden", "", $idPreventa, "", "", "", "", "", "", 0, 0);
            $css->CrearInputText("TxtTablaItem", "hidden", "", $tab, "", "", "", "", "", "", 0, 0);
            $css->CrearInputText("TxtAgregarItemPreventa", "hidden", "", $DatosProducto["idProductosVenta"], "", "", "", "", "", "", 0, 0);
            
            $css->CrearInputNumber("TxtCantidad", "number", "", 1, "Cantidad", "", "", "", 100, 30, 0, 1, 0, "", "any");
            if($myPage<>'VentasRapidasV2.php'){
                $css->CrearInputNumber("TxtMultiplicador", "number", "X", 1, "Dias", "", "", "", 100, 30, 0, 1, 0, "", "any");
            }
            $css->CrearBotonNaranja("BtnAgregar", "Agregar");
            $css->CerrarForm();
			
			
            print("</td>");
            $css->ColTabla($DatosProducto["idProductosVenta"], 1);
            $css->ColTabla($DatosProducto["Referencia"], 1);
            $css->ColTabla($DatosProducto["Nombre"], 1);
            $css->ColTabla($DatosProducto["PrecioVenta"], 1);
            $css->ColTabla($DatosProducto["PrecioMayorista"], 1);
            //$css->ColTabla($DatosProducto["Existencias"], 1);
           
            $css->CierraFilaTabla();
        }
    }
    
    $tab="sistemas";
    $Condicion=" WHERE ID='$key' OR Nombre LIKE '%$key%'";
    $consulta=$obVenta->ConsultarTabla($tab,$Condicion);
    if($obVenta->NumRows($consulta)){
        
        while($DatosProducto=$obVenta->FetchArray($consulta)){
            $css->FilaTabla(16);
             print("<td>");
            			
            $css->CrearForm2("Frm$tab$DatosProducto[ID]", $myPage, "post", "_self");
            $css->CrearInputText("CmbPreVentaAct", "hidden", "", $idPreventa, "", "", "", "", "", "", 0, 0);
            $css->CrearInputText("TxtTablaItem", "hidden", "", $tab, "", "", "", "", "", "", 0, 0);
            $css->CrearInputText("TxtAgregarItemPreventa", "hidden", "", $DatosProducto["ID"], "", "", "", "", "", "", 0, 0);
            
            $css->CrearInputNumber("TxtCantidad", "number", "", 1, "Cantidad", "", "", "", 100, 30, 0, 1, 0, "", "any");
            if($myPage<>'VentasRapidasV2.php'){
                $css->CrearInputNumber("TxtMultiplicador", "number", "X", 1, "Dias", "", "", "", 100, 30, 0, 1, 0, "", "any");
            }
            $css->CrearBotonNaranja("BtnAgregar", "Agregar");
            $css->CerrarForm();
            $sql="SELECT sum(`ValorUnitario`*`Cantidad`) as Total FROM `sistemas_relaciones` WHERE `idSistema`='$DatosProducto[ID]'";
            $consulta=$obVenta->Query($sql);
            $TotalSistema=$obVenta->FetchArray($consulta);
            $PrecioVenta= number_format($TotalSistema["Total"]);
			
            print("</td>");
            $css->ColTabla($DatosProducto["ID"], 1);
            
            $css->ColTabla($DatosProducto["Nombre"], 1);
            $css->ColTabla($PrecioVenta, 1);
            //$css->ColTabla($DatosProducto["PrecioMayorista"], 1);
            //$css->ColTabla($DatosProducto["Existencias"], 1);
           
            $css->CierraFilaTabla();
        }
    }
    
    $css->CerrarTabla();
    $css->CerrarDiv();
}else{
    $css->CrearNotificacionRoja("Digite un Dato", 16);
}
$css->AgregaJS(); //Agregamos javascripts
?>
    
</body>
</html>