<?php

include("../../modelo/php_conexion.php");
$BaseIVA=0;
////////////////////////////////////////////
/////////////Obtengo el rango de fechas
////////////////////////////////////////////
$VerFacturas=0;
$obVenta = new ProcesoVenta(1);
$fecha=date("Y-m-d");
$FechaIni = $obVenta->normalizar($_POST["TxtFechaIniPI"]);
$FechaFinal = $obVenta->normalizar($_POST["TxtFechaFinPI"]);
$consulta=$obVenta->ConsultarTabla("porcentajes_iva", "WHERE Habilitado='SI'");
    while($DatosIVA=$obVenta->FetchArray($consulta)){
        $idIVA=$DatosIVA["ID"];
        if(isset($_POST["TxtPorcentaje".$idIVA])){
            $PorcentajeIVAS[$idIVA]=$obVenta->normalizar($_POST["TxtPorcentaje".$idIVA])/100;
        }
    }
//$Porcentaje=$obVenta->normalizar($_POST["TxtPorcentaje"])/100;

$Condicion=" ori_facturas_items WHERE ";
$Condicion2="ori_facturas WHERE ";

$CondicionFecha1=" FechaFactura >= '$FechaIni' AND FechaFactura <= '$FechaFinal' ";
$CondicionFecha2=" Fecha >= '$FechaIni' AND Fecha <= '$FechaFinal' ";
$Rango="De $FechaIni a $FechaFinal";


$CondicionItems=$Condicion.$CondicionFecha1;
$CondicionFacturas=$Condicion2.$CondicionFecha2;

$idFormatoCalidad=16;

$Documento="<strong>Informe De Ventas $Rango</strong>";
require_once('Encabezado.php');

$nombre_file=$fecha."_Reporte_Fiscal";
		   

///////////////////////////////////////////////////////
//////////////tabla con los datos de ventas//////////////////
////////////////////////////////////////////////////////


$tbl = <<<EOD


<span style="color:RED;font-family:'Bookman Old Style';font-size:12px;"><strong><em>Total de Ventas Discriminadas por Departamento:
</em></strong></span><BR><BR>


<table border="1" cellspacing="2" align="center" >
  <tr> 
    <th><h3>Departamento</h3></th>
	<th><h3>Nombre</h3></th>
        <th><h3>Impuesto</h3></th>
	<th><h3>Total Items</h3></th>
    <th><h3>SubTotal</h3></th>
        
	<th><h3>IVA</h3></th>
	<th><h3>Total</h3></th>
  </tr >
  
</table>


EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');

/*
$sql="SELECT `PorcentajeIVA` FROM `ori_facturas_items` GROUP BY `PorcentajeIVA` ";
$consulta=$obVenta->Query($sql);
while($DatosIVA=$obVenta->FetchArray($consulta)){
    $TipoIVA=$DatosIVA["PorcentajeIVA"];
    
}
 */       
if(isset($_POST["BtnAplicar"])){
    foreach($PorcentajeIVAS as $key => $value){
        $idIVA = $key;
        $DatosPIVA=$obVenta->DevuelveValores("porcentajes_iva", "ID", $idIVA);
        $CondicionPorcentaje=$DatosPIVA["Valor"]*100;
        $CondicionPorcentaje=$CondicionPorcentaje."%";
        if($DatosPIVA["Valor"]=="E"){
            $CondicionPorcentaje="Exc";
        }
        $DatosIVA[$CondicionPorcentaje]["Valor"]=0;
        $DatosIVA[$CondicionPorcentaje]["Base"]=0;
        $Porcentaje=$value;
        $sql="UPDATE ori_facturas_items SET TotalItem = TotalItem * $Porcentaje , SubtotalItem=SubtotalItem*$Porcentaje, IVAItem=IVAItem*$Porcentaje "
        . "  WHERE $CondicionFecha1 AND PorcentajeIVA='$CondicionPorcentaje'";
        $obVenta->Query($sql);
    }



//$obVenta->ActualizaFacturasFromItems($FechaIni,$FechaFinal,1,"");
}

if(isset($_POST["BtnVistaPrevia"])){
    $z=0;
    $sql="";
    foreach($PorcentajeIVAS as $key => $value){
        if($z==0){
            $z=1;
        }else{
          $sql.=" UNION ALL "; 
        }
        $idIVA = $key;
        $DatosPIVA=$obVenta->DevuelveValores("porcentajes_iva", "ID", $idIVA);
        $CondicionPorcentaje=$DatosPIVA["Valor"]*100;
        $CondicionPorcentaje=$CondicionPorcentaje."%";
        if($DatosPIVA["Valor"]=="E"){
            $CondicionPorcentaje="Exc";
        }
        $DatosIVA[$CondicionPorcentaje]["Valor"]=0;
        $DatosIVA[$CondicionPorcentaje]["Base"]=0;
        $Porcentaje=$value;
        $sql.="SELECT Departamento as idDepartamento, SUM(ValorOtrosImpuestos) as TotalBolsas,`PorcentajeIVA`,sum(`TotalItem`)*$Porcentaje as Total, sum(`IVAItem`)*$Porcentaje as IVA, sum(`SubtotalItem`)*$Porcentaje as Subtotal, SUM(Cantidad) as Items"
              . "  FROM $CondicionItems  AND PorcentajeIVA='$CondicionPorcentaje' GROUP BY Departamento,`PorcentajeIVA`";
    }    


}else{
    
    $sql="SELECT Departamento as idDepartamento,SUM(ValorOtrosImpuestos) as TotalBolsas, `PorcentajeIVA`,sum(`TotalItem`) as Total, sum(`IVAItem`) as IVA, sum(`SubtotalItem`) as Subtotal, SUM(Cantidad) as Items"
    . "  FROM $CondicionItems GROUP BY Departamento,`PorcentajeIVA`";
   
   
}

