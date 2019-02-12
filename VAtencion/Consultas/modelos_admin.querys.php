<?php
session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../../images/401.png'>Iniciar Sesion </a>");
  
}

include_once("../../modelo/php_conexion.php");
include_once("../../modelo/PrintPos.php");
include_once("../css_construct.php");
include_once("../clases/ModelosAdmin.class.php");
$css =  new CssIni("");
$idUser=$_SESSION["idUser"];
$obVenta = new ProcesoVenta($idUser);
$obModel= new Modelos($idUser);
$obPrint= new PrintPos($idUser);
function Kardex(){
    $idUser=$_SESSION["idUser"];
    $obVenta = new ProcesoVenta($idUser);   
    $Consulta=$obVenta->ConsultarTabla("facturas_kardex", "WHERE Kardex='NO' and idUsuario='$idUser'");
    while ($DatosFactura=$obVenta->FetchArray($Consulta)){
        $obVenta->DescargueFacturaInventarios($DatosFactura["idFacturas"],"");
        
        $Datos["ID"]=$DatosFactura["idFacturas"];
        $Datos["CuentaDestino"]=$DatosFactura["CuentaDestino"];
        $obVenta->InsertarFacturaLibroDiario($Datos);
        print("Factura $DatosFactura[idFacturas] Contabilizada<br>");
        print("Factura $DatosFactura[idFacturas] descargada de inventarios<br>");
        $obVenta->BorraReg("facturas_kardex", "idFacturas", $DatosFactura["idFacturas"]);
    }
    
     
}

if(isset($_REQUEST["Accion"])){
    
    switch ($_REQUEST["Accion"]){
        case 1: // se anula la prestacion de un servicio
            $idAgenda=$obVenta->normalizar($_REQUEST["idAgenda"]);
            $Observaciones=$obVenta->normalizar($_REQUEST["Observaciones"])." usuario: $idUser";
            $sql="UPDATE modelos_agenda SET Estado='Anulado',Observaciones='$Observaciones' WHERE ID='$idAgenda'";
            $obVenta->Query($sql);
            break;
        case 2: // se cobra el servicio 
            
            
            $idAgenda=$obVenta->normalizar($_REQUEST["idAgenda"]);
            $DatosAgenda=$obVenta->DevuelveValores("modelos_agenda", "ID", $idAgenda);
            
            $HoraInicial=date("Y-m-d H:i:s");
            $Tiempo=$DatosAgenda["Minutos"];
            $HoraFinal=date( "Y-m-d H:i:s" ,strtotime($HoraInicial)+($Tiempo*60));
            
            $sql="UPDATE modelos_agenda SET Estado='Cobrado',HoraInicial='$HoraInicial',HoraATerminar='$HoraFinal' WHERE ID='$idAgenda'";
            $obVenta->Query($sql);
            break;
        case 3: // se factura el servicio
            $idAgenda=$obVenta->normalizar($_REQUEST["idAgenda"]);
            $sql="UPDATE modelos_agenda SET Estado='Facturado' WHERE ID='$idAgenda'";
            $obVenta->Query($sql);
            $NumFactura=$obModel->FacturarServicioModelos($idAgenda, $idUser, "");
            $RutaPrint="PDF_Factura.php?ImgPrintFactura=".$NumFactura;
            $DatosFactura=$obVenta->DevuelveValores("facturas", "idFacturas", $NumFactura);
            $css->CrearNotificacionVerde("Factura Creada Correctamente <a href='$RutaPrint' target='_blank'>Imprimir Factura No. $DatosFactura[NumeroFactura]</a>",16);
            if($TipoKardex=="Automatico"){
                register_shutdown_function('Kardex');
            }
            $obPrint->ImprimeFacturaPOS($NumFactura, "", 1);
            break;
        case 4: //Liquidar Modelos
            $idModelo=0;
            if(isset($_REQUEST["Modelo"])){
                $idModelo=$obVenta->normalizar($_REQUEST["Modelo"]);
            }
            $idCierre=$obModel->CerrarTurnoModelos($idModelo, $idUser, "");
            $obPrint->ImprimirCierreModelos($idCierre, "", 2, "");
            $css->CrearNotificacionRoja("Se realizó el cierre Num. $idCierre", 16);
        break;
        case 5: // se cobra el servicio 
            $idAgenda=$obVenta->normalizar($_REQUEST["idAgenda"]);
            $sql="UPDATE modelos_agenda SET Estado='Finalizado' WHERE ID='$idAgenda'";
            $obVenta->Query($sql);
        break;
            
    }
    goto CargarDatos;
}

$idModelo=$obVenta->normalizar($_REQUEST["Modelo"]);
$DatosModelos=$obVenta->DevuelveValores("modelos_db", "ID", $idModelo);
$sql="SELECT ID FROM modelos_agenda WHERE idModelo='$idModelo' AND (Estado='Abierto' or Estado='Cobrado') LIMIT 1";
$Datos=$obVenta->Query($sql);

