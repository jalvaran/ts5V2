<?php
/* 
 * Clase donde se realizaran la generacion de informes.
 * Julian Alvaran
 * Techno Soluciones SAS
 */
//include_once '../../modelo/php_tablas.php';
class Informes extends Tabla{
    
    public function InformeFiscalIVA($FechaIni, $FechaFin, $Empresa,$CentroCostos, $idSucursal, $Vector ) {
        
        $this->PDF_Ini("REPORTE FISCAL DE IVA", 8, "");
        $this->PDF_Encabezado($FechaFin,$Empresa, 24, "");
        
        $html= $this->HTML_IVA_ori_facturas($FechaIni, $FechaFin, $Empresa, $CentroCostos, $idSucursal);
        $this->PDF_Write($html);
        
        $html=$this->HTML_IVA_facturas_compra_productos($FechaIni, $FechaFin, $Empresa, $CentroCostos, $idSucursal);
        $this->PDF_Write("<br><hr>".$html);
        
        $html=$this->HTML_IVA_facturas_compra_servicios($FechaIni, $FechaFin, $Empresa, $CentroCostos, $idSucursal);
        $this->PDF_Write("<br><hr>".$html);
        
        $html=$this->HTML_IVA_facturas_compra_productos_devueltos($FechaIni, $FechaFin, $Empresa, $CentroCostos, $idSucursal);
        $this->PDF_Write("<br><hr>".$html);
        
        $html=$this->HTML_IVA_nota_devoluciones($FechaIni, $FechaFin, $Empresa, $CentroCostos, $idSucursal);
        $this->PDF_Write("<br><hr>".$html);
        
        
        
        $this->PDF_Output("FiscalIVA_$FechaFin");
    }
    
    //Arme el Html de las facturas de venta
    
    public function HTML_IVA_ori_facturas($FechaIni,$FechaFin,$Empresa,$CentroCostos,$idSucursal) {
        $FechaCorte=" DE $FechaIni A $FechaFin";
        $CondicionAdicional="";
        if($CentroCostos<>'ALL'){
            $CondicionAdicional.=" AND f.CentroCosto='$CentroCostos'";
        }
        if($idSucursal<>'ALL'){
            $CondicionAdicional.=" AND f.idSucursal='$idSucursal'";
        }
        
        
        $sql="SELECT SUM(fi.`SubtotalItem`) as Subtotal,SUM(fi.`IVAItem`) as IVA,SUM(fi.`TotalItem`) as Total,"
                . "SUM(fi.`ValorOtrosImpuestos`) as OtrosImpuestos, fi.`PorcentajeIVA` "
                . "FROM facturas f INNER JOIN `ori_facturas_items` fi ON f.idFacturas=fi.`idFactura` "
                . "WHERE fi.`FechaFactura`>='$FechaIni' AND fi.`FechaFactura`<='$FechaFin' AND f.FormaPago<>'ANULADA' "
                . "AND f.EmpresaPro_idEmpresaPro='$Empresa' $CondicionAdicional"
                . "GROUP BY `PorcentajeIVA` ";
        
        
        $h=1;
        
        
        $Back="#CEE3F6";
        $html='<table cellspacing="1" cellpadding="2" border="0"  align="center" >';
        $html.='<tr style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">';
        $html.='<td colspan="5"><strong>IVA GENERADO EN EL PERIODO '.$FechaCorte.'</strong></td></tr>'; 
        $html.='<tr style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">';
        $html.='<td><strong>PORCENTAJE</strong></td>';
        $html.='<td><strong>BASE</strong></td>';
        $html.='<td><strong>IVA</strong></td>';
        $html.='<td><strong>TOTAL</strong></td>';
        $html.='<td><strong>OTROS IMPUESTOS</strong></td></tr>';
        $Consulta=$this->obCon->Query($sql);
        $GranSubtotal=0;
        $GranIVA=0;
        $GranTotal=0;
        $GranOtrosImpuestos=0;
        while($DatosIVA=$this->obCon->FetchArray($Consulta)){
            $GranSubtotal=$GranSubtotal+$DatosIVA["Subtotal"];
            $GranIVA=$GranIVA+$DatosIVA["IVA"];
            $GranTotal=$GranTotal+$DatosIVA["Total"];
            $GranOtrosImpuestos=$GranOtrosImpuestos+$DatosIVA["OtrosImpuestos"];
            if($h==0){
                $Back="#f2f2f2";
                $h=1;
            }else{
                $Back="white";
                $h=0;
            }
           
           $html.='<tr align="rigth" border="0" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"> ';
           $html.='<td>'.$DatosIVA["PorcentajeIVA"].'</td>';
           $html.='<td>'.number_format($DatosIVA["Subtotal"]).'</td>';
           $html.='<td>'.number_format($DatosIVA["IVA"]).'</td>';
           $html.='<td>'.number_format($DatosIVA["Total"]).'</td>';
           $html.='<td>'.number_format($DatosIVA["OtrosImpuestos"]).'</td>';
           $html.='</tr>'; 
        }
        $Back="#CEE3F6";
        $html.='<tr align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">';
        $html.='<td><strong>TOTALES</strong></td>';
        $html.='<td><strong>'. number_format($GranSubtotal).'</strong></td>';
        $html.='<td><strong>'. number_format($GranIVA).'</strong></td>';
        $html.='<td><strong>'. number_format($GranTotal).'</strong></td>';
        $html.='<td><strong>'. number_format($GranOtrosImpuestos).'</strong></td></tr>';
        $html.='</table>';
        return($html);
    }
    
