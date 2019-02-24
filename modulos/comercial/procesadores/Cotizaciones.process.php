<?php

session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];

include_once("../clases/Cotizaciones.class.php");

if( !empty($_REQUEST["Accion"]) ){
    $obCon = new Cotizaciones($idUser);
    
    switch ($_REQUEST["Accion"]) {
        
        case 1: //Crear una Cotizacion
            $Fecha=$obCon->normalizar($_REQUEST["Fecha"]); 
            $idTercero=$obCon->normalizar($_REQUEST["Tercero"]); 
            
            $Observaciones=$obCon->normalizar($_REQUEST["Observaciones"]); 
            
            $idCotizacion=$obCon->CrearCotizacion($Fecha, $idTercero, $Observaciones, "");
            print("OK;$idCotizacion");            
            
        break; 
        
        case 2: //editar datos generales de una cotizacion
            $idCotizacion=$obCon->normalizar($_REQUEST["idCotizacionActiva"]); 
            $Fecha=$obCon->normalizar($_REQUEST["Fecha"]); 
            $idTercero=$obCon->normalizar($_REQUEST["Tercero"]);           
            $Observaciones=$obCon->normalizar($_REQUEST["Observaciones"]); 
            
            
            $obCon->ActualizaRegistro("cotizacionesv5", "Fecha", $Fecha, "ID", $idCotizacion,0);
            $obCon->ActualizaRegistro("cotizacionesv5", "Clientes_idClientes", $idTercero, "ID", $idCotizacion,0);
            $obCon->ActualizaRegistro("cotizacionesv5", "Observaciones", $Observaciones, "ID", $idCotizacion,0);
            
            $DatosTercero=$obCon->DevuelveValores("clientes", "idClientes", $idTercero);
            
            print("OK;$DatosTercero[RazonSocial]");
            
        break; 
        case 3://Agregar un item
            
            $idCotizacion=$obCon->normalizar($_REQUEST["idCotizacion"]); 
            $CmbListado=$obCon->normalizar($_REQUEST["CmbListado"]); 
            $CmbBusquedas=$obCon->normalizar($_REQUEST["CmbBusquedas"]); 
            $Cantidad=$obCon->normalizar($_REQUEST["Cantidad"]); 
            $ValorUnitario=$obCon->normalizar($_REQUEST["ValorUnitario"]); 
            if($CmbListado==1){
                $TablaItem="productosventa";
            }
            if($CmbListado==2){
                $TablaItem="servicios";
            }
            if($CmbListado==3){
                $TablaItem="productosalquiler";
            }
            $Multiplicador=1;
            $obCon->AgregaItemCotizacion($idCotizacion,$Cantidad,$Multiplicador,$CmbBusquedas,$TablaItem,$ValorUnitario,"");
            
            print("OK");
            
        break;//Fin caso 3
        
        
        case 5://Se elimina un item
            $idItem=$obCon->normalizar($_REQUEST["idItem"]);
            $Tabla=$obCon->normalizar($_REQUEST["Tabla"]);
            if($Tabla==1){
                $Tabla="cot_itemscotizaciones";
            }
            
            $obCon->BorraReg($Tabla, "ID", $idItem);
            print("Item Eliminado");
        break;//Fin caso 5
        
        case 6://Guardo el documento
            $idCotizacion=$obCon->normalizar($_REQUEST["idCotizacion"]);            
            $CmbCuentaIngreso=$obCon->normalizar($_REQUEST["CmbCuentaIngreso"]);
            $TxtAnticipo=$obCon->normalizar($_REQUEST["TxtAnticipo"]);
            $TxtFechaAnticipo=$obCon->normalizar($_REQUEST["TxtFechaAnticipo"]);
            
            $obCon->ActualizaRegistro("cotizacionesv5", "Estado", "Cerrada", "ID", $idCotizacion);
            $MensajeComprobante="";
            if($TxtAnticipo>0){
                $CentroCotos=1;
                $idComprobanteIngreso=$obCon->AnticipoCotizacion($TxtFechaAnticipo, $idCotizacion, $TxtAnticipo, $CmbCuentaIngreso, $CentroCotos, "");
                $LinkComprobante="../../VAtencion/PDF_Documentos.php?idDocumento=4&idIngreso=$idComprobanteIngreso";
                $MensajeComprobante="<br><strong>Comprobante de ingreso $idComprobanteIngreso Creado Correctamente </strong><a href='$LinkComprobante'  target='blank'> Imprimir</a>";
           
            }
            
            
            $LinkCotizacion="../../VAtencion/ImprimirPDFCotizacion.php?ImgPrintCoti=$idCotizacion";
                        
            $Mensaje="<strong>Cotizacion $idCotizacion Creada Correctamente </strong><a href='$LinkCotizacion'  target='blank'> Imprimir</a>";
            $Mensaje.=$MensajeComprobante;
            print("OK;$Mensaje");
        break;//Fin caso 6
        
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>