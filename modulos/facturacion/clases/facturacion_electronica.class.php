<?php
/* 
 * Clase que realiza los procesos de facturacion electronica
 * Julian Alvaran
 * Techno Soluciones SAS
 */

class Factura_Electronica extends ProcesoVenta{
    public function ConstruyaLayoutEmitirFactura($idFactura) {
        $DocumentoFE="FACTURA";
        $TipoDocumentoFE="INVOIC";
        $UserWebService="programacion@facturatech.co";
        $PassWebService="Demo.Col2018.1";
        $NitEmisor="901143311";
        $DVEmisor="07";
        $NitAdquiriente="94481747";
        $UBLVersion="UBL 2.0";
        $VersionFormatoDocumento="DIAN 1.0";
        $PrefijoFactura="PRUE";
        $NumeroFactura="980000513";
        $FacturaCompleta=$PrefijoFactura.$NumeroFactura;
        $FechaFactura="2018-11-30";
        $HoraFactura="09:19:19";
        $TipoFactura=1;//1 Factura 9 Nota Credito
        $MonedaFactura="COP";
        $FechaVencimiento="2018-12-30";
        $EmisorTipoPersona=3; //1 Juridica 2 Persona Natural
        $EmisorTipoDocumento=31; //Tabla tipos_documentos
        $EmisorNumTipoRegimen=2; //0 Simplificado 2 Comun 
        $EmisorRazonSocial="Ftech Colombia SAS";
        $EmisorDireccion="AvPoblado Cra 43 A 19 17";
        $EmisorDepartamento="ANTIOQUIA";
        $EmisorCiudad="MEDELLIN";
        $EmisorBarrio="MEDELLIN";
        $EmisorCodigoPais="CO";
        $EmisorPais="Colombia";
        //Actividades del RUT
        $TAC="      (TAC)

		TAC_1:O-42;

	(/TAC)

	(TAC)

		TAC_1:O-42;

	(/TAC)
                            ";
        $EmisorMatriculaMercantil="1234567";
        
        //Datos Adquiriente
        $AdqTipoPersona=2; //1 Juridica 2 Persona Natural
        $AdqNit="94481747";
        $AdqTipoDocumento=13;
        $adqNumTipoRegimen=0;


        $AdqRazonSocial="JULIAN ANDRES ALVARAN VALENCIA";
        $AdqNombres="JULIAN ANDRES";
        $adqApellidos="ALVARAN VALENCIA";

        $AdqDireccion="CALLE 19A 18-26";
        $AdqDepartamento="VALLE DEL CAUCA";
        $AdqBarrio="GUADALAJARA DE BUGA";
        $AdqCiudad="GUADALAJARA DE BUGA";
        $AdqCodigoPais="CO";
        $AdqCodigoComercio=0; //0 si se desconoce
        $AdqInfoTributariaAduana="O-99";  // O-99 si se desconoce
        $AdqContactoTipo=1; // 1 Persona de contacto, 2 de Entrega,3 de contabilidad, 4 de compras, 5 procesamiento del pedido
        $AdqContactoNombre="JULIAN ALVARAN";
        $AdqContactoTelefono="3177740609";
        $AdqContactoMail="jalvaran@gmail.com";
        
        //Totales de la factura
        
        $FacturaSubtotal=1000.00;
        $FacturaMonedaSubtotal="COP";
        $FacturaBaseImpuestos=1000.00;
        $FacturaMonedaBaseImpuestos="COP";
        $FacturaTotalSinImpuestosRetenidos=1190.00;
        $FacturaMonedaTotalSinImpuestosRetenidos="COP";
        $FacturaTotal=1190.00;
        $FacturaMonedaTotal="COP";
        $FacturaTotalDescuentos=0;
        $FacturaMonedaDescuentos="COP";
        $FacturaTotalCargos=0;
        $FacturaMonedaCargos="COP";
        
        //Impuestos
        
        $ImpuestosTipo="false";//false para IVA o ImpoConsumo
        $ImpuestosTotal=190.00;
        $ImpuestosMoneda="COP";
        $ImpuestosClase="01"; //01 IVA, 02 Impoconsumo, 03 ICA, 
        $ImpuestosBase=1000.00;
        $ImpuestosMonedaBase="COP";
        $ImpuestosTotalItemImpuesto=190.00;
        $ImpuestosPorcentaje="19.00";
        
        //Tasa de Cambio
        
        $TasaDeCambioModena="COP";
        $FactorTasaCambio=1;
        
        //Descuentos
        
        $DescuentoTipo="false"; //false descuento, true cargo
        $PorcentajeDescuento=0.0;
        $ValorDescuento=0.0;
        $ModedaDescuento="COP";
        $CodigoDescuento=19;
        $IndicadorSecuenciaCalculo=1;
        
        //Datos Resolucion
        
        $NumeroResolucion="9000000123973223";
        $FechaInicioResolucion="2018-01-11";
        $FechaFinResolucion="2028-01-11";
        $PrefijoResolucion="PRUE";
        $RangoInicialResolucion=980000000;
        $RangoFinalResolucion=985000000;
        
        //Total impuestos
        
        $TotalesImpuestos=190.00;
        $ImpuestosMoneda="COP";
        $TotalFactura=1000.00;
        $MonedaTotal="COP";
        
        //Notas legales
        
        $NotasLegales="IVA REGIMEN COMUN ACTIVIDAD ECONOMICA CIIU 8020";

        //Referencias, se refiere a los documentos enviados por el proveedor ejemplo cotizaciones, ordenes de compra, etc

        $ReferenciaTipo="IV";//IV factura,NC Nota Credito, ND Nota debito
        $NumReferencia="0000200216";
        $FechaDocumentoReferencia="2017-09-26";
        
        //Codigo de la plantailla, informacion para carvajal
        
        $CodigoPlantilla="CGEN01";
        
        
        $CodigoMonedaCambio="COP";
        $TotalImporteBrutoMonedaCambio=1000.00;

        //Items
        
        $ItemConsecutivo=1; //Consecutivo del item
        $TipoItem='false'; //true si el item es gratis, false si se cobra}
        $ItemCantidad=1.0;
        $UnidadMedida="ST"; //Ver tabla 12
        $TotalItem=1000.00;
        $MonedaItem="COP";
        $PrecioUnitarioItem=1000.00;
        $MonedaItem="COP";
        $ReferenciaItem="REF001";
        $NombreItem="Soporte Tecnico";
        $UnidadMedidaEmpaque="CR";
        $TotlItemConCargos=1000.00;
        
        //Descuentos items
        
        $ItemDescuentoTipo="false"; //false descuento,true cargo
        $TotalDescuentoItem=0.00;
        $MonedaDescuentoItem="COP";
        
        $param = array('LayOut' => "[".$NitEmisor."]
            [".$NitEmisor."-".$DVEmisor."]
            [NO]
            [".$DocumentoFE."]
            [".$UserWebService."]
            [".$PassWebService."]
            (ENC)

                    ENC_1:".$TipoDocumentoFE.";

                    ENC_2:".$NitEmisor.";  

                    ENC_3:".$NitAdquiriente.";  

                    ENC_4:".$UBLVersion.";

                    ENC_5:".$VersionFormatoDocumento.";

                    ENC_6:".$FacturaCompleta."; 

                    ENC_7:".$FechaFactura.";

                    ENC_8:".$HoraFactura.";

                    ENC_9:".$TipoFactura.";

                    ENC_10:".$MonedaFactura.";

                    ENC_16:".$FechaVencimiento.";
            (/ENC)

            (EMI)

                    EMI_1:".$EmisorTipoPersona.";

                    EMI_2:".$NitEmisor."; 

                    EMI_3:".$EmisorTipoDocumento.";

                    EMI_4:".$EmisorNumTipoRegimen.";

                    EMI_6:".$EmisorRazonSocial.";

                    EMI_10:".$EmisorDireccion.";

                    EMI_11:".$EmisorDepartamento.";

                    EMI_12:".$EmisorBarrio.";

                    EMI_13:".$EmisorCiudad.";

                    EMI_15:".$EmisorCodigoPais.";

                    EMI_19:".$EmisorDepartamento.";

                    EMI_20:".$EmisorCiudad.";

                    EMI_21:".$EmisorPais.";

                    ".$TAC."

                    (ICC)

                            ICC_1:".$EmisorMatriculaMercantil.";

                    (/ICC)

            (/EMI)

            (ADQ)

                    ADQ_1:".$AdqTipoPersona.";

                    ADQ_2:".$AdqNit.";

                    ADQ_3:".$AdqTipoDocumento.";

                    ADQ_4:".$adqNumTipoRegimen.";

                    ADQ_6:".$AdqRazonSocial.";

                    ADQ_8:".$AdqNombres.";

                    ADQ_9:".$adqApellidos.";

                    ADQ_10:".$AdqDireccion.";

                    ADQ_11:".$AdqDepartamento.";

                    ADQ_12:".$AdqBarrio.";

                    ADQ_13:".$AdqCiudad.";

                    ADQ_15:".$AdqCodigoPais.";

                    ADQ_17:".$AdqCodigoComercio.";

                    (TCR)

                            TCR_1:".$AdqInfoTributariaAduana.";

                    (/TCR)

                    (ICR/)
                    (CDA)
                            CDA_1:".$AdqContactoTipo.";
                            CDA_2:".$AdqContactoNombre.";
                            CDA_3:".$AdqContactoTelefono.";
                            CDA_4:".$AdqContactoMail.";
                    (/CDA)
            (/ADQ)

            (TOT)

                    TOT_1:".$FacturaSubtotal.";

                    TOT_2:".$FacturaMonedaSubtotal.";

                    TOT_3:".$FacturaBaseImpuestos.";

                    TOT_4:".$FacturaMonedaBaseImpuestos.";

                    TOT_5:".$FacturaTotalSinImpuestosRetenidos.";

                    TOT_6:".$FacturaMonedaTotalSinImpuestosRetenidos.";

                    TOT_7:".$FacturaTotal.";

                    TOT_8:".$FacturaMonedaTotal.";
                        
                    TOT_9:".$FacturaTotalDescuentos.";
                    
                    TOT_10:".$FacturaMonedaDescuentos.";
                    
                    TOT_11:".$FacturaTotalCargos.";

                    TOT_12:".$FacturaMonedaCargos.";

            (/TOT)

            (TIM)

                    TIM_1:".$ImpuestosTipo.";

                    TIM_2:".$ImpuestosTotal.";

                    TIM_3:".$ImpuestosMoneda.";

                    (IMP)

                            IMP_1:".$ImpuestosClase.";

                            IMP_2:".$ImpuestosBase.";

                            IMP_3:".$ImpuestosMonedaBase.";

                            IMP_4:".$ImpuestosTotalItemImpuesto.";

                            IMP_5:".$ImpuestosMoneda.";

                            IMP_6:".$ImpuestosPorcentaje.";

                    (/IMP)



            (/TIM)

            (TDC)

                    TDC_1:".$TasaDeCambioModena.";

                    TDC_2:".$TasaDeCambioModena.";

                    TDC_3:".$FactorTasaCambio.";

            (/TDC)

            (DSC)

                    DSC_1:".$DescuentoTipo.";

                    DSC_2:".$PorcentajeDescuento.";

                    DSC_3:".$ValorDescuento.";

                    DSC_4:".$ModedaDescuento.";
                    
                    DSC_5:".$CodigoDescuento.";

                    DSC_8:".$ModedaDescuento.";

                    DSC_9:".$IndicadorSecuenciaCalculo.";

            (/DSC)

            (DRF)

                    DRF_1:".$NumeroResolucion.";

                    DRF_2:".$FechaInicioResolucion.";

                    DRF_3:".$FechaFinResolucion.";

                    DRF_4:".$PrefijoResolucion.";

                    DRF_5:".$RangoInicialResolucion.";

                    DRF_6:".$RangoFinalResolucion.";      

            (/DRF)

            (ITD)

                    ITD_1:".$TotalesImpuestos.";

                    ITD_2:".$ImpuestosMoneda.";

                    ITD_5:".$TotalFactura.";

                    ITD_6:".$MonedaTotal.";

            (/ITD)

            (NOT)

                    NOT_1: ".$NotasLegales.";

            (/NOT)

            (REF)

                    REF_1:".$ReferenciaTipo.";

                    REF_2:".$NumReferencia.";

                    REF_3:".$FechaDocumentoReferencia.";

            (/REF)

            (CTS)

                    CTS_1:".$CodigoPlantilla.";

            (/CTS)
            
            (ITE)

                   ITE_1:".$ItemConsecutivo.";

                   ITE_2:".$TipoItem.";

                   ITE_3:".$ItemCantidad.";

                   ITE_4:".$UnidadMedida.";

                   ITE_5:".$TotalItem.";

                   ITE_6:".$MonedaItem.";

                   ITE_7:".$PrecioUnitarioItem.";

                   ITE_8:".$MonedaItem.";

                   ITE_11:".$ReferenciaItem.";

                   ITE_12:".$NombreItem.";

                   ITE_14:".$UnidadMedidaEmpaque.";

                   ITE_19:".$TotlItemConCargos.";

                   ITE_20:".$MonedaItem.";

                   ITE_21:".$TotalItem.";

                   ITE_22:".$MonedaItem.";


                   (IDE)

                       IDE_1:".$ItemDescuentoTipo.";

                       IDE_2:".$TotalDescuentoItem.";

                       IDE_3:".$MonedaDescuentoItem.";

                       IDE_8:".$MonedaDescuentoItem.";

                   (/IDE)

                   (/ITE)

            [/FACTURA]");
        
        
        $paramok = array('LayOut' => "[901143311]
[901143311-01]
[NO]
[FACTURA]
[programacion@facturatech.co]
[Demo.Col2018.1]
(ENC)

	ENC_1:INVOIC;

	ENC_2:901143311;  

	ENC_3:985499999;  

	ENC_4:UBL 2.0;

	ENC_5:DIAN 1.0;

	ENC_6:".$FacturaCompleta."; 

	ENC_7:2018-07-17;

	ENC_8:08:15:19;

	ENC_9:1;

	ENC_10:COP;

	ENC_16:2018-11-25;
(/ENC)

(EMI)

	EMI_1:3;

	EMI_2:901143311; 

	EMI_3:31;

	EMI_4:2;

	EMI_6:Ftech Colombia SAS;

	EMI_10:AvPoblado Cra 43 A 19 17;

	EMI_11:ANTIOQUIA;

	EMI_12:MEDELLIN;

	EMI_13:MEDELLIN;

	EMI_15:CO;

	EMI_19:ANTIOQUIA;

	EMI_20:MEDELLIN;

	EMI_21:Colombia;

	(TAC)

		TAC_1:O-42;

	(/TAC)

	(TAC)

		TAC_1:O-42;

	(/TAC)

	(ICC)

		ICC_1:1234567;

	(/ICC)

(/EMI)

(ADQ)

	ADQ_1:1;

	ADQ_2:985499999;

	ADQ_3:13;

	ADQ_4:2;

	ADQ_6:VANEGAS SOTO LUIS ALEJANDRO;

	ADQ_8:VANEGAS SOTO LUIS ALEJANDRO;

	ADQ_9:VANEGAS SOTO LUIS ALEJANDRO;

	ADQ_10:CL 34  25  44;

	ADQ_11:SANTANDER;

	ADQ_12:BUCARAMANGA;

	ADQ_13:BUCARAMANGA;

	ADQ_15:CO;

	ADQ_17:1234567;

	(TCR)

		TCR_1:O-99;

	(/TCR)

	(ICR/)
	(CDA)
		CDA_1:1;
		CDA_2:Test;
		CDA_3:9999999;
		CDA_4:carlosmario.ep@gmail.co;
	(/CDA)
(/ADQ)

(TOT)

	TOT_1:0.0;

	TOT_2:COP;

	TOT_3:1700.3;

	TOT_4:COP;

	TOT_5:2099.14;

	TOT_6:COP;

	TOT_7:2099.14;

	TOT_8:COP;

	TOT_10:COP;

	TOT_12:COP;

(/TOT)

(TIM)

	TIM_1:false;

	TIM_2:398.84;

	TIM_3:COP;

	(IMP)

		IMP_1:01;

		IMP_2:0.0;

		IMP_3:COP;

		IMP_4:0.0;

		IMP_5:COP;

		IMP_6:19.0;

	(/IMP)

	(IMP)

		IMP_1:01;

		IMP_2:850.15;

		IMP_3:COP;

		IMP_4:199.42;

		IMP_5:COP;

		IMP_6:19.0;

	(/IMP)

	(IMP)

		IMP_1:01;

		IMP_2:850.15;

		IMP_3:COP;

		IMP_4:199.42;

		IMP_5:COP;

		IMP_6:19.0;

	(/IMP)

(/TIM)

(TDC)

	TDC_1:COP;

	TDC_2:COP;

	TDC_3:1.0;

(/TDC)

(DSC)

	DSC_1:false;

	DSC_2:12.0;

	DSC_3:12.0;

	DSC_4:COP;

	DSC_5:19;

	DSC_8:COP;

	DSC_9:1;

(/DSC:

(DRF)

	DRF_1:9000000123973223;

	DRF_2:2018-01-11;

	DRF_3:2028-01-11;

	DRF_4:PRUE;

	DRF_5:980000000;

	DRF_6:985000000;      

(/DRF)

(ITD)

	ITD_1:398.84;

	ITD_2:COP;

	ITD_5:398.84;

	ITD_6:COP;

(/ITD)

(NOT)

	NOT_1: SOMOS AUTORETENEDORES RES 6777 JUL 28/2008, GRANDES CONTRIBUYENTES RES 7714 de 16 de Dic de 1998, NO EFECTUAR RETENCI?N SOBRE EL IVA IVA - REGIMEN COMUN;

(/NOT)

(REF)

	REF_1:IV;

	REF_2:0000200216;

	REF_3:2017-09-26;

(/REF)

(CTS)

	CTS_1:CGEN01;

(/CTS)

(FE1)

	FE1_1:                           1.00000;

	FE1_2:COP;

	FE1_3:1700.3;

	FE1_4:398.84;

	FE1_5:1700.3;

	(FT1)

		FT1_1:100;

		FT1_2:0.0;

		FT1_3:0.0;

	(/FT1)

	(FT1)

		FT1_1:101;

		FT1_2:1049.57;

		FT1_3:1049.57;

	(/FT1)

	(FT1)

		FT1_1:102;

		FT1_2:1049.57;

		FT1_3:1049.57;

	(/FT1)

(/FE1)

(ITE)

	ITE_1:101;

	ITE_2:true;

	ITE_3:1.0;

	ITE_4:ST;

	ITE_5:850.15;

	ITE_6:COP;

	ITE_7:850.15;

	ITE_8:COP;

	ITE_11:CINT_FEM_UNIFAZ_HEBILLA_ENGANCHE/ROJO/SM;

	ITE_12:CINT_FEM_UNIFAZ_HEBILLA_ENGANCHE/ROJO/SM;

	ITE_14:CR;

	ITE_19:850.15;

	ITE_20:COP;

	ITE_21:850.15;

	ITE_22:COP;

	(IDE)

		IDE_1:false;

		IDE_2:0.0;

		IDE_3:COP;

		IDE_8:COP;

	(/IDE)

(/ITE)

(ITE)

	ITE_1:102;

	ITE_2:true;

	ITE_3:1.0;

	ITE_4:ST;

	ITE_5:850.15;

	ITE_6:COP;

	ITE_7:850.15;

	ITE_8:COP;

	ITE_11:CINT_FEM_UNIFAZ_HEBILLA_ENGANCHE/ROJO/ME;

	ITE_12:CINT_FEM_UNIFAZ_HEBILLA_ENGANCHE/ROJO/ME;

	ITE_14:CR;

	ITE_19:850.15;

	ITE_20:COP;

	ITE_21:850.15;

	ITE_22:COP;

	(IDE)

		IDE_1:false;

		IDE_2:0.0;

		IDE_3:COP;

		IDE_8:COP;

	(/IDE)

	(IDE)

		IDE_1:false;

		IDE_2:0.0;

		IDE_3:COP;

		IDE_8:COP;

	(/IDE)

(/ITE)
[/FACTURA]");
        
        return($paramok);
    }
}