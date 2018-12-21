<?php 
$myPage="InformeVentas.php";
include_once("../sesiones/php_control.php");
if(isset($_REQUEST["BtnInformeDepartamentos"])){
   $obTabla = new Tabla($db);
   $Mes=$_REQUEST["CmbMes"];
   $Anio=$_REQUEST["CmbAnio"];
   $obTabla->GenereInformeDepartamento($Mes, $Anio, "");
}
include_once("css_construct.php");

$obVenta = new ProcesoVenta($idUser);

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
                $css->CrearSelect("CmbTipoReporte", "");
                    $css->CrearOptionSelect("Corte", "Fecha de Corte", 1);
                    $css->CrearOptionSelect("Rango", "Por Rango de Fechas", 0);
                $css->CerrarSelect();
                print("<br>");
                $css->CrearInputText("TxtFechaCorte", "date", "Fecha de Corte:<br>", date("Y-m-d"), "Fecha Corte", "black", "", "", 150, 30, 0, 1);
                print("</td>");
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
            $css->CrearBotonVerde("BtnVerInforme", "Generar Informe");
            print("</td>");
            $css->CierraFilaTabla();
        $css->CerrarTabla();
    $css->CerrarForm(); 
}
print("<html>");
print("<head>");
$css =  new CssIni("Informe de Ventas");

print("</head>");