    //Arme el Html de las facturas de Compra
    
    public function HTML_IVA_facturas_compra_productos($FechaIni,$FechaFin,$Empresa,$CentroCostos,$idSucursal) {
        $FechaCorte=" DE $FechaIni A $FechaFin";
        $CondicionAdicional="";
        if($CentroCostos<>'ALL'){
            $CondicionAdicional.=" AND f.idCentroCostos='$CentroCostos'";
        }
        if($idSucursal<>'ALL'){
            $CondicionAdicional.=" AND f.idSucursal='$idSucursal'";
        }
        
        
        $sql="SELECT SUM(fi.`SubtotalCompra`) as Subtotal,SUM(fi.`ImpuestoCompra`) as IVA,SUM(fi.`TotalCompra`) as Total,"
                . " fi.`Tipo_Impuesto` "
                . "FROM factura_compra f INNER JOIN `factura_compra_items` fi ON f.ID=fi.`idFacturaCompra` "
                . "WHERE f.`Fecha`>='$FechaIni' AND f.`Fecha`<='$FechaFin' AND f.Estado='CERRADA' "
                . " $CondicionAdicional"
                . "GROUP BY `Tipo_Impuesto` ";
        
        
        $h=1;
        
        
        $Back="#d6fe6c";
        $html='<table cellspacing="1" cellpadding="2" border="0"  align="center" >';
        $html.='<tr style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">';
        $html.='<td colspan="4"><strong>IVA EN COMPRAS DE PRODUCTOS EN EL PERIODO '.$FechaCorte.'</strong></td></tr>'; 
        $html.='<tr style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">';
        $html.='<td><strong>PORCENTAJE</strong></td>';
        $html.='<td><strong>BASE</strong></td>';
        $html.='<td><strong>IVA</strong></td>';
        $html.='<td><strong>TOTAL</strong></td></tr>';
        
        $Consulta=$this->obCon->Query($sql);
        $GranSubtotal=0;
        $GranIVA=0;
        $GranTotal=0;
        
        while($DatosIVA=$this->obCon->FetchArray($Consulta)){
            $GranSubtotal=$GranSubtotal+$DatosIVA["Subtotal"];
            $GranIVA=$GranIVA+$DatosIVA["IVA"];
            $GranTotal=$GranTotal+$DatosIVA["Total"];
            $PorcentajeIVA=$DatosIVA["Tipo_Impuesto"]*100;
            $PorcentajeIVA=$PorcentajeIVA."%";
            if($h==0){
                $Back="#f2f2f2";
                $h=1;
            }else{
                $Back="white";
                $h=0;
            }
           
           $html.='<tr align="rigth" border="0" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"> ';
           $html.='<td>'.$PorcentajeIVA.'</td>';
           $html.='<td>'.number_format($DatosIVA["Subtotal"]).'</td>';
           $html.='<td>'.number_format($DatosIVA["IVA"]).'</td>';
           $html.='<td>'.number_format($DatosIVA["Total"]).'</td>';
           
           $html.='</tr>'; 
        }
        $Back="#d6fe6c";
        $html.='<tr align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">';
        $html.='<td><strong>TOTALES</strong></td>';
        $html.='<td><strong>'. number_format($GranSubtotal).'</strong></td>';
        $html.='<td><strong>'. number_format($GranIVA).'</strong></td>';
        $html.='<td><strong>'. number_format($GranTotal).'</strong></td></tr>';
        
        $html.='</table>';
        return($html);
    }
    
