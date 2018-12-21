<?php

$myTabla="restaurante_pedidos_items";
$MyID="ID";
$myPage="restaurante_pedidos_items.php";
$myTitulo="Historial de items Pedidos";



/////Asigno Datos necesarios para la visualizacion de la tabla en el formato que se desea
////
///
//print($statement);
$Vector["Tabla"]=$myTabla;          //Tabla
$Vector["Titulo"]=$myTitulo;        //Titulo
$Vector["VerDesde"]=$startpoint;    //Punto desde donde empieza
$Vector["Limit"]=$limit;            //Numero de Registros a mostrar
$Vector["MyPage"]=$myPage;
/*
 * Deshabilito Acciones
 * 
 */

$Vector["NuevoRegistro"]["Deshabilitado"]=1;            
$Vector["VerRegistro"]["Deshabilitado"]=1;                      
$Vector["EditarRegistro"]["Deshabilitado"]=1;  


//Link para la accion ver
$Ruta="$myPage?idPedido=";
$Vector["VerRegistro"]["Link"]=$Ruta;
$Vector["VerRegistro"]["ColumnaLink"]="ID";

                 //Columna que quiero mostrar

///Filtros y orden
$Vector["Order"]=" $MyID DESC ";   //Orden
?>