print("<body>");
    
    $css->CabeceraIni("Informe de Ventas"); //Inicia la cabecera de la pagina
    
    
    $css->CabeceraFin(); 
    ///////////////Creamos el contenedor
    /////
    /////
    $css->CrearDiv("principal", "container", "center",1,1);
    print("<br>");
    ///////////////Creamos la imagen representativa de la pagina
    /////
    /////	
    $css->CrearImageLink("../VMenu/MnuInformes.php", "../images/infventas.png", "_self",200,200);
    
    
    ///////////////Se crea el DIV que servirá de contenedor secundario
    /////
    /////
    $css->CrearDiv("Secundario", "container", "center",1,1);
    
    $css->CrearNotificacionNaranja("GENERAR INFORME DE VENTAS", 16);
    
    $VectorInformes["FormName"]="FrmInformeVentas";
    $VectorInformes["ActionForm"]="../tcpdf/examples/InformeVentasTotal.php";
    $VectorInformes["Metod"]="post";
    $VectorInformes["Target"]="_blank";
    $VectorInformes["Titulo"]="INFORME DE VENTAS";
    CrearFormularioInformes($VectorInformes);
     
    $sql="SELECT Role FROM usuarios WHERE idUsuarios='$idUser'";
    $Datos=$obVenta->Query($sql);
    $DatosUser=$obVenta->FetchArray($Datos);
    if($DatosUser["Role"]=="SUPERVISOR"){
        
    $css->CrearForm2("FrmInformeDepartamentos", $myPage, "post", "_blank");
    print("<br><br><br>");
    $css->CrearTabla();
    $css->CrearNotificacionNaranja("INFORME POR DEPARTAMENTOS", 16);
    $css->FilaTabla(16);
    print("<td>");
    print("<strong>Seleccione el Mes: </strong><br>");
    $css->CrearSelect("CmbMes", "");
    $NumMes=date("m");
        $sel=0;
        if($NumMes=="01"){
            $sel=1;
        }
        $css->CrearOptionSelect("01", "Enero", $sel);
        $sel=0;
        if($NumMes=="02"){
            $sel=1;
        }
        $css->CrearOptionSelect("02", "Febrero", $sel);
        $sel=0;
        if($NumMes=="03"){
            $sel=1;
        }
        $css->CrearOptionSelect("03", "Marzo", $sel);
        $sel=0;
        if($NumMes=="04"){
            $sel=1;
        }
        $css->CrearOptionSelect("04", "Abril", $sel);
        $sel=0;
        if($NumMes=="05"){
            $sel=1;
        }
        $css->CrearOptionSelect("05", "Mayo", $sel);
        $sel=0;
        if($NumMes=="06"){
            $sel=1;
        }
        $css->CrearOptionSelect("06", "Junio", $sel);
        $sel=0;
        if($NumMes=="07"){
            $sel=1;
        }
        $css->CrearOptionSelect("07", "Julio", $sel);
        $sel=0;
        if($NumMes=="08"){
            $sel=1;
        }
        $css->CrearOptionSelect("08", "Agosto", $sel);
        $sel=0;
        if($NumMes=="09"){
            $sel=1;
        }
        $css->CrearOptionSelect("09", "Septiembre", $sel);
        $sel=0;
        if($NumMes=="10"){
            $sel=1;
        }
        $css->CrearOptionSelect("10", "Octubre", $sel);
        $sel=0;
        if($NumMes=="11"){
            $sel=1;
        }
        $css->CrearOptionSelect("11", "Noviembre", $sel);
        $sel=0;
        if($NumMes=="12"){
            $sel=1;
        }
        $css->CrearOptionSelect("12", "Diciembre", $sel);
    $css->CerrarSelect();
   
    print("</td>");
    print("<td>");
     print("<strong>Seleccione el Año: </strong><br>");
    $Anio=date("Y");
    $css->CrearSelect("CmbAnio", "");
    for($i=2000;$i<=2031;$i++){
        $sel=0;
        if($i==$Anio){
           $sel=1; 
        }
        $css->CrearOptionSelect($i, $i, $sel);
    }
    $css->CerrarSelect();
    print("</td>");
    $css->FilaTabla(16);
    print("<td colspan='2' style=' text-align:center'>");
    $css->CrearBotonVerde("BtnInformeDepartamentos", "Generar Informe");
    print("</td>");
    $css->CierraFilaTabla();
    $css->CerrarTabla();
    $css->CerrarForm();
    
    
        $css->CrearNotificacionRoja("GENERAR PRESUPUESTO", 16);
        $css->CrearForm2("FormFiscal", "../tcpdf/examples/InformeVentasTotalPor.php", "post", "_blank");
        $css->CrearTabla();
        $css->FilaTabla(16);
            $css->ColTabla("<strong>Fecha Inicial</strong>", 1);
            $css->ColTabla("<strong>Fecha Final</strong>", 1);
            $css->ColTabla("<strong>%</strong>", 1);
            $css->ColTabla("<strong>Vista Previa</strong>", 1);
            $css->ColTabla("<strong>Accion</strong>", 1);
        $css->CierraFilaTabla();
            print("<td>");
            $css->CrearInputFecha("", "TxtFechaIniP", date("Y-m-d"), 100, 30, "");
            print("</td>");
            print("<td>");
            $css->CrearInputFecha("", "TxtFechaFinP", date("Y-m-d"), 100, 30, "");
            print("</td>");
            print("<td>");
            $css->CrearInputNumber("TxtPorcentaje", "number", "", 100, "porcentaje", "black", "", "", 100, 30, 0, 1, 0, 200, 1);
            print("</td>");
            print("<td>");
            $css->CrearBotonVerde("BtnVistaPrevia", "Vista Previa");
            print("</td>");
            print("<td>");
            $css->CrearBotonConfirmado("BtnAplicar", "Aplicar");
            print("</td>");
        $css->FilaTabla(16);
        $css->CierraFilaTabla();
        $css->CerrarTabla();
        $css->CerrarForm();
        
        //Informe x Tipo de Iva
        
        $css->CrearNotificacionNaranja("GENERAR PRESUPUESTO SEGUN IMPUESTOS", 16);
        $css->CrearForm2("FormPresupuestosImp", "../tcpdf/examples/InformeVentasTotalPorImpuestos.php", "post", "_blank");
        $css->CrearTabla();
        $css->FilaTabla(16);
            $css->ColTabla("<strong>Fecha Inicial</strong>", 1);
            $css->ColTabla("<strong>Fecha Final</strong>", 1);
            $css->ColTabla("<strong>%</strong>", 1);
            $css->ColTabla("<strong>Vista Previa</strong>", 1);
            $css->ColTabla("<strong>Accion</strong>", 1);
        $css->CierraFilaTabla();
            print("<td>");
            $css->CrearInputFecha("", "TxtFechaIniPI", date("Y-m-d"), 100, 30, "");
            print("</td>");
            print("<td>");
            $css->CrearInputFecha("", "TxtFechaFinPI", date("Y-m-d"), 100, 30, "");
            print("</td>");
            print("<td>");
            $consulta=$obVenta->ConsultarTabla("porcentajes_iva", "");
            while($DatosIVA=$obVenta->FetchArray($consulta)){
                print("$DatosIVA[Nombre]:<br>");
                $css->CrearInputNumber("TxtPorcentaje".$DatosIVA["ID"], "number", "", 100, "porcentaje", "black", "", "", 100, 30, 0, 1, 0, 200, 1);
                print("<br>");
            }
            print("</td>");
            print("<td>");
            $css->CrearBotonVerde("BtnVistaPrevia", "Vista Previa");
            print("</td>");
            print("<td>");
            $css->CrearBotonConfirmado("BtnAplicar", "Aplicar");
            print("</td>");
        $css->FilaTabla(16);
        $css->CierraFilaTabla();
        $css->CerrarTabla();
        $css->CerrarForm();
        
        ////Informes de ventas Reales
        
        print("<br>");
        
        $css->CrearNotificacionAzul("GENERAR INFORME DE VENTAS 2", 16);
    
        $VectorInformes["FormName"]="FrmInformeVentasR";
        $VectorInformes["ActionForm"]="../tcpdf/examples/InformeVentasAdminTotal.php";
        $VectorInformes["Metod"]="post";
        $VectorInformes["Target"]="_blank";
        $VectorInformes["Titulo"]="INFORME DE VENTAS TOTALES";
        CrearFormularioInformes($VectorInformes);
        
        ////Informes de ventas por rangos
        
        $css->CrearNotificacionAzul("GENERAR INFORME DE VENTAS POR RANGOS", 16);
        $css->CrearForm2("FormVentasXRangos", "../tcpdf/examples/InformeVentasRangos.php", "post", "_blank");
        $css->CrearTabla();
        $css->FilaTabla(16);
            $css->ColTabla("<strong>Tipo de Reporte</strong>", 1);
            $css->ColTabla("<strong>Fecha Inicial</strong>", 1);
            $css->ColTabla("<strong>Fecha Final</strong>", 1);
            $css->ColTabla("<strong>Niveles</strong>", 1);
            $css->ColTabla("<strong>Generar</strong>", 1);
            
        $css->CierraFilaTabla();
        print("<td>");
                $css->CrearSelect("CmbTipoReporteRangos", "");
                    $css->CrearOptionSelect("Corte", "Fecha de Corte", 1);
                    $css->CrearOptionSelect("Rango", "Por Rango de Fechas", 0);
                $css->CerrarSelect();
                print("<br>");
                $css->CrearInputText("TxtFechaCorteRangos", "date", "Fecha de Corte:<br>", date("Y-m-d"), "Fecha Corte", "black", "", "", 150, 30, 0, 1);
                print("</td>");
            print("<td>");
            $css->CrearInputFecha("", "TxtFechaIniRango", date("Y-m-d"), 100, 30, "");
            print("</td>");
            print("<td>");
            $css->CrearInputFecha("", "TxtFechaFinRango", date("Y-m-d"), 100, 30, "");
            print("</td>");
            print("<td>");
            
            $css->CrearSelect("CmbNivel", "");
                $css->CrearOptionSelect(1, "A nivel Departamentos", 1);
                $css->CrearOptionSelect(2, "Hasta el SubGrupo 1", 0);
                $css->CrearOptionSelect(3, "Hasta el SubGrupo 2", 0);
                $css->CrearOptionSelect(4, "Hasta el SubGrupo 3", 0);
                $css->CrearOptionSelect(5, "Hasta el SubGrupo 4", 0);
                $css->CrearOptionSelect(6, "Hasta el SubGrupo 5", 0);
            $css->CerrarSelect();
            
            print("</td>");
            print("<td>");
            $css->CrearBotonVerde("BtnGenerarInformeRangos", "Generar");
            print("</td>");
            
        $css->FilaTabla(16);
        $css->CierraFilaTabla();
        $css->CerrarTabla();
        $css->CerrarForm();
    }
    $css->CerrarDiv();//Cerramos contenedor Secundario
    $css->CerrarDiv();//Cerramos contenedor Principal
    $css->AgregaJS(); //Agregamos javascripts
    $css->AgregaSubir();
    $css->Footer();
    print("</body></html>");
?>