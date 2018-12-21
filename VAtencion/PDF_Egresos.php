<?php 
$myPage="PDF_Egresos.php";
include_once("../sesiones/php_control.php");
include_once("clases/ClasesPDFDocumentos.php");
include_once("../modelo/PrintPos.php");	
$obPrint=new PrintPos($idUser);

if(isset($_REQUEST["BtnPrintEgreso"])){
    
    $obVenta = new ProcesoVenta($idUser);
    $obDoc = new Documento($db);
    $idEgreso=$obVenta->normalizar($_REQUEST["BtnPrintEgreso"]);
    $obDoc->PDF_Egreso($idEgreso);   
    
    $DatosImpresora=$obVenta->DevuelveValores("config_puertos", "ID", 1);
    
    if($DatosImpresora["Habilitado"]=="SI"){
        
        $obPrint->ImprimeEgresoPOS($idEgreso,"",$DatosImpresora["Puerto"],1);

    }
    
}
?>