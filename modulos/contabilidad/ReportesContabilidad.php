<?php
/**
 * Reportes de contabilidad
 * 2019-01-08, Julian Alvaran Techno Soluciones SAS
 * 
 * es recomendable No usar los siguientes ID para ningún objeto:
 * FrmModal, ModalAcciones,DivFormularios,BtnModalGuardar,DivOpcionesTablas,
 * DivControlCampos,DivOpciones1,DivOpciones2,DivOpciones3,DivParametrosTablas
 * TxtTabla, TxtCondicion,TxtOrdenNombreColumna,TxtOrdenTabla,TxtLimit,TxtPage,tabla
 * 
 */
$myPage="ReportesContabilidad.php";
$myTitulo="Reportes Contables";
include_once("../../sesiones/php_control_usuarios.php");
include_once("../../constructores/paginas_constructor.php");

$css = new PageConstruct($myTitulo, "", "", "");
$obCon = new conexion($idUser); //Conexion a la base de datos

$css->PageInit($myTitulo);
        
    $css->CrearDiv("", "col-md-2", "center", 1, 1);   
        $css->fieldset("", "", "FieldReporte", "Reporte", "", "");
            $css->legend("", "");
                print("<a href='#'>Reporte</a>");
            $css->Clegend();
            $css->select("CmbReporteContable", "form-control", "CmbReporteContable", "", "", "", "");
                $css->option("", "", "", "", "", "");
                    print("Seleccione");
                $css->Coption();
                $css->option("", "", "Balance x Terceros", 1, "", "");
                    print("Balance por Terceros");
                $css->Coption();
                
            $css->Cselect();
        $css->Cfieldset();
    $css->CerrarDiv();
    $css->CrearDiv("", "col-md-2", "center", 1, 1);
        $css->fieldset("", "", "FieldReporte", "Reporte", "", "");
            $css->legend("", "");
                print("<a href='#'>Tipo</a>");
            $css->Clegend();
            $css->select("CmbTipo", "form-control", "CmbTipo", "", "", "", "");                
                $css->option("", "", "Rango", 1, "", "");
                    print("Rango de fechas");
                $css->Coption();
                $css->option("", "", "Fecha de Corte", 2, "", "");
                    print("Fecha de Corte");
                $css->Coption();                
            $css->Cselect();
        $css->Cfieldset();
    $css->CerrarDiv();
    $css->CrearDiv("", "col-md-2", "center", 1, 1);
        $css->fieldset("", "", "FieldReporte", "Reporte", "", "");
            $css->legend("", "");
                print("<a href='#'>Fecha Inicial</a>");
            $css->Clegend();           
            $css->input("date", "TxtFechaInicial", "form-control", "TxtFechaInicial", "", date("Y-m-d"), "Fecha Inicial", "off", "", "style='line-height: 15px;'");
        $css->Cfieldset();
    $css->CerrarDiv();
    $css->CrearDiv("", "col-md-2", "center", 1, 1);
        $css->fieldset("", "", "FieldReporte", "Reporte", "", "");
            $css->legend("", "");
                print("<a href='#'>Fecha Final</a>");
            $css->Clegend();           
            $css->input("date", "TxtFechaFinal", "form-control", "TxtFechaFinal", "", date("Y-m-d"), "Fecha Inicial", "off", "", "style='line-height: 15px;'");
        $css->Cfieldset();
    $css->CerrarDiv();
    $css->CrearDiv("", "col-md-2", "center", 1, 1);
        $css->fieldset("", "", "FieldReporte", "Reporte", "", "");
            $css->legend("", "");
                print("<a href='#'>Empresa</a>");
            $css->Clegend();
            $css->select("CmbEmpresa", "form-control", "CmbEmpresa", "", "", "", "");                
                $css->option("", "", "", "ALL", "", "");
                    print("Completo");
                $css->Coption();
                $consulta=$obCon->ConsultarTabla("empresapro", "");
                while($DatosEmpresa=$obCon->FetchAssoc($consulta)){
                    $css->option("", "", "", $DatosEmpresa["idEmpresaPro"], "", "");
                        print($DatosEmpresa["idEmpresaPro"]." ".$DatosEmpresa["RazonSocial"]." ".$DatosEmpresa["NIT"]);
                    $css->Coption();
                }
            $css->Cselect();
        $css->Cfieldset();
    $css->CerrarDiv();
    $css->CrearDiv("", "col-md-2", "center", 1, 1);
        $css->fieldset("", "", "FieldReporte", "Reporte", "", "");
            $css->legend("", "");
                print("<a href='#'>Centro de Costos</a>");
            $css->Clegend();
            $css->select("CmbCentroCosto", "form-control", "CmbCentroCosto", "", "", "", "");                
                $css->option("", "", "", "ALL", "", "");
                    print("Completo");
                $css->Coption();
                $consulta=$obCon->ConsultarTabla("centrocosto", "");
                while($DatosEmpresa=$obCon->FetchAssoc($consulta)){
                    $css->option("", "", "", $DatosEmpresa["ID"], "", "");
                        print($DatosEmpresa["ID"]." ".$DatosEmpresa["Nombre"]);
                    $css->Coption();
                }
            $css->Cselect();
        $css->Cfieldset();
    $css->CerrarDiv();
    print("<br><br><br><br><br>");
    $css->CrearDiv("DivAccion", "col-md-4", "center", 1, 1);
    $css->CerrarDiv();
    $css->CrearDiv("DivAccion", "col-md-4", "center", 1, 1);
        
        $css->CrearBotonEvento("BtnCrearReporte", "Generar", 1, "onClick", "GenereReporte()", "verde", "");
        
    $css->CerrarDiv();
    $css->CrearDiv("DivAccion", "col-md-4", "center", 1, 1);
    $css->CerrarDiv();
    print("<br><br><br><br><br>");
    $css->CrearDiv("DivOpcionesReportes", "", "center", 1, 1);
    $css->CerrarDiv();
    $css->CrearDiv("DivReportesContables", "", "center", 1, 1);
    $css->CerrarDiv();  
$css->PageFin();

print('<script src="../../general/js/notificaciones.js"></script>');
print('<script src="jsPages/ReportesContabilidad.js"></script>');
$css->Cbody();
$css->Chtml();

?>