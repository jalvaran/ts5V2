<?php
/* 
 * Clase donde se realizaran la generacion de informes.
 * Julian Alvaran
 * Techno Soluciones SAS
 */
//include_once '../../modelo/php_tablas.php';
class Cartel extends Tabla{
    
    public function PDF_CrearCartelPublicidad() {
        $this->PDF_Ini("CARTEL PUBLICIDAD", 8, "",0);
        $html=$this->HTML_Cartel(1);
        $this->PDF_Write($html);
        $this->PDF->AddPage();
        $html=$this->HTML_Cartel(2);
        $this->PDF_Write($html);
        $this->PDF_Output("Cartel");
    }
    //Arme html del cartel pagina 1
    public function HTML_Cartel($Pagina) {
        $DatosEmpresaPro=$this->obCon->DevuelveValores("empresapro", "idEmpresaPro", 1);
        $DatosPublicidad=$this->obCon->DevuelveValores("publicidad_encabezado_cartel", "ID", 1);
        $ColorTitulo=$DatosPublicidad["ColorTitulo"];
        $ColorRazonSocial=$DatosPublicidad["ColorRazonSocial"];
        $ColorPrecios=$DatosPublicidad["ColorPrecios"];
        $ColorBordes=$DatosPublicidad["ColorBordes"];
        $RutaLogo="../$DatosEmpresaPro[RutaImagen]";
        $RutaOfertas="../images/ofertas.png";
        $Back="#9FF781";
        $html='<table cellspacing="1" cellpadding="2" border="0"  align="center" >';
        $html.='<tr style="border-bottom: 1px solid;">';
        $html.='<td colspan="3" style="text-align: left;height:192px;">';
        $html.='<img src="'.$RutaOfertas.'" style="width:500px;height:100px;">';
        $html.='<div style="width: 500px;height: 100px;font-style: italic;text-align: center;font-size: 30px;color: '.$ColorTitulo.';">';
        $html.='<strong>'.$DatosPublicidad["Titulo"].'</strong>';
        $html.='</div>'; 
        $html.='<div style="width: 500px;height: 100px;font-style: italic;text-align: left;font-size: 10px;color: black;">';
        $html.='Válido del '.$DatosPublicidad["Desde"].' hasta el '.$DatosPublicidad["Hasta"].' de '.$DatosPublicidad["Mes"].' del año '.$DatosPublicidad["Anio"].' ó hasta agotar existencias.';
        $html.='</div>'; 
        $html.='</td>';
        $html.='<td colspan="1" style="text-align: center;height:192px;">';
        $html.='<img src="'.$RutaLogo.'" style="width:150px;height:100px;">';
        $html.='<div style="width: 200px;height: 100px;font-style: italic;font-size: 14px;color: '.$ColorRazonSocial.';">'
                . '<strong>'.$DatosEmpresaPro["RazonSocial"].'</strong><br>'
                . '<strong>'.$DatosEmpresaPro["Direccion"].'</strong><br>'
                . '<strong>'.$DatosEmpresaPro["Telefono"].'</strong><br>'
                . '<strong>'.$DatosEmpresaPro["Ciudad"].'</strong>';
        $html.='</div>'; 
        //$html.='<div style="width:100px;height:180px;"><img src="'.$RutaLogo.'" style="width:100px;height:180px;"></div>';
        $html.='</td></tr>'; 
        //$html.='<td colspan="1" style="text-align: center;"><img src="'.$RutaLogo.'" style="width:110px;height:60px;"></td></tr>';
        $html.='<tr style="border-bottom: 1px solid ;">';
        
        for($i=1;$i<=16;$i++){
            if($Pagina==1){
               $z=$i; 
            }else{
               $z=$i+16;
            }
            $DatosPublicidad=$this->obCon->DevuelveValores("publicidad_paginas","ID",$z);
            $DatosProducto=$this->obCon->DevuelveValores("productosventa","idProductosVenta",$DatosPublicidad["idProducto"]);
            $html.='<td style="border: 1px dashed '.$ColorBordes.';height:170px;width:25%;font-style: italic;"><strong>'.$DatosProducto["Nombre"].'</strong>';
            $html.='<br><div style="height:100px;">';
            
            if($DatosProducto["idProductosVenta"]>0){
                $html.='<img id="'.$DatosProducto["idProductosVenta"].'" src="../'.$DatosProducto["RutaImagen"].'" width="90px" height="90px">';
            }  
            $html.='</div>';
            $html.='<div style="width: 200px;height: 100px;font-style: italic;font-size: 35px;color: '.$ColorPrecios.';"><strong>$ '.number_format($DatosProducto["PrecioVenta"]).'</strong>';
            $html.='</div>';
            $html.='</td>';
            if($i==4 or $i==8 or $i==12){
                $html.=('</tr><tr style="border-bottom: 1px solid ;">');
            }
        }
        $html.=("</tr></table>");
        return($html);
    }
   //Fin Clases
}
    