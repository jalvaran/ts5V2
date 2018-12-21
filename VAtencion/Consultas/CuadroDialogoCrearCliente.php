<?php

/* 
 * Archivo donde se incluyen las clases para crear un cuadro de dialogo para crear un cliente
 */

include_once("../../modelo/php_conexion.php");
include_once("../css_construct.php");
include_once("../clases/Restaurante.class.php");
session_start();
$idUser=$_SESSION['idUser'];
$css =  new CssIni("",0);
$obVenta = new ProcesoVenta($idUser);
    $css->CrearNotificacionAzul("Crear Tercero", 16);
    
    $css->CrearSelect("CmbTipoDocumento","Oculta()");
    $css->CrearOptionSelect('13','Cedula',1);
    $css->CrearOptionSelect('31','NIT',0);
    $css->CrearOptionSelect('12','Tarjeta Identidad',0);
    $css->CrearOptionSelect('22','Cedula Extranjeria',0);
    $css->CerrarSelect();
    //$css->CrearInputText("CmbPreVentaAct","hidden","",$idPreventa,"","","","",0,0,0,0);
    $css->CrearInputText("TxtNIT","number","","","Identificacion","black","","",200,30,0,1);
    echo '<br>';
    $css->CrearInputText("TxtPN","text","","","Primer Nombre","black","onkeyup","CrearNombreCompleto()",200,30,0,0);
    $css->CrearInputText("TxtON","text","","","Otros Nombres","black","onkeyup","CrearNombreCompleto()",200,30,0,0);
    $css->CrearInputText("TxtPA","text","","","Primer Apellido","black","onkeyup","CrearNombreCompleto()",200,30,0,0);
    $css->CrearInputText("TxtSA","text","","","Segundo Apellido","black","onkeyup","CrearNombreCompleto()",200,30,0,0);
    
    $css->CrearInputText("TxtRazonSocial","text","","","Razon Social","black","","",200,30,0,1);
    $css->CrearInputText("TxtDireccion","text","","","Direccion","black","","",200,30,0,1);
    $css->CrearInputText("TxtTelefono","text","","","Telefono","black","","",200,30,0,1);

    $css->CrearInputText("TxtEmail","text","","","Email","black","","",200,30,0,1);
    $css->CrearInputText("TxtCupo","text","",0,"Cupo Credito","black","","",200,30,0,1);
    $VarSelect["Ancho"]="200";
    $VarSelect["PlaceHolder"]="Seleccione el municipio";
    $css->CrearSelectChosen("CmbCodMunicipio", $VarSelect);

    $sql="SELECT * FROM cod_municipios_dptos";
    $Consulta=$obVenta->Query($sql);
       while($DatosMunicipios=$obVenta->FetchArray($Consulta)){
           $Sel=0;
           if($DatosMunicipios["ID"]==1011){
               $Sel=1;
           }
           $css->CrearOptionSelect($DatosMunicipios["ID"], $DatosMunicipios["Ciudad"], $Sel);
       }
    $css->CerrarSelect();
    echo '<br><br>';
    $css->CrearBotonEvento("BtnCrearTercero", "Crear", 1, "onClick", "CrearTercero()", "naranja", "");
    
    