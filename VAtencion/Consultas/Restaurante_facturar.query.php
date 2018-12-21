<?php
include_once("../../modelo/php_conexion.php");
include_once("../css_construct.php");
include_once("../clases/Restaurante.class.php");
session_start();
$idUser=$_SESSION['idUser'];
$css =  new CssIni("",0);

$obRest=new Restaurante($idUser);

if(isset($_REQUEST["idPedido"])){
    $ConsultaCajas=$obRest->ConsultarTabla("cajas", "WHERE idUsuario='$idUser' AND Estado='ABIERTA'");
        $DatosCaja=$obRest->FetchArray($ConsultaCajas);

        if($DatosCaja["ID"]<=0){
           $css->CrearNotificacionRoja("No tiene asignada una Caja, por favor Asignese a una Caja, <a href='HabilitarUser.php' target='_blank'>Vamos</a>", 16);
           exit();
        }  
        
    //Tipo pedido AB= pedidos abiertos, DO=Domicilios abieros, LL=para llevar Abiertos
    $idPedido=$obRest->normalizar($_REQUEST["idPedido"]);
    $sql="SELECT SUM(Subtotal) as Subtotal,SUM(IVA) AS IVA, SUM(Total) AS Total FROM restaurante_pedidos_items WHERE idPedido='$idPedido'";
    $Datos=$obRest->Query($sql);
    $Totales=$obRest->FetchAssoc($Datos);
    $css->CrearTabla();
        $css->FilaTabla(16);
            $css->ColTabla("<strong>Facturar Pedido $idPedido</strong>", 3);
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
            $css->ColTabla("<strong>Subtotal</strong>", 1);
            $css->ColTabla("<strong>Impuestos</strong>", 1);
            $css->ColTabla("<strong>Total</strong>", 1);
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
            $css->ColTabla(number_format($Totales["Subtotal"]), 1);
            $css->ColTabla(number_format($Totales["IVA"]), 1);
            $css->ColTabla(number_format($Totales["Total"]), 1);
        $css->CierraFilaTabla();
        
        
        $css->FilaTabla(16);
            print("<td colspan=3 style='text-align:center'>");
                $css->ImageOcultarMostrar("ImgOcultar", "", "DivOpcionesPago", 40, 40, "");
                $css->CrearDiv("DivOpcionesPago", "", "center", 0, 1);
                    $css->CrearSelect("idCliente", "");
                        $css->CrearOptionSelect(1, "Clientes Varios", 1);
                    $css->CerrarSelect();
                    //$css->CrearTableChosen("idCliente", "clientes", "", "RazonSocial", "Num_Identificacion", "Telefono", "idClientes", 200, 0, "Clientes", "Clientes<br>");
                    print("<br>");
                    $css->CrearInputNumber("TxtTarjetas", "number", "Tarjetas:<br>", 0, "Tarjetas", "", "onKeyUp", "CalculeDevueltaRestaurante($Totales[Total])", 200, 30, 0, 0, 0, "", 1);
                    print("<br>");
                    $css->CrearInputNumber("TxtCheques", "number", "Cheques:<br>", 0, "Tarjetas", "", "onKeyUp", "CalculeDevueltaRestaurante($Totales[Total])", 200, 30, 0, 0, 0, "", 1);
                    print("<br>");
                    $css->CrearInputNumber("TxtBonos", "number", "Bonos:<br>", 0, "Tarjetas", "", "onKeyUp", "CalculeDevueltaRestaurante($Totales[Total])", 200, 30, 0, 0, 0, "", 1);
                    print("<br><strong>Tipo de Factura:</strong><br>");
                    $css->CrearSelect("CmbTipoPago","");
                        $consulta=$obRest->ConsultarTabla("facturas_tipo_pago", "");
                        while ($DatosTipoPago=$obRest->FetchArray($consulta)){
                            $sel=0;
                            if($DatosTipoPago["TipoPago"]=="Contado"){
                                $sel=1;
                            }
                            $css->CrearOptionSelect($DatosTipoPago["TipoPago"], $DatosTipoPago["Leyenda"], $sel);
                        }
                    $css->CerrarSelect();
                    print("<br><strong>Asignar a:</strong><br>");
                    $css->CrearSelect("CmbColaboradores","");
                        $css->CrearOptionSelect("", "Colaborador", 0);
                        $consulta=$obRest->ConsultarTabla("colaboradores", " WHERE Activo='A'");
                        while ($DatosTipoPago=$obRest->FetchArray($consulta)){
                            $css->CrearOptionSelect($DatosTipoPago["idColaboradores"], $DatosTipoPago["Nombre"], 0);
                        }
                    $css->CerrarSelect();
                    
                    print("<br>");
                    $css->CrearInputNumber("TxtPropinaEfectivo", "number", "Propina Efectivo:<br>", 0, "P Efectivo", "", "onKeyUp", "CalculeDevueltaRestaurante($Totales[Total])", 200, 30, 0, 0, 0, "", 1);
                    print("<br>");
                    $css->CrearInputNumber("TxtPropinaTarjetas", "number", "Propina Tarjetas:<br>", 0, "P Tarjeta", "", "onKeyUp", "CalculeDevueltaRestaurante($Totales[Total])", 200, 30, 0, 0, 0, "", 1);
                    print("<br>");
                    $css->CrearTextArea("TxtObservacionesFactura", "", "", "Observaciones", "", "", "", 200, 50, 0, 0);
                $css->CerrarDiv();
            print("</td>");
        $css->CierraFilaTabla();      
        $css->FilaTabla(16);
            print("<td colspan=3 style='text-align:center'>");
                $css->CrearInputNumber("TxtEfectivo", "number", "",$Totales["Total"] , "Efectivo", "", "onKeyUp", "CalculeDevueltaRestaurante($Totales[Total])", 200, 60, 0, 1, 1, "", 1,"font-size:2em;");
                $css->CrearInputNumber("GranTotalPropinas", "hidden", "",0 , "Efectivo", "", "onKeyUp", "CalculeDevueltaRestaurante($Totales[Total])", 200, 60, 0, 1, 1, "", 1,"font-size:2em;");
            
            print("</td>");
        $css->CierraFilaTabla();   
        
                
        $css->FilaTabla(16);
            print("<td colspan=3 style='text-align:center'>");
                $css->CrearInputNumber("TxtDevuelta", "number", "",0 , "Devuelta", "", "", "", 200, 60, 0, 1, 1, "", 1,"font-size:2em;");
            print("</td>");
        $css->CierraFilaTabla();  
        $css->FilaTabla(16); 
        
            print("<td colspan=3 style='text-align:center'>");
                $evento="onClick";
                $funcion="FacturarPedido($idPedido);";

                $css->CrearBotonEvento("BtnFacturarPedido", "Facturar", 1, $evento, $funcion, "naranja", "");
        print("</td>");
        $css->CierraFilaTabla();  
    $css->CerrarTabla();
}else{
    print("No se recibieron parametros");
}

?>