<?php
$obVenta = new ProcesoVenta($idUser);
if(!empty($_REQUEST['BtnCargar'])){
    $destino="";
    $TablaUpload=$obVenta->normalizar($_REQUEST['TablaUpload']);
    if(!empty($_FILES['UplListado']['type'])){
        
        $TipoArchivo=$_FILES['UplListado']['type'];
        $NombreArchivo=$_FILES['UplListado']['name'];
        //if($TipoArchivo=="text/csv"){
            
            
            $handle = fopen($_FILES['UplListado']['tmp_name'], "r");
            $i=0;
            
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                
                $tab=$TablaUpload;
                $NumRegistros=3;

                $Columnas[0]="Mayor1";      $Valores[0]=$data[0];
                $Columnas[1]="Mayor2";      $Valores[1]=$data[1];
                $Columnas[2]="Adicional";   $Valores[2]=$data[2];
                
                $obVenta->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);   
               
                
            }
            
            fclose($handle);
            
      
    }
}

if(!empty($_REQUEST['BtnAsignarTitulo'])){
    
    
    $Desde=$obVenta->normalizar($_REQUEST['TxtTituloDesde']);
    $Hasta=$obVenta->normalizar($_REQUEST['TxtTituloHasta']);
    $TablaTitulos=$obVenta->normalizar($_REQUEST['TablaTitulo']);
    $idPromocion=$obVenta->normalizar($_REQUEST['idListado']);
    $Fecha=$obVenta->normalizar($_REQUEST['TxtFechaAsignacion']);
    $idColaborador=$obVenta->normalizar($_REQUEST['CmbColaboradorAsignado']);
    $Observaciones=$obVenta->normalizar($_REQUEST['TxtObservacionesAsignacion']);
    
    $sql="SELECT Mayor1, idColaborador, NombreColaborador FROM $TablaTitulos WHERE idColaborador<>'0' AND Mayor1>='$Desde' AND Mayor1<='$Hasta'";
    $Datos=$obVenta->Query($sql);
    if($Desde<=$Hasta){
        if($obVenta->NumRows($Datos)){
            while($DatosTitulos=$obVenta->FetchArray($Datos)){
                $Titulo=$DatosTitulos["Mayor1"];
                $TitulosOcupados[$Titulo]["Numero"]=$Titulo;
                $TitulosOcupados[$Titulo]["idColaborador"]=$DatosTitulos["idColaborador"];
                $TitulosOcupados[$Titulo]["NombreColaborador"]=$DatosTitulos["NombreColaborador"];
            }
            $css->CrearNotificacionRoja("No se puede realizar esta asignacion porque los siguientes titulos estan ocupados:",16);
            print("<pre>");
            print_r($TitulosOcupados);
            print("</pre>");
        }else{
            $idAsignacion=$obVenta->AsignarTitulosColaborador($TablaTitulos,$Fecha,$Desde,$Hasta,$idPromocion,$idColaborador,$Observaciones,"");
            $css->CrearNotificacionVerde("Se asignaron los titulos del $Desde hasta $Hasta, de la promocion $idPromocion, al Colaborador: $idColaborador",16);
            $RutaPrint="../tcpdf/examples/ImprimaAsignacionTitulos.php?idAsignacion=".$idAsignacion;
            $css->CrearNotificacionVerde("<a href='$RutaPrint' target='_blank'>Imprimir Acta de Entrega de Titulos No. $idAsignacion</a>",16);
        }
    }else{
        $css->CrearNotificacionRoja("Valores de los titulos incorrectos 'Desde' debe ser menor o igual a 'Hasta'",16);
    }
    
}