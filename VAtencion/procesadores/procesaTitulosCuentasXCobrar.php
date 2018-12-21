<?php 


        ////Se registra una venta de un titulo
	
	if(!empty($_REQUEST['BtnAbonar'])){
            
            $IDCuenta=$obVenta->normalizar($_REQUEST['TxtIDCuenta']);
            $Fecha=$obVenta->normalizar($_REQUEST["TxtFechaAbono$IDCuenta"]);
            $Abono=$obVenta->normalizar($_REQUEST["TxtAbono$IDCuenta"]);
            $Observaciones=$obVenta->normalizar($_REQUEST['TxtObservaciones']);
            $idColaborador=$obVenta->normalizar($_REQUEST["CmbColaborador$IDCuenta"]);          
            $idComprobante=$obVenta->RegistreAbonoTitulo($Fecha, $IDCuenta, $Abono, $Observaciones,1,$idColaborador,$idUser, "");
            
            $RutaPrintIngreso="../tcpdf/examples/imprimiringreso.php?ImgPrintIngreso=".$idComprobante;			
            $css->CrearTabla();
            $css->CrearFilaNotificacion("Comprobante de Ingreso Creado Correctamente <a href='$RutaPrintIngreso' target='_blank'>Imprimir Comprobante de Ingreso No. $idComprobante</a>",16);
            $css->CerrarTabla();
            
        }
        ///////////////Fin
?>