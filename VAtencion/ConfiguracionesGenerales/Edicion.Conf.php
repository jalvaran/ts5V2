<?php
/*
 * Parametros de configuracion productosventa
 * Columnas Excluidas
 */
$TablaConfig="productosventa";
$Vector[$TablaConfig]["Excluir"]["CodigoBarras"]=1;
$Vector[$TablaConfig]["Excluir"]["Existencias"]=1;
//$Vector[$TablaConfig]["Excluir"]["Especial"]=1;
$Vector[$TablaConfig]["Excluir"]["Kit"]=1;
//$Vector[$TablaConfig]["Excluir"]["CostoTotal"]=1;
//$Vector[$TablaConfig]["Excluir"]["CostoUnitario"]=1;
///Columnas requeridas al momento de una insercion
$Vector[$TablaConfig]["Required"]["Departamento"]=1;   
$Vector[$TablaConfig]["Required"]["Nombre"]=1; 
$Vector[$TablaConfig]["Required"]["PrecioVenta"]=1;
$Vector[$TablaConfig]["Required"]["CostoUnitario"]=1;
$Vector[$TablaConfig]["Required"]["CostoTotal"]=1;
$Vector[$TablaConfig]["Required"]["IVA"]=1;
$Vector[$TablaConfig]["Required"]["Bodega_idBodega"]=1;
$Vector[$TablaConfig]["Required"]["CuentaPUC"]=1;

