<?php 

if(!empty($_REQUEST["BtnCrearActividad"])){
    
    $obVenta=new ProcesoVenta($idUser);
    
    $idOT=$_REQUEST["idOT"];
    $idMaquina=$_REQUEST["idMaquina"];
    $FechaInicioPlaneado=$_REQUEST["TxtFechaInicioP"];
    $HoraInicioPlaneado=$_REQUEST["TxtHoraInicioP"];
    $FechaFinPlaneado=$_REQUEST["TxtFechaFinP"];
    $HoraFinPlaneado=$_REQUEST["CmbHoraFinP"];
    $Descripcion=$_REQUEST["TxtDescripcion"];
    $Observaciones=$_REQUEST["TxtObservaciones"];
    
    if(($HoraFinPlaneado==$HoraInicioPlaneado and $FechaInicioPlaneado==$FechaFinPlaneado) and $HoraFinPlaneado<>'23:59'){
        $HoraInicial=strtotime($HoraFinPlaneado);
        $HoraFinPlaneado=date("H:i",$HoraInicial+60*60);
        
    }
    
    if($HoraFinPlaneado=="23:59"){
        $HoraFinPlaneado="24:00";
    }
    $obVenta->AgregaActividadOT($idOT, $idMaquina, $FechaInicioPlaneado, $HoraInicioPlaneado, $FechaFinPlaneado, $HoraFinPlaneado, $Descripcion, $Observaciones, "");
    
    //$obVenta->CerrarCon();
    header("location:$myPage?idOT=$idOT&TxtFechaCronograma=$FechaInicioPlaneado");
}

if(!empty($_REQUEST["BtnEditarActividad"])){
    
    $obVenta=new ProcesoVenta($idUser);
    
    $IDEdit=$_REQUEST["idAct"];
    
    $FechaInicioPlaneado=$obVenta->normalizar($_REQUEST["TxtFechaInicioP"]);
    $HoraInicioPlaneado=$obVenta->normalizar($_REQUEST["TxtHoraInicioP"]);
    $FechaFinPlaneado=$obVenta->normalizar($_REQUEST["TxtFechaFinP"]);
    $HoraFinPlaneado=$obVenta->normalizar($_REQUEST["TxtHoraFinP"]);
    $Descripcion=$obVenta->normalizar($_REQUEST["TxtDescripcion"]);
    $Observaciones=$obVenta->normalizar($_REQUEST["TxtObservaciones"]);
    $idColaborador=$obVenta->normalizar($_REQUEST["CmbColaborador"]);
    
    $sql="UPDATE produccion_actividades SET Fecha_Planeada_Inicio='$FechaInicioPlaneado', Fecha_Planeada_Fin='$FechaFinPlaneado'"
            . ", Hora_Planeada_Inicio='$HoraInicioPlaneado', Hora_Planeada_Fin='$HoraFinPlaneado', Fecha_Inicio='$FechaInicioPlaneado'"
            . ", Fecha_Fin='$FechaInicioPlaneado', Hora_Inicio='$HoraInicioPlaneado', Hora_Fin='$HoraFinPlaneado'"
            . ", Descripcion='$Descripcion', Observaciones='$Observaciones', idColaborador='$idColaborador'  WHERE ID='$IDEdit'";
    $obVenta->Query($sql);
    //$obVenta->CerrarCon();
    header("location:$myPage?TxtFechaCronograma=$FechaInicioPlaneado");
}

if(!empty($_REQUEST["BtnEliminarActividad"])){
    
    $obVenta=new ProcesoVenta($idUser);
    $FechaActual=$_REQUEST["TxtFechaActual"];
    $IDAct=$obVenta->normalizar($_REQUEST["idActDel"]);
    
    $obVenta->BorraReg("produccion_actividades", "ID", $IDAct);
    //$obVenta->CerrarCon();
    header("location:$myPage?TxtFechaCronograma=$FechaActual");
}

///////////////fin
?>