//print($sql);

$Datos=$obVenta->Query($sql);
$TotalBolsas=0;
$Subtotal=0;
$TotalIVA=0;
$TotalVentas=0;
$TotalItems=0;
$flagQuery=0;   //para indicar si hay resultados
$i=-1;
$TotalExluidos=0;

$DatosIVA[0]["Valor"]=0;
$DatosIVA[0]["Base"]=0;

$DatosIVAP[]=0;
while($DatosVentas=$obVenta->FetchArray($Datos)){
        $TotalBolsas=$TotalBolsas+$DatosVentas["TotalBolsas"];
	$i++;
        $flagQuery=1;
        $TipoIva=$DatosVentas["PorcentajeIVA"];
        
            $PIVA= str_replace("%", "", $TipoIva);
            $PIVA=$PIVA/100;
            
        
        $Total=round($DatosVentas["Total"],-2);
        $Subtotal1=$Total/(1+$PIVA);
        $IVA=$Total-$Subtotal1;
        $SubtotalUser=number_format($Subtotal1);
        //$SubtotalUser=number_format($DatosVentas["Subtotal"]);
        //$IVA=$DatosVentas["Subtotal"]*$PIVA;
        //$Total=$DatosVentas["Subtotal"]+$IVA;
        $Items=number_format($DatosVentas["Items"]);
        $DatosDepartamento=$obVenta->DevuelveValores("prod_departamentos", "idDepartamentos", $DatosVentas["idDepartamento"]);
        $NombreDep=$DatosDepartamento["Nombre"];
        if(!isset($DatosIVA[$TipoIva]["Valor"])){
            $DatosIVA[$TipoIva]["Valor"]=0;
            $DatosIVA[$TipoIva]["Base"]=0;
        }
        $DatosIVAP[$TipoIva]=$TipoIva;
        $DatosIVA[$TipoIva]["Valor"]=$DatosIVA[$TipoIva]["Valor"]+$IVA;
        $DatosIVA[$TipoIva]["Base"]=$DatosIVA[$TipoIva]["Base"]+$Subtotal1;
        $Subtotal=$Subtotal+$Subtotal1;
        $TotalIVA=$TotalIVA+$IVA;
        $TotalVentas=$TotalVentas+$Total;
        $TotalItems=$TotalItems+$DatosVentas["Items"];
        $idDepartamentos=$DatosVentas["idDepartamento"];
        $IVA= number_format($IVA);
        $Total= number_format($Total);
        $tbl = <<<EOD

<table border="1" cellpadding="2"  align="center">
 <tr>
  <td>$idDepartamentos</td>
  <td>$NombreDep</td>
  <td>$TipoIva</td>
  <td>$Items</td>
  <td>$SubtotalUser</td>
  
  <td>$IVA</td>
  <td>$Total</td>
 </tr>
 </table>
EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');

}
	
if($flagQuery==1){
$BaseIVA=$Subtotal;
$TotalVentasFinal=$TotalVentas;
$TotalIVAFinal=$TotalIVA;
$TotalItems=number_format($TotalItems);
$Subtotal=number_format($Subtotal);
$TotalIVA=number_format($TotalIVA);
$TotalVentas=number_format($TotalVentas);

$tbl = <<<EOD

<table border="1" cellspacing="2" align="center">
 <tr>
  <td align="RIGHT"><h3>SUMATORIA</h3></td>
  <td><h3>NA</h3></td>
  <td><h3>NA</h3></td>
  <td><h3>$TotalItems</h3></td>
  <td><h3>$Subtotal</h3></td>
        
  <td><h3>$TotalIVA</h3></td>
  <td><h3>$TotalVentas</h3></td>
 </tr>
 </table>
EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');
	
        }


////////////////////////////////////////////////////////////////////////////////
/////////////////////////FACTURAS NUMERACION////////////////////////////
////////////////////////////////////////////////////////////////////////////////

$tbl = <<<EOD


<BR><BR><span style="color:RED;font-family:'Bookman Old Style';font-size:12px;"><strong><em>Informe de Numeracion Facturas:
</em></strong></span><BR><BR>


