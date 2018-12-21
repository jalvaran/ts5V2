<?php 
$myPage="ReporteFiscalIVA.php";
include_once("../sesiones/php_control.php");

include_once("css_construct.php");
$obVenta = new ProcesoVenta($idUser);

print("<html>");
print("<head>");
$css =  new CssIni("Reporte Fiscal IVA");

print("</head>");
print("<body>");
    
        
    $css->CabeceraIni("Reporte Fiscal IVA"); //Inicia la cabecera de la pagina
    
    $css->CabeceraFin(); 
    ///////////////Creamos el contenedor
    /////
    /////
    $css->CrearDiv("principal", "container", "center",1,1);
   
       
    ///////////////Se crea el DIV que servirá de contenedor secundario
    /////
    /////
    $css->CrearDiv("Secundario", "container", "center",1,1);
   										
    $css->CrearNotificacionAzul("Generar Reporte Fiscal de IVA", 16);
    $css->CrearForm2("FrmFiscalIVA", "PDF_Informes_Fiscales.php", "post", "_blank");
        $css->CrearTabla();
            $css->FilaTabla(16);
                $css->ColTabla("<strong>Fecha Inicio</strong>", 1);
                $css->ColTabla("<strong>Fecha Fin</strong>", 1);
                $css->ColTabla("<strong>Empresa</strong>", 1);
                $css->ColTabla("<strong>Centro de Costos</strong>", 1);
                $css->ColTabla("<strong>Sucursal</strong>", 1);
            $css->CierraFilaTabla();
            $css->FilaTabla(16);
                print("<td>");
                    $css->CrearInputFecha("", "TxtFechaIni", date("Y-m-d"), 100, 30, "");
                print("</td>");
                print("<td>");
                    $css->CrearInputFecha("", "TxtFechaFin", date("Y-m-d"), 100, 30, "");
                print("</td>");
                print("<td>");
                    $css->CrearSelect("CmbEmpresa", "");
                        
                        $consulta=$obVenta->ConsultarTabla("empresapro", "");
                        while($DatosEmpresa=$obVenta->FetchArray($consulta)){
                            $css->CrearOptionSelect($DatosEmpresa["idEmpresaPro"], $DatosEmpresa["RazonSocial"]." ".$DatosEmpresa["NIT"], 0);
                        }
                    $css->CerrarSelect();
                print("</td>");
                print("<td>");
                    $css->CrearSelect("CmbCentroCostos", "");
                        $css->CrearOptionSelect("ALL", "Todo", 0);
                        $consulta=$obVenta->ConsultarTabla("centrocosto", "");
                        while($DatosEmpresa=$obVenta->FetchArray($consulta)){
                            $css->CrearOptionSelect($DatosEmpresa["ID"], $DatosEmpresa["Nombre"], 0);
                        }
                    $css->CerrarSelect();
                print("</td>");
                print("<td>");
                    $css->CrearSelect("CmbSucursal", "");
                        $css->CrearOptionSelect("ALL", "Todo", 0);
                        $consulta=$obVenta->ConsultarTabla("empresa_pro_sucursales", "");
                        while($DatosEmpresa=$obVenta->FetchArray($consulta)){
                            $css->CrearOptionSelect($DatosEmpresa["ID"], $DatosEmpresa["Nombre"], 0);
                        }
                    $css->CerrarSelect();
                print("</td>");
            $css->CierraFilaTabla();
            $css->FilaTabla(16);
                print("<td colspan='5' style='text-align:center'>");
                    $css->CrearBotonVerde("BtnReporteFiscalIVA", "Generar");
                print("</td>");
            $css->CierraFilaTabla();
        $css->CerrarTabla();
    $css->CerrarForm();    
    $css->CerrarDiv();//Cerramos contenedor Secundario
    $css->CerrarDiv();//Cerramos contenedor Principal
    $css->AgregaJS(); //Agregamos javascripts
    $css->AgregaSubir();
    $css->Footer();
    print("</body></html>");
    ob_end_flush();
?>