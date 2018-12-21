<?php

/* 
 * Archivo para crear un tercero
 */

include_once("../../modelo/php_conexion.php");
include_once("../css_construct.php");

function calcularDV($nit) {
        if (! is_numeric($nit)) {
            return false;
        }
     
        $arr = array(1 => 3, 4 => 17, 7 => 29, 10 => 43, 13 => 59, 2 => 7, 5 => 19, 
        8 => 37, 11 => 47, 14 => 67, 3 => 13, 6 => 23, 9 => 41, 12 => 53, 15 => 71);
        $x = 0;
        $y = 0;
        $z = strlen($nit);
        $dv = '';
        
        for ($i=0; $i<$z; $i++) {
            $y = substr($nit, $i, 1);
            $x += ($y*$arr[$z-$i]);
        }
        
        $y = $x%11;
        
        if ($y > 1) {
            $dv = 11-$y;
            return $dv;
        } else {
            $dv = $y;
            return $dv;
        }
        
    }
    
if(!empty($_REQUEST['TxtNIT']) and !empty($_REQUEST['CmbTipoDocumento']) and $_REQUEST['TxtRazonSocial'] and !empty($_REQUEST['TxtDireccion'])  and !empty($_REQUEST['TxtTelefono'])  and !empty($_REQUEST['TxtDireccion']) ){
    


session_start();
$idUser=$_SESSION['idUser'];
$css =  new CssIni("",0);
$obVenta=new ProcesoVenta($idUser);
    $NIT=$obVenta->normalizar($_REQUEST['TxtNIT']);
    $idMun=$obVenta->normalizar($_REQUEST['CmbCodMunicipio']);
    
    $DatosClientes=$obVenta->DevuelveValores('clientes',"Num_Identificacion",$NIT);

    $DatosMunicipios=$obVenta->DevuelveValores('cod_municipios_dptos',"ID",$idMun);
    $DV="";


    if($DatosClientes["Num_Identificacion"]<>$NIT){

            ///////////////////////////Ingresar a Clientes 

            if($_REQUEST['CmbTipoDocumento']==31){

                    $DV=calcularDV($NIT);

            }

            $tab="clientes";
            $NumRegistros=16;  


            $Columnas[0]="Tipo_Documento";		$Valores[0]=$obVenta->normalizar($_REQUEST['CmbTipoDocumento']);
            $Columnas[1]="Num_Identificacion";		$Valores[1]=$obVenta->normalizar($_REQUEST['TxtNIT']);
            $Columnas[2]="DV";				$Valores[2]=$DV;
            $Columnas[3]="Primer_Apellido";		$Valores[3]=$obVenta->normalizar($_REQUEST['TxtPA']);
            $Columnas[4]="Segundo_Apellido";		$Valores[4]=$obVenta->normalizar($_REQUEST['TxtSA']);
            $Columnas[5]="Primer_Nombre";		$Valores[5]=$obVenta->normalizar($_REQUEST['TxtPN']);
            $Columnas[6]="Otros_Nombres";		$Valores[6]=$obVenta->normalizar($_REQUEST['TxtON']);
            $Columnas[7]="RazonSocial";			$Valores[7]=$obVenta->normalizar($_REQUEST['TxtRazonSocial']);
            $Columnas[8]="Direccion";			$Valores[8]=$obVenta->normalizar($_REQUEST['TxtDireccion']);
            $Columnas[9]="Cod_Dpto";			$Valores[9]=$DatosMunicipios["Cod_Dpto"];
            $Columnas[10]="Cod_Mcipio";			$Valores[10]=$DatosMunicipios["Cod_mcipio"];
            $Columnas[11]="Pais_Domicilio";		$Valores[11]=169;
            $Columnas[12]="Telefono";			$Valores[12]=$obVenta->normalizar($_REQUEST['TxtTelefono']);
            $Columnas[13]="Ciudad";			$Valores[13]=$DatosMunicipios["Ciudad"];
            $Columnas[14]="Email";			$Valores[14]=$obVenta->normalizar($_REQUEST['TxtEmail']);
            $Columnas[15]="Cupo";			$Valores[15]=$obVenta->normalizar($_REQUEST['TxtCupo']);
            $obVenta->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
            $tab="proveedores";
            $obVenta->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
            print("Se ha creado el tercero Exitosamente");
        }else{
            print("El tercero ya existe no se puede duplicar");
        }
    }else{
        print("Debe completar los campos obligatorios");
    }