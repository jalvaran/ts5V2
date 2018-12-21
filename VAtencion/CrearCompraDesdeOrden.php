<?php 
$myPage="CrearCompraDesdeOrden.php";
include_once("../sesiones/php_control.php");
include_once("clases/ClasesCompras.php");
include_once("css_construct.php");
$obVenta = new ProcesoVenta($idUser);
//////Si recibo un cliente
if(!empty($_REQUEST['idOrden'])){

        $idOrden=$obVenta->normalizar($_REQUEST['idOrden']);
}

	
print("<html>");
print("<head>");
$css =  new CssIni("Crear Compra desde Orden de Compra");

print("</head>");
print("<body>");
    
        
    $css->CabeceraIni("Crear Compra desde Orden de Compra"); //Inicia la cabecera de la pagina
    
    //////////Creamos el formulario de busqueda de remisiones
    /////
    /////
    
   
    
    $css->CabeceraFin(); 
    ///////////////Creamos el contenedor
    /////
    /////
    $css->CrearDiv("principal", "container", "center",1,1);
    print("<br>");
    ///////////////Creamos la imagen representativa de la pagina
    /////
    /////	
    $css->CrearNotificacionAzul("Crear Compra desde la orden $idOrden", 16);
    $css->CrearForm2("FrmCreaCompra", "RegistraCompra.php", "post", "_self");
        $css->CrearInputText("TxtIdOrdenOrdenCompra", "hidden", "", $idOrden, "", "", "", "", "", "", 1, 0);
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
            $VarSelect["Ancho"]="400";
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
    
    
    $css->CerrarDiv();//Cerramos contenedor Secundario
    $css->CerrarDiv();//Cerramos contenedor Principal
    $css->AgregaJS(); //Agregamos javascripts
    $css->AgregaSubir();
    $css->Footer();
    print("</body></html>");
    ob_end_flush();
?>