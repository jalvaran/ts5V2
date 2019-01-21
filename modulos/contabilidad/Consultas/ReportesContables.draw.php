<?php

session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];

include_once("../clases/ReportesContables.class.php");
include_once("../clases/PDF_ReportesContables.class.php");
include_once("../../../constructores/paginas_constructor.php");

if( !empty($_REQUEST["Accion"]) ){
    $css =  new PageConstruct("", "", 1, "", 1, 0);
    $obCon = new Contabilidad($idUser);
    
    switch ($_REQUEST["Accion"]) {
        case 1: //Crea las opciones para el reporte de Balance por terceros
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
            $css->CrearDiv("", "col-md-3", "center", 1, 1);
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
            $css->CrearDiv("", "col-md-3", "center", 1, 1);
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

                $css->CrearBotonEvento("BtnCrearReporte", "Generar", 1, "onClick", "GenereBalanceXTerceros()", "verde", "");

            $css->CerrarDiv();
            $css->CrearDiv("DivAccion", "col-md-4", "center", 1, 1);
            $css->CerrarDiv();
        break; 
    
        case 2: //Crea la vista para el balance x tercero
            $Tipo=$obCon->normalizar($_REQUEST["CmbTipo"]);
            $FechaInicial=$obCon->normalizar($_REQUEST["TxtFechaInicial"]);
            $FechaFinal=$obCon->normalizar($_REQUEST["TxtFechaFinal"]);
            $Empresa=$obCon->normalizar($_REQUEST["CmbCentroCosto"]);
            $CentroCostos=$obCon->normalizar($_REQUEST["CmbEmpresa"]);                        
            $obCon->ConstruirVistaBalanceTercero($Tipo, $FechaInicial, $FechaFinal, $Empresa, $CentroCostos, "");
            print("OKBXT");
        break; 
    
        case 3: //Crea las opciones para el certificado de retenciones
            
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
            
            $css->CrearDiv("", "col-md-4", "center", 1, 1);
                $css->fieldset("", "", "FieldReporte", "Reporte", "", "");
                    $css->legend("", "");
                        print("<a href='#'>Tercero</a>");
                    $css->Clegend();
                    $css->select("CmbTercero", "form-control", "CmbTercero", "", "", "", "");                
                        $css->option("", "", "", "", "", "");
                            print("Seleccione un tercero");
                        $css->Coption();
                        
                    $css->Cselect();
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
            $css->CrearDiv("", "col-md-6", "center", 1, 1);
                
                    $css->select("CmbCiudadRetencion", "form-control", "CmbCiudadRetencion", "", "", "", "");                
                        $css->option("", "", "", "", "", "");
                            print("Ciudad donde se practicó la Retención");
                        $css->Coption();                        
                    $css->Cselect();
                
            $css->CerrarDiv();
            
            $css->CrearDiv("", "col-md-6", "center", 1, 1);
                
                    $css->select("CmbCiudadPago", "form-control", "CmbCiudadPago", "", "", "", "");                
                        $css->option("", "", "", "", "", "");
                            print("Ciudad donde se consignó la Retención");
                        $css->Coption();                        
                    $css->Cselect();
                
            $css->CerrarDiv();
            
            print("<br><br><br>");
            $css->CrearDiv("DivAccion", "col-md-4", "center", 1, 1);
            $css->CerrarDiv();
            $css->CrearDiv("DivAccion", "col-md-4", "center", 1, 1);

                $css->CrearBotonEvento("BtnCrearReporte", "Generar", 1, "onClick", "GenereCertificaRetenciones()", "verde", "");

            $css->CerrarDiv();
            $css->CrearDiv("DivAccion", "col-md-4", "center", 1, 1);
            $css->CerrarDiv();
        break; //Fin caso 3
        case 4: //Crea la vista para el balance x tercero
            
            $FechaInicial=$obCon->normalizar($_REQUEST["TxtFechaInicial"]);
            $FechaFinal=$obCon->normalizar($_REQUEST["TxtFechaFinal"]);
            $Empresa=$obCon->normalizar($_REQUEST["CmbEmpresa"]);
            $CentroCostos=$obCon->normalizar($_REQUEST["CmbCentroCosto"]);  
            $CmbTercero=$obCon->normalizar($_REQUEST["CmbTercero"]);
            $CmbCiudadRetencion=$obCon->normalizar($_REQUEST["CmbCiudadRetencion"]);
            $CmbCiudadPago=$obCon->normalizar($_REQUEST["CmbCiudadPago"]);
            
            $page="../../general/Consultas/PDF_Documentos.draw.php?idDocumento=34&TxtFechaInicial=$FechaInicial&TxtFechaFinal=$FechaFinal"; 
            $page.="&CmbEmpresa=$Empresa&CmbCentroCosto=$CentroCostos&CmbTercero=$CmbTercero&CmbCiudadPago=$CmbCiudadPago&CmbCiudadRetencion=$CmbCiudadRetencion";
            $Target="FramePDF";
            //$Target="_blank";
            print("<a href='$page' id='LinkPDF' target='$Target'></a>");
        break; // fin caso 4
    
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>