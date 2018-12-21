<?php
include_once("../../modelo/php_conexion.php");
include_once("../css_construct.php");
include_once("../clases/ReservaEspacios.class.php");
$DiaSemana=array('','Lunes', 'Martes', 'Miercoles','Jueves','Viernes','Sabado','Domingo');
session_start();
$idUser=$_SESSION['idUser'];
$css =  new CssIni("");

$obReserva = new Reserva($idUser);
$idEspacio=$obReserva->normalizar($_REQUEST["idEspacio"]);
$Fecha=$obReserva->normalizar($_REQUEST["TxtFecha"]);
$SelFecha=strtotime($Fecha);
$NumDia=date("N",$SelFecha);
$DatosEspacio=$obReserva->DevuelveValores("reservas_espacios", "ID", $idEspacio);

$css->CrearNotificacionAzul("Cronograma en $DatosEspacio[Nombre] para el dia $DiaSemana[$NumDia] $Fecha", 16);


function Kardex(){
    
    $idUser=$_SESSION['idUser'];
    $obVenta = new ProcesoVenta($idUser);
    
    $Consulta=$obVenta->ConsultarTabla("facturas_kardex", "WHERE Kardex='NO' and idUsuario='$idUser'");
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

if(isset($_REQUEST["Hora"]) and isset($_REQUEST["idCliente"])){
    
    $Hora=$obReserva->normalizar($_REQUEST["Hora"]);
    $idCliente=$obReserva->normalizar($_REQUEST["idCliente"]);
    
    if($idCliente>0){
        $Repite=1;
        if(isset($_REQUEST["Repite"])){
            $Repite=$obReserva->normalizar($_REQUEST["Repite"]);
        }
        $DatosCliente=$obReserva->DevuelveValores("clientes", "idClientes", $idCliente);
        $FechaInicio=$Fecha." ".$Hora;
        $HoraFinal=$Hora+1;
        if($Hora=="23:00"){
            $HoraFinal="23:59:00";
        }
        $FechaFin=$Fecha." ".($HoraFinal);
        $idReserva=$obReserva->CrearReserva($idEspacio,$DatosCliente["RazonSocial"],$NumDia, $FechaInicio, $FechaFin, $idCliente, $DatosCliente["Telefono"], "", $idUser,$Repite, "");
        if($Repite==1){
            $css->CrearNotificacionVerde("Se ha asignado el Cliente $idCliente el $DiaSemana[$NumDia] a las $Hora", 16);
        }else{
            $css->CrearNotificacionNaranja("Se ha reservado el Cliente $idCliente el $DiaSemana[$NumDia] a las $Hora por un año", 16);
       
        }
    }else{
        $css->VentanaFlotante("Por favor Selecciona un Cliente");
    }
    
}
if(isset($_REQUEST["TxtA"])){
    $idEvento=$obReserva->normalizar($_REQUEST["idEvento"]);
    
    if($_REQUEST["TxtA"]==3){ //Editar Precio
        $DatosEvento=$obReserva->DevuelveValores("reservas_eventos", "ID", $idEvento);
        $Observaciones=$DatosEvento["Observaciones"];
    }else{
        $Observaciones=$obReserva->normalizar($_REQUEST["TxtObservaciones"]);
    }
    if($_REQUEST["TxtA"]==4){ //Facturar
        
        $idEvento=$obReserva->normalizar($_REQUEST["idEvento"]);
        $NumFactura=$obReserva->FacturarReserva($idEspacio, $idEvento, $Fecha,$idUser, "");
        $RutaPrint="PDF_Factura.php?ImgPrintFactura=".$NumFactura;
        $DatosFactura=$obReserva->DevuelveValores("facturas", "idFacturas", $NumFactura);
        
        $css->CrearNotificacionVerde("Factura Creada Correctamente <a href='$RutaPrint' target='_blank'>Imprimir Factura No. $DatosFactura[NumeroFactura]</a>",16);
        if($TipoKardex=="Automatico"){
            register_shutdown_function('Kardex');
        }
        $obReserva->ActualizaRegistro("reservas_eventos", "Estado", "FA", "ID", $idEvento);
        $obReserva->ActualizaRegistro("reservas_eventos", "idFactura", $NumFactura, "ID", $idEvento);
        goto Cronograma;
    }
    if($Observaciones<>''){ 
        $obReserva->ActualizaRegistro("reservas_eventos", "Observaciones", $Observaciones, "ID", $idEvento);
        if($_REQUEST["TxtA"]==1){ //Actualizar Observaciones
            
            $css->VentanaFlotante("Se han actualizado las observaciones del evento $idEvento con: $Observaciones");
            
            
        }
        if($_REQUEST["TxtA"]==2){ //Descartar Reserva
            
            $obReserva->ActualizaRegistro("reservas_eventos", "Estado", "AN", "ID", $idEvento);
            $css->VentanaFlotante("Se ha descartado el evento $idEvento por $Observaciones");
        }
        if($_REQUEST["TxtA"]==3){ //Editar Precio
            $Tarifa=$obReserva->normalizar($_REQUEST["TxtPrecio"]);
            if($Tarifa>=$DatosEspacio["TarifaMinima"]){
                $obReserva->ActualizaRegistro("reservas_eventos", "Tarifa", $Tarifa, "ID", $idEvento);
                $css->VentanaFlotante("Se ha editado el precio del evento $idEvento por ". number_format($Tarifa));
            }else{
                $css->VentanaFlotante("No puedes Seleccionar un valor menor a ".number_format($DatosEspacio["TarifaMinima"])."!");
            }
            
        }
    }else{
        $css->VentanaFlotante("Debe escribir observaciones para modificar este evento");
    }
    
    
    
}
Cronograma:
    $Tag="tag".(date("H")-1);
    
    print('<a id="ancla" href="#'.$Tag.'">Ir a la hora actual</a>');
    
//Totales

$css->CrearDiv("DivTotales", "", "center", 0, 1);
    $sql="SELECT SUM(Tarifa) as Totales,count(ID) as Items, Estado FROM reservas_eventos WHERE `FechaInicio` LIKE '$Fecha%' GROUP BY Estado";
    $Datos=$obReserva->Query($sql);
    
    $css->CrearTabla();
        $css->FilaTabla(16);
            $css->ColTabla("<strong>Tipo</strong>", 1);
            $css->ColTabla("<strong>Items</strong>", 1);
            $css->ColTabla("<strong>Total</strong>", 1);
        $css->CierraFilaTabla();
        $Total=0;
        $TotalItems=0;
        while($DatosSumas=$obReserva->FetchArray($Datos)){
            $Total=$Total+$DatosSumas["Totales"];
            $TotalItems=$TotalItems+$DatosSumas["Items"];
            $css->FilaTabla(16);
                print("<td>");
                    if($DatosSumas["Estado"]=="FA"){
                        $Tipo="FACTURADAS";
                    }
                    if($DatosSumas["Estado"]=="AN"){
                        $Tipo="ANULADAS";
                    }
                    if($DatosSumas["Estado"]=="RE"){
                        $Tipo="RESERVADA";
                    }
                    print($Tipo);
                print("</td>");
                $css->ColTabla($DatosSumas["Items"], 1);
                print("<td style='text-align:right'>");
                    print(number_format($DatosSumas["Totales"]));
                print("</td>");
            $css->CierraFilaTabla();
        }
        $css->FilaTabla(16);
            print("<td style='text-align:right'>");
            print("<strong>Totales</strong>");
            print("</td>");
            $css->ColTabla("<strong>". number_format($TotalItems)."</strong>", 1);
            print("<td style='text-align:right'>");
            print("<strong>". number_format($Total)."</strong>");
            print("</td>");
        $css->CierraFilaTabla();
    $css->CerrarTabla();
$css->CerrarDiv();

//Tabla cronograma
$css->CrearTabla();
    $css->FilaTabla(16);
        $css->ColTabla("<strong>Hora</strong>", 1);
        $css->ColTabla("<strong>Accion</strong>", 1);
        $css->ColTabla("<strong>Cliente</strong>", 1);
        $css->ColTabla("<strong>Telefono</strong>", 1);
        $css->ColTabla("<strong>Observaciones</strong>", 1);
        $css->ColTabla("<strong>Valor</strong>", 1);
        $css->ColTabla("<strong>Facturar</strong>", 1);
    $css->CierraFilaTabla();
    
    for($i=$DatosEspacio["HoraInicial"];$i<=$DatosEspacio["HoraFinal"];$i++){
        $Hora=str_pad($i, 2, "0", STR_PAD_LEFT).":00";
        $FechaBusqueda=$Fecha." ".$Hora.":00";
        $DatosReservas=$obReserva->ValorActual("reservas_eventos", "*", "FechaInicio='$FechaBusqueda' AND idEspacio='$idEspacio' AND Estado<>'AN'");
        $Disable=0;
        if($DatosReservas["Estado"]=='FA'){
            $Disable=1;
            
        }
        $css->FilaTabla(16);
        
            $css->ColTabla($Hora, 1);
            print("<td><A name='tag$i'></a>");
                if($DatosReservas["ID"]>0){
                    
                    $Page="Consultas/ReservaEspacios.query.php?idEspacio=$idEspacio&TxtFecha=$Fecha&idEvento=$DatosReservas[ID]&TxtA=2&TxtObservaciones=";
                    $Javascript="onClick=EnvieObjetoConsulta2(`$Page`,`TxtObservaciones$i`,`DivAgenda`,`99`);return false;";
                    if($Disable==0){
                        
                        $css->CrearImage("ImgDescartar$i", "../images/delete.png", "Descartar", 30, 30, $Javascript);
                        print(" &nbsp;&nbsp; ");
                        $idCliente=$DatosReservas["idCliente"];
                        $Page="Consultas/ReservaEspacios.query.php?idEspacio=$idEspacio&TxtFecha=$Fecha&Hora=$Hora&idCliente=$idCliente&Repite=51&TxtObservaciones=";
                        $Javascript="onClick=EnvieObjetoConsulta2(`$Page`,`TxtObservaciones$i`,`DivAgenda`,`98`);return false;";

                        $css->CrearImage("ImgRepetir$i", "../images/repeat.png", "Repetir este evento durante 1 año", 30, 30, $Javascript);
                        
                    }
                                       
                }else{
                    $Page="Consultas/ReservaEspacios.query.php?idEspacio=$idEspacio&TxtFecha=$Fecha&Hora=$Hora&idCliente=";
                    $Javascript="onClick=EnvieObjetoConsulta2(`$Page`,`CmbTercero`,`DivAgenda`,`99`);return false;";

                    $css->CrearImage("ImgAgregar$i", "../images/agregar2.png", "Agregar", 30, 30, $Javascript);
                }
                
            print("</td>");
            
            print("<td>");
                if($DatosReservas["ID"]>0){
                    
                    $DatosClienteReserva=$obReserva->DevuelveValores("clientes", "idClientes",$DatosReservas["idCliente"] );
                     print($DatosClienteReserva["RazonSocial"]);
                     
                }else{
                    
                }
            print("</td>");
            print("<td>");
                if($DatosReservas["ID"]>0){
                    print($DatosClienteReserva["Telefono"]);
                }
            print("</td>");
            print("<td>");
                if($DatosReservas["ID"]>0){
                    $Page="Consultas/ReservaEspacios.query.php?idEspacio=$idEspacio&TxtFecha=$Fecha&idEvento=$DatosReservas[ID]&TxtA=1&TxtObservaciones=";
                    $Javascript="EnvieObjetoConsulta2(`$Page`,`TxtObservaciones$i`,`DivAgenda`,`99`);return false;";
                    $css->CrearTextArea("TxtObservaciones$i", "", $DatosReservas["Observaciones"], "Observaciones", "", "OnChange", $Javascript, 200, 60, $Disable, 1);
                }
            print("</td>");
            print("<td>");
                if($DatosReservas["ID"]>0){
                    $Page="Consultas/ReservaEspacios.query.php?idEspacio=$idEspacio&TxtFecha=$Fecha&idEvento=$DatosReservas[ID]&TxtA=3&TxtPrecio=";
                    $Javascript="EnvieObjetoConsulta2(`$Page`,`TxtPrecioVenta$i`,`DivAgenda`,`99`);return false;";
                    $css->CrearInputNumber("TxtPrecioVenta$i", "number", "", $DatosReservas["Tarifa"], "Precio", "", "OnChange", $Javascript, 100, 30, $Disable, 1, $DatosEspacio["TarifaMinima"], "", 1);
                }
            print("</td>");
            print("<td>");
                if($DatosReservas["ID"]>0){
                    
                    $Page="Consultas/ReservaEspacios.query.php?idEspacio=$idEspacio&TxtFecha=$Fecha&idEvento=$DatosReservas[ID]&TxtA=4&TxtObservaciones=";
                    $Javascript="onClick=EnvieObjetoConsulta(`$Page`,`TxtObservaciones$i`,`DivAgenda`,`5`);return false;";
                    if($Disable==0){
                        $css->CrearImage("ImgFacturar$i", "../images/facturar1.png", "Facturar", 30, 30, $Javascript);
                    }else{
                        $css->CrearImage("ImgFacturado$i", "../images/facturado.png", "Facturado", 60, 100, "");
                    }
                }
            print("</td>");
        $css->CierraFilaTabla();
    }
    
$css->CerrarTabla();

?>