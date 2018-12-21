<?php
session_start();
$idUser=$_SESSION['idUser'];
include_once '../../modelo/php_conexion.php';
//include_once("../clases/Separados.class.php");
include_once("../../modelo/PrintPos.php");      //Imprime documentos en la impresora pos
$obVenta = new ProcesoVenta($idUser);
  

if(isset($_REQUEST["idAccion"])){
    switch($_REQUEST["idAccion"]){
               
        case 1:
            $obPrint=new PrintPos($idUser);
            $idItemSeparado=$obVenta->normalizar($_REQUEST['idItemSeparado']);
            $Cantidad=$obVenta->normalizar($_REQUEST['Cantidad']);
            $NumFactura=$obVenta->FacturarItemSeparado($idItemSeparado,$Cantidad,$idUser,"");
            $obPrint->ImprimeFacturaPOS($NumFactura, "", 1);
            print("OK");
        break;
    
    }
}else{
    print("Error No se recibieron parametros");
}
