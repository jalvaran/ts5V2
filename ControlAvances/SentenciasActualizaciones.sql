ALTER TABLE `facturas_abonos` ADD `TipoPagoAbono` VARCHAR(30) NOT NULL AFTER `Hora`;
--
-- Estructura de tabla para la tabla `parametros_contables`
--
DROP TABLE IF EXISTS `parametros_contables`;
CREATE TABLE IF NOT EXISTS `parametros_contables` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` text COLLATE utf8_spanish2_ci NOT NULL,
  `CuentaPUC` bigint(20) NOT NULL,
  `NombreCuenta` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=19 ;

--
-- Volcado de datos para la tabla `parametros_contables`
--

INSERT INTO `parametros_contables` (`ID`, `Descripcion`, `CuentaPUC`, `NombreCuenta`, `Updated`, `Sync`) VALUES
(1, 'Cuenta que se utiliza para el iva generado en las operaciones de venta ', 24080501, 'Impuesto sobre las ventas por pagar Generado', '2017-06-22 22:35:55', '2017-06-22 17:35:55'),
(2, 'Cuenta Costo de venta de la mercancia', 613501, 'Venta de Mercancias No Fabricadas por la Empresa', '2017-06-15 14:05:38', '2017-06-15 09:05:38'),
(3, 'Cuenta Gasto Para Bajas de Mercancias no fabricadas por la empresa', 529915, '', '2017-04-18 14:59:19', '2017-04-18 09:59:19'),
(4, 'Cuenta donde se alojan los inventarios de las mercancias no fabricadas por la empresa', 143501, 'Mercancias No Fabricadas por la Empresa', '2017-06-15 14:05:38', '2017-06-15 09:05:38'),
(5, 'Cuenta para Realizar el Credito a las altas de un producto', 529915, '', '2017-04-18 14:59:19', '2017-04-18 09:59:19'),
(6, 'Cuenta para realizar creditos o debitos a los clientes', 130505, 'CLIENTES NACIONALES', '2017-06-15 14:05:38', '2017-06-15 09:05:38'),
(7, 'Cuenta para registrar el gasto por otros descuentos cuando se registra un ingreso por cartera', 521095, 'OTROS DESCUENTOS', '2017-04-18 14:59:19', '2017-04-18 09:59:19'),
(8, 'CUENTA PARA REGISTRAR EL PAGO DE COMISIONES', 520518, 'COMISIONES', '2017-04-18 14:59:19', '2017-04-18 09:59:19'),
(9, 'Cuenta para registrar la devolucion de una venta', 417501, 'DEVOLUCIONES EN VENTA', '2017-04-18 14:59:19', '2017-04-18 09:59:19'),
(10, 'CUENTA ORIGEN DE LA CREACION DE UN EGRESO A PARTIR DE UN CONCEPTO CONTABLE CREADO.', 110505, 'CAJA GENERAL', '2017-04-18 14:59:19', '2017-04-18 09:59:19'),
(11, 'Cuenta para llevar la utilidad del ejercicio', 3605, 'Utilidad del Ejercicio', '2017-04-18 14:59:19', '2017-04-18 09:59:19'),
(12, 'Cuenta para llevar la perdida del ejercicio', 3610, 'Perdida del Ejercicio', '2017-04-18 14:59:19', '2017-04-18 09:59:19'),
(13, 'Contrapartida para llevar la perdida o ganancia del ejercicio', 5905, 'Ganancias y perdidas', '2017-04-18 14:59:19', '2017-04-18 09:59:19'),
(14, 'Cuenta x pagar proveedores', 220505, 'PROVEEDORES NACIONALES', '2017-06-16 17:13:00', '2017-06-16 12:13:00'),
(15, 'Descuentos en compras por pronto pago', 421040, 'DESCUENTOS COMERCIALES CONDICIONADOS', '2017-06-15 14:05:38', '2017-06-15 09:05:38'),
(16, 'impuesto generado al consumo de bolsas plasticas', 24081004, 'IMPUESTO AL CONSUMO DE BOLSAS PLASTICAS', '2017-06-15 14:05:38', '2017-06-15 09:05:38'),
(17, 'Cuenta para registrar los abonos a los creditos con tarjetas', 11100501, 'BANCOS', '2017-06-15 14:05:38', '2017-06-15 09:05:38'),
(18, 'Cuenta para registrar los abonos a los creditos con Cheques', 11100510, 'BANCOS CHEQUES', '2017-06-15 14:05:38', '2017-06-15 09:05:38');
DROP TABLE IF EXISTS `registro_basculas`;
CREATE TABLE IF NOT EXISTS `registro_basculas` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Gramos` double NOT NULL,
  `idBascula` int(11) NOT NULL,
  `Leido` bit(1) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1;

DROP TABLE IF EXISTS `porcentajes_iva`;
CREATE TABLE IF NOT EXISTS `porcentajes_iva` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Valor` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Factor` varchar(10) COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'M',
  `CuentaPUC` bigint(20) NOT NULL,
  `CuentaPUCIVAGenerado` bigint(20) NOT NULL,
  `NombreCuenta` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `Habilitado` varchar(2) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=8 ;

--
-- Volcado de datos para la tabla `porcentajes_iva`
--

INSERT INTO `porcentajes_iva` (`ID`, `Nombre`, `Valor`, `Factor`, `CuentaPUC`, `CuentaPUCIVAGenerado`, `NombreCuenta`, `Habilitado`, `Updated`, `Sync`) VALUES
(1, 'Sin IVA', '0', 'M', 2408, 2408, '', 'SI', '2017-06-15 14:05:43', '2017-06-15 09:05:43'),
(2, 'Excluidos', 'E', 'M', 2408, 2408, '', 'SI', '2017-06-15 14:05:43', '2017-06-15 09:05:43'),
(3, 'IVA 5 %', '0.05', 'M', 24080503, 24081003, 'Impuestos del 5%', 'SI', '2017-06-15 14:05:43', '2017-06-15 09:05:43'),
(4, 'IVA del 8%', '0.08', 'M', 24080502, 24081002, 'Impuestos del 8%', 'SI', '2017-06-15 14:05:43', '2017-06-15 09:05:43'),
(5, 'IVA del 16%', '0.16', 'M', 24080504, 24081004, 'Impuestos del 16%', 'NO', '2017-06-15 14:05:43', '2017-06-15 09:05:43'),
(6, 'IVA del 19%', '0.19', 'M', 24080501, 24081001, 'Impuestos del 19%', 'SI', '2017-06-15 14:05:43', '2017-06-15 09:05:43'),
(7, 'ImpoConsumo Bolsas', '20', 'S', 24080511, 24081011, 'IMPUESTO AL CONSUMO DE BOLSAS', 'SI', '2017-07-21 15:35:47', '0000-00-00 00:00:00');

ALTER TABLE `facturas_items` ADD `idPorcentajeIVA` INT NOT NULL AFTER `PorcentajeIVA`;
ALTER TABLE `ori_facturas_items` ADD `idPorcentajeIVA` INT NOT NULL AFTER `PorcentajeIVA`;

ALTER TABLE `facturas_items` ADD `ValorOtrosImpuestos` DOUBLE NOT NULL AFTER `IVAItem`;
ALTER TABLE `facturas_items` ADD `idOtrosImpuestos` INT NOT NULL AFTER `PorcentajeIVA`;

ALTER TABLE `ori_facturas_items` ADD `ValorOtrosImpuestos` DOUBLE NOT NULL AFTER `IVAItem`;
ALTER TABLE `ori_facturas_items` ADD `idOtrosImpuestos` INT NOT NULL AFTER `PorcentajeIVA`;


