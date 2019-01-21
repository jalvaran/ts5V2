<?php

if(file_exists("../../../general/clases/ClasesPDFDocumentos.class.php")){
    include_once("../../../general/clases/ClasesPDFDocumentos.class.php");
}

class PDF_ReportesContables extends Documento{
    
    public function CertificadoRetencion($FechaInicial, $FechaFinal,$CmbTercero, $Empresa, $CentroCostos,$CmbCiudadRetencion,$CmbCiudadPago, $Vector) {
        $idCotizacion=1;
        $DatosCotizacion= $this->obCon->DevuelveValores("cotizacionesv5", "ID", $idCotizacion);
        $NumeracionDocumento="COTIZACION No. $idCotizacion";
        $this->PDF_Ini("Cotizacion_$idCotizacion", 8, "","","../../../");
        
        //$this->PDF_Encabezado($DatosCotizacion["Fecha"],1, 1, "",$NumeracionDocumento);
        $this->PDF_Encabezado_Cotizacion($idCotizacion);
        $html= $this->ArmeHTMLItemsCotizacion($idCotizacion);
        //print($html);
        
        $Position=$this->PDF->SetY(85);
        $this->PDF_Write($html);
        
        $Position=$this->PDF->GetY();
        if($Position>250){
          $this->PDF_Add();
        }
        
        $html= $this->ArmeHTMLTotalesCotizacion($idCotizacion);
        $Position=$this->PDF->SetY(250);
        $this->PDF_Write($html);
        
       // $this->PDF->MultiCell(184, 30, $html, 1, 'L', 1, 0, '', '254', true,0, true, true, 10, 'M');
        
        $Datos=$this->obCon->ConsultarTabla("cotizaciones_anexos", " WHERE NumCotizacion='$idCotizacion'");
        $this->PDF->SetMargins(20, 20, 30);
        
        $this->PDF->SetHeaderMargin(20);
        
        while ($DatosAnexos=$this->obCon->FetchArray($Datos)){
            $this->PDF_Add();
            $this->PDF_Write($DatosAnexos["Anexo"]);
        }
        $PDFBase64=$this->PDF->Output("Cotizacion_$idCotizacion".".pdf", 'E');
        //$this->PDF_Output("Cotizacion_$idCotizacion");
        return($PDFBase64);
    }
    
    /**
     * Fin Clase
     */
}
