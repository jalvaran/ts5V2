<?php
session_start();
include_once("../../modelo/php_conexion.php");

$Autorizado=$_REQUEST['Autorizado'];
function Kardex(){
    
    $idUser=$_SESSION['idUser'];
    $obVenta = new ProcesoVenta($idUser);
    
    $Consulta=$obVenta->ConsultarTabla("facturas_kardex", "WHERE Kardex='NO'");  //Sin el usuario porque será para todas las cajas
    while ($DatosFactura=$obVenta->FetchArray($Consulta)){
        $obVenta->DescargueFacturaInventarios($DatosFactura["idFacturas"],"");
        
        $Datos["ID"]=$DatosFactura["idFacturas"];
        $Datos["CuentaDestino"]=$DatosFactura["CuentaDestino"];
        $obVenta->InsertarFacturaLibroDiario($Datos);
        print("Factura $DatosFactura[idFacturas] Contabilizada<br>");
        print("Factura $DatosFactura[idFacturas] descargada de inventarios<br>");
        $obVenta->BorraReg("facturas_kardex", "idFacturas", $DatosFactura["idFacturas"]);
    }
    
     
}
if($Autorizado<>""){
    
    $ip=$_SERVER['REMOTE_ADDR'];
    $ipServer=$_SERVER['SERVER_ADDR'];
    if($ip==$ipServer){
        register_shutdown_function('Kardex');
        print("<br><strong>Conectado desde $ip, al server $ipServer, Modo Servidor Activo, Esperando por Datos</strong>");
    }else{
        print("<br><strong>Usted está Conectado desde la IP: $ip</strong>");
      
    }
       
}else{
    print("Sin Datos");
}


?> 