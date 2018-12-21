<?php

/* 
 * Archivo donde se incluyen las clases para crear un cuadro de dialogo para crear un cliente, un proveedor y realizar un egreso
 */

/////////////////Cuadro de dialogo de Clientes create
	 $css->CrearCuadroDeDialogo("DialCliente","Crear Crear Tercero"); 
	 
		 $css->CrearForm("FrmCrearCliente",$myPage,"post","_self");
		 $css->CrearSelect("CmbTipoDocumento","Oculta()");
		 $css->CrearOptionSelect('13','Cedula',1);
		 $css->CrearOptionSelect('31','NIT',0);
                 $css->CrearOptionSelect('12','Tarjeta Identidad',0);
                 $css->CrearOptionSelect('22','Cedula Extranjeria',0);
		 $css->CerrarSelect();
		 //$css->CrearInputText("CmbPreVentaAct","hidden","",$idPreventa,"","","","",0,0,0,0);
		 $css->CrearInputText("TxtNIT","number","","","Identificacion","black","","",200,30,0,1);
		 $css->CrearInputText("TxtPA","text","","","Primer Apellido","black","onkeyup","CreaRazonSocial()",200,30,0,0);
		 $css->CrearInputText("TxtSA","text","","","Segundo Apellido","black","onkeyup","CreaRazonSocial()",200,30,0,0);
		 $css->CrearInputText("TxtPN","text","","","Primer Nombre","black","onkeyup","CreaRazonSocial()",200,30,0,0);
		 $css->CrearInputText("TxtON","text","","","Otros Nombres","black","onkeyup","CreaRazonSocial()",200,30,0,0);
		 $css->CrearInputText("TxtRazonSocial","text","","","Razon Social","black","","",200,30,0,1);
		 $css->CrearInputText("TxtDireccion","text","","","Direccion","black","","",200,30,0,1);
		 $css->CrearInputText("TxtTelefono","text","","","Telefono","black","","",200,30,0,1);
                 
		 $css->CrearInputText("TxtEmail","text","","","Email","black","","",200,30,0,1);
                 $css->CrearInputText("TxtCupo","text","",0,"Cupo Credito","black","","",200,30,0,1);
                 $VarSelect["Ancho"]="200";
                 $VarSelect["PlaceHolder"]="Seleccione el municipio";
                 $css->CrearSelectChosen("CmbCodMunicipio", $VarSelect);
                 
                 $sql="SELECT * FROM cod_municipios_dptos";
                 $Consulta=$obVenta->Query($sql);
                    while($DatosMunicipios=$obVenta->FetchArray($Consulta)){
                        $Sel=0;
                        if($DatosMunicipios["ID"]==1011){
                            $Sel=1;
                        }
                        $css->CrearOptionSelect($DatosMunicipios["ID"], $DatosMunicipios["Ciudad"], $Sel);
                    }
                 $css->CerrarSelect();
                 echo '<br><br>';
		 $css->CrearBoton("BtnCrearCliente", "Crear Cliente");
		 $css->CerrarForm();
	 
	 $css->CerrarCuadroDeDialogo(); 
         
         
         /////////////////Cuadro de dialogo de separados
	 $css->CrearCuadroDeDialogo("DialSeparado","Crear Separado"); 
	 
	 $DatosPreventa=$obVenta->DevuelveValores("vestasactivas","idVestasActivas", $idPreventa);
	 
        $css->CrearForm2("FrmCrearSeparado",$myPage,"post","_self");
        $VarSelect["Ancho"]="200";
        $VarSelect["PlaceHolder"]="Seleccione un Cliente";
        $VarSelect["Required"]=1;
        $VarSelect["Title"]="Cliente: ";
        $css->CrearSelectChosen("CmbClientes", $VarSelect);

        $sql="SELECT * FROM clientes";
        $Consulta=$obVenta->Query($sql);
        $css->CrearOptionSelect("", "Seleccione Un Cliente" , 0);
           while($DatosCliente=$obVenta->FetchArray($Consulta)){
               
               $css->CrearOptionSelect($DatosCliente["idClientes"], "$DatosCliente[Num_Identificacion] - $DatosCliente[RazonSocial]" , 0);
           }
        $css->CerrarSelect();
        echo '<br><br>';
        $css->CrearInputText("CmbPreVentaAct","hidden","",$idPreventa,"","","","",0,0,0,0);
        $css->CrearInputNumber("TxtAbono","number","Abono:<br>","","Digite el abono del cliente","black","","",200,30,0,1,1,"","");
        
        $css->CrearBotonConfirmado("BtnCrearSeparado", "Crear Separado");
        $css->CerrarForm();
	 
	 $css->CerrarCuadroDeDialogo();
         
         
         /////////////////Cuadro de dialogo de egresos
	 $css->CrearCuadroDeDialogo("DialEgreso","Crear Egreso"); 
	 
	 	 
        $css->CrearForm2("FrmCrearEgreso",$myPage,"post","_self");
        $VarSelect["Ancho"]="200";
        $VarSelect["PlaceHolder"]="Seleccione el Egreso";
        $VarSelect["Required"]=1;
        $VarSelect["Title"]="Tipo de Egreso: ";
        $css->CrearSelectChosen("CmbCuentaDestino", $VarSelect);
        //$sql="SELECT * FROM cuentasfrecuentes WHERE ClaseCuenta='EGRESOS'";
        $sql="SELECT * FROM subcuentas WHERE PUC LIKE '5195%' OR PUC LIKE '5135%'";
        $Consulta=$obVenta->Query($sql);
        $css->CrearOptionSelect("", "Seleccione Un Tipo de Egreso" , 0);
           while($DatosEgresos=$obVenta->FetchArray($Consulta)){
                //$sql="SELECT * FROM cuentas WHERE idPUC ='$DatosEgresos[CuentaPUC]' LIMIT 1";
                //$Consulta2=$obVenta->Query($sql);
                //$DatosCuenta=$obVenta->FetchArray($Consulta2);
                
               $css->CrearOptionSelect($DatosEgresos["PUC"], "$DatosEgresos[Nombre]" , 0);
           }
        $css->CerrarSelect();
        echo '<br>';
        
        $VarSelect["Ancho"]="200";
        $VarSelect["PlaceHolder"]="Seleccione un Tercero";
        $VarSelect["Required"]=1;
        $VarSelect["Title"]="Tercero: ";
        $css->CrearSelectChosen("CmbProveedores", $VarSelect);

        $sql="SELECT * FROM proveedores";
        $Consulta=$obVenta->Query($sql);
        $css->CrearOptionSelect("", "Seleccione Un Tercero" , 0);
           while($DatosProveedor=$obVenta->FetchArray($Consulta)){
               
               $css->CrearOptionSelect($DatosProveedor["idProveedores"], "$DatosProveedor[Num_Identificacion] - $DatosProveedor[RazonSocial]" , 0);
           }
        $css->CerrarSelect();
        echo '<br><br>';
        
        $css->CrearInputText("CmbPreVentaAct","hidden","",$idPreventa,"","","","",0,0,0,0);
        $css->CrearTextArea("TxtConcepto","Concepto: <br>","","Concepto del Egreso","black","","",200,100,0,1);
        echo '<br>';
        $css->CrearInputText("TxtNumFactura","text","Numero de Soporte: <br>","","Numero de Soporte","black","","",200,30,0,1);
        echo '<br>';
        $css->CrearUpload("foto");
        echo '<br>';
        $css->CrearInputNumber("TxtSubtotalEgreso","number","Subtotal:<br>",0,"Subtotal","black","onkeyup","CalculeTotalEgresosVR()",200,30,0,1,1,'',"");
        echo '<br>';
        $css->CrearInputNumber("TxtIVAEgreso","number","IVA:<br>",0,"IVA","black","onkeyup","CalculeTotalEgresosVR()",200,30,0,1,0,'',"");
        echo '<br>';
        $css->CrearInputNumber("TxtValorEgreso","number","Total:<br>","","Total","black","","",200,30,1,1,1,1,1);
        echo '<br>';
        
        $css->CrearBotonConfirmado("BtnCrearEgreso", "Crear Egreso");
        $css->CerrarForm();
	 
	 $css->CerrarCuadroDeDialogo();