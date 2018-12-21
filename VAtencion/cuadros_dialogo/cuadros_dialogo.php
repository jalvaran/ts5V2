<?php

/* 
 * Archivo donde se incluye la creacion de cuadros de dialogo
 */

/////////////////Cuadro de dialogo de Clientes create
    $css->CrearCuadroDeDialogo("BtnNuevaSesion","Crear Nueva Sesion");
    
    $css->CrearForm2("FrmCrearNuevaSesion",$myPage,"post","_self");
    $css->CrearInputFecha("Fecha","TxtFechaSesion",date("Y-m-d"),100,30,"");
    echo '<br>';
    $VectorSel["Nombre"]="CmbTipoSesion";
    $VectorSel["Evento"]="";
    $VectorSel["Funcion"]="";
    $VectorSel["Required"]=1;
        $css->CrearSelect2($VectorSel);
        $css->CrearOptionSelect("", "Seleccione el tipo se Sesión", 0);
        $sql="SELECT * FROM concejo_tipo_sesiones";
        $Consulta=$obVenta->Query($sql);
           while($DatosTipoSesiones=$obVenta->FetchArray($Consulta)){
               
               $css->CrearOptionSelect($DatosTipoSesiones["Tipo"], $DatosTipoSesiones["Tipo"], 0);
           }
        $css->CerrarSelect();
        echo '<br>';
        
        $css->CrearInputText("TxtSesion","text","","","Nombre de la sesión","black","","",300,30,0,1);
        
        echo '<br>';
        $css->CrearBoton("BtnCrearSesion", "Crear Sesion");
    $css->CerrarForm();

$css->CerrarCuadroDeDialogo();      
