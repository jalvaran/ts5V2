<?php 
$myPage="Auxiliares.php";
include_once("../sesiones/php_control.php");
include_once("clases/ClasesDocumentosExcel.php");
$obVenta = new ProcesoVenta($idUser);
$obTabla = new Tabla($db);
if(isset($_REQUEST["BtnVerInforme"])){
    
    $FechaInicial=$obVenta->normalizar($_REQUEST["TxtFechaIni"]);
    $FechaFinal=$obVenta->normalizar($_REQUEST["TxtFechaFinal"]);
    $FechaCorte=$obVenta->normalizar($_REQUEST["TxtFechaCorte"]);
    $TipoReporte=$obVenta->normalizar($_REQUEST["CmbTipoReporte"]);
    $CuentaPUC=$obVenta->normalizar($_REQUEST["TxtCuentaPUC"]);
    $TipoFiltro=$obVenta->normalizar($_REQUEST["CmbFiltro"]);
    $Tercero=$obVenta->normalizar($_REQUEST["TxtTercero"]);
    $obTabla->ExcelAuxiliarDetallado($TipoReporte,$FechaInicial,$FechaFinal,$FechaCorte,$CuentaPUC,$TipoFiltro,$Tercero,"");
}
// Genera un auxiliar x documento
if(isset($_REQUEST["BtnVerAuxDoc"])){
    $obDocExcel = new TS5_Excel($db);
    $FechaInicial=$obVenta->normalizar($_REQUEST["TxtFechaIni"]);
    $FechaFinal=$obVenta->normalizar($_REQUEST["TxtFechaFinal"]);
    
    $obDocExcel->AuxiliarXDocumento($FechaInicial, $FechaFinal, "");
}

