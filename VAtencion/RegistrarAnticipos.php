<?php 
$myPage="RegistrarAnticipos.php";
include_once("../sesiones/php_control.php");
include_once("css_construct.php");

print("<html>");
print("<head>");
$css =  new CssIni("Registrar Anticipo");

print("</head>");
print("<body>");
   
    include_once("procesadores/procesaAnticipo.php");
    
    $css->CabeceraIni("Registrar Anticipo"); //Inicia la cabecera de la pagina
    
   
    
    $css->CabeceraFin(); 
    ///////////////Creamos el contenedor
    /////
    /////
    $css->CrearDiv("principal", "container", "center",1,1);
    print("<br>");
    ///////////////Creamos la imagen representativa de la pagina
    /////
    /////	
    $css->CrearImageLink($myPage, "../images/Anticipos.png", "_self",200,200);
    
    
    ///////////////Se crea el DIV que servirá de contenedor secundario
    /////
    /////
    $css->CrearDiv("Secundario", "container", "center",1,1);
   										
    /*
     * Dibujamos el formulario para seleccionar los datos del ingreso
     * 
     */
    if(!empty($_REQUEST["TxtidIngreso"])){
        $RutaPrintIngreso="PDF_Documentos.php?idDocumento=4&idIngreso=".$_REQUEST["TxtidIngreso"];			
        
        $css->CrearNotificacionVerde("Comprobante de Ingreso Creado Correctamente <a href='$RutaPrintIngreso' target='_blank'>Imprimir Comprobante de Ingreso No. $_REQUEST[TxtidIngreso]</a>",16);
        
    }
            
    $css->CrearNotificacionAzul("Ingrese los datos para registrar el Anticipo", 16);
    $css->CrearForm2("FrmIngresos", $myPage, "post", "_self");
    
    $css->CrearTabla();
        $css->FilaTabla(14);
        $css->ColTabla("<strong>Fecha</strong>", 1);
        $css->ColTabla("<strong>Cuenta Ingreso</strong>", 1);
        $css->ColTabla("<strong>Centro de Costo</strong>", 1);
        $css->ColTabla("<strong>Cliente</strong>", 1);
        
        $css->CierraFilaTabla();
        $css->FilaTabla(14);
        print("<td>");
        $css->CrearInputText("TxtFecha", "text", "", date("Y-m-d"), "Fecha", "Fecha", "", "", 100, 30, 0, 1);
        
        print("</td>");
        print("<td>");
        $css->CrearSelect("CmbCuentaDestino", "");
        $Consulta=$obVenta->ConsultarTabla("cuentasfrecuentes", "WHERE ClaseCuenta='ACTIVOS'");
            if($obVenta->NumRows($Consulta)){
            while($DatosCuentasFrecuentes=  $obVenta->FetchArray($Consulta)){
                $css->CrearOptionSelect($DatosCuentasFrecuentes["CuentaPUC"], $DatosCuentasFrecuentes["Nombre"], 0);
            }
            }else{
                print("<script>alert('No hay cuentas frecuentes creadas debe crear al menos una')</script>");
            }
        $css->CerrarSelect();
        print("</td>");
        print("<td>");
        $css->CrearSelect("CmbCentroCostos", "");
        $Consulta=$obVenta->ConsultarTabla("centrocosto", "");
            if($obVenta->NumRows($Consulta)){
            while($DatosCentroCosto=  $obVenta->FetchArray($Consulta)){
                $css->CrearOptionSelect($DatosCentroCosto["ID"], $DatosCentroCosto["Nombre"], 0);
            }
            }else{
                print("<script>alert('No hay centros de costo, debe crear al menos uno')</script>");
            }
        $css->CerrarSelect();
        print("</td>");
        print("<td>");
            $VarSelect["Ancho"]="200";
            $VarSelect["PlaceHolder"]="Seleccione el Cliente";
            $css->CrearSelectChosen("TxtTercero", $VarSelect);

            $sql="SELECT * FROM clientes";
            $Consulta=$obVenta->Query($sql);
               while($DatosProveedores=$obVenta->FetchArray($Consulta)){
                   $Sel=0;
                   
                   $css->CrearOptionSelect($DatosProveedores["idClientes"], "$DatosProveedores[RazonSocial] $DatosProveedores[Num_Identificacion]" , $Sel);
               }
            $css->CerrarSelect();
        print("</td>");
        $css->CierraFilaTabla();
        $css->FilaTabla(14);
        print("<td colspan='2' style='text-align:center'>");
        $css->CrearTextArea("TxtConcepto", "Concepto:<br>", "", "Concepto", "black", "", "", 200, 80, 0, 1);
        print("</td>");
        print("<td colspan='2' style='text-align:center'>");
        $css->CrearInputNumber("TxtTotal", "Number", "Total:<br>", "", "Total", "Black", "", "", 120, 30, 0, 1, 1, "", 1);
        print("<br>");
        $css->CrearBotonConfirmado("BtnGuardarAnticipo", "Guardar");
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