<?php 
$myPage="traslados_mercancia.php";
include_once("../sesiones/php_control.php");
include_once("css_construct.php");

$sql="";
$myPage="DescargarTraslados.php";
$obVenta = new conexion($idUser);
$DatosSucursal=$obVenta->DevuelveValores("empresa_pro_sucursales", "Actual", 1);
$DatosServer=$obVenta->DevuelveValores("servidores", "ID", 1);
if(isset($_REQUEST["LkBajar"])){
    /*
    $VectorTraslado["LocalHost"]=$host;
    $VectorTraslado["User"]=$user;
    $VectorTraslado["PW"]=$pw;
    $VectorTraslado["DB"]=$db;
    $Mensaje=$obVenta->DescargarTraslado(1,$VectorTraslado);
    */
    $FechaSinc=date("Y-m-d H:i:s");
    $Condicion="WHERE DestinoSincronizado ='0000-00-00 00:00:00' AND Destino='$DatosSucursal[ID]' ";
    $sql="SELECT * FROM traslados_mercancia $Condicion";
    $Consulta=$obVenta->QueryExterno($sql, $DatosServer["IP"], $DatosServer["Usuario"], $DatosServer["Password"], $DatosServer["DataBase"], "");
    $sqlTraslados="REPLACE INTO `traslados_mercancia` (`ID`, `Fecha`, `Hora`, `Origen`, `ConsecutivoInterno`, `Destino`, `Descripcion`, `idBodega`, `Estado`, `Abre`, `Cierra`, `ServerSincronizado`, `DestinoSincronizado`) VALUES ";
    while($DatosTraslados=$obVenta->FetchAssoc($Consulta)){
        $sqlTraslados.="('$DatosTraslados[ID]','$DatosTraslados[Fecha]','$DatosTraslados[Hora]','$DatosTraslados[Origen]'"
                . ",'$DatosTraslados[ConsecutivoInterno]','$DatosTraslados[Destino]','$DatosTraslados[Descripcion]',"
                . "'$DatosTraslados[idBodega]','$DatosTraslados[Estado]','$DatosTraslados[Abre]','$DatosTraslados[Cierra]',"
                . "'$DatosTraslados[ServerSincronizado]','$DatosTraslados[DestinoSincronizado]')";
        $sqlTraslados.=",";
    }
    $sqlTraslados = substr($sqlTraslados, 0, -1);
    $obVenta->Query($sqlTraslados);
    $sql="UPDATE traslados_mercancia SET DestinoSincronizado='$FechaSinc' $Condicion ";
    $obVenta->QueryExterno($sql, $DatosServer["IP"], $DatosServer["Usuario"], $DatosServer["Password"], $DatosServer["DataBase"], "");
    $obVenta->Query($sql);
    
    $sql="SELECT * FROM traslados_items $Condicion";
    $Consulta=$obVenta->QueryExterno($sql, $DatosServer["IP"], $DatosServer["Usuario"], $DatosServer["Password"], $DatosServer["DataBase"], "");
    
    
    $sqlItems="REPLACE INTO `traslados_items` (`ID`, `Fecha`, `idTraslado`, `Destino`, `CodigoBarras`, `Referencia`, `Nombre`, `Cantidad`,"
            . " `PrecioVenta`, `PrecioMayorista`, `CostoUnitario`, `IVA`, `Departamento`, `Sub1`, `Sub2`, `Sub3`, `Sub4`, `Sub5`, `CuentaPUC`, `Estado`, `ServerSincronizado`, `DestinoSincronizado`, `CodigoBarras1`, `CodigoBarras2`, `CodigoBarras3`, `CodigoBarras4`) VALUES ";
    while($DatosTraslados=$obVenta->FetchAssoc($Consulta)){
        $sqlItems.="('$DatosTraslados[ID]','$DatosTraslados[Fecha]','$DatosTraslados[idTraslado]','$DatosTraslados[Destino]'"
                . ",'$DatosTraslados[CodigoBarras]','$DatosTraslados[Referencia]','$DatosTraslados[Nombre]',"
                . "'$DatosTraslados[Cantidad]','$DatosTraslados[PrecioVenta]','$DatosTraslados[PrecioMayorista]','$DatosTraslados[CostoUnitario]',"
                . "'$DatosTraslados[IVA]','$DatosTraslados[Departamento]','$DatosTraslados[Sub1]',"
                . "'$DatosTraslados[Sub2]','$DatosTraslados[Sub3]','$DatosTraslados[Sub4]','$DatosTraslados[Sub5]',"
                . "'$DatosTraslados[CuentaPUC]','$DatosTraslados[Estado]','$DatosTraslados[ServerSincronizado]','$DatosTraslados[DestinoSincronizado]',"
                . "'$DatosTraslados[CodigoBarras1]','$DatosTraslados[CodigoBarras2]','$DatosTraslados[CodigoBarras3]','$DatosTraslados[CodigoBarras4]')";
        $sqlItems.=",";
    }
    
    $sqlItems = substr($sqlItems, 0, -1);
    $obVenta->Query($sqlItems);
    $sql="UPDATE traslados_items SET DestinoSincronizado='$FechaSinc' $Condicion ";
    $obVenta->QueryExterno($sql, $DatosServer["IP"], $DatosServer["Usuario"], $DatosServer["Password"], $DatosServer["DataBase"], "");
    $obVenta->Query($sql);    
    header("location:$myPage");
}	

