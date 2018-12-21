<?php
$css= new CssIni("");
$obVenta=new ProcesoVenta($idUser);  
/* 
 * Este archivo procesa la anulacion de un abono a un titulo
 */

if(!empty($_REQUEST["BtnCrearDiferencias"])){
          
    $consulta=$obVenta->ConsultarTabla("inventarios_temporal", "");
    while($DatosProductoTemporal=$obVenta->FetchArray($consulta)){
        $DatosProductoFisico=$obVenta->DevuelveValores("productosventa", "idProductosVenta", $DatosProductoTemporal["idProductosVenta"]);
        $Diferencia=$DatosProductoFisico["Existencias"]-$DatosProductoTemporal["Existencias"];
        $CostoTotal=$Diferencia*$DatosProductoTemporal["CostoUnitario"];
        
        $tab="inventarios_diferencias";	
        $NumRegistros=18;
        
        $Columnas[0]="idProductosVenta";$Valores[0]=$DatosProductoTemporal["idProductosVenta"];
        $Columnas[1]="CodigoBarras";	$Valores[1]=$DatosProductoTemporal["CodigoBarras"];
        $Columnas[2]="Referencia";	$Valores[2]=$DatosProductoTemporal["Referencia"];
        $Columnas[3]="Nombre";          $Valores[3]=$DatosProductoTemporal["Nombre"];
        $Columnas[4]="Diferencia";	$Valores[4]=$Diferencia;
        $Columnas[5]="PrecioVenta";	$Valores[5]=$DatosProductoTemporal["PrecioVenta"];
        $Columnas[6]="Updated";         $Valores[6]=date("Y-m-d H:i:s");
        $Columnas[7]="CostoUnitario";   $Valores[7]=$DatosProductoTemporal["CostoUnitario"];
        $Columnas[8]="CostoTotal";	$Valores[8]=$CostoTotal;
        $Columnas[9]="IVA";             $Valores[9]=$DatosProductoTemporal["IVA"];
        $Columnas[10]="ExistenciaAnterior"; $Valores[10]=$DatosProductoTemporal["Existencias"];
        $Columnas[11]="Departamento";	$Valores[11]=$DatosProductoTemporal["Departamento"];
        $Columnas[12]="Sub1";           $Valores[12]=$DatosProductoTemporal["Sub1"];
        $Columnas[13]="Sub2";           $Valores[13]=$DatosProductoTemporal["Sub2"];
        $Columnas[14]="Sub3";           $Valores[14]=$DatosProductoTemporal["Sub3"];
        $Columnas[15]="Sub4";		$Valores[15]=$DatosProductoTemporal["Sub4"];
        $Columnas[16]="Sub5";		$Valores[16]=$DatosProductoTemporal["Sub5"];
        $Columnas[17]="ExistenciaActual"; $Valores[17]=$DatosProductoFisico["Existencias"];
        
        $obVenta->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
        $obVenta->BorraReg("inventarios_temporal", "idProductosVenta", $DatosProductoTemporal["idProductosVenta"]);
    }
}
?>