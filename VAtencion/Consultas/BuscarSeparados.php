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

    //Dibujo una busqueda de un separado
if(!empty($_REQUEST["TxtBuscarSeparado"])){
    
    $key=$obVenta->normalizar($_REQUEST["TxtBuscarSeparado"]);
    $sql="SELECT sp.ID, cl.RazonSocial, cl.Num_Identificacion, sp.Total, sp.Saldo, sp.idCliente FROM separados sp"
            . " INNER JOIN clientes cl ON sp.idCliente = cl.idClientes "
            . " WHERE (sp.Estado<>'Cerrado' AND sp.Estado<>'ANULADO' AND sp.Saldo>0) AND (cl.RazonSocial LIKE '%$key%' OR cl.Num_Identificacion LIKE '%$key%') LIMIT 10";
    $Datos=$obVenta->Query($sql);
    if($obVenta->NumRows($Datos)){
        $css->CrearTabla();
        
        while($DatosSeparado=$obVenta->FetchArray($Datos)){
            $css->FilaTabla(14);
            $css->ColTabla("<strong>Separado No. $DatosSeparado[ID]<strong>", 6);
            $css->CierraFilaTabla();
            $css->FilaTabla(14);
            print("<td>");
            $css->CrearForm2("FormAbonosSeparados$DatosSeparado[ID]", $myPage, "post", "_self");
            $css->CrearInputText("CmbPreVentaAct","hidden","",$idPreventa,"","","","",0,0,0,0);
            $css->CrearInputText("TxtIdSeparado","hidden","",$DatosSeparado["ID"],"","","","",0,0,0,0);
            $css->CrearInputText("TxtIdClientes","hidden","",$DatosSeparado["idCliente"],"","","","",0,0,0,0);
            $css->CrearInputNumber("TxtAbonoSeparado$DatosSeparado[ID]", "number", "Abonar: ", $DatosSeparado["Saldo"], "Abonar", "black", "", "", 200, 30, 0, 1, 1, $DatosSeparado["Saldo"], "any");
            $css->CrearBotonConfirmado("BtnAbono$DatosSeparado[ID]", "Abonar");
            $css->CerrarForm();
            print("</td>");
            $css->ColTabla($DatosSeparado["ID"], 1);
            $css->ColTabla($DatosSeparado["RazonSocial"], 1);
            $css->ColTabla($DatosSeparado["Num_Identificacion"], 1);
            $css->ColTabla(number_format($DatosSeparado["Total"]), 1);
            $css->ColTabla(number_format($DatosSeparado["Total"]-$DatosSeparado["Saldo"]), 1);
            $css->ColTabla(number_format($DatosSeparado["Saldo"]), 1);
            $css->CierraFilaTabla();
            
            $css->FilaTabla(16);
            $css->ColTabla("ID Separado", 1);
            $css->ColTabla("Referencia", 1);
            $css->ColTabla("Nombre", 2);
            $css->ColTabla("Cantidad", 1);
            $css->ColTabla("TotalItem", 1);
            $css->ColTabla("Opciones", 1);
            $css->CierraFilaTabla();
            $TotalAbonos=$DatosSeparado["Total"]-$DatosSeparado["Saldo"];
            $ConsultaItems=$obVenta->ConsultarTabla("separados_items", "WHERE idSeparado='$DatosSeparado[ID]'");
            while($DatosItemsSeparados=$obVenta->FetchArray($ConsultaItems)){
                $CantidadMaxima=$DatosItemsSeparados["Cantidad"];
                $ValorUnitarioItem=$DatosItemsSeparados["ValorUnitarioItem"];
                $idItemSeparado=$DatosItemsSeparados["ID"];
                $css->FilaTabla(14);
                $css->ColTabla($DatosItemsSeparados["idSeparado"], 1);
                $css->ColTabla($DatosItemsSeparados["Referencia"], 1);
                
                $css->ColTabla($DatosItemsSeparados["Nombre"], 2);
                print("<td>");
                
                $css->CrearInputNumber("TxtCantidadItemSeparado_$idItemSeparado", "number", "", $DatosItemsSeparados["Cantidad"], "", "", "onKeyPress", "CampoNumerico(event)", 100, 30, 0, 0,0,$DatosItemsSeparados["Cantidad"],"any");
                //$css->ColTabla($DatosItemsSeparados["Cantidad"], 1);
                print("</td>");
                
                $css->ColTabla(number_format($DatosItemsSeparados["TotalItem"]), 1);
                print("<td>");
                    
                    $Page="Consultas/FacturarItemSeparado.php?myPage=$myPage&FacturarItemSeparado=1&idItemSeparado=$idItemSeparado&CmbPreVentaAct=$idPreventa&";
                    $css->CrearInputText("TxtIdSeparado".$idItemSeparado, "hidden", "", $idItemSeparado, "", "", "", "", "", "", 1, 1);
                    //$css->CrearBotonEvento("BtnFactItemSeparado$DatosItemsSeparados[ID]", "Facturar este Item", 1, "onClick", "EnvieObjetoConsulta(`$Page`,`TxtIdSeparado$idItemSeparado`,`DivRespuestasJS`,`1`);return false;", "naranja", "");
                    $css->CrearBotonEvento("BtnFactItemSeparado", "Facturar Item", 1, "onClick", "FacturarItemSeparado('$idItemSeparado','$TotalAbonos','$CantidadMaxima','$ValorUnitarioItem')", "naranja", "");
                print("</td>");
                $css->CierraFilaTabla();
            }           
            
             
            
        }
        $css->CerrarTabla();
    }else{
        $css->CrearNotificacionRoja("No se encontraron datos", 16);
    }
}

?>