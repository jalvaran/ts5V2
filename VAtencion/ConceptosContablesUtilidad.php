<?php 
$myPage="ConceptosContablesUtilidad.php";
include_once("../sesiones/php_control.php");

$obVenta = new ProcesoVenta($idUser);
$obTabla = new Tabla($db);
$idConcepto=0;
if(isset($_REQUEST["CmbConcepto"])){
    $idConcepto=$obVenta->normalizar($_REQUEST["CmbConcepto"]);
}
include_once("css_construct.php");

print("<html>");
print("<head>");

$css =  new CssIni("Conceptos Contables");

print("</head>");

print("<body>");
    
$css->CabeceraIni("Conceptos Contables"); //Inicia la cabecera de la pagin   

$css->CabeceraFin(); 
 
    
///////////////Creamos el contenedor
/////
/////
$css->CrearDiv("principal", "container", "center",1,1);
if(isset($_REQUEST["RutaPrint"])){
    $Ruta=base64_decode($_REQUEST["RutaPrint"]);
    $css->CrearNotificacionVerde("Concepto ejecutado correctamente;<a href='$Ruta' target='_blank'> Imprimir Comprobante</a>", 16);
}
//Select con la seleccion del Concepto

$css->CrearForm2("FrmSeleccionaConcepto", $myPage, "post", "_self");
    
    $css->CrearTabla();
    $css->FilaTabla(16);
    print("<td style='text-align:center'>");
    
        $css->CrearSelect("CmbConcepto", "EnviaForm('FrmSeleccionaConcepto')");
        
            $css->CrearOptionSelect("","Selecciona un Concepto",0);
            
            $consulta = $obVenta->ConsultarTabla("conceptos","WHERE Completo='SI' AND Activo='SI'");
            while($DatosConcepto=$obVenta->FetchArray($consulta)){
                if($idConcepto==$DatosConcepto['ID']){
                    $Sel=1;
                    
                }else{
                    
                    $Sel=0;
                }
                $css->CrearOptionSelect($DatosConcepto['ID'],$DatosConcepto['ID']." ".$DatosConcepto['Nombre'],$Sel);							
            }
        $css->CerrarSelect();
    print("</td>");
    $css->CierraFilaTabla();
    $css->CerrarTabla();
    $css->CerrarForm();    
    
    
    include_once("procesadores/ProcesaConceptosContablesUtilidad.php");
    ///////////////Creamos la imagen representativa de la pagina
    /////
    /////
    if($idConcepto==0){
        $css->CrearImageLink("../VMenu/MnuAjustes.php", "../images/conceptos.png", "_self",200,200);
    }
    
    ///////////////Se crea el DIV que servirá de contenedor secundario
    /////
    /////
    $css->CrearDiv("Secundario", "container", "center",1,1);
    
    if($idConcepto>0){
        $DatosConcepto=$obVenta->DevuelveValores("conceptos", "ID", $idConcepto);
        $css->CrearNotificacionAzul("Concepto Contable $idConcepto $DatosConcepto[Nombre], Observaciones: $DatosConcepto[Observaciones]", 16);
        $css->CrearForm2("FrmAgregaMonto", $myPage, "post", "_self");
        $css->CrearInputText("CmbConcepto", "hidden", "", $idConcepto, "", "", "", "", "", "", "", "");
        $css->CrearTabla();
        $css->FilaTabla(16);
        $css->ColTabla("<strong>Datos Generales</strong>", 1);
        
        $css->CierraFilaTabla();
        $css->FilaTabla(14);
        $css->ColTabla("<strong>Fecha</strong>", 1);
        $css->ColTabla("<strong>Tercero</strong>", 1);
        $css->ColTabla("<strong>Centro de Costos</strong>", 1);
        $css->ColTabla("<strong>Sede</strong>", 1);
        
        $css->CierraFilaTabla();
        $css->FilaTabla(14);
        print("<td>");
        $css->CrearInputFecha("", "TxtFecha", date("Y-m-d"), 100, 30, "");
        print("</td>");
        print("<td>");
        $VarSelect["Ancho"]=300;
        $VarSelect["PlaceHolder"]="Seleccione el Tercero";
        $VarSelect["Required"]=1;
        //$VarSelect["Title"]="Tercero";   
                      
        $css->CrearSelectChosen("CmbTercero", $VarSelect);
        $css->CrearOptionSelect("", "Seleccione un Tercero", 0);
        $Consulta=$obVenta->ConsultarTabla("proveedores", "");
        while($DatosProveedor=$obVenta->FetchArray($Consulta)){
            $css->CrearOptionSelect($DatosProveedor["Num_Identificacion"],$DatosProveedor["RazonSocial"]." ".$DatosProveedor["Num_Identificacion"] , 0);
        }
        $css->CerrarSelect();
        print("</td>");
        print("<td>");
           
                   
        $css->CrearSelect("CmbCentroCostos", "");
        
        $Consulta=$obVenta->ConsultarTabla("centrocosto", "");
        while($DatosCentro=$obVenta->FetchArray($Consulta)){
            $css->CrearOptionSelect($DatosCentro["ID"],$DatosCentro["Nombre"] , 0);
        }
        $css->CerrarSelect();
        print("</td>");
        print("<td>");
           
                   
        $css->CrearSelect("CmbSede", "");
        $css->CrearOptionSelect("", "Sede", 0);
        $Consulta=$obVenta->ConsultarTabla("empresa_pro_sucursales", "");
        while($DatosSucursal=$obVenta->FetchArray($Consulta)){
            $sel=0;
            if($DatosSucursal["Actual"]==1){
                $sel=1;
            }
            $css->CrearOptionSelect($DatosSucursal["ID"],$DatosSucursal["Nombre"] , $sel);
        }
        $css->CerrarSelect();
        print("</td>");
        $css->CierraFilaTabla();
        $css->FilaTabla(14);
        print("<td colspan=2>");
        $css->CrearTextArea("TxtObservacionesConcepto", "", "", "Observaciones", "", "", "", 420, 60, 0, 1);
        print("</td>");
        print("<td colspan=2>");
        $css->CrearInputText("TxtNumFactura","text",'',"","Numero de Comprobante","black","","",300,30,0,1);
        echo"<br>";
        $css->CrearUpload("foto");
        
        print("</td>");
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
        $css->ColTabla("<strong>Valores:</strong>", 4);
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
        print("<td colspan=4 style='text-align:center'>");
        $obTabla->CrearInputsMontos($idConcepto,"");
        
        $css->CrearBotonConfirmado("BtnGuardar", "Guardar");
        $css->CierraFilaTabla();
        $css->CerrarTabla();
        $css->CerrarForm();
        }else{
            $css->CrearNotificacionRoja("No hay movimientos", 16);
        }    
        
        
        
   
    
    
    $css->CerrarDiv();//Cerramos contenedor Secundario
    $css->CerrarDiv();//Cerramos contenedor Principal
    $css->AgregaJS(); //Agregamos javascripts
    $css->AgregaSubir();
    $css->Footer();
    print("</body></html>");
?>