<?php
/* 
 * Este archivo se encarga de escuchar las peticiones para editar un registro
 */

if(!empty($_REQUEST["TipoCodigo"])){
    include_once("../../modelo/php_tablas.php");  //Clases de donde se escribirán las tablas
    include_once("../../modelo/PrintBarras.php");  //Clases para la impresion de codigos de barras
    include_once("../css_construct.php");
    session_start();
    
    $idUser=$_SESSION['idUser'];
    $obTabla = new Tabla($db);
    $obVenta = new ProcesoVenta($idUser);
    $obPrintBarras = new Barras($idUser);
    $idProducto=$obVenta->normalizar($_REQUEST["idProducto"]);
    $Cantidad=$obVenta->normalizar($_REQUEST["TxtCantidad"]);
    $Tabla="productosventa";
    $DatosCB["EmpresaPro"]=1;
    $css =  new CssIni("Print");
    $DatosPuerto=$obVenta->DevuelveValores("config_puertos", "ID", 2);
    
    if($DatosPuerto["Habilitado"]=="SI"){
        switch ($_REQUEST["TipoCodigo"]){
            case 1:
                    //Impresora de codigos de barras Monarch
                
                $obPrintBarras->ImprimirCodigoBarrasMonarch9416TM($Tabla,$idProducto,$Cantidad,$DatosPuerto["Puerto"],$DatosCB);
                
                //$obPrintBarras->ImprimirCBZebraLP2814($Tabla,$idProducto,$Cantidad,$DatosPuerto["Puerto"],$DatosCB);
                
                break;
            case 2:
                
                $obPrintBarras->ImprimirLabelMonarch($Tabla,$idProducto,$Cantidad,$DatosPuerto["Puerto"],$DatosCB);
                break;
            case 3:
                
                $obPrintBarras->ImprimirTiketCortoMonarch($Tabla,$idProducto,$Cantidad,$DatosPuerto["Puerto"],$DatosCB);
                break;
            case 4:
                //print("id $idProducto cantidad: $Cantidad");
                $Tabla="sistemas";
                $obPrintBarras->CodigoBarrasSistemaMonarch9416TM($Tabla,$idProducto,$Cantidad,$DatosPuerto["Puerto"],$DatosCB);
                break;
            case 5:   //Exclusivo Diana Carvajal
                
                $obPrintBarras->LabelImport($Cantidad,$DatosPuerto["Puerto"],$DatosCB);
                break;
            case 6:   //Exclusivo Diana Carvajal
                
                $obPrintBarras->ImprimirLabelZapatos($Cantidad,$DatosPuerto["Puerto"],$DatosCB);
                break;
        }
        
        //$css->CrearNotificacionAzul("Impreso", 16);
    }
    
   $css->VentanaFlotante("Se ha impreso $Cantidad Tikets del producto $idProducto");
    
}

?>