<?php
/* 
 * Clase donde se realizaran procesos de compras u otros modulos.
 * Julian Alvaran
 * Techno Soluciones SAS
 */
//include_once '../../php_conexion.php';
class Remision extends ProcesoVenta{
    public function CrearRemision($Fecha, $idCliente,$Observaciones,$idCotizacion,$Obra,$DireccionObra,$CiudadObra,$TelefonoObra,$ColaboradorRetira,$FechaDespacho,$HoraDespacho,$Anticipo,$Dias,$idUser,$CentroCostos, $Vector) {
        
     $tab="remisiones";
    $NumRegistros=16;  


    $Columnas[0]="Fecha";					$Valores[0]=$Fecha;
    $Columnas[1]="Clientes_idClientes";				$Valores[1]=$idCliente;
    $Columnas[2]="ObservacionesRemision";			$Valores[2]=$Observaciones;
    $Columnas[3]="Cotizaciones_idCotizaciones";			$Valores[3]=$idCotizacion;
    $Columnas[4]="Obra";					$Valores[4]=$Obra;
    $Columnas[5]="Direccion";					$Valores[5]=$DireccionObra;
    $Columnas[6]="Ciudad";					$Valores[6]=$CiudadObra;
    $Columnas[7]="Telefono";					$Valores[7]=$TelefonoObra;
    $Columnas[8]="Retira";					$Valores[8]=$ColaboradorRetira;
    $Columnas[9]="FechaDespacho";				$Valores[9]=$FechaDespacho;
    $Columnas[10]="HoraDespacho";				$Valores[10]=$HoraDespacho;
    $Columnas[11]="Anticipo";					$Valores[11]=$Anticipo;
    $Columnas[12]="Dias";			    		$Valores[12]=$Dias;
    $Columnas[13]="Estado";			    		$Valores[13]="A";
    $Columnas[14]="Usuarios_idUsuarios";			$Valores[14]=$idUser;
    $Columnas[15]="CentroCosto";                                $Valores[15]=$CentroCostos;

    $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);


    $idRemision=$this->ObtenerMAX("remisiones", "ID", 1, "");

    ///////////////////////////////Se ingresa a rem_relaciones

    $ConsultaItems=$this->ConsultarTabla("cot_itemscotizaciones","WHERE NumCotizacion='$idCotizacion'");
    while($DatosItemsCotizacion=  $this->FetchArray($ConsultaItems)){
        $tab="rem_relaciones";
        $NumRegistros=6; 
        $Columnas[0]="FechaEntrega";			$Valores[0]=$Fecha;
        $Columnas[1]="CantidadEntregada";		$Valores[1]=$DatosItemsCotizacion["Cantidad"];
        $Columnas[2]="idItemCotizacion";		$Valores[2]=$DatosItemsCotizacion['ID'];
        $Columnas[3]="idRemision";                      $Valores[3]=$idRemision;
        $Columnas[4]="Usuarios_idUsuarios";             $Valores[4]=$idUser;
        $Columnas[5]="Multiplicador";                   $Valores[5]=$DatosItemsCotizacion["Multiplicador"];

        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
        if($DatosItemsCotizacion["TablaOrigen"]=="productosalquiler"){
            $DatosProducto= $this->DevuelveValores("productosalquiler", "Referencia", $DatosItemsCotizacion["Referencia"]);
            $DatosClientes= $this->DevuelveValores("clientes","idClientes",$DatosItemsCotizacion["idCliente"]);
            $this->KardexAlquiler($Fecha, "SALIDA", $DatosItemsCotizacion["Cantidad"], $DatosProducto["Nombre"],$DatosProducto["idProductosVenta"],$DatosProducto["Existencias"],$DatosProducto["EnAlquiler"],$DatosProducto["EnBodega"], $DatosClientes["Num_Identificacion"], $DatosClientes["RazonSocial"],"Remision", $idRemision,$DatosProducto["CostoUnitario"], $DatosProducto["CostoUnitario"]*$DatosItemsCotizacion["Cantidad"],$idUser, "");
        }
        
        }
    return($idRemision);  
    }
    //Ingresa a Kardex Alquileres
    public function KardexAlquiler($Fecha,$Movimiento,$Cantidad,$Equipo,$idEquipo,$Existencias,$EnAlquiler,$EnBodega,$idCliente,$RazonSocial,$Detalle,$idRemision,$ValorUnitario,$ValorTotal,$idUser,$Vector) {
        $tab="kardex_alquiler";
        $NumRegistros=12; 
        $Columnas[0]="Fecha";			$Valores[0]=$Fecha;
        $Columnas[1]="Movimiento";		$Valores[1]=$Movimiento;
        $Columnas[2]="Cantidad";		$Valores[2]=$Cantidad;
        $Columnas[3]="Equipo";                  $Valores[3]=$Equipo;
        $Columnas[4]="idProducto";              $Valores[4]=$idEquipo;
        $Columnas[5]="idCliente";               $Valores[5]=$idCliente;
        $Columnas[6]="RazonSocial";		$Valores[6]=$RazonSocial;
        $Columnas[7]="Detalle";                 $Valores[7]=$Detalle;
        $Columnas[8]="NumDocumento";            $Valores[8]=$idRemision;
        $Columnas[9]="ValorUnitario";           $Valores[9]=$ValorUnitario;
        $Columnas[10]="ValorTotal";             $Valores[10]=$ValorTotal;
        $Columnas[11]="idUser";		        $Valores[11]=$idUser;
        
        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
        if($Movimiento=="SALIDA"){
            $TotalAlquilados=$EnAlquiler+$Cantidad;
        }
        if($Movimiento=="ENTRADA"){
            $TotalAlquilados=$EnAlquiler-$Cantidad;
        }
        $TotalBodega=$Existencias-$TotalAlquilados;
        $this->ActualizaRegistro("productosalquiler", "EnAlquiler", $TotalAlquilados, "idProductosVenta", $idEquipo,0);
        $this->ActualizaRegistro("productosalquiler", "EnBodega", $TotalBodega, "idProductosVenta", $idEquipo,0);
    }   
    //Fin Clases
}