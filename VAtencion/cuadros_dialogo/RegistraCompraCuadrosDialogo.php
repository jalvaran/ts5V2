<?php

/* 
 * Archivo donde se incluyen las clases para crear un cuadro de dialogo para crear un cliente, un proveedor y realizar un egreso
 */
//Creo los cuadros de dialogo
     /////////////////Cuadro de dialogo de Clientes create
$css->CrearCuadroDeDialogo("Proveedor","Crear Tercero"); 
$css->CrearForm("FrmCrearCliente",$myPage,"post","_self");
        $css->CrearSelect("CmbTipoDocumento","Oculta()");
        $css->CrearOptionSelect('13','Cedula',1);
        $css->CrearOptionSelect('31','NIT',0);
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
        //echo "<div style='width: 500px;display:block;position: relative;margin: 10px; height:300px;'>";
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

        $css->CrearBoton("BtnCrearProveedor", "Crear Tercero");
        $css->CerrarForm();
    $css->CerrarCuadroDeDialogo(); 

    $css->CrearCuadroDeDialogo("CrearCompra","Crear una compra"); 
        $css->CrearForm2("FrmCreaCompra", $myPage, "post", "_self");
        $css->CrearTabla();
        $css->FilaTabla(16);
            $css->ColTabla("<strong>Fecha</strong>", 1);
            $css->ColTabla("<strong>Tercero</strong>", 1);
            
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
        print("<td>");
        $css->CrearInputFecha("", "TxtFecha", date("Y-m-d"), 100, 30, "");
        
        print("</td>");        
         print("<td>");
            $VarSelect["Ancho"]="200";
            $VarSelect["PlaceHolder"]="Seleccione el tercero";
            $css->CrearSelectChosen("TxtTerceroCI", $VarSelect);

            $sql="SELECT * FROM proveedores";
            $Consulta=$obVenta->Query($sql);
               while($DatosProveedores=$obVenta->FetchArray($Consulta)){
                   $Sel=0;
                   
                   $css->CrearOptionSelect($DatosProveedores["Num_Identificacion"], "$DatosProveedores[RazonSocial] $DatosProveedores[Num_Identificacion]" , $Sel);
               }
            $css->CerrarSelect();
        print("</td>"); 
       
        $css->CierraFilaTabla();
        $css->FilaTabla(16); 
       
            $css->ColTabla("<strong>CentroCosto</strong>", 1);
            
            $css->ColTabla("<strong>Crear</strong>", 1);
            
            
        $css->CierraFilaTabla();
        
         print("<td>");
        
        $css->CrearSelect("CmbCentroCosto"," Centro de Costos:<br>","black","",1);
        //$this->css->CrearOptionSelect("","Seleccionar Centro de Costos",0);

        $Consulta = $obVenta->ConsultarTabla("centrocosto","");
        while($CentroCosto=$obVenta->FetchArray($Consulta)){
                        $css->CrearOptionSelect($CentroCosto['ID'],$CentroCosto['Nombre'],0);							
        }
        $css->CerrarSelect();
         print("<br>");
        $css->CrearSelect("idSucursal"," Sucursal:<br>","black","",1);
        //$this->css->CrearOptionSelect("","Seleccionar Sucursal",0);

        $Consulta = $obVenta->ConsultarTabla("empresa_pro_sucursales","");
        while($CentroCosto=$obVenta->FetchArray($Consulta)){
                        $css->CrearOptionSelect($CentroCosto['ID'],$CentroCosto['Nombre'],0);							
        }
        $css->CerrarSelect();
        print("<br>");
        $css->CrearTextArea("TxtConcepto", "", "", "Concepto", "", "", "", 200, 60, 0, 1);
        print("</td>"); 
               
        print("<td>");
        $css->CrearSelect("TipoCompra", "");
            $css->CrearOptionSelect("FC", "FC", 1);
            $css->CrearOptionSelect("RM", "RM", 0);
        $css->CerrarSelect();
        echo"<br>";
        $css->CrearInputText("TxtNumFactura","text",'Numero de Comprobante:<br>',"","Numero de Comprobante","black","","",220,30,0,1);
        echo"<br>";
        $css->CrearUpload("foto");
        $css->CrearBotonConfirmado("BtnCrearCompra", "Crear");
        print("</td>");   
        $css->CierraFilaTabla();
    $css->CerrarTabla();
    $css->CerrarForm();
    $css->CerrarCuadroDeDialogo(); 
    
    //Fin Cuadros de Dialogo