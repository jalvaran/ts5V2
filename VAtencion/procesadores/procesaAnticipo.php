<?php 

//print("<script>alert('entra');</script>");		
if(!empty($_REQUEST["BtnGuardarAnticipo"])){
    //print("<script>alert('entra');</script>");
    $obVenta=new ProcesoVenta($idUser);
    
    $fecha=$_REQUEST["TxtFecha"];
    $CuentaDestino=$_REQUEST["CmbCuentaDestino"];
    $idCliente=$_REQUEST["TxtTercero"];
    $Total=$_REQUEST["TxtTotal"];
    $CentroCosto=$_REQUEST["CmbCentroCostos"];
    $Concepto=$_REQUEST["TxtConcepto"];   
    $VectorIngreso["Fut"]="";        
    $idIngreso=$obVenta->RegistreAnticipo2($fecha, $CuentaDestino, $idCliente, $Total, $CentroCosto, $Concepto, $idUser, $VectorIngreso);
   
    header("location:RegistrarAnticipos.php?TxtidIngreso=$idIngreso");
}

///////////////fin
?>