<?php
session_start();
$idUser=$_SESSION['idUser'];
include_once("../../modelo/php_conexion.php");
$obCon = new ProcesoVenta($idUser);
if(isset($_REQUEST["Telefono"])){
    $Telefono=$obCon->normalizar($_REQUEST["Telefono"]);
    $sql="SELECT * FROM restaurante_pedidos WHERE TelefonoConfirmacion = '$Telefono' LIMIT 1";
    $consulta=$obCon->Query($sql);
    $DatosUsuarios=$obCon->FetchAssoc($consulta);       
    echo(json_encode($DatosUsuarios));
}


if(isset($_REQUEST["idDepartamento"])){
    $idDepartamento=$obCon->normalizar($_REQUEST["idDepartamento"]);
    if($idDepartamento=="Todos"){
        $Mensaje["msg"]="Todos";
        echo json_encode($Mensaje,JSON_UNESCAPED_UNICODE);
    } else{   
        $sql="SELECT idProductosVenta,Nombre,PrecioVenta FROM productosventa WHERE Departamento='$idDepartamento' ORDER BY `productosventa`.`Nombre` ASC LIMIT 200  ";
        //print($sql);
        $Datos=$obCon->Query($sql);
        $i=0;
        //$Mensaje[]="";

        while($DatosProductos=$obCon->FetchAssoc($Datos)){
            $Mensaje[$i]["ID"]=$DatosProductos["idProductosVenta"];
            $Mensaje[$i]["Nombre"]= utf8_encode($DatosProductos["Nombre"]);
            $Mensaje[$i]["PrecioVenta"]=$DatosProductos["PrecioVenta"];
            $i++;        
        }
        echo json_encode($Mensaje,JSON_UNESCAPED_UNICODE);
    }
    //print_r($Mensaje);
    //print(json_encode($Mensaje));
}
    
