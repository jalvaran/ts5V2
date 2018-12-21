<?php

/* 
 * Este archivo procesa la anulacion de una factura
 */

if(!empty($_REQUEST["BtnTrasladar"])){
$obVenta=new ProcesoVenta($idUser);        
$idMayor=$obVenta->normalizar($_REQUEST["Mayor"]);
$TablaTraslado=$obVenta->normalizar($_REQUEST["CmbListado"]);
$fecha=$obVenta->normalizar($_REQUEST["TxtFechaTraslado"]);
$Concepto=$obVenta->normalizar($_REQUEST["TxtConcepto"]);
$idColaborador=$obVenta->normalizar($_REQUEST["CmbColaborador"]);
$DatosTitulo=$obVenta->DevuelveValores($TablaTraslado, "Mayor1",$idMayor);
$DatosColaborador=$obVenta->DevuelveValores("colaboradores", "Identificacion",$idColaborador);
$Promocion=substr($TablaTraslado, 27);

//Creo el Registro el comprobante de traslado de titulo  
    
    
     ////////////////Creo el comprobante
    /////
    ////
    
    $tab="titulos_traslados";
    $NumRegistros=8; 

    $Columnas[0]="Fecha";                       $Valores[0]=$fecha;
    $Columnas[1]="Promocion";                   $Valores[1]=$Promocion;
    $Columnas[2]="Mayor1";                      $Valores[2]=$idMayor;
    $Columnas[3]="idColaboradorAnterior";       $Valores[3]=$DatosTitulo["idColaborador"];
    $Columnas[4]="NombreColaboradorAnterior";   $Valores[4]=$DatosTitulo["NombreColaborador"];
    $Columnas[5]="idColaboradorAsignado";       $Valores[5]=$DatosColaborador["Identificacion"];
    $Columnas[6]="NombreColaboradorAsignado";   $Valores[6]=$DatosColaborador["Nombre"];
    $Columnas[7]="Observaciones";               $Valores[7]=$Concepto;
    
    $obVenta->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
    $idComprobante=$obVenta->ObtenerMAX($tab, "ID", 1, "");
    
    
    $obVenta->ActualizaRegistro($TablaTraslado, "idColaborador", $DatosColaborador["Identificacion"], "Mayor1", $idMayor);
    $obVenta->ActualizaRegistro($TablaTraslado, "NombreColaborador", $DatosColaborador["Nombre"], "Mayor1", $idMayor);
    $obVenta->ActualizaRegistro($TablaTraslado, "FechaEntregaColaborador", $fecha, "Mayor1", $idMayor);
    header("location:imprime_traslado_titulo.php?TxtidComprobante=$idComprobante");
        
    }
?>