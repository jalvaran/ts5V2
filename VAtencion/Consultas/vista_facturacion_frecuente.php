<?php

session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];
$TipoUser=$_SESSION['tipouser'];
//$myPage="titulos_comisiones.php";
include_once("../../modelo/php_conexion.php");

include_once("../css_construct.php");


if(  !empty($_REQUEST["Page"]) or !empty($_REQUEST["st"]) ){
    $css =  new CssIni("id",0);
    $obGlosas = new ProcesoVenta($idUser);
    $Fecha=$obGlosas->normalizar($_REQUEST['Fecha']);
    // Consultas enviadas a traves de la URL
    $statement="";
    
    //////////////////
    //$CuentaRIPS=$obGlosas->normalizar($_REQUEST['CuentaRIPS']);
    //$CuentaRIPS=str_pad($CuentaRIPS, 6, "0", STR_PAD_LEFT);
        
    $statement=" `vista_facturas_frecuentes` WHERE ProximaFechaFacturacion<='$Fecha'  ";
    if(!empty($_REQUEST['idCliente'])){
        $idCliente=$obGlosas->normalizar($_REQUEST['idCliente']);
        $statement.=" and  idCliente ='$idCliente' ";
    }
    if(isset($_REQUEST['st'])){

        $statement= urldecode($_REQUEST['st']);
        //print($statement);
    }
    $css->CrearNotificacionAzul("Facturas frecuentes", 16);
    //Paginacion
    if(isset($_REQUEST['Page'])){
        $NumPage=$obGlosas->normalizar($_REQUEST['Page']);
    }else{
        $NumPage=1;
    }
    
    $limit = 10;
    $startpoint = ($NumPage * $limit) - $limit;
    $VectorST = explode("LIMIT", $statement);
    $statement = $VectorST[0]; 
    $query = "SELECT COUNT(*) as `num` FROM {$statement}";
    $row = $obGlosas->FetchArray($obGlosas->Query($query));
    $ResultadosTotales = $row['num'];
    $statementPage=$statement;
    $statement.=" ORDER BY ID DESC LIMIT $startpoint,$limit";
    
    
    //print("st:$statement");
    $query="SELECT * ";
    $consulta=$obGlosas->Query("$query FROM $statement");
    if($obGlosas->NumRows($consulta)){
        
        $Resultados=$obGlosas->NumRows($consulta);
        
        $css->CrearTabla();
        //Paginacion
        if($Resultados){
            
            $st= urlencode($statementPage);
            $css->CrearDiv("DivActualizar", "", "center", 0, 1);
                $Page="Consultas/vista_facturacion_frecuente.php?st=$st&Page=1&Carry=";
                $FuncionJS="EnvieObjetoConsulta(`$Page`,`idFacturaActiva`,`DivListFacturas`,`5`);return false ;";

                $css->CrearBotonEvento("BtnActualizarFacturas", "Actualizar", 1, "onclick", $FuncionJS, "naranja", "");
            $css->CerrarDiv();
            
            if($ResultadosTotales>$limit){
                
                $css->FilaTabla(16);
                print("<td  style=text-align:center>");
                if($NumPage>1){
                    
                    
                    $NumPage1=$NumPage-1;
                    $Page="Consultas/vista_facturacion_frecuente.php?st=$st&Page=$NumPage1&Carry=";
                    $FuncionJS="EnvieObjetoConsulta(`$Page`,`idFacturaActiva`,`DivListFacturas`,`5`);return false ;";
                    
                    $css->CrearBotonEvento("BtnMas", "Página $NumPage1", 1, "onclick", $FuncionJS, "rojo", "");
                    
                }
                print("</td>");
                $TotalPaginas= ceil($ResultadosTotales/$limit);
                print("<td colspan=2 style=text-align:center>");
                print("<strong>Página: </strong>");
                                
                $Page="Consultas/vista_facturacion_frecuente.php?st=$st&Page=";
                $FuncionJS="EnvieObjetoConsulta(`$Page`,`CmbPage`,`DivListFacturas`,`5`);return false ;";
                $css->CrearSelect("CmbPage", $FuncionJS,70);
                    for($p=1;$p<=$TotalPaginas;$p++){
                        if($p==$NumPage){
                            $sel=1;
                        }else{
                            $sel=0;
                        }
                        $css->CrearOptionSelect($p, "$p", $sel);
                    }
                    
                $css->CerrarSelect();
                print("</td>");
                print("<td style=text-align:center>");
                if($ResultadosTotales>($startpoint+$limit)){
                    $NumPage1=$NumPage+1;
                    $Page="Consultas/vista_facturacion_frecuente.php?st=$st&Page=$NumPage1&Carry=";
                    $FuncionJS="EnvieObjetoConsulta(`$Page`,`idFacturaActiva`,`DivListFacturas`,`5`);return false ;";
                    $css->CrearBotonEvento("BtnMas", "Página $NumPage1", 1, "onclick", $FuncionJS, "verde", "");
                }
                print("</td>");
               $css->CierraFilaTabla(); 
            }
        }   
        $css->FilaTabla(12);
            $css->ColTabla("<strong>Cliente</strong>", 1);
            $css->ColTabla("<strong>Direccion</strong>", 1);
            $css->ColTabla("<strong>Fecha Última Facturación</strong>", 1);
            
            $css->ColTabla("<strong>Acciones</strong>", 1);
            
        $css->CierraFilaTabla();
        
        while($DatosCuenta=$obGlosas->FetchArray($consulta)){
            $ID=$DatosCuenta["ID"];
            
            $css->FilaTabla(12);
                $css->ColTabla($DatosCuenta["RazonSocial"], 1);
                $css->ColTabla($DatosCuenta["Direccion"], 1);                
                $css->ColTabla($DatosCuenta["UltimaFechaFacturacion"], 1);
                print("<td style='text-align:center'>");
                    $link="PDF_Factura.php?ImgPrintFactura=".$DatosCuenta["UltimaFactura"];
                    $css->CrearLink($link, "_blank", "Ver Última Factura");
                print("</br>");
               
                     $css->CrearBotonEvento("BtnMostrar_$ID", "Seleccionar", 1, "onClick", "SeleccionaFactura('$ID','BtnMostrar_$ID')", "naranja", "");
                print("</td>");
            $css->CierraFilaTabla();
        }
        $css->CerrarTabla();
    }else{
        $css->CrearNotificacionRoja("No hay facturas frecuentes por realizar", 16);
    }
    
}else{
    print("No se enviaron parametros");
}
?>