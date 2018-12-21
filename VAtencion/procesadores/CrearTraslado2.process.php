<?php
include_once("../../modelo/php_conexion.php");

session_start();
$idUser=$_SESSION['idUser'];
$obCon=new ProcesoVenta($idUser);
if(isset($_REQUEST["idAccion"])){
    $idAccion=$obCon->normalizar($_REQUEST["idAccion"]);
    
    switch ($idAccion) {
        case 1://agrega un item a un traslado
            $idComprobante=$obCon->normalizar($_REQUEST["idTraslado"]);
            $Cantidad=$obCon->normalizar($_REQUEST["TxtCantidad"]);
            $CodBarras=$obCon->normalizar($_REQUEST["TxtCodigo"]); 
            if($CodBarras<>''){
                
            
                $DatosProducto=$obCon->DevuelveValores("productosventa", "idProductosVenta", $CodBarras);
                $Vacio=1;
                if($DatosProducto["idProductosVenta"] <> ''){
                    $Vacio=0;
                    $idProducto=$CodBarras;
                    $obCon->AgregarItemTraslado($idComprobante,$idProducto,$Cantidad,"");
                }else{
                    $DatosCodigo=$obCon->DevuelveValores("prod_codbarras", "CodigoBarras", $CodBarras);
                    if($DatosCodigo<>''){
                        $Vacio=0;
                        $idProducto=$DatosCodigo["ProductosVenta_idProductosVenta"];
                        $obCon->AgregarItemTraslado($idComprobante,$idProducto,$Cantidad,"");
                    }
                }
                if($Vacio==1){
                    print("E1");                
                }
                if($Vacio==0){
                    print("OK");                
                }
            }else{
                print("No se recibió un código"); 
            }    
        break;
        case 2: //Dibujo los items
            include_once("../css_construct.php");
            $css =  new CssIni("",0);
            $idComprobante=$obCon->normalizar($_REQUEST["idTraslado"]);
            $consulta=$obCon->ConsultarTabla("traslados_items", "WHERE idTraslado='$idComprobante' ORDER BY Updated DESC");
            if($obCon->NumRows($consulta)){
                $css->CrearTabla();
                    $css->FilaTabla(16);
                        
                        print("<td colspan=5 style=text-align:center>");
                            $css->CrearBotonEvento("BtnGuardar", "Guardar este traslado", 1, "onClick", "GuardarTraslado('$idComprobante')", "rojo", "");
                        print("</td>");
                    $css->CierraFilaTabla();
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>idProducto</strong>", 1);
                        $css->ColTabla("<strong>Producto</strong>", 1);
                        $css->ColTabla("<strong>Referencia</strong>", 1);
                        $css->ColTabla("<strong>Cantidad</strong>", 1);
                        $css->ColTabla("<strong>Borrar</strong>", 1);
                    $css->CierraFilaTabla();
               
                while($DatosItems=$obCon->FetchArray($consulta)){
                    $css->FilaTabla(16);
                        $Item=$DatosItems["ID"];
                        $css->ColTabla($DatosItems["CodigoBarras"], 1);
                        $css->ColTabla($DatosItems["Nombre"], 1);
                        $css->ColTabla($DatosItems["Referencia"], 1);
                        $css->ColTabla($DatosItems["Cantidad"], 1);
                        print("<td style=text-align:center>");
                            $css->CrearBotonEvento("BtnBorrar", "X", 1, "onClick", "BorrarItem('$Item')", "rojo", "");
                        print("</td>");
                    $css->CierraFilaTabla();
                }
                $css->CerrarTabla();
            }else{
                $css->CrearNotificacionAzul("No hay items en este traslado", 16);
            }
            break;
        case 3://Guardar el traslado
            $idComprobante=$obCon->normalizar($_REQUEST["idTraslado"]);
            $obCon->GuardarTrasladoMercancia($idComprobante);
            print($idComprobante);
            break;
        case 4://Elimina un item de un traslado
            $idItem=$obCon->normalizar($_REQUEST["idItem"]);
            $obCon->BorraReg("traslados_items", "ID", $idItem);
            print("OK");
            break;
    }
    
}else{
    print("No se recibiron parametros");
}
?>