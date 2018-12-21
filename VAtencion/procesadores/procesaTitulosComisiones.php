<?php 

$obVenta = new ProcesoVenta($idUser);
        ////Se registra una venta de un titulo
	
	if(!empty($_REQUEST['BtnPagarComision'])){
            
            $IDVenta=$obVenta->normalizar($_REQUEST['TxtIDVenta']);
            $Fecha=$obVenta->normalizar($_REQUEST["TxtFechaPago$IDVenta"]);
            $Pago=$obVenta->normalizar($_REQUEST["TxtPagoComision$IDVenta"]);
            $Observaciones=$obVenta->normalizar($_REQUEST['TxtObservaciones']);
            $CuentaOrigen="110505";      
            $idComprobante=$obVenta->RegistrePagoComisionTitulo($Fecha, $IDVenta, $Pago, $Observaciones, $CuentaOrigen, 1, $idUser, "");
            
            $RutaPrintIngreso="../tcpdf/examples/imprimircomp.php?ImgPrintComp=".$idComprobante;			
            $css->CrearTabla();
            $css->CrearFilaNotificacion("Comprobante de Egreso Creado Correctamente <a href='$RutaPrintIngreso' target='_blank'>Imprimir Comprobante de Egreso No. $idComprobante</a>",16);
            $css->CerrarTabla();
            
        }
        ///////////////Fin
?>