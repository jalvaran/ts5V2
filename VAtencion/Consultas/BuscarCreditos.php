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
//$key=$obVenta->normalizar($_REQUEST["TxtBuscarCredito"]);
//$obTabla->DibujaSeparado($myPage,$idPreventa,"");
//$obTabla->DibujaCredito($myPage,$idPreventa,"");
//$key=$obVenta->normalizar($_REQUEST['key']);
    //Dibujo una busqueda de un separado
if(!empty($_REQUEST["TxtBuscarCredito"])){
    
    $key=$obVenta->normalizar($_REQUEST["TxtBuscarCredito"]);
    if(strlen($key)<=2){
        
        $css->CrearNotificacionNaranja("Escriba mas de 3 caracteres", 16);
        return;  
    }
    $sql="SELECT cart.idCartera,cart.TipoCartera,cart.Facturas_idFacturas, cl.RazonSocial, cl.Num_Identificacion, cart.TotalFactura, cart.Saldo,cart.TotalAbonos, cl.idClientes FROM cartera cart"
            . " INNER JOIN clientes cl ON cart.idCliente = cl.idClientes "
            . " WHERE (cl.RazonSocial LIKE '%$key%' OR cl.Num_Identificacion LIKE '%$key%') AND cart.Saldo>1 LIMIT 40";
    $Datos=$obVenta->Query($sql);
    if($obVenta->NumRows($Datos)){
        $css->CrearTabla();
        
        while($DatosCredito=$obVenta->FetchArray($Datos)){
            $DatosFactura=$obVenta->DevuelveValores("facturas", "idFacturas", $DatosCredito["Facturas_idFacturas"]);
            
            $css->FilaTabla(14);
            if($DatosFactura["FormaPago"]=='SisteCredito'){
                
                print("<td colspan=6 style='background-color:#ff391a; color:white'>");
            }else{
                print("<td colspan=6 style='background-color:#daeecf;'>");
            }
            
            print("<strong>Factura No. ".$DatosFactura["Prefijo"]." - ".$DatosFactura["NumeroFactura"]." TIPO DE CREDITO: $DatosFactura[FormaPago] Fecha: $DatosFactura[Fecha]<strong>");
            print("</td>");
            $css->CierraFilaTabla();
            $css->FilaTabla(14);
            print("<td>");
            $css->CrearForm2("FormCartera$DatosCredito[idCartera]", $myPage, "post", "_self");
            $css->CrearInputText("CmbPreVentaAct","hidden","",$idPreventa,"","","","",0,0,0,0);
            $css->CrearInputText("TxtIdFactura","hidden","",$DatosCredito["Facturas_idFacturas"],"","","","",0,0,0,0);
            $css->CrearInputText("TxtIdCartera","hidden","",$DatosCredito["idCartera"],"","","","",0,0,0,0);
            $CarteraAct=0;
            if(isset($_REQUEST["HabilitaCmbCuentaDestino"])){
                $css->CrearInputFecha("Fecha: ", "TxtFecha", date("Y-m-d"), 100, 30, "");
                $VectorCuentas["Nombre"]="CmbCuentaDestino";
                $VectorCuentas["Evento"]="";
                $VectorCuentas["Funcion"]="";
                $VectorCuentas["Required"]=1;
                print("<strong>Cuenta:</strong>");
                $css->CrearSelect2($VectorCuentas);
                $css->CrearOptionSelect("", "Seleccione una cuenta destino", 0);
                $ConsultaCuentas=$obVenta->ConsultarTabla("subcuentas", "WHERE PUC LIKE '11%'");
                while($DatosCuentaFrecuentes=$obVenta->FetchArray($ConsultaCuentas)){
                    $css->CrearOptionSelect($DatosCuentaFrecuentes["PUC"], $DatosCuentaFrecuentes["Nombre"]." ".$DatosCuentaFrecuentes["PUC"], 0);
                }
                $css->CerrarSelect();
                print("<br>");
                $CarteraAct=1;
            }
           
            $css->CrearInputNumber("TxtAbonoCredito$DatosCredito[idCartera]", "number", "Efectivo: ", $DatosCredito["Saldo"], "Abonar", "black", "", "", 200, 30, 0, 1, 0, $DatosCredito["Saldo"], "any");
            print("<br>");
            if($CarteraAct==0){
                print("<strong>+ Opciones:</strong><image name='imgHidde' id='imgHidde' src='../images/hidde.png' onclick=MuestraOculta('DivCredito$DatosCredito[idCartera]');><br>");
            }    
            $css->CrearDiv("DivCredito$DatosCredito[idCartera]", "", "left", 0, 1);
                $css->CrearInputNumber("TxtInteresCredito$DatosCredito[idCartera]", "number", "Intereses: ", 0, "Interes", "black", "", "", 200, 30, 0, 1, 0, "", "any");
                print("<br>");    
            
                $css->CrearInputNumber("TxtAbonoTarjeta$DatosCredito[idCartera]", "number", "Tarjetas: ", 0, "Abonar", "black", "", "", 200, 30, 0, 1, 0, $DatosCredito["Saldo"], 1);  
                print("<br>");
                $css->CrearInputNumber("TxtAbonoCheques$DatosCredito[idCartera]", "number", "Cheques: ", 0, "Abonar", "black", "", "", 200, 30, 0, 1, 0, $DatosCredito["Saldo"], 1);  
                print("<br>");
                $css->CrearInputNumber("TxtAbonoOtros$DatosCredito[idCartera]", "number", "Otros: ", 0, "Abonar", "black", "", "", 200, 30, 0, 1, 0, $DatosCredito["Saldo"], 1);  
            print("<br>");
            $css->CerrarDiv();
            $css->CrearBotonConfirmado("BtnAbono$DatosCredito[idCartera]", "Abonar a Credito");
            $css->CerrarForm();
            print("</td>");
            $css->ColTabla($DatosFactura["Prefijo"]." - ".$DatosFactura["NumeroFactura"], 1);
            $css->ColTabla($DatosCredito["RazonSocial"], 1);
            $css->ColTabla($DatosCredito["Num_Identificacion"], 1);
            $css->ColTabla(number_format($DatosCredito["TotalFactura"]), 1);
            $css->ColTabla(number_format($DatosCredito["Saldo"]), 1);
            $css->CierraFilaTabla();
            $css->FilaTabla(16);
            print("<td colspan='6' style='text-align:center'>");
            $idCartera=$DatosCredito["idCartera"];
            $Page="Consultas/ItemsFactura.php?idCartera=$idCartera";
            $css->CrearInputText("TxtIdCartera".$idCartera, "hidden", "", $idCartera, "", "", "", "", "", "", 1, 1);
            $css->CrearBotonEvento("BtnMostrar$DatosCredito[idCartera]", "Mostrar Items de la Factura", 1, "onClick", "EnvieObjetoConsulta(`$Page`,`TxtBuscarSeparado`,`DivCredito_Items$idCartera`,`5`);return false;", "naranja", "");
            print("</td>");
            $css->CierraFilaTabla();
            $css->FilaTabla(16);
            print("<td colspan='6' style='text-align:center'>");
                $css->CrearDiv("DivCredito_Items$DatosCredito[idCartera]", "", "center", 1, 1);
                $css->CerrarDiv();
            print("</td>");   
            $css->CierraFilaTabla();
            /*
            $css->FilaTabla(16);
            $css->ColTabla("Factura", 1);
            $css->ColTabla("Referencia", 1);
            $css->ColTabla("Nombre", 2);
            $css->ColTabla("Cantidad", 1);
            $css->ColTabla("TotalItem", 1);
            $css->CierraFilaTabla();
            
            $idFactura_Item=$DatosCredito["Facturas_idFacturas"];
            $sql="SELECT Referencia,Nombre,Cantidad,TotalItem FROM facturas_items WHERE idFactura='$idFactura_Item'";
            $ConsultaItems=$obVenta->Query($sql);
            
            //$ConsultaItems=$obVenta->ConsultarTabla("facturas_items", "WHERE idFactura='$DatosCredito[Facturas_idFacturas]'");
            while($DatosItemsFactura=$obVenta->FetchArray($ConsultaItems)){
                
                $css->FilaTabla(14);
                $css->ColTabla($DatosFactura["Prefijo"]." - ".$DatosFactura["NumeroFactura"], 1);
                $css->ColTabla($DatosItemsFactura["Referencia"], 1);
                $css->ColTabla($DatosItemsFactura["Nombre"], 2);
                $css->ColTabla($DatosItemsFactura["Cantidad"], 1);
                $css->ColTabla($DatosItemsFactura["TotalItem"], 1);
                $css->CierraFilaTabla();
            }           
            
          
             * 
             */
            
            
        }
        $css->CerrarTabla();
        
    }else{
        $css->CrearNotificacionRoja("No se encontraron datos", 16);
    }
}

?>