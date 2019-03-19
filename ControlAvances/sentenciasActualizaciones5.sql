ALTER TABLE `cotizacionesv5` CHANGE `Fecha` `Fecha` DATE NOT NULL;
ALTER TABLE `cotizacionesv5` ADD `Estado` VARCHAR(25) NOT NULL AFTER `Seguimiento`;
ALTER TABLE `cotizacionesv5` ADD INDEX(`Estado`);

INSERT INTO `menu_pestanas` (`ID`, `Nombre`, `idMenu`, `Orden`, `Estado`, `Updated`, `Sync`) VALUES (49, 'Ingresos', '23', '1', b'1', '2019-01-13 09:12:43', '2019-01-13 09:12:43');
INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `idMenu`, `TablaAsociada`, `TipoLink`, `JavaScript`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (186, 'Historial Comprobantes Ingreso', '49', '3', '0', 'comprobantes_ingreso', '1', 'onclick=\"SeleccioneTablaDB(`comprobantes_ingreso`)\";', 'comprobantes_ingreso.php', '_SELF', '1', 'historial3.png', '1', '2019-01-13 09:12:44', '2019-01-13 09:12:44');

INSERT INTO `configuracion_control_tablas` (`ID`, `TablaDB`, `Agregar`, `Editar`, `Ver`, `LinkVer`, `Exportar`, `AccionesAdicionales`, `Eliminar`, `Updated`, `Sync`) VALUES (7, 'comprobantes_ingreso', '0', '0', '1', 'PDF_Documentos.php?idDocumento=4&idIngreso=', '1', '1', '0', '2019-01-13 09:04:48', '2019-01-13 09:04:48');
INSERT INTO `configuracion_campos_asociados` (`ID`, `TablaOrigen`, `CampoTablaOrigen`, `TablaAsociada`, `CampoAsociado`, `IDCampoAsociado`, `Updated`, `Sync`) VALUES (3, 'comprobantes_ingreso', 'Clientes_idClientes', 'clientes', 'idClientes', 'Num_Identificacion', '2019-01-13 09:04:47', '2019-01-13 09:04:47');

ALTER TABLE `factura_compra_items` ADD `PrecioVenta` DOUBLE NOT NULL AFTER `SubtotalDescuento`;

UPDATE `parametros_contables` SET `CuentaPUC` = '280505' WHERE `parametros_contables`.`ID` = 20;
UPDATE `menu_submenus` SET `TipoLink` = '1' WHERE `menu_submenus`.`ID` = 55;
UPDATE `menu_submenus` SET `TablaAsociada` = 'productosventa' WHERE `menu_submenus`.`ID` = 55;
UPDATE `menu_submenus` SET `JavaScript` = 'onclick=\"SeleccioneTablaDB(`productosventa`)\";' WHERE `menu_submenus`.`ID` = 55;

UPDATE `menu_submenus` SET `Target` = '_SELF' WHERE `menu_submenus`.`ID` = 55;

INSERT INTO `configuracion_campos_asociados` (`ID`, `TablaOrigen`, `CampoTablaOrigen`, `TablaAsociada`, `CampoAsociado`, `IDCampoAsociado`, `Updated`, `Sync`) VALUES (4, 'productosventa', 'Departamento', 'prod_departamentos', 'Nombre', 'idDepartamentos', '2019-02-24 14:01:51', '2019-01-24 14:01:51');

INSERT INTO `configuracion_campos_asociados` (`ID`, `TablaOrigen`, `CampoTablaOrigen`, `TablaAsociada`, `CampoAsociado`, `IDCampoAsociado`, `Updated`, `Sync`) VALUES (5, 'productosventa', 'Sub1', 'prod_sub1', 'NombreSub1', 'idSub1', '2019-02-24 14:01:51', '2019-01-24 14:01:51');
INSERT INTO `configuracion_campos_asociados` (`ID`, `TablaOrigen`, `CampoTablaOrigen`, `TablaAsociada`, `CampoAsociado`, `IDCampoAsociado`, `Updated`, `Sync`) VALUES (6, 'productosventa', 'Sub2', 'prod_sub2', 'NombreSub2', 'idSub2', '2019-02-24 14:01:51', '2019-01-24 14:01:51');
INSERT INTO `configuracion_campos_asociados` (`ID`, `TablaOrigen`, `CampoTablaOrigen`, `TablaAsociada`, `CampoAsociado`, `IDCampoAsociado`, `Updated`, `Sync`) VALUES (7, 'productosventa', 'Sub3', 'prod_sub3', 'NombreSub3', 'idSub3', '2019-02-24 14:01:51', '2019-01-24 14:01:51');
INSERT INTO `configuracion_campos_asociados` (`ID`, `TablaOrigen`, `CampoTablaOrigen`, `TablaAsociada`, `CampoAsociado`, `IDCampoAsociado`, `Updated`, `Sync`) VALUES (8, 'productosventa', 'Sub4', 'prod_sub4', 'NombreSub4', 'idSub4', '2019-02-24 14:01:51', '2019-01-24 14:01:51');
INSERT INTO `configuracion_campos_asociados` (`ID`, `TablaOrigen`, `CampoTablaOrigen`, `TablaAsociada`, `CampoAsociado`, `IDCampoAsociado`, `Updated`, `Sync`) VALUES (9, 'productosventa', 'Sub5', 'prod_sub5', 'NombreSub5', 'idSub5', '2019-02-24 14:01:51', '2019-01-24 14:01:51');
INSERT INTO `configuracion_campos_asociados` (`ID`, `TablaOrigen`, `CampoTablaOrigen`, `TablaAsociada`, `CampoAsociado`, `IDCampoAsociado`, `Updated`, `Sync`) VALUES (10, 'productosventa', 'Sub6', 'prod_sub6', 'NombreSub6', 'idSub6', '2019-02-24 14:01:51', '2019-01-24 14:01:51');


