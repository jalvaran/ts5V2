<?php 
$myPage="CreacionConceptos.php";
include_once("../sesiones/php_control.php");

$obVenta = new ProcesoVenta($idUser);
$obTabla = new Tabla($db);
$idConcepto=0;
if(isset($_REQUEST["CmbConcepto"])){
    $idConcepto=$obVenta->normalizar($_REQUEST["CmbConcepto"]);
}
if(isset($_REQUEST["BtnCopiarConcepto"])){
    
    $idConcepto=$obVenta->normalizar($_REQUEST["CmbConcepto"]);
    $idConcepto=$obVenta->CopiarConceptoContable($idConcepto,"");
}
include_once("css_construct.php");

print("<html>");
print("<head>");
$css =  new CssIni("Creacion de Parametros Contables");

print("</head>");

print("<body>");
    
$css->CabeceraIni("Creacion de Parametros Contables"); //Inicia la cabecera de la pagin   
$css->CreaBotonDesplegable("CrearConcepto","Nuevo");
$css->CabeceraFin(); 

//Cuadros de Dialogo

 /////////////////Cuadro de dialogo de Concepto
$css->CrearCuadroDeDialogo("CrearConcepto","Crear un Concepto"); 
    $css->CrearForm2("FrmCreaConcepto", $myPage, "post", "_self");
    $css->CrearTabla();
    $css->FilaTabla(16);
        $css->ColTabla("<strong>Nombre</strong>", 1);
        $css->ColTabla("<strong>Observaciones</strong>", 1);
        $css->ColTabla("<strong>Documento que Genera</strong>", 1);
        $css->ColTabla("<strong>Crear</strong>", 1);
    $css->CierraFilaTabla();
    $css->FilaTabla(16);
    print("<td>");
    
    $css->CrearInputText("TxtNombreNuevoConcepto", "text", "", "", "Nombre", "", "", "", 200, 30, 0, 1);
    
    print("</td>");        

    print("<td>");
    $css->CrearTextArea("TxtObservacionesNuevoConcepto","","","Observaciones","black","","",200,100,0,1);
    print("</td>");
    print("<td>");
    $css->CrearSelect("CmbDocumentoGenerado", "");
    $css->CrearOptionSelect("", "Seleccione", 0);
    $css->CrearOptionSelect("CE", "Comprobante de Egreso", 0);
    $css->CrearOptionSelect("CC", "Comprobante Contable", 0);
    $css->CerrarSelect();
    print("</td>"); 
    print("<td>");
    $css->CrearBotonConfirmado("BtnCrearConcepto", "Crear");
    print("</td>");   
    $css->CierraFilaTabla();
$css->CerrarTabla();
$css->CerrarForm(); 
$css->CerrarCuadroDeDialogo(); 
    
    ///////////////Creamos el contenedor
    /////
    /////
    $css->CrearDiv("principal", "container", "center",1,1);

//Select con la seleccion del Concepto