    //Arme el Html de las facturas de Compra
    
    public function HTML_IVA_facturas_compra_productos_devueltos($FechaIni,$FechaFin,$Empresa,$CentroCostos,$idSucursal) {
        $FechaCorte=" DE $FechaIni A $FechaFin";
        $CondicionAdicional="";
        if($CentroCostos<>'ALL'){
            $CondicionAdicional.=" AND f.idCentroCostos='$CentroCostos'";
        }
        if($idSucursal<>'ALL'){
            $CondicionAdicional.=" AND f.idSucursal='$idSucursal'";
        }
        
        
        $sql="SELECT SUM(fi.`SubtotalCompra`) as Subtotal,SUM(fi.`ImpuestoCompra`) as IVA,SUM(fi.`TotalCompra`) as Total,"
                . " fi.`Tipo_Impuesto` "
                . "FROM factura_compra f INNER JOIN `factura_compra_items_devoluciones` fi ON f.ID=fi.`idFacturaCompra` "
                . "WHERE f.`Fecha`>='$FechaIni' AND f.`Fecha`<='$FechaFin' AND f.Estado='CERRADA' "
                . " $CondicionAdicional"
                . "GROUP BY `Tipo_Impuesto` ";
        
        
        $h=1;
        
        
        $Back="#ffe687";
        $html='<table cellspacing="1" cellpadding="2" border="0"  align="center" >';
        $html.='<tr style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">';
        $html.='<td colspan="4"><strong>IVA EN COMPRAS DE PRODUCTOS DEVUELTOS EN EL PERIODO '.$FechaCorte.'</strong></td></tr>'; 
        $html.='<tr style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">';
        $html.='<td><strong>PORCENTAJE</strong></td>';
        $html.='<td><strong>BASE</strong></td>';
        $html.='<td><strong>IVA</strong></td>';
        $html.='<td><strong>TOTAL</strong></td></tr>';
        
        $Consulta=$this->obCon->Query($sql);
        $GranSubtotal=0;
        $GranIVA=0;
        $GranTotal=0;
        
        while($DatosIVA=$this->obCon->FetchArray($Consulta)){
            $GranSubtotal=$GranSubtotal+$DatosIVA["Subtotal"];
            $GranIVA=$GranIVA+$DatosIVA["IVA"];
            $GranTotal=$GranTotal+$DatosIVA["Total"];
            $PorcentajeIVA=$DatosIVA["Tipo_Impuesto"]*100;
            $PorcentajeIVA=$PorcentajeIVA."%";
            if($h==0){
                $Back="#f2f2f2";
                $h=1;
            }else{
                $Back="white";
                $h=0;
            }
           
           $html.='<tr align="rigth" border="0" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"> ';
           $html.='<td>'.$PorcentajeIVA.'</td>';
           $html.='<td>'.number_format($DatosIVA["Subtotal"]).'</td>';
           $html.='<td>'.number_format($DatosIVA["IVA"]).'</td>';
           $html.='<td>'.number_format($DatosIVA["Total"]).'</td>';
           
           $html.='</tr>'; 
        }
        $Back="#ffe687";
        $html.='<tr align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">';
        $html.='<td><strong>TOTALES</strong></td>';
        $html.='<td><strong>'. number_format($GranSubtotal).'</strong></td>';
        $html.='<td><strong>'. number_format($GranIVA).'</strong></td>';
        $html.='<td><strong>'. number_format($GranTotal).'</strong></td></tr>';
        
        $html.='</table>';
        return($html);
    }
    