// Genera un auxiliar x documento
if(isset($_REQUEST["BtnVerAuxTer"])){
    $obDocExcel = new TS5_Excel($db);
    $FechaInicial=$obVenta->normalizar($_REQUEST["TxtFechaIni"]);
    $FechaFinal=$obVenta->normalizar($_REQUEST["TxtFechaFinal"]);
    
    $obDocExcel->AuxiliarXTercero($FechaInicial, $FechaFinal, "");
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
   $css =  new CssIni("Informe de Compras");
   
   $css->CrearForm2($FormName, $ActionForm, $Metod, $Target);
        $css->CrearTabla();
            $css->FilaTabla(14);
            $css->ColTabla("<strong>$Titulo</strong>", 5);

                $css->CierraFilaTabla();
            $css->FilaTabla(14);
                $css->ColTabla("<strong>TIPO:</strong>", 1);
                $css->ColTabla("<strong>FECHA INICIAL:</strong>", 1);
                $css->ColTabla("<strong>FECHA FINAL:</strong>", 1);
                $css->ColTabla("<strong>CUENTA:</strong>", 1);
            $css->CierraFilaTabla();
            $css->FilaTabla(14);
                print("<td>");
                $css->CrearSelect("CmbTipoReporte", "");
                    $css->CrearOptionSelect("Corte", "Fecha de Corte", 0);
                    $css->CrearOptionSelect("Rango", "Por Rango de Fechas", 1);
                $css->CerrarSelect();
                print("<br>");
                $css->CrearInputFecha("Fecha de Corte:<br>", "TxtFechaCorte", date("Y-m-d"), 150, 30, "");
                
                print("</td>");
                print("<td>");
                $css->CrearInputFecha("", "TxtFechaIni", date("Y-m-d"), 150, 30, "");
                
                print("</td>");   
                print("<td>");
                $css->CrearInputFecha("", "TxtFechaFinal", date("Y-m-d"), 150, 30, "");
                //$css->CrearInputText("TxtFechaFinal", "date", "", date("Y-m-d"), "Fecha Inicial", "black", "", "", 150, 30, 0, 1);
                print("</td>"); 
                print("<td>");
                $css->CrearSelect("CmbFiltro", "");
                    $css->CrearOptionSelect("Igual", "Igual", 0);
                    $css->CrearOptionSelect("Inicia", "Empieza por", 1);
                $css->CerrarSelect();
                print("<br>");
                $css->CrearInputNumber("TxtCuentaPUC", "number", "", "", "Cuenta", "", "", "", 100, 30, 0, 0, 0, "", 1);
                print("<br>");
                $VarSelect["Ancho"]="200";
                $VarSelect["PlaceHolder"]="Busque un Tercero";
                $VarSelect["Required"]=1;
                $css->CrearSelectChosen("TxtTercero", $VarSelect);
                $css->CrearOptionSelect("All", "Todos" , 1);
                    $sql="SELECT * FROM clientes";
                    $Consulta=$obVenta->Query($sql);
                    while($DatosCliente=$obVenta->FetchArray($Consulta)){

                           $css->CrearOptionSelect("$DatosCliente[Num_Identificacion]", "$DatosCliente[Num_Identificacion] / $DatosCliente[RazonSocial] / $DatosCliente[Telefono]" , 0);
                       }
                    $sql="SELECT * FROM proveedores";
                    $Consulta=$obVenta->Query($sql);
                    while($DatosCliente=$obVenta->FetchArray($Consulta)){

                           $css->CrearOptionSelect("$DatosCliente[Num_Identificacion]", "$DatosCliente[Num_Identificacion] / $DatosCliente[RazonSocial] / $DatosCliente[Telefono]" , 0);
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
print("<html>");
print("<head>");
$css =  new CssIni("Auxiliares Detallados");

print("</head>");




print("<body>");
    
    $css->CabeceraIni("Auxiliares Detallados"); //Inicia la cabecera de la pagina
    
    
    $css->CabeceraFin(); 
    ///////////////Creamos el contenedor
    /////
    /////
    $css->CrearDiv("principal", "container", "center",1,1);
    print("<br>");
    ///////////////Creamos la imagen representativa de la pagina
    /////
    /////	
    $css->CrearImageLink("../VMenu/MnuInformes.php", "../images/auxiliar.png", "_self",200,200);
    
    
    ///////////////Se crea el DIV que servirá de contenedor secundario
    /////
    /////
    $css->CrearDiv("Secundario", "container", "center",1,1);
    
    $css->CrearNotificacionNaranja("GENERAR UN AUXILIAR DETALLADO", 16);
    
    $VectorInformes["FormName"]="FrmInformeAuxiliar";
    $VectorInformes["ActionForm"]=$myPage;
    $VectorInformes["Metod"]="post";
    $VectorInformes["Target"]="_self";
    $VectorInformes["Titulo"]="Auxiliar Detallado";
    CrearFormularioInformes($VectorInformes);
    print("<br>");
    $css->CrearNotificacionVerde("GENERAR UN AUXILIAR X DOCUMENTO", 16);
    $css->CrearForm2("FrmAuxDocumento", $myPage, "POST", "_SELF");
        $css->CrearTabla();
            $css->FilaTabla(14);
            $css->ColTabla("<strong>AUXILIAR X DOCUMENTO</strong>", 5);

                $css->CierraFilaTabla();
            $css->FilaTabla(14);
                
                $css->ColTabla("<strong>FECHA INICIAL:</strong>", 1);
                $css->ColTabla("<strong>FECHA FINAL:</strong>", 1);
                
            $css->CierraFilaTabla();
            $css->FilaTabla(14);
                
                print("<td>");
                $css->CrearInputText("TxtFechaIni", "date", "", date("Y-m-d"), "Fecha", "", "", "", 150, 30, 0, 1);
                //$css->CrearInputFecha("", "TxtFechaIni", date("Y-m-d"), 150, 30, "");
                
                print("</td>");   
                print("<td>");
                $css->CrearInputText("TxtFechaFinal", "date", "", date("Y-m-d"), "Fecha", "", "", "", 150, 30, 0, 1);
                
                print("</td>"); 
                
            $css->FilaTabla(16);
            print("<td colspan='5' style='text-align:center'>");
            $css->CrearBotonNaranja("BtnVerAuxDoc", "Generar");
            print("</td>");
            $css->CierraFilaTabla();
        $css->CerrarTabla();
    $css->CerrarForm(); 
    
    print("<br>");
    $css->CrearNotificacionAzul("GENERAR UN AUXILIAR X TERCERO", 16);
    $css->CrearForm2("FrmAuxTercero", $myPage, "POST", "_SELF");
        $css->CrearTabla();
            $css->FilaTabla(14);
            $css->ColTabla("<strong>AUXILIAR X TERCERO</strong>", 5);

                $css->CierraFilaTabla();
            $css->FilaTabla(14);
                
                $css->ColTabla("<strong>FECHA INICIAL:</strong>", 1);
                $css->ColTabla("<strong>FECHA FINAL:</strong>", 1);
                
            $css->CierraFilaTabla();
            $css->FilaTabla(14);
                
                print("<td>");
                $css->CrearInputText("TxtFechaIni", "date", "", date("Y-m-d"), "Fecha", "", "", "", 150, 30, 0, 1);
                //$css->CrearInputFecha("", "TxtFechaIni", date("Y-m-d"), 150, 30, "");
                
                print("</td>");   
                print("<td>");
                $css->CrearInputText("TxtFechaFinal", "date", "", date("Y-m-d"), "Fecha", "", "", "", 150, 30, 0, 1);
                
                print("</td>"); 
                
            $css->FilaTabla(16);
            print("<td colspan='5' style='text-align:center'>");
            $css->CrearBotonNaranja("BtnVerAuxTer", "Generar");
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
?>