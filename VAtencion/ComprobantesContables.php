<?php 
$myPage="ComprobantesContables.php";
include_once("../sesiones/php_control.php");
include_once("clases/ClasesPDFDocumentos.php");
include_once("clases/ClasesDocumentosExcel.php");
$obVenta = new ProcesoVenta($idUser);

if(isset($_REQUEST["BtnVerInforme"])){
    $obPDF = new Documento($db);
    $obExcel = new TS5_Excel($db);
    $FechaInicial=$obVenta->normalizar($_REQUEST["TxtFechaIni"]);
    $FechaFinal=$obVenta->normalizar($_REQUEST["TxtFechaFinal"]);
    $CuentaPUC=$obVenta->normalizar($_REQUEST["TxtCuentaPUC"]);
    
    $Tercero=$obVenta->normalizar($_REQUEST["TxtTercero"]);
    $obExcel->AcumuladoXTerceroExcel($FechaInicial, $FechaFinal, $CuentaPUC, $Tercero, "");
    $obPDF->PDF_ComprobanteMovimientos($FechaInicial, $FechaFinal, $CuentaPUC, $Tercero, "");
    
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
   $css =  new CssIni("Certificado Contable");
   
   $css->CrearForm2($FormName, $ActionForm, $Metod, $Target);
        $css->CrearTabla();
            $css->FilaTabla(14);
            $css->ColTabla("<strong>$Titulo</strong>", 5);

                $css->CierraFilaTabla();
            $css->FilaTabla(14);
                $css->ColTabla("<strong>FECHA INICIAL:</strong>", 1);
                $css->ColTabla("<strong>FECHA FINAL:</strong>", 1);
                $css->ColTabla("<strong>CUENTA:</strong>", 1);
            $css->CierraFilaTabla();
            $css->FilaTabla(14);
                
                print("<td>");
                $css->CrearInputFecha("", "TxtFechaIni", date("Y-m-d"), 150, 30, "");
                
                print("</td>");   
                print("<td>");
                $css->CrearInputFecha("", "TxtFechaFinal", date("Y-m-d"), 150, 30, "");
                //$css->CrearInputText("TxtFechaFinal", "date", "", date("Y-m-d"), "Fecha Inicial", "black", "", "", 150, 30, 0, 1);
                print("</td>"); 
                print("<td>");
                
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
            $css->CrearBotonVerde("BtnVerInforme", "Generar Comprobante");
            print("</td>");
            $css->CierraFilaTabla();
        $css->CerrarTabla();
    $css->CerrarForm(); 
}
print("<html>");
print("<head>");
$css =  new CssIni("Comprobantes Contables");

print("</head>");




print("<body>");
    
    $css->CabeceraIni("Comprobantes Contables"); //Inicia la cabecera de la pagina
    
    
    $css->CabeceraFin(); 
    ///////////////Creamos el contenedor
    /////
    /////
    $css->CrearDiv("principal", "container", "center",1,1);
    print("<br>");
    ///////////////Creamos la imagen representativa de la pagina
    /////
    /////	
    $css->CrearImageLink("../VMenu/MnuInformes.php", "../images/comprobantes.png", "_self",200,200);
    
    
    ///////////////Se crea el DIV que servirá de contenedor secundario
    /////
    /////
    $css->CrearDiv("Secundario", "container", "center",1,1);
    
    $css->CrearNotificacionNaranja("GENERAR UN COMPROBANTE", 16);
    
    $VectorInformes["FormName"]="FrmInformeAuxiliar";
    $VectorInformes["ActionForm"]=$myPage;
    $VectorInformes["Metod"]="post";
    $VectorInformes["Target"]="_self";
    $VectorInformes["Titulo"]="Comprobante Contable";
    CrearFormularioInformes($VectorInformes);
     
    $css->CerrarDiv();//Cerramos contenedor Secundario
    $css->CerrarDiv();//Cerramos contenedor Principal
    $css->AgregaJS(); //Agregamos javascripts
    $css->AgregaSubir();
    $css->Footer();
    print("</body></html>");
?>