<?php 
$myPage="InformeVentasAdmin.php";
include_once("../sesiones/php_control.php");
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
                $css->CrearSelect("CmbTipoReporte", "");
                    $css->CrearOptionSelect("Rango", "Por Rango de Fechas", 1);
                    $css->CrearOptionSelect("Corte", "Fecha de Corte", 0);
                    
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
            $css->CrearBotonVerde("BtnVerInformeAdmin", "Generar Informe");
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
        
    $myPage="InformeVentas.php";
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
    //$VectorInformes["ActionForm"]="../tcpdf/examples/InformeVentasAdmin.php";
    $VectorInformes["ActionForm"]="PDF_Informes_Ventas.php";
    $VectorInformes["Metod"]="post";
    $VectorInformes["Target"]="_blank";
    $VectorInformes["Titulo"]="INFORME DE VENTAS";
    CrearFormularioInformes($VectorInformes);
      
    $css->CerrarDiv();//Cerramos contenedor Secundario
    $css->CerrarDiv();//Cerramos contenedor Principal
    $css->AgregaJS(); //Agregamos javascripts
    $css->AgregaSubir();
    $css->Footer();
    print("</body></html>");
?>