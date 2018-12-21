<?php 
$myPage="CorregirLibro.php";
include_once("../sesiones/php_control.php");

$obVenta = new ProcesoVenta($idUser);
$obTabla = new Tabla($db);

if(isset($_REQUEST["BtnAjustar"])){
    $Mov=$obVenta->normalizar($_REQUEST["Mov"]);
    $idLibro=$obVenta->normalizar($_REQUEST["idLibro"]);
    $Diferencia=$obVenta->normalizar($_REQUEST["TxtDiferencia"]);
    $DatosLibro=$obVenta->DevuelveValores("librodiario", "idLibroDiario", $idLibro);
    
    $sql="UPDATE librodiario SET ";
    if($Mov=="D"){
        $NuevoDebito=$DatosLibro["Debito"]-$Diferencia;
        $sql.="Debito='$NuevoDebito', Neto='$NuevoDebito' ";
    }else{
        $NuevoCredito=$DatosLibro["Credito"]+$Diferencia;
        $NuevoNeto=$NuevoCredito*(-1);
        $sql.="Credito='$NuevoCredito', Neto='$NuevoNeto' ";
    }
    $sql.=" WHERE idLibroDiario='$idLibro'";
    $obVenta->Query($sql);
}
include_once("css_construct.php");

print("<html>");
print("<head>");
$css =  new CssIni("Correccion de Documentos");

print("</head>");




print("<body>");
    
    $css->CabeceraIni("Correccion de Documentos"); //Inicia la cabecera de la pagina
    
    
    $css->CabeceraFin(); 
    ///////////////Creamos el contenedor
    /////
    /////
    $css->CrearDiv("principal", "container", "center",1,1);
    $css->CrearDiv("secundario", "", "center",1,1);
    if(isset($_REQUEST["TipoDoc"])){
        $TipoDoc=$obVenta->normalizar($_REQUEST["TipoDoc"]);
        $NumDoc=$obVenta->normalizar($_REQUEST["NumDoc"]);
        
        $css->CrearTabla();
        $css->FilaTabla(16);
        $css->ColTabla("<strong>Datos del Documento $TipoDoc $NumDoc</strong>", 6);
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
        $css->ColTabla("<strong>idLibro</strong>", 1);
        $css->ColTabla("<strong>Cuenta</strong>", 1);
        $css->ColTabla("<strong>Nombre</strong>", 1);
        $css->ColTabla("<strong>Debitos</strong>", 1);
        $css->ColTabla("<strong>Creditos</strong>", 1);
        $css->ColTabla("<strong>Accion</strong>", 1);
        $css->CierraFilaTabla();
        $Diferencia=$obVenta->Sume("librodiario", "Neto", " WHERE Tipo_Documento_Intero='$TipoDoc' AND Num_Documento_Interno='$NumDoc'");
        $sql="SELECT idLibroDiario, Credito, Debito, CuentaPUC,NombreCuenta FROM librodiario "
                . " WHERE Tipo_Documento_Intero='$TipoDoc' AND Num_Documento_Interno='$NumDoc'";
        $Consulta=$obVenta->Query($sql);
        $TotalDebitos=0;
        $TotalCreditos=0;
        while($DatosLibro=$obVenta->FetchArray($Consulta)){
            $Mov="";
            if($DatosLibro["Debito"]<>0){
                $Mov="D";
            }
            if( $DatosLibro["Credito"]<>0){
                $Mov="C";
            }
            $css->FilaTabla(16);
            $TotalDebitos=$TotalDebitos+$DatosLibro["Debito"];
            $TotalCreditos=$TotalCreditos+$DatosLibro["Credito"];
            $css->ColTabla($DatosLibro["idLibroDiario"], 1);
            $css->ColTabla($DatosLibro["CuentaPUC"], 1);
            $css->ColTabla($DatosLibro["NombreCuenta"], 1);
            $css->ColTabla($DatosLibro["Debito"], 1);
            $css->ColTabla($DatosLibro["Credito"], 1);
            print("<td>");
            $css->CrearForm2("FrmAjustar".$DatosLibro["idLibroDiario"], $myPage, "post", "_self");
            $css->CrearInputText("idLibro", "hidden", "", $DatosLibro["idLibroDiario"], "", "", "", "", "", "", "", "");
            $css->CrearInputText("TipoDoc", "hidden", "", $TipoDoc, "", "", "", "", "", "", "", "");
            $css->CrearInputText("NumDoc", "hidden", "", $NumDoc, "", "", "", "", "", "", "", "");
            $css->CrearInputText("Mov", "hidden", "", $Mov, "", "", "", "", "", "", "", "");
            $css->CrearInputText("TxtDiferencia", "hidden", "", $Diferencia, "", "", "", "", "", "", "", "");
            $css->CrearBotonConfirmado("BtnAjustar", "Ajustar en este movimiento");
            $css->CerrarForm();
            print("</td>");
            $css->CierraFilaTabla();
        }
        //$Diferencia=$TotalDebitos-$TotalCreditos;
        $css->FilaTabla(16);
        $css->ColTabla("<strong>Totales</strong>", 3);
        $css->ColTabla("<strong>$TotalDebitos</strong>", 1);
        $css->ColTabla("<strong>$TotalCreditos</strong>", 1);
        $css->ColTabla("<strong>$Diferencia</strong>", 1);
        $css->CierraFilaTabla();
        $css->CerrarTabla();
    }
    $css->CerrarDiv();//Cerramos contenedor secundario
    $css->CerrarDiv();//Cerramos contenedor Principal
    $css->AgregaJS(); //Agregamos javascripts
    $css->AgregaSubir();
    $css->Footer();
    print("</body></html>");
?>