$css->CrearForm2("FrmSeleccionaConcepto", $myPage, "post", "_self");
    
    $css->CrearTabla();
    $css->FilaTabla(16);
    print("<td style='text-align:center'>");
    
        $css->CrearSelect("CmbConcepto", "EnviaForm('FrmSeleccionaConcepto')");
        
            $css->CrearOptionSelect("","Selecciona un Concepto",0);
            
            $consulta = $obVenta->ConsultarTabla("conceptos","WHERE Completo='NO'");
            while($DatosConcepto=$obVenta->FetchArray($consulta)){
                if($idConcepto==$DatosConcepto['ID']){
                    $Sel=1;
                    
                }else{
                    
                    $Sel=0;
                }
                $css->CrearOptionSelect($DatosConcepto['ID'],$DatosConcepto['ID']." ".$DatosConcepto['Nombre'],$Sel);							
            }
        $css->CerrarSelect();
    print("</td>");
    $css->CierraFilaTabla();
    $css->CerrarTabla();
    $css->CerrarForm();    
    
    
    include_once("procesadores/procesaCreacionConceptos.php");
    ///////////////Creamos la imagen representativa de la pagina
    /////
    /////
    if($idConcepto==0){
        $css->CrearImageLink("../VMenu/MnuAjustes.php", "../images/conceptos.png", "_self",200,200);
    }
    
    ///////////////Se crea el DIV que servirá de contenedor secundario
    /////
    /////
    $css->CrearDiv("Secundario", "container", "center",1,1);
    
    if($idConcepto>0){
        $DatosConcepto=$obVenta->DevuelveValores("conceptos", "ID", $idConcepto);
        
        $css->CrearForm2("FrmEditaConcepto", $myPage, "post", "_self");
        $css->CrearInputText("CmbConcepto", "hidden", "", $idConcepto, "", "", "", "", "", "", "", "");
        $css->CrearTabla();
        
        $css->FilaTabla(16);
        $css->ColTabla("<strong>Nombre</strong>", 1);
        $css->ColTabla("<strong>Observaciones</strong>", 1);
        $css->ColTabla("<strong>Documento que genera</strong>", 1);
        $css->ColTabla("<strong>Editar</strong>", 1);
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
        print("<td>");
        $css->CrearInputText("TxtNombreConceptoEdit", "text", "", $DatosConcepto["Nombre"], "Nombre", "", "", "", 200, 30, 0, 1);
        
        print("</td>");
        print("<td>");
        $css->CrearTextArea("TxtObservacionesConceptoEdit", "", $DatosConcepto["Observaciones"], "Observaciones", "", "", "", 200, 60, 0, 1);
        print("</td>");
        
         print("<td>");
        $css->CrearSelect("CmbDocumentoGeneradoEdit", "");
        $Sel=0;
        
        if($DatosConcepto["Genera"]=="CE"){
            $Sel=1;
        }
        $css->CrearOptionSelect("CE", "Comprobante de Egreso", $Sel);
        $Sel=0;
        if($DatosConcepto["Genera"]=="CC"){
            $Sel=1;
        }
        $css->CrearOptionSelect("CC", "Comprobante Contable", $Sel);
        $css->CerrarSelect();
        print("</td>"); 
        print("<td>"); 
        $css->CrearBotonConfirmado("BtnEditarConcepto", "Editar");
        print("</td>");
        $css->CierraFilaTabla();
        $css->CerrarTabla();
        $css->CerrarForm();
        $css->CrearForm2("FrmAgregaMonto", $myPage, "post", "_self");
        $css->CrearInputText("CmbConcepto", "hidden", "", $idConcepto, "", "", "", "", "", "", "", "");
        $css->CrearNotificacionAzul("Agregue Montos al Concepto $idConcepto $DatosConcepto[Nombre]", 16);
        $css->CrearTabla();
        $css->FilaTabla(16);
        $css->ColTabla("<strong>Agregar un Monto</strong>", 5);
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
        $css->ColTabla("<strong>Nombre</strong>", 1);
        $css->ColTabla("<strong>Dependencia</strong>", 1);
        $css->ColTabla("<strong>Operacion</strong>", 1);
        $css->ColTabla("<strong>Valor de la dependencia</strong>", 1);
        $css->ColTabla("<strong>Agregar</strong>", 1);
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
        print("<td>");
        $css->CrearInputText("TxtMonto", "text", "", "", "Nombre", "", "", "", 200, 30, 0, 1);
        print("</td>");
        print("<td>");
        $css->CrearSelect("CmbDependencia", "");
            $css->CrearOptionSelect("NO", "Sin Dependencia", 1);
            $Consulta=$obVenta->ConsultarTabla("conceptos_montos", "WHERE idConcepto='$idConcepto'");
            while($DatosMontos=$obVenta->FetchArray($Consulta)){
                $css->CrearOptionSelect($DatosMontos["ID"], $DatosMontos["NombreMonto"], 0);
            }        
            
        $css->CerrarSelect();
        print("</td>");
        print("<td>");
        $css->CrearSelect("CmbOperacion", "");
            $css->CrearOptionSelect("NO", "Sin Operacion", 1);
            $css->CrearOptionSelect("P", "Porcentaje", 0);
            $css->CrearOptionSelect("S", "Suma", 0);
            $css->CrearOptionSelect("R", "Resta", 0);
            
        $css->CerrarSelect();
        print("</td>");
        print("<td>");
        $css->CrearInputNumber("TxtValorDependencia", "number", "", 0, "Valor Depencia", "", "", "", 100, 30, 0, 0, 0, "", 1);
        print("</td>");
        print("<td>");
        $css->CrearBotonConfirmado("BtnCrearMonto", "Agregar");
        print("</td>");
        $css->CierraFilaTabla();
        $css->CerrarTabla();
        $css->CerrarForm();
        
        ///Visualizamos los montos creados
        
        //Se miran los montos del concepto
                       
        $Consulta=$obVenta->ConsultarTabla("conceptos_montos", "WHERE idConcepto='$idConcepto'");
        if($obVenta->NumRows($Consulta)){
            $css->CrearTabla();
            $css->FilaTabla(16);
            $css->ColTabla("<strong>Montos de este Concepto</strong>", 5);
            $css->CierraFilaTabla();
            $css->FilaTabla(16);
            $css->ColTabla("<strong>Monto</strong>", 1);
            $css->ColTabla("<strong>Dependencia</strong>", 1);
            $css->ColTabla("<strong>Operacion</strong>", 1);
            $css->ColTabla("<strong>ValorDepencia</strong>", 1);
            $css->ColTabla("<strong>Eliminar</strong>", 1);
            
            $css->CierraFilaTabla();
        while($DatosMontos=$obVenta->FetchArray($Consulta)){
            $css->FilaTabla(14);
            
            $css->ColTabla("$DatosMontos[NombreMonto]", 1);
            print("<td>");
            $css->CrearForm2("FrmEditaMontos", $myPage, "post", "_self");
            $css->CrearInputText("CmbConcepto", "hidden", "", $idConcepto, "", "", "", "", "", "", "", "");
            $css->CrearInputText("idMonto", "hidden", "", $DatosMontos["ID"], "", "", "", "", "", "", "", "");
            
            $css->CrearSelect("CmbDependenciaMontoEdit", "");
            $css->CrearOptionSelect("NO", "Sin Dependencia", 1);
            $ConsultaMontosExistentes=$obVenta->ConsultarTabla("conceptos_montos", "WHERE idConcepto='$idConcepto'");
            while($DatosMontosExistentes=$obVenta->FetchArray($ConsultaMontosExistentes)){
                $sel=0;
                if($DatosMontosExistentes["Depende"]==$DatosMontos["ID"]){
                    $sel=1;
                }
                           
                $css->CrearOptionSelect($DatosMontosExistentes["ID"], $DatosMontosExistentes["NombreMonto"], $sel);
            }        
            
            $css->CerrarSelect();
            
            $css->CrearBotonVerde("BtnEditarMonto", "E");
            $css->CerrarForm();
            print("</td>");
            print("<td>");
            $css->CrearForm2("FrmEditaMontosOperacion", $myPage, "post", "_self");
            $css->CrearInputText("CmbConcepto", "hidden", "", $idConcepto, "", "", "", "", "", "", "", "");
            $css->CrearInputText("idMonto", "hidden", "", $DatosMontos["ID"], "", "", "", "", "", "", "", "");
            
            $css->CrearSelect("CmbOperacionEdit", "");
            $css->CrearOptionSelect("NO", "Sin Operacion", 1);
            $sel=0;
            if($DatosMontos["Operacion"]=="P"){
                $sel=1;
            }
            $css->CrearOptionSelect("P", "Porcentaje", $sel);
            $sel=0;
            if($DatosMontos["Operacion"]=="S"){
                $sel=1;
            }
            $css->CrearOptionSelect("S", "Suma", $sel);
            $sel=0;
            if($DatosMontos["Operacion"]=="R"){
                $sel=1;
            }
            $css->CrearOptionSelect("R", "Resta", $sel);
            $css->CerrarSelect();
            
            $css->CrearBotonVerde("BtnEditarMonto", "E");
            $css->CerrarForm();
            print("</td>");
            
             print("<td>");
            $css->CrearForm2("FrmEditaValorDependencia", $myPage, "post", "_self");
            $css->CrearInputText("CmbConcepto", "hidden", "", $idConcepto, "", "", "", "", "", "", "", "");
            $css->CrearInputText("idMonto", "hidden", "", $DatosMontos["ID"], "", "", "", "", "", "", "", "");
            
            $css->CrearInputNumber("TxtValorDependenciaEdt", "number", "", $DatosMontos["ValorDependencia"], "Valor", "", "", "", 100, 30, 0, 1, 0, "", "any");
            
            $css->CrearBotonVerde("BtnEditarValorDependencia", "E");
            $css->CerrarForm();
            print("</td>");
            
            $css->ColTablaDel($myPage, "conceptos_montos", "ID", $DatosMontos["ID"], $idConcepto);
            
            $css->CierraFilaTabla();
        }
        $css->CerrarTabla();
        }
        ///Visualizamos los movimientos que tenemos creados
        
        $css->CrearNotificacionAzul("Movimientos creados al Concepto $idConcepto $DatosConcepto[Nombre]", 16);
        ///Agregamos un Movimiento
        
        $css->CrearForm2("FrmAgregaMovimiento", $myPage, "post", "_self");
        $css->CrearInputText("CmbConcepto", "hidden", "", $idConcepto, "", "", "", "", "", "", "", "");
        $css->CrearTabla();
        $css->FilaTabla(16);
        $css->ColTabla("<strong>Agregar un Movimiento</strong>", 5);
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
        $css->ColTabla("<strong>Monto</strong>", 1);
        $css->ColTabla("<strong>CuentaPUC</strong>", 1);
        $css->ColTabla("<strong>Tipo de Movimiento</strong>", 1);
        $css->ColTabla("<strong>Agregar</strong>", 1);
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
        
        print("<td>");
        $css->CrearSelect("CmbMonto", "");
            $css->CrearOptionSelect("", "Elija un Monto", 0);
            $Consulta=$obVenta->ConsultarTabla("conceptos_montos", "WHERE idConcepto='$idConcepto'");
            while($DatosMontos=$obVenta->FetchArray($Consulta)){
                $css->CrearOptionSelect($DatosMontos["ID"], $DatosMontos["NombreMonto"], 0);
            }        
            
        $css->CerrarSelect();
        print("</td>");
        print("<td>");
            $VarSelect["Ancho"]="200";
            $VarSelect["PlaceHolder"]="Seleccione la cuenta";
            $css->CrearSelectChosen("CmbCuentaMovimiento", $VarSelect);
            $css->CrearOptionSelect("", "Seleccione la cuenta del movimiento" , 0);
            
            //Solo para cuando el PUC no está todo en subcuentas
            $sql="SELECT * FROM cuentas";
            $Consulta=$obVenta->Query($sql);
            
               while($DatosProveedores=$obVenta->FetchArray($Consulta)){
                   $Sel=0;
                   $NombreCuenta=str_replace(" ","_",$DatosProveedores['Nombre']);
                   $css->CrearOptionSelect($DatosProveedores['idPUC'].';'.$NombreCuenta, "$DatosProveedores[idPUC] $DatosProveedores[Nombre]" , $Sel);
               }
            
            //En subcuentas se debera cargar todo el PUC
            $sql="SELECT * FROM subcuentas";
            $Consulta=$obVenta->Query($sql);
            
               while($DatosProveedores=$obVenta->FetchArray($Consulta)){
                   $Sel=0;
                   $NombreCuenta=str_replace(" ","_",$DatosProveedores['Nombre']);
                   $css->CrearOptionSelect($DatosProveedores['PUC'].';'.$NombreCuenta, "$DatosProveedores[PUC] $DatosProveedores[Nombre]" , $Sel);
               }
               
            //En subcuentas se debera cargar todo el PUC
            $sql="SELECT * FROM cuentasfrecuentes";
            $Consulta=$obVenta->Query($sql);
            
               while($DatosProveedores=$obVenta->FetchArray($Consulta)){
                   $Sel=0;
                   $NombreCuenta=str_replace(" ","_",$DatosProveedores['Nombre']);
                   $css->CrearOptionSelect($DatosProveedores['CuentaPUC'].';'.$NombreCuenta, "$DatosProveedores[CuentaPUC] $DatosProveedores[Nombre]" , $Sel);
               }   
            
            $css->CerrarSelect();
        print("</td>");
        print("<td>");
        $css->CrearSelect("CmbTipoMovimiento", "");
            $css->CrearOptionSelect("", "Seleccione", 0);
            $css->CrearOptionSelect("DB", "Debito", 0);
            $css->CrearOptionSelect("CR", "Credito", 0);
                        
        $css->CerrarSelect();
        print("</td>");
        print("<td>");
        $css->CrearBotonConfirmado("BtnCrearMovimiento", "Crear Movimiento");
        print("</td>");
        $css->CierraFilaTabla();
        $css->CerrarTabla();
        $css->CerrarForm();
        
        
        //Se miran los movimimientos del concepto
                       
        $Consulta=$obVenta->ConsultarTabla("conceptos_movimientos", "WHERE idConcepto='$idConcepto'");
        if($obVenta->NumRows($Consulta)){
            $css->CrearTabla();
            $css->FilaTabla(16);
            $css->ColTabla("<strong>Movimientos de este Concepto</strong>", 5);
            $css->CierraFilaTabla();
            $css->FilaTabla(16);
            $css->ColTabla("<strong>Monto</strong>", 1);
            $css->ColTabla("<strong>Cuenta</strong>", 1);
            $css->ColTabla("<strong>NombreCuenta</strong>", 1);
            $css->ColTabla("<strong>Debito</strong>", 1);
            $css->ColTabla("<strong>Credito</strong>", 1);
            $css->ColTabla("<strong>Borrar</strong>", 1);
            $css->CierraFilaTabla();
        while($DatosMovimientos=$obVenta->FetchArray($Consulta)){
            $css->FilaTabla(14);
            $Montos=$obVenta->DevuelveValores("conceptos_montos", "ID", $DatosMovimientos["idMonto"]);
            if($DatosMovimientos["TipoMovimiento"]=="CR"){
                $Credito="X";
                $Debito="";
            }else{
                $Credito="";
                $Debito="X";
            }
            $css->ColTabla("$Montos[NombreMonto]", 1);
            print("<td>");
            $css->CrearForm2("FrmEditaCuentaPUC", $myPage, "post", "_self");
            $css->CrearInputText("CmbConcepto", "hidden", "", $idConcepto, "", "", "", "", "", "", "", "");
            $css->CrearInputText("idMovimiento", "hidden", "", $DatosMovimientos["ID"], "", "", "", "", "", "", "", "");
            $css->CrearInputNumber("TxtCuentaPUCEdit", "number", "", $DatosMovimientos["CuentaPUC"], "CuentaPUC", "", "", "", 100, 30, 0, 1, 0, "", 1);
            $css->CrearBotonVerde("BtnEditarCuentaPUC", "E");
            $css->CerrarForm();
            print("</td>");
            print("<td>");
            $css->CrearForm2("FrmEditaNombreCuentaPUC", $myPage, "post", "_self");
            $css->CrearInputText("idMovimiento", "hidden", "", $DatosMovimientos["ID"], "", "", "", "", "", "", "", "");
            $css->CrearInputText("CmbConcepto", "hidden", "", $idConcepto, "", "", "", "", "", "", "", "");
            $css->CrearInputText("TxtNombreCuentaEdit", "text", "", $DatosMovimientos["NombreCuentaPUC"], "Nombre de la Cuenta", "", "", "", 200, 30, 0, 1);
            $css->CrearSelect("CmbTipoMovimiento", "");
            $selDB=0;
            $selCR=0;
            if($DatosMovimientos["TipoMovimiento"]=="DB"){
               $selDB=1;
            }
            if($DatosMovimientos["TipoMovimiento"]=="CR"){
               $selCR=1;
            }
            $css->CrearOptionSelect("DB", "Debito", $selDB);
            $css->CrearOptionSelect("CR", "Credito", $selCR);
            $css->CerrarSelect();
            $css->CrearBotonVerde("BtnEditarNombreCuentaPUC", "E");
            $css->CerrarForm();
            print("</td>");
            $css->ColTabla($Debito, 1);
            $css->ColTabla($Credito, 1);
            $css->ColTablaDel($myPage, "conceptos_movimientos", "ID", $DatosMovimientos["ID"], $idConcepto);
            
            $css->CierraFilaTabla();
        }
        $css->FilaTabla(14);
        print("<td style='text-align:center'; colspan=6>");
        $css->CrearForm2("FrmEditaMovimientos", $myPage, "post", "_self");
        $css->CrearInputText("CmbConcepto", "hidden", "", $idConcepto, "", "", "", "", "", "", "", "");
        $css->CrearBotonConfirmado("BtnCerrarConcepto", "Cerrar y Activar este Concepto");
        $css->CerrarForm();
        print("</td>");
        $css->CierraFilaTabla();
        $css->CerrarTabla();
        
        }else{
            $css->CrearNotificacionRoja("No hay movimientos", 16);
        }    
        
        
        
    }
    
    
    $css->CerrarDiv();//Cerramos contenedor Secundario
    $css->CerrarDiv();//Cerramos contenedor Principal
    $css->AgregaJS(); //Agregamos javascripts
    $css->AgregaSubir();
    $css->Footer();
    print("</body></html>");
?>