<?php
include_once("../../modelo/php_conexion.php");
include_once("../clases/Recetas.class.php");
session_start();
$idUser=$_SESSION['idUser'];
$obReceta=new Recetas($idUser);
if(isset($_REQUEST["idAccion"])){
    $idAccion=$obReceta->normalizar($_REQUEST["idAccion"]);
    
    switch ($idAccion) {
        case 1://agrega un insumo a una receta
            $idProducto=$obReceta->normalizar($_REQUEST["idProducto"]);
            $Cantidad=$obReceta->normalizar($_REQUEST["Cantidad"]);
            $idInsumo=$obReceta->normalizar($_REQUEST["idInsumo"]); 
            $obReceta->AgregarItemReceta($idProducto, "insumos", "ID", $idInsumo, $Cantidad, $idUser, "");
            $DatosProducto= $obReceta->ValorActual("productosventa", "Referencia", " idProductosVenta='$idProducto'");
            $obReceta->CalcularCostosProductoReceta($DatosProducto["Referencia"], "");
            print("OK");
        break;
        case 2: //Dibujo los items
            include_once("../css_construct.php");
            $css =  new CssIni("",0);
            $idProducto=$obReceta->normalizar($_REQUEST["idProducto"]);
            $DatosProducto=$obReceta->DevuelveValores("productosventa", "idProductosVenta", $idProducto);
            $ReferenciaProducto=$DatosProducto["Referencia"];
            $consulta=$obReceta->ConsultarTabla("recetas_relaciones", "WHERE ReferenciaProducto='$ReferenciaProducto' ORDER BY Updated DESC");
            if($obReceta->NumRows($consulta)){
                $css->CrearTabla();
                    
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>idProducto</strong>", 1);
                        $css->ColTabla("<strong>Producto</strong>", 1);
                        $css->ColTabla("<strong>Referencia</strong>", 1);
                        $css->ColTabla("<strong>Precio de Venta</strong>", 1);
                        $css->ColTabla("<strong>Costo Unitario</strong>", 1);
                        $css->ColTabla("<strong>Existencias Actuales</strong>", 1);
                        $css->ColTabla("<strong>Cantidad a Construir</strong>", 1);
                        $css->ColTabla("<strong>Construir</strong>", 1);
                    $css->CierraFilaTabla();
                    
                    $css->FilaTabla(16);
                        //$idProductoCrear=$DatosProducto["idProductosVenta"];
                        $css->ColTabla($DatosProducto["idProductosVenta"], 1);
                        $css->ColTabla($DatosProducto["Nombre"], 1);
                        $css->ColTabla($DatosProducto["Referencia"], 1);
                        $css->ColTabla($DatosProducto["PrecioVenta"], 1);
                        $css->ColTabla($DatosProducto["CostoUnitario"], 1);
                        $css->ColTabla($DatosProducto["Existencias"], 1);
                        print("<td>");
                            $css->CrearInputNumber("TxtCantidadCrear", "number", "", 1, "", "", "", "", 100, 30, 0, 1, 0, "", "any");
                        print("</td>");
                        print("<td>");
                            $css->CrearBotonEvento("BtnCrearProducto", "Construir", 1, "onClick", "CrearProductoDesdeReceta('$idProducto')", "azul", "");
                        print("</td>");
                    $css->CierraFilaTabla();
                    
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>Items para producir este producto</strong>", 8,"C");
                        
                    $css->CierraFilaTabla();
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>Tabla del insumo</strong>", 1);
                        $css->ColTabla("<strong>Producto</strong>", 4);
                        $css->ColTabla("<strong>Referencia</strong>", 1);
                        $css->ColTabla("<strong>Cantidad</strong>", 1);
                        $css->ColTabla("<strong>Editar (Poner en cero para inhabilitar insumo)</strong>", 1);
                        
                    $css->CierraFilaTabla();
                while($DatosItems=$obReceta->FetchArray($consulta)){
                    if($DatosItems["Cantidad"]>0){
                        $DatosInsumo=$obReceta->DevuelveValores($DatosItems["TablaIngrediente"], "Referencia", $DatosItems["ReferenciaIngrediente"]);
                        $css->FilaTabla(16);
                            $Item=$DatosItems["ID"];
                            $css->ColTabla($DatosItems["TablaIngrediente"], 1);
                            $css->ColTabla($DatosInsumo["Nombre"], 4);
                            $css->ColTabla($DatosInsumo["Referencia"], 1);
                            print("<td style=text-align:center>");
                                $css->CrearInputNumber("TxtCantidad_".$Item, "number", "", $DatosItems["Cantidad"], "Cantidad", "", "", "", 100, 30, 0, 1, 0, "", "any");
                            print("</td>");
                            print("<td style=text-align:center>");
                                $css->CrearBotonEvento("BtnEditar", "Editar", 1, "onClick", "EditarItem('$Item')", "naranja", "");
                            print("</td>");
                        $css->CierraFilaTabla();
                    }
                }
                $css->CerrarTabla();
            }else{
                $css->CrearNotificacionAzul("Este producto aún no es una receta", 16);
            }
            break;
        case 3://Editar una cantidad
            $idItemEditar=$obReceta->normalizar($_REQUEST["idItem"]);
            $Cantidad=$obReceta->normalizar($_REQUEST["Cantidad"]);
            $obReceta->ActualizaRegistro("recetas_relaciones", "Cantidad", $Cantidad, "ID", $idItemEditar);
            $DatosItem=$obReceta->DevuelveValores("recetas_relaciones", "ID", $idItemEditar);
            $obReceta->CalcularCostosProductoReceta($DatosItem["ReferenciaProducto"], "");
            print("OK");
            break;
        case 4://Agrega un servicio
            $idProducto=$obReceta->normalizar($_REQUEST["idProducto"]);
            $Cantidad=$obReceta->normalizar($_REQUEST["Cantidad"]);
            $idServicio=$obReceta->normalizar($_REQUEST["idServicio"]); 
            $obReceta->AgregarItemReceta($idProducto, "servicios", "idProductosVenta", $idServicio, $Cantidad, $idUser, "");
            $DatosProducto= $obReceta->ValorActual("productosventa", "Referencia", " idProductosVenta='$idProducto'");
            $obReceta->CalcularCostosProductoReceta($DatosProducto["Referencia"], "");
            print("OK");
        break;
        case 5://Agrega un producto
            $idProducto=$obReceta->normalizar($_REQUEST["idProducto"]);
            $Cantidad=$obReceta->normalizar($_REQUEST["Cantidad"]);
            $idProductoReceta=$obReceta->normalizar($_REQUEST["idProductoReceta"]); 
            $obReceta->AgregarItemReceta($idProducto, "productosventa", "idProductosVenta", $idProductoReceta, $Cantidad, $idUser, "");
            $DatosProducto= $obReceta->ValorActual("productosventa", "Referencia", " idProductosVenta='$idProducto'");
            $obReceta->CalcularCostosProductoReceta($DatosProducto["Referencia"], "");
            print("OK");
        break;
        case 6://Fabricar un producto
            $idProducto=$obReceta->normalizar($_REQUEST["idProducto"]);
            $Cantidad=$obReceta->normalizar($_REQUEST["Cantidad"]);            
            $obReceta->FabricarProducto($idProducto, $Cantidad, "");
            print("OK");
        break;
    }
    
}else{
    print("No se recibiron parametros");
}
?>