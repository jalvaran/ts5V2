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
                $sql="SELECT * FROM preventa WHERE VestasActivas_idVestasActivas='$idPreventa' ORDER BY idPrecotizacion DESC";
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
                            
                            print('<li><a href="#" onclick="EditarPrecioVenta(`'.$idItem.'`,`0`)" title="Valor Libre">Valor Libre</a></li>');
                            print('<li><a href="#" onclick="EditarPrecioVenta(`'.$idItem.'`,`1`)" title="Precio Mayorista">Mayorista</a></li>');            

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
            
            $sql="SELECT SUM(Cantidad) as TotalItems,SUM(Subtotal) AS Subtotal, SUM(Impuestos) as IVA, round(SUM(TotalVenta)) as Total FROM preventa WHERE VestasActivas_idVestasActivas = '$idPreventa'";
            $Consulta=$obCon->Query($sql);
            $Totales=$obCon->FetchAssoc($Consulta);
            
            $Subtotal=$Totales["Subtotal"];
            $IVA=$Totales["IVA"];
            $Total=$Totales["Total"];
            
            $sql="SELECT Devuelve FROM facturas WHERE Usuarios_idUsuarios='$idUser' ORDER BY idFacturas DESC LIMIT 1";
            $consulta=$obCon->Query($sql);
            $DatosDevuelta=$obCon->FetchArray($consulta);
    
            //$css->input("hidden", "TxtTotalDocumento", "", "TxtTotalDocumento", "", $Total, "", "", "", "");
           
                
                $css->CrearTabla();
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>TOTALES</strong>", 2,'C');
                    $css->CierraFilaTabla();
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>Última Devuelta:</strong>", 1,'L'); 
                        $css->ColTabla(number_format($DatosDevuelta["Devuelve"]), 1,'R'); 
                    $css->CierraFilaTabla();
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>Items:</strong>", 1,'L'); 
                        $css->ColTabla(($Totales["TotalItems"]), 1,'R');
                    $css->CierraFilaTabla();
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>Subtotal:</strong>", 1,'L'); 
                        $css->ColTabla(number_format($Subtotal), 1,'R');  
                    $css->CierraFilaTabla();
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>Impuestos:</strong>", 1,'L');
                        $css->ColTabla(number_format($IVA), 1,'R');
                    $css->CierraFilaTabla();
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>Total:</strong>", 1,'L');
                        $css->ColTabla(number_format($Total), 1,'R');
                    $css->CierraFilaTabla();
                    
                    
                                        
                    $css->FilaTabla(16);
                        print("<td colspan=3 style='text-align:center'>");
                            $habilitaBotones=0;
                             if($Total>0){ //Verifico que hayan productos, servicios o insumos agregados
                                 $habilitaBotones=1;
                             }
                             $css->CrearBotonEvento("BtnFacturar", "Facturar", $habilitaBotones, "onclick", "AbrirModalFacturarPOS()", "naranja", "");
                            
                            print("<br><br>");
                            $css->CrearBotonEvento("BtnCotizar", "Cotizar", $habilitaBotones, "onclick", "CotizarPOS()", "verde", "");
                        print("</td>");
                    $css->CierraFilaTabla();
                $css->CerrarTabla(); 
            
                   
            
            
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
        
        case 6: //Dibujo el formulario para facturar 
            $idPreventa=$obCon->normalizar($_REQUEST["idPreventa"]);
            $idCliente=$obCon->normalizar($_REQUEST["idCliente"]);
            
            $DatosCliente=$obCon->DevuelveValores("clientes", "idClientes", $idCliente);
            $NIT=$DatosCliente["Num_Identificacion"];
            $Parametros=$obCon->DevuelveValores("parametros_contables", "ID", 20);//Aqui se encuentra la cuenta para los anticipos
            $CuentaAnticipos=$Parametros["CuentaPUC"];
            $sql="SELECT SUM(Debito) as Debito, SUM(Credito) AS Credito FROM librodiario WHERE CuentaPUC='$CuentaAnticipos' AND Tercero_Identificacion='$NIT'";
            $Consulta=$obCon->Query($sql);
            $DatosAnticipos=$obCon->FetchAssoc($Consulta);
            $SaldoAnticiposTercero=$DatosAnticipos["Credito"]-$DatosAnticipos["Debito"];
            
            $sql="SELECT round(SUM(TotalVenta)) as Total FROM preventa WHERE VestasActivas_idVestasActivas = '$idPreventa'";
            $Consulta=$obCon->Query($sql);
            $Totales=$obCon->FetchAssoc($Consulta);
            
            $TotalFactura=$Totales["Total"];
            $css->input("hidden", "TxtTotalFactura", "", "TxtTotalFactura", "", $TotalFactura, "", "", "", ""); 
            $css->input("hidden", "TxtTotalAnticiposFactura", "", "TxtTotalAnticiposFactura", "", $SaldoAnticiposTercero, "", "", "", "");  
            
            $css->input("hidden", "idFormulario", "", "idFormulario", "", 1, "", "", "", ""); //1 sirve para indicarle al sistema que debe guardar el formulario de crear una factura
            
            $css->CrearTabla();
                $css->FilaTabla(22);
                    $css->ColTabla("Facturar Esta preventa al Cliente: $DatosCliente[RazonSocial] $DatosCliente[Num_Identificacion], por un total de:<strong> ". number_format($TotalFactura)."</strong>", 5);
                $css->CierraFilaTabla();
                
                
                $css->FilaTabla(14);
                    
                    $css->ColTabla("<strong>Efectivo</strong>", 1);
                    $css->ColTabla("<strong>Tarjetas</strong>", 1);
                    $css->ColTabla("<strong>Cheques</strong>", 1);
                    $css->ColTabla("<strong>Otros</strong>", 1);
                    $css->ColTabla("<strong>Devolver</strong>", 1);
                    
                $css->CierraFilaTabla();
                
                $css->FilaTabla(14);
                    
                    print("<td >");
                        
                        $css->input("number", "Efectivo", "form-control input-lg", "Efectivo", "Efectivo", $TotalFactura, "Efectivo", "off", "", "onKeyUp=CalculeDevuelta()");
                    print("</td>");
                    print("<td >");
                        
                        $css->input("number", "Tarjetas", "form-control input-lg", "Tarjetas", "Tarjetas", 0, "Tarjetas", "off", "", "onKeyUp=CalculeDevuelta()");
                    print("</td>");
                    print("<td>");
                        
                        $css->input("number", "Cheque", "form-control input-lg", "Cheque", "Cheque", 0, "Cheque", "off", "", "onKeyUp=CalculeDevuelta()");
                    print("</td>");
                    print("<td >");
                        
                        $css->input("number", "Otros", "form-control input-lg", "Otros", "Otros", 0, "Otros", "off", "", "onKeyUp=CalculeDevuelta()");
                    print("</td>");
                   
                    print("<td >");                        
                        $css->input("number", "Devuelta", "form-control input-lg", "Devuelta", "Devuelta", 0, "Efectivo", "off", "", " disabled");
                    print("</td>");
                    
                
                $css->FilaTabla(14);
                    $css->ColTabla("<strong>Forma de Pago</strong>", 1);
                    $css->ColTabla("<strong>Asignar</strong>", 1);
                    $css->ColTabla("<strong>Imprimir</strong>", 1);
                    $css->ColTabla("<strong>Observaciones</strong>", 1);
                    $css->ColTabla("<strong>Anticipos del Cliente: $".number_format($SaldoAnticiposTercero)."</strong>", 1);
                $css->CierraFilaTabla();
                
                $css->FilaTabla(14);
                print("<td>");
                        $css->select("CmbFormaPago", "form-control", "CmbFormaPago", "", "", "", "");

                            $sql="SELECT * FROM repuestas_forma_pago";
                            $Consulta=$obCon->Query($sql);
                            if($idCliente==1){
                                $css->option("", "",'' , "Contado", "", "", "", "");
                                    print("Contado");
                                $css->Coption();
                            }
                            while($DatosFormaPago=$obCon->FetchAssoc($Consulta)){
                                if($idCliente<>1){
                                    $css->option("", "",'' , $DatosFormaPago["DiasCartera"], "", "", "", "");
                                        print($DatosFormaPago["Etiqueta"]);
                                    $css->Coption();
                                }
                            }


                        $css->Cselect();
                    print("</td>");
                    
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
                    
                    print("<td>");
                        $DatosImpresion=$obCon->DevuelveValores("configuracion_general", "ID", 2);  //aqui está almaceda la info para saber si debe imprimir o no el tikete por defecto
                        $Imprime=$DatosImpresion["Valor"];
                        $css->select("CmbPrint", "form-control", "CmbPrint", "", "", "", "");
                            $Defecto=0;
                            if($Imprime==1){
                                $Defecto=1;
                            }
                            
                            $css->option("", "",'' , 'SI', "", "", $Defecto, "");
                                print("SI");
                            $css->Coption();
                            $Defecto=0;
                            if($Imprime==0){
                                $Defecto=1;
                            }
                            $css->option("", "",'' , 'NO', "", "", $Defecto, "");
                                print("NO");
                            $css->Coption();
                            
                            
                        $css->Cselect();
                    print("</td>");
                    
                    print("<td>");
                        $css->textarea("TxtObservacionesFactura", "form-control", "TxtObservacionesFactura", "Observaciones", "Observaciones", "", "");
                        $css->Ctextarea();
                    print("</td>"); 
                    
                    print("<td>");
                        
                        $css->input("number", "AnticiposCruzados", "form-control input-lg", "AnticiposCruzados", "Cruzar Anticipos", 0, "", "", "", "");
                    print("</td>");
                    
                    
                    $css->CierraFilaTabla();
                    
            $css->CerrarTabla();
            
        break;//Fin caso 6
        
        
        
        
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>