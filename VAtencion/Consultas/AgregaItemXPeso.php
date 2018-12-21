<?php
/* 
 * Este archivo se encarga de escuchar las peticiones para editar un registro
 */

if(!empty($_REQUEST["key"])){
    include_once("../../modelo/php_tablas.php");  //Clases de donde se escribirán las tablas
    include_once("../css_construct.php");
    
    session_start();
    $idUser=$_SESSION['idUser'];
    $obTabla = new Tabla($db);
    $obVenta = new ProcesoVenta($idUser);
    $css =  new CssIni("");
    $CodBar=$obVenta->normalizar($_REQUEST['key']);
    $idPreventa=$obVenta->normalizar($_REQUEST['CmbPreVentaAct']);
    $myPage=$obVenta->normalizar($_REQUEST['myPage']);
    /*
    $sql="SELECT pv.`idProductosVenta`,pv.`PrecioVenta`,pv.`Nombre`, pv.`Referencia` FROM `productosventa` pv "
                . " INNER JOIN prod_codbarras k ON pv.`idProductosVenta`=k.ProductosVenta_idProductosVenta "
                . " WHERE k.`CodigoBarras`='$CodBar' "
                . " OR pv.`CodigoBarras`='$CodBar' "
                . " OR pv.`idProductosVenta`='$CodBar' ORDER BY pv.`idProductosVenta` DESC LIMIT 1";
    $Consulta=$obVenta->Query($sql);
    $DatosProducto=$obVenta->FetchArray($Consulta);
    
    */
    $DatosCajas=$obVenta->DevuelveValores("cajas", "idUsuario", $idUser);
    $idBascula=$DatosCajas["idBascula"];
    $sql="SELECT ProductosVenta_idProductosVenta as idProductosVenta FROM prod_codbarras WHERE CodigoBarras='$CodBar'";
        $consulta=$obVenta->Query($sql);
        $DatosProducto=$obVenta->FetchArray($consulta);
        if($DatosProducto["idProductosVenta"]==''){
            $idProducto=ltrim($CodBar, "0");
            $sql="SELECT idProductosVenta FROM productosventa WHERE idProductosVenta='$CodBar'";
            $consulta=$obVenta->Query($sql);
            $DatosProducto=$obVenta->FetchArray($consulta);
        }
    if($DatosProducto["idProductosVenta"]){
        $id=$DatosProducto["idProductosVenta"];
        $sql="SELECT idProductosVenta,PrecioVenta,Nombre,Especial FROM productosventa WHERE idProductosVenta='$id'";
            $consulta=$obVenta->Query($sql);
            $DatosProducto=$obVenta->FetchArray($consulta);
        if($DatosProducto["PrecioVenta"]>0){
            $tab="productosventa";
            $css->CrearNotificacionAzul("Digite la cantidad que desea agregar del producto $DatosProducto[Nombre] Precio: ".number_format($DatosProducto["PrecioVenta"]), 14);
            $css->CrearForm2("FrmAgregarItem$CodBar", $myPage, 'post', '_self');
            $css->CrearInputText("CmbPreVentaAct", "hidden", "", $idPreventa, "", "", "", "", "", "", 0, 0);
            $css->CrearInputText("TxtTablaItem", "hidden", "", $tab, "", "", "", "", "", "", 0, 0);
            $css->CrearInputText("Bascula", "hidden", "", 1, "", "", "", "", "", "", 0, 0);
            $css->CrearInputText("TxtAgregarItemPreventa", "hidden", "", $DatosProducto["idProductosVenta"], "", "", "", "", "", "", 0, 0);
            $sql="SELECT Gramos FROM registro_basculas WHERE idBascula='$idBascula' AND Leido=0";
            $DatosBascula=$obVenta->Query($sql);
            $DatosBascula=$obVenta->FetchArray($DatosBascula);
            $css->CrearInputNumber("TxtCantidad", "number", "", $DatosBascula["Gramos"], "Cantidad", "", "", "", 100, 30, 0, 1, 0, "", "any");
            if($DatosProducto["Especial"]=='SI'){
                $css->CrearInputNumber("TxtValorAcordadoBascula", "number", "", $DatosProducto["PrecioVenta"], "PrecioVenta", "", "", "", 100, 30, 0, 1, 50, "", 1);
            }
            $css->CrearBotonNaranja("BtnAgregar", "Agregar");
            $css->CerrarForm(); 
            
        }else{
           $css->CrearNotificacionRoja("Este producto no tiene precio de venta, no lo entregue", 16); 
        }
    }else{
        $css->CrearNotificacionRoja("Este producto no esta en la base de datos, no lo entregue", 16);
    }
    
   //$css->CrearNotificacionAzul("Se ha Actualizado la Columna $NombreCol de la tabla $tab con el Valor: $Edicion",16);
     
}

?>