<?php

/* 
 * Archivo donde se incluyen las clases para crear un cuadro de dialogo para crear un cliente, un proveedor y realizar un egreso
 */
//Creo los cuadros de dialogo

   

    $css->CrearCuadroDeDialogo("CrearNota","Crear una Nota de devolucion"); 
        $css->CrearForm2("FrmCrearNota", $myPage, "post", "_self");
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
            $css->CrearBotonConfirmado("BtnCrear","Crear");
        print("</td>"); 
        
        $css->CierraFilaTabla();
    $css->CerrarTabla();
    $css->CerrarForm();
    $css->CerrarCuadroDeDialogo(); 
    
    //Fin Cuadros de Dialogo