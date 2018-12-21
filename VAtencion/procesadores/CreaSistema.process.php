<?php 
$obSistema=new Sistema($idUser);
if(!empty($_REQUEST['del'])){
    $id=$obSistema->normalizar($_REQUEST['del']);
    $idSistema=$obSistema->normalizar($_REQUEST['idSistema']);
    $obSistema->BorraReg("sistemas_relaciones", "ID", $id);
    header("location:$myPage?idSistema=$idSistema");
}

if(!empty($_REQUEST["BtnCrearSistema"])){
       
    $Nombre=$obSistema->normalizar($_REQUEST["TxtNombre"]);
    //$PrecioVenta=$obSistema->normalizar($_REQUEST["TxtPrecioVenta"]);
    //$PrecioMayorista=$obSistema->normalizar($_REQUEST["TxtPrecioMayor"]);
    $Observaciones=$obSistema->normalizar($_REQUEST["TxtObservaciones"]);
    //$CuentaPUC=$obSistema->normalizar($_REQUEST["CuentaPUC"]);
    //$Departamento=$obSistema->normalizar($_REQUEST["CmbDepartamento"]);
    //$Sub1=0; $Sub2=0; $Sub3=0; $Sub4=0; $Sub5=0;
    /*
    if(isset($_REQUEST["CmbSub1"])){
        $Sub1=$obSistema->normalizar($_REQUEST["CmbSub1"]);
    }
    if(isset($_REQUEST["CmbSub2"])){
        $Sub2=$obSistema->normalizar($_REQUEST["CmbSub2"]);
    }
    if(isset($_REQUEST["CmbSub3"])){
        $Sub3=$obSistema->normalizar($_REQUEST["CmbSub3"]);
    }
    if(isset($_REQUEST["CmbSub4"])){
        $Sub4=$obSistema->normalizar($_REQUEST["CmbSub4"]);
    }
    if(isset($_REQUEST["CmbSub5"])){
        $Sub5=$obSistema->normalizar($_REQUEST["CmbSub5"]);
    }
    */
    $idSistema=$obSistema->CrearSistema($Nombre, $Observaciones,$idUser, "");
    if(!empty($_REQUEST["TxtCodigoBarras"])){
        $CodigoBarras=$obSistema->normalizar($_REQUEST["TxtCodigoBarras"]);
        $obSistema->AgregarCodigoBarrasAItem($idSistema,$CodigoBarras,$TablaOrigen='sistemas',$Vector);
    }
    header("location:$myPage?idSistema=$idSistema");
}

		
if(!empty($_REQUEST["BtnAgregarItem"])){
           
    $idSistema=$obSistema->normalizar($_REQUEST["idSistema"]);
    $Cantidad=$obSistema->normalizar($_REQUEST["TxtCantidad"]);
    $ValorUnitario=$obSistema->normalizar($_REQUEST["TxtValor"]);
    $idItem=$obSistema->normalizar($_REQUEST["idProducto"]);
    $TipoItem=$obSistema->normalizar($_REQUEST["TipoItem"]);
    $obSistema->AgregarItemSistema($TipoItem,$idSistema,$Cantidad,$ValorUnitario,$idItem,"");
    header("location:$myPage?idSistema=$idSistema");
}
// si se requiere editar una cantidad
if(!empty($_REQUEST["BtnEditarCantidad"])){
    
    $idSistema=$obSistema->normalizar($_REQUEST["idSistema"]);
    $idItem=$obSistema->normalizar($_REQUEST["idItem"]);
    $Cantidad=$obSistema->normalizar($_REQUEST["TxtCantidadEdit"]);
    $ValorUnitario=$obSistema->normalizar($_REQUEST["TxtValorEdit"]);
    $obSistema->ActualizaRegistro("sistemas_relaciones", "Cantidad", $Cantidad, "ID", $idItem,0);
    $obSistema->ActualizaRegistro("sistemas_relaciones", "ValorUnitario", $ValorUnitario, "ID", $idItem,0);
    header("location:$myPage?idSistema=$idSistema");
    
}
// si se requiere editar una cantidad
if(!empty($_REQUEST["BtnEditarSistema"])){
    
    $idSistema=$obSistema->normalizar($_REQUEST["idSistema"]);
    
    $Nombre=$obSistema->normalizar($_REQUEST["TxtNombre"]);
    $Observaciones=$obSistema->normalizar($_REQUEST["TxtObservaciones"]);
    
    
    $obSistema->ActualizaRegistro("sistemas", "Observaciones", $Observaciones, "ID", $idSistema,0);
    $obSistema->ActualizaRegistro("sistemas", "Nombre", $Nombre, "ID", $idSistema,0);
    
    header("location:$myPage?idSistema=$idSistema");
    
}
// si se requiere guardar y cerrar
if(!empty($_REQUEST["BtnGuardar"])){
    
    $idSistema=$obSistema->normalizar($_REQUEST["idSistema"]);
    $obSistema->ActualizaRegistro("sistemas", "Estado", "CERRADO", "ID", $idSistema);
        
    header("location:$myPage");
    
}
///////////////fin
?>