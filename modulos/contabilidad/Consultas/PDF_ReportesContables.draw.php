<?php 
if(isset($_REQUEST["idDocumento"])){
    
    include_once("../../../modelo/php_conexion.php");
    //include_once("../../modelo/PrintPos.php");
    include_once("../clases/PDF_ReportesContables.class.php");
    session_start();
    $idUser=$_SESSION["idUser"];
    $obCon = new conexion($idUser);
    
    $obDoc = new Documento($db);
    $idDocumento=$obCon->normalizar($_REQUEST["idDocumento"]);
    
    
    switch ($idDocumento){
        case 1://Genera el PDF de una retencion en la fuente
            
            $idCotizacion=$obCon->normalizar($_REQUEST["ID"]);
            
            $obDoc->PDF_Cotizacion($idCotizacion, "");
    
            
        break;
        
    }
}else{
    print("No se recibió parametro de documento");
}

?>