print("<html>");
print("<head>");
$css =  new CssIni("Descargar Traslados de Mercancia desde la Nube");

print("</head>");
print("<body>");
    
    //include_once("procesadores/ProcesaCreaTraslado.php");
    
    $css->CabeceraIni("Descargar Traslados desde la Nube"); //Inicia la cabecera de la pagina
   
    $css->CabeceraFin(); 
    
    
    ///////////////Creamos el contenedor
    /////
    /////
     
     
    $css->CrearDiv("principal", "container", "center",1,1);
    
    $VectorCon["Fut"]=0;  //$DatosServer["IP"]
    $Consulta=$obVenta->QueryExterno("SELECT * FROM traslados_mercancia LIMIT 1", $DatosServer["IP"], $DatosServer["Usuario"], $DatosServer["Password"], $DatosServer["DataBase"], $VectorCon);
    //$Mensaje=$obVenta->ConToServer($DatosServer["IP"], $DatosServer["Usuario"], $DatosServer["Password"], $DatosServer["DataBase"], $VectorCon);
    $DatosConsulta=$obVenta->FetchAssoc($Consulta);
    $Mensaje="Sin Conexión";
    if($DatosConsulta["ID"]<>''){
        $Mensaje="Conexión Satisfactoria";
    }
    if($DatosConsulta["ID"]==''){
        $Mensaje="Conectado";
    }
    $css->CrearNotificacionNaranja($Mensaje, 16);
    //$css->CrearNotificacionAzul($sql, 16);
    print("<strong>Click para Descargar</strong><br>");
    $css->CrearImageLink($myPage."?LkBajar=1", "../images/descargar.png", "_self", 200, 200);
    //$obVenta->ConToServer($host,$user,$pw,$db,$VectorCon);
    $css->CrearDiv("Secundario", "container", "center",1,1);
    $css->Creartabla();
    $css->CrearNotificacionNaranja("TRASLADOS PENDIENTES POR DESCARGAR", 16);
    $sql="SELECT * FROM traslados_mercancia WHERE DestinoSincronizado ='0000-00-00 00:00:00' AND Destino='$DatosSucursal[ID]' AND Estado='PREPARADO'";
    $consulta=$obVenta->QueryExterno($sql, $DatosServer["IP"], $DatosServer["Usuario"], $DatosServer["Password"], $DatosServer["DataBase"], "");
    //$consulta=$obVenta->ConsultarTabla("traslados_mercancia", "WHERE DestinoSincronizado ='0000-00-00 00:00:00' AND Destino='$DatosSucursal[ID]' AND Estado='PREPARADO'");
    if($obVenta->NumRows($consulta)){
        $css->FilaTabla(16);
        $css->ColTabla("<strong>ID</strong>", 1);
        $css->ColTabla("<strong>Fecha</strong>", 1);
        $css->ColTabla("<strong>Destino</strong>", 1);
        $css->ColTabla("<strong>Descripcion</strong>", 1);
        $css->ColTabla("<strong>Usuario</strong>", 1);
        $css->CierraFilaTabla();
        while($DatosTraslados=$obVenta->FetchArray($consulta)){
            $css->FilaTabla(16);
            $css->ColTabla($DatosTraslados["ID"], 1);
            $css->ColTabla($DatosTraslados["Fecha"], 1);
            $DatosSucursal=$obVenta->DevuelveValores("empresa_pro_sucursales", "ID", $DatosTraslados["Destino"]);
            $css->ColTabla($DatosSucursal["Nombre"], 1);
            $css->ColTabla($DatosTraslados["Descripcion"], 1);
            $css->ColTabla($DatosTraslados["Abre"], 1);
            $css->CierraFilaTabla();
        }
    }else{
        $css->CrearFilaNotificacion("No hay traslados pendientes por descargar", 16);
    }   
    
    $css->CerrarTabla();
    $css->CerrarDiv();//Cerramos contenedor Secundario
    $css->CerrarDiv();//Cerramos contenedor Principal
    $css->AgregaJS(); //Agregamos javascripts
    $css->AgregaSubir();
    $css->AnchoElemento("CmbDestino_chosen", 200);
    $css->AnchoElemento("CmbCuentaDestino_chosen", 200);
    print("</body></html>");
    ob_end_flush();
?>