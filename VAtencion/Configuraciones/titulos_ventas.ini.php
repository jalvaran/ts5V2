<?php

$myTabla="titulos_ventas";
$idTabla="ID";
$myPage="titulos_ventas.php";
$myTitulo="Historial de Ventas de titulos";



/////Asigno Datos necesarios para la visualizacion de la tabla en el formato que se desea
////
///
//print($statement);
$Vector["Tabla"]=$myTabla;          //Tabla
$Vector["Titulo"]=$myTitulo;        //Titulo
$Vector["VerDesde"]=$startpoint;    //Punto desde donde empieza
$Vector["Limit"]=$limit;            //Numero de Registros a mostrar

/*
 * Deshabilito Acciones
 * 
 */

        
$Vector["NuevoRegistro"]["Deshabilitado"]=1;            
$Vector["VerRegistro"]["Deshabilitado"]=1;                      
$Vector["EditarRegistro"]["Deshabilitado"]=1; 

//Link para la accion ver
$Ruta="../tcpdf/examples/comprobantecontable.php?idComprobante=";
$Vector["VerRegistro"]["Link"]=$Ruta;
$Vector["VerRegistro"]["ColumnaLink"]="idComprobanteContable";



// Nueva Accion
$Ruta="DevolverVenta.php?idVenta=";
$Vector["NuevaAccionLink"][0]="Asociar";
$Vector["NuevaAccion"]["Asociar"]["Titulo"]=" Devolver ";
$Vector["NuevaAccion"]["Asociar"]["Link"]=$Ruta;
$Vector["NuevaAccion"]["Asociar"]["ColumnaLink"]="ID";
$Vector["NuevaAccion"]["Asociar"]["Target"]="_self";

/*
 * Datos vinculados
 * 
 */


/*
 * 
 * Requeridos
 */


///Filtros y orden
$Vector["Order"]=" $idTabla DESC ";   //Orden
?>