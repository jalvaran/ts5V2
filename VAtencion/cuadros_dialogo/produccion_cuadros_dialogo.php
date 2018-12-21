<?php

/* 
 * Archivo donde se incluye la creacion de cuadros de dialogo
 */

$Titulo="Crear Actividad";
    $Nombre="ImgCrearActividad";
    $RutaImage="../images/pop_servicios.png";
    $javascript="";
    $VectorBim["f"]=0;
    $target="#DialCrearActividad";
    $css->CrearBotonImagen($Titulo,$Nombre,$target,$RutaImage,"",1,1,"fixed","left:10px;top:50",$VectorBim);
    
    $Titulo="Editar Actividad";
    $Nombre="ImgEditarActividad";
    $RutaImage="../images/pop_servicios.png";
    $javascript="";
    $VectorBim["f"]=0;
    $target="#DialEditarActividad";
    $css->CrearBotonImagen($Titulo,$Nombre,$target,$RutaImage,"",1,1,"fixed","left:10px;top:60",$VectorBim);
    
    $VectorCDC["F"]=0;
    $idEdit=0;
    if(isset($_REQUEST["TxtFechaCronograma"]) ){
        $FechaActual=$_REQUEST["TxtFechaCronograma"];
    }else{
        $FechaActual=date("Y-m-d");
    }
    if(isset($_REQUEST["idEdit"])){
        $idEdit=$_REQUEST["idEdit"];
    }
    $idOT=0;
    $idMaquina=0;
    if(isset($_REQUEST["idOT"]) ){
        $idOT=$_REQUEST["idOT"];
    }
    if(isset($_REQUEST["idMaquina"]) ){
        $idMaquina=$_REQUEST["idMaquina"];
    }
    $NombreDia=date("l", strtotime("$FechaActual"));
    $DiaMes=date("d", strtotime("$FechaActual"));
    $NombreMes=date("F", strtotime("$FechaActual"));
    $Anio=date("Y", strtotime("$FechaActual"));
    $Titulo=$NombreDia.", ".$DiaMes.", ".$NombreMes." ".$Anio;
    
    
    //Creamos El dialogo para crear y editar  una actividad
    if($idMaquina>0){
    /////////////////Cuadro de dialogo de creacion de actividades
        $FechaInicioPlaneado=$_REQUEST["TxtFechaCronograma"];
        $HoraInicioPlaneado=$_REQUEST["TxtHoraIni"];
        
        $DatosMaquina=$obVenta->DevuelveValores("maquinas", "ID", $idMaquina);
        $DatosOT=$obVenta->DevuelveValores("produccion_ordenes_trabajo", "ID", $idOT);
	$css->CrearCuadroDeDialogo("DialCrearActividad","Crear Actividad para la OT $idOT Descripcion: $DatosOT[Descripcion], Maquina: $DatosMaquina[Nombre]"); 
	 
        $css->CrearForm2("FrmCrearActividad",$myPage,"post","_self");
        $css->CrearInputText("idOT","hidden","",$idOT,"","","","",0,0,0,0);
        $css->CrearInputText("idMaquina","hidden","",$idMaquina,"","","","",0,0,0,0);
        
        $css->CrearInputText("TxtFechaInicioP","text","Fecha Inicio Planeado:<br>",$FechaInicioPlaneado,"FechaInicio","black","","",200,30,1,1);
        
        $css->CrearInputText("TxtHoraInicioP","text","<br>Hora Inicio Planeado:<br>",$HoraInicioPlaneado,"HoraInicio","black","","",200,30,1,1);
        
        $css->CrearInputText("TxtFechaFinP","date","<br>Fecha Fin Planeado:<br>",$FechaInicioPlaneado,"Fecha Fin","black","","",200,30,1,0);
        print("<strong><br>Hora Fin Planeada:<br></strong>");
        $css->CrearSelect("CmbHoraFinP", "");
            $HoraLimite=$obVenta->DevuelveValores("produccion_horas_cronograma", "Hora", $HoraInicioPlaneado);
            $idLimit=$HoraLimite[ID]-1;
            $Datos=$obVenta->ConsultarTabla("produccion_horas_cronograma", "LIMIT $idLimit,24");
            $Paro=0;
            while($DatosHorasCrono=$obVenta->FetchArray($Datos)){
                $selected=0;
                $DatosCrono=$obVenta->ConsultarTabla("produccion_actividades", " WHERE Fecha_Inicio='$FechaInicioPlaneado' AND Hora_Inicio='$DatosHorasCrono[Hora]' AND idMaquina='$idMaquina'");
                $DatosCrono=$obVenta->FetchArray($DatosCrono);
                if($DatosCrono["ID"]>0){
                    $Paro=1;
                }
                if($DatosHorasCrono["Hora"]==$HoraInicioPlaneado+1){
                    $selected=1;
                }
                $Paro=0; //Se coloca para que muestre todas las horas
                if($Paro==0){
                    $css->CrearOptionSelect($DatosHorasCrono["Hora"], $DatosHorasCrono["Hora"], $selected);
                }
            }
        $css->CerrarSelect();
        $css->CrearTextArea("TxtDescripcion", "", "", "Descripcion", "Black", "", "", 200, 60, 0, 1);
        $css->CrearTextArea("TxtObservaciones", "", "", "Observaciones", "Black", "", "", 200, 60, 0, 0);
        echo '<br>';
        $css->CrearBotonConfirmado("BtnCrearActividad", "Crear Actividad");
        $css->CerrarForm();
	 
	 $css->CerrarCuadroDeDialogo(); 
         
         //////////////////////////////////
         //Cuadro de dialogo para editar la actividad
         ///////////////////////////////
         
        $DatosActividad=$obVenta->DevuelveValores("produccion_actividades", "ID", $idEdit);
        $DatosColaborador=$obVenta->DevuelveValores("usuarios", "identificacion", $DatosActividad['idColaborador']);
	$css->CrearCuadroDeDialogo("DialEditarActividad","Ver o Editar Actividad $idEdit Descripcion: $DatosActividad[Descripcion], Maquina: $DatosMaquina[Nombre]"); 
	 
        $css->CrearForm2("FrmEditarActividad",$myPage,"post","_self");
        $css->CrearInputText("idAct","hidden","",$idEdit,"","","","",0,0,0,0);
                
        $css->CrearInputText("TxtFechaInicioP","text","Fecha Inicio Planeado:<br>",$DatosActividad['Fecha_Planeada_Inicio'],"FechaInicio","black","","",200,30,0,1);
        
        //$css->CrearInputText("TxtHoraInicioP","text","<br>Hora Inicio Planeado:<br>",$DatosActividad['Hora_Planeada_Inicio'],"HoraInicio","black","","",200,30,0,1);
        echo '<br><strong>Hora Inicio Planeado:</strong><br>';
        $css->CrearSelect("TxtHoraInicioP", "");
            
            $Datos=$obVenta->ConsultarTabla("produccion_horas_cronograma", "");
            $Paro=0;
            while($DatosHorasCrono=$obVenta->FetchArray($Datos)){
                $selected=0;
                //$DatosCrono=$obVenta->ConsultarTabla("produccion_actividades", " WHERE Fecha_Inicio='$FechaInicioPlaneado' AND Hora_Inicio='$DatosHorasCrono[Hora]' AND idMaquina='$idMaquina'");
                //$DatosCrono=$obVenta->FetchArray($DatosCrono);
                
                if($DatosHorasCrono["Hora"].":00"==$DatosActividad['Hora_Planeada_Inicio']){
                    $selected=1;
                }
                if($Paro==0){
                    $css->CrearOptionSelect($DatosHorasCrono["Hora"], $DatosHorasCrono["Hora"], $selected);
                }
            }
        $css->CerrarSelect();
        
        //$css->CrearInputText("TxtFechaFinP","date","<br>Fecha Fin Planeado:<br>",$DatosActividad['Fecha_Planeada_Fin'],"Fecha Fin","black","","",200,30,0,1);
        //$css->CrearInputText("TxtHoraFinP","date","<br>Hora Fin Planeado:<br>",$DatosActividad['Hora_Planeada_Fin'],"Hora Fin","black","","",200,30,0,1);
        echo '<br><strong>Hora Fin Planeado:</strong><br>';
        $css->CrearSelect("TxtHoraFinP", "");
            
            $Datos=$obVenta->ConsultarTabla("produccion_horas_cronograma", "");
            $Paro=0;
            while($DatosHorasCrono=$obVenta->FetchArray($Datos)){
                $selected=0;
                //$DatosCrono=$obVenta->ConsultarTabla("produccion_actividades", " WHERE Fecha_Inicio='$FechaInicioPlaneado' AND Hora_Inicio='$DatosHorasCrono[Hora]' AND idMaquina='$idMaquina'");
                //$DatosCrono=$obVenta->FetchArray($DatosCrono);
                
                if($DatosHorasCrono["Hora"].":00"==$DatosActividad['Hora_Planeada_Fin']){
                    $selected=1;
                }
                if($Paro==0){
                    $css->CrearOptionSelect($DatosHorasCrono["Hora"], $DatosHorasCrono["Hora"], $selected);
                }
            }
        $css->CerrarSelect();
        
        $css->CrearTextArea("TxtDescripcion", "", "$DatosActividad[Descripcion]", "Descripcion", "Black", "", "", 200, 60, 0, 1);
        $css->CrearTextArea("TxtObservaciones", "", "$DatosActividad[Observaciones]", "Observaciones", "Black", "", "", 200, 60, 0, 0);
        echo '<br><strong>Colaborador:</strong><br>';
        $css->CrearSelect("CmbColaborador", "");
            $sql="SELECT Identificacion, Nombre, Apellido FROM usuarios";
            $Datos=$obVenta->Query($sql);
            $css->CrearOptionSelect("NO", "Sin Asignar" , 0);
            while($DatosUsuario=$obVenta->FetchArray($Datos)){
                $selected=0;
                
                if($DatosUsuario["Identificacion"]==$DatosActividad["idColaborador"]){
                    $selected=1;
                }
               
                    $css->CrearOptionSelect($DatosUsuario["Identificacion"], $DatosUsuario["Identificacion"]." ".$DatosUsuario["Nombre"]." ".$DatosUsuario["Apellido"] , $selected);
                
            }
        $css->CerrarSelect();
        echo '<br>';
        
        $css->CrearBotonConfirmado("BtnEditarActividad", "Editar Actividad");
        $css->CerrarForm();
	
        if($DatosActividad["Estado"]=="NO_INICIADA"){
            $css->CrearForm2("FrmEliminarActividad",$myPage,"post","_self");
            $css->CrearInputText("idActDel","hidden","",$idEdit,"","","","",0,0,0,0);
            $css->CrearInputText("TxtFechaActual","hidden","",$FechaActual,"","","","",0,0,0,0);
            $css->CrearBotonConfirmado("BtnEliminarActividad", "Eliminar Actividad");
            $css->CerrarForm();
        }
        
	 $css->CerrarCuadroDeDialogo(); 
    }