DROP TABLE IF EXISTS `productos_impuestos_adicionales`;
CREATE TABLE IF NOT EXISTS `productos_impuestos_adicionales` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NombreImpuesto` text COLLATE latin1_spanish_ci NOT NULL,
  `idProducto` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `ValorImpuesto` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `CuentaPUC` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `NombreCuenta` text COLLATE latin1_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `productos_impuestos_adicionales`
--

INSERT INTO `productos_impuestos_adicionales` (`ID`, `NombreImpuesto`, `idProducto`, `ValorImpuesto`, `CuentaPUC`, `NombreCuenta`, `Updated`, `Sync`) VALUES
(1, 'Impoconsumo', '0', '20', '24081011', 'IMPUESTO AL CONSUMO DE BOLSAS', '2017-08-18 22:49:49', '0000-00-00 00:00:00');

ALTER TABLE `egresos_pre` CHANGE `Abono` `Abono` DOUBLE NOT NULL;
ALTER TABLE `cuentasxpagar_abonos` CHANGE `idCuentaXPagar` `idCuentaXPagar` TEXT NOT NULL;

DROP TABLE IF EXISTS `menu`;
CREATE TABLE IF NOT EXISTS `menu` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(80) COLLATE latin1_spanish_ci NOT NULL,
  `idCarpeta` int(11) NOT NULL,
  `Pagina` varchar(80) COLLATE latin1_spanish_ci NOT NULL,
  `Target` varchar(10) COLLATE latin1_spanish_ci NOT NULL DEFAULT '_SELF',
  `Estado` int(1) NOT NULL DEFAULT '1',
  `Image` text COLLATE latin1_spanish_ci NOT NULL,
  `Orden` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=24 ;

--
-- Volcado de datos para la tabla `menu`
--

INSERT INTO `menu` (`ID`, `Nombre`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES
(1, 'Administrar', 1, 'Admin.php', '_BLANK', 1, 'admin.png', 1, '2017-07-24 19:05:12', '2017-06-22 18:08:59'),
(2, 'Gestión Comercial', 1, 'MnuVentas.php', '_BLANK', 1, 'comercial.png', 2, '2017-07-24 19:05:12', '2017-06-22 18:08:59'),
(3, 'Facturación', 1, 'MnuFacturacion.php', '_BLANK', 1, 'factura.png', 3, '2017-07-24 19:05:12', '2017-06-22 18:08:59'),
(4, 'Cartera', 3, 'cartera.php', '_BLANK', 1, 'cartera.png', 4, '2017-07-24 19:03:17', '2017-06-22 18:08:59'),
(5, 'Compras', 1, 'MnuCompras.php', '_BLANK', 1, 'factura_compras.png', 5, '2017-07-24 19:38:53', '2017-06-22 18:08:59'),
(6, 'Egresos', 1, 'MnuEgresos.php', '_BLANK', 1, 'egresos.png', 6, '2017-07-24 19:05:12', '2017-06-22 18:08:59'),
(7, 'Comprobantes Contables', 3, 'CreaComprobanteCont.php', '_BLANK', 1, 'egresoitems.png', 7, '2017-07-24 19:03:17', '2017-06-22 18:08:59'),
(8, 'Conceptos Contables', 3, 'ConceptosContablesUtilidad.php', '_BLANK', 1, 'conceptos.png', 8, '2017-07-24 19:03:17', '2017-06-22 18:08:59'),
(9, 'Clientes', 3, 'clientes.php', '_BLANK', 1, 'clientes.png', 9, '2017-07-24 19:03:17', '2017-06-22 18:08:59'),
(10, 'Proveedores', 3, 'proveedores.php', '_BLANK', 1, 'proveedores.png', 10, '2017-07-24 19:03:17', '2017-06-22 18:08:59'),
(11, 'Cuentas X Pagar', 3, 'cuentasxpagar.php', '_BLANK', 1, 'cuentasxpagar.png', 11, '2017-07-24 19:03:17', '2017-06-22 18:08:59'),
(12, 'Inventarios', 1, 'MnuInventarios.php', '_BLANK', 1, 'inventarios.png', 12, '2017-07-24 19:05:12', '2017-06-22 18:08:59'),
(13, 'Ordenes de Servicio', 3, 'ordenesdetrabajo.php', '_BLANK', 1, 'ordentrabajo.png', 13, '2017-07-24 19:03:17', '2017-06-22 18:08:59'),
(14, 'Producción', 3, 'CronogramaProduccion.php', '_BLANK', 1, 'produccion.png', 14, '2017-07-24 19:03:17', '2017-06-22 18:08:59'),
(15, 'Títulos', 1, 'MnuTitulos.php', '_BLANK', 1, 'titulos.jpg', 15, '2017-07-24 19:05:12', '2017-06-22 18:08:59'),
(16, 'Restaurante', 1, 'MnuRestaurante.php', '_BLANK', 1, 'restaurante.png', 16, '2017-07-24 19:05:12', '2017-06-22 18:08:59'),
(17, 'Informes', 1, 'MnuInformes.php', '_BLANK', 1, 'informes.png', 17, '2017-07-24 19:05:12', '2017-06-22 18:08:59'),
(18, 'Gestión de Requerimientos', 1, 'MnuRequerimientos.php', '_BLANK', 1, 'requerimientos.png', 18, '2017-07-24 19:05:12', '2017-06-22 18:08:59'),
(19, 'Ajustes y Servicios Generales', 1, 'MnuAjustes.php', '_BLANK', 1, 'ajustes.png', 19, '2017-07-24 19:05:12', '2017-06-22 18:08:59'),
(20, 'Salir', 2, 'destruir.php', '_SELF', 1, 'salir.png', 20, '2017-07-24 19:07:08', '2017-06-22 18:08:59'),
(21, 'Administrar Tiempos', 3, 'crono_admin_sesiones.php', '_BLANK', 0, 'admin.png', 21, '2017-07-24 19:10:13', '2017-06-22 18:08:59'),
(22, 'Visualizar Tiempo', 3, 'crono.php', '_BLANK', 0, 'crono.png', 22, '2017-07-24 19:10:11', '2017-06-22 18:08:59'),
(23, 'Ingresos', 1, 'MnuIngresos.php', '_BLANK', 1, 'ingresos.png', 5, '2017-07-24 19:38:53', '2017-06-22 18:08:59');

DROP TABLE IF EXISTS `menu_carpetas`;
CREATE TABLE IF NOT EXISTS `menu_carpetas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Ruta` varchar(90) COLLATE latin1_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `menu_carpetas`
--

INSERT INTO `menu_carpetas` (`ID`, `Ruta`, `Updated`, `Sync`) VALUES
(1, '', '2017-07-26 15:12:02', '0000-00-00 00:00:00'),
(2, '../', '2017-07-26 15:12:02', '0000-00-00 00:00:00'),
(3, '../VAtencion/', '2017-07-26 15:12:02', '0000-00-00 00:00:00');

ALTER TABLE `facturas` CHANGE `Fecha` `Fecha` DATE NOT NULL;

ALTER TABLE `preventa` ADD `CostoUnitario` DOUBLE NOT NULL AFTER `ValorAcordado`, ADD `PrecioMayorista` DOUBLE NOT NULL AFTER `CostoUnitario`;
ALTER TABLE `preventa` ADD `PorcentajeIVA` DOUBLE NOT NULL AFTER `Impuestos`;
ALTER TABLE `preventa` ADD `idPorcentajeIVA` INT NOT NULL AFTER `PorcentajeIVA`;

ALTER TABLE `preventa` CHANGE `ValorAcordado` `ValorAcordado` DOUBLE NOT NULL;
ALTER TABLE `preventa` CHANGE `ValorUnitario` `ValorUnitario` DOUBLE NOT NULL;
ALTER TABLE `preventa` CHANGE `Subtotal` `Subtotal` DOUBLE NOT NULL;
ALTER TABLE `preventa` CHANGE `Impuestos` `Impuestos` DOUBLE NOT NULL;
ALTER TABLE `preventa` CHANGE `TotalVenta` `TotalVenta` DOUBLE NOT NULL;
ALTER TABLE `preventa` CHANGE `Cantidad` `Cantidad` DOUBLE NOT NULL;
ALTER TABLE `preventa` CHANGE `Descuento` `Descuento` DOUBLE NOT NULL;
ALTER TABLE `preventa` CHANGE `ProductosVenta_idProductosVenta` `ProductosVenta_idProductosVenta` BIGINT NOT NULL;

DROP VIEW IF EXISTS `vista_titulos_devueltos`;
CREATE VIEW vista_titulos_devueltos AS
SELECT td.`ID` as ID,td.`Fecha` as Fecha, td.`idVenta` as idVenta,td.`Promocion` as Promocion, td.`Mayor` as Mayor,td.`Concepto` as Concepto,td.`idColaborador` as idColaborador,td.`NombreColaborador`,td.idUsuario,tv.`Mayor2`,tv.`Adicional`,tv.`Valor`,tv.`TotalAbonos`,tv.`Saldo`,tv.`idCliente`,tv.`NombreCliente`  FROM titulos_devoluciones td INNER JOIN titulos_ventas tv ON td.idVenta=tv.ID;


DROP VIEW IF EXISTS `vista_titulos_abonos`;
CREATE VIEW vista_titulos_abonos AS
SELECT td.`ID` as ID,td.`Fecha` as Fecha,td.`Hora` ,td.Monto, td.`idVenta`,tv.`Promocion` as Promocion, tv.`Mayor1` as Mayor,td.`Observaciones` as Concepto,td.`idColaborador` as idColaborador,td.`NombreColaborador`,td.`Estado`,td.`idComprobanteIngreso`,tv.`Mayor2`,tv.`Adicional`,tv.`Valor`,tv.`TotalAbonos`,tv.`Saldo`,tv.`idCliente`,tv.`NombreCliente`  FROM titulos_abonos td INNER JOIN titulos_ventas tv ON td.idVenta=tv.ID;

DROP VIEW IF EXISTS `vista_titulos_comisiones`;
CREATE VIEW vista_titulos_comisiones AS 
SELECT td.`ID` as ID,td.`Fecha` as Fecha,td.`Hora` ,td.Monto, td.`idVenta`,tv.`Promocion` as Promocion, tv.`Mayor1` as Mayor,td.`Observaciones` as Concepto,td.`idColaborador` as idColaborador,td.`NombreColaborador`,td.`idUsuario`,td.`idEgreso`,tv.`Mayor2`,tv.`Adicional`,tv.`Valor`,tv.`TotalAbonos`,tv.`Saldo`,tv.`idCliente`,tv.`NombreCliente` FROM titulos_comisiones td INNER JOIN titulos_ventas tv ON td.idVenta=tv.ID;

DROP VIEW IF EXISTS `vista_preventa`;
CREATE VIEW vista_preventa AS 
select p.VestasActivas_idVestasActivas,'productosventa' AS `TablaItems`,`pv`.`Referencia` AS `Referencia`,`pv`.`Nombre` AS `Nombre`,`pv`.`Departamento` AS `Departamento`,`pv`.`Sub1` AS `SubGrupo1`,`pv`.`Sub2` AS `SubGrupo2`,`pv`.`Sub3` AS `SubGrupo3`,`pv`.`Sub4` AS `SubGrupo4`,`pv`.`Sub5` AS `SubGrupo5`,`p`.`ValorAcordado` AS `ValorUnitarioItem`,`p`.`Cantidad` AS `Cantidad`,'1' AS `Dias`,(`p`.`ValorAcordado` * `p`.`Cantidad`) AS `SubtotalItem`,((`p`.`ValorAcordado` * `p`.`Cantidad`) * `pv`.`IVA`) AS `IVAItem`,((select `productos_impuestos_adicionales`.`ValorImpuesto` from `productos_impuestos_adicionales` where (`productos_impuestos_adicionales`.`idProducto` = `p`.`ProductosVenta_idProductosVenta`)) * `p`.`Cantidad`) AS `ValorOtrosImpuestos`, ((`p`.`ValorAcordado` * `p`.`Cantidad`) + (`p`.`ValorAcordado` * `p`.`Cantidad`) * `pv`.`IVA` ) as TotalItem,(CONCAT(pv.IVA*100,'%')) as PorcentajeIVA,pv.CostoUnitario as PrecioCostoUnitario, pv.CostoUnitario*p.Cantidad as SubtotalCosto,(SELECT TipoItem FROM prod_departamentos WHERE idDepartamentos=pv.Departamento) as TipoItem,pv.CuentaPUC as CuentaPUC,p.Updated as Updated,p.Sync as Sync from (`preventa` `p` join `productosventa` `pv` on((`p`.`ProductosVenta_idProductosVenta` = `pv`.`idProductosVenta`))) where (`p`.`TablaItem` = 'productosventa');


CREATE TABLE IF NOT EXISTS `factura_compra_anulaciones` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `Observaciones` text COLLATE utf8_spanish2_ci NOT NULL,
  `idCompra` bigint(20) NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=1 ;


ALTER TABLE `cajas` ADD `idTerceroIntereses` BIGINT NOT NULL COMMENT 'Nit del Tercero al que se va a ir la cuent x parar de intereses' AFTER `CuentaPUCIVAEgresos`;

INSERT INTO `parametros_contables` (`ID`, `Descripcion`, `CuentaPUC`, `NombreCuenta`, `Updated`, `Sync`) VALUES ('19', 'Cuenta x pagar Intereses Siste Credito', '220505', 'PROVEEDORES NACIONALES', '2017-06-16 12:13:00', '2017-06-16 12:11:00');

--
-- Estructura de tabla para la tabla `facturas_intereses_sistecredito`
--

CREATE TABLE IF NOT EXISTS `facturas_intereses_sistecredito` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `idFactura` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `Valor` double NOT NULL,
  `idCierre` bigint(20) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;



--
-- Estructura de tabla para la tabla `menu`
--

DROP TABLE IF EXISTS `menu`;
CREATE TABLE IF NOT EXISTS `menu` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(80) COLLATE latin1_spanish_ci NOT NULL,
  `idCarpeta` int(11) NOT NULL,
  `Pagina` varchar(80) COLLATE latin1_spanish_ci NOT NULL,
  `Target` varchar(10) COLLATE latin1_spanish_ci NOT NULL DEFAULT '_SELF',
  `Estado` int(1) NOT NULL DEFAULT '1',
  `Image` text COLLATE latin1_spanish_ci NOT NULL,
  `Orden` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=26 ;

--
-- Volcado de datos para la tabla `menu`
--

INSERT INTO `menu` (`ID`, `Nombre`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES
(1, 'Administrar', 1, 'Admin.php', '_BLANK', 1, 'admin.png', 1, '2017-07-24 19:05:12', '2017-06-22 18:08:59'),
(2, 'Gestión Comercial', 1, 'MnuVentas.php', '_BLANK', 1, 'comercial.png', 2, '2017-07-24 19:05:12', '2017-06-22 18:08:59'),
(3, 'Facturación', 1, 'MnuFacturacion.php', '_BLANK', 1, 'factura.png', 3, '2017-07-24 19:05:12', '2017-06-22 18:08:59'),
(4, 'Cartera', 3, 'cartera.php', '_BLANK', 1, 'cartera.png', 4, '2017-07-24 19:03:17', '2017-06-22 18:08:59'),
(5, 'Compras', 1, 'MnuCompras.php', '_BLANK', 1, 'factura_compras.png', 5, '2017-07-24 19:38:53', '2017-06-22 18:08:59'),
(6, 'Egresos', 1, 'MnuEgresos.php', '_BLANK', 1, 'egresos.png', 6, '2017-07-24 19:05:12', '2017-06-22 18:08:59'),
(7, 'Comprobantes Contables', 3, 'CreaComprobanteCont.php', '_BLANK', 1, 'egresoitems.png', 7, '2017-07-24 19:03:17', '2017-06-22 18:08:59'),
(8, 'Conceptos Contables', 3, 'ConceptosContablesUtilidad.php', '_BLANK', 1, 'conceptos.png', 8, '2017-07-24 19:03:17', '2017-06-22 18:08:59'),
(9, 'Clientes', 3, 'clientes.php', '_BLANK', 1, 'clientes.png', 9, '2017-07-24 19:03:17', '2017-06-22 18:08:59'),
(10, 'Proveedores', 3, 'proveedores.php', '_BLANK', 1, 'proveedores.png', 10, '2017-07-24 19:03:17', '2017-06-22 18:08:59'),
(11, 'Cuentas X Pagar', 1, 'MnuCuentasxPagar.php', '_BLANK', 1, 'cuentasxpagar.png', 11, '2017-08-02 14:52:50', '2017-06-22 18:08:59'),
(12, 'Inventarios', 1, 'MnuInventarios.php', '_BLANK', 1, 'inventarios.png', 12, '2017-07-24 19:05:12', '2017-06-22 18:08:59'),
(13, 'Ordenes de Servicio', 3, 'ordenesdetrabajo.php', '_BLANK', 1, 'ordentrabajo.png', 13, '2017-07-24 19:03:17', '2017-06-22 18:08:59'),
(14, 'Producción', 3, 'CronogramaProduccion.php', '_BLANK', 1, 'produccion.png', 14, '2017-07-24 19:03:17', '2017-06-22 18:08:59'),
(15, 'Títulos', 1, 'MnuTitulos.php', '_BLANK', 1, 'titulos.jpg', 15, '2017-07-24 19:05:12', '2017-06-22 18:08:59'),
(16, 'Restaurante', 1, 'MnuRestaurante.php', '_BLANK', 1, 'restaurante.png', 16, '2017-07-24 19:05:12', '2017-06-22 18:08:59'),
(17, 'Informes', 1, 'MnuInformes.php', '_BLANK', 1, 'informes.png', 17, '2017-07-24 19:05:12', '2017-06-22 18:08:59'),
(18, 'Gestión de Requerimientos', 1, 'MnuRequerimientos.php', '_BLANK', 1, 'requerimientos.png', 18, '2017-07-24 19:05:12', '2017-06-22 18:08:59'),
(19, 'Ajustes y Servicios Generales', 1, 'MnuAjustes.php', '_BLANK', 1, 'ajustes.png', 19, '2017-07-24 19:05:12', '2017-06-22 18:08:59'),
(20, 'Salir', 2, 'destruir.php', '_SELF', 1, 'salir.png', 20, '2017-07-24 19:07:08', '2017-06-22 18:08:59'),
(21, 'Administrar Tiempos', 3, 'crono_admin_sesiones.php', '_BLANK', 0, 'admin.png', 21, '2017-07-24 19:10:13', '2017-06-22 18:08:59'),
(22, 'Visualizar Tiempo', 3, 'crono.php', '_BLANK', 0, 'crono.png', 22, '2017-07-24 19:10:11', '2017-06-22 18:08:59'),
(23, 'Ingresos', 1, 'MnuIngresos.php', '_BLANK', 1, 'ingresos.png', 5, '2017-07-24 19:38:53', '2017-06-22 18:08:59'),
(24, 'Traslados', 1, 'MnuTraslados.php', '_BLANK', 0, 'traslados.png', 1, '2017-07-24 19:38:53', '2017-06-22 18:08:59'),
(25, 'Marketing', 1, 'MnuPublicidad.php', '_BLANK', 1, 'publicidad.png', 17, '2017-09-11 13:24:46', '2017-06-22 18:08:59');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu_carpetas`
--

