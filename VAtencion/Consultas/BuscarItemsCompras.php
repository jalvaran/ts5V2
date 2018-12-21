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
$idCompra=$obVenta->normalizar($_REQUEST['idCompra']);
$TipoBusqueda=$obVenta->normalizar($_REQUEST['TipoItem']);
$PageReturn=$myPage."?TipoItem=1&idCompra=$idCompra&TxtAgregarItemCompra=";
if($key<>""){
    $css->CrearTabla();
    $DatosCompraGeneral=$obVenta->DevuelveValores("factura_compra", "ID", $idCompra);
    switch ($TipoBusqueda) {
        case 1:
            $sql="SELECT * FROM `productosventa` pv 
		WHERE pv.`idProductosVenta`='$key' OR pv.Nombre LIKE '%$key%' or pv.Referencia = '$key'  LIMIT 50";
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
                            $css->CrearInputText("idCompra", "hidden", "", $idCompra, "", "", "", "", "", "", 0, 0);
                            $css->CrearInputText("TxtidProducto", "hidden", "", $DatosProducto["idProductosVenta"], "", "", "", "", "", "", 0, 0);
                            $css->CrearInputText("TipoItem", "hidden", "", 1, "", "", "", "", "", "", 0, 0);
                            $css->CrearInputNumber("TxtCantidad", "number", "Cantidad: <br>", 1, "Cantidad", "Black", "", "", 100, 30, 0, 1, 1, "", "any");
                            $css->CrearInputNumber("TxtCosto", "number", "<br>Costo Unitario: <br>", $DatosProducto["CostoUnitario"], "Costo Unitario", "Black", "", "", 100, 30, 0, 1, 0, "", "any");

                            print("<br><strong>Tipo de IVA: </strong><br>");
                            $css->CrearSelect("TipoIVA", "");
                                $css->CrearOptionSelect("", "Seleccione un tipo de IVA", 0);
                                $Consulta=$obVenta->ConsultarTabla("porcentajes_iva", " WHERE Habilitado='SI'");
                                while($DatosIVA=$obVenta->FetchArray($Consulta)){
                                    $sel=0;
                                    if($DatosCompraGeneral["TipoCompra"]=='RM'){
                                        if($DatosIVA["Valor"]=='0'){
                                            $sel=1;
                                        }
                                    }
                                    if($DatosCompraGeneral["TipoCompra"]=='FC'){
                                        if($DatosIVA["Valor"]=='0.19'){
                                            $sel=1;
                                        }
                                    }
                                    $css->CrearOptionSelect($DatosIVA["Valor"], $DatosIVA["Nombre"], $sel);
                                }
                            $css->CerrarSelect();

                            print("<br><strong>IVA Incluido?: </strong><br>");
                            $css->CrearSelect("IVAIncluido", "");
                                $css->CrearOptionSelect("NO", "NO", 1);
                                $css->CrearOptionSelect("SI", "SI", 0);
                            $css->CerrarSelect();
                            print("<br>");
                            $css->CrearBotonNaranja("BtnAgregarItem", "Agregar");
                            $css->CerrarForm();
                        print("</td>");

                        $css->CierraFilaTabla();

                }
            }else{
                $css->CrearNotificacionRoja("No se encontraron productos relacionados a la busqueda", 16);
            }

            break;

        case 2:
             $sql="SELECT * FROM `insumos` pv 
		WHERE pv.`ID`='$key' OR pv.Nombre LIKE '%$key%' or pv.Referencia = '$key'  LIMIT 50";
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
                    
                    $css->ColTabla($DatosProducto["ID"], 1);
                    $css->ColTabla($DatosProducto["Referencia"], 1);
                    $css->ColTabla($DatosProducto["Nombre"], 1);
                    print("<td>");
                        $css->CrearForm2("FrmAgregaItemCompra$DatosProducto[ID]", $myPage, "post", "_self");
                        $css->CrearInputText("idCompra", "hidden", "", $idCompra, "", "", "", "", "", "", 0, 0);
                        $css->CrearInputText("TxtidProducto", "hidden", "", $DatosProducto["ID"], "", "", "", "", "", "", 0, 0);
                        $css->CrearInputText("TipoItem", "hidden", "", 2, "", "", "", "", "", "", 0, 0);
                        $css->CrearInputNumber("TxtCantidad", "number", "Cantidad: <br>", 1, "Cantidad", "Black", "", "", 100, 30, 0, 1, 1, "", "any");
                        $css->CrearInputNumber("TxtCosto", "number", "<br>Costo Unitario: <br>", $DatosProducto["CostoUnitario"], "Costo Unitario", "Black", "", "", 100, 30, 0, 1, 0, "", "any");
                        
                        print("<br><strong>Tipo de IVA: </strong><br>");
                        $css->CrearSelect("TipoIVA", "");
                            $css->CrearOptionSelect("", "Seleccione un tipo de IVA", 0);
                            $Consulta=$obVenta->ConsultarTabla("porcentajes_iva", " WHERE Habilitado='SI'");
                            while($DatosIVA=$obVenta->FetchArray($Consulta)){
                                $sel=0;
                                if($DatosCompraGeneral["TipoCompra"]=='RM'){
                                    if($DatosIVA["Valor"]=='0'){
                                        $sel=1;
                                    }
                                }
                                if($DatosCompraGeneral["TipoCompra"]=='FC'){
                                    if($DatosIVA["Valor"]=='0.19'){
                                        $sel=1;
                                    }
                                }
                                $css->CrearOptionSelect($DatosIVA["Valor"], $DatosIVA["Nombre"], $sel);
                            }
                        $css->CerrarSelect();
                       
                        print("<br><strong>IVA Incluido?: </strong><br>");
                        $css->CrearSelect("IVAIncluido", "");
                            $css->CrearOptionSelect("NO", "NO", 1);
                            $css->CrearOptionSelect("SI", "SI", 0);
                        $css->CerrarSelect();
                        print("<br>");
                        $css->CrearBotonNaranja("BtnAgregarItem", "Agregar");
                        $css->CerrarForm();
                    print("</td>");
                                        
                    $css->CierraFilaTabla();
                
                }
            }else{
                $css->CrearNotificacionRoja("No se encontraron insumos relacionados a la busqueda", 16);
            }

                
            break;
    }
    
    $css->CerrarTabla();
    
}else{
    $css->CrearNotificacionRoja("Digite un Dato", 16);
}

?>
    
</body>
</html>