ALTER TABLE `cot_itemscotizaciones` ADD `PorcentajeIVA` VARCHAR(10) NOT NULL AFTER `TipoItem`, ADD `Departamento` INT NOT NULL AFTER `PorcentajeIVA`, ADD `SubGrupo1` INT NOT NULL AFTER `Departamento`, ADD `SubGrupo2` INT NOT NULL AFTER `SubGrupo1`, ADD `SubGrupo3` INT NOT NULL AFTER `SubGrupo2`, ADD `SubGrupo4` INT NOT NULL AFTER `SubGrupo3`, ADD `SubGrupo5` INT NOT NULL AFTER `SubGrupo4`;
ALTER TABLE `cot_itemscotizaciones` ADD `idPorcentajeIVA` INT NOT NULL AFTER `PorcentajeIVA`;

INSERT INTO `configuracion_control_tablas` (`ID`, `TablaDB`, `Agregar`, `Editar`, `Ver`, `LinkVer`, `Exportar`, `AccionesAdicionales`, `Eliminar`, `Updated`, `Sync`) VALUES (8, 'clientes', '1', '1', '0', '', '1', '0', '0', '2019-01-13 09:04:48', '2019-01-13 09:04:48');
ALTER TABLE `configuracion_tablas_acciones_adicionales` CHANGE `ClaseIcono` `ClaseIcono` VARCHAR(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL;

INSERT INTO `configuracion_tablas_acciones_adicionales` (`ID`, `TablaDB`, `JavaScript`, `ClaseIcono`, `Titulo`, `Ruta`, `Target`, `Updated`, `Sync`) VALUES ('4', 'comprobantes_ingreso', '', 'fa fa-fw fa-close', 'Anular', '../../VAtencion/AnularComprobanteIngreso.php?idComprobante=', '_BLANK', '2019-01-13 09:04:49', '2018-01-13 09:04:49');
UPDATE `configuracion_control_tablas` SET `AccionesAdicionales` = '1' WHERE `configuracion_control_tablas`.`ID` = 7;
INSERT INTO `configuracion_campos_asociados` (`ID`, `TablaOrigen`, `CampoTablaOrigen`, `TablaAsociada`, `CampoAsociado`, `IDCampoAsociado`, `Updated`, `Sync`) VALUES (11, 'cotizacionesv5', 'Clientes_idClientes', 'clientes', 'Num_Identificacion', 'idClientes', '2019-02-24 14:01:51', '2018-02-24 14:01:51');

ALTER TABLE `preventa` ADD `Nombre` VARCHAR(100) NOT NULL AFTER `TablaItem`;
ALTER TABLE `preventa` ADD `Referencia` TEXT NOT NULL AFTER `Nombre`;

CREATE TABLE `cotizaciones_anticipos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Valor` double NOT NULL,
  `idCotizacion` bigint(20) NOT NULL,
  `idComprobanteIngreso` bigint(20) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `Estado` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `idCotizacion` (`idCotizacion`),
  KEY `idComprobanteIngreso` (`idComprobanteIngreso`),
  KEY `Estado` (`Estado`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `configuracion_campos_asociados` (`ID`, `TablaOrigen`, `CampoTablaOrigen`, `TablaAsociada`, `CampoAsociado`, `IDCampoAsociado`, `Updated`, `Sync`) VALUES (12, 'clientes', 'Tipo_Documento', 'cod_documentos', 'Descripcion', 'Codigo', '2019-03-01 23:38:29', '2019-02-01 23:38:29');

INSERT INTO `configuracion_campos_asociados` (`ID`, `TablaOrigen`, `CampoTablaOrigen`, `TablaAsociada`, `CampoAsociado`, `IDCampoAsociado`, `Updated`, `Sync`) VALUES ('13', 'clientes', 'Cod_Dpto', 'cod_departamentos', 'Nombre', 'Cod_dpto', '2019-03-01 23:38:29', '2019-02-01 23:38:29');
INSERT INTO `configuracion_campos_asociados` (`ID`, `TablaOrigen`, `CampoTablaOrigen`, `TablaAsociada`, `CampoAsociado`, `IDCampoAsociado`, `Updated`, `Sync`) VALUES ('14', 'clientes', 'Cod_Mcipio', 'cod_municipios_dptos', 'Ciudad', 'Cod_mcipio', '2019-03-01 23:38:29', '2019-02-01 23:38:29');
INSERT INTO `configuracion_campos_asociados` (`ID`, `TablaOrigen`, `CampoTablaOrigen`, `TablaAsociada`, `CampoAsociado`, `IDCampoAsociado`, `Updated`, `Sync`) VALUES ('15', 'clientes', 'Pais_Domicilio', 'cod_paises', 'Pais', 'Codigo', '2019-03-01 23:38:29', '2019-02-01 23:38:29');

ALTER TABLE `cajas` ADD `idEmpresa` INT NOT NULL AFTER `idTerceroIntereses`;
ALTER TABLE `cajas` ADD `idEmpresa` INT NOT NULL DEFAULT '1' AFTER `idTerceroIntereses`;
ALTER TABLE `cajas` ADD `idSucursal` INT NOT NULL DEFAULT '1' AFTER `idEmpresa`;

INSERT INTO `parametros_contables` (`ID`, `Descripcion`, `CuentaPUC`, `NombreCuenta`, `Updated`, `Sync`) VALUES
(30,	'Cuenta para registrar los abonos o pagos en ventas rapidas a los creditos o ventas con otras formas de pago',	11050599,	'OTRAS FORMAS DE PAGO',	'2019-01-13 09:12:55',	'2018-01-13 09:12:55');

INSERT INTO `parametros_contables` (`ID`, `Descripcion`, `CuentaPUC`, `NombreCuenta`, `Updated`, `Sync`) VALUES
(31,	'Anticipos realizados por clientes para los separados',	28050501,	'ANTICIPOS REALIZADOS POR CLIENTES EN SEPARADOS',	'2019-02-26 15:55:46',	'2019-02-26 15:55:46');

INSERT INTO `configuracion_general` (`ID`, `Descripcion`, `Valor`, `Updated`, `Sync`) VALUES
(2,'Valor por defecto si se imprime o no al momento de realizar una factura pos',	'1',	'2019-03-18 07:36:48',	'0000-00-00 00:00:00');

INSERT INTO `configuracion_general` (`ID`, `Descripcion`, `Valor`, `Updated`, `Sync`) VALUES
(3,	'Determina si se debe pedir autorizacion para retornar un item en pos',	'1',	'2019-02-18 07:44:40',	'2019-03-18 07:44:40');

INSERT INTO `configuracion_general` (`ID`, `Descripcion`, `Valor`, `Updated`, `Sync`) VALUES
(4,	'Determina si se debe pedir autorizacion para elimininar un item en pos',	'1',	'2019-02-18 08:20:26',	'2019-03-18 08:20:26');

INSERT INTO `configuracion_general` (`ID`, `Descripcion`, `Valor`, `Updated`, `Sync`) VALUES
(5,	'Determina si se debe pedir autorizacion para cambiar el precio de venta de un item en pos',	'1',	'2019-02-18 08:27:46',	'2019-03-18 08:27:46');

INSERT INTO `configuracion_general` (`ID`, `Descripcion`, `Valor`, `Updated`, `Sync`) VALUES
(6,	'Determina el valor maximo que se puede aplicar al descuento general',	'35',	'2019-03-18 08:33:01',	'2019-03-18 08:33:01');

INSERT INTO `configuracion_general` (`ID`, `Descripcion`, `Valor`, `Updated`, `Sync`) VALUES
(7,'Determina si se pueden realizar descuentos a precio de costo','1',	'2019-02-18 08:33:01',	'2019-03-18 08:33:01');

ALTER TABLE `clientes` ADD `CodigoTarjeta` VARCHAR(20) NOT NULL AFTER `Cupo`;
ALTER TABLE `proveedores` ADD `CodigoTarjeta` VARCHAR(20) NOT NULL AFTER `Cupo`;

INSERT INTO `configuracion_general` (`ID`, `Descripcion`, `Valor`, `Updated`, `Sync`) VALUES
(8,	'Determina cuantas copias saldrán del separado al crearse',	'2',	'2019-02-18 15:54:51',	'2019-03-18 15:54:51');
