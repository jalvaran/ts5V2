<?php

session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];

include_once("../clases/Cotizaciones.class.php");
include_once("../../../constructores/paginas_constructor.php");

if( !empty($_REQUEST["Accion"]) ){
    $css =  new PageConstruct("", "", 1, "", 1, 0);
    $obCon = new Cotizaciones($idUser);
    
    switch ($_REQUEST["Accion"]) {
        case 1: //dibujar el formulario para crear una cotizacion nueva
            $css->input("hidden", "idAccion", "", "TxtOpcionGuardarEditar", "", "1", "", "", "", "");        
           
            $css->CrearDiv("", "col-md-12", "center", 1, 1);
                print("<h4><strong>Fecha:</strong></h4>");
                $css->input("date", "TxtFecha", "form-control", "TxtFecha", "Fecha", date("Y-m-d"), "Fecha", "off", "", "","style='line-height: 15px;'");
            $css->CerrarDiv();
            $css->CrearDiv("", "col-md-12", "center", 1, 1);
                print("<h4><strong>Tercero:</strong></h4>");
                $css->select("CmbTercero", "form-control", "CmbTercero", "", "", "", "style=width:100%");
                    $css->option("", "", "", "", "", "");
                        print("Seleccione un tercero");
                    $css->Coption();
                $css->Cselect();
            $css->CerrarDiv();
                         
            $css->CrearDiv("", "col-md-12", "center", 1, 1);
                print("<h4><strong>Observaciones:</strong></h4>");
                $css->textarea("TxtObservaciones", "form-control", "TxtObservaciones", "Observaciones", "Observaciones", "", "");
                $css->Ctextarea();
            $css->CerrarDiv();
            print("<br><br><br><br><br><br><br><br><br><br><br><br><br><br>");
            
        break; 
        case 2:// se dibuja el formulario para editar los datos generales de la cotizacion
            $idCotizacion=$obCon->normalizar($_REQUEST["idCotizacion"]);
            $DatosCotizacion=$obCon->DevuelveValores("cotizacionesv5", "ID", $idCotizacion);
            $DatosTercero=$obCon->DevuelveValores("clientes", "idClientes", $DatosCotizacion["Clientes_idClientes"]);
            $css->input("hidden", "idAccion", "", "TxtOpcionGuardarEditar", "", "2", "", "", "", "");        
            $css->CrearDiv("", "col-md-12", "center", 1, 1);
                print("<h4><strong>Fecha:</strong></h4>");
                $css->input("date", "TxtFecha", "form-control", "TxtFecha", "Fecha", $DatosCotizacion["Fecha"], "Fecha", "off", "", "","style='line-height: 15px;'");
            $css->CerrarDiv();
            $css->CrearDiv("", "col-md-12", "center", 1, 1);
                print("<h4><strong>Tercero:</strong></h4>");
                $css->select("CmbTercero", "form-control", "CmbTerceroCrearCompra", "", "", "", "style=width:100%");
                    $css->option("", "", "", $DatosCotizacion["Clientes_idClientes"], "", "");
                        print($DatosTercero["RazonSocial"]." ".$DatosTercero["Num_Identificacion"]);
                    $css->Coption();
                $css->Cselect();
            $css->CerrarDiv();
            
            
            $css->CrearDiv("", "col-md-12", "center", 1, 1);
                print("<h4><strong>Observaciones:</strong></h4>");
                $css->textarea("TxtObservaciones", "form-control", "TxtObservaciones", "Observaciones", "Observaciones", "", "");
                    print($DatosCotizacion["Observaciones"]);
                $css->Ctextarea();
            $css->CerrarDiv();            
                       
            print("<br><br><br><br><br><br><br><br><br><br><br><br><br><br>");
            
        break;  
        
        case 3://Dibuja los items de una cotizacion
            $idCotizacion=$obCon->normalizar($_REQUEST["idCotizacion"]);
            $css->CrearTabla();
                $css->FilaTabla(16);
                    
                    $css->ColTabla("<strong>Nombre</strong>", 1, "C");
                    $css->ColTabla("<strong>Referencia</strong>", 1, "C");
                    $css->ColTabla("<strong>Cantidad</strong>", 1, "C");
                    $css->ColTabla("<strong>Valor Unitario</strong>", 1, "C");
                    $css->ColTabla("<strong>Subtotal</strong>", 1, "C");
                    $css->ColTabla("<strong>Impuestos</strong>", 1, "C");
                    $css->ColTabla("<strong>Total</strong>", 1, "C");                    
                    $css->ColTabla("<strong>Eliminar</strong>", 1, "C");
                    
                $css->CierraFilaTabla();
                //Dibujo los productos
                $sql="SELECT *
                         FROM cot_itemscotizaciones WHERE NumCotizacion='$idCotizacion' ORDER BY ID DESC";
                $Consulta=$obCon->Query($sql);
                while ($DatosItems = $obCon->FetchAssoc($Consulta)) {
                    $idItem=$DatosItems["ID"];
                    
                    $css->FilaTabla(16);
                        $css->ColTabla($DatosItems["Descripcion"], 1, "C");                   
                        
                        $css->ColTabla($DatosItems["Referencia"], 1, "C");
                        $css->ColTabla(number_format($DatosItems["Cantidad"]), 1, "C");
                        $css->ColTabla(number_format($DatosItems["ValorUnitario"],2,",","."), 1, "C");
                        $css->ColTabla(number_format($DatosItems["Subtotal"],2,",","."), 1, "C");
                        $css->ColTabla(number_format($DatosItems["IVA"],2,",","."), 1, "C");
                        $css->ColTabla(number_format($DatosItems["Total"],2,",","."), 1, "C");
                        
                        print("<td style='font-size:16px;text-align:center;color:red' title='Borrar'>");   
                            
                            $css->li("", "fa  fa-remove", "", "onclick=EliminarItem(`1`,`$idItem`) style=font-size:16px;cursor:pointer;text-align:center;color:red");
                            $css->Cli();
                        print("</td>");
                    $css->CierraFilaTabla();
                }
                
                
            $css->CerrarTabla();
        break;// fin caso 3
        
        case 4://Dibujo los Totales
            $idCotizacion=$obCon->normalizar($_REQUEST["idCotizacion"]);
            $sql="SELECT SUM(Subtotal) AS Subtotal, SUM(IVA) as IVA, round(SUM(Total)) as Total FROM cot_itemscotizaciones WHERE NumCotizacion = '$idCotizacion'";
            $Consulta=$obCon->Query($sql);
            $Totales=$obCon->FetchAssoc($Consulta);
            
            $Subtotal=$Totales["Subtotal"];
            $IVA=$Totales["IVA"];
            $Total=$Totales["Total"];
            $css->input("hidden", "TxtTotalDocumento", "", "TxtTotalDocumento", "", $Total, "", "", "", "");
            if($Total>0){ //Verifico que hayan productos, servicios o insumos agregados
                
                $css->CrearTabla();
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>TOTALES</strong>", 2,'C');
                    $css->CierraFilaTabla();
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>Subtotal:</strong>", 1,'L');                        
                        $css->ColTabla(number_format($Subtotal), 1,'L');
                    $css->CierraFilaTabla();
                    
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>Impuestos:</strong>", 1,'L');                        
                        $css->ColTabla(number_format($IVA), 1,'L');
                    $css->CierraFilaTabla();
                    
                    $css->FilaTabla(17);
                        $css->ColTabla("<strong>Total:</strong>", 1,'L');                        
                        $css->ColTabla(number_format($Total), 1,'L');
                    $css->CierraFilaTabla();
                
                
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>OPCIONES</strong>", 2,'C');
                    $css->CierraFilaTabla();
                    
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>Anticipo:</strong>", 1,'L');                        
                        print("<td>");
                            $css->input("number", "TxtAnticipo", "form-control", "TxtAnticipo", "Anticipo", 0, "Anticipo", "", "", "", "", "", "");
                        print("</td>");
                    $css->CierraFilaTabla();
                    
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>Fecha del Anticipo:</strong>", 1,'L');                        
                        print("<td>");
                            $css->input("date", "TxtFechaAnticipo", "form-control", "TxtfechaAnticipo", "Anticipo", date("Y-m-d"), "Anticipo", "", "", "", "", "", "style='line-height: 15px;'");
                        print("</td>");
                    $css->CierraFilaTabla();
                    
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>Cuenta Ingreso:</strong>", 1,'L');                        
                        print("<td>");
                            $css->select("CmbCuentaIngreso", "form-control", "CmbCuentaIngreso", "Cuenta PUC del anticipo", "", "", "");
                                
                                $sql="SELECT * FROM subcuentas WHERE PUC LIKE '11%' AND LENGTH(PUC)>4";
                                $Consulta=$obCon->Query($sql);
                                while($DatosPUC=$obCon->FetchAssoc($Consulta)){
                                    $css->option("", "",'' , $DatosPUC["PUC"], "", "", "", "");
                                        print($DatosPUC["PUC"]." ".$DatosPUC["Nombre"]);
                                    $css->Coption();
                                }
            
                                
                                
                                
                            $css->Cselect();
                        print("</td>");
                    $css->CierraFilaTabla();
                    $css->FilaTabla(16);
                        print("<td colspan=2 style='text-align:center'>");
                            $css->CrearBotonEvento("BtnGuardarDocumento", "Guardar", 1, "onclick", "GuardarDocumento()", "naranja", "");
                        print("</td>");
                    $css->CierraFilaTabla();
                $css->CerrarTabla(); 
            }
                   
            
            
        break; // fin caso 4
        
        case 5: 
            $Listado=$obCon->normalizar($_REQUEST["listado"]);
            $idBusqueda=$obCon->normalizar($_REQUEST["CmbBusquedas"]);
            
            if($Listado==1){
                $tab="productosventa";
            }
            if($Listado==2){
                $tab="servicios";
            }
            if($Listado==3){
                $tab="productosalquiler";
            }
            $Datos=$obCon->ValorActual($tab, "PrecioVenta", " idProductosVenta='$idBusqueda'");
            print($Datos["PrecioVenta"]);
            break;//Fin caso 5
        
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>