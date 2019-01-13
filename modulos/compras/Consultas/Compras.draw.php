<?php

session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];

include_once("../clases/ReciboOrdenCompra.class.php");
include_once("../../../constructores/paginas_constructor.php");

if( !empty($_REQUEST["Accion"]) ){
    $css =  new PageConstruct("", "", 1, "", 1, 0);
    $obCon = new ReciboOrdenCompra($idUser);
    
    switch ($_REQUEST["Accion"]) {
        case 1: //dibujar el formulario para crear una compra nueva
            
            $css->CrearDiv("", "col-md-2", "center", 1, 1);
                print("<h4><strong>Fecha:</strong></h4>");
                $css->input("date", "TxtFecha", "form-control", "TxtFecha", "Fecha", date("Y-m-d"), "Fecha", "off", "", "","style='line-height: 15px;'");
            $css->CerrarDiv();
            $css->CrearDiv("", "col-md-4", "center", 1, 1);
                print("<h4><strong>Tercero:</strong></h4>");
                $css->select("CmbTerceroCrearCompra", "form-control", "CmbTerceroCrearCompra", "", "", "", "style=width:300px");
                    $css->option("", "", "", "", "", "");
                        print("Seleccione un tercero");
                    $css->Coption();
                $css->Cselect();
            $css->CerrarDiv();
            $css->CrearDiv("", "col-md-3", "center", 1, 1); 
                print("<h4><strong>Centro de costos:</strong></h4>");
                $css->select("CmbCentroCosto", "form-control", "CmbCentroCosto", "", "", "", "");
                $Consulta = $obCon->ConsultarTabla("centrocosto","");
                while($CentroCosto=$obCon->FetchArray($Consulta)){
                    $css->option("", "", "", $CentroCosto['ID'], "", "");
                        print($CentroCosto['ID']." ".$CentroCosto['Nombre']);
                    $css->Coption();
                    							
                }
                $css->Cselect();
            $css->CerrarDiv();
            
            $css->CrearDiv("", "col-md-3", "center", 1, 1); 
                print("<h4><strong>Sucursal:</strong></h4>");
                $css->select("idSucursal", "form-control", "idSucursal", "", "", "", "");
                $Consulta = $obCon->ConsultarTabla("empresa_pro_sucursales","");
                while($CentroCosto=$obCon->FetchArray($Consulta)){
                    $css->option("", "", "", $CentroCosto['ID'], "", "");
                        print($CentroCosto['ID']." ".$CentroCosto['Nombre']);
                    $css->Coption();
                    							
                }
                $css->Cselect();
            $css->CerrarDiv();
            
            $css->CrearDiv("", "col-md-2", "center", 1, 1);
                print("<h4><strong>Tipo:</strong></h4>");
                $css->select("TipoCompra", "form-control", "TipoCompra", "", "", "", "");
                    $css->option("", "", "", "FC", "", "");
                        print("FC");
                    $css->Coption();
                    $css->option("", "", "", "RM", "", "");
                        print("RM");
                    $css->Coption();
                $css->Cselect();
            $css->CerrarDiv();
            
            $css->CrearDiv("", "col-md-4", "center", 1, 1);
                print("<h4><strong>Concepto:</strong></h4>");
                $css->textarea("TxtConcepto", "form-control", "TxtConcepto", "Concepto", "Concepto", "", "");
                $css->Ctextarea();
            $css->CerrarDiv();
            
            $css->CrearDiv("", "col-md-3", "center", 1, 1);
                print("<h4><strong>No. Comprobante:</strong></h4>");
                $css->input("text", "TxtNumFactura", "form-control", "TxtNumFactura", "Comprobante", "", "Comprobante", "off", "", "");
            $css->CerrarDiv();
            
            $css->CrearDiv("", "col-md-3", "center", 1, 1);
                print("<h4><strong>Soporte:</strong></h4>");
                $css->input("file", "foto", "", "foto", "Soporte", "", "Soporte", "off", "", "style=width:100%");
            $css->CerrarDiv();
            
            print("<br><br><br><br><br><br><br><br><br><br>");
            
        break; 
        
        
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>