<?php

session_start();
$idUser=$_SESSION['idUser'];
$TipoUser=$_SESSION['tipouser'];
//$myPage="titulos_comisiones.php";
include_once("../../modelo/php_conexion.php");
include_once("../css_construct.php");

$css =  new CssIni("id");
$obVenta = new ProcesoVenta($idUser);

//Si se recibe un codigo de barras
if(isset($_REQUEST['idMesa'])){
    $fecha=date("Y-m-d");
    $hora=date("H:i:s");
    $idMesa=$obVenta->normalizar($_REQUEST['idMesa']);
    $css->CrearNotificacionRoja("Mesa $idMesa",20);  
    if(isset($_REQUEST['BtnAgregarItem'])){
        
        $Cantidad=$obVenta->normalizar($_REQUEST['TxtCantidad']);
        $Observaciones=$obVenta->normalizar($_REQUEST['TxtObservaciones']);
        $idProducto=$obVenta->normalizar($_REQUEST['idItem']);
        $idPedido=$obVenta->AgregueProductoAPedido($idMesa,$fecha,$hora,$Cantidad,$idProducto,$Observaciones,"");
        
    } 
    $DatoPedido=$obVenta->ValorActual("restaurante_pedidos", "ID", " idMesa='$idMesa' AND Estado='AB'");
    $idPedido=$DatoPedido["ID"];
    if($idPedido==""){
        $css->CrearNotificacionNaranja("No hay pedidos para esta mesa", 16);
    }else{
        $css->CrearTabla();
        $Subtotal=$obVenta->SumeColumna("restaurante_pedidos_items", "Subtotal", "idPedido", $idPedido);
        $IVA=$obVenta->SumeColumna("restaurante_pedidos_items", "IVA", "idPedido", $idPedido);
        $Total=$obVenta->SumeColumna("restaurante_pedidos_items", "Total", "idPedido", $idPedido);
        $css->FilaTabla(16);
            print("<td rowspan=3 colspan=2 style='text-align:center'>");
                $ImageAlterna="../images/print.png";
                $RutaImage=$ImageAlterna;
                $Nombre="ImgDescartar".$idPedido;
                $Page="ProcesadoresJS/ProcesaAccionesJS.php?idAccion=4&idPedido=$idPedido&Carry=";
                $FuncionJS="onclick='EnvieObjetoConsulta(`$Page`,`$Nombre`,`DivMensajes`,`NO`);return false ;'";
                $css->CrearImage($Nombre, $RutaImage, $ImageAlterna, 100, 100,$FuncionJS);
                
            print("</td>");
            print("<td colspan=2 style='text-align:right'>");
                print("<strong>SUBTOTAL</strong>");
            print("</td>");
            
            print("<td style='text-align:right'>");
                print("<strong>".number_format($Subtotal)."</strong>");
            print("</td>");
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
            print("<td colspan=2 style='text-align:right'>");
                print("<strong>IVA</strong>");
            print("</td>");
            
            print("<td style='text-align:right'>");
                print("<strong>".number_format($IVA)."</strong>");
            print("</td>");
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
            print("<td colspan=2 style='text-align:right'>");
                print("<strong>TOTAL</strong>");
            print("</td>");
            print("<td style='text-align:right'>");
                print("<strong>".number_format($Total)."</strong>");
            print("</td>");
           
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
            $css->ColTabla('<strong>Producto</strong>', 3);
            $css->ColTabla('<strong>Cantidad</strong>', 1);
            $css->ColTabla('<strong>Total</strong>', 1);
            $css->ColTabla('<strong>Observaciones</strong>', 1);
            
        $css->CierraFilaTabla();
        $consulta=$obVenta->ConsultarTabla("restaurante_pedidos_items", "WHERE idPedido='$idPedido' ORDER BY ID DESC");
        $tbl="restaurante_pedidos_items";
        while($DatosItem=$obVenta->FetchArray($consulta)){
            
            $css->FilaTabla(16);
            $css->ColTabla($DatosItem["NombreProducto"], 3);
            
            $css->ColTabla($DatosItem["Cantidad"], 1);
            
            print("<td style='text-align:right'>");
                print(number_format($DatosItem["Total"]));
            print("</td>");
            print("<td>");
            $idItem=$DatosItem["ID"];
            $idElement="TxtObservaciones".$idItem;
            $css->CrearTextArea($idElement, "", $DatosItem["Observaciones"], "", "", "onKeyUp", "EditeRegistroSinConfirmar(`restaurante_pedidos_items`,`Observaciones`,`ID`,`$idItem`,`$idElement`)", "", "", 0, 1,0);
                                
             print("</td>");
            $css->CierraFilaTabla();
        }
        
        $css->CerrarTabla();
    }
    
}else{
    $css->CrearNotificacionRoja("No se ha seleccionado una mesa",20);  
}

$css->CerrarDiv();
$css->AgregaJS(); //Agregamos javascripts
?>