<?php 
$myPage="BalanceComprobacion.php";
include_once("../sesiones/php_control.php");
include_once("../modelo/php_tablas.php");
include_once("clases/ClasesDocumentosExcel.php");
$obTabla = new Tabla($db);
$obVenta = new ProcesoVenta($idUser);
if(isset($_REQUEST["BtnCrearBalanceComprobacion"])){
    $obExcel=new TS5_Excel($db);
    $FechaInicial=$obVenta->normalizar($_REQUEST["TxtFechaIniBC"]);
    $FechaFinal=$obVenta->normalizar($_REQUEST["TxtFechaFinalBC"]);
    $FechaCorte=$obVenta->normalizar($_REQUEST["TxtFechaCorteBC"]);
    $TipoReporte=$obVenta->normalizar($_REQUEST["CmbTipoReporteBC"]);
    $idEmpresa=$obVenta->normalizar($_REQUEST["CmbEmpresaProBC"]);
    $CentroCosto=$obVenta->normalizar($_REQUEST["CmbCentroCostosBC"]);
    $obExcel->GenerarBalanceComprobacionExcel($TipoReporte,$FechaInicial,$FechaFinal,$FechaCorte,$idEmpresa,$CentroCosto,"");
}

include_once("css_construct.php");

function CrearFormularioInformes($VectorInformes) {
   
   $FormName=$VectorInformes["FormName"];
   $ActionForm=$VectorInformes["ActionForm"];
   $Metod=$VectorInformes["Metod"];
   $Target=$VectorInformes["Target"];
   $Titulo=$VectorInformes["Titulo"];
   
   $idUser=$_SESSION['idUser'];
   $obVenta = new ProcesoVenta($idUser);
   $css =  new CssIni("Balance de Comprobacion");
   
   $css->CrearForm2($FormName, $ActionForm, $Metod, $Target);
        $css->CrearTabla();
            $css->FilaTabla(14);
            $css->ColTabla("<strong>$Titulo</strong>", 5);

                $css->CierraFilaTabla();
            $css->FilaTabla(14);
                $css->ColTabla("<strong>TIPO:</strong>", 1);
                $css->ColTabla("<strong>FECHA INICIAL:</strong>", 1);
                $css->ColTabla("<strong>FECHA FINAL:</strong>", 1);
                $css->ColTabla("<strong>EMPRESA:</strong>", 1);
                $css->ColTabla("<strong>CENTRO DE COSTOS:</strong>", 1);  
            $css->CierraFilaTabla();
            $css->FilaTabla(14);
                print("<td>");
                $css->CrearSelect("CmbTipoReporteBC", "");
                    $css->CrearOptionSelect("Corte", "Fecha de Corte", 0);
                    $css->CrearOptionSelect("Rango", "Por Rango de Fechas", 1);
                $css->CerrarSelect();
                print("<br>");
                $css->CrearInputText("TxtFechaCorteBC", "date", "Fecha de Corte:<br>", date("Y-m-d"), "Fecha Corte", "black", "", "", 150, 30, 0, 1);
                print("</td>");
                print("<td>");
                $css->CrearInputText("TxtFechaIniBC", "date", "", date("Y-m-d"), "Fecha Inicial", "black", "", "", 150, 30, 0, 1);
                print("</td>");   
                print("<td>");
                $css->CrearInputText("TxtFechaFinalBC", "date", "", date("Y-m-d"), "Fecha Inicial", "black", "", "", 150, 30, 0, 1);
                print("</td>"); 
                print("<td>");
                $css->CrearSelect("CmbEmpresaProBC", "");
                $css->CrearOptionSelect("ALL", "COMPLETO", 0);                  
                $consulta=$obVenta->ConsultarTabla("empresapro", "");
              
                while($DatosEmpresa=$obVenta->FetchArray($consulta)){
                    $css->CrearOptionSelect($DatosEmpresa["idEmpresaPro"], $DatosEmpresa["RazonSocial"], 0);
                }
                $css->CerrarSelect();
                print("</td>"); 
                print("<td>");
                $css->CrearSelect("CmbCentroCostosBC", "");                
                $consulta=$obVenta->ConsultarTabla("centrocosto", "");
                $css->CrearOptionSelect("ALL", "COMPLETO", 0);                
                while($DatosEmpresa=$obVenta->FetchArray($consulta)){
                    $css->CrearOptionSelect($DatosEmpresa["ID"], $DatosEmpresa["Nombre"], 0);
                }
                $css->CerrarSelect();
                print("</td>"); 
            $css->FilaTabla(16);
            print("<td colspan='5' style='text-align:center'>");
            $Nombre="BtnCrearBalanceComprobacion";
            $Page="ProcesadoresJS/GeneradorExcel.php?idDocumento=1&Carry="; //SIn uso por error al generar
            $FuncionJS="EnvieObjetoConsulta2(`$Page`,`$Nombre`,`_blank`,`2`);return false ;";
            $css->CrearBotonEvento($Nombre,"Generar",1,"","","verde","");
            print("</td>");
            $css->CierraFilaTabla();
        $css->CerrarTabla();
    $css->CerrarForm(); 
}

