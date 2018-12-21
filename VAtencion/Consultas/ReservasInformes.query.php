<?php
include_once("../../modelo/php_conexion.php");
include_once("../css_construct.php");
include_once("../clases/ReservaEspacios.class.php");

session_start();
$idUser=$_SESSION['idUser'];
$css =  new CssIni("");


if(isset($_REQUEST["TxtFechaInicial"]) and isset($_REQUEST["TxtFechaFinal"])){
    $obReserva = new Reserva($idUser);
    $FechaInicial=$obReserva->normalizar($_REQUEST["TxtFechaInicial"]);
    $FechaFinal=$obReserva->normalizar($_REQUEST["TxtFechaFinal"]);

    $css->CrearNotificacionAzul("Informe del $FechaInicial al $FechaFinal", 16);
    
    $css->CrearDiv("DivTotales", "", "center", 1, 1);
    $sql="SELECT SUM(Tarifa) as Totales,count(ID) as Items, Estado FROM reservas_eventos WHERE `FechaInicio` >= '$FechaInicial 00:00:00' AND `FechaInicio` <= '$FechaFinal 23:59:59' GROUP BY Estado";
    $Datos=$obReserva->Query($sql);
    
    $css->CrearTabla();
        $css->FilaTabla(16);
            $css->ColTabla("<strong>Tipo</strong>", 1);
            $css->ColTabla("<strong>Items</strong>", 1);
            $css->ColTabla("<strong>Total</strong>", 1);
        $css->CierraFilaTabla();
        $Total=0;
        $TotalItems=0;
        while($DatosSumas=$obReserva->FetchArray($Datos)){
            $Total=$Total+$DatosSumas["Totales"];
            $TotalItems=$TotalItems+$DatosSumas["Items"];
            $css->FilaTabla(16);
                print("<td>");
                    if($DatosSumas["Estado"]=="FA"){
                        $Tipo="FACTURADAS";
                    }
                    if($DatosSumas["Estado"]=="AN"){
                        $Tipo="ANULADAS";
                    }
                    if($DatosSumas["Estado"]=="RE"){
                        $Tipo="RESERVADA";
                    }
                    print($Tipo);
                print("</td>");
                $css->ColTabla($DatosSumas["Items"], 1);
                print("<td style='text-align:right'>");
                    print(number_format($DatosSumas["Totales"]));
                print("</td>");
            $css->CierraFilaTabla();
        }
        $css->FilaTabla(16);
            print("<td style='text-align:right'>");
            print("<strong>Totales</strong>");
            print("</td>");
            $css->ColTabla("<strong>". number_format($TotalItems)."</strong>", 1);
            print("<td style='text-align:right'>");
            print("<strong>". number_format($Total)."</strong>");
            print("</td>");
        $css->CierraFilaTabla();
    $css->CerrarTabla();
$css->CerrarDiv();
    
}


?>