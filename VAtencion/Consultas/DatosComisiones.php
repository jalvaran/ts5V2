<!DOCTYPE html>
<html>
<head>

</head>
<body>

<?php
session_start();
$idUser=$_SESSION['idUser'];
$TipoUser=$_SESSION['tipouser'];
$myPage="titulos_comisiones.php";
include_once("../../modelo/php_conexion.php");
include_once("../css_construct.php");

$css =  new CssIni("");
$obVenta = new ProcesoVenta($idUser);
$key=$obVenta->normalizar($_GET['key']);
if($key<>""){
    
    

    $css->CrearNotificacionAzul("Datos del Titulo", 16);
    
    $Resultados=$obVenta->ConsultarTabla("titulos_ventas"," WHERE (idColaborador = '$key'  OR Mayor1 = '$key' OR NombreColaborador LIKE '%$key%') AND SaldoComision>0 AND Estado='' ORDER BY ID DESC  LIMIT 100");
    if($obVenta->NumRows($Resultados)>0){
        
        
        while($DatosCuentasXCobrar=$obVenta->FetchArray($Resultados)){
        
        $css->CrearTabla();    
        $css->FilaTabla(16);
        $css->ColTabla('<strong>Pagar</strong>', 1);
        $css->ColTabla('<strong>Promocion</strong>', 1);
        $css->ColTabla('<strong>Mayor</strong>', 1);
        $css->ColTabla('<strong>idColaborador</strong>', 1);
        $css->ColTabla('<strong>NombreColaborador</strong>', 1);
        $css->ColTabla('<strong>Abonos Recibidos</strong>', 1);
        $css->ColTabla('<strong>Comision A Pagar</strong>', 1);
        $css->ColTabla('<strong>Saldo Comision</strong>', 1);
        $css->ColTabla('<strong>Total Pagado</strong>', 1);
        $css->CierraFilaTabla();

        $css->FilaTabla(16);
        print("<td>");
        $css->CrearForm2("FrmPago".$DatosCuentasXCobrar["ID"], $myPage, "post", "_self");
        $css->CrearInputText("TxtIDVenta", "hidden", "", $DatosCuentasXCobrar["ID"], "", "", "", "", "", "", 0, 0);
        
        $css->CrearInputFecha("<strong>Fecha: </strong><br>", "TxtFechaPago".$DatosCuentasXCobrar["ID"], date("Y-m-d"), 100, 30, "");
        print("<br>");
        
        $css->CrearInputNumber("TxtPagoComision".$DatosCuentasXCobrar["ID"], "number", "<strong>Pago: </strong><br>", 0, "Pago", "black", "", "", 100, 30, 0, 1, 1, $DatosCuentasXCobrar["SaldoComision"], 1);
        print("<br>");
        $css->CrearTextArea("TxtObservaciones", "", "", "Escriba Si hay observaciones", "black", "", "", 160, 60, 0, 0);
        print("<br>");
        $css->CrearBotonConfirmado("BtnPagarComision", "Pagar");
        $css->CerrarForm();
        print("</td>");
        $css->ColTabla($DatosCuentasXCobrar['Promocion'], 1);
        $css->ColTabla($DatosCuentasXCobrar['Mayor1'], 1);
        $css->ColTabla($DatosCuentasXCobrar['idColaborador'], 1);
        $css->ColTabla($DatosCuentasXCobrar['NombreColaborador'], 1);
        $css->ColTabla(number_format($DatosCuentasXCobrar['TotalAbonos']), 1);
        $css->ColTabla(number_format($DatosCuentasXCobrar['ComisionAPagar']), 1);
        $css->ColTabla(number_format($DatosCuentasXCobrar['SaldoComision']), 1);
        $css->ColTabla(number_format($DatosCuentasXCobrar['ComisionAPagar']-$DatosCuentasXCobrar['SaldoComision']), 1);

        $css->CierraFilaTabla();
        $css->CerrarTabla();
        $css->CrearTabla(); 
        ///Mostramos abonos
        $ConsultaAbonos=$obVenta->ConsultarTabla("titulos_comisiones"," WHERE idVenta=$DatosCuentasXCobrar[ID] ORDER BY ID DESC");
        $css->CrearNotificacionAzul("Historial de Pago de Comisiones de este Titulo", 14);
        $css->FilaTabla(16);
            $css->ColTabla('<strong>ID</strong>', 1);
            $css->ColTabla('<strong>Fecha</strong>', 1);
            $css->ColTabla('<strong>Hora</strong>', 1);
            $css->ColTabla('<strong>idVenta</strong>', 1);
            $css->ColTabla('<strong>Monto</strong>', 1);
            $css->ColTabla('<strong>idColaborador</strong>', 1);
            $css->ColTabla('<strong>NombreColaborador</strong>', 1);
            $css->ColTabla('<strong>idEgreso</strong>', 1);
            $css->ColTabla('<strong>Observaciones</strong>', 1);
            $css->CierraFilaTabla();
        while($DatosAbonos=$obVenta->FetchArray($ConsultaAbonos)){
            $css->FilaTabla(16);
            $css->ColTabla($DatosAbonos["ID"], 1);
            $css->ColTabla($DatosAbonos["Fecha"], 1);
            $css->ColTabla($DatosAbonos["Hora"], 1);
            $css->ColTabla($DatosAbonos["idVenta"], 1);
            $css->ColTabla($DatosAbonos["Monto"], 1);
            $css->ColTabla($DatosAbonos["idColaborador"], 1);
            $css->ColTabla($DatosAbonos["NombreColaborador"], 1);
            $css->ColTabla($DatosAbonos["idEgreso"], 1);
            $css->ColTabla($DatosAbonos["Observaciones"], 1);
           
            $css->CierraFilaTabla();
        }
        $css->CerrarTabla();
        }
        //$css->CerrarTabla(); 
    }else{
       $css->CrearNotificacionRoja("Sin Resultados", 16); 
    }
    
}else{
    $css->CrearNotificacionRoja("Digite un Dato", 16);
}
$css->AgregaJS(); //Agregamos javascripts
?>
    
</body>
</html>