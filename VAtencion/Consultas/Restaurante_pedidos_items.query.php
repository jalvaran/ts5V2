<?php
include_once("../../modelo/php_conexion.php");
include_once("../css_construct.php");
include_once("../clases/Restaurante.class.php");

session_start();
$idUser=$_SESSION['idUser'];
$TipoUser=$_SESSION['tipouser'];
$css =  new CssIni("",0);

$obRest=new Restaurante($idUser);

if(isset($_REQUEST["idPedido"])){
    $idPedido=$obRest->normalizar($_REQUEST["idPedido"]);
    $TotalPedido=$obRest->SumeColumna("restaurante_pedidos_items", "Total", "idPedido", $idPedido);
    
    $DatosPedido=$obRest->DevuelveValores("restaurante_pedidos", "ID", $idPedido);
    if(!empty($_REQUEST["Opciones"])){
    $css->CrearTabla();
        $css->FilaTabla(16);
            //$css->ColTabla("Mesa", 1);
            $css->ColTabla("Agregar", 1);
            
        $css->CierraFilaTabla();    
        $css->FilaTabla(16);
            
            print("<td colspan=4 style='text-align:center'>");
                /*  Para busqueda de items
                $css->CrearDiv("DivText","","center",1,0);
                $css->CrearInputText("TxtBusquedaItems", "text", "", "", "Buscar", "", "onkeyup", "BuscarItemsRestaurante()", 300, 30, 0, 0);
                print("<br>");
                $Styles="max-height:100px;width:300px;overflow: auto;";
                $css->CrearDiv("DivBusquedaItems", "", "center", 0, 0,$Styles);
               
                $css->CerrarDiv();
                $css->CerrarDiv();
                 * 
                 */
                print("<br>");
                $css->CrearSelect("idDepartamento", "CargarProductos()", 300);
                    $Datos=$obRest->ConsultarTabla("prod_departamentos", " ORDER BY Nombre");
                    $css->CrearOptionSelect("", "Departamento", 0);
                    $css->CrearOptionSelect("Todos", "Todos", 0);
                    while ($DatosDepartamentos=$obRest->FetchArray($Datos)){
                        $css->CrearOptionSelect2($DatosDepartamentos["idDepartamentos"], $DatosDepartamentos["Nombre"], "", 0);
                        
                    }
                $css->CerrarSelect();
                print("<br>");
                $css->CrearInputNumber("Cantidad", "number", "", 1, "Cantidad", "", "", "", 100, 50, 0, 0, 0, '', "any","font-size:3em;");
                print("<br>");
                $css->CrearSelect("idProducto", "", 300);
                    
                    $css->CrearOptionSelect("", "Producto", 0);
                    
                $css->CerrarSelect();
                
                
                print("<br>");
                $css->CrearTextArea("Observaciones", "", "", "Observaciones", "", "", "", 300, 60, 0, 0);
                print("<br>");
                $evento="onClick";
                //$funcion="EnvieObjetoConsulta2(`$Page`,`Observaciones`,`DivPedidos`,`9`);return false;";
                $funcion="AgregarItemPedido($idPedido)";
                $css->CrearBotonEvento("BtnAgregarPedido", "Agregar", 1, $evento, $funcion, "rojo", "");
            print("</td>");
            
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
            if($TipoUser=="administrador"){
                $css->ColTabla("<strong>Descartar</strong>", 1);
            }
           $css->ColTabla("<strong>Pedido</strong>", 1);
           $css->ColTabla("<strong>Precuenta</strong>", 1);
           $css->ColTabla("<strong>Facturar</strong>", 1);
           if($TipoUser=="administrador"){
                $css->ColTabla("<strong>FSI</strong>", 1);
           }
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
        
           print("<td style='text-align:center'>");
                $ImageAlterna="../images/anular.png";
                $RutaImage=$ImageAlterna;
                $Nombre="ImgDescartar".$DatosPedido["ID"];
                if($DatosPedido["Estado"]=="AB"){
                    $FuncionJS="onclick='DescartarPedido(1,`$idPedido`)'";
                }
                if($DatosPedido["Estado"]=="DO"){
                    $FuncionJS="onclick='DescartarPedido(2,`$idPedido`)'";
                }
                if($DatosPedido["Estado"]=="LL"){
                    $FuncionJS="onclick='DescartarPedido(3,`$idPedido`)'";
                }
                
                if($TipoUser=="administrador"){
                    $css->CrearImage($Nombre, $RutaImage, $ImageAlterna, 50, 50,$FuncionJS);
                }
                print("</td>");
                print("<td style='text-align:center'>");
                $ImageAlterna="../images/print.png";
                $RutaImage=$ImageAlterna;
                $Nombre="ImgDescartar".$DatosPedido["ID"];
                
                if($DatosPedido["Estado"]=="AB"){
                    $FuncionJS="onclick='AccionesPedidos(4,`$idPedido`)'"; //Imprime pedido
                }
                if($DatosPedido["Estado"]=="DO"){
                    $FuncionJS="onclick='AccionesPedidos(5,`$idPedido`)'"; //imprime domicilio
                }
                if($DatosPedido["Estado"]=="LL"){
                    $FuncionJS="onclick='AccionesPedidos(6,`$idPedido`)'"; //imprime para llevar
                }
                
                $css->CrearImage($Nombre, $RutaImage, $ImageAlterna, 50, 50,$FuncionJS);
                
                print("</td>");
                print("<td style='text-align:center'>");
                $ImageAlterna="../images/precuenta.png";
                $RutaImage=$ImageAlterna;
                $Nombre="ImgDescartar".$DatosPedido["ID"];
                
                $FuncionJS="onclick='AccionesPedidos(7,`$idPedido`)'"; //imprime precuenta
                $css->CrearImage($Nombre, $RutaImage, $ImageAlterna, 50, 50,$FuncionJS);
                
                print("</td>");
                print("<td style='text-align:center'>");
                $RutaImage="../images/facturar2.png";
                $Nombre="ImgFacturar".$DatosPedido["ID"];
                
                $FuncionJS="onclick='DibujeAreaFacturar(`$idPedido`)'"; //Dibuja las opciones para facturar un pedido
                $css->CrearImage($Nombre, $RutaImage, $ImageAlterna, 50, 50,$FuncionJS);
                print("</td>");
                if($TipoUser=="administrador"){
                    print("<td style='text-align:center'>");
                    $RutaImage="../images/facturar3.png";
                    $Nombre="ImgFacturar".$DatosPedido["ID"];

                    $FuncionJS="onclick='FacturarPedido(`$idPedido`,`1`)'"; //Dibuja las opciones para facturar un pedido
                    $css->CrearImage($Nombre, $RutaImage, $ImageAlterna, 50, 50,$FuncionJS);
                    print("</td>");
                }    
        $css->CierraFilaTabla();
    $css->CerrarTabla();
    
    }
    $css->CrearDiv("DivItemsConsultas", "", "", 1, 1);
   
    if($DatosPedido["Estado"]=="AB"){
        $css->CrearNotificacionNaranja("P_$idPedido, Mesa = $DatosPedido[idMesa], Total: $".number_format($TotalPedido), 16);
    }
    if($DatosPedido["Estado"]=="DO"){
        $css->CrearNotificacionRoja("Domicilio: $idPedido, a nombre de:$DatosPedido[NombreCliente], Total: $".number_format($TotalPedido), 16);
    }
    if($DatosPedido["Estado"]=="LL"){
        $css->CrearNotificacionVerde("Para Llevar No: $idPedido, a nombre de:$DatosPedido[NombreCliente], Total: $".number_format($TotalPedido), 16);
    }
    
    $consulta=$obRest->ConsultarTabla("restaurante_pedidos_items", " WHERE idPedido='$idPedido' ORDER BY ID DESC");
    if($obRest->NumRows($consulta)){
        $css->CrearTabla();
        $css->FilaTabla(16);
            $css->ColTabla("<strong>Cant</strong>", 1);
            $css->ColTabla("<strong>Nombre</strong>", 1);
            $css->ColTabla("<strong>Total</strong>", 1);
            $css->ColTabla("<strong>Opciones</strong>", 1);
            
        $css->CierraFilaTabla();
        while($DatosPedidos=$obRest->FetchArray($consulta)){
            $css->FilaTabla(14);
            $css->ColTabla($DatosPedidos["Cantidad"], 1);
            print("<td>");
                print($DatosPedidos["NombreProducto"]);
                if($DatosPedidos["Observaciones"]<>""){
                    print("<br><strong>Observaciones:</strong><br>".$DatosPedidos["Observaciones"]);
                }
            print("</td>");
            
            $css->ColTabla(number_format($DatosPedidos["Total"]), 1);
            
            print("<td>");
                $idItem=$DatosPedidos["ID"];
                
                //$Page="Consultas/Restaurante_pedidos_items.query.php?idPedido=".$DatosPedidos["ID"]."&carry=";
                $evento="onClick";
                //$funcion="EnvieObjetoConsulta(`$Page`,`BtnPedidos`,`DivItems`,`99`);return false;";
                $funcion="ObservacionesEliminarItemPedido(`$idItem`,`$idPedido`);";
                if($TipoUser=="administrador"){
                    $css->CrearBotonEvento("BtnEliminar".$idItem, "x", 1, $evento, $funcion, "rojo", "");
                }
            print("</td>");
        $css->CierraFilaTabla();
        }

        $css->CerrarTabla();
    }
    $css->CerrarDiv();
}
?>