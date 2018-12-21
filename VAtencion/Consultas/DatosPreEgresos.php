<?php

//$myPage="DatosPreEgresos.php";
//include_once("../../modelo/php_conexion.php");
//include_once("../css_construct.php");

$css =  new CssIni("");
$obVenta = new ProcesoVenta($idUser);
$sql="SELECT ep.ID as idPre, cp.ID, ep.Abono,ep.Descuento, cp.DocumentoReferencia,cp.Subtotal,cp.IVA,cp.Total,cp.Saldo,cp.Abonos,cp.idProveedor,cp.RazonSocial FROM egresos_pre ep "
        . " INNER JOIN cuentasxpagar cp ON ep.idCuentaXPagar=cp.ID AND ep.idUsuario='$idUser'";
$Consulta=$obVenta->Query($sql);
if($obVenta->NumRows($Consulta)){
    $css->CrearNotificacionAzul("Pre Egreso", 16);
    $css->CrearTabla();

    $css->FilaTabla(16);
    $css->ColTabla('<strong>Cuenta X Pagar</strong>', 1);
    $css->ColTabla('<strong>Abono</strong>', 1);
    $css->ColTabla('<strong>Documento Referencia</strong>', 1);
    $css->ColTabla('<strong>Subtotal</strong>', 1);
    $css->ColTabla('<strong>IVA</strong>', 1);
    $css->ColTabla('<strong>Total</strong>', 1);
    $css->ColTabla('<strong>Abonos</strong>', 1);
    $css->ColTabla('<strong>Saldo</strong>', 1);
    $css->ColTabla('<strong>Tercero</strong>', 1);
    $css->ColTabla('<strong>Eliminar</strong>', 1);
    $css->CierraFilaTabla();

    while($DatosPreEgreso=$obVenta->FetchArray($Consulta)){
        $css->FilaTabla(16);
        $css->ColTabla($DatosPreEgreso['ID'], 1);
        print("<td>");
        $css->CrearForm2("FrmEditarMonto".$DatosPreEgreso["ID"], $myPage, "post", "_self");
        $css->CrearInputText("idPre", "hidden", "", $DatosPreEgreso["idPre"], "", "", "", "", "", "", 0, 0);
        $css->CrearInputText("TxtSaldo", "hidden", "", $DatosPreEgreso["Saldo"], "", "", "", "", "", "", 0, 0);
        print("<br>");
        $css->CrearInputNumber("TxtAbonoEdit", "Number", "Abono:<br>", $DatosPreEgreso['Abono'], "Abono", "", "", "", 100, 30, 0, 1, 1, $DatosPreEgreso['Saldo'], "any");
        print("<br>");
        $css->CrearInputNumber("TxtDescuentoProntoPago", "Number", "Descuento:<br>", $DatosPreEgreso['Descuento'], "Descuento", "", "", "", 100, 30, 0, 0, 0, $DatosPreEgreso['Saldo'], 1);
        print("<br><strong>Cruzar con Nota:</strong>");
        
        $css->CrearSelectTable("CmbNotaDevolucion", "vista_notas_devolucion", "WHERE Tercero='$DatosPreEgreso[idProveedor]' AND Estado='CERRADA' and Total<='$DatosPreEgreso[Saldo]'", "ID", "Concepto", "Total", "onChange", "", "", 0);
        
        print("<br>");
        $css->CrearBoton("BtnEditar", "Agregar");
        $css->CerrarForm();
        print("</td>");
       
        $css->ColTabla($DatosPreEgreso['DocumentoReferencia'], 1);
        $css->ColTabla($DatosPreEgreso['Subtotal'], 1);
        $css->ColTabla($DatosPreEgreso['IVA'], 1);
        $css->ColTabla($DatosPreEgreso['Total'], 1);
        $css->ColTabla($DatosPreEgreso['Abonos'], 1);
        $css->ColTabla($DatosPreEgreso['Saldo'], 1);
        $css->ColTabla($DatosPreEgreso['RazonSocial']." ".$DatosPreEgreso['idProveedor'], 1);
        $css->ColTablaDel($myPage, "egresos_pre", "ID", $DatosPreEgreso["idPre"], "");
        $css->CierraFilaTabla();
    }
    $css->CerrarTabla();
    $css->CrearForm2("FrmGuardar", $myPage, "post", "_self");
    $css->CrearTabla();    
    $css->FilaTabla(16);
    $css->ColTabla("<strong>Fecha</strong>", 1);
    $css->ColTabla("<strong>Total</strong>", 1);
    $css->ColTabla("<strong>Total Descuentos</strong>", 1);
    $css->ColTabla("<strong>Cruce de Notas</strong>", 1);
    $css->ColTabla("<strong>Gran Total</strong>", 1);
    $css->ColTabla("<strong>Cuenta Origen</strong>", 6);
    $css->ColTabla("<strong>Generar</strong>", 2);
    $css->CierraFilaTabla();
    $css->FilaTabla(16);
    print("<td >");
    $css->CrearInputFecha("", "TxtFecha", date("Y-m-d"), 100, 30, "");
    print("</td>");
    print("<td>");
    $TotalAbono=$obVenta->Sume("egresos_pre", "Abono", " WHERE idUsuario='$idUser'");
    $TotalDescuentos=$obVenta->Sume("egresos_pre", "Descuento", " WHERE idUsuario='$idUser'");
    $TotalCruces=$obVenta->Sume("egresos_pre", "CruceNota", " WHERE idUsuario='$idUser'");
    print(number_format($TotalAbono));
    print("</td>");
    print("<td>");
    print(number_format($TotalDescuentos));
    print("</td>");
    print("<td>");
    print(number_format($TotalCruces));
    print("</td>");
    print("<td>");
    print(number_format($TotalAbono+$TotalDescuentos+$TotalCruces));
    print("</td>");
    print("<td colspan='6'>");
    $VarSelect["Ancho"]=300;
    $VarSelect["PlaceHolder"]="Cuenta Origen";
    $VarSelect["Required"]=1;
    $css->CrearSelectChosen("CmbCuentaOrigen", $VarSelect);
    $Consulta=$obVenta->ConsultarTabla("cuentasfrecuentes", "WHERE ClaseCuenta='ACTIVOS'");
        while($DatosCuentas=$obVenta->FetchArray($Consulta)){
            $css->CrearOptionSelect($DatosCuentas["CuentaPUC"], $DatosCuentas["Nombre"]." (".$DatosCuentas["CuentaPUC"].")", 0);
        }
    $css->CerrarSelect();
    print("<br>");
    $css->CrearTextArea("TxtObservaciones", "", "", "Observaciones", "", "", "", 200, 60, 0, 0);
    print("</td>");
    print("<td colspan='2'>");
    $css->CrearBotonConfirmado("BtnGuardar", "Guardar");
    print("</td>");
    
    $css->CierraFilaTabla(); 
    $css->CerrarTabla();
    $css->CerrarForm();  

}
?>