<?php 
$myPage="trasladar_titulo.php";
include_once("../sesiones/php_control.php");
include_once("css_construct.php");
$obVenta =  new ProcesoVenta($idUser);
if(!empty($_REQUEST["Mayor"])){
    $idMayor=$obVenta->normalizar($_REQUEST["Mayor"]);
    $TablaTraslado=$obVenta->normalizar($_REQUEST["CmbListado"]);
}	
print("<html>");
print("<head>");
$css =  new CssIni("Trasladar Titulo");

print("</head>");
print("<body>");
    
    include_once("procesadores/procesaTrasladoTitulo.php");
    
    $css->CabeceraIni("Trasladar Titulo"); //Inicia la cabecera de la pagina
    
    //////////Creamos el formulario de busqueda de remisiones
    /////
    /////
    
   
    
    $css->CabeceraFin(); 
    ///////////////Creamos el contenedor
    /////
    /////
    $css->CrearDiv("principal", "container", "center",1,1);
    print("<br>");
    ///////////////Creamos la imagen representativa de la pagina
    /////
    /////	
    $css->CrearImageLink("listados_titulos.php", "../images/traslado.png", "_self",200,200);
    
    ///////////////Si se crea un traslado
    /////
    /////
    if(!empty($_REQUEST["TxtidComprobante"])){
        $RutaPrintIngreso="../tcpdf/examples/notacredito.php?idComprobante=".$_REQUEST["TxtidComprobante"];			
        $css->CrearTabla();
        $css->CrearFilaNotificacion("Nota Credito Creada Correctamente <a href='$RutaPrintIngreso' target='_blank'>Imprimir Nota Credito No. $_REQUEST[TxtidComprobante]</a>",16);
        $css->CerrarTabla();
    }
    ///////////////Se crea el DIV que servirá de contenedor secundario
    /////
    /////
    $css->CrearDiv("Secundario", "container", "center",1,1);
   										
    
    //////////////////////////Se dibujan los campos para la anulacion de la factura
    /////
    /////
    if(!empty($idMayor)){
        
        $css->CrearTabla();
            
            $DatosTitulo=$obVenta->DevuelveValores($TablaTraslado, "Mayor1", $idMayor);
            
            if($DatosTitulo["idColaborador"]=="0"){
                $css->CrearNotificacionRoja("Este Titulo no ha sido asignado aun", 16);
                exit();
            }
            $DatosColaborador=$obVenta->DevuelveValores("colaboradores", "Identificacion", $DatosTitulo["idColaborador"]);
            $css->CrearNotificacionAzul("Datos del titulo", 18);
            $css->FilaTabla(14);
            
            $css->ColTabla("<strong>Mayor1</strong>", 1);
            $css->ColTabla("<strong>Mayor2</strong>", 1);
            $css->ColTabla("<strong>Adicional</strong>", 1);           
            $css->ColTabla("<strong>Identificacion</strong>", 1);
            $css->ColTabla("<strong>Nombre Colaborador</strong>", 1);
            
            $css->CierraFilaTabla();
            
            $css->FilaTabla(14);
            
            $css->ColTabla($DatosTitulo["Mayor1"], 1);
            $css->ColTabla($DatosTitulo["Mayor2"], 1);
            $css->ColTabla($DatosTitulo["Adicional"], 1);
            $css->ColTabla($DatosTitulo["idColaborador"], 1);
            $css->ColTabla($DatosTitulo["NombreColaborador"], 1);
                        
            $css->CierraFilaTabla();
            
        $css->CerrarTabla();
        $css->CrearForm2("FrmRegistraTraslado", $myPage, "post", "_self");
        $css->CrearInputText("CmbListado", "hidden", "", $TablaTraslado, "", "", "", "", "", "", "", "");
        $css->CrearInputText("Mayor", "hidden", "", $idMayor, "", "", "", "", "", "", "", "");
        $css->CrearTabla();
        $css->CrearNotificacionNaranja("Datos Para Realizar el traslado", 16);
        print("<td style='text-align:center'>");
        $css->CrearInputText("TxtFechaTraslado", "date", "Fecha de Traslado: <br>", date("Y-m-d"), "Fecha", "black", "", "", 100, 30, 0, 1);
        print("<br>");
        $VarSelect["Ancho"]=200;
        $VarSelect["PlaceHolder"]="Colaborador a quien se traslada";
        $VarSelect["Required"]=1;
        $css->CrearSelectChosen("CmbColaborador", $VarSelect);
        $css->CrearOptionSelect("", "Colaborador a trasladar", 0);
        $Datos=$obVenta->ConsultarTabla("colaboradores", "");
            while($DatosColaboradores=$obVenta->FetchArray($Datos)){
                if($DatosColaboradores["Identificacion"]<>$DatosTitulo["idColaborador"]){
                $css->CrearOptionSelect($DatosColaboradores["Identificacion"], $DatosColaboradores["Nombre"]." ".$DatosColaboradores["Identificacion"], 0);
                }
            }
        $css->CerrarSelect();
        print("<br><br>");
        $css->CrearTextArea("TxtConcepto", "", "", "Escriba el por qué se trasladará el titulo", "black", "", "", 200, 100, 0, 1);
        print("<br>");
        $css->CrearBotonConfirmado("BtnTrasladar","Trasladar");	
            
        print("</td>");
        
        $css->CerrarTabla();
        $css->CerrarForm();
        
        
    }else{
        $css->CrearTabla();
        $css->CrearFilaNotificacion("Por favor busque y asocie una titulo",16);
        $css->CerrarTabla();
    }
    $css->CerrarDiv();//Cerramos contenedor Secundario
    $css->CerrarDiv();//Cerramos contenedor Principal
    $css->AgregaJS(); //Agregamos javascripts
    $css->AgregaSubir();
    $css->Footer();
    print("</body></html>");
    ob_end_flush();
?>