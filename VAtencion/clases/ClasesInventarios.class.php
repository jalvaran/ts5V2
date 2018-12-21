<?php
/* 
 * Clase donde se realizaran procesos de compras u otros modulos.
 * Julian Alvaran
 * Techno Soluciones SAS
 */
//include_once '../../php_conexion.php';
class Inventarios extends ProcesoVenta{
   //Registrar el conteo fisico
     public function RegistrarConteoFisicoSelectivo($Codigo,$Cantidad,$Vector) {
         $DatosCodigoBarras=$this->DevuelveValores("prod_codbarras", "CodigoBarras", $Codigo);
         $idProducto=$DatosCodigoBarras["ProductosVenta_idProductosVenta"];
         if($idProducto==''){
             $idProducto=$Codigo;
         }
         $DatosProducto=$this->DevuelveValores("productosventa", "idProductosVenta", $idProducto);
         if($DatosProducto["idProductosVenta"]==''){
             $Respuestas["Error"]="el producto con el codigo $idProducto No existe";
             return($Respuestas);
         }
         $DatosProductoConteo=$this->DevuelveValores("inventarios_conteo_selectivo", "Referencia", $idProducto);
         if($DatosProductoConteo["Referencia"]==''){
             $Referencia=$DatosProducto["Referencia"];
             $sql="INSERT INTO `inventarios_conteo_selectivo` (`Referencia`, `Cantidad`) VALUES ('$idProducto', '$Cantidad');";
             $this->Query($sql);
             //$this->RegistrarDiferenciaInventarios($idProducto, "");
             $Respuestas["Creado"]="Se han contado $Cantidad items del producto con codigo $idProducto, Refencia $Referencia, $DatosProducto[Nombre] y Precio $DatosProducto[PrecioVenta] ";
             return($Respuestas);
         }else{
            $Referencia=$DatosProducto["Referencia"];
            $Saldo=$DatosProductoConteo["Cantidad"]+$Cantidad;
            $this->ActualizaRegistro("inventarios_conteo_selectivo", "Cantidad", $Saldo, "Referencia", $idProducto);
            $Respuestas["Actualizado"]="el codigo $idProducto, $DatosProducto[Nombre], Precio: $DatosProducto[PrecioVenta], Referencia $DatosProductoConteo[Referencia],  Se ha actualizado satisfactoriamente, existencia anterior = $DatosProductoConteo[Cantidad], Cantidad Ingresada=$Cantidad, Nuevo Saldo = $Saldo";
            return($Respuestas);
         }
     }
    
    //Fin Clases
}