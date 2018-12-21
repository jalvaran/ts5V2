<?php

$myTabla="vista_pedidos_restaurante";
$MyID="ID";
$myPage="restaurante_pedidos.php";
$myTitulo="Historial de Pedidos";



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
//$Vector["VerRegistro"]["Deshabilitado"]=1;                      
$Vector["EditarRegistro"]["Deshabilitado"]=1;  


//Link para la accion ver
$Ruta="$myPage?idPedido=";
$Vector["VerRegistro"]["Link"]=$Ruta;
$Vector["VerRegistro"]["ColumnaLink"]="ID";

/*
 * 
 * Selecciono las Columnas que tendran valores de otras tablas
 */

$Vector["idUsuario"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["idUsuario"]["TablaVinculo"]="usuarios";  //tabla de donde se vincula
$Vector["idUsuario"]["IDTabla"]="idUsuarios"; //id de la tabla que se vincula
$Vector["idUsuario"]["Display"]="Apellido";                    //Columna que quiero mostrar

///Filtros y orden
$Vector["Order"]=" $MyID DESC ";   //Orden
?>