if(!$obVenta->FetchArray($Datos) and isset($_REQUEST["Valor"]) and is_numeric($_REQUEST["Valor"])){
    $HoraInicial=$obVenta->normalizar($_REQUEST["HoraInicio"]);
    $Valor=$obVenta->normalizar($_REQUEST["Valor"]);
    $Tiempo=$obVenta->normalizar($_REQUEST["Tiempo"]);
    if($Tiempo==20){
        $ValorModelo=$DatosModelos["ValorServicio1"];
    }

    if($Tiempo==30){
        $ValorModelo=$DatosModelos["ValorServicio2"];
    }

    if($Tiempo==60){
        $ValorModelo=$DatosModelos["ValorServicio3"];
    }
    
    //////Ingreso a agenda   
    $obModel->NuevaAgenda($idModelo, $Valor, $ValorModelo, $Tiempo, $HoraInicial, $idUser, "");
    
}else{
    $css->CrearNotificacionRoja("Error en el envío de los datos, al parecer la modelo ya está ocupada o el valor no es válido", 16);
}

CargarDatos:
    
$css->CrearTabla();
    
$css->FilaTabla(16);
    $css->ColTabla("<strong>Modelo<strong>", 1);
    $css->ColTabla("<strong>ValorServicio<strong>", 1);
    $css->ColTabla("<strong>Minutos<strong>", 1);
    $css->ColTabla("<strong>Termina<strong>", 1);
    $css->ColTabla("<strong>Estado<strong>", 1);
    $css->ColTabla("<strong>Anular<strong>", 1);
    $css->ColTabla("<strong>Cobrar<strong>", 1);
    $css->ColTabla("<strong>Terminar<strong>", 1);
    $css->ColTabla("<strong>Facturar<strong>", 1);
$css->CierraFilaTabla();
$consulta=$obVenta->ConsultarTabla("modelos_agenda", "WHERE Estado='Abierto' OR Estado='Cobrado' ORDER BY HoraATerminar Asc LIMIT 100");
while ($DatosAgenda=$obVenta->FetchArray($consulta)){
    $idAgenda=$DatosAgenda["ID"];
    $DatosModelos=$obVenta->DevuelveValores("modelos_db", "ID", $DatosAgenda["idModelo"]);
    $css->FilaTabla(16);
        $css->ColTabla($DatosModelos["NombreArtistico"], 1);
        $css->ColTabla(number_format($DatosAgenda["ValorPagado"]), 1);
        $css->ColTabla($DatosAgenda["Minutos"], 1);
        print("<td>");
            print("<p name='PHoraIni'>".$DatosAgenda["HoraATerminar"]."</p>");
        print("</td>");
        print("<td style='text-align:center'>");
            print("<div name='Shape' style='background-color:green;color:green;height:20px;width:20px;border-radius:10px;text-align:center'></div>");
        print("</td>");
        print("<td style='text-align:center'>");
        
            $Page="Consultas/modelos_admin.querys.php?Accion=1&idAgenda=".$idAgenda;      
            $Javascript="onClick=EnvieConsultaModelos(`$Page`,``,`DivAgenda`,`3`);return false;";

            $css->CrearImage("ImgDescartar$idAgenda", "../images/delete.png", "Descartar este evento", 30, 30, $Javascript);

       
        
        
                  
        print("</td>");
        
        print("<td style='text-align:center'>");
        
        
        
        if($DatosAgenda["Estado"]=="Abierto"){
            $Page="Consultas/modelos_admin.querys.php?Accion=2&idAgenda=".$idAgenda;      
            $Javascript="onClick=EnvieConsultaModelos(`$Page`,``,`DivAgenda`,`2`);return false;";

            $css->CrearImage("ImgDescartar$idAgenda", "../images/agregar2.png", "Cobrar este servicio", 30, 30, $Javascript);
        }
        
                        
        print("</td>");
        print("<td style='text-align:center'>");
            if($DatosAgenda["Estado"]=="Cobrado"){
                $Page="Consultas/modelos_admin.querys.php?Accion=5&idAgenda=".$idAgenda;      
                $Javascript="onClick=EnvieConsultaModelos(`$Page`,``,`DivAgenda`,`2`);return false;";

                $css->CrearImage("ImgDescartar$idAgenda", "../images/pause3.png", "Finalizar", 30, 30, $Javascript);

            }
        print("</td>");
        print("<td style='text-align:center'>");
        
        $Page="Consultas/modelos_admin.querys.php?Accion=3&idAgenda=".$idAgenda;      
        $Javascript="onClick=EnvieConsultaModelos(`$Page`,``,`DivAgenda`,`4`);return false;";

        $css->CrearImage("ImgDescartar$idAgenda", "../images/facturar1.png", "Descartar este evento", 30, 30, $Javascript);
        $css->CrearDiv("DivOptFact$idAgenda", "", "center", 0, 1);
            
        $css->CerrarDiv();
        print("</td>");
    $css->CierraFilaTabla();
}

$css->CerrarTabla();
?>