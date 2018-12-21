<?php
$obVenta = new ProcesoVenta($idUser);
$DatosEmpresa=$obVenta->DevuelveValores("empresapro", "idEmpresaPro", 1);
$myTabla="vista_sistemas";
$idTabla="ID";
$myPage="vista_sistemas.php";
$myTitulo="Sistemas Consolidado";

/*
 * Opciones en Acciones
 * 
 */

$Vector["NuevoRegistro"]["Deshabilitado"]=1;            
$Vector["VerRegistro"]["Deshabilitado"]=1;                      
$Vector["EditarRegistro"]["Deshabilitado"]=1; 

/////Asigno Datos necesarios para la visualizacion de la tabla en el formato que se desea
////
///
//print($statement);
$Vector["Tabla"]=$myTabla;          //Tabla
$Vector["Titulo"]=$myTitulo;        //Titulo
$Vector["VerDesde"]=$startpoint;    //Punto desde donde empieza
$Vector["Limit"]=$limit;            //Numero de Registros a mostrar
$Vector["MyPage"]=$myPage;            //pagina
///Columnas excluidas

//Link para la accion ver
$Ruta="../tcpdf/examples/imprimirOT.php?idOT=";
$Vector["VerRegistro"]["Link"]=$Ruta;
$Vector["VerRegistro"]["ColumnaLink"]="ID";

$Vector["Excluir"]["Estado"]=1;


//Nueva Accion
$Ruta="CreaSistema.php?Abrir=1&idSistema=";
$Vector["NuevaAccionLink"][0]="EditarSistema";
$Vector["NuevaAccion"]["EditarSistema"]["Titulo"]="Editar";
$Vector["NuevaAccion"]["EditarSistema"]["Link"]=$Ruta;
$Vector["NuevaAccion"]["EditarSistema"]["ColumnaLink"]="idSistema";
$Vector["NuevaAccion"]["EditarSistema"]["Target"]="_self";

///Filtros y orden
$Vector["Order"]=" $idTabla DESC ";   //Orden
?>