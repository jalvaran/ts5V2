<?php

session_start();
$idUser=$_SESSION['idUser'];
$TipoUser=$_SESSION['tipouser'];
//$myPage="titulos_comisiones.php";
include_once("../../modelo/php_conexion.php");
include_once("../../modelo/php_tablas.php");
include_once("../css_construct.php");

$css =  new CssIni("id");
$obVenta = new ProcesoVenta($idUser);
$obTabla = new Tabla($db);
$myPage=$obVenta->normalizar($_REQUEST['myPage']);
$idPreventa=$obVenta->normalizar($_REQUEST['CmbPreVentaAct']);

if(!empty($_REQUEST["FacturarItemSeparado"])){
        
        $idItemSeparado=$obVenta->normalizar($_REQUEST['idItemSeparado']);
        $DatosItem=$obVenta->DevuelveValores("separados_items", "ID", $idItemSeparado);
        $idSeparado=$DatosItem["idSeparado"];
        $DatosSeparado=$obVenta->DevuelveValores("separados", "ID", $idSeparado);
        $TotalAbonos=$DatosSeparado["Total"]-$DatosSeparado["Saldo"];
        print("<div id='divFact' class='fade in' align='left' style='display:block;background-color: white;width: 200%; border-style: solid;border-color: #fc4c04;border-radius: 30px 5px 30px 5px;' >");
            print('<a href="#" class="close" data-dismiss="alert" aria-label="close">X</a>');
        
        if($DatosItem["TotalItem"]>$TotalAbonos){
            $css->CrearNotificacionRoja("El Valor del Item es Superior a los Abonos realizados.", 16);
        }else{
            $css->CrearTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>FACTURAR ITEM DE UN SEPARADO</strong>", 6);
                $css->CierraFilaTabla();
                $css->FilaTabla(14);
                    $css->ColTabla("<strong>ARTICULO</strong>", 1);
                    $css->ColTabla("<strong>CANTIDAD</strong>", 1);
                    $css->ColTabla("<strong>VALOR</strong>", 1);
                    $css->ColTabla("<strong>ABONOS</strong>", 1);
                    $css->ColTabla("<strong>SALDO</strong>", 1);
                    $css->ColTabla("<strong>GENERAR</strong>", 1);
                $css->CierraFilaTabla();
                $css->FilaTabla(14);
                    $css->ColTabla($DatosItem["Nombre"], 1);
                    $css->ColTabla($DatosItem["Cantidad"], 1);
                    $css->ColTabla($DatosItem["TotalItem"], 1);
                    $css->ColTabla(number_format($DatosSeparado["Total"]-$DatosSeparado["Saldo"]), 1);
                    $css->ColTabla(number_format($DatosSeparado["Saldo"]), 1);
                    print("<td>");
                        $css->CrearForm2("FrmCrearFacItem", $myPage, "post", "_self");
                            $css->CrearInputText("CmbPreVentaAct", "hidden", "", $idPreventa, "", "", "", "", "", "", 0, 0);
                            $css->CrearInputText("idItemSeparado", "hidden", "", $idItemSeparado, "", "", "", "", "", "", 0, 0);
                            $css->CrearBotonConfirmado("BtnFacturarItemSeparado", "Facturar");
                        $css->CerrarForm();
                    print("</td>");
                $css->CierraFilaTabla();
            $css->CerrarTabla();
        }
        
        $css->CerrarDiv();
       
        
}

?>