//Selecciono las Columnas que tendran valores de otras tablas
//
//
$Vector[$TablaConfig]["CodigoBarras"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector[$TablaConfig]["CodigoBarras"]["TablaVinculo"]="prod_codbarras";  //tabla de donde se vincula
$Vector[$TablaConfig]["CodigoBarras"]["IDTabla"]="ProductosVenta_idProductosVenta"; //id de la tabla que se vincula
$Vector[$TablaConfig]["CodigoBarras"]["Display"]="CodigoBarras";                    //Columna que quiero mostrar
$Vector[$TablaConfig]["CodigoBarras"]["Predeterminado"]="N";

$Vector[$TablaConfig]["IVA"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector[$TablaConfig]["IVA"]["TablaVinculo"]="porcentajes_iva";  //tabla de donde se vincula
$Vector[$TablaConfig]["IVA"]["IDTabla"]="Valor"; //id de la tabla que se vincula
$Vector[$TablaConfig]["IVA"]["Display"]="Nombre"; 
$Vector[$TablaConfig]["IVA"]["Predeterminado"]=0;

$Vector[$TablaConfig]["Bodega_idBodega"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector[$TablaConfig]["Bodega_idBodega"]["TablaVinculo"]="bodega";  //tabla de donde se vincula
$Vector[$TablaConfig]["Bodega_idBodega"]["IDTabla"]="idBodega"; //id de la tabla que se vincula
$Vector[$TablaConfig]["Bodega_idBodega"]["Display"]="Nombre";                    //Columna que quiero mostrar
$Vector[$TablaConfig]["Bodega_idBodega"]["Predeterminado"]=1;

$Vector[$TablaConfig]["Departamento"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector[$TablaConfig]["Departamento"]["TablaVinculo"]="prod_departamentos";  //tabla de donde se vincula
$Vector[$TablaConfig]["Departamento"]["IDTabla"]="idDepartamentos"; //id de la tabla que se vincula
$Vector[$TablaConfig]["Departamento"]["Display"]="Nombre";                    //Columna que quiero mostrar
$Vector[$TablaConfig]["Departamento"]["Predeterminado"]="N";

$Vector[$TablaConfig]["Sub1"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector[$TablaConfig]["Sub1"]["TablaVinculo"]="prod_sub1";  //tabla de donde se vincula
$Vector[$TablaConfig]["Sub1"]["IDTabla"]="idSub1"; //id de la tabla que se vincula
$Vector[$TablaConfig]["Sub1"]["Display"]="NombreSub1";                    //Columna que quiero mostrar

$Vector[$TablaConfig]["Sub2"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector[$TablaConfig]["Sub2"]["TablaVinculo"]="prod_sub2";  //tabla de donde se vincula
$Vector[$TablaConfig]["Sub2"]["IDTabla"]="idSub2"; //id de la tabla que se vincula
$Vector[$TablaConfig]["Sub2"]["Display"]="NombreSub2";                    //Columna que quiero mostrar

$Vector[$TablaConfig]["Sub3"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector[$TablaConfig]["Sub3"]["TablaVinculo"]="prod_sub3";  //tabla de donde se vincula
$Vector[$TablaConfig]["Sub3"]["IDTabla"]="idSub3"; //id de la tabla que se vincula
$Vector[$TablaConfig]["Sub3"]["Display"]="NombreSub3";                    //Columna que quiero mostrar

$Vector[$TablaConfig]["Sub4"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector[$TablaConfig]["Sub4"]["TablaVinculo"]="prod_sub4";  //tabla de donde se vincula
$Vector[$TablaConfig]["Sub4"]["IDTabla"]="idSub4"; //id de la tabla que se vincula
$Vector[$TablaConfig]["Sub4"]["Display"]="NombreSub4";                    //Columna que quiero mostrar
//
$Vector[$TablaConfig]["Sub5"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector[$TablaConfig]["Sub5"]["TablaVinculo"]="prod_sub5";  //tabla de donde se vincula
$Vector[$TablaConfig]["Sub5"]["IDTabla"]="idSub5"; //id de la tabla que se vincula
$Vector[$TablaConfig]["Sub5"]["Display"]="NombreSub5";                    //Columna que quiero mostrar

$Vector[$TablaConfig]["Sub6"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector[$TablaConfig]["Sub6"]["TablaVinculo"]="prod_sub6";  //tabla de donde se vincula
$Vector[$TablaConfig]["Sub6"]["IDTabla"]="idSub6"; //id de la tabla que se vincula
$Vector[$TablaConfig]["Sub6"]["Display"]="NombreSub6";                    //Columna que quiero mostrar

/*
 * Parametros de configuracion Tabla facturas
 * Columnas Excluidas
 */

$TablaConfig="facturas";


$Vector[$TablaConfig]["FormaPago"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector[$TablaConfig]["FormaPago"]["TablaVinculo"]="facturas_tipo_pago";  //tabla de donde se vincula
$Vector[$TablaConfig]["FormaPago"]["IDTabla"]="TipoPago"; //id de la tabla que se vincula
$Vector[$TablaConfig]["FormaPago"]["Display"]="Leyenda"; 
$Vector[$TablaConfig]["FormaPago"]["Predeterminado"]=0;

$Vector[$TablaConfig]["Clientes_idClientes"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector[$TablaConfig]["Clientes_idClientes"]["TablaVinculo"]="clientes";  //tabla de donde se vincula
$Vector[$TablaConfig]["Clientes_idClientes"]["IDTabla"]="idClientes"; //id de la tabla que se vincula
$Vector[$TablaConfig]["Clientes_idClientes"]["Display"]="RazonSocial"; 
$Vector[$TablaConfig]["Clientes_idClientes"]["Predeterminado"]=0;
/*
 * Parametros de configuracion Tabla facturas_items
 * Columnas Excluidas
 */

$TablaConfig="facturas_items";
$Vector[$TablaConfig]["Excluir"]["SubGrupo1"]=1;
$Vector[$TablaConfig]["Excluir"]["SubGrupo2"]=1;
$Vector[$TablaConfig]["Excluir"]["SubGrupo3"]=1;
$Vector[$TablaConfig]["Excluir"]["SubGrupo4"]=1;
$Vector[$TablaConfig]["Excluir"]["SubGrupo5"]=1;
$Vector[$TablaConfig]["Excluir"]["SubtotalItem"]=1;
$Vector[$TablaConfig]["Excluir"]["IVAItem"]=1;
$Vector[$TablaConfig]["Excluir"]["TotalItem"]=1;
$Vector[$TablaConfig]["Excluir"]["PorcentajeIVA"]=1;
$Vector[$TablaConfig]["Excluir"]["PrecioCostoUnitario"]=1;
$Vector[$TablaConfig]["Excluir"]["SubtotalCosto"]=1;
$Vector[$TablaConfig]["Excluir"]["TipoItem"]=1;
$Vector[$TablaConfig]["Excluir"]["CuentaPUC"]=1;
$Vector[$TablaConfig]["Excluir"]["GeneradoDesde"]=1;
$Vector[$TablaConfig]["Excluir"]["NumeroIdentificador"]=1;
$Vector[$TablaConfig]["Excluir"]["FechaFactura"]=1;
$Vector[$TablaConfig]["Excluir"]["idFactura"]=1;
$Vector[$TablaConfig]["Excluir"]["TablaItems"]=1;
$Vector[$TablaConfig]["Excluir"]["Referencia"]=1;
$Vector[$TablaConfig]["Excluir"]["Departamento"]=1;
$Vector[$TablaConfig]["Excluir"]["ValorUnitarioItem"]=1;
$Vector[$TablaConfig]["Excluir"]["Cantidad"]=1;

/*
 * Campos Requridos
 */

$Vector[$TablaConfig]["Required"]["Dias"]=1;

/*
 * Tabla Usuarios
 * Tipo de Texto
 */
$TablaConfig="usuarios";
$Vector[$TablaConfig]["Password"]["TipoText"]="password";


/*
 * Tabla librodiario
 * 
 * Campos Requridos
 */
$TablaConfig="librodiario";
$Vector[$TablaConfig]["Required"]["idEmpresa"]=1;
$Vector[$TablaConfig]["Required"]["idCentroCosto"]=1;


/*
 * Parametros de configuracion subcuentas
 * Columnas Excluidas
 */
$TablaConfig="subcuentas";
$Vector[$TablaConfig]["Excluir"]["Valor"]=1;

/*
 * Parametros de configuracion subcuentas
 * CAmpos requeridos y Columnas Excluidas
 */
$TablaConfig="cuentasfrecuentes";
$Vector[$TablaConfig]["Required"]["ClaseCuenta"]=1;
$Vector[$TablaConfig]["Excluir"]["UsoFuturo"]=1;

/*
 * Tabla cot_itemscotizaciones
 * 
 * Campos Requridos
 */
$TablaConfig="cot_itemscotizaciones";
$Vector[$TablaConfig]["Required"]["CuentaPUC"]=1;

/*
 * Tabla remisiones
 * 
 * Campos Requeridos
 */
$TablaConfig="remisiones";
$Vector[$TablaConfig]["Required"]["Usuarios_idUsuarios"]=1;
$Vector[$TablaConfig]["MyPage"]="historialremisiones.php";
$Vector[$TablaConfig]["Excluir"]["Cotizaciones_idCotizaciones"]=1;
$Vector[$TablaConfig]["Excluir"]["Anticipo"]=1;


/*
 * Tabla ordenesdetrabajo
 * Tipo de ordenesdetrabajo
 * Campos Requridos
 */
$TablaConfig="ordenesdetrabajo";
$Vector[$TablaConfig]["Required"]["Hora"]=1;
$Vector[$TablaConfig]["Required"]["idCliente"]=1;
$Vector[$TablaConfig]["Required"]["idUsuarioCreador"]=1;
$Vector[$TablaConfig]["Required"]["Descripcion"]=1;
$Vector[$TablaConfig]["Required"]["FechaOT"]=1;
$Vector[$TablaConfig]["Excluir"]["Estado"]=1;

/*
 * Tabla cotizacionesv5
 * 
 * 
 */
$TablaConfig="cotizacionesv5";
$Vector[$TablaConfig]["Required"]["Seguimiento"]=1;
$Vector[$TablaConfig]["Excluir"]["NumSolicitud"]=1;
$Vector[$TablaConfig]["Excluir"]["NumOrden"]=1;
$Vector[$TablaConfig]["Excluir"]["Usuarios_idUsuarios"]=1;
//$Vector[$TablaConfig]["Fecha"]["Excluir"]=1;

/*
 * Tabla ordenes de compra
 * 
 * 
 */
$TablaConfig="ordenesdecompra";

$Vector[$TablaConfig]["Excluir"]["Created"]=1;
$Vector[$TablaConfig]["Excluir"]["UsuarioCreador"]=1;

/*
 * Parametros de configuracion cartera
 * Columnas Excluidas
 */
$TablaConfig="cartera";
$Vector[$TablaConfig]["Excluir"]["Facturas_idFacturas"]=1;
$Vector[$TablaConfig]["Excluir"]["FechaIngreso"]=1;
$Vector[$TablaConfig]["Excluir"]["FechaVencimiento"]=1;
$Vector[$TablaConfig]["Excluir"]["DiasCartera"]=1;
$Vector[$TablaConfig]["Excluir"]["idCliente"]=1;
$Vector[$TablaConfig]["Excluir"]["RazonSocial"]=1;
$Vector[$TablaConfig]["Excluir"]["Telefono"]=1;
$Vector[$TablaConfig]["Excluir"]["Contacto"]=1;
$Vector[$TablaConfig]["Excluir"]["TelContacto"]=1;
$Vector[$TablaConfig]["Excluir"]["TotalFactura"]=1;
$Vector[$TablaConfig]["Excluir"]["TotalAbonos"]=1;
$Vector[$TablaConfig]["Excluir"]["Saldo"]=1;
$Vector[$TablaConfig]["Excluir"]["idUsuarios"]=1;
$Vector[$TablaConfig]["Excluir"]["TipoCartera"]=1;

/*
 * Tabla departamentos
 * 
 * 
 */
$TablaConfig="prod_departamentos";
$Vector[$TablaConfig]["TablaOrigen"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector[$TablaConfig]["TablaOrigen"]["TablaVinculo"]="tablas_ventas";  //tabla de donde se vincula
$Vector[$TablaConfig]["TablaOrigen"]["IDTabla"]="NombreTabla"; //id de la tabla que se vincula
$Vector[$TablaConfig]["TablaOrigen"]["Display"]="NombreTabla"; 
$Vector[$TablaConfig]["TablaOrigen"]["Predeterminado"]=1;

$Vector[$TablaConfig]["ManejaExistencias"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector[$TablaConfig]["ManejaExistencias"]["TablaVinculo"]="respuestas_condicional";  //tabla de donde se vincula
$Vector[$TablaConfig]["ManejaExistencias"]["IDTabla"]="Valor"; //id de la tabla que se vincula
$Vector[$TablaConfig]["ManejaExistencias"]["Display"]="Valor"; 
$Vector[$TablaConfig]["ManejaExistencias"]["Predeterminado"]=1;

$Vector[$TablaConfig]["TipoItem"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector[$TablaConfig]["TipoItem"]["TablaVinculo"]="respuestas_tipo_item";  //tabla de donde se vincula
$Vector[$TablaConfig]["TipoItem"]["IDTabla"]="Valor"; //id de la tabla que se vincula
$Vector[$TablaConfig]["TipoItem"]["Display"]="Valor"; 
$Vector[$TablaConfig]["TipoItem"]["Predeterminado"]=1;

$TablaConfig="documentos_contables_control";
$Vector[$TablaConfig]["Excluir"]["Consecutivo"]=1;

$TablaConfig="insumos";
$Vector[$TablaConfig]["Excluir"]["Referencia"]=1;
?>