DROP TABLE IF EXISTS `menu_carpetas`;
CREATE TABLE IF NOT EXISTS `menu_carpetas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Ruta` varchar(90) COLLATE latin1_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `menu_carpetas`
--

INSERT INTO `menu_carpetas` (`ID`, `Ruta`, `Updated`, `Sync`) VALUES
(1, '', '2017-07-26 15:12:02', '0000-00-00 00:00:00'),
(2, '../', '2017-07-26 15:12:02', '0000-00-00 00:00:00'),
(3, '../VAtencion/', '2017-07-26 15:12:02', '0000-00-00 00:00:00'),
(4, '../VMenu/', '2017-07-26 15:12:02', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu_pestanas`
--

DROP TABLE IF EXISTS `menu_pestanas`;
CREATE TABLE IF NOT EXISTS `menu_pestanas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `idMenu` int(11) NOT NULL,
  `Orden` int(11) NOT NULL,
  `Estado` bit(1) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=36 ;

--
-- Volcado de datos para la tabla `menu_pestanas`
--

INSERT INTO `menu_pestanas` (`ID`, `Nombre`, `idMenu`, `Orden`, `Estado`, `Updated`, `Sync`) VALUES
(1, 'Empresa', 1, 1, b'1', '2017-08-30 17:13:45', '0000-00-00 00:00:00'),
(2, 'Usuarios', 1, 2, b'1', '2017-08-30 17:13:45', '0000-00-00 00:00:00'),
(3, 'Impuestos', 1, 3, b'1', '2017-08-30 17:13:45', '0000-00-00 00:00:00'),
(4, 'Colaboradores', 1, 4, b'1', '2017-08-30 17:13:45', '0000-00-00 00:00:00'),
(5, 'Descuentos', 1, 5, b'1', '2017-08-30 17:13:45', '0000-00-00 00:00:00'),
(6, 'Finanzas', 1, 6, b'1', '2017-08-30 17:13:45', '0000-00-00 00:00:00'),
(7, 'Informes', 1, 7, b'1', '2017-08-30 17:13:45', '0000-00-00 00:00:00'),
(8, 'Hardware', 1, 8, b'1', '2017-08-30 17:13:45', '0000-00-00 00:00:00'),
(9, 'Ventas', 2, 1, b'1', '2017-08-30 17:13:45', '0000-00-00 00:00:00'),
(10, 'Cotizaciones', 2, 2, b'1', '2017-08-30 17:13:45', '0000-00-00 00:00:00'),
(11, 'Remisiones', 2, 3, b'1', '2017-08-30 17:13:45', '0000-00-00 00:00:00'),
(12, 'Facturacion', 3, 1, b'1', '2017-08-31 20:34:06', '0000-00-00 00:00:00'),
(13, 'Compras', 5, 1, b'1', '2017-08-31 20:34:06', '0000-00-00 00:00:00'),
(14, 'Egresos', 6, 1, b'1', '2017-08-31 20:34:06', '0000-00-00 00:00:00'),
(15, 'Cuentas X Pagar', 11, 1, b'1', '2017-08-31 20:34:06', '0000-00-00 00:00:00'),
(16, 'Financieros', 17, 1, b'1', '2017-08-31 20:34:06', '0000-00-00 00:00:00'),
(17, 'Auxiliares', 17, 2, b'1', '2017-09-07 12:41:28', '0000-00-00 00:00:00'),
(18, 'Reporte de Ventas', 17, 3, b'1', '2017-09-07 12:41:28', '0000-00-00 00:00:00'),
(19, 'Fiscales', 17, 4, b'1', '2017-09-07 12:41:28', '0000-00-00 00:00:00'),
(20, 'Compras', 17, 5, b'1', '2017-09-07 12:41:28', '0000-00-00 00:00:00'),
(21, 'Auditoria', 17, 6, b'1', '2017-09-07 12:41:28', '0000-00-00 00:00:00'),
(22, 'Inventarios', 12, 1, b'1', '2017-09-07 12:41:28', '0000-00-00 00:00:00'),
(23, 'Clasificacion de Inventarios', 12, 2, b'1', '2017-09-07 12:41:28', '0000-00-00 00:00:00'),
(24, 'Bodegas', 12, 3, b'1', '2017-09-07 12:41:28', '0000-00-00 00:00:00'),
(25, 'Movimientos', 12, 4, b'1', '2017-09-07 12:41:28', '0000-00-00 00:00:00'),
(26, 'General', 12, 5, b'1', '2017-09-07 12:41:28', '0000-00-00 00:00:00'),
(27, 'Sistemas', 12, 6, b'1', '2017-09-07 12:41:28', '0000-00-00 00:00:00'),
(28, 'Conteo Fisico', 12, 7, b'1', '2017-09-07 16:01:31', '0000-00-00 00:00:00'),
(29, 'Requerimientos', 18, 1, b'1', '2017-09-07 16:50:39', '0000-00-00 00:00:00'),
(30, 'Restaurante', 16, 1, b'1', '2017-09-07 16:50:39', '0000-00-00 00:00:00'),
(31, 'Configuracion', 16, 2, b'1', '2017-09-07 16:50:39', '0000-00-00 00:00:00'),
(32, 'Titulos', 15, 1, b'1', '2017-09-07 16:50:39', '0000-00-00 00:00:00'),
(33, 'Traslados', 24, 1, b'1', '2017-09-07 16:50:39', '0000-00-00 00:00:00'),
(34, 'Seguimiento', 24, 2, b'1', '2017-09-07 16:50:39', '0000-00-00 00:00:00'),
(35, 'Publicidad', 25, 1, b'1', '2017-09-07 16:50:39', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu_submenus`
--

DROP TABLE IF EXISTS `menu_submenus`;
CREATE TABLE IF NOT EXISTS `menu_submenus` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `idPestana` int(11) NOT NULL,
  `idCarpeta` int(11) NOT NULL,
  `Pagina` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `Target` varchar(10) COLLATE latin1_spanish_ci NOT NULL,
  `Estado` bit(1) NOT NULL,
  `Image` varchar(200) COLLATE latin1_spanish_ci NOT NULL,
  `Orden` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=105 ;

--
-- Volcado de datos para la tabla `menu_submenus`
--

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES
(1, 'Crear/Editar Empresa', 1, 3, 'empresapro.php', '_SELF', b'1', 'empresa.png', 1, '2017-08-30 17:13:46', '0000-00-00 00:00:00'),
(2, 'Crear/Editar Sucursal', 1, 3, 'empresa_pro_sucursales.php', '_SELF', b'1', 'sucursal.png', 2, '2017-08-30 17:13:46', '0000-00-00 00:00:00'),
(3, 'Resoluciones de Facturacion', 1, 3, 'empresapro_resoluciones_facturacion.php', '_SELF', b'1', 'resolucion.png', 3, '2017-08-30 17:13:46', '0000-00-00 00:00:00'),
(4, 'Formatos de Calidad', 1, 3, 'formatos_calidad.php', '_SELF', b'1', 'notacredito.png', 4, '2017-08-30 17:13:46', '0000-00-00 00:00:00'),
(5, 'Centros de Costos', 1, 3, 'centrocosto.php', '_SELF', b'1', 'centrocostos.png', 5, '2017-08-30 17:13:46', '0000-00-00 00:00:00'),
(6, 'Crear/Editar Cajas', 1, 3, 'cajas.php', '_SELF', b'1', 'cajas.png', 6, '2017-08-30 17:13:46', '0000-00-00 00:00:00'),
(7, 'Configurar Tikete de Promocion', 1, 3, 'config_tiketes_promocion.php', '_SELF', b'1', 'tiketes.png', 7, '2017-08-30 17:13:46', '0000-00-00 00:00:00'),
(8, 'Costos operativos', 1, 3, 'costos.php', '_SELF', b'1', 'costos.png', 8, '2017-08-30 17:13:46', '0000-00-00 00:00:00'),
(9, 'Crear/Editar un Usuario', 2, 3, 'usuarios.php', '_SELF', b'1', 'usuarios.png', 1, '2017-08-30 17:13:46', '0000-00-00 00:00:00'),
(10, 'Crear/Editar un Tipo de Usuario', 2, 3, 'usuarios_tipo.php', '_SELF', b'1', 'usuariostipo.png', 2, '2017-08-30 17:13:46', '0000-00-00 00:00:00'),
(11, 'Asignar usuarios a cajas', 2, 3, 'HabilitarUser.php', '_SELF', b'1', 'autorizarcajas.png', 2, '2017-08-30 17:13:46', '0000-00-00 00:00:00'),
(12, 'Crear/Editar un impuesto o una retencion', 3, 3, 'impret.php', '_SELF', b'1', 'impuestos.png', 1, '2017-08-30 17:13:46', '0000-00-00 00:00:00'),
(13, 'Colaboradores', 4, 3, 'colaboradores.php', '_SELF', b'1', 'colaboradores.png', 1, '2017-08-30 17:13:46', '0000-00-00 00:00:00'),
(14, 'Fechas Descuentos', 5, 3, 'fechas_descuentos.php', '_SELF', b'1', 'descuentos.png', 1, '2017-08-30 17:13:46', '0000-00-00 00:00:00'),
(15, 'Libro Diario', 6, 3, 'librodiario.php', '_SELF', b'1', 'librodiario.png', 1, '2017-08-30 17:13:46', '0000-00-00 00:00:00'),
(16, 'Historial de Facturacion', 6, 3, 'facturas.php', '_SELF', b'1', 'facturas.png', 2, '2017-08-30 17:13:46', '0000-00-00 00:00:00'),
(17, 'Cuentas', 6, 3, 'subcuentas.php', '_SELF', b'1', 'cuentas.png', 3, '2017-08-30 17:13:46', '0000-00-00 00:00:00'),
(18, 'Cuentas Frecuentes', 6, 3, 'cuentasfrecuentes.php', '_SELF', b'1', 'cuentasfrecuentes.png', 4, '2017-08-30 17:13:46', '0000-00-00 00:00:00'),
(19, 'Informe Administrador', 7, 3, 'InformeVentasAdmin.php', '_SELF', b'1', 'informes2.png', 1, '2017-08-30 17:13:46', '0000-00-00 00:00:00'),
(20, 'Hardware', 8, 3, 'config_puertos.php', '_SELF', b'1', 'configuracion.png', 1, '2017-08-30 17:13:46', '0000-00-00 00:00:00'),
(21, 'Ventas Rapidas', 9, 3, 'VentasRapidasV2.php', '_SELF', b'1', 'vender.png', 1, '2017-08-30 17:13:46', '0000-00-00 00:00:00'),
(22, 'Historial de Cierres', 9, 3, 'cajas_aperturas_cierres.php', '_SELF', b'1', 'cierres_caja.jpg', 2, '2017-08-31 20:08:55', '0000-00-00 00:00:00'),
(23, 'Historial de Separados', 9, 3, 'separados.php', '_SELF', b'1', 'separados.png', 3, '2017-08-30 17:13:46', '0000-00-00 00:00:00'),
(24, 'Historial de Abonos a Facturas', 9, 3, 'facturas_abonos.php', '_SELF', b'1', 'abonar.jpg', 4, '2017-08-30 17:13:46', '0000-00-00 00:00:00'),
(25, 'Agregar Codigo de Barras', 9, 3, 'prod_codbarras.php', '_SELF', b'1', 'codigobarras.png', 5, '2017-08-30 17:13:46', '0000-00-00 00:00:00'),
(26, 'Cotizar', 10, 3, 'Cotizaciones.php', '_SELF', b'1', 'cotizacion.png', 1, '2017-08-30 17:13:46', '0000-00-00 00:00:00'),
(27, 'Historial de Cotizaciones', 10, 3, 'cotizacionesv5.php', '_SELF', b'1', 'historial.png', 2, '2017-08-31 20:13:18', '0000-00-00 00:00:00'),
(28, 'Historial Cotizaciones Detallado', 10, 3, 'cot_itemscotizaciones.php', '_SELF', b'1', 'historial2.png', 3, '2017-08-31 20:13:18', '0000-00-00 00:00:00'),
(29, 'Anexos a Cotizaciones', 10, 3, 'cotizaciones_anexos.php', '_SELF', b'1', 'anexos2.png', 4, '2017-08-31 20:13:18', '0000-00-00 00:00:00'),
(30, 'Remisiones', 11, 3, 'Remisiones.php', '_SELF', b'1', 'remision.png', 1, '2017-08-31 20:13:18', '0000-00-00 00:00:00'),
(31, 'Ajuste a Remision', 11, 3, 'Devoluciones.php', '_SELF', b'1', 'devolucion2.png', 2, '2017-08-31 20:13:18', '0000-00-00 00:00:00'),
(32, 'Historial de Facturas', 12, 3, 'facturas.php', '_SELF', b'1', 'factura.png', 1, '2017-08-31 20:13:18', '0000-00-00 00:00:00'),
(33, 'Historial de Facturas Detallado', 12, 3, 'facturas_items.php', '_SELF', b'1', 'detalle.png', 2, '2017-08-31 20:13:18', '0000-00-00 00:00:00'),
(34, 'Historial de Notas Credito', 12, 3, 'notascredito.php', '_SELF', b'1', 'historial3.png', 3, '2017-08-31 20:13:18', '0000-00-00 00:00:00'),
(35, 'Facturar desde Cotizacion', 12, 3, 'FactCoti.php', '_SELF', b'1', 'cotizacion.png', 4, '2017-08-31 20:13:18', '0000-00-00 00:00:00'),
(36, 'Historial', 13, 3, 'factura_compra.php', '_SELF', b'1', 'historial2.png', 2, '2017-08-31 20:44:31', '0000-00-00 00:00:00'),
(37, 'Historial de Productos Comprados', 13, 3, 'vista_compras_productos.php', '_SELF', b'1', 'historial.png', 3, '2017-08-31 20:44:37', '0000-00-00 00:00:00'),
(38, 'Historial de Productos Devueltos', 13, 3, 'vista_compras_productos_devoluciones.php', '_SELF', b'1', 'devoluciones.png', 5, '2017-08-31 20:44:44', '0000-00-00 00:00:00'),
(39, 'Historial de Compras Servicios', 13, 3, 'vista_compras_servicios.php', '_SELF', b'1', 'servicios_compras.png', 4, '2017-08-31 20:13:18', '0000-00-00 00:00:00'),
(40, 'Registrar una Compra', 13, 3, 'RegistraCompra.php', '_SELF', b'1', 'compras.png', 1, '2017-08-31 20:43:49', '0000-00-00 00:00:00'),
(41, 'Historial Egresos', 14, 3, 'egresos.php', '_SELF', b'1', 'historial.png', 1, '2017-08-31 20:43:49', '0000-00-00 00:00:00'),
(42, 'Historial Notas Contables', 14, 3, 'notascontables.php', '_SELF', b'1', 'historial3.png', 2, '2017-08-31 20:43:49', '0000-00-00 00:00:00'),
(43, 'Registrar Gasto o Compra', 14, 3, 'Egresos2.php', '_SELF', b'1', 'compramercancias.png', 3, '2017-08-31 20:43:49', '0000-00-00 00:00:00'),
(44, 'Historial de Compras Activas', 14, 3, 'compras_activas.php', '_SELF', b'1', 'historial4.png', 4, '2017-08-31 20:43:49', '0000-00-00 00:00:00'),
(45, 'Realizar un comprobante de Egreso Libre', 14, 3, 'ComprobantesEgresoLibre.php', '_SELF', b'1', 'precuenta.png', 5, '2017-08-31 20:43:49', '0000-00-00 00:00:00'),
(46, 'Historial de Cuentas x Pagar', 15, 3, 'cuentasxpagar_all.php', '_SELF', b'1', 'historial.png', 1, '2017-08-31 20:43:49', '0000-00-00 00:00:00'),
(47, 'Pagar', 15, 3, 'cuentasxpagar.php', '_SELF', b'1', 'cuentasxpagar.png', 1, '2017-08-31 20:43:49', '0000-00-00 00:00:00'),
(48, 'Balance General y Estado de Resultados', 16, 3, 'BalanceComprobacion.php', '_SELF', b'1', 'resultados.png', 1, '2017-08-31 20:43:49', '0000-00-00 00:00:00'),
(49, 'Cuentas Auxiliares', 17, 3, 'Auxiliares.php', '_SELF', b'1', 'auxiliar.png', 1, '2017-08-31 20:43:49', '0000-00-00 00:00:00'),
(50, 'Informe de Ventas', 18, 3, 'InformeVentas.php', '_SELF', b'1', 'infventas.png', 1, '2017-08-31 20:43:49', '0000-00-00 00:00:00'),
(51, 'Reporte de IVA', 19, 3, 'ReporteFiscalIVA.php', '_SELF', b'1', 'fiscales.png', 1, '2017-09-07 12:59:38', '0000-00-00 00:00:00'),
(52, 'Informe de Compras', 20, 3, 'InformeCompras.php', '_SELF', b'1', 'otrosinformes.png', 1, '2017-09-07 12:49:20', '0000-00-00 00:00:00'),
(53, 'Auditoria de Documentos', 21, 3, 'AuditoriaDocumentos.php', '_SELF', b'1', 'auditoria.png', 1, '2017-09-07 12:49:20', '0000-00-00 00:00:00'),
(54, 'Historial de Ediciones', 21, 3, 'registra_ediciones.php', '_SELF', b'1', 'registros.png', 2, '2017-09-07 12:49:20', '0000-00-00 00:00:00'),
(55, 'Productos para la venta', 22, 3, 'productosventa.php', '_SELF', b'1', 'productosventa.png', 1, '2017-09-07 12:49:20', '0000-00-00 00:00:00'),
(56, 'Productos para alquilar', 22, 3, 'productosalquiler.php', '_SELF', b'1', 'alquiler.png', 2, '2017-09-07 16:03:21', '0000-00-00 00:00:00'),
(57, 'Servicios para la venta', 22, 3, 'servicios.php', '_SELF', b'1', 'servicios.png', 3, '2017-09-07 16:03:21', '0000-00-00 00:00:00'),
(58, 'Ordenes de Compra', 22, 3, 'ordenesdecompra.php', '_SELF', b'1', 'ordendecompra.png', 4, '2017-09-07 16:03:21', '0000-00-00 00:00:00'),
(59, 'Kardex', 22, 3, 'vista_kardex.php', '_SELF', b'1', 'kardex.png', 5, '2017-09-07 16:03:21', '0000-00-00 00:00:00'),
(60, 'Historial de Compras', 22, 3, 'relacioncompras.php', '_SELF', b'1', 'compras.png', 6, '2017-09-07 16:03:21', '0000-00-00 00:00:00'),
(61, 'Agregar o Editar CB', 22, 3, 'prod_codbarras.php', '_SELF', b'1', 'codigobarras.png', 7, '2017-09-07 16:03:21', '0000-00-00 00:00:00'),
(62, 'Traslados', 22, 1, 'MnuTraslados.php', '_SELF', b'1', 'traslados.png', 8, '2017-09-07 16:08:07', '0000-00-00 00:00:00'),
(63, 'Crear Departamentos', 23, 3, 'prod_departamentos.php', '_SELF', b'1', 'departamentos.png', 1, '2017-09-07 16:03:21', '0000-00-00 00:00:00'),
(64, 'Subgrupo 1', 23, 3, 'prod_sub1.php', '_SELF', b'1', 'uno.png', 2, '2017-09-07 16:03:21', '0000-00-00 00:00:00'),
(65, 'Subgrupo 2', 23, 3, 'prod_sub2.php', '_SELF', b'1', 'dos.png', 3, '2017-09-07 16:10:12', '0000-00-00 00:00:00'),
(66, 'Subgrupo 3', 23, 3, 'prod_sub3.php', '_SELF', b'1', 'tres.png', 4, '2017-09-07 16:10:12', '0000-00-00 00:00:00'),
(67, 'Subgrupo 4', 23, 3, 'prod_sub4.php', '_SELF', b'1', 'cuatro.jpg', 5, '2017-09-07 16:10:12', '0000-00-00 00:00:00'),
(68, 'Subgrupo 5', 23, 3, 'prod_sub5.php', '_SELF', b'1', 'cinco.png', 6, '2017-09-07 16:10:12', '0000-00-00 00:00:00'),
(69, 'Ver/Crear/Editar Bodega', 24, 3, 'bodega.php', '_SELF', b'1', 'bodega.png', 1, '2017-09-07 16:10:12', '0000-00-00 00:00:00'),
(70, 'Ver Bodegas Externas', 24, 3, 'bodegas_externas.php', '_SELF', b'1', 'externas.png', 2, '2017-09-07 16:10:12', '0000-00-00 00:00:00'),
(71, 'Ver el historial de las bajas y altas', 25, 3, 'prod_bajas_altas.php', '_SELF', b'1', 'historial.png', 1, '2017-09-07 16:10:12', '0000-00-00 00:00:00'),
(72, 'Dar de baja o alta a un producto', 25, 3, 'DarBajaAlta.php', '_SELF', b'1', 'baja.png', 2, '2017-09-07 16:10:12', '0000-00-00 00:00:00'),
(73, 'Actualizaciones Generales', 26, 3, 'ActualizacionesGeneralesInventarios.php', '_SELF', b'1', 'actualizar.png', 1, '2017-09-07 16:10:12', '0000-00-00 00:00:00'),
(74, 'Consolidado Sistemas', 27, 3, 'vista_sistemas.php', '_SELF', b'1', 'sistema.png', 1, '2017-09-07 16:10:12', '0000-00-00 00:00:00'),
(75, 'Crear', 27, 3, 'CreaSistema.php', '_SELF', b'1', 'crearsistema.png', 2, '2017-09-07 16:10:12', '0000-00-00 00:00:00'),
(76, 'Agregar Productos desde CSV', 28, 3, 'AgregarItemsXCB.php', '_SELF', b'1', 'csv.png', 1, '2017-09-07 16:10:12', '0000-00-00 00:00:00'),
(77, 'Preparar Conteo Fisico', 28, 3, 'inventario_preparacion.php', '_SELF', b'1', 'terminado.png', 2, '2017-09-07 16:10:12', '0000-00-00 00:00:00'),
(78, 'Tabla Temporal', 28, 3, 'inventarios_temporal.php', '_SELF', b'1', 'pedidos.png', 3, '2017-09-07 16:10:12', '0000-00-00 00:00:00'),
(79, 'Realizar Conteo Fisico', 28, 3, 'ConteoFisico.php', '_SELF', b'1', 'conteo_inventario.png', 4, '2017-09-07 16:10:12', '0000-00-00 00:00:00'),
(80, 'Iniciar', 28, 3, 'ConteoFisicoPDA.php', '_SELF', b'1', 'PDA.png', 5, '2017-09-07 16:10:12', '0000-00-00 00:00:00'),
(81, 'Diferencias en los inventarios', 28, 3, 'inventarios_diferencias.php', '_SELF', b'1', 'inventarios_diferencias.png', 6, '2017-09-07 16:10:12', '0000-00-00 00:00:00'),
(82, 'Proyectos', 29, 3, 'requerimientos_proyectos.php', '_SELF', b'1', 'proyectos.png', 1, '2017-09-07 16:10:12', '0000-00-00 00:00:00'),
(83, 'Atencion Mesas', 30, 3, 'AtencionMeseros.php', '_SELF', b'1', 'mesero.png', 1, '2017-09-07 16:10:12', '0000-00-00 00:00:00'),
(84, 'Atencion Domicilios', 30, 3, 'AtencionDomicilios.php', '_SELF', b'1', 'atencion_domicilios.png', 2, '2017-09-07 16:56:36', '0000-00-00 00:00:00'),
(85, 'Pedidos', 30, 3, 'Restaurante_Admin.php', '_SELF', b'1', 'pedidos.png', 3, '2017-09-07 16:10:12', '0000-00-00 00:00:00'),
(86, 'Crear o Editar Mesas', 31, 3, 'mesas.php', '_SELF', b'1', 'mesas.png', 3, '2017-09-07 16:10:12', '0000-00-00 00:00:00'),
(87, 'Promociones', 32, 3, 'titulos_promociones.php', '_SELF', b'1', 'promociones.png', 1, '2017-09-07 16:10:12', '0000-00-00 00:00:00'),
(88, 'Inventario de Titulos', 32, 3, 'listados_titulos.php', '_SELF', b'1', 'inventarios_titulos.png', 2, '2017-09-07 17:07:39', '0000-00-00 00:00:00'),
(89, 'Historial de Actas de Entrega', 32, 3, 'titulos_asignaciones.php', '_SELF', b'1', 'acta.png', 3, '2017-09-07 17:07:39', '0000-00-00 00:00:00'),
(90, 'Venta de Titulos', 32, 3, 'VentasTitulos.php', '_SELF', b'1', 'ventastitulos.png', 4, '2017-09-07 17:07:39', '0000-00-00 00:00:00'),
(91, 'Historial de Venta de Titulos', 32, 3, 'titulos_ventas.php', '_SELF', b'1', 'historial.png', 5, '2017-09-07 17:07:39', '0000-00-00 00:00:00'),
(92, 'Historial de Abonos a Ventas', 32, 3, 'titulos_abonos.php', '_SELF', b'1', 'abonos.png', 6, '2017-09-07 17:07:39', '0000-00-00 00:00:00'),
(93, 'Historial de Titulos Devueltos', 32, 3, 'titulos_devoluciones.php', '_SELF', b'1', 'historial2.png', 7, '2017-09-07 17:07:39', '0000-00-00 00:00:00'),
(94, 'Cuentas X Cobrar', 32, 3, 'titulos_cuentasxcobrar.php', '_SELF', b'1', 'cuentasxcobrar.png', 8, '2017-09-07 17:07:39', '0000-00-00 00:00:00'),
(95, 'Comisiones', 32, 3, 'titulos_comisiones.php', '_SELF', b'1', 'comisiones.png', 9, '2017-09-07 17:07:39', '0000-00-00 00:00:00'),
(96, 'Historial de Traslados', 32, 3, 'titulos_traslados.php', '_SELF', b'1', 'traslado.png', 10, '2017-09-07 17:07:39', '0000-00-00 00:00:00'),
(97, 'Historial de Anulacion de Abonos', 32, 3, 'comprobantes_ingreso_anulaciones.php', '_SELF', b'1', 'historial3.png', 11, '2017-09-07 17:12:07', '0000-00-00 00:00:00'),
(98, 'Informes', 32, 3, 'InformeTitulos.php', '_SELF', b'1', 'informes.png', 12, '2017-09-07 17:12:07', '0000-00-00 00:00:00'),
(99, 'Historial', 33, 3, 'traslados_mercancia.php', '_SELF', b'1', 'historial.png', 1, '2017-09-07 17:12:07', '0000-00-00 00:00:00'),
(100, 'Nuevo', 33, 3, 'CreaTraslado.php', '_SELF', b'1', 'nuevo.png', 2, '2017-09-07 17:12:07', '0000-00-00 00:00:00'),
(101, 'Subir Traslados', 33, 3, 'SubirTraslado.php', '_SELF', b'1', 'upload.png', 3, '2017-09-07 17:12:07', '0000-00-00 00:00:00'),
(102, 'Descargar Traslados', 33, 3, 'DescargarTraslados.php', '_SELF', b'1', 'descargar.png', 4, '2017-09-07 17:12:07', '0000-00-00 00:00:00'),
(103, 'Seguimiento', 34, 3, '_.php', '_SELF', b'1', 'departamentos.png', 1, '2017-09-07 17:12:07', '0000-00-00 00:00:00'),
(104, 'Crear o Editar cartel de publicidad', 35, 3, 'CrearCartelPublicitario.php', '_SELF', b'1', 'cartel.png', 1, '2017-09-07 17:12:07', '0000-00-00 00:00:00');

INSERT INTO `formatos_calidad` (`ID`, `Nombre`, `Version`, `Codigo`, `Fecha`, `NotasPiePagina`, `Updated`, `Sync`) VALUES ('24', 'INFORME FISCAL DE IVA', '001', 'F-GF-005', '2017-08-09', '', '2017-06-15 09:03:57', '2017-06-15 09:03:57');

ALTER TABLE `facturas_items` ADD INDEX(`idFactura`);
ALTER TABLE `ori_facturas_items` ADD INDEX(`idFactura`);
ALTER TABLE `factura_compra_items` ADD INDEX(`idFacturaCompra`);

--
-- Estructura de tabla para la tabla `publicidad_encabezado_cartel`
--

CREATE TABLE IF NOT EXISTS `publicidad_encabezado_cartel` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Titulo` text COLLATE latin1_spanish_ci NOT NULL,
  `ColorTitulo` varchar(10) COLLATE latin1_spanish_ci NOT NULL,
  `Desde` int(11) NOT NULL,
  `Hasta` int(11) NOT NULL,
  `Mes` varchar(20) COLLATE latin1_spanish_ci NOT NULL,
  `Anio` int(11) NOT NULL,
  `ColorRazonSocial` varchar(10) COLLATE latin1_spanish_ci NOT NULL,
  `ColorPrecios` varchar(10) COLLATE latin1_spanish_ci NOT NULL,
  `ColorBordes` varchar(10) COLLATE latin1_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publicidad_paginas`
--

CREATE TABLE IF NOT EXISTS `publicidad_paginas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `idProducto` bigint(20) NOT NULL,
  `Observaciones` text COLLATE latin1_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=100 ;

ALTER TABLE `productosventa` ADD `CostoUnitarioPromedio` DOUBLE NOT NULL AFTER `CostoTotal`;
ALTER TABLE `productosventa` CHANGE `PrecioMayorista` `PrecioMayorista` DOUBLE NOT NULL;
ALTER TABLE `productosventa` CHANGE `CostoUnitario` `CostoUnitario` DOUBLE NULL DEFAULT NULL;
ALTER TABLE `productosventa` CHANGE `CostoTotal` `CostoTotal` DOUBLE NULL DEFAULT NULL;
ALTER TABLE `productosventa` ADD `CostoTotalPromedio` DOUBLE NOT NULL AFTER `CostoUnitarioPromedio`;
UPDATE `productosventa` SET `CostoUnitarioPromedio`=`CostoUnitario`,`CostoTotalPromedio`=`CostoTotal` ;


DROP VIEW IF EXISTS `vista_resumen_facturacion`;
CREATE VIEW vista_resumen_facturacion AS
SELECT ID,`FechaFactura` as FechaInicial,`FechaFactura` as FechaFinal,`Referencia`,`Nombre`,`Departamento`,`SubGrupo1`,`SubGrupo2`,`SubGrupo3`,`SubGrupo4`,`SubGrupo5`,SUM(`Cantidad`) as Cantidad,round(SUM(`TotalItem`),2) as TotalVenta,round(SUM(`SubtotalCosto`),2) as Costo
  FROM `facturas_items` GROUP BY `Referencia`,`FechaFactura`;

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES ('105', 'Resumen de facturacion', '12', '3', 'vista_resumen_facturacion.php', '_SELF', b'1', 'resumen.png', '5', '2017-09-07 12:12:07', '0000-00-00 00:00:00');
ALTER TABLE `cot_itemscotizaciones` ADD INDEX(`NumCotizacion`);
ALTER TABLE `facturas_items` ADD INDEX(`idCierre`);

INSERT INTO `parametros_contables` (`ID`, `Descripcion`, `CuentaPUC`, `NombreCuenta`, `Updated`, `Sync`) VALUES
(20, 'Anticipos realizados por clientes', 280505, 'ANTICIPOS REALIZADOS POR CLIENTES', '2017-09-29 15:24:03', '2017-06-06 12:13:00');

ALTER TABLE `comprobantes_ingreso` ADD `Estado` VARCHAR(10) NOT NULL AFTER `Usuarios_idUsuarios`;
ALTER TABLE `comprobantes_ingreso` ADD `idCierre` BIGINT NOT NULL AFTER `Estado`;
UPDATE `comprobantes_ingreso` SET `idCierre`=1;
ALTER TABLE `empresapro` ADD `FacturaSinInventario` VARCHAR(2) NOT NULL DEFAULT 'SI' AFTER `RutaImagen`;
ALTER TABLE `empresapro` ADD `CXPAutomaticas` VARCHAR(2) NOT NULL DEFAULT 'SI' AFTER `FacturaSinInventario`;
ALTER TABLE `colaboradores` ADD `Activo` VARCHAR(2) NOT NULL DEFAULT 'SI' AFTER `SalarioBasico`;
INSERT INTO `formatos_calidad` (`ID`, `Nombre`, `Version`, `Codigo`, `Fecha`, `NotasPiePagina`, `Updated`, `Sync`) VALUES (25, 'COMPROBANTE DE BAJAS O ALTAS', '001', 'F-GI-006', '2017-08-09', '', '2017-06-15 09:03:57', '2017-06-15 09:03:57');

ALTER TABLE `productosalquiler` CHANGE `Existencias` `Existencias` INT NOT NULL;
ALTER TABLE `productosalquiler` CHANGE `PrecioVenta` `PrecioVenta` DOUBLE NOT NULL;
ALTER TABLE `productosalquiler` CHANGE `PrecioMayorista` `PrecioMayorista` DOUBLE NOT NULL;
ALTER TABLE `productosalquiler` CHANGE `CostoUnitario` `CostoUnitario` DOUBLE NOT NULL;
ALTER TABLE `productosalquiler` ADD `EnAlquiler` INT NOT NULL AFTER `Existencias`, ADD `EnBodega` INT NOT NULL AFTER `EnAlquiler`;
INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES ('106', 'Kardex Alquiler', '22', '3', 'kardex_alquiler.php', '_SELF', b'1', 'kardex_alquiler.png', '5', '2017-09-07 11:03:21', '0000-00-00 00:00:00');
ALTER TABLE `restaurante_pedidos_items` ADD INDEX(`idPedido`);
INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES ('107', 'Historial de Cierres', '30', '3', 'restaurante_cierres.php', '_SELF', b'1', 'historial.png', '4', '2017-10-11 20:22:44', '0000-00-00 00:00:00');
INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES ('108', 'Historial de Pedidos', '30', '3', 'restaurante_pedidos.php', '_SELF', b'1', 'historial2.png', '5', '2017-10-11 23:03:06', '0000-00-00 00:00:00');
INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES ('109', 'Historial de Eliminaciones', '21', '3', 'registra_eliminaciones.php', '_SELF', b'1', 'papelera.png', '3', '2017-09-07 07:49:20', '0000-00-00 00:00:00');

DROP TABLE IF EXISTS `registra_eliminaciones`;
CREATE TABLE IF NOT EXISTS `registra_eliminaciones` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `Campo` text COLLATE latin1_spanish_ci NOT NULL,
  `Valor` text COLLATE latin1_spanish_ci NOT NULL,
  `Causal` text COLLATE latin1_spanish_ci NOT NULL,
  `TablaOrigen` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `idTabla` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `idItemEliminado` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `TablaOrigen` (`TablaOrigen`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

ALTER TABLE `colaboradores` CHANGE `Activo` `Activo` VARCHAR(2) NOT NULL DEFAULT 'SI';
ALTER TABLE `empresapro` CHANGE `CXPAutomaticas` `CXPAutomaticas` VARCHAR(2) NOT NULL DEFAULT 'SI';

CREATE TABLE IF NOT EXISTS `facturas_kardex` (
  `idFacturas` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `CuentaDestino` bigint(20) NOT NULL,
  `Kardex` varchar(2) COLLATE latin1_spanish_ci NOT NULL DEFAULT 'NO',
  `idUsuario` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idFacturas`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

UPDATE `menu` SET `Image` = 'pub.png' WHERE `menu`.`ID` = 25;

ALTER TABLE `librodiario` ADD INDEX(`Tipo_Documento_Intero`);
ALTER TABLE `librodiario` ADD INDEX(`Num_Documento_Interno`);
ALTER TABLE `librodiario` ADD INDEX(`Tercero_Identificacion`);
ALTER TABLE `librodiario` ADD INDEX(`CuentaPUC`);

ALTER TABLE `kardexmercancias` ADD `CostoUnitarioPromedio` DOUBLE NOT NULL AFTER `ValorTotal`, ADD `CostoTotalPromedio` DOUBLE NOT NULL AFTER `CostoUnitarioPromedio`;
ALTER TABLE `kardexmercancias_temporal` ADD `CostoUnitarioPromedio` DOUBLE NOT NULL AFTER `ValorTotal`, ADD `CostoTotalPromedio` DOUBLE NOT NULL AFTER `CostoUnitarioPromedio`;
UPDATE `kardexmercancias` SET `CostoUnitarioPromedio`=`ValorUnitario`,`CostoTotalPromedio`=`ValorTotal`;
INSERT INTO `formatos_calidad` (`ID`, `Nombre`, `Version`, `Codigo`, `Fecha`, `NotasPiePagina`, `Updated`, `Sync`) VALUES ('26', 'ESTADO DE RESULTADO INTEGRAL', '001', 'F-GF-002', '2017-08-09', '', '2017-10-13 14:10:40', '2017-10-13 14:10:40');
ALTER TABLE `estadosfinancieros_mayor_temporal` ADD `SaldoAnterior` DOUBLE NOT NULL AFTER `NombreCuenta`;
ALTER TABLE `estadosfinancieros_mayor_temporal` ADD `SaldoFinal` DOUBLE NOT NULL AFTER `Neto`;
ALTER TABLE `estadosfinancieros_mayor_temporal` CHANGE `Neto` `Neto` DOUBLE NOT NULL;


DROP VIEW IF EXISTS `vista_resumen_facturacion`;
CREATE VIEW vista_resumen_facturacion AS
SELECT ID,`FechaFactura` as FechaInicial,`FechaFactura` as FechaFinal,`Referencia`,(SELECT idProductosVenta FROM productosventa WHERE productosventa.Referencia=facturas_items.Referencia) as idProducto,`Nombre`,`Departamento`,`SubGrupo1`,`SubGrupo2`,`SubGrupo3`,`SubGrupo4`,`SubGrupo5`,SUM(`Cantidad`) as Cantidad,round(SUM(`TotalItem`),2) as TotalVenta,round(SUM(`SubtotalCosto`),2) as Costo
  FROM `facturas_items` GROUP BY `FechaFactura`,`Referencia`;



ALTER TABLE `librodiario` ENGINE = MyISAM;
ALTER TABLE `facturas_items` ENGINE = MyISAM;
ALTER TABLE `facturas_items` ADD INDEX(`FechaFactura`);
ALTER TABLE `librodiario` ADD INDEX(`Fecha`);

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES ('110', 'Resumen de facturacion X Fecha', '12', '3', 'facturacionxfecha.php', '_SELF', b'1', 'fecha.png', '4', '2017-10-13 14:16:57', '2017-10-11 14:16:57');


--
-- Estructura de tabla para la tabla `configuracion_general`
--
DROP TABLE IF EXISTS `configuracion_general`;
CREATE TABLE IF NOT EXISTS `configuracion_general` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` text COLLATE latin1_spanish_ci NOT NULL,
  `Valor` text COLLATE latin1_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `configuracion_general`
--

INSERT INTO `configuracion_general` (`ID`, `Descripcion`, `Valor`) VALUES
(1, 'RUTA PARA EXPORTAR TABLAS EN CSV', '../../htdocs/ts5/exports/tabla.csv');