    //Arme el Html de las facturas de Compra
    
    public function HTML_IVA_facturas_compra_servicios($FechaIni,$FechaFin,$Empresa,$CentroCostos,$idSucursal) {
        $FechaCorte=" DE $FechaIni A $FechaFin";
        $CondicionAdicional="";
        if($CentroCostos<>'ALL'){
            $CondicionAdicional.=" AND f.idCentroCostos='$CentroCostos'";
        }
        if($idSucursal<>'ALL'){
            $CondicionAdicional.=" AND f.idSucursal='$idSucursal'";
        }
        
        
        $sql="SELECT SUM(fi.`Subtotal_Servicio`) as Subtotal,SUM(fi.`Impuesto_Servicio`) as IVA,SUM(fi.`Total_Servicio`) as Total,"
                . " fi.`Tipo_Impuesto` "
                . "FROM factura_compra f INNER JOIN `factura_compra_servicios` fi ON f.ID=fi.`idFacturaCompra` "
                . "WHERE f.`Fecha`>='$FechaIni' AND f.`Fecha`<='$FechaFin' AND f.Estado='CERRADA' "
                . " $CondicionAdicional"
                . "GROUP BY `Tipo_Impuesto` ";
        
        
        $h=1;
        
        
        $Back="#ddfbfb";
        $html='<table cellspacing="1" cellpadding="2" border="0"  align="center" >';
        $html.='<tr style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">';
        $html.='<td colspan="4"><strong>IVA COMPRA DE SERVICIOS EN EL PERIODO '.$FechaCorte.'</strong></td></tr>'; 
        $html.='<tr style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">';
        $html.='<td><strong>PORCENTAJE</strong></td>';
        $html.='<td><strong>BASE</strong></td>';
        $html.='<td><strong>IVA</strong></td>';
        $html.='<td><strong>TOTAL</strong></td></tr>';
        
        $Consulta=$this->obCon->Query($sql);
        $GranSubtotal=0;
        $GranIVA=0;
        $GranTotal=0;
        
        while($DatosIVA=$this->obCon->FetchArray($Consulta)){
            $GranSubtotal=$GranSubtotal+$DatosIVA["Subtotal"];
            $GranIVA=$GranIVA+$DatosIVA["IVA"];
            $GranTotal=$GranTotal+$DatosIVA["Total"];
            $PorcentajeIVA=$DatosIVA["Tipo_Impuesto"]*100;
            $PorcentajeIVA=$PorcentajeIVA."%";
            if($h==0){
                $Back="#f2f2f2";
                $h=1;
            }else{
                $Back="white";
                $h=0;
            }
           
           $html.='<tr align="rigth" border="0" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"> ';
           $html.='<td>'.$PorcentajeIVA.'</td>';
           $html.='<td>'.number_format($DatosIVA["Subtotal"]).'</td>';
           $html.='<td>'.number_format($DatosIVA["IVA"]).'</td>';
           $html.='<td>'.number_format($DatosIVA["Total"]).'</td>';
           
           $html.='</tr>'; 
        }
        $Back="#ddfbfb";
        $html.='<tr align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">';
        $html.='<td><strong>TOTALES</strong></td>';
        $html.='<td><strong>'. number_format($GranSubtotal).'</strong></td>';
        $html.='<td><strong>'. number_format($GranIVA).'</strong></td>';
        $html.='<td><strong>'. number_format($GranTotal).'</strong></td></tr>';
        
        $html.='</table>';
        return($html);
    }
    /**
     * Funcion para retornar el HTML del iva en las notas de devolucion
     * @param type $FechaIni ->Fecha inicial del periodo consultado
     * @param type $FechaFin ->Fecha final del periodo consultado
     * @param type $Empresa ->empresa para la consulta
     * @param type $CentroCostos ->centro de costos
     * @param type $idSucursal ->sucursal
     * @return type -> Retorna el HTML que se dibujará
     */
    public function HTML_IVA_nota_devoluciones($FechaIni,$FechaFin,$Empresa,$CentroCostos,$idSucursal) {
        $FechaCorte=" DE $FechaIni A $FechaFin";
        $CondicionAdicional="";
        if($CentroCostos<>'ALL'){
            $CondicionAdicional.=" AND f.idCentroCostos='$CentroCostos'";
        }
        if($idSucursal<>'ALL'){
            $CondicionAdicional.=" AND f.idSucursal='$idSucursal'";
        }
        
        
        $sql="SELECT SUM(fi.`SubtotalCompra`) as Subtotal,SUM(fi.`ImpuestoCompra`) as IVA,SUM(fi.`TotalCompra`) as Total,"
                . " fi.`Tipo_Impuesto` "
                . "FROM factura_compra_notas_devolucion f INNER JOIN `factura_compra_items_devoluciones` fi ON f.ID=fi.`idNotaDevolucion` "
                . "WHERE f.`Fecha`>='$FechaIni' AND f.`Fecha`<='$FechaFin' AND f.Estado='CERRADA' OR f.Estado='CRUZADA'"
                . " $CondicionAdicional"
                . "GROUP BY `Tipo_Impuesto` ";
        
        
        $h=1;
        
        
        $Back="#ffeded";
        $html='<table cellspacing="1" cellpadding="2" border="0"  align="center" >';
        $html.='<tr style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">';
        $html.='<td colspan="4"><strong>IVA EN NOTAS DE DEVOLUCION EN EL PERIODO '.$FechaCorte.'</strong></td></tr>'; 
        $html.='<tr style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">';
        $html.='<td><strong>PORCENTAJE</strong></td>';
        $html.='<td><strong>BASE</strong></td>';
        $html.='<td><strong>IVA</strong></td>';
        $html.='<td><strong>TOTAL</strong></td></tr>';
        
        $Consulta=$this->obCon->Query($sql);
        $GranSubtotal=0;
        $GranIVA=0;
        $GranTotal=0;
        
        while($DatosIVA=$this->obCon->FetchArray($Consulta)){
            $GranSubtotal=$GranSubtotal+$DatosIVA["Subtotal"];
            $GranIVA=$GranIVA+$DatosIVA["IVA"];
            $GranTotal=$GranTotal+$DatosIVA["Total"];
            $PorcentajeIVA=$DatosIVA["Tipo_Impuesto"]*100;
            $PorcentajeIVA=$PorcentajeIVA."%";
            if($h==0){
                $Back="#f2f2f2";
                $h=1;
            }else{
                $Back="white";
                $h=0;
            }
           
           $html.='<tr align="rigth" border="0" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"> ';
           $html.='<td>'.$PorcentajeIVA.'</td>';
           $html.='<td>'.number_format($DatosIVA["Subtotal"]).'</td>';
           $html.='<td>'.number_format($DatosIVA["IVA"]).'</td>';
           $html.='<td>'.number_format($DatosIVA["Total"]).'</td>';
           
           $html.='</tr>'; 
        }
        $Back="#ffeded";
        $html.='<tr align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">';
        $html.='<td><strong>TOTALES</strong></td>';
        $html.='<td><strong>'. number_format($GranSubtotal).'</strong></td>';
        $html.='<td><strong>'. number_format($GranIVA).'</strong></td>';
        $html.='<td><strong>'. number_format($GranTotal).'</strong></td></tr>';
        
        $html.='</table>';
        return($html);
    }
   //Fin Clases
}
    