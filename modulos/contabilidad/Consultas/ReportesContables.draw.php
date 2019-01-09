<?php

session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];

include_once("../clases/ReportesContables.class.php");
include_once("../../../constructores/paginas_constructor.php");

if( !empty($_REQUEST["Accion"]) ){
    $css =  new PageConstruct("", "", 1, "", 1, 0);
    $obCon = new Contabilidad($idUser);
    
    switch ($_REQUEST["Accion"]) {
        case 1: //Crea la vista para el balance x tercero
            $Tipo=$obCon->normalizar($_REQUEST["CmbTipo"]);
            $FechaInicial=$obCon->normalizar($_REQUEST["TxtFechaInicial"]);
            $FechaFinal=$obCon->normalizar($_REQUEST["TxtFechaFinal"]);
            $Empresa=$obCon->normalizar($_REQUEST["CmbCentroCosto"]);
            $CentroCostos=$obCon->normalizar($_REQUEST["CmbEmpresa"]);                        
            $obCon->ConstruirVistaBalanceTercero($Tipo, $FechaInicial, $FechaFinal, $Empresa, $CentroCostos, "");
            print("OKBXT");
        break; 
        
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>