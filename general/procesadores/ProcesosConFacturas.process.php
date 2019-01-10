<?php

session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];

include_once("../clases/facturacion_electronica.class.php");

if( !empty($_REQUEST["idAccion"]) ){
    
function ContabilizarFacturas(){
    
    $idUser=$_SESSION['idUser'];
    $obCon = new Factura_Electronica($idUser);
    
    $Consulta=$obCon->ConsultarTabla("facturas_kardex", "WHERE Kardex='NO'");  //Sin el usuario porque será para todas las cajas
    $Mensaje="";
    while ($DatosFactura=$obCon->FetchArray($Consulta)){
        $idFactura=$DatosFactura["idFacturas"];
        $sql="SELECT Num_Documento_Interno FROM librodiario WHERE Num_Documento_Interno='$idFactura'";
        $Verificacion=$obCon->Query($sql);
        $Verificacion=$obCon->FetchAssoc($Verificacion);
        if($Verificacion["Num_Documento_Interno"]==''){
            $Datos["ID"]=$DatosFactura["idFacturas"];
            $Datos["CuentaDestino"]=$DatosFactura["CuentaDestino"];
            $obCon->InsertarFacturaLibroDiario($Datos);
            $obCon->DescargueFacturaInventarios($DatosFactura["idFacturas"],"");
            $Mensaje.="Factura $DatosFactura[idFacturas] Contabilizada<br>";
            //print("Factura $DatosFactura[idFacturas] Contabilizada<br>");
            //print("Factura $DatosFactura[idFacturas] descargada de inventarios<br>");
            $obCon->BorraReg("facturas_kardex", "idFacturas", $DatosFactura["idFacturas"]);
        }
        
    }
    print("OK;$Mensaje");
     
}
    //$obCon = new Backups($idUser);
    
    switch ($_REQUEST["idAccion"]) {
        
        case 1: //Contabilizacion de facturas
            if($TipoKardex=="NO"){
                register_shutdown_function('ContabilizarFacturas');
            }else{
                print("OK;Contabilizacion Automatica Deshabilitada");
            }
          
        break; //Fin caso 1
        
        case 2://Crear las tablas locales en el servidor externo
            
            $sql="SHOW FULL TABLES WHERE Table_type='BASE TABLE'";
            $consulta=$obCon->Query($sql);
            $i=0;
            while ($DatosTablas=$obCon->FetchArray($consulta)){
                $TablasLocales[$i]=$DatosTablas[0];
                $i++;
                
            }
            $CantidadTablasLocales=count($TablasLocales);
            //print("<br>Tablas locales ".$CantidadTablasLocales);
            
            $DatosServer=$obCon->DevuelveValores("servidores", "ID", 2);
            $consultaExterna=$obCon->QueryExterno($sql, $DatosServer["IP"], $DatosServer["Usuario"], $DatosServer["Password"], $DatosServer["DataBase"], "");
            
            $i=0;
            $TablasExternas[]="";
            while ($DatosTablasExternas=$obCon->FetchArray($consultaExterna)){
                $TablasExternas[$i]=$DatosTablasExternas[0];
                $i++;
                
            }
            $CantidadTablasExternas=count($TablasExternas);
            //print("<br>Tablas externas ".$CantidadTablasExternas);
            foreach ($TablasLocales as $key => $value) {
                if(!in_array($value, $TablasExternas)){
                    $obCon->conectar();
                    $sql="SHOW CREATE TABLE ".$value;
                    $consulta=$obCon->Query($sql);
                    $DatosCreacionTabla=$obCon->FetchAssoc($consulta);
                    $sql=$DatosCreacionTabla["Create Table"];
                    $obCon->QueryExterno($sql, $DatosServer["IP"], $DatosServer["Usuario"], $DatosServer["Password"], $DatosServer["DataBase"], "");
            
                    print("OK;$CantidadTablasLocales;$CantidadTablasExternas;$value");
                    exit();
                }
            }
            print("OK;$CantidadTablasLocales;$CantidadTablasExternas;ST");
           
        break;//Fin caso 2
        
        case 3: //Revisa en que tablas hay registros nuevos o cambios
            $sql="SHOW FULL TABLES WHERE Table_type='BASE TABLE'";
            $consulta=$obCon->Query($sql);
            $i=0;
            $RegistrosXCopiar=0;
            $TablasLocales=[];
            while ($DatosTablas=$obCon->FetchArray($consulta)){
                $Tabla=$DatosTablas[0];
                $sql="SELECT COUNT(*) as TotalRegistros FROM $Tabla WHERE Sync = '0000-00-00 00:00:00' OR Sync<>Updated";
                $ConsultaConteo=$obCon->Query($sql);
                $Registros=$obCon->FetchAssoc($ConsultaConteo);
                $TotalRegistros=$Registros["TotalRegistros"];
                if($TotalRegistros>0){  
                    $RegistrosXCopiar=$RegistrosXCopiar+$TotalRegistros;
                    $TablasLocales[$i]["Nombre"]=$Tabla;
                    $TablasLocales[$i]["Registros"]=$TotalRegistros;
                    $i++;                
                }
                
            }
            
            print("OK;$RegistrosXCopiar;".json_encode($TablasLocales, JSON_FORCE_OBJECT));
            
        break;//Fin caso 3
         
        case 4://Realiza el backup a una tabla
            $Tabla=$obCon->normalizar($_REQUEST["tabla"]);
            $DatosServer=$obCon->DevuelveValores("servidores", "ID", 2);
            $FechaSinc=date("Y-m-d H:i:s");
            $CondicionUpdate="WHERE Sync = '0000-00-00 00:00:00' OR Sync<>Updated LIMIT 5000";
            $sql=$obCon->ArmeSqlReplace($Tabla, DB, $CondicionUpdate,$DatosServer["DataBase"],$FechaSinc, "");
            //print($sql);
            if($sql==''){
                print("OK;0");
                exit();
            }
            $Mensaje="";
            $Mensaje=$obCon->QueryExterno($sql, $DatosServer["IP"], $DatosServer["Usuario"], $DatosServer["Password"], $DatosServer["DataBase"], "");
            if($Mensaje<>"" and $Mensaje<>1){
                $Mensaje="Error: al insertar datos en la tabla $Tabla: ".$Mensaje;
                $obCon->RegistraAlerta("", "", "Backups", $Mensaje, "");
            }
            $sqlUp="UPDATE $Tabla SET Sync='$FechaSinc', Updated='$FechaSinc' $CondicionUpdate";
            $Mensaje=$obCon->Query($sqlUp);
            if($Mensaje<>"" and $Mensaje<>1){
                $Mensaje="Error: al insertar datos en la tabla $Tabla: ".$Mensaje;
                $obCon->RegistraAlerta("", "", "Backups", $Mensaje, "");
            }
            $sql="SELECT COUNT(*) as TotalRegistros FROM $Tabla WHERE Sync = '0000-00-00 00:00:00' OR Sync<>Updated";
            $ConsultaConteo=$obCon->Query($sql);
            $Registros=$obCon->FetchAssoc($ConsultaConteo);
            $TotalRegistros=$Registros["TotalRegistros"];
            print("OK;$TotalRegistros");
            
            //print($consultaExterna->num_rows);
            //print_r($consultaExterna);
        break;//Fin caso 4
        
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>