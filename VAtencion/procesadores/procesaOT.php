<?php

/* 
 * Este archivo se encarga de agregar items a las ordenes de trabajo
 * 
 */
include_once("../modelo/php_tablas.php");
///////////////////////////////
////////Si se solicita borrar algo
////
////

if(!empty($_REQUEST['del'])){
    $id=$_REQUEST['del'];
    $Tabla=$_REQUEST['TxtTabla'];
    $IdTabla=$_REQUEST['TxtIdTabla'];
    $IdPre=$_REQUEST['TxtIdPre'];
    $obVenta->Query("DELETE FROM $Tabla WHERE $IdTabla='$id'");
    header("location:AgregaItemsOT.php?idOT=$IdPre");
}


/*
 * 
 * Si llega la peticion de crear la factura
 * 
 */

if(!empty($_REQUEST["BtnAgregarItemOT"])){
        $obTabla= NEW Tabla($db);
        $idOT=$_REQUEST['TxtIdOT'];
        $Actividad=$_REQUEST['TxtActividad'];
        $FechaIni=$_REQUEST["TxtFechaIni"];
        $FechaFin=$_REQUEST["TxtFechaFin"];
        $Horas=$_REQUEST["TxtHoras"];
        $Observaciones=$_REQUEST["TxtObservaciones"];
        $idColaborador=$_REQUEST["CmbColaborador"];
        
       
        ////////////////Inserto datos de ot items
       /////
       ////
       $ID=$obTabla->ObtengaID();
       $tab="ordenesdetrabajo_items";
       $NumRegistros=9; 

       $Columnas[0]="ID";		    $Valores[0]=$ID;
       $Columnas[1]="idOT";                 $Valores[1]=$idOT;
       $Columnas[2]="Actividad";            $Valores[2]=$Actividad;
       $Columnas[3]="FechaInicio";          $Valores[3]=$FechaIni;
       $Columnas[4]="FechaFin";             $Valores[4]=$FechaFin;
       $Columnas[5]="TiempoEstimadoHoras";  $Valores[5]=$Horas;
       $Columnas[6]="idColaborador";        $Valores[6]=$idColaborador;
       $Columnas[7]="Estado";               $Valores[7]="A";
       $Columnas[8]="Observaciones";        $Valores[8]=$Observaciones;
       
       $obVenta->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
       header("location:AgregaItemsOT.php?idOT=$idOT");
        
    }
?>