<?php

session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];

include_once("../clases/Facturacion.class.php");
include_once("../../../constructores/paginas_constructor.php");

if( !empty($_REQUEST["Accion"]) ){
    $css =  new PageConstruct("", "", 1, "", 1, 0);
    $obCon = new Facturacion($idUser);
    
    switch ($_REQUEST["Accion"]) {
                
        case 1://Dibuja los items de una preventa
            $idPreventa=$obCon->normalizar($_REQUEST["idPreventa"]);
            $css->CrearTabla();
                $css->FilaTabla(16);
                    
                    $css->ColTabla("<strong>Nombre</strong>", 1, "C");
                    $css->ColTabla("<strong>Referencia</strong>", 1, "C");
                    $css->ColTabla("<strong>Cantidad</strong>", 1, "C");                    
                    $css->ColTabla("<strong>Valor_Unitario</strong>", 1, "C");                    
                    $css->ColTabla("<strong>Total</strong>", 1, "C");                    
                    $css->ColTabla("<strong>Eliminar</strong>", 1, "C");
                    
                $css->CierraFilaTabla();
                //Dibujo los productos
                $sql="SELECT pre.idPrecotizacion,pre.Cantidad,prod.Nombre,prod.Referencia,pre.ValorAcordado,pre.TotalVenta"
                        . " FROM preventa pre INNER JOIN productosventa prod ON pre.ProductosVenta_idProductosVenta=prod.idProductosVenta"
                        . " WHERE pre.VestasActivas_idVestasActivas='$idPreventa' ORDER BY idPrecotizacion DESC";
                $Consulta=$obCon->Query($sql);
                while ($DatosItems = $obCon->FetchAssoc($Consulta)) {
                    $idItem=$DatosItems["idPrecotizacion"];
                    
                    $css->FilaTabla(16);                        
                        
                        $css->ColTabla($DatosItems["Nombre"], 1, "C");                   
                        
                        $css->ColTabla($DatosItems["Referencia"], 1, "C");
                        print("<td>");
                            print('<div class="input-group input-group-md" style=width:100px>');
                            
                                $css->input("number", "TxtCantidad_$idItem", "form-control", "TxtCantidad_$idItem", "Cantidad", $DatosItems["Cantidad"], "", "off", "", "");
                                print('<span class="input-group-btn">');
                                    print('<button type="button" id="BtnEditarCantidad_'.$idItem.'" class="btn btn-info btn-flat" onclick=EditarItemCantidad('.$idItem.')>E</button>');
                                    
                                print('</span>');
                            print('</div>');
                            
                            
                        print("</td>");
                        
                                              
                        print("<td>");
                            
                            print('<div class="input-group input-group-md">
                                <input type="text" id="TxtValorUnitario_'.$idItem.'" value="'.$DatosItems["ValorAcordado"].'" class="form-control" placeholder="Valor Unitario">
                                <div class="input-group-btn">
                                  <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-expanded="false" >Precio
                                    <span class="fa fa-caret-down"></span></button>
                                    <ul class="dropdown-menu">');
                            
                            print('<li><a href="#" onclick="EditarPrecioLibre(1)" title="Valor Libre">Valor Libre</a></li>');
                            print('<li><a href="#" onclick="EditarPrecioLibre(2)" title="Precio Mayorista">Mayorista</a></li>');            

                            print('</ul></div></div>');
                                

                         print("</td>");
                        
                        
                        $css->ColTabla(number_format($DatosItems["TotalVenta"],2,",","."), 1, "C");
                        
                        print("<td style='font-size:16px;text-align:center;color:red' title='Borrar'>");   
                            
                            $css->li("", "fa  fa-remove", "", "onclick=EliminarItem(`$idItem`) style=font-size:16px;cursor:pointer;text-align:center;color:red");
                            $css->Cli();
                        print("</td>");
                        
                    $css->CierraFilaTabla();
                }
                
                
            $css->CerrarTabla();
        break;// fin caso 1
        
        case 2://Dibujo los Totales
            $idPreventa=$obCon->normalizar($_REQUEST["idPreventa"]);
            
            $sql="SELECT SUM(Subtotal) AS Subtotal, SUM(Impuestos) as IVA, round(SUM(TotalVenta)) as Total FROM preventa WHERE VestasActivas_idVestasActivas = '$idPreventa'";
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
                    
                    $css->FilaTabla(17);
                        $css->ColTabla("<strong>OPCIONES:</strong>", 2,'C');                        
                        
                    $css->CierraFilaTabla();
                    
                                        
                    $css->FilaTabla(16);
                        print("<td colspan=2 style='text-align:center'>");
                            $css->CrearBotonEvento("BtnFacturar", "Facturar", 1, "onclick", "Facturar()", "naranja", "");
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
        
        case 6://Dibuja el formulario para registrar un abono a una cotizacion 
            $idCotizacion=$obCon->normalizar($_REQUEST["idCotizacion"]);  
            
            $sql="SELECT round(SUM(Total)) as Total FROM cot_itemscotizaciones WHERE NumCotizacion = '$idCotizacion'";
            $Consulta=$obCon->Query($sql);
            $Totales=$obCon->FetchAssoc($Consulta);
            
            $TotalCotizacion=$Totales["Total"];
            $css->input("hidden", "TxtTotalDocumento", "", "TxtTotalDocumento", "", $TotalCotizacion, "", "", "", "");
            
            $sql="SELECT round(SUM(Valor)) as Total FROM cotizaciones_anticipos WHERE idCotizacion = '$idCotizacion'";
            $Consulta=$obCon->Query($sql);
            $Totales=$obCon->FetchAssoc($Consulta);
            
            $TotalAnticipos=$Totales["Total"];
            $DatosCotizacion=$obCon->DevuelveValores("cotizacionesv5", "ID", $idCotizacion);
            $idCliente=$DatosCotizacion["Clientes_idClientes"];
            $DatosCliente=$obCon->ValorActual("clientes", "Num_Identificacion", "idClientes='$idCliente'");
            $Parametros=$obCon->DevuelveValores("parametros_contables", "ID", 20);
            $CuentaAnticipos=$Parametros["CuentaPUC"];
            $NIT=$DatosCliente["Num_Identificacion"];
            $sql="SELECT SUM(Debito) as Debito,SUM(Credito) as Credito FROM librodiario WHERE CuentaPUC = '$CuentaAnticipos' AND Tercero_Identificacion='$NIT'";
            $Consulta=$obCon->Query($sql);
            $TotalesLibro=$obCon->FetchAssoc($Consulta);
            $SaldoAnticipos=$TotalesLibro["Credito"]-$TotalesLibro["Debito"];            
            
            $css->input("hidden", "TxtTotalAnticipos", "", "TxtTotalAnticipos", "", $TotalAnticipos, "", "", "", "");            
            
            $css->input("hidden", "idFormulario", "", "idFormulario", "", 1, "", "", "", ""); // 1 sirve para indicarle al sistema que debe guardar un anticipo de cotizacion
            
            $css->div("DivAnticipos", "col-md-6", "", "", "", "", "");
                $sql="SELECT * FROM cotizaciones_anticipos WHERE idCotizacion='$idCotizacion'";
                $Consulta=$obCon->Query($sql);
                $css->CrearTabla();
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>HISTORIAL DE ANTICIPOS A ESTA COTIZACIÓN</strong>", 2,'C');
                    $css->CierraFilaTabla();
                    $css->FilaTabla(14);
                        $css->ColTabla("<strong>FECHA</strong>", 1,'C');
                        $css->ColTabla("<strong>VALOR</strong>", 1,'C');
                    $css->CierraFilaTabla();
                    while($DatosAbonos=$obCon->FetchAssoc($Consulta)){
                        $css->FilaTabla(14);
                            $css->ColTabla($DatosAbonos["Fecha"], 1,'L');
                            $css->ColTabla(number_format($DatosAbonos["Valor"]), 1,'L');
                        $css->CierraFilaTabla();
                    }
                    $css->FilaTabla(14);
                        $css->ColTabla("<strong>Total Cotización:</strong>", 1,'R');
                        $css->ColTabla(number_format($TotalCotizacion), 1,'R');
                    $css->CierraFilaTabla();
                    $css->FilaTabla(14);
                        $css->ColTabla("<strong>Total Anticipos:</strong>", 1,'R');
                        $css->ColTabla(number_format($TotalAnticipos), 1,'R');
                    $css->CierraFilaTabla();
                    $css->FilaTabla(14);
                        $css->ColTabla("<strong>Saldo:</strong>", 1,'R');
                        $css->ColTabla(number_format($TotalCotizacion-$TotalAnticipos), 1,'R');
                    $css->CierraFilaTabla();
                $css->CerrarTabla();
            $css->Cdiv();
            
            $css->div("DivAnticipos", "col-md-6", "", "", "", "", "");
                $css->CrearTabla();

                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>REGISTRAR ANTICIPO</strong>", 2,'C');
                    $css->CierraFilaTabla();

                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>Fecha del Anticipo:</strong>", 1,'L');                        
                        print("<td>");
                            $css->input("date", "TxtFechaAnticipo", "form-control", "TxtFechaAnticipo", "Anticipo", date("Y-m-d"), "Anticipo", "", "", "", "", "", "style='line-height: 15px;'");
                        print("</td>");
                    $css->CierraFilaTabla();

                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>Anticipo:</strong>", 1,'L');                        
                        print("<td>");
                            $css->input("number", "TxtAnticipo", "form-control", "TxtAnticipo", "Anticipo", 0, "Anticipo", "", "", "", "", "", "");
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
                        $css->ColTabla("<strong>Disponible en Anticipos:</strong>", 1,'L');  
                        $css->ColTabla(number_format($SaldoAnticipos), 1,'L');  
                        
                    $css->CierraFilaTabla();

                $css->CerrarTabla();
            $css->Cdiv();        
            print("<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>");
        break;//Fin caso 6
        
        case 7: //Dibujo el formulario para facturar una cotización
            $idCotizacion=$obCon->normalizar($_REQUEST["idCotizacion"]);
            $DatosCotizacion=$obCon->DevuelveValores("cotizacionesv5", "ID", $idCotizacion);
            
            $DatosCliente=$obCon->DevuelveValores("clientes", "idClientes", $DatosCotizacion["Clientes_idClientes"]);
            $NIT=$DatosCliente["Num_Identificacion"];
            $Parametros=$obCon->DevuelveValores("parametros_contables", "ID", 20);//Aqui se encuentra la cuenta para los anticipos
            $CuentaAnticipos=$Parametros["CuentaPUC"];
            $sql="SELECT SUM(Debito) as Debito, SUM(Credito) AS Credito FROM librodiario WHERE CuentaPUC='$CuentaAnticipos' AND Tercero_Identificacion='$NIT'";
            $Consulta=$obCon->Query($sql);
            $DatosAnticipos=$obCon->FetchAssoc($Consulta);
            $SaldoAnticiposTercero=$DatosAnticipos["Credito"]-$DatosAnticipos["Debito"];
            
            $sql="SELECT round(SUM(Total)) as Total FROM cot_itemscotizaciones WHERE NumCotizacion = '$idCotizacion'";
            $Consulta=$obCon->Query($sql);
            $Totales=$obCon->FetchAssoc($Consulta);
            
            $TotalCotizacion=$Totales["Total"];
            $css->input("hidden", "TxtTotalFactura", "", "TxtTotalFactura", "", $TotalCotizacion, "", "", "", ""); 
            $css->input("hidden", "TxtTotalAnticiposFactura", "", "TxtTotalAnticiposFactura", "", $SaldoAnticiposTercero, "", "", "", "");  
            
            $css->input("hidden", "idFormulario", "", "idFormulario", "", 2, "", "", "", ""); // 2 sirve para indicarle al sistema que debe guardar el formulario de crear una factura desde una cotizacion
            
            $css->CrearTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("Facturar Ésta Cotización al Cliente: <strong>$DatosCliente[RazonSocial] $DatosCliente[Num_Identificacion]</strong>", 4);
                $css->CierraFilaTabla();
                
                $css->FilaTabla(14);
                    $css->ColTabla("<strong>Fecha</strong>", 1);
                    $css->ColTabla("<strong>Empresa</strong>", 1);
                    $css->ColTabla("<strong>Centro de Costos</strong>", 1);
                    $css->ColTabla("<strong>Sucursal</strong>", 1);
                    
                $css->CierraFilaTabla();
                
                $css->FilaTabla(14);
                    
                    print("<td>");
                        $css->input("date", "TxtFechaFactura", "form-control", "TxtFechaFactura", "Fecha de la Factura", date("Y-m-d"), "Fecha de la Factura", "", "", "", "", "", "style='line-height: 15px;'");
                    print("</td>");
                    
                    print("<td>");
                        $css->select("CmbEmpresa", "form-control", "CmbEmpresa", "", "", "", "");

                            $sql="SELECT * FROM empresapro";
                            $Consulta=$obCon->Query($sql);
                            while($DatosCentro=$obCon->FetchAssoc($Consulta)){
                                $css->option("", "",'' , $DatosCentro["idEmpresaPro"], "", "", "", "");
                                    print($DatosCentro["idEmpresaPro"]." ".$DatosCentro["RazonSocial"]." ".$DatosCentro["NIT"]." ".$DatosCentro["Ciudad"]);
                                $css->Coption();
                            }


                        $css->Cselect();
                    print("</td>");
                    
                    print("<td>");
                        $css->select("CmbCentroCostosFactura", "form-control", "CmbCentroCostosFactura", "", "", "", "");

                            $sql="SELECT * FROM centrocosto";
                            $Consulta=$obCon->Query($sql);
                            while($DatosCentro=$obCon->FetchAssoc($Consulta)){
                                $css->option("", "",'' , $DatosCentro["ID"], "", "", "", "");
                                    print($DatosCentro["ID"]." ".$DatosCentro["Nombre"]);
                                $css->Coption();
                            }


                        $css->Cselect();
                    print("</td>");
                    print("<td>");
                        $css->select("CmbSucursal", "form-control", "CmbSucursal", "", "", "", "");

                            $sql="SELECT * FROM empresa_pro_sucursales ";
                            $Consulta=$obCon->Query($sql);
                            while($DatosSucursales=$obCon->FetchAssoc($Consulta)){
                                $css->option("", "",'' , $DatosSucursales["ID"], "", "", "", "");
                                    print($DatosSucursales["ID"]." ".$DatosSucursales["Nombre"]);
                                $css->Coption();
                            }


                        $css->Cselect();
                    print("</td>");
                    
                $css->CierraFilaTabla();
                
                $css->FilaTabla(14);
                    $css->ColTabla("<strong>Forma de Pago</strong>", 1);
                    $css->ColTabla("<strong>Resolución</strong>", 1);
                    $css->ColTabla("<strong>Frecuente</strong>", 1);
                    $css->ColTabla("<strong>Cuenta de Ingreso</strong>", 1);
                    
                $css->CierraFilaTabla();
                
                $css->FilaTabla(14);
                    print("<td>");
                        $css->select("CmbFormaPago", "form-control", "CmbFormaPago", "", "", "", "");

                            $sql="SELECT * FROM repuestas_forma_pago";
                            $Consulta=$obCon->Query($sql);
                            while($DatosFormaPago=$obCon->FetchAssoc($Consulta)){
                                $css->option("", "",'' , $DatosFormaPago["DiasCartera"], "", "", "", "");
                                    print($DatosFormaPago["Etiqueta"]);
                                $css->Coption();
                            }


                        $css->Cselect();
                    print("</td>");
                    print("<td>");
                        $css->select("CmbResolucion", "form-control", "CmbResolucion", "", "", "", "");

                            $sql="SELECT * FROM empresapro_resoluciones_facturacion WHERE Completada='NO'";
                            $Consulta=$obCon->Query($sql);
                            while($DatosResolucion=$obCon->FetchAssoc($Consulta)){
                                $css->option("", "",'' , $DatosResolucion["ID"], "", "", "", "");
                                    print($DatosResolucion["ID"]." ".$DatosResolucion["NombreInterno"]);
                                $css->Coption();
                            }


                        $css->Cselect();
                    print("</td>");
                
                     print("<td>");
                        $css->select("CmbFrecuente", "form-control", "CmbFrecuente", "", "", "", "");

                            $css->option("", "",'' ,'NO', "", "", "", "");
                                print('NO');
                            $css->Coption();
                            
                            $css->option("", "",'' ,'SI', "", "", "", "");
                                print('SI');
                            $css->Coption();



                        $css->Cselect();
                    print("</td>");
                    print("<td>");
                        $css->select("CmbCuentaIngresoFactura", "form-control", "CmbCuentaIngresoFactura", "", "", "", "");

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
                
                $css->FilaTabla(14);
                    
                    $css->ColTabla("<strong>Asignar</strong>", 1);
                    $css->ColTabla("<strong>Observaciones</strong>", 1);
                $css->CierraFilaTabla();
                
                $css->FilaTabla(14);
                print("<td>");
                        $css->select("CmbColaboradores", "form-control", "CmbColaboradores", "", "", "", "");

                            $sql="SELECT * FROM colaboradores WHERE Activo='SI'";
                            $Consulta=$obCon->Query($sql);
                                $css->option("", "",'' , '', "", "", "", "");
                                    print("Seleccione un colaborador");
                                $css->Coption();
                            while($DatosColaboradores=$obCon->FetchAssoc($Consulta)){
                                $css->option("", "",'' , $DatosColaboradores["idColaboradores"], "", "", "", "");
                                    print($DatosColaboradores["Nombre"]." ".$DatosColaboradores["Identificacion"]);
                                $css->Coption();
                            }


                        $css->Cselect();
                    print("</td>");
                    print("<td colspan=2>");
                        $css->textarea("TxtObservacionesFactura", "form-control", "TxtObservacionesFactura", "Observaciones", "Observaciones", "", "");
                        $css->Ctextarea();
                    print("</td>"); 
                    
                    print("<td>");
                        print("Éste Cliente cuenta con anticipos por valor de: <strong>". number_format($SaldoAnticiposTercero)."</strong>; Cuanto desea Cruzar en esta factura?:");
                        $css->input("number", "AnticiposCruzados", "form-control", "AnticiposCruzados", "Cruzar Anticipos", 0, "", "", "", "");
                    print("</td>");
                    
                    
                    $css->CierraFilaTabla();
                    
            $css->CerrarTabla();
            
        break;//Fin caso 7
        
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>