<table border="1" cellspacing="2" align="center" >
  <tr> 
    <th><h3>Resolucion</h3></th>
    <th><h3>Factura Inicial</h3></th>
    <th><h3>Factura Final</h3></th>
    <th><h3>Total Clientes</h3></th>
	
  </tr >
  
</table>


EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');

$sql="SELECT idResolucion,MAX(NumeroFactura) as MaxFact, MIN(NumeroFactura) as MinFact FROM facturas
	WHERE $CondicionFecha2 GROUP BY idResolucion";
$sel1=$obVenta->Query($sql);


while($DatosNumFact=$obVenta->FetchArray($sel1)){
	$MinFact=$DatosNumFact["MinFact"];
	$MaxFact=$DatosNumFact["MaxFact"];
        $idResolucion=$DatosNumFact["idResolucion"];
	$TotalFacts=$MaxFact-$MinFact+1;
	
	
	
$tbl = <<<EOD

<table border="1"  cellpadding="2" align="center">
 <tr>
  <td>$idResolucion</td>
  <td>$MinFact</td>
  <td>$MaxFact</td>
  <td>$TotalFacts</td>
 
 </tr>
 </table>
EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');
	
}

////////////////////////////////////////////////////////////////////////////////
/////////////////////////INFORMACION DE IVA////////////////////////////
////////////////////////////////////////////////////////////////////////////////
$tbl = <<<EOD


<BR><BR><span style="color:RED;font-family:'Bookman Old Style';font-size:12px;"><strong><em>Informe con los Porcentajes de IVA en ventas:
</em></strong></span><BR><BR>
        <table border="1" cellspacing="2" align="center" >
  <tr> 
	
    <th><h3>Porcentaje</h3></th>
    <th><h3>Base</h3></th>
    <th><h3>Valor</h3></th>
            </tr>
      </table>  
EOD;
$pdf->writeHTML($tbl, false, false, false, false, '');
foreach($DatosIVAP as $TipoIva){
	
		
    $Base= number_format($DatosIVA[$TipoIva]["Base"]);
    $Valor=number_format($DatosIVA[$TipoIva]["Valor"]);
    if($DatosIVA[$TipoIva]["Base"]<>0){
    $tbl = <<<EOD


<table border="1" cellspacing="1" cellpadding="2" align="center" >
  
    <tr>
        <td>$TipoIva </td>
        <td>$Base</td>
        <td>$Valor</td>
  
 
 </tr>
	  
</table>


EOD;
    $pdf->writeHTML($tbl, false, false, false, false, '');
    }
    
}


////////////////////////////////////////////////////////////////////////////////
/////////////////////////BOLSAS////////////////////////////
////////////////////////////////////////////////////////////////////////////////
if($TotalBolsas>0){
$tbl =' 
<BR><BR><span style="color:RED;font-family:Bookman Old Style;font-size:12px;"><strong><em>Otros Impuestos:
</em></strong></span><BR><BR>
<table border="1" cellspacing="2" cellpadding="2" align="center" >
  <tr> 
    <th><h3>Nombre</h3></th>
    <th><h3>Total</h3></th>
    	
  </tr >
  <tr> 
    <th>IMPUESTO AL CONSUMO DE BOLSAS</th>
    <th>'.number_format($TotalBolsas).'</th>
    	
  </tr >
</table>';


$pdf->writeHTML($tbl, false, false, false, false, '');

}

////////////////////////////////////////////////////////////////////////////////
/////////////////////////TIPO VENTAS////////////////////////////
////////////////////////////////////////////////////////////////////////////////

$tbl = <<<EOD


<BR><BR><span style="color:RED;font-family:'Bookman Old Style';font-size:12px;"><strong><em>Tipo de Ventas:
</em></strong></span><BR><BR>


<table border="1" cellspacing="2" align="center" >
  <tr> 
    <th><h3>Efectivo</h3></th>
    <th><h3>Ventas al Detal</h3></th>
    <th><h3>Ventas al Por mayor</h3></th>
    
	
  </tr >
  <tr> 
    <th><h3>$TotalVentas</h3></th>
    <th><h3>$TotalVentas</h3></th>
    <th><h3>0</h3></th>
    
	
  </tr >
</table>


EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');

if(isset($_POST["BtnAplicar"])){
    if($TotalFacts==0){
        $TotalFacts=1;
    }
    $PromedioSubtotal=round($BaseIVA/$TotalFacts);
    $PromedioIVA=$PromedioSubtotal*0.19;
    $PromedioTotal=$PromedioSubtotal+$PromedioIVA;

    $sql="UPDATE ori_facturas SET Total='$PromedioTotal',Subtotal='$PromedioSubtotal', IVA='$PromedioIVA' WHERE $CondicionFecha2";
    $obVenta->Query($sql);
}
 
//Close and output PDF document
$pdf->Output($nombre_file.'.pdf', 'I');


//============================================================+
// END OF FILE
//============================================================+
?>