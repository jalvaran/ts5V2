<?php
/* 
 * Clase donde se realizaran procesos de compras u otros modulos.
 * Julian Alvaran
 * Techno Soluciones SAS
 */
//include_once 'php_conexion.php';
class PrintPos extends ProcesoVenta{
    public function EncabezadoComprobantesPos($handle,$Fecha, $idEmpresa){
        $DatosEmpresa=$this->DevuelveValores("empresapro", "idEmpresaPro", $idEmpresa);
        $RazonSocial=$DatosEmpresa["RazonSocial"];
        $NIT=$DatosEmpresa["NIT"];
        $Direccion=$DatosEmpresa["Direccion"];
        $Ciudad=$DatosEmpresa["Ciudad"];
        $Telefono=$DatosEmpresa["Telefono"];
        fwrite($handle,chr(27). chr(64));//REINICIO
        //fwrite($handle, chr(27). chr(112). chr(48));//ABRIR EL CAJON
        fwrite($handle, chr(27). chr(100). chr(0));// SALTO DE CARRO VACIO
        fwrite($handle, chr(27). chr(33). chr(8));// NEGRITA
        fwrite($handle, chr(27). chr(97). chr(1));// CENTRADO
        $this->SeparadorHorizontal($handle,"*", 37);
        fwrite($handle,$RazonSocial); // ESCRIBO RAZON SOCIAL
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$NIT);
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$Direccion);
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$Ciudad);
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$Telefono);
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
    }
    
    public function Footer($handle){
        
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        //fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle, chr(27). chr(97). chr(1));// CENTRO

       // fwrite($handle, chr(27). chr(100). chr(1));//salto de linea

        //fwrite($handle, chr(27). chr(100). chr(1));
        fwrite($handle, chr(27). chr(100). chr(1));
        fwrite($handle,"***Documento impreso por TS5***");
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"Techno Soluciones SAS, 3177740609");
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"www.technosoluciones.com.co");
        //fwrite($handle,"=================================");
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle, chr(27). chr(100). chr(1));
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle, chr(27). chr(100). chr(1));
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle, chr(27). chr(100). chr(1));
        fwrite($handle, chr(29). chr(86). chr(49));//CORTA PAPEL
        
    }
    
    //Separador Horizontal
    public function SeparadorHorizontal($handle,$Caracter,$Cantidad){
        
        //fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        $Line=str_pad($Caracter,  $Cantidad, $Caracter);
        fwrite($handle,$Line); //
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
    }
     
    //Comprobante fiscal de Cierre Diario
    public function ImprimeComprobanteInformeDiario($COMPrinter,$FechaInicial,$FechaFinal) {
        $COMPrinter= $this->COMPrinter;    
        if(($handle = @fopen("$COMPrinter", "w")) === FALSE){
            die('ERROR:\nNo se puedo Imprimir, Verifique la conexion de la IMPRESORA');
        }
        
        $Condicion=" WHERE Fecha BETWEEN  '$FechaInicial' AND '$FechaFinal'";
            
       $sql="SELECT * FROM cajas_aperturas_cierres $Condicion";
       $Consulta=$this->Query($sql);
       
       while($DatosCierre=$this->FetchArray($Consulta)){
            $DatosUsuario=$this->DevuelveValores("usuarios", "idUsuarios", $DatosCierre["Usuario"]);
            $idUsuario=$DatosCierre["Usuario"];
            $this->EncabezadoComprobantesPos($handle, $DatosCierre["Fecha"], 1);
            fwrite($handle,"Cajero:.$DatosUsuario[Nombre] $DatosUsuario[Apellido]");
            $this->SeparadorHorizontal($handle,"*", 37);

            /////////////////////////////Datos del Cierre

            fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
            fwrite($handle, chr(27). chr(97). chr(0));// IZQUIERDA
            fwrite($handle,"FECHA: $DatosCierre[Fecha]          HORA: $DatosCierre[Hora]");
            fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
            fwrite($handle,"COMPROBANTE DE INFORME DIARIO: $DatosCierre[ID]");
            fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
            $idCierre=$DatosCierre["ID"];
            $sql="SELECT idResolucion,MIN(NumeroFactura) AS MinFact, MAX(NumeroFactura) AS MaxFact FROM facturas WHERE CerradoDiario='$idCierre'";
            $Datos=$this->Query($sql);
            $DatosFacturas=$this->FetchArray($Datos);
            $DatosResolucion=$this->DevuelveValores("empresapro_resoluciones_facturacion", "ID", $DatosFacturas["idResolucion"]);
            fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
            fwrite($handle,"RESOLUCION DIAN: ".$DatosResolucion["NumResolucion"]." DEL ".$DatosResolucion["Fecha"]);
            fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
            fwrite($handle,"HABILITA DESDE: ".$DatosResolucion["Prefijo"]." ".$DatosResolucion["Desde"]." HASTA ".$DatosResolucion["Prefijo"]." ".$DatosResolucion["Hasta"]);
            $this->SeparadorHorizontal($handle, "_", 37);
            fwrite($handle,"Fact. Inicial: ".$DatosFacturas["MinFact"]);
            fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
            fwrite($handle,"Fact. Final:   ".$DatosFacturas["MaxFact"]);
            fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
            fwrite($handle,"Numero Facts:  ".($DatosFacturas["MaxFact"]-$DatosFacturas["MinFact"]+1));
            fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
            
            fwrite($handle,"VENTAS DISCRIMINADAS POR DEPARTAMENTO:");
            fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
            
            $CondicionItems=" ori_facturas_items WHERE FechaFactura BETWEEN '$FechaInicial' AND '$FechaFinal' AND idUsuarios='$idUsuario'";
            $sql="SELECT Departamento as idDepartamento, `PorcentajeIVA`,sum(`TotalItem`) as Total, sum(`IVAItem`) as IVA, sum(`SubtotalItem`) as Subtotal, SUM(Cantidad) as Items"
            . "  FROM $CondicionItems GROUP BY `Departamento`,`PorcentajeIVA`";
            
            $ConsultaItems= $this->Query($sql);
            $GranSubtotal=0;
            $GranIVA=0;
            $GranTotal=0;
            
            while($DatosVentas= $this->FetchArray($ConsultaItems)){
                if(round($DatosVentas["Total"],-2)>0){
                    $this->SeparadorHorizontal($handle, "_", 37);
                    $TipoIva=$DatosVentas["PorcentajeIVA"];
                    $PIVA= str_replace("%", "", $TipoIva);
                    $PIVA=$PIVA/100;
                    $Total=round($DatosVentas["Total"],-2);
                    $Subtotal=$Total/(1+$PIVA);
                    $IVA=$Total-$Subtotal;
                    $GranSubtotal=$GranSubtotal+$Subtotal;
                    $GranIVA=$GranIVA+$IVA;
                    $GranTotal=$GranTotal+$Total;
                    $DatosDepartamentos=$this->DevuelveValores("prod_departamentos", "idDepartamentos", $DatosVentas["idDepartamento"]);
                    fwrite($handle,$DatosDepartamentos["Nombre"]." ".$DatosVentas["PorcentajeIVA"]);
                    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
                    fwrite($handle,"BASE:             ".number_format($Subtotal));
                    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
                    fwrite($handle,"IVA:              ".number_format($IVA));
                    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
                    fwrite($handle,"TOTAL:            ".number_format($Total));
                    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
                }
            }
            $this->SeparadorHorizontal($handle, "_", 37);
            $this->SeparadorHorizontal($handle, "_", 37);
            $sql="SELECT SUM(ValorOtrosImpuestos) AS Impoconsumo FROM facturas_items WHERE idCierre='$idCierre'";
            $ConsultaOtros= $this->Query($sql);
            $DatosOtrosImpuestos=$this->FetchArray($ConsultaOtros);
            fwrite($handle,"       TOTALES          ");
            fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
            fwrite($handle,"BASE:             ".number_format($GranSubtotal));
            fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
            fwrite($handle,"IVA:              ".number_format($GranIVA));
            fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
            fwrite($handle,"IMPOCONSUMO:      ".number_format($DatosOtrosImpuestos["Impoconsumo"]));
            fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
            $GranTotal=$GranTotal+$DatosOtrosImpuestos["Impoconsumo"];
            fwrite($handle,"TOTAL:            ".number_format($GranTotal));
            
            $sql="SELECT SUM(Tarjetas) AS Tarjetas FROM facturas WHERE 	CerradoDiario='$idCierre'";
            $ConsultaTarjetas= $this->Query($sql);
            $DatosTarjetas=$this->FetchArray($ConsultaTarjetas);
            $this->SeparadorHorizontal($handle, "_", 37);
            fwrite($handle,"       FORMAS DE PAGO          ");
            fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
            fwrite($handle,"EFECTIVO:            ".number_format($GranTotal-$DatosTarjetas["Tarjetas"]));
            fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
            fwrite($handle,"TARJETAS:            ".number_format($DatosTarjetas["Tarjetas"]));
                          
            $this->Footer($handle);
            
       }     
       
       fclose($handle); // cierra el fichero PRN
       $salida = shell_exec('lpr $COMPrinter');
    }
    
    //Imprime Factura
    
    /*
     * Imprime una factura pos
     */
    public function ImprimeFacturaPOS($idFactura,$COMPrinter,$Copias,$AbreCajon=1){
        $COMPrinter= $this->COMPrinter;
        $DatosImpresora=$this->DevuelveValores("config_puertos", "ID", 1);   
        if($DatosImpresora["Habilitado"]<>"SI"){
            return;
        }
        if(($handle = @fopen("$COMPrinter", "w")) === FALSE){
            die('ERROR:\nNo se puedo Imprimir, Verifique la conexion de la IMPRESORA');
        }
        $AnchoSeparador=44;
        $AnchoItems=28;
        $idFormatoCalidad=2;
        $DatosFormato= $this->DevuelveValores("formatos_calidad", "ID", $idFormatoCalidad);
        $DatosFactura=$this->DevuelveValores("facturas", "idFacturas", $idFactura);
        $DatosEmpresa=$this->DevuelveValores("empresapro", "idEmpresaPro", $DatosFactura["EmpresaPro_idEmpresaPro"]);
        $DatosResolucion=$this->DevuelveValores("empresapro_resoluciones_facturacion", "ID", $DatosFactura["idResolucion"]);
        $idUsuario=$DatosFactura["Usuarios_idUsuarios"];
        $DatosUsuario=$this->ValorActual("usuarios", " Nombre , Apellido ", " idUsuarios='$idUsuario'");
        
        $DatosCliente=$this->DevuelveValores("clientes", "idClientes", $DatosFactura["Clientes_idClientes"]);
        $RazonSocial=$DatosEmpresa["RazonSocial"];
        $NIT=$DatosEmpresa["NIT"];
        $Direccion=$DatosEmpresa["Direccion"];
        $Ciudad=$DatosEmpresa["Ciudad"];
        $Regimen=$DatosEmpresa["Regimen"];
        $ResolucionDian1="RES DIAN: $DatosResolucion[NumResolucion] del $DatosResolucion[Fecha]";
        $ResolucionDian2="FACTURA AUT. $DatosResolucion[Prefijo] - $DatosResolucion[Desde] HASTA $DatosResolucion[Prefijo] - $DatosResolucion[Hasta]";
        $ResolucionDian3="Autoriza impresion en:  $DatosResolucion[Factura]";
        $Telefono=$DatosEmpresa["Telefono"];
        $ImpuestosP[]="";
        $impuesto=$DatosFactura["IVA"];
        $Descuento=$DatosFactura["Descuentos"];
        $TotalVenta=$DatosFactura["Total"];
        $Subtotal=$DatosFactura["Subtotal"];
        $TotalFinal=$DatosFactura["Total"];
        

        $Fecha=$DatosFactura["Fecha"];
        $Hora=$DatosFactura["Hora"];
        $NumFact=$DatosFactura["Prefijo"]." - ".$DatosFactura["NumeroFactura"];
        for($i=1; $i<=$Copias;$i++){
        fwrite($handle,chr(27). chr(64));//REINICIO
        if($AbreCajon==1){
            fwrite($handle, chr(27). chr(112). chr(48));//ABRIR EL CAJON
        }
        
        fwrite($handle, chr(27). chr(100). chr(0));// SALTO DE CARRO VACIO
        fwrite($handle, chr(27). chr(33). chr(8));// NEGRITA
        fwrite($handle, chr(27). chr(97). chr(1));// CENTRADO
        $this->SeparadorHorizontal($handle, "*", 36);
        fwrite($handle,$RazonSocial); // ESCRIBO RAZON SOCIAL
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        $InfoRegimen="REGIMEN SIMPLIFICADO";
        if($Regimen<>"SIMPLIFICADO"){
            $InfoRegimen="IVA REGIMEN COMUN";
        }
        fwrite($handle,"NIT: ".$NIT." ".$InfoRegimen);
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
		if($Regimen<>"SIMPLIFICADO"){
        fwrite($handle,$ResolucionDian1);
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$ResolucionDian2);
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$ResolucionDian3);
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
		}
        fwrite($handle,$Direccion." ".$Ciudad);
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        
        fwrite($handle,"TEL: ".$Telefono);
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA

        fwrite($handle,"Cajero:.$DatosUsuario[Nombre] $DatosUsuario[Apellido]");
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        $this->SeparadorHorizontal($handle, "*", 36);
        fwrite($handle,"Cliente: $DatosCliente[RazonSocial]");
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,"NIT: $DatosCliente[Num_Identificacion]");
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        $this->SeparadorHorizontal($handle, "*", 36);
        /////////////////////////////FECHA Y NUM FACTURA

        fwrite($handle, chr(27). chr(97). chr(0));// IZQUIERDA
        fwrite($handle,"FECHA: $Fecha      HORA: $Hora");
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"$DatosFormato[Nombre] No $NumFact");
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"TIPO DE FACTURA: $DatosFactura[FormaPago]");
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        $this->SeparadorHorizontal($handle, "_", $AnchoSeparador);

        /////////////////////////////ITEMS VENDIDOS

        fwrite($handle, chr(27). chr(97). chr(0));// IZQUIERDA

        $sql = "SELECT * FROM facturas_items WHERE idFactura='$idFactura'";
	
        $consulta=$this->Query($sql);
		$i=0;						
	while($DatosVenta=$this->FetchArray($consulta)){
		$i++;
            
            $SubTotalITem=$DatosVenta["TotalItem"];
            
            fwrite($handle,str_pad($DatosVenta["Cantidad"],4," ",STR_PAD_RIGHT));

            fwrite($handle,str_pad(substr($DatosVenta["Referencia"]." ".$DatosVenta["Nombre"],0,$AnchoItems),$AnchoItems," ",STR_PAD_BOTH)."   ");

            fwrite($handle,str_pad("$".number_format($SubTotalITem),10," ",STR_PAD_LEFT));

            fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        }




    /////////////////////////////TOTALES

    $this->SeparadorHorizontal($handle, "_", $AnchoSeparador);
    fwrite($handle, chr(27). chr(97). chr(0));// IZQUIERDA
    if($Regimen<>"SIMPLIFICADO"){
        $sql="SELECT sum(SubtotalItem) as Subtotal, sum(ValorOtrosImpuestos) as OtrosImpuestos,sum(IVAItem) as IVA,sum(TotalItem) as TotalItem, PorcentajeIVA FROM facturas_items WHERE idFactura = '$idFactura' GROUP BY PorcentajeIVA";
	$Consulta=$this->Query($sql);
	while($DatosTotales=$this->FetchArray($Consulta)){
            $TotalVenta=$DatosTotales["Subtotal"]+$DatosTotales["IVA"]+$DatosTotales["OtrosImpuestos"];
                fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
                fwrite($handle,"Base del $DatosTotales[PorcentajeIVA]      ".str_pad("$".number_format($DatosTotales["Subtotal"],2),20," ",STR_PAD_LEFT));
                fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
                if($DatosTotales["PorcentajeIVA"]=='8%'){
                    fwrite($handle,"Impoconsumo     ".str_pad("$".number_format($DatosTotales["IVA"],2),20," ",STR_PAD_LEFT));
                
                }else{
                    fwrite($handle,"Impuesto $DatosTotales[PorcentajeIVA]     ".str_pad("$".number_format($DatosTotales["IVA"],2),20," ",STR_PAD_LEFT));
                
                }
                if($DatosTotales["OtrosImpuestos"]>0){
                    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
                    fwrite($handle,"Impoconsumo      ".str_pad("$".number_format($DatosTotales["OtrosImpuestos"]),20," ",STR_PAD_LEFT));
                  
                }
           
        }

       
    }
    $Total=$this->Sume("facturas_items", "TotalItem", " WHERE idFactura='$idFactura'");
    $Bolsa=$this->Sume("facturas_items", "ValorOtrosImpuestos", " WHERE idFactura='$idFactura'");
    
	fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"TOTAL                    ".str_pad("$".number_format($Total+$Bolsa),20," ",STR_PAD_LEFT));
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
	
    $DatosPropinas=$this->DevuelveValores("restaurante_registro_propinas", "idFactura", $idFactura);
    $TotalPropina=$DatosPropinas["Efectivo"]+$DatosPropinas["Tarjetas"];
    if($TotalPropina>0){
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"PROPINA            ".str_pad("$".number_format($TotalPropina),20," ",STR_PAD_LEFT));
		fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
		fwrite($handle,"TOTAL + PROPINA    ".str_pad("$".number_format($Total+$Bolsa+$TotalPropina),20," ",STR_PAD_LEFT));
		fwrite($handle, chr(27). chr(100). chr(1));//salto de linea

    }
    
    $this->SeparadorHorizontal($handle, "_", $AnchoSeparador);

    /////////////////////////////Forma de PAGO

    $this->SeparadorHorizontal($handle, "_", $AnchoSeparador);
    fwrite($handle, chr(27). chr(97). chr(0));// IZQUIERDA

    fwrite($handle,"Formas de Pago");
    if($DatosFactura["Efectivo"]>0){
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"       Efectivo ----> $".str_pad(number_format($DatosFactura["Efectivo"]),10," ",STR_PAD_LEFT));
    }
    if($DatosFactura["Tarjetas"]>0){
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"       Tarjetas ----> $".str_pad(number_format($DatosFactura["Tarjetas"]),10," ",STR_PAD_LEFT));
    }
    if($DatosFactura["Cheques"]>0){
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"       Cheques  ----> $".str_pad(number_format($DatosFactura["Cheques"]),10," ",STR_PAD_LEFT));
    }
    if($DatosFactura["Otros"]>0){
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"       Otros    ----> $".str_pad(number_format($DatosFactura["Otros"]),10," ",STR_PAD_LEFT));
    }
    if($DatosFactura["Devuelve"]>0){
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"       Cambio   ----> $".str_pad(number_format($DatosFactura["Devuelve"]),10," ",STR_PAD_LEFT));
    }
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea

    $this->SeparadorHorizontal($handle, "_", $AnchoSeparador);
    //Se mira si hay observaciones
    if($DatosFactura["ObservacionesFact"]<>""){
        /////////////////////////////Forma de PAGO

    $this->SeparadorHorizontal($handle, "_", $AnchoSeparador);
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(97). chr(0));// IZQUIERDA
    if($DatosFactura["ObservacionesFact"]<>""){
        fwrite($handle,"Observaciones:");
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,$DatosFactura["ObservacionesFact"]);
    }

    
    }
    
    //Termina observaciones
    
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(97). chr(1));// CENTRADO
    if($DatosFormato["NotasPiePagina"]<>''){
        $array = explode(";", $DatosFormato["NotasPiePagina"]);
        $this->SeparadorHorizontal($handle, "*", $AnchoSeparador);
        foreach ($array as $Nota) {
            fwrite($handle,$Nota);
            fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        }
        
    }
    $this->Footer($handle);
    }
    fclose($handle); // cierra el fichero PRN
    $salida = shell_exec('lpr $COMPrinter');
    
    }
    
    /*
     * Imprime una cotizacion pos
     */
    public function ImprimeCotizacionPOS($idCotizacion,$COMPrinter,$Copias){
        $COMPrinter= $this->COMPrinter;
        if(($handle = @fopen("$COMPrinter", "w")) === FALSE){
            die('ERROR:\nNo se puedo Imprimir, Verifique la conexion de la IMPRESORA');
        }
        $AnchoSeparador=44;
        $AnchoItems=28;
        $idFormatoCalidad=1;
        $DatosFormato= $this->DevuelveValores("formatos_calidad", "ID", $idFormatoCalidad);
        $DatosCotizacion= $this->DevuelveValores("cotizacionesv5", "ID", $idCotizacion);
        $idUsuario=$DatosCotizacion["Usuarios_idUsuarios"];
        $DatosUsuario=$this->ValorActual("usuarios", " Nombre , Apellido ", " idUsuarios='$idUsuario'");
        $idEmpresa=1;
        $this->EncabezadoComprobantesPos($handle, $DatosCotizacion["Fecha"], $idEmpresa);
        
        //fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"$DatosFormato[Nombre] No $idCotizacion");
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"ATIENDE: $DatosUsuario[Nombre] $DatosUsuario[Apellido]");
        $this->SeparadorHorizontal($handle, "*", 37);

        /////////////////////////////ITEMS COTIZADOS

        fwrite($handle, chr(27). chr(97). chr(0));// IZQUIERDA
        $this->SeparadorHorizontal($handle, "_", $AnchoSeparador);
        $sql = "SELECT * FROM cot_itemscotizaciones WHERE NumCotizacion='$idCotizacion'";
	
        $consulta=$this->Query($sql);
	$GranSubtotal=0;
        $GranIVA=0;
        $GranTotal=0;
	while($DatosItems=$this->FetchArray($consulta)){
            $GranSubtotal=$GranSubtotal+$DatosItems["Subtotal"];
            $GranIVA=$GranIVA+$DatosItems["IVA"];
            $GranTotal=$GranTotal+$DatosItems["Total"];
            fwrite($handle,str_pad($DatosItems["Cantidad"],4," ",STR_PAD_RIGHT));
            fwrite($handle,str_pad(substr($DatosItems["Referencia"]." ".$DatosItems["Descripcion"],0,$AnchoItems),$AnchoItems," ",STR_PAD_BOTH)."   ");
            fwrite($handle,str_pad("$".number_format($DatosItems["Total"]),10," ",STR_PAD_LEFT));
            fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        }

        /////////////////////////////TOTALES

        $this->SeparadorHorizontal($handle, "_", $AnchoSeparador);
        
        fwrite($handle, chr(27). chr(97). chr(0));// IZQUIERDA
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"SUBTOTAL    ".str_pad("$".number_format($GranSubtotal),20," ",STR_PAD_LEFT));
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"IVA         ".str_pad("$".number_format($GranIVA),20," ",STR_PAD_LEFT));
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"TOTAL       ".str_pad("$".number_format($GranTotal),20," ",STR_PAD_LEFT));
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        if($DatosCotizacion["Observaciones"]<>''){
            $this->SeparadorHorizontal($handle, "_", $AnchoSeparador);
            fwrite($handle,"Observaciones:");
            fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
            fwrite($handle,$DatosCotizacion["Observaciones"]);
        }    
        if($DatosFormato["NotasPiePagina"]<>''){
            $array = explode(";", $DatosFormato["NotasPiePagina"]);
            $this->SeparadorHorizontal($handle, "*", $AnchoSeparador);
            foreach ($array as $Nota) {
                fwrite($handle,$Nota);
                fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
            }
        
        }
        $this->Footer($handle);
        fclose($handle); // cierra el fichero PRN
        $salida = shell_exec('lpr $COMPrinter');
    
    }
     
     
    //imprime un tikete de promo
    public function ImprimirTiketePromo($idFactura,$Titulo,$COMPrinter,$Copias,$VectorTiket){
        $COMPrinter= $this->COMPrinter;
        if(($handle = @fopen("$COMPrinter", "w")) === FALSE){
            die('ERROR:\nNo se puedo Imprimir, Verifique la conexion de la IMPRESORA');
        }
       $DatosFactura=$this->DevuelveValores("facturas", "idFacturas", $idFactura);
        $Fecha=$DatosFactura["Fecha"];
        $Hora=$DatosFactura["Hora"];
        $NumFact=$DatosFactura["Prefijo"]." - ".$DatosFactura["NumeroFactura"];
        for($i=1; $i<=$Copias;$i++){
        fwrite($handle,chr(27). chr(64));//REINICIO
        //fwrite($handle, chr(27). chr(112). chr(48));//ABRIR EL CAJON
        fwrite($handle, chr(27). chr(100). chr(0));// SALTO DE CARRO VACIO
        fwrite($handle, chr(27). chr(33). chr(8));// NEGRITA
        fwrite($handle, chr(27). chr(97). chr(1));// CENTRADO
        fwrite($handle,"*************************************");
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$Titulo); // Titulo
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,"*************************************");
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,str_pad("NOMBRE:    ",40,"________________________________________",STR_PAD_RIGHT));
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,str_pad("CEDULA:    ",40,"________________________________________",STR_PAD_RIGHT));
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,str_pad("DIRECCION: ",40,"________________________________________",STR_PAD_RIGHT));
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,str_pad("TELEFONO:  ",40,"________________________________________",STR_PAD_RIGHT));
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,str_pad("CIUDAD:    ",40,"________________________________________",STR_PAD_RIGHT));
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,"*************************************");
        /////////////////////////////FECHA Y NUM FACTURA

        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle, chr(27). chr(97). chr(0));// IZQUIERDA
        fwrite($handle,"FECHA: $Fecha      HORA: $Hora");
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"Factura: $NumFact total: $". number_format($DatosFactura["Total"]));
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"_____________________________________");
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        
    fwrite($handle, chr(29). chr(86). chr(49));//CORTA PAPEL
    }
    fclose($handle); // cierra el fichero PRN
    $salida = shell_exec('lpr $COMPrinter');
    }
    
    
     /*
      * Imprime un separado
      */
     
     public function ImprimeSeparado($idSeparado,$COMPrinter,$Copias){
         $COMPrinter= $this->COMPrinter;
        if(($handle = @fopen("$COMPrinter", "w")) === FALSE){
            die('ERROR:\nNo se puedo Imprimir, Verifique la conexion de la IMPRESORA');
        }
       $DatosSeparado=$this->DevuelveValores("separados", "ID", $idSeparado);
       $DatosEmpresa=$this->DevuelveValores("empresapro", "idEmpresaPro", 1);
       
       $DatosUsuario=$this->DevuelveValores("usuarios", "idUsuarios", $DatosSeparado["idUsuarios"]);
       $DatosCliente=$this->DevuelveValores("clientes", "idClientes", $DatosSeparado["idCliente"]);
        $RazonSocial=$DatosEmpresa["RazonSocial"];
        $NIT=$DatosEmpresa["NIT"];
        $Direccion=$DatosEmpresa["Direccion"];
        $Ciudad=$DatosEmpresa["Ciudad"];
       
        $Telefono=$DatosEmpresa["Telefono"];

        $Total=$DatosSeparado["Total"];
        $Saldo=$DatosSeparado["Saldo"];
        
        $Fecha=$DatosSeparado["Fecha"];
        $Hora=$DatosSeparado["Hora"];
        
        for($i=1; $i<=$Copias;$i++){
        fwrite($handle,chr(27). chr(64));//REINICIO
        fwrite($handle, chr(27). chr(112). chr(48));//ABRIR EL CAJON
        fwrite($handle, chr(27). chr(100). chr(0));// SALTO DE CARRO VACIO
        fwrite($handle, chr(27). chr(33). chr(8));// NEGRITA
        fwrite($handle, chr(27). chr(97). chr(1));// CENTRADO
        fwrite($handle,"*************************************");
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$RazonSocial); // ESCRIBO RAZON SOCIAL
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$NIT);
        
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$Direccion);
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$Ciudad);
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$Telefono);
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA

        fwrite($handle,"Cajero:.$DatosUsuario[Nombre] $DatosUsuario[Apellido]");
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,"*************************************");
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,"Cliente: $DatosCliente[RazonSocial]");
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,"NIT: $DatosCliente[Num_Identificacion]");
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,"*************************************");
        /////////////////////////////FECHA Y NUM FACTURA

        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle, chr(27). chr(97). chr(0));// IZQUIERDA
        fwrite($handle,"FECHA: $Fecha        Hora: $Hora");
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"COMPROBANTE DE SEPARADO No $idSeparado");
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"_____________________________________");
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea

        /////////////////////////////ITEMS VENDIDOS

        fwrite($handle, chr(27). chr(97). chr(0));// IZQUIERDA

        $sql = "SELECT * FROM separados_items WHERE idSeparado='$idSeparado'";
	
        $consulta=$this->Query($sql);
							
	while($DatosVenta=$this->FetchArray($consulta)){
		
            //$Descuentos=$DatosVenta["Descuentos"];
            //$Impuestos=$DatosVenta["Impuestos"];
            $SubTotalITem=$DatosVenta["TotalItem"];
            //$SubTotalITem=$TotalVenta-$Impuestos;


            fwrite($handle,str_pad($DatosVenta["Cantidad"],4," ",STR_PAD_RIGHT));

            fwrite($handle,str_pad(substr($DatosVenta["Nombre"],0,20),20," ",STR_PAD_BOTH)."   ");

            fwrite($handle,str_pad("$".number_format($SubTotalITem),10," ",STR_PAD_LEFT));

            fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
}


    $TotalAbonos=$DatosSeparado['Total']-$DatosSeparado['Saldo'];

    /////////////////////////////TOTALES

    fwrite($handle,"_____________________________________");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(97). chr(0));// IZQUIERDA

    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"TOTAL           ".str_pad("$".number_format($DatosSeparado['Total']),20," ",STR_PAD_LEFT));

    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"_____________________________________");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"ABONOS:          ");
    $Consulta=$this->ConsultarTabla("separados_abonos", " WHERE idSeparado='$idSeparado'");
    while($DatosAbonos=$this->FetchArray($Consulta)){
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"CI No: $DatosAbonos[idComprobanteIngreso]");
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"Fecha:  $DatosAbonos[Fecha]  Valor: ".str_pad("$".number_format($DatosAbonos["Valor"]),10," ",STR_PAD_LEFT));
               
    }
    
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"TOTAL ABONOS:    ".str_pad("$".number_format($TotalAbonos),20," ",STR_PAD_LEFT));
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"_____________________________________");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"SALDO           ".str_pad("$".number_format($DatosSeparado['Saldo']),20," ",STR_PAD_LEFT));
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea

    fwrite($handle,"_____________________________________");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea

    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(97). chr(1));// CENTRO
    fwrite($handle,"***GRACIAS POR ELEGIRNOS***");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"**EL PLAZO MAXIMO PARA RETIRAR SU SEPARADO ES DE 30 DIAS***");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    //fwrite($handle, chr(27). chr(32). chr(0));//ESTACIO ENTRE LETRAS
    //fwrite($handle, chr(27). chr(100). chr(0));
    //fwrite($handle, chr(29). chr(107). chr(4)); //CODIGO BARRAS
    fwrite($handle, chr(27). chr(100). chr(1));
    fwrite($handle, chr(27). chr(100). chr(1));
    fwrite($handle,"***Comprobante impreso por TS5***");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"Software disenado por Techno Soluciones SAS, 3177740609, www.technosoluciones.com.co");
    //fwrite($handle,"=================================");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(100). chr(1));
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(100). chr(1));
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(100). chr(1));

    fwrite($handle, chr(29). chr(86). chr(49));//CORTA PAPEL
    }
    fclose($handle); // cierra el fichero PRN
    $salida = shell_exec('lpr $COMPrinter');
    
    }
     
    /*
     * Imprime en un egreso en POS
     * 
     */
    
    public function ImprimeEgresoPOS($idEgreso,$VectorEgresos,$COMPrinter,$Copias){
        $COMPrinter= $this->COMPrinter;    
        if(($handle = @fopen("$COMPrinter", "w")) === FALSE){
            die('ERROR:\nNo se puedo Imprimir, Verifique la conexion de la IMPRESORA');
        }
       $DatosEgreso=$this->DevuelveValores("egresos", "idEgresos", $idEgreso);
       $DatosEmpresa=$this->DevuelveValores("empresapro", "idEmpresaPro", 1);
       $RazonSocial=$DatosEmpresa["RazonSocial"];
        $NIT=$DatosEmpresa["NIT"];
        $Direccion=$DatosEmpresa["Direccion"];
        $Ciudad=$DatosEmpresa["Ciudad"];
       
        $Telefono=$DatosEmpresa["Telefono"];

       $DatosUsuario=$this->DevuelveValores("usuarios", "idUsuarios", $DatosEgreso["Usuario_idUsuario"]);
             
        for($i=1; $i<=$Copias;$i++){
        fwrite($handle,chr(27). chr(64));//REINICIO
        fwrite($handle, chr(27). chr(112). chr(48));//ABRIR EL CAJON
        fwrite($handle, chr(27). chr(100). chr(0));// SALTO DE CARRO VACIO
        fwrite($handle, chr(27). chr(33). chr(8));// NEGRITA
        fwrite($handle, chr(27). chr(97). chr(1));// CENTRADO
        fwrite($handle,"*************************************");
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$RazonSocial); // ESCRIBO RAZON SOCIAL
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$NIT);
        
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$Direccion);
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$Ciudad);
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$Telefono);
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA

        fwrite($handle,"Usuario:.$DatosUsuario[Nombre] $DatosUsuario[Apellido]");
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,"*************************************");
        
        /////////////////////////////FECHA Y NUM FACTURA

        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle, chr(27). chr(97). chr(0));// IZQUIERDA
        fwrite($handle,"FECHA: $DatosEgreso[Fecha]");
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"COMPROBANTE DE EGRESO:   $idEgreso");
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle, chr(27). chr(97). chr(1));// CENTRADO
        fwrite($handle,"_____________________________________");
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea

        /////////////////////////////Beneficiario
       
        fwrite($handle,"DATOS DEL BENEFICIARIO");
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle, chr(27). chr(97). chr(0));// IZQUIERDA

        fwrite($handle,str_pad("Razon Social: $DatosEgreso[Beneficiario]",10," ",STR_PAD_LEFT));
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,str_pad("NIT: $DatosEgreso[NIT]",10," ",STR_PAD_LEFT));
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,str_pad("Direccion: $DatosEgreso[Direccion]",10," ",STR_PAD_LEFT));
        
        fwrite($handle, chr(27). chr(100). chr(1));
        fwrite($handle,str_pad("Ciudad: $DatosEgreso[Ciudad]",10," ",STR_PAD_LEFT));
        fwrite($handle, chr(27). chr(100). chr(1));
    /////////////////////////////TOTALES
    fwrite($handle, chr(27). chr(97). chr(1));// CENTRADO
    fwrite($handle,"_____________________________________");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    /////////////////////////////Beneficiario
    
    fwrite($handle,"CONCEPTO");
    fwrite($handle, chr(27). chr(97). chr(0));// IZQUIERDA
    
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,$DatosEgreso["Concepto"]);
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"_____________________________________");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    /////////////////////////////Totales
    
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"SUBTOTAL:      ".str_pad("$".number_format($DatosEgreso["Subtotal"]),20," ",STR_PAD_LEFT));
    
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"IVA:           ".str_pad("$".number_format($DatosEgreso["IVA"]),20," ",STR_PAD_LEFT));
    
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"TOTAL:         ".str_pad("$".number_format($DatosEgreso["Valor"]),20," ",STR_PAD_LEFT));
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    
    fwrite($handle,"_____________________________________");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"RECIBIDO:     _______________________");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"REALIZA:      _______________________");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"APRUEBA:      _______________________");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    
    
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(97). chr(1));// CENTRO
   
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    //fwrite($handle, chr(27). chr(32). chr(0));//ESTACIO ENTRE LETRAS
    //fwrite($handle, chr(27). chr(100). chr(0));
    //fwrite($handle, chr(29). chr(107). chr(4)); //CODIGO BARRAS
    fwrite($handle, chr(27). chr(100). chr(1));
    fwrite($handle, chr(27). chr(100). chr(1));
    fwrite($handle,"***Comprobante impreso por TS5***");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"Software disenado por Techno Soluciones SAS, 3177740609, www.technosoluciones.com.co");
    //fwrite($handle,"=================================");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(100). chr(1));
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(100). chr(1));
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(100). chr(1));

    fwrite($handle, chr(29). chr(86). chr(49));//CORTA PAPEL
    }
    fclose($handle); // cierra el fichero PRN
    $salida = shell_exec('lpr $COMPrinter');
    
    }
    
        
        
        /*
      * Imprime un Comprobante de Abono de Factura
      */
     
     public function ImprimeComprobanteAbonoFactura($idComprobanteAbono,$COMPrinter,$Copias){
         $COMPrinter= $this->COMPrinter;
        if(($handle = @fopen("$COMPrinter", "w")) === FALSE){
            die('ERROR:\nNo se puedo Imprimir, Verifique la conexion de la IMPRESORA');
        }
       $DatosAbono=$this->DevuelveValores("facturas_abonos", "ID", $idComprobanteAbono);
       $DatosFactura=$this->DevuelveValores("facturas", "idFacturas", $DatosAbono["Facturas_idFacturas"]);
       $DatosEmpresa=$this->DevuelveValores("empresapro", "idEmpresaPro", $DatosFactura["EmpresaPro_idEmpresaPro"]);
       
       $DatosUsuario=$this->DevuelveValores("usuarios", "idUsuarios", $DatosAbono["Usuarios_idUsuarios"]);
       $DatosCliente=$this->DevuelveValores("clientes", "idClientes", $DatosFactura["Clientes_idClientes"]);
       $SaldoTotal=$this->SumeColumna("cartera", "Saldo", "idCliente", $DatosFactura["Clientes_idClientes"]);
        $RazonSocial=$DatosEmpresa["RazonSocial"];
        $NIT=$DatosEmpresa["NIT"];
        $Direccion=$DatosEmpresa["Direccion"];
        $Ciudad=$DatosEmpresa["Ciudad"];
       
        $Telefono=$DatosEmpresa["Telefono"];

        $Total=$DatosFactura["Total"];
        $Saldo=$DatosFactura["SaldoFact"];
        
        $Fecha=$DatosAbono["Fecha"];
        $Hora=$DatosAbono["Hora"];
        
        for($i=1; $i<=$Copias;$i++){
        fwrite($handle,chr(27). chr(64));//REINICIO
        fwrite($handle, chr(27). chr(112). chr(48));//ABRIR EL CAJON
        fwrite($handle, chr(27). chr(100). chr(0));// SALTO DE CARRO VACIO
        fwrite($handle, chr(27). chr(33). chr(8));// NEGRITA
        fwrite($handle, chr(27). chr(97). chr(1));// CENTRADO
        fwrite($handle,"*************************************");
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$RazonSocial); // ESCRIBO RAZON SOCIAL
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$NIT);
        
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$Direccion);
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$Ciudad);
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$Telefono);
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA

        fwrite($handle,"Cajero:.$DatosUsuario[Nombre] $DatosUsuario[Apellido]");
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,"*************************************");
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,"Cliente: $DatosCliente[RazonSocial]");
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,"NIT: $DatosCliente[Num_Identificacion]");
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,"*************************************");
        /////////////////////////////FECHA Y NUM FACTURA

        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle, chr(27). chr(97). chr(0));// IZQUIERDA
        fwrite($handle,"FECHA: $Fecha        Hora: $Hora");
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"COMPROBANTE DE ABONO No $idComprobanteAbono");
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"_____________________________________");
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"FACTURA NUMERO: $DatosFactura[Prefijo] - $DatosFactura[NumeroFactura]");
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"_____________________________________");
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea

    $TotalAbonos=$DatosFactura['Total']-$DatosFactura['SaldoFact'];

    /////////////////////////////TOTALES

    fwrite($handle,"_____________________________________");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(97). chr(0));// IZQUIERDA

    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"TOTAL FACTURA        ".str_pad("$".number_format($DatosFactura['Total']),20," ",STR_PAD_LEFT));

    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"_____________________________________");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    $idFactura=$DatosFactura["idFacturas"];
    fwrite($handle,"ABONOS:          ");
    $Consulta=$this->ConsultarTabla("facturas_abonos", " WHERE Facturas_idFacturas='$idFactura'");
    $TotalAbonos=0;
    while($DatosAbonosFactura=$this->FetchArray($Consulta)){
        $TotalAbonos=$TotalAbonos+$DatosAbonosFactura["Valor"];
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"CI No: $DatosAbonosFactura[idComprobanteIngreso]");
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"Fecha:  $DatosAbonosFactura[Fecha]  Valor: ".str_pad("$".number_format($DatosAbonosFactura["Valor"]),10," ",STR_PAD_LEFT));
               
    }
    
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"TOTAL ABONOS:    ".str_pad("$".number_format($TotalAbonos),20," ",STR_PAD_LEFT));
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"_____________________________________");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"SALDO DE ESTA FACTURA: ".str_pad("$".number_format($DatosFactura['SaldoFact']),20," ",STR_PAD_LEFT));
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea

    fwrite($handle,"_____________________________________");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    
    fwrite($handle,"SALDOS ANTERIORES:     ".str_pad("$".number_format($SaldoTotal),20," ",STR_PAD_LEFT));
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea

    fwrite($handle,"_____________________________________");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(97). chr(1));// CENTRO
    fwrite($handle,"***GRACIAS POR ELEGIRNOS***");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    //fwrite($handle, chr(27). chr(32). chr(0));//ESTACIO ENTRE LETRAS
    //fwrite($handle, chr(27). chr(100). chr(0));
    //fwrite($handle, chr(29). chr(107). chr(4)); //CODIGO BARRAS
    fwrite($handle, chr(27). chr(100). chr(1));
    fwrite($handle, chr(27). chr(100). chr(1));
    fwrite($handle,"***Comprobante impreso por TS5***");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"Software disenado por Techno Soluciones SAS, 3177740609, www.technosoluciones.com.co");
    //fwrite($handle,"=================================");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(100). chr(1));
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(100). chr(1));
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(100). chr(1));

    fwrite($handle, chr(29). chr(86). chr(49));//CORTA PAPEL
    }
    fclose($handle); // cierra el fichero PRN
    $salida = shell_exec('lpr $COMPrinter');
    
    }
    
    /*
      * Imprime un Cierre
      */
     
     public function ImprimeCierre($idUser,$VectorCierre,$COMPrinter,$Copias){
        $COMPrinter= $this->COMPrinter;    
        if(($handle = @fopen("$COMPrinter", "w")) === FALSE){
            die('ERROR:\nNo se puedo Imprimir, Verifique la conexion de la IMPRESORA');
        }
       $idCierre=$VectorCierre["idCierre"];
       $DatosEmpresa=$this->DevuelveValores("empresapro", "idEmpresaPro", 1);
       $RazonSocial=$DatosEmpresa["RazonSocial"];
        $NIT=$DatosEmpresa["NIT"];
        $Direccion=$DatosEmpresa["Direccion"];
        $Ciudad=$DatosEmpresa["Ciudad"];
       
        $Telefono=$DatosEmpresa["Telefono"];

       $DatosUsuario=$this->DevuelveValores("usuarios", "idUsuarios", $idUser);
       $DatosCierre=$this->DevuelveValores("cajas_aperturas_cierres", "ID", $idCierre);
      
       
        for($i=1; $i<=$Copias;$i++){
        fwrite($handle,chr(27). chr(64));//REINICIO
        fwrite($handle, chr(27). chr(112). chr(48));//ABRIR EL CAJON
        fwrite($handle, chr(27). chr(100). chr(0));// SALTO DE CARRO VACIO
        fwrite($handle, chr(27). chr(33). chr(8));// NEGRITA
        fwrite($handle, chr(27). chr(97). chr(1));// CENTRADO
        $this->SeparadorHorizontal($handle,"*", 37);
        fwrite($handle,$RazonSocial); // ESCRIBO RAZON SOCIAL
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$NIT);
        
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$Direccion);
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$Ciudad);
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$Telefono);
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA

        fwrite($handle,"Cajero:.$DatosUsuario[Nombre] $DatosUsuario[Apellido]");
        $this->SeparadorHorizontal($handle,"*", 37);
        
        /////////////////////////////FECHA Y NUM FACTURA

        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle, chr(27). chr(97). chr(0));// IZQUIERDA
        fwrite($handle,"FECHA: $DatosCierre[Fecha]          HORA: $DatosCierre[Hora]");
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"COMPROBANTE DE ENTREGA:   $idCierre");
        $this->SeparadorHorizontal($handle, "_", 37);

        /////////////////////////////DEVOLUCIONES
        
        $sql = "SELECT Cantidad as Cantidad, TotalItem as Total, Referencia as Referencia"
                . " FROM facturas_items fi "
                . " WHERE Cantidad < 0 AND idCierre='$idCierre'";
	
        $consulta=$this->Query($sql);
	$TotalDevoluciones=0;						
	while($DatosVenta=$this->FetchArray($consulta)){
	
            $TotalDevoluciones=$TotalDevoluciones+$DatosVenta["Total"];
           
            fwrite($handle,str_pad($DatosVenta["Cantidad"],4," ",STR_PAD_RIGHT));

            fwrite($handle,str_pad(substr($DatosVenta["Referencia"],0,20),20," ",STR_PAD_BOTH)."   ");

            fwrite($handle,str_pad("$".number_format($DatosVenta["Total"]),10," ",STR_PAD_LEFT));

            fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        }

        fwrite($handle,str_pad("Total Devoluciones $TotalDevoluciones",10," ",STR_PAD_LEFT));
    
    /////////////////////////////TOTALES
    
    $this->SeparadorHorizontal($handle, "_", 37);
    
    fwrite($handle,"TOTAL VENTAS         ".str_pad("$".number_format($DatosCierre["TotalVentas"]),20," ",STR_PAD_LEFT));

    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"TOTAL VENTAS CONTADO ".str_pad("$".number_format($DatosCierre["TotalVentasContado"]),20," ",STR_PAD_LEFT));
    
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"TOTAL VENTAS CREDITO ".str_pad("$".number_format($DatosCierre["TotalVentasCredito"]),20," ",STR_PAD_LEFT));
    //Calculo las ventas x separado
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"RETIROS SEPARADOS    ".str_pad("$".number_format($DatosCierre["TotalRetiroSeparados"]),20," ",STR_PAD_LEFT));
    
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"TOTAL VENTAS SISTE CREDITO ".str_pad("$".number_format($DatosCierre["TotalVentasSisteCredito"]),14," ",STR_PAD_LEFT));
    /*
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"EFECTIVO             ".str_pad("$".number_format($DatosCierre["Efectivo"]),20," ",STR_PAD_LEFT));
    
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"DEVUELTAS            ".str_pad("$".number_format($DatosCierre["Devueltas"]),20," ",STR_PAD_LEFT));
    */
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"ABONOS SEPARADOS     ".str_pad("$".number_format($DatosCierre["TotalAbonos"]),20," ",STR_PAD_LEFT));
    $sql="SELECT SUM(Valor) as Abono, TipoPagoAbono FROM facturas_abonos WHERE idCierre='$idCierre' GROUP BY TipoPagoAbono ";
    $ConsultaAbonos=$this->Query($sql);
    $AbonosCreditoEfectivo=0;
    $AbonosCreditoTarjeta=0;
    $AbonosCreditoCheque=0;
    $AbonosCreditoOtros=0;
    while ($DatosAbonos=$this->FetchArray($ConsultaAbonos)){
        if($DatosAbonos["TipoPagoAbono"]==""){
            $AbonosCreditoEfectivo=$AbonosCreditoEfectivo+$DatosAbonos["Abono"];
        }
        if($DatosAbonos["TipoPagoAbono"]=="Tarjetas"){
            $AbonosCreditoTarjeta=$AbonosCreditoTarjeta+$DatosAbonos["Abono"];
        }
        if($DatosAbonos["TipoPagoAbono"]=="Cheques"){
            $AbonosCreditoCheque=$AbonosCreditoCheque+$DatosAbonos["Abono"];
        }
        if($DatosAbonos["TipoPagoAbono"]=="Bonos"){
            $AbonosCreditoOtros=$AbonosCreditoOtros+$DatosAbonos["Abono"];
        }
    }
    $TotalInteresesSisteCredito=$this->Sume("facturas_intereses_sistecredito", "Valor", "WHERE idCierre='$idCierre'");
    $TotalAnticiposRecibidos=$this->Sume("comprobantes_ingreso", "Valor", "WHERE idCierre='$idCierre' AND Estado='ABIERTO' AND Tipo='ANTICIPO'");
    $TotalAnticiposCruzados=$this->Sume("comprobantes_ingreso", "Valor", "WHERE idCierre='$idCierre' AND Estado='CERRADO' AND Tipo='ANTICIPO'");
        
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"ABONOS CRED EFECTIVO ".str_pad("$".number_format($AbonosCreditoEfectivo),20," ",STR_PAD_LEFT));
    
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"ABONOS CRED TARJETAS ".str_pad("$".number_format($AbonosCreditoTarjeta),20," ",STR_PAD_LEFT));
    
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"ABONOS CRED CHEQUES  ".str_pad("$".number_format($AbonosCreditoCheque),20," ",STR_PAD_LEFT));
    
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"ABONOS CRED BONOS    ".str_pad("$".number_format($AbonosCreditoOtros),20," ",STR_PAD_LEFT));
    
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"ABONOS SISTECREDITO  ".str_pad("$".number_format($DatosCierre["AbonosSisteCredito"]),20," ",STR_PAD_LEFT));
    
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"INTERESES SISTECREDITO  ".str_pad("$".number_format($TotalInteresesSisteCredito),17," ",STR_PAD_LEFT));
    if($TotalAnticiposRecibidos>0){
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"ANTICIPOS RECIBIDOS  ".str_pad("$".number_format($TotalAnticiposRecibidos),20," ",STR_PAD_LEFT));
     
    }
    if($TotalAnticiposCruzados>0){
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"ANTICIPOS CRUZADOS   ".str_pad("$".number_format($TotalAnticiposCruzados),20," ",STR_PAD_LEFT));
     
    }
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"EGRESOS              ".str_pad("$".number_format($DatosCierre["TotalEgresos"]),20," ",STR_PAD_LEFT));
     
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"TOTAL TARJETAS       ".str_pad("$".number_format($DatosCierre["TotalTarjetas"]),20," ",STR_PAD_LEFT));
    
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"TOTAL CHEQUES        ".str_pad("$".number_format($DatosCierre["TotalCheques"]),20," ",STR_PAD_LEFT));
    
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"TOTAL OTROS          ".str_pad("$".number_format($DatosCierre["TotalOtros"]),20," ",STR_PAD_LEFT));
    
    $TotalOtrosImpuestos=$this->Sume("facturas_items", "ValorOtrosImpuestos", "WHERE idCierre='$idCierre'");
    
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"OTROS IMPUESTOS      ".str_pad("$".number_format($TotalOtrosImpuestos),20," ",STR_PAD_LEFT));
    
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"TOTAL ENTREGA        ".str_pad("$".number_format($DatosCierre["TotalEntrega"]+$TotalOtrosImpuestos+$TotalInteresesSisteCredito+$TotalAnticiposRecibidos-$TotalAnticiposCruzados),20," ",STR_PAD_LEFT));
    
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"SALDO EN CAJA        ".str_pad("$".number_format($DatosCierre["TotalEfectivo"]+$TotalOtrosImpuestos+$TotalInteresesSisteCredito+$TotalAnticiposRecibidos-$TotalAnticiposCruzados),20," ",STR_PAD_LEFT));
    
    $this->SeparadorHorizontal($handle, "_", 37);

    $this->Footer($handle);
    }
    fclose($handle); // cierra el fichero PRN
    $salida = shell_exec('lpr $COMPrinter');
    $this->ImprimeCierreDepartamentos($idUser,$VectorCierre,$COMPrinter,$Copias);
    }
    
     //Imprime el dato de los departamentos en un cierre
      public function ImprimeCierreDepartamentos($idUser,$VectorCierre,$COMPrinter,$Copias){
        $COMPrinter= $this->COMPrinter;    
        if(($handle = @fopen("$COMPrinter", "w")) === FALSE){
            die('ERROR:\nNo se puedo Imprimir, Verifique la conexion de la IMPRESORA');
        }
       $idCierre=$VectorCierre["idCierre"];
       
       $DatosCierre=$this->DevuelveValores("cajas_aperturas_cierres", "ID", $idCierre);
      
       
        for($i=1; $i<=$Copias;$i++){
        fwrite($handle,chr(27). chr(64));//REINICIO
        //fwrite($handle, chr(27). chr(112). chr(48));//ABRIR EL CAJON
        fwrite($handle, chr(27). chr(100). chr(0));// SALTO DE CARRO VACIO
        fwrite($handle, chr(27). chr(33). chr(8));// NEGRITA
        fwrite($handle, chr(27). chr(97). chr(1));// CENTRADO
        fwrite($handle,"*************************************");
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,"Resumen de Ventas por Departamento"); // ESCRIBO RAZON SOCIAL
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea

        /////////////////////////////DEVOLUCIONES
        
        
        fwrite($handle, chr(27). chr(97). chr(0));// IZQUIERDA

        $sql = "SELECT sum(`TotalItem`) as Total, sum(`Cantidad`) as Cantidad, `Departamento` FROM `facturas_items` WHERE `idCierre`='$idCierre' GROUP BY `Departamento`";
	
        $consulta=$this->Query($sql);
							
	while($DatosVenta=$this->FetchArray($consulta)){
	    $DatosDepartamento=$this->DevuelveValores("prod_departamentos", "idDepartamentos", $DatosVenta["Departamento"]);       
            fwrite($handle,str_pad("Departamento: ".$DatosDepartamento["Nombre"],10," ",STR_PAD_RIGHT));
            fwrite($handle,str_pad(number_format($DatosVenta["Cantidad"]),3," ",STR_PAD_LEFT));
            fwrite($handle,str_pad("$".number_format($DatosVenta["Total"]),10," ",STR_PAD_LEFT));

            fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        }

    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"_____________________________________");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea

    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(97). chr(1));// CENTRO
   
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    //fwrite($handle, chr(27). chr(32). chr(0));//ESTACIO ENTRE LETRAS
    //fwrite($handle, chr(27). chr(100). chr(0));
    //fwrite($handle, chr(29). chr(107). chr(4)); //CODIGO BARRAS
    fwrite($handle, chr(27). chr(100). chr(1));
    fwrite($handle, chr(27). chr(100). chr(1));
    
    //fwrite($handle,"=================================");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(100). chr(1));
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(100). chr(1));
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(100). chr(1));

    fwrite($handle, chr(29). chr(86). chr(49));//CORTA PAPEL
    }
    fclose($handle); // cierra el fichero PRN
    $salida = shell_exec('lpr $COMPrinter');
    
    }
    
    //Imprime comprobante de ingreso pos
    
    public function ComprobanteIngresoPOS($idIngreso,$COMPrinter,$Copias){
        $DatosImpresora=$this->DevuelveValores("config_puertos", "ID", 1);   
        if($DatosImpresora["Habilitado"]<>"SI"){
            return;
        }
        $COMPrinter= $this->COMPrinter;
        if(($handle = @fopen("$COMPrinter", "w")) === FALSE){
            die('ERROR:\nNo se puedo Imprimir, Verifique la conexion de la IMPRESORA');
        }
        $AnchoSeparador=44;
        $AnchoItems=28;
        $idFormatoCalidad=4;
        $DatosFormato= $this->DevuelveValores("formatos_calidad", "ID", $idFormatoCalidad);
        $DatosIngreso=$this->DevuelveValores("comprobantes_ingreso","ID",$idIngreso);
        $idCliente=$DatosIngreso["Clientes_idClientes"];
        $Tercero=$DatosIngreso["Tercero"];
        $idUsuario=$DatosIngreso["Usuarios_idUsuarios"];
        $DatosUsuario=$this->ValorActual("usuarios", " Nombre , Apellido ", " idUsuarios='$idUsuario'");
        $DatosTercero[]="";
        if($Tercero>0){
            $DatosTercero=$this->DevuelveValores("clientes","Num_Identificacion",$Tercero);
            if($DatosTercero["Num_Identificacion"]==''){
                $DatosTercero=$this->DevuelveValores("proveedores","Num_Identificacion",$Tercero);
            }
        }
        if($idCliente>0){
            $DatosTercero=$this->DevuelveValores("clientes","idClientes",$idCliente);
        }
        
        $idEmpresa=1;
        $this->EncabezadoComprobantesPos($handle, $DatosCotizacion["Fecha"], $idEmpresa);
        
        //fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"$DatosFormato[Nombre] No $idIngreso");
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"REALIZA: $DatosUsuario[Nombre] $DatosUsuario[Apellido]");
        $this->SeparadorHorizontal($handle, "*", 37);
        
        fwrite($handle,"Cliente: $DatosTercero[RazonSocial]");
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,"NIT: $DatosTercero[Num_Identificacion]");
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        $this->SeparadorHorizontal($handle, "*", 37);
        
        if($DatosIngreso["Concepto"]<>''){
            $this->SeparadorHorizontal($handle, "_", $AnchoSeparador);
            fwrite($handle,"Concepto:");
            fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
            fwrite($handle,$DatosIngreso["Concepto"]);
        }  
        /////////////////////////////TOTALES

        $this->SeparadorHorizontal($handle, "_", $AnchoSeparador);
        
        
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"VALOR    ".str_pad("$".number_format($DatosIngreso["Valor"]),20," ",STR_PAD_LEFT));
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        
          
        if($DatosFormato["NotasPiePagina"]<>''){
            $array = explode(";", $DatosFormato["NotasPiePagina"]);
            $this->SeparadorHorizontal($handle, "*", $AnchoSeparador);
            foreach ($array as $Nota) {
                fwrite($handle,$Nota);
                fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
            }
        
        }
        $this->Footer($handle);
        fclose($handle); // cierra el fichero PRN
        $salida = shell_exec('lpr $COMPrinter');
    
    }
    
    
    //imprime un domicilio de restaurante
    public function ImprimeDomicilioRestaurante($idPedido,$COMPrinter,$Copias,$Vector){
        $DatosImpresora=$this->DevuelveValores("config_puertos", "ID", 1);   
        if($DatosImpresora["Habilitado"]<>"SI"){
            return;
        }
        $COMPrinter= $this->COMPrinter;
        if(($handle = @fopen("$COMPrinter", "w")) === FALSE){
            die('ERROR:\nNo se puedo Imprimir, Verifique la conexion de la IMPRESORA');
        }
       $DatosPedido=$this->DevuelveValores("restaurante_pedidos", "ID", $idPedido);
       $DatosCliente=$this->DevuelveValores("clientes", "idClientes", $DatosPedido["idCliente"]);
        $Fecha=$DatosPedido["Fecha"];
        $Hora=$DatosPedido["Hora"];
        $DatosMesa=$this->DevuelveValores("restaurante_mesas", "ID", $DatosPedido["idMesa"]);
        $idUserR=$DatosPedido["idUsuario"];
        $sql="SELECT Nombre, Apellido FROM usuarios WHERE idUsuarios='$idUserR'";
        $consulta=$this->Query($sql);
        $DatosUsuario=$this->FetchArray($consulta);
        for($i=1; $i<=$Copias;$i++){
        $DatosPedido=$this->DevuelveValores("restaurante_pedidos", "ID", $idPedido);
        fwrite($handle,chr(27). chr(64));//REINICIO
        //fwrite($handle, chr(27). chr(112). chr(48));//ABRIR EL CAJON
        fwrite($handle, chr(27). chr(100). chr(0));// SALTO DE CARRO VACIO
        fwrite($handle, chr(27). chr(33). chr(8));// NEGRITA
        fwrite($handle, chr(27). chr(33). chr(32));// DOBLE ANCHO
        //fwrite($handle, chr(27). chr(33). chr(48));// MUY GRANDE
        
        fwrite($handle, chr(27). chr(97). chr(1));// CENTRADO
        fwrite($handle,"********************");
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        if($i==1){
            fwrite($handle,"---ORIGINAL---");
        }else{
            fwrite($handle,"---COPIA---");
        }
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,"DOMICILIO No $idPedido"); // Titulo
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,"********************");
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        
        fwrite($handle,"$DatosPedido[FechaCreacion]");
        
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,"CL:  $DatosPedido[NombreCliente]");
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        $DireccionEnvio=$DatosPedido["DireccionEnvio"];
        $TelefonoConfirmacion=$DatosPedido["TelefonoConfirmacion"];
        if($DatosPedido["DireccionEnvio"]==""){
            $DireccionEnvio=$DatosCliente["Direccion"];
        }
        if($TelefonoConfirmacion==''){
            $TelefonoConfirmacion=$DatosCliente["Telefono"];
        }
        fwrite($handle,"DIR: $DireccionEnvio ");
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,"TEL:  $TelefonoConfirmacion");
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        
        
        fwrite($handle,"**************");
        /////////////////////////////FECHA Y NUM FACTURA

        $sql = "SELECT * FROM restaurante_pedidos_items WHERE idPedido='$idPedido'";
	
        $consulta=$this->Query($sql);
	$Total=0;							
	while($DatosPedido=$this->FetchArray($consulta)){
            $Total=$Total+$DatosPedido["Total"];
            fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
            fwrite($handle,$DatosPedido["Cantidad"]."  ");
            fwrite($handle,substr($DatosPedido["NombreProducto"],0,50)."   ");
            fwrite($handle, number_format($DatosPedido["Total"]));
            fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
            if($DatosPedido["Observaciones"]<>""){
                fwrite($handle,$DatosPedido["Observaciones"]);
                fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
            }
            fwrite($handle,"______________");

        }

        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
    /////////////////////////////TOTALES

    fwrite($handle,"______________");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(97). chr(0));// IZQUIERDA
    
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"TOTAL A PAGAR    ".str_pad("$".number_format($Total),20," ",STR_PAD_LEFT));
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea

    fwrite($handle,"______________");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea

    
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(97). chr(1));// CENTRO
    fwrite($handle,"NO VALIDO COMO FACTURA");
    
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(100). chr(1));
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(100). chr(1));

    fwrite($handle, chr(29). chr(86). chr(49));//CORTA PAPEL
    }
    fclose($handle); // cierra el fichero PRN
    $salida = shell_exec('lpr $COMPrinter');
    }
    
     //imprime un pedido de restaurante
    public function ImprimePedidoRestaurante($idPedido,$COMPrinter,$Copias,$Vector){
        $DatosImpresora=$this->DevuelveValores("config_puertos", "ID", 1);   
        if($DatosImpresora["Habilitado"]<>"SI"){
            return;
        }
        $COMPrinter= $this->COMPrinter;
        if(($handle = @fopen("$COMPrinter", "w")) === FALSE){
            die('ERROR:\nNo se puedo Imprimir, Verifique la conexion de la IMPRESORA');
        }
       $DatosPedido=$this->DevuelveValores("restaurante_pedidos", "ID", $idPedido);
        $Fecha=$DatosPedido["Fecha"];
        $Hora=$DatosPedido["Hora"];
        $DatosMesa=$this->DevuelveValores("restaurante_mesas", "ID", $DatosPedido["idMesa"]);
        $idUserR=$DatosPedido["idUsuario"];
        $sql="SELECT Nombre, Apellido FROM usuarios WHERE idUsuarios='$idUserR'";
        $consulta=$this->Query($sql);
        $DatosUsuario=$this->FetchArray($consulta);
        for($i=1; $i<=$Copias;$i++){
        fwrite($handle,chr(27). chr(64));//REINICIO
        //fwrite($handle, chr(27). chr(112). chr(48));//ABRIR EL CAJON
        fwrite($handle, chr(27). chr(100). chr(0));// SALTO DE CARRO VACIO
        //fwrite($handle, chr(27). chr(33). chr(8));// NEGRITA
        
        //fwrite($handle, chr(27). chr(33). chr(48));// DOBLE ALTO
        
        fwrite($handle, chr(27). chr(97). chr(1));// CENTRADO
        
        if($i==1){
            fwrite($handle,"---ORIGINAL---");
        }else{
            fwrite($handle,"---COPIA---");
        }
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,"ORDEN DE PEDIDO No $idPedido"); // Titulo
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,"****************");
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        //fwrite($handle,"SOLICITA:  $DatosUsuario[Nombre] $DatosUsuario[Apellido]");
        //fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        
        
        fwrite($handle,"****************");
        fwrite($handle, chr(27). chr(33). chr(32));// DOBLE ANCHO
        /////////////////////////////FECHA Y NUM FACTURA

        $sql = "SELECT * FROM restaurante_pedidos_items WHERE idPedido='$idPedido'";
	
        $consulta=$this->Query($sql);
								
	while($DatosPedido=$this->FetchArray($consulta)){
		
            fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
            fwrite($handle,$DatosPedido["Cantidad"]."  ");
            fwrite($handle,substr($DatosPedido["NombreProducto"],0,50)."   ");
            fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
            if($DatosPedido["Observaciones"]<>""){
                fwrite($handle,$DatosPedido["Observaciones"]);
                fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
            }
            fwrite($handle,"_________________");

        }

        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,$Fecha." ".$Hora);
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,"$DatosMesa[Nombre]");
        
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        
    fwrite($handle, chr(29). chr(86). chr(49));//CORTA PAPEL
    }
    fclose($handle); // cierra el fichero PRN
    $salida = shell_exec('lpr $COMPrinter');
    }
    
    
    //Imprime la precuenta
    //
    
    public function ImprimePrecuentaRestaurante($idPedido,$COMPrinter,$Copias){
        $DatosImpresora=$this->DevuelveValores("config_puertos", "ID", 1);   
        if($DatosImpresora["Habilitado"]<>"SI"){
            return;
        }
        $COMPrinter= $this->COMPrinter;
        if(($handle = @fopen("$COMPrinter", "w")) === FALSE){
            die('ERROR:\nNo se puedo Imprimir, Verifique la conexion de la IMPRESORA');
        }
       $DatosPedido=$this->DevuelveValores("restaurante_pedidos", "ID", $idPedido);
       $idUserR=$DatosPedido["idUsuario"];
        $sql="SELECT Nombre, Apellido FROM usuarios WHERE idUsuarios='$idUserR'";
        $consulta=$this->Query($sql);
        $DatosUsuario=$this->FetchArray($consulta);
        $DatosMesa=$this->DevuelveValores("restaurante_mesas", "ID", $DatosPedido["idMesa"]);
        $Fecha=$DatosPedido["FechaCreacion"];
        
        for($i=1; $i<=$Copias;$i++){
        fwrite($handle,chr(27). chr(64));//REINICIO
        //fwrite($handle, chr(27). chr(112). chr(48));//ABRIR EL CAJON
        fwrite($handle, chr(27). chr(100). chr(0));// SALTO DE CARRO VACIO
        fwrite($handle, chr(27). chr(33). chr(8));// NEGRITA
        fwrite($handle, chr(27). chr(97). chr(1));// CENTRADO
        fwrite($handle,"****************");
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,"PRECUENTA No. $idPedido"); // ESCRIBO RAZON SOCIAL
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        
        fwrite($handle,"$Fecha, $DatosMesa[Nombre] ");
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
	fwrite($handle,"Atiende: $DatosUsuario[Nombre] $DatosUsuario[Apellido]");	
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,"****************");
        
        //fwrite($handle, chr(27). chr(97). chr(0));// CENTRADO
        /////////////////////////////ITEMS VENDIDOS

       

        $sql = "SELECT * FROM restaurante_pedidos_items WHERE idPedido='$idPedido'";
	
        $consulta=$this->Query($sql);
	$Subtotal=0;
        $IVA=0;
        $Total=0;
	while($DatosVenta=$this->FetchArray($consulta)){
		 fwrite($handle, chr(27). chr(97). chr(0));// IZQUIERDA
            $Subtotal=$Subtotal+$DatosVenta["Subtotal"];
            $IVA=$IVA+$DatosVenta["IVA"];
            $Total=$Total+$DatosVenta["Total"];
             fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
            fwrite($handle,str_pad($DatosVenta["Cantidad"],4," ",STR_PAD_RIGHT));

            fwrite($handle,str_pad(substr($DatosVenta["NombreProducto"],0,26),20," ",STR_PAD_BOTH)."   ");

            fwrite($handle,str_pad("$".number_format($DatosVenta["Total"]),10," ",STR_PAD_LEFT));

}



fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
    /////////////////////////////TOTALES

    fwrite($handle,"________________");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(97). chr(0));// IZQUIERDA
    
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"TOTAL             ".str_pad("$".number_format($Total),20," ",STR_PAD_LEFT));
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea

    fwrite($handle,"_________________");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea

    $propina=$Total*0.1;
    
	fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"PROPINA VOLUNTARIA".str_pad("$".number_format($propina),20," ",STR_PAD_LEFT));
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea

    fwrite($handle,"_________________");
	fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"TOTAL A PAGAR    ".str_pad("$".number_format($propina+$Total),20," ",STR_PAD_LEFT));
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea

    fwrite($handle,"_________________");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(97). chr(1));// CENTRO
    fwrite($handle,"NO VALIDO COMO FACTURA");
    
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(100). chr(1));
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(100). chr(1));

    fwrite($handle, chr(29). chr(86). chr(49));//CORTA PAPEL
    }
    fclose($handle); // cierra el fichero PRN
    $salida = shell_exec('lpr $COMPrinter');
    
    }
    //imprime un cierre de restaurante
    public function ImprimirCierreRestaurante($idCierre,$COMPrinter,$Copias,$Vector) {
        $DatosImpresora=$this->DevuelveValores("config_puertos", "ID", 1);   
        if($DatosImpresora["Habilitado"]<>"SI"){
            return;
        }
        $COMPrinter= $this->COMPrinter;
        if(($handle = @fopen("$COMPrinter", "w")) === FALSE){
            die('ERROR:\nNo se puedo Imprimir, Verifique la conexion de la IMPRESORA');
        }
        $Titulo="Comprobante de Cierre No. $idCierre";
        $DatosCierre=$this->DevuelveValores("restaurante_cierres", "ID", $idCierre);
        $Fecha=$DatosCierre["Fecha"];
        $Hora=$DatosCierre["Hora"];
        $idUsuario=$DatosCierre["idUsuario"];
        $Usuarios[]="";
        $TotalesPedidos[]="";
        $sql="SELECT count(DISTINCT idPedido) as NumPedidos,Estado,sum(`Total`) as Total, idUsuario FROM `restaurante_pedidos_items` "
                . "WHERE `idCierre`='$idCierre' GROUP BY `Estado`,`idUsuario` ";
        $Consulta=$this->Query($sql);
        while($DatosCierre=$this->FetchArray($Consulta)){
            $Estado=$DatosCierre["Estado"];
            $idUsuario=$DatosCierre["idUsuario"];
            $Usuarios[$idUsuario]=$DatosCierre["idUsuario"];
            $TotalesPedidos[$idUsuario][$Estado]=$DatosCierre["Total"];
            $TotalesPedidos[$idUsuario]["NumPedidos"]=$DatosCierre["NumPedidos"];  
        }
        for($i=1; $i<=$Copias;$i++){
        fwrite($handle,chr(27). chr(64));//REINICIO
        fwrite($handle, chr(27). chr(112). chr(48));//ABRIR EL CAJON
        fwrite($handle, chr(27). chr(100). chr(0));// SALTO DE CARRO VACIO
        fwrite($handle, chr(27). chr(33). chr(8));// NEGRITA
        fwrite($handle, chr(27). chr(97). chr(1));// CENTRADO
        fwrite($handle,"*************************************");
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$Titulo); // Titulo
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,"*************************************");
        
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle, chr(27). chr(97). chr(0));// IZQUIERDA
        fwrite($handle,"FECHA: $Fecha      HORA: $Hora");
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"*************************************");
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        $GranTotal=0;
        foreach($Usuarios as $idUser){
            $DatosUsuario=$this->DevuelveValores("usuarios", "idUsuarios", $idUser);
            fwrite($handle,"USUARIO $DatosUsuario[Nombre] $DatosUsuario[Apellido]:");
            fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
            $NumPedidos="";
            if(isset($TotalesPedidos[$idUsuario]["NumPedidos"])){
                $NumPedidos=$TotalesPedidos[$idUsuario]["NumPedidos"];
            }
            
            if(isset($TotalesPedidos[$idUser]["FAPE"])){
                $GranTotal=$GranTotal+$TotalesPedidos[$idUser]["FAPE"];
                fwrite($handle,"PEDIDOS FACTURADOS: $NumPedidos X $".number_format($TotalesPedidos[$idUser]["FAPE"]));
                fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
                //fwrite($handle,"NUM PEDIDOS FACTURADOS: ".number_format($TotalesPedidos[$idUsuario][$Estado]["NumPedidos"]));
                //fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
            }
            if(isset($TotalesPedidos[$idUser]["DEPE"])){
                fwrite($handle,"PEDIDOS DESCARTADOS: $NumPedidos X $".number_format($TotalesPedidos[$idUser]["DEPE"]));
                fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
            }
            if(isset($TotalesPedidos[$idUser]["FADO"])){
                $GranTotal=$GranTotal+$TotalesPedidos[$idUser]["FADO"];
                fwrite($handle,"DOMICILIOS FACTURADOS: $NumPedidos X $".number_format($TotalesPedidos[$idUser]["FADO"]));
                fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
            }
            if(isset($TotalesPedidos[$idUser]["DEDO"])){
                fwrite($handle,"DOMICILIOS DESCARTADOS: $NumPedidos X $".number_format($TotalesPedidos[$idUser]["DEDO"]));
                fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
            }
            if(isset($TotalesPedidos[$idUser]["FALL"])){
                $GranTotal=$GranTotal+$TotalesPedidos[$idUser]["FALL"];
                fwrite($handle,"PARA LLEVAR FACTURADOS: $NumPedidos X $".number_format($TotalesPedidos[$idUser]["FALL"]));
                fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
            }
            if(isset($TotalesPedidos[$idUser]["DELL"])){
                fwrite($handle,"PARA LLEVAR DESCARTADOS: $NumPedidos X $".number_format($TotalesPedidos[$idUser]["DELL"]));
                fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
            }
            
        }
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"TOTAL: $".number_format($GranTotal));
                
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(29). chr(86). chr(49));//CORTA PAPEL
    }
    fclose($handle); // cierra el fichero PRN
    $salida = shell_exec('lpr $COMPrinter');
    $this->RelacionItemsXFecha($idCierre,$Fecha, $Copias, "");
    }
    //Abrir cajon
    
    public function AbreCajon($Vector) {
        $DatosImpresora=$this->DevuelveValores("config_puertos", "ID", 1);   
        if($DatosImpresora["Habilitado"]<>"SI"){
            return;
        }
        $COMPrinter= $this->COMPrinter;
        if(($handle = @fopen("$COMPrinter", "w")) === FALSE){
            die('ERROR:\nNo se puedo Abrir el cajon, Verifique la conexion de la IMPRESORA');
        }
        
        fwrite($handle,chr(27). chr(64));//REINICIO
        fwrite($handle, chr(27). chr(112). chr(48));//ABRIR EL CAJON
        fwrite($handle, chr(27). chr(100). chr(0));// SALTO DE CARRO VACIO
        fwrite($handle, chr(27). chr(33). chr(8));// NEGRITA
        fwrite($handle, chr(27). chr(97). chr(1));// CENTRADO
        fwrite($handle,"*************************************");
        
    fclose($handle); // cierra el fichero PRN
    $salida = shell_exec('lpr $COMPrinter');
    }
    //Imprime cierre de modelos
   
    public function ImprimirCierreModelos($idCierre,$COMPrinter,$Copias,$Vector) {
        $DatosImpresora=$this->DevuelveValores("config_puertos", "ID", 1);   
        if($DatosImpresora["Habilitado"]<>"SI"){
            return;
        }
        $COMPrinter= $this->COMPrinter;
        if(($handle = @fopen("$COMPrinter", "w")) === FALSE){
            die('ERROR:\nNo se puedo Imprimir, Verifique la conexion de la IMPRESORA');
        }
        $Titulo="Comprobante de Cierre De Modelos No. $idCierre";
        $DatosCierre=$this->DevuelveValores("modelos_cierres", "ID", $idCierre);
        $Fecha=$DatosCierre["Fecha"];
        $Hora=$DatosCierre["Hora"];
        $idUsuario=$DatosCierre["idUser"];
        $Modelos[]="";
        
        for($i=1; $i<=$Copias;$i++){
        fwrite($handle,chr(27). chr(64));//REINICIO
        fwrite($handle, chr(27). chr(112). chr(48));//ABRIR EL CAJON
        fwrite($handle, chr(27). chr(100). chr(0));// SALTO DE CARRO VACIO
        fwrite($handle, chr(27). chr(33). chr(8));// NEGRITA
        fwrite($handle, chr(27). chr(97). chr(1));// CENTRADO
        fwrite($handle,"*************************************");
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$Titulo); // Titulo
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,"*************************************");
        
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle, chr(27). chr(97). chr(0));// IZQUIERDA
        fwrite($handle,"FECHA: $Fecha      HORA: $Hora");
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"*************************************");
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        $sql="SELECT * FROM modelos_agenda WHERE idCierre='$idCierre' AND Estado <> 'Anulado' ORDER BY idModelo";
        $Consulta= $this->Query($sql);
        $idModelo="";
        $DatosCasa[]="";
        $TotalModelo=0;
        $TotalCasa=0;
        while($DatosAgenda=$this->FetchArray($Consulta)){
            $idModeloAnt=$idModelo;
            $idModelo=$DatosAgenda["idModelo"];
            if($idModelo<>$idModeloAnt){
                
                $DatosModelo=$this->DevuelveValores("modelos_db", "ID", $idModelo);
                fwrite($handle,"Servicios de la Modelo $DatosModelo[NombreArtistico]: ");
                fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
                
                
            }
            $TotalCasa=$TotalCasa+$DatosAgenda["ValorCasa"];
            $TotalModelo=$TotalModelo+$DatosAgenda["ValorModelo"];
            
            fwrite($handle,"Fecha: $DatosAgenda[HoraInicial] // ");
            fwrite($handle,"Valor: ".number_format($DatosAgenda["ValorModelo"]));
            fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        }
        
        //fwrite($handle,"Total Modelo: $DatosAgenda[HoraInicial] // ");
        fwrite($handle,"Total Modelo: ".number_format($TotalModelo));
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
            
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(29). chr(86). chr(49));//CORTA PAPEL
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
            
        
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"Total Casa: ".number_format($TotalCasa));
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
            
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(29). chr(86). chr(49));//CORTA PAPEL
    }
    fclose($handle); // cierra el fichero PRN
    $salida = shell_exec('lpr $COMPrinter');
    }
    //Imprime Relacion de items vendidos
    public function RelacionItemsXFecha($idCierre,$Fecha,$Copias,$Vector) {
        
        
        $DatosImpresora=$this->DevuelveValores("config_puertos", "ID", 1);   
        if($DatosImpresora["Habilitado"]<>"SI"){
            return;
        }
        $COMPrinter= $this->COMPrinter;
        if(($handle = @fopen("$COMPrinter", "w")) === FALSE){
            die('ERROR:\nNo se puedo Imprimir, Verifique la conexion de la IMPRESORA');
        }
        $Titulo="Relacion de Productos y Servicios Vendidos el día $Fecha";
                
        for($i=1; $i<=$Copias;$i++){
            fwrite($handle,chr(27). chr(64));//REINICIO
            //fwrite($handle, chr(27). chr(112). chr(48));//ABRIR EL CAJON
            fwrite($handle, chr(27). chr(100). chr(0));// SALTO DE CARRO VACIO
            fwrite($handle, chr(27). chr(33). chr(8));// NEGRITA
            fwrite($handle, chr(27). chr(97). chr(1));// CENTRADO
            fwrite($handle,"*************************************");
            fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
            fwrite($handle,$Titulo); // Titulo
            fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
            fwrite($handle,"*************************************");

            fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
            fwrite($handle, chr(27). chr(97). chr(0));// IZQUIERDA
            fwrite($handle,"FECHA: $Fecha");
            fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
            fwrite($handle,"*************************************");
            fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
            $sql="SELECT NombreProducto as Nombre, SUM(`Total`) as Total,SUM(`Cantidad`) AS NumItems "
                    . "FROM `restaurante_pedidos_items`  "
                    . "WHERE idCierre='$idCierre' and (Estado='FAPE' or Estado='FADO' or Estado='FALL') GROUP BY `idProducto`";
            $Consulta= $this->Query($sql);
            
            $Total=0;
            $TotalItems=0;
            while($DatosItems=$this->FetchArray($Consulta)){
                $Total=$Total+$DatosItems["Total"];
                $TotalItems=$TotalItems+$DatosItems["NumItems"];
                
                fwrite($handle,str_pad($DatosItems["NumItems"],4," ",STR_PAD_RIGHT));

                fwrite($handle,str_pad(substr($DatosItems["Nombre"],0,24),24," ",STR_PAD_BOTH)."   ");

                fwrite($handle,str_pad("$".number_format($DatosItems["Total"]),10," ",STR_PAD_LEFT));

                fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
            }

            //fwrite($handle,"Total Modelo: $DatosAgenda[HoraInicial] // ");
            fwrite($handle,"Total Items: ".number_format($TotalItems));
            fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
            fwrite($handle,"Total:       ".number_format($Total));
            fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
            fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
            fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
            
            fwrite($handle,"RELACION DE CIERRES ESTE DIA"); // Titulo
            fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
            
            fwrite($handle,"*************************************");
            fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
            $sql="SELECT * FROM vista_cierres_restaurante WHERE Fecha='$Fecha' ";
            $Consulta= $this->Query($sql);
           
            while($DatosCierres=$this->FetchArray($Consulta)){
                fwrite($handle,"CIERRE $DatosCierres[ID]: ".$DatosCierres["Hora"].", USUARIO: ".$DatosCierres["idUsuario"]);
                fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
                $TotalEfectivo=$DatosCierres["PedidosFacturados"]+$DatosCierres["DomiciliosFacturados"]+$DatosCierres["ParaLlevarFacturado"];              
                //fwrite($handle,str_pad($DatosCierres["idUsuario"],10," ",STR_PAD_RIGHT));

                fwrite($handle,str_pad(substr(" TOTAL FACTURADO: ",0,24),24," ",STR_PAD_BOTH)."   ");

                fwrite($handle,str_pad("$".number_format($TotalEfectivo),10," ",STR_PAD_LEFT));

                fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
                
                $TotalDescartado=$DatosCierres["PedidosDescartados"]+$DatosCierres["DomiciliosDescartados"]+$DatosCierres["ParaLlevarDescartado"];              
                //fwrite($handle,str_pad($DatosCierres["idUsuario"],10," ",STR_PAD_RIGHT));

                fwrite($handle,str_pad(substr(" TOTAL DESCARTADO: ",0,24),24," ",STR_PAD_BOTH)."   ");

                fwrite($handle,str_pad("$".number_format($TotalDescartado),10," ",STR_PAD_LEFT));

                fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
                
                $PropinasEfectivo=$DatosCierres["PropinasEfectivo"];
                fwrite($handle,str_pad(substr(" PROPINAS EN EFECTIVO: ",0,24),24," ",STR_PAD_BOTH)."   ");

                fwrite($handle,str_pad("$".number_format($PropinasEfectivo),10," ",STR_PAD_LEFT));

                fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
                
                $PropinasTarjetas=$DatosCierres["PropinasTarjetas"];
                fwrite($handle,str_pad(substr(" PROPINAS EN TARJETAS: ",0,24),24," ",STR_PAD_BOTH)."   ");

                fwrite($handle,str_pad("$".number_format($PropinasTarjetas),10," ",STR_PAD_LEFT));

                fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
            }

            
            fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
            
            fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
            fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
            
            fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
            fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
            fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
            fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
            fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle, chr(29). chr(86). chr(49));//CORTA PAPEL
        }
        fclose($handle); // cierra el fichero PRN
        $salida = shell_exec('lpr $COMPrinter');
    }
    
    //Imprime cierre de modelos
   
    public function ImprimeComprobanteBajaAlta($idBaja,$COMPrinter,$Copias,$Vector) {
        $DatosImpresora=$this->DevuelveValores("config_puertos", "ID", 1);   
        if($DatosImpresora["Habilitado"]<>"SI"){
            return;
        }
        $COMPrinter= $this->COMPrinter;
        if(($handle = @fopen("$COMPrinter", "w")) === FALSE){
            die('ERROR:\nNo se puedo Imprimir, Verifique la conexion de la IMPRESORA');
        }
        $Titulo="Comprobante de Bajas O Altas No. $idBaja";
        $DatosComprobante=$this->DevuelveValores("prod_bajas_altas", "ID", $idBaja);
        $Fecha=$DatosComprobante["Fecha"];
        $Movimiento=$DatosComprobante["Movimiento"];
        $idUsuario=$DatosComprobante["Usuarios_idUsuarios"];
        
        
        for($i=1; $i<=$Copias;$i++){
        fwrite($handle,chr(27). chr(64));//REINICIO
        
        fwrite($handle, chr(27). chr(100). chr(0));// SALTO DE CARRO VACIO
        fwrite($handle, chr(27). chr(33). chr(8));// NEGRITA
        fwrite($handle, chr(27). chr(97). chr(1));// CENTRADO
        fwrite($handle,"*************************************");
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$Titulo); // Titulo
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,"*************************************");
        
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle, chr(27). chr(97). chr(0));// IZQUIERDA
        fwrite($handle,"FECHA: $Fecha");
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"*************************************");
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        
        //fwrite($handle,"Total Modelo: $DatosAgenda[HoraInicial] // ");
        fwrite($handle,"Referencia: ".$DatosComprobante["Referencia"]);
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,$DatosComprobante["Cantidad"]." / ".$DatosComprobante["Nombre"]);
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"Observaciones / ".$DatosComprobante["Observaciones"]);
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea    
        fwrite($handle,"Usuario / ".$DatosComprobante["Usuarios_idUsuarios"]);
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea    
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(29). chr(86). chr(49));//CORTA PAPEL
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
            
        
        
    }
    fclose($handle); // cierra el fichero PRN
    $salida = shell_exec('lpr $COMPrinter');
    }
    //Fin Clases
}