function CrearFormularioBalance($VectorInformes) {
   
   $FormName=$VectorInformes["FormName"];
   $ActionForm=$VectorInformes["ActionForm"];
   $Metod=$VectorInformes["Metod"];
   $Target=$VectorInformes["Target"];
   $Titulo=$VectorInformes["Titulo"];
   
   $idUser=$_SESSION['idUser'];
   $obVenta = new ProcesoVenta($idUser);
   $css =  new CssIni("Balance General");
   
   $css->CrearForm2($FormName, $ActionForm, $Metod, $Target);
        $css->CrearTabla();
            $css->FilaTabla(14);
            $css->ColTabla("<strong>$Titulo</strong>", 5);

                $css->CierraFilaTabla();
            $css->FilaTabla(14);
                $css->ColTabla("<strong>CORTE:</strong>", 1);
                
                $css->ColTabla("<strong>EMPRESA:</strong>", 1);
                $css->ColTabla("<strong>CENTRO DE COSTOS:</strong>", 1);  
            $css->CierraFilaTabla();
            $css->FilaTabla(14);
                print("<td>");
                
                $css->CrearInputText("TxtFechaCorteBalance", "date", "Fecha de Corte:<br>", date("Y-m-d"), "Fecha Corte", "black", "", "", 150, 30, 0, 1);
                print("</td>");
                
                print("<td>");
                $css->CrearSelect("CmbEmpresaPro", "");
                $css->CrearOptionSelect("ALL", "COMPLETO", 0);                  
                $consulta=$obVenta->ConsultarTabla("empresapro", "");
              
                while($DatosEmpresa=$obVenta->FetchArray($consulta)){
                    $css->CrearOptionSelect($DatosEmpresa["idEmpresaPro"], $DatosEmpresa["RazonSocial"], 0);
                }
                $css->CerrarSelect();
                print("</td>"); 
                print("<td>");
                $css->CrearSelect("CmbCentroCostos", "");                
                $consulta=$obVenta->ConsultarTabla("centrocosto", "");
                $css->CrearOptionSelect("ALL", "COMPLETO", 0);                
                while($DatosEmpresa=$obVenta->FetchArray($consulta)){
                    $css->CrearOptionSelect($DatosEmpresa["ID"], $DatosEmpresa["Nombre"], 0);
                }
                $css->CerrarSelect();
                print("</td>"); 
            $css->FilaTabla(16);
            print("<td colspan='5' style='text-align:center'>");
            $css->CrearBotonVerde("BtnVerInforme", "Generar Informe");
            print("</td>");
            $css->CierraFilaTabla();
        $css->CerrarTabla();
    $css->CerrarForm(); 
}

function CrearFormularioEstado($VectorInformes) {
   
   $FormName=$VectorInformes["FormName"];
   $ActionForm=$VectorInformes["ActionForm"];
   $Metod=$VectorInformes["Metod"];
   $Target=$VectorInformes["Target"];
   $Titulo=$VectorInformes["Titulo"];
   
   $idUser=$_SESSION['idUser'];
   $obVenta = new ProcesoVenta($idUser);
   $css =  new CssIni("Estado de Resultados");
   
   $css->CrearForm2($FormName, $ActionForm, $Metod, $Target);
        $css->CrearTabla();
            $css->FilaTabla(14);
            $css->ColTabla("<strong>$Titulo</strong>", 5);

                $css->CierraFilaTabla();
            $css->FilaTabla(14);
                $css->ColTabla("<strong>TIPO:</strong>", 1);
                $css->ColTabla("<strong>FECHA INICIAL:</strong>", 1);
                $css->ColTabla("<strong>FECHA FINAL:</strong>", 1);
                $css->ColTabla("<strong>EMPRESA:</strong>", 1);
                $css->ColTabla("<strong>CENTRO DE COSTOS:</strong>", 1);  
            $css->CierraFilaTabla();
            $css->FilaTabla(14);
                print("<td>");
                $css->CrearSelect("CmbTipoReporteER", "");
                    $css->CrearOptionSelect("Corte", "Fecha de Corte", 0);
                    $css->CrearOptionSelect("Rango", "Por Rango de Fechas", 1);
                $css->CerrarSelect();
                print("<br>");
                $css->CrearInputText("TxtFechaCorteBalance", "date", "Fecha de Corte:<br>", date("Y-m-d"), "Fecha Corte", "black", "", "", 150, 30, 0, 1);
                print("</td>");
                print("<td>");
                
                $css->CrearInputText("TxtFechaIniER", "date", "", date("Y-m-d"), "Fecha Inicial", "black", "", "", 150, 30, 0, 1);
                print("</td>");
                print("<td>");
                
                $css->CrearInputText("TxtFechaFinER", "date", "", date("Y-m-d"), "Fecha Final", "black", "", "", 150, 30, 0, 1);
                print("</td>");
                print("<td>");
                $css->CrearSelect("CmbEmpresaPro", "");
                $css->CrearOptionSelect("ALL", "COMPLETO", 0);                  
                $consulta=$obVenta->ConsultarTabla("empresapro", "");
              
                while($DatosEmpresa=$obVenta->FetchArray($consulta)){
                    $css->CrearOptionSelect($DatosEmpresa["idEmpresaPro"], $DatosEmpresa["RazonSocial"], 0);
                }
                $css->CerrarSelect();
                print("</td>"); 
                print("<td>");
                $css->CrearSelect("CmbCentroCostos", "");                
                $consulta=$obVenta->ConsultarTabla("centrocosto", "");
                $css->CrearOptionSelect("ALL", "COMPLETO", 0);                
                while($DatosEmpresa=$obVenta->FetchArray($consulta)){
                    $css->CrearOptionSelect($DatosEmpresa["ID"], $DatosEmpresa["Nombre"], 0);
                }
                $css->CerrarSelect();
                print("</td>"); 
            $css->FilaTabla(16);
            print("<td colspan='5' style='text-align:center'>");
            $css->CrearBotonNaranja("BtnVerEstadoResultados", "Generar Informe");
            print("</td>");
            $css->CierraFilaTabla();
        $css->CerrarTabla();
    $css->CerrarForm(); 
}

function CrearFormularioInterface($VectorInformes) {
   
   $FormName=$VectorInformes["FormName"];
   $ActionForm=$VectorInformes["ActionForm"];
   $Metod=$VectorInformes["Metod"];
   $Target=$VectorInformes["Target"];
   $Titulo=$VectorInformes["Titulo"];
   $Tipo=$VectorInformes["Tipo"];
   $idUser=$_SESSION['idUser'];
   $obVenta = new ProcesoVenta($idUser);
   $css =  new CssIni("Balance de Comprobacion");
   
   $css->CrearForm2($FormName, $ActionForm, $Metod, $Target);
   $css->CrearInputText("TxtTipoInforme", "hidden", "", $Tipo, "", "", "", "", "", "", 0, 0);
        $css->CrearTabla();
            $css->FilaTabla(14);
            $css->ColTabla("<strong>$Titulo</strong>", 5);

                $css->CierraFilaTabla();
            $css->FilaTabla(14);
                
                $css->ColTabla("<strong>FECHA INICIAL:</strong>", 1);
                $css->ColTabla("<strong>FECHA FINAL:</strong>", 1);
                $css->ColTabla("<strong>EMPRESA:</strong>", 1);
                $css->ColTabla("<strong>CENTRO DE COSTOS:</strong>", 1);  
            $css->CierraFilaTabla();
            $css->FilaTabla(14);
                
                print("<td>");
                $css->CrearInputText("TxtFechaIni", "date", "", date("Y-m-d"), "Fecha Inicial", "black", "", "", 150, 30, 0, 1);
                print("</td>");   
                print("<td>");
                $css->CrearInputText("TxtFechaFinal", "date", "", date("Y-m-d"), "Fecha Inicial", "black", "", "", 150, 30, 0, 1);
                print("</td>"); 
                print("<td>");
                $css->CrearSelect("CmbEmpresaPro", "");
                $css->CrearOptionSelect("ALL", "COMPLETO", 0);                  
                $consulta=$obVenta->ConsultarTabla("empresapro", "");
              
                while($DatosEmpresa=$obVenta->FetchArray($consulta)){
                    $css->CrearOptionSelect($DatosEmpresa["idEmpresaPro"], $DatosEmpresa["RazonSocial"], 0);
                }
                $css->CerrarSelect();
                print("</td>"); 
                print("<td>");
                $css->CrearSelect("CmbCentroCostos", "");                
                $consulta=$obVenta->ConsultarTabla("centrocosto", "");
                $css->CrearOptionSelect("ALL", "COMPLETO", 0);                
                while($DatosEmpresa=$obVenta->FetchArray($consulta)){
                    $css->CrearOptionSelect($DatosEmpresa["ID"], $DatosEmpresa["Nombre"], 0);
                }
                $css->CerrarSelect();
                print("</td>"); 
            $css->FilaTabla(16);
            print("<td colspan='5' style='text-align:center'>");
            $css->CrearBotonVerde("BtnVerInterfaz", "Generar Informe");
            print("</td>");
            $css->CierraFilaTabla();
        $css->CerrarTabla();
    $css->CerrarForm(); 
}
print("<html>");
print("<head>");
$css =  new CssIni("Balance de Comprobacion");

print("</head>");




print("<body>");
    
    
    
    $css->CabeceraIni("Balance de Comprobacion"); //Inicia la cabecera de la pagina
    
    
    $css->CabeceraFin(); 
    ///////////////Creamos el contenedor
    /////
    /////
    $css->CrearDiv("principal", "container", "center",1,1);
    print("<br>");
    ///////////////Creamos la imagen representativa de la pagina
    /////
    /////	
    $css->CrearImageLink("../VMenu/MnuInformes.php", "../images/balance.png", "_self",200,200);
    
    
    ///////////////Se crea el DIV que servirá de contenedor secundario
    /////
    /////
    $css->CrearDiv("Secundario", "container", "center",1,1);
    $css->CrearDiv("DivProcesos", "", "center", 1, 1);
    $css->CerrarDiv();
    $css->CrearNotificacionAzul("GENERAR BALANCE DE COMPROBACION", 16);
    
    $VectorInformes["FormName"]="FormBalanceComprobacion";
    $VectorInformes["ActionForm"]=$myPage;
    $VectorInformes["Metod"]="post";
    $VectorInformes["Target"]="_self";
    $VectorInformes["Titulo"]="BALANCE GENERAL";
    CrearFormularioInformes($VectorInformes);
      
    $css->CrearNotificacionVerde("GENERAR BALANCE GENERAL", 16);
    
    $VectorInformes["FormName"]="FormBalanceGeneral";
    $VectorInformes["ActionForm"]="EstadosFinancieros.php";
    $VectorInformes["Metod"]="post";
    $VectorInformes["Target"]="_blank";
    $VectorInformes["Titulo"]="BALANCE GENERAL";
    CrearFormularioBalance($VectorInformes);
    
    $css->CrearNotificacionNaranja("GENERAR ESTADO DE RESULTADOS DETALLADO", 16);
    
    $VectorInformes["FormName"]="FormEstadoResultados";
    $VectorInformes["ActionForm"]="EstadosFinancieros.php";
    $VectorInformes["Metod"]="post";
    $VectorInformes["Target"]="_blank";
    $VectorInformes["Titulo"]="ESTADO DE RESULTADOS";
    CrearFormularioEstado($VectorInformes);
    /*
   
    $css->CrearNotificacionAzul("GENERAR INTERFACE INGRESOS", 16);
    
    $VectorInformes["FormName"]="FormInterfaceIngresos";
    $VectorInformes["ActionForm"]="GenereInterfaceIngresos.php";
    $VectorInformes["Metod"]="post";
    $VectorInformes["Target"]="_blank";
    $VectorInformes["Tipo"]="I";
    $VectorInformes["Titulo"]="INTERFACE DE INGRESOS";
    CrearFormularioInterface($VectorInformes);
    
    $css->CrearNotificacionNaranja("GENERAR INTERFACE EGRESOS", 16);
    
    $VectorInformes["FormName"]="FormInterfaceEgresos";
    $VectorInformes["ActionForm"]="GenereInterfaceIngresos.php";
    $VectorInformes["Metod"]="post";
    $VectorInformes["Target"]="_blank";
    $VectorInformes["Tipo"]="E";
    $VectorInformes["Titulo"]="INTERFACE DE EGRESOS";
    CrearFormularioInterface($VectorInformes);
    *
     * 
     */
    $css->CerrarDiv();//Cerramos contenedor Secundario
    $css->CerrarDiv();//Cerramos contenedor Principal
    $css->AgregaJS(); //Agregamos javascripts
    $css->AgregaSubir();
    $css->Footer();
    print("</body></html>");
?>