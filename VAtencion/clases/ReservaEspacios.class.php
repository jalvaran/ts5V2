<?php
/* 
 * Clase donde se realizaran procesos de compras u otros modulos.
 * Julian Alvaran
 * Techno Soluciones SAS
 */
//include_once '../../php_conexion.php';
class Reserva extends ProcesoVenta{
    public function CrearReserva($idEspacio,$NombreEvento,$NumDia,$FechaInicio,$FechaFin,$idCliente,$Telefono, $Observaciones,$idUser,$Repite, $Vector) {
        
        $DatosEspacio=$this->DevuelveValores("reservas_espacios", "ID", $idEspacio); 
        if($NumDia>=2 and $NumDia<=5){
            $Tarifa=$DatosEspacio["TarifaNormal"];
        }else{
            $Tarifa=$DatosEspacio["TarifaNormal2"];
        }
        $tab="reservas_eventos";
        
        $NumRegistros=9;

        $Columnas[0]="NombreEvento";	$Valores[0]=$NombreEvento;
        $Columnas[1]="FechaInicio";     $Valores[1]=$FechaInicio;
        $Columnas[2]="FechaFin";	$Valores[2]=$FechaFin;
        $Columnas[3]="idCliente";       $Valores[3]=$idCliente;
        $Columnas[4]="Telefono";        $Valores[4]=$Telefono;
        $Columnas[5]="Observaciones";   $Valores[5]=$Observaciones;
        $Columnas[6]="idUser";          $Valores[6]=$idUser;
        $Columnas[7]="idEspacio";       $Valores[7]=$idEspacio;
        $Columnas[8]="Tarifa";          $Valores[8]=$Tarifa;
        if($Repite==1){
            $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
        }
        //Si se requiere programar un año el mismo evento
        $FechaInicioRepeticion=$FechaInicio;
        $FechaFinRepeticion=$FechaFin;
        if($Repite>1){
            for ($i=1;$i<=$Repite;$i++){
                
                $FechaInicioRepeticion=$this->SumeDiasFechaReserva($FechaInicioRepeticion, 7, "");
                $FechaFinRepeticion=$this->SumeDiasFechaReserva($FechaFinRepeticion, 7, "");
                $Valores[1]=$FechaInicioRepeticion;
                $Valores[2]=$FechaFinRepeticion;
                //Primero verifico que en la fecha solicitada no haya otro evento
                $Verifica=$this->ValorActual("reservas_eventos", "ID", " FechaInicio='$FechaInicioRepeticion' AND Estado='RE'");
                if($Verifica==''){
                    $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
                }
            }
            
            
        }

        $idReserva=$this->ObtenerMAX($tab,"ID", 1,"");
        return $idReserva;
    }
    
    //Clase para agregar un item a un sistema
    public function FacturarReserva($idEspacio,$idReserva,$fecha,$idUser,$Vector) {
        $DatosEspacio=$this->DevuelveValores("reservas_espacios", "ID", $idEspacio);
        $DatosReserva=$this->DevuelveValores("reservas_eventos", "ID", $idReserva);
        $idPreventa=99;// se utiliza esta para no interferir en la operacion
        //Agrego el item a la preventa 99
        $this->AgregaPreventa($fecha,1,$idPreventa,$DatosEspacio['idProductoRelacionado'],"productosventa",$DatosReserva["Tarifa"]);
        
        //Registro la venta y creo la factura
        $Parametros= $this->DevuelveValores("parametros_contables", "ID", 21); // en este registro se encuentra la cuenta por defecto a utilizar en caja
        $CuentaDestino=$Parametros["CuentaPUC"];
        $DatosVentaRapida["PagaCheque"]=0;
        $DatosVentaRapida["PagaTarjeta"]=0;
        $DatosVentaRapida["idTarjeta"]=0;
        $DatosVentaRapida["PagaOtros"]=0;
        $DatosCaja=$this->DevuelveValores("cajas", "idUsuario", $idUser);
        $DatosVentaRapida["CentroCostos"]=$DatosCaja["CentroCostos"];
        $DatosVentaRapida["ResolucionDian"]=$DatosCaja["idResolucionDian"];
        $DatosVentaRapida["Observaciones"]=$DatosReserva["Observaciones"];
        $NumFactura=$this->RegistreVentaRapida($idPreventa, $DatosReserva["idCliente"], "Contado", $DatosReserva["Tarifa"], 0, $Parametros["CuentaPUC"], $DatosVentaRapida);
        $this->FacturaKardex($NumFactura,$CuentaDestino, $idUser, "");
        //print("<script>alert('Entra 2')</script>");
        $this->BorraReg("preventa","VestasActivas_idVestasActivas",$idPreventa);
        
        return($NumFactura);
    }
       
    public function SumeDiasFechaReserva($Fecha,$Dias,$Vector){		
        $nuevafecha = date('Y-m-d H:i:s', strtotime($Fecha) + 86400);
        $nuevafecha = date('Y-m-d H:i:s', strtotime("$Fecha + $Dias day"));

        return($nuevafecha);

    }
    //Fin Clases
}