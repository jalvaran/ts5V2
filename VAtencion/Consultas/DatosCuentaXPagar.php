<!DOCTYPE html>
<html>
<head>

</head>
<body>

<?php

$myPage="titulos_cuentasxcobrar.php";
include_once("../../modelo/php_conexion.php");
include_once("../css_construct.php");

$css =  new CssIni("");
$obVenta = new ProcesoVenta(1);
$key=$obVenta->normalizar($_GET['key']);
if($key<>""){
    
    

    $css->CrearNotificacionAzul("Datos del Titulo", 16);
    
    $Resultados=$obVenta->ConsultarTabla("titulos_cuentasxcobrar"," WHERE (idTercero = '$key'  OR Mayor = '$key' OR RazonSocial LIKE '%$key%') AND Saldo>0 LIMIT 50");
    if($obVenta->NumRows($Resultados)>0){
        
        
        while($DatosCuentasXCobrar=$obVenta->FetchArray($Resultados)){
            $css->CrearTabla();    
        $css->FilaTabla(16);
        $css->ColTabla('<strong>Abonar</strong>', 1);
        $css->ColTabla('<strong>RazonSocial</strong>', 1);
        $css->ColTabla('<strong>Identificacion</strong>', 1);
        $css->ColTabla('<strong>Direccion</strong>', 1);
        $css->ColTabla('<strong>TotalAbonos</strong>', 1);
        $css->ColTabla('<strong>Saldo</strong>', 1);
        $css->ColTabla('<strong>UltimoPago</strong>', 1);
        $css->ColTabla('<strong>Mayor</strong>', 1);
        $css->ColTabla('<strong>Promocion</strong>', 1);
        $css->CierraFilaTabla();

        $css->FilaTabla(16);
        print("<td>");
        $css->CrearForm2("FrmAbono".$DatosCuentasXCobrar["ID"], $myPage, "post", "_self");
        $css->CrearInputText("TxtIDCuenta", "hidden", "", $DatosCuentasXCobrar["ID"], "", "", "", "", "", "", 0, 0);
        $VarSelect["Ancho"]="200";
        $VarSelect["PlaceHolder"]="Busque un Colaborador";
        $VarSelect["Required"]=1;
        $css->CrearSelectChosen("CmbColaborador".$DatosCuentasXCobrar["ID"], $VarSelect);
        $css->CrearOptionSelect("", "Seleccione un Colaborador" , 0);
        $sql="SELECT * FROM colaboradores";
        $Consulta=$obVenta->Query($sql);
        while($DatosColaborador=$obVenta->FetchArray($Consulta)){
               
               $css->CrearOptionSelect("$DatosColaborador[Identificacion]", "$DatosColaborador[Nombre] / $DatosColaborador[Identificacion]" , 0);
           }
           
        $css->CerrarSelect();
        print("<br>");
        $css->CrearInputFecha("<strong>Fecha: </strong><br>", "TxtFechaAbono".$DatosCuentasXCobrar["ID"], date("Y-m-d"), 100, 30, "");
        print("<br>");
        
        $css->CrearInputNumber("TxtAbono".$DatosCuentasXCobrar["ID"], "number", "<strong>Abono: </strong><br>", 0, "Abono", "black", "", "", 100, 30, 0, 1, 1, $DatosCuentasXCobrar["Saldo"], 1);
        print("<br>");
        $css->CrearTextArea("TxtObservaciones", "", "", "Escriba Si hay observaciones", "black", "", "", 160, 60, 0, 0);
        print("<br>");
        $css->CrearBotonConfirmado("BtnAbonar", "Abonar");
        $css->CerrarForm();
        print("</td>");
        $css->ColTabla($DatosCuentasXCobrar['RazonSocial'], 1);
        $css->ColTabla($DatosCuentasXCobrar['idTercero'], 1);
        $css->ColTabla($DatosCuentasXCobrar['Direccion'], 1);
        $css->ColTabla($DatosCuentasXCobrar['TotalAbonos'], 1);
        $css->ColTabla($DatosCuentasXCobrar['Saldo'], 1);
        $css->ColTabla($DatosCuentasXCobrar['UltimoPago'], 1);
        $css->ColTabla($DatosCuentasXCobrar['Mayor'], 1);
        $css->ColTabla($DatosCuentasXCobrar['Promocion'], 1);
        $css->CierraFilaTabla();
        $css->CerrarTabla();
        $css->CrearTabla(); 
        ///Mostramos abonos
        $ConsultaAbonos=$obVenta->ConsultarTabla("titulos_abonos"," WHERE idVenta=$DatosCuentasXCobrar[idDocumento] AND Estado<>'ANULADO' ORDER BY ID DESC");
        $css->CrearNotificacionAzul("Historial de Abonos de este Titulo", 14);
        $css->FilaTabla(16);
            $css->ColTabla('<strong>ID</strong>', 1);
            $css->ColTabla('<strong>Fecha</strong>', 1);
            $css->ColTabla('<strong>Hora</strong>', 1);
            $css->ColTabla('<strong>idVenta</strong>', 1);
            $css->ColTabla('<strong>Monto</strong>', 1);
            $css->ColTabla('<strong>idColaborador</strong>', 1);
            $css->ColTabla('<strong>NombreColaborador</strong>', 1);
            $css->ColTabla('<strong>idComprobanteIngreso</strong>', 1);
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
            $css->ColTabla($DatosAbonos["idComprobanteIngreso"], 1);
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