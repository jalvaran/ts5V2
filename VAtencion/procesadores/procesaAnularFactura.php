<?php

/* 
 * Este archivo procesa la anulacion de una factura
 */

if(!empty($_REQUEST["BtnAnular"])){
$obVenta=new ProcesoVenta($idUser);        
$idFactura=$_REQUEST["TxtIdFactura"];
$fecha=$_REQUEST["TxtFechaAnulacion"];
$ConceptoAnulacion=$_REQUEST["TxtConceptoAnulacion"];
$hora=date("H:i");

$DatosFactura=$obVenta->DevuelveValores("facturas", "idFacturas",$idFactura);
$Concepto="Anulacion de Factura $DatosFactura[Prefijo] - $DatosFactura[NumeroFactura] por: ".$ConceptoAnulacion;

//Creo el comprobante que realizará la anulacion de la factura    
    
    
     ////////////////Creo el comprobante
    /////
    ////
    
    $tab="notascredito";
    $NumRegistros=6; 

    $Columnas[0]="Fecha";                   $Valores[0]=$fecha;
    $Columnas[1]="Concepto";                $Valores[1]=$Concepto;
    $Columnas[2]="Hora";                    $Valores[2]=$hora;
    $Columnas[3]="Usuarios_idUsuarios";     $Valores[3]=$idUser;
    $Columnas[4]="idFactura";               $Valores[4]=$idFactura;
    $Columnas[5]="Cliente";                 $Valores[5]=$DatosFactura["Clientes_idClientes"];
    
    $obVenta->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
    $idComprobante=$obVenta->ObtenerMAX($tab, "ID", 1, "");
    $obVenta->AnularMovimientoLibroDiario("FACTURA", $idFactura, "");
    /*
    $Consulta=$obVenta->ConsultarTabla("librodiario", "WHERE Tipo_Documento_Intero='FACTURA' AND Num_Documento_Interno='$idFactura'");
    while($DatosLibroDiario=$obVenta->FetchArray($Consulta)){
        
        $tab="librodiario";
        $NumRegistros=27;
        $CuentaPUC=$DatosLibroDiario["CuentaPUC"];
        $NombreCuenta=$DatosLibroDiario["NombreCuenta"];
        if( substr($CuentaPUC, 0, 1)==4){
            $DatosCuentaDevolucion=$obVenta->DevuelveValores("parametros_contables", "ID", 9);
            $CuentaPUC=$DatosCuentaDevolucion["CuentaPUC"];
            $NombreCuenta=$DatosCuentaDevolucion["NombreCuenta"];
        }
        $Debito=$DatosLibroDiario["Credito"];
        $Credito=$DatosLibroDiario["Debito"];
        $Neto=$DatosLibroDiario["Neto"]*(-1);
        
        $Columnas[0]="Fecha";					$Valores[0]=$fecha;
        $Columnas[1]="Tipo_Documento_Intero";                   $Valores[1]="NOTA CREDITO";
        $Columnas[2]="Num_Documento_Interno";                   $Valores[2]=$idComprobante;
        $Columnas[3]="Tercero_Tipo_Documento";                  $Valores[3]=$DatosLibroDiario['Tercero_Tipo_Documento'];
        $Columnas[4]="Tercero_Identificacion";                  $Valores[4]=$DatosLibroDiario['Tercero_Identificacion'];
        $Columnas[5]="Tercero_DV";				$Valores[5]=$DatosLibroDiario['Tercero_DV'];
        $Columnas[6]="Tercero_Primer_Apellido";                 $Valores[6]=$DatosLibroDiario['Tercero_Primer_Apellido'];
        $Columnas[7]="Tercero_Segundo_Apellido";                $Valores[7]=$DatosLibroDiario['Tercero_Segundo_Apellido'];
        $Columnas[8]="Tercero_Primer_Nombre";                   $Valores[8]=$DatosLibroDiario['Tercero_Primer_Nombre'];
        $Columnas[9]="Tercero_Otros_Nombres";                   $Valores[9]=$DatosLibroDiario['Tercero_Otros_Nombres'];
        $Columnas[10]="Tercero_Razon_Social";                   $Valores[10]=$DatosLibroDiario['Tercero_Razon_Social'];
        $Columnas[11]="Tercero_Direccion";                      $Valores[11]=$DatosLibroDiario['Tercero_Direccion'];
        $Columnas[12]="Tercero_Cod_Dpto";                       $Valores[12]=$DatosLibroDiario['Tercero_Cod_Dpto'];
        $Columnas[13]="Tercero_Cod_Mcipio";                     $Valores[13]=$DatosLibroDiario['Tercero_Cod_Mcipio'];
        $Columnas[14]="Tercero_Pais_Domicilio";                 $Valores[14]=$DatosLibroDiario['Tercero_Pais_Domicilio'];

        $Columnas[15]="CuentaPUC";				$Valores[15]=$CuentaPUC;
        $Columnas[16]="NombreCuenta";                           $Valores[16]=$NombreCuenta;
        $Columnas[17]="Detalle";				$Valores[17]="Anulacion de Factura";
        $Columnas[18]="Debito";					$Valores[18]=$Debito;
        $Columnas[19]="Credito";				$Valores[19]=$Credito;
        $Columnas[20]="Neto";					$Valores[20]=$Neto;
        $Columnas[21]="Mayor";					$Valores[21]="NO";
        $Columnas[22]="Esp";					$Valores[22]="NO";
        $Columnas[23]="Concepto";				$Valores[23]=$Concepto;
        $Columnas[24]="idCentroCosto";				$Valores[24]=$DatosLibroDiario['idCentroCosto'];
        $Columnas[25]="idEmpresa";				$Valores[25]=$DatosLibroDiario['idEmpresa'];
        $Columnas[26]="Estado";                                 $Valores[26]="";
        
        $obVenta->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
    }
     * 
     */
    //Elimino de cartera en caso de que esté ahi
    $obVenta->BorraReg("cartera", "Facturas_idFacturas",$idFactura);
    //Alimento el inventario
    $obVenta->ReingreseItemsInventario($idFactura);
    //Se actualiza para no anular la misma
    $obVenta->ActualizaRegistro("facturas", "FormaPago", "ANULADA", "idFacturas", $idFactura);
header("location:AnularFactura.php?TxtidComprobante=$idComprobante");
        
    }
?>