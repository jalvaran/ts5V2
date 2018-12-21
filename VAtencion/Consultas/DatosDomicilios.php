<?php
$Valida = intval($_GET['Valida']);
session_start();
$idUser=$_SESSION["idUser"];
$myPage="AtencionDomicilios.php";
include_once("../../modelo/php_conexion.php");
include_once("../../modelo/php_tablas.php");
include_once("../css_construct.php");

$css =  new CssIni("");
$obVenta = new ProcesoVenta($idUser);
$Valida=$obVenta->normalizar($_GET['Valida']);

if($Valida==1){
    
    $consulta=$obVenta->ConsultarTabla("restaurante_pedidos", " WHERE Estado='DO'");
    if($obVenta->NumRows($consulta)){
               
        while($DatosPedido=$obVenta->FetchArray($consulta)){
            $DatosMesa=$obVenta->DevuelveValores("restaurante_mesas", "ID", $DatosPedido["idMesa"]);
            $idPedido=$DatosPedido["ID"];
            $css->CrearNotificacionRoja("Domicilio No: $idPedido, para $DatosPedido[NombreCliente], $DatosPedido[DireccionEnvio], $DatosPedido[TelefonoConfirmacion]", 16);
            $css->CrearTabla();
            $css->FilaTabla(16);
            $css->ColTabla('<strong>Fecha</strong>', 1);
            $css->ColTabla("<strong>Cliente</strong>", 1);
            $css->ColTabla('<strong>Direccion</strong>', 1);
            $css->ColTabla('<strong>Descartar</strong>', 1);
            $css->ColTabla('<strong>Domicilio</strong>', 1);
            $css->ColTabla('<strong>Precuenta</strong>', 1);
            $css->ColTabla('<strong>Facturar</strong>', 1);
            $css->CierraFilaTabla();
                
                $idUsuarioPedido=$DatosPedido["idUsuario"];
                
                $sql="SELECT Nombre, Apellido FROM usuarios WHERE idUsuarios='$idUsuarioPedido'";
                $DatosUsuario=$obVenta->Query($sql);
                $DatosUsuario=$obVenta->FetchArray($DatosUsuario);
                $NombreUsuario=$DatosUsuario["Nombre"]." ".$DatosUsuario["Apellido"];
                $css->FilaTabla(16);
                $css->ColTabla($DatosPedido["FechaCreacion"], 1);
                $css->ColTabla($DatosPedido["NombreCliente"]." ".$DatosPedido["TelefonoConfirmacion"], 1);
                $css->ColTabla($DatosPedido["DireccionEnvio"], 1);
                
                print("<td style='text-align:center'>");
                $ImageAlterna="../images/anular.png";
                $RutaImage=$ImageAlterna;
                $Nombre="ImgDescartar".$DatosPedido["ID"];
                $Page="ProcesadoresJS/ProcesaAccionesJS.php?idAccion=2&idPedido=$idPedido&Carry=";
                $FuncionJS="onclick='EnvieObjetoConsulta(`$Page`,`$Nombre`,`DivMensajes`,`9`);return false ;'";
                $css->CrearImage($Nombre, $RutaImage, $ImageAlterna, 50, 50,$FuncionJS);
                print("</td>");
                print("<td style='text-align:center'>");
                $ImageAlterna="../images/print.png";
                $RutaImage=$ImageAlterna;
                $Nombre="ImgDescartar".$DatosPedido["ID"];
                $Page="ProcesadoresJS/ProcesaAccionesJS.php?idAccion=3&idPedido=$idPedido&Carry=";
                $FuncionJS="onclick='EnvieObjetoConsulta(`$Page`,`$Nombre`,`DivMensajes`,`NO`);return false ;'";
                $css->CrearImage($Nombre, $RutaImage, $ImageAlterna, 50, 50,$FuncionJS);
                
                print("</td>");
                print("<td style='text-align:center'>");
                $ImageAlterna="../images/precuenta.png";
                $RutaImage=$ImageAlterna;
                $Nombre="ImgDescartar".$DatosPedido["ID"];
                $Page="ProcesadoresJS/ProcesaAccionesJS.php?idAccion=5&idPedido=$idPedido&Carry=";
                $FuncionJS="onclick='EnvieObjetoConsulta(`$Page`,`$Nombre`,`DivMensajes`,`NO`);return false ;'";
                $css->CrearImage($Nombre, $RutaImage, $ImageAlterna, 50, 50,$FuncionJS);
                
                print("</td>");
                print("<td style='text-align:center'>");
                $RutaImage="../images/facturar2.png";
                $Link=$myPage."?BtnFacturarDomicilio=$DatosPedido[ID]";
                $css->CrearImageLink($Link, $RutaImage, "_self", 50, 50);
                print("</td>");
                $css->CierraFilaTabla();
                $css->FilaTabla(16);
                $css->ColTabla('<strong>Producto</strong>', 3);
                $css->ColTabla('<strong>Observaciones</strong>', 1);
                $css->ColTabla('<strong>Cantidad</strong>', 1);
                $css->ColTabla('<strong>Total</strong>', 1);
                $css->ColTabla('<strong>Borrar</strong>', 1);
                $css->CierraFilaTabla();
                $Datos=$obVenta->ConsultarTabla("restaurante_pedidos_items", " WHERE idPedido='$idPedido'");
                $SubTotal=0;
                $IVA=0;
                $Total=0;
                while($ItemsPedido=$obVenta->FetchArray($Datos)){
                    $idItem=$ItemsPedido["ID"];
                    $SubTotal=$SubTotal+$ItemsPedido["Subtotal"];
                    $IVA=$IVA+$ItemsPedido["IVA"];
                    $Total=$Total+$ItemsPedido["Total"];
                    $css->FilaTabla(16);
                    $css->ColTabla($ItemsPedido["NombreProducto"], 3);
                    $css->ColTabla($ItemsPedido["Observaciones"], 1);
                    $css->ColTabla($ItemsPedido["Cantidad"], 1);
                    $css->ColTabla(number_format($ItemsPedido["Total"]), 1,"R");
                    print("<td style='text-align:center'>");
                        $ImageAlterna="../images/eliminar.png";
                        $RutaImage=$ImageAlterna;
                        $Nombre="ImgBorrar".$DatosPedido["ID"];
                        $Page="ProcesadoresJS/ProcesaAccionesJS.php?idAccion=6&idTbl=ID&Tbl=restaurante_pedidos_items&idItemDel=$idItem&Carry=";
                        $FuncionJS="onclick='EnvieObjetoConsulta(`$Page`,`$Nombre`,`DivMensajes`,`10`);return false ;'";
                        $css->CrearImage($Nombre, $RutaImage, $ImageAlterna, 20, 20,$FuncionJS);
                    print("</td>");
                    $css->CierraFilaTabla();
                }
            
            $css->FilaTabla(16);
                $css->ColTabla("<strong>Subtotal:</strong>", 5,"R");
                $css->ColTabla("<strong>$".number_format($SubTotal)."</strong>", 2,"R");
            $css->CierraFilaTabla();
            $css->FilaTabla(16);
                $css->ColTabla("<strong>IVA:</strong>", 5,"R");
                $css->ColTabla("<strong>$".number_format($IVA)."</strong>", 2,"R");
            $css->CierraFilaTabla();
            $css->FilaTabla(16);
                $css->ColTabla("<strong>Total:</strong>", 5,"R");
                $css->ColTabla("<strong>$".number_format($Total)."</strong>", 2,"R");
            $css->CierraFilaTabla();
            $css->CerrarTabla();
        }
       
        
    }else{
        $css->CrearNotificacionNaranja("No hay domicilios en este momento", 16);
    }
    
}else{
    $css->CrearNotificacionRoja("No se ha recibido un parametro valido", 16);
}

?>