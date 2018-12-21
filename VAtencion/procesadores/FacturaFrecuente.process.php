<?php
include_once("../../modelo/php_conexion.php");
include_once("../clases/FacturasFrecuentes.class.php");
session_start();
$idUser=$_SESSION['idUser'];
$obVenta=new FacturasFrecuentes($idUser);
if(isset($_REQUEST["idAccion"])){
    $idAccion=$obVenta->normalizar($_REQUEST["idAccion"]);
    
    switch ($idAccion) {
        case 1://agrega un servicio a una factura frecuente
            $idFacturaFrecuente=$obVenta->normalizar($_REQUEST["idFacturaFrecuente"]);
            $Cantidad=$obVenta->normalizar($_REQUEST["Cantidad"]);
            $idServicio=$obVenta->normalizar($_REQUEST["idServicio"]);
            $TablaItem="servicios"; 
            $idTabla="idProductosVenta";
            $obVenta->AgregarItemFacturaFrecuente($idFacturaFrecuente, $TablaItem, $idTabla, $idServicio, $Cantidad, $idUser, "");
           
            print("OK");
        break;
        case 2: //Dibujo los items
            include_once("../css_construct.php");
            $css =  new CssIni("",0);
            $idFacturaFrecuente=$obVenta->normalizar($_REQUEST["idFacturaFrecuente"]);
            $css->CrearNotificacionVerde("Items Agregados a esta factura", 16);
       
            $consulta=$obVenta->ConsultarTabla("facturas_frecuentes_items_adicionales", "WHERE idFacturaFrecuente='$idFacturaFrecuente'");
            if($obVenta->NumRows($consulta)){
                
                $css->CrearTabla();
                    
                    $css->FilaTabla(12);
                        $css->ColTabla("<strong>Tabla</strong>", 1);
                        $css->ColTabla("<strong>Nombre</strong>", 1);
                        $css->ColTabla("<strong>Referencia</strong>", 1);
                        $css->ColTabla("<strong>Cantidad</strong>", 1);
                        $css->ColTabla("<strong>Valor Unitario</strong>", 1);
                        $css->ColTabla("<strong>Total</strong>", 1);
                        $css->ColTabla("<strong>Editar</strong>", 1);
                        
                    $css->CierraFilaTabla();
                    
                    
                while($DatosItems=$obVenta->FetchArray($consulta)){
                    
                    $DatosItemsGeneral=$obVenta->DevuelveValores($DatosItems["TablaOrigen"], $DatosItems["idTablaOrigen"], $DatosItems["idItem"]);
                    
                    $css->FilaTabla(12);
                        $Item=$DatosItems["ID"];
                        $css->ColTabla($DatosItems["TablaOrigen"], 1);
                        $css->ColTabla($DatosItemsGeneral["Nombre"], 1);
                        $css->ColTabla($DatosItemsGeneral["Referencia"], 1);
                        print("<td style=text-align:center>");
                            $css->CrearInputNumber("TxtCantidad_".$Item, "number", "", $DatosItems["Cantidad"], "Cantidad", "", "onChange", "EditarItem('$Item')", 100, 30, 0, 1, 0, "", "any");
                        print("</td>");
                        print("<td style=text-align:center>");
                            $css->CrearInputNumber("TxtValorUnitario_".$Item, "number", "", $DatosItems["ValorUnitario"], "ValorUnitario", "", "onChange", "EditarItem('$Item')", 100, 30, 0, 1, 0, "", "any");
                        print("</td>");
                       // print("<td style=text-align:center>");
                            $css->ColTabla(number_format($DatosItems["ValorUnitario"]*$DatosItems["Cantidad"]), 1);
                           // $css->CrearInputNumber("TxtTotal_".$Item, "number", "", $DatosItems["ValorUnitario"]*$DatosItems["Cantidad"], "ValorUnitario", "", "", "", 100, 30, 1, 1, 1, "", "any");
                        //print("</td>");
                        print("<td style=text-align:center>");
                            $css->CrearBotonEvento("BtnEditar", "Editar", 1, "onClick", "EditarItem('$Item')", "naranja", "");
                        print("</td>");
                    $css->CierraFilaTabla();
                    
                }
                $css->CerrarTabla();
            }else{
                $css->CrearNotificacionAzul("Esta factura aún no tiene items", 16);
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
        
        case 4://agrega un producto a una factura frecuente
            $idFacturaFrecuente=$obVenta->normalizar($_REQUEST["idFacturaFrecuente"]);
            $Cantidad=$obVenta->normalizar($_REQUEST["Cantidad"]);
            $idProducto=$obVenta->normalizar($_REQUEST["idProducto"]);
            $TablaItem="productosventa"; 
            $idTabla="idProductosVenta";
            $obVenta->AgregarItemFacturaFrecuente($idFacturaFrecuente, $TablaItem, $idTabla, $idProducto, $Cantidad, $idUser, "");
           
            print("OK");
        break;
    
        case 5://edita la cantidad y valor de un item
            $idItem=$obVenta->normalizar($_REQUEST["idItem"]);
            $Cantidad=$obVenta->normalizar($_REQUEST["Cantidad"]);
            $ValorUnitario=$obVenta->normalizar($_REQUEST["ValorUnitario"]);
            $obVenta->ActualizaRegistro("facturas_frecuentes_items_adicionales", "Cantidad", $Cantidad, "ID", $idItem);
            $obVenta->ActualizaRegistro("facturas_frecuentes_items_adicionales", "ValorUnitario", $ValorUnitario, "ID", $idItem);
           
            print("OK");
        break;
    
        case 6://Realiza las facturas de acuerdo a la tabla de facturas frecuentes
            $Fecha=$obVenta->normalizar($_REQUEST["Fecha"]);
            
            $sql="SELECT COUNT(*) AS NumFacts FROM vista_facturas_frecuentes WHERE ProximaFechaFacturacion<='$Fecha' AND Realizada=0";
            $consulta=$obVenta->Query($sql);
            $DatosNumFact=$obVenta->FetchAssoc($consulta);
            $CantidadTotalFacturas=$DatosNumFact["NumFacts"];
            if($CantidadTotalFacturas=="" or $CantidadTotalFacturas==0){
                print("SD");
                exit();
            }
            
            $sql="SELECT COUNT(*) AS NumFacts FROM facturas_frecuentes";
            $consulta=$obVenta->Query($sql);
            $DatosNumFact=$obVenta->FetchAssoc($consulta);
            $CantidadTotalFacturas=$DatosNumFact["NumFacts"];
            
            $sql="SELECT ID FROM facturas_frecuentes WHERE Realizada=0 LIMIT 1";
            $Consulta=$obVenta->Query($sql);
            $DatosFacturaFrecuente=$obVenta->FetchAssoc($Consulta);
            $NumFactura=$obVenta->GenerarFacturaFrecuente($Fecha,$DatosFacturaFrecuente["ID"], $idUser, "");
            
            $sql="SELECT COUNT(*) AS NumFacts FROM facturas_frecuentes WHERE Realizada=1";
            $consulta=$obVenta->Query($sql);
            $DatosNumFact=$obVenta->FetchAssoc($consulta);
            $CantidadTotalFacturasRealizadas=$DatosNumFact["NumFacts"];
            
            $PorcentajeRealizado=round((100/$CantidadTotalFacturas)*$CantidadTotalFacturasRealizadas);
            if($PorcentajeRealizado==100){
                $obVenta->VaciarTabla("facturas_frecuentes_items_adicionales");
                $obVenta->update("facturas_frecuentes", "Realizada", 0,"");
            }
            $DatosFactura=$obVenta->ValorActual("facturas", "NumeroFactura", "idFacturas='$NumFactura'");
            $NumeroFactura=$DatosFactura["NumeroFactura"];
            $Page="PDF_Factura.php?ImgPrintFactura=".$NumFactura;
            $msg="Factura $NumeroFactura Creada <a href='$Page' target='_blank'> Imprimir </a>";
            print("OK;$PorcentajeRealizado;$msg");
        break;
        
    }
    
}else{
    print("No se recibieron parametros");
}
?>