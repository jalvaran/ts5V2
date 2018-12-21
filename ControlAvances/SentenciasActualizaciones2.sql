ALTER TABLE `facturas_pre` CHANGE `Cantidad` `Cantidad` DOUBLE NOT NULL;
ALTER TABLE `facturas_pre` CHANGE `Dias` `Dias` DOUBLE NOT NULL;
ALTER TABLE `facturas_pre` CHANGE `SubtotalItem` `SubtotalItem` DOUBLE NOT NULL;
ALTER TABLE `facturas_pre` CHANGE `IVAItem` `IVAItem` DOUBLE NOT NULL;
ALTER TABLE `facturas_pre` CHANGE `TotalItem` `TotalItem` DOUBLE NOT NULL;
ALTER TABLE `facturas_pre` CHANGE `PorcentajeIVA` `PorcentajeIVA` DOUBLE NOT NULL;
ALTER TABLE `facturas_pre` CHANGE `PrecioCostoUnitario` `PrecioCostoUnitario` DOUBLE NOT NULL;
ALTER TABLE `facturas_pre` CHANGE `SubtotalCosto` `SubtotalCosto` DOUBLE NOT NULL;
ALTER TABLE `facturas_pre` CHANGE `FechaFactura` `FechaFactura` DATE NOT NULL;
ALTER TABLE `facturas_pre` CHANGE `Nombre` `Nombre` TEXT CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL;
ALTER TABLE `facturas_pre` CHANGE `ValorUnitarioItem` `ValorUnitarioItem` DOUBLE NOT NULL;

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (111, 'Historial detallado', '33', '3', 'traslados_items.php', '_SELF', b'1', 'historial2.png', '4', '2017-10-13 14:16:57', '2017-10-13 14:16:57');
INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (112, 'Sistemas', '27', '3', 'sistemas.php', '_SELF', b'1', 'sistem.png', '1', '2017-10-13 14:16:57', '2017-10-13 14:16:57');

ALTER TABLE `inventarios_temporal` ADD `CostoUnitarioPromedio` DOUBLE NOT NULL AFTER `CostoTotal`;
ALTER TABLE `inventarios_temporal` CHANGE `PrecioMayorista` `PrecioMayorista` DOUBLE NOT NULL;
ALTER TABLE `inventarios_temporal` CHANGE `CostoUnitario` `CostoUnitario` DOUBLE NULL DEFAULT NULL;
ALTER TABLE `inventarios_temporal` CHANGE `CostoTotal` `CostoTotal` DOUBLE NULL DEFAULT NULL;
ALTER TABLE `inventarios_temporal` ADD `CostoTotalPromedio` DOUBLE NOT NULL AFTER `CostoUnitarioPromedio`;

INSERT INTO `subcuentas` (`PUC`, `Nombre`, `Valor`, `Cuentas_idPUC`, `Updated`, `Sync`) VALUES ('220505', 'PROVEEDORES NACIONALES', NULL, '2205', CURRENT_TIMESTAMP, '0000-00-00 00:00:00');
ALTER TABLE `cuentasxpagar` ADD `Estado` VARCHAR(20) NOT NULL  AFTER `idUsuario`;

ALTER TABLE `cuentasxpagar` ADD `CuentaPUC` VARCHAR(20) NOT NULL DEFAULT '220505' AFTER `Estado`;

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (113, 'Inventario de Separados', '22', '3', 'vista_inventario_separados.php', '_SELF', b'1', 'inventario_separados.png', '3', '2017-10-13 14:16:57', '2017-10-13 14:16:57');

ALTER TABLE `separados` ADD `Observaciones` TEXT NOT NULL AFTER `Estado`;

INSERT INTO `porcentajes_iva` (`ID`, `Nombre`, `Valor`, `Factor`, `CuentaPUC`, `CuentaPUCIVAGenerado`, `NombreCuenta`, `Habilitado`, `Updated`, `Sync`) VALUES ('8', 'impuesto del 1.9%', '0.019', 'M', '24080505', '24081005', 'Impuestos del 10% del 19%', 'SI', '2017-10-13 14:28:50', '2017-10-13 14:28:50');

ALTER TABLE `comprobantes_contabilidad_items` CHANGE `Tercero` `Tercero` VARCHAR(45) NOT NULL;

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (114, 'Comparacion Anual', '9', '5', 'YearsComparison.php', '_SELF', b'1', 'anualcomp.jpg', '6', '2017-10-13 14:16:57', '2017-10-13 14:16:57');
INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (115, 'Comparacion Diaria', '9', '5', 'DiasComparacion.php', '_SELF', b'1', 'diascomp.png', '6', '2017-10-13 14:16:57', '2017-10-13 14:16:57');

INSERT INTO `menu_carpetas` (`ID`, `Ruta`, `Updated`, `Sync`) VALUES (5, '../Graficos/', '2017-10-13 14:16:51', '2017-10-13 14:16:51');

INSERT INTO `menu` (`ID`, `Nombre`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (26, 'Salud', '1', 'MnuSalud.php', '_BLANK', '0', 'salud.png', '18', '2017-10-16 20:26:13', '2017-10-13 14:16:49');

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (116, 'Subir RIPS Generados', '36', '5', 'Salud_SubirRips.php', '_SELF', b'1', 'upload2.png', '1', '2017-10-13 14:16:57', '2017-10-13 14:16:57');

INSERT INTO `menu_pestanas` (`ID`, `Nombre`, `idMenu`, `Orden`, `Estado`, `Updated`, `Sync`) VALUES (36, 'RIPS', '26', '1', b'1', '2017-10-13 14:16:55', '2017-10-13 14:16:55');

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (117, 'Subir RIPS de pago', '36', '3', 'Salud_SubirRipsPagos.php', '_SELF', b'1', 'upload.png', '3', '2017-12-11 10:44:06', '2017-10-13 14:16:57');

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (118, 'Radicar Facturas', '36', '3', 'salud_radicacion_facturas.php', '_SELF', b'1', 'radicar.jpg', '2', '2017-12-11 10:44:06', '2017-10-13 14:16:57');

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (119, 'Historial de Facturas Pagas', '36', '3', 'vista_salud_facturas_pagas.php', '_SELF', b'1', 'historial.png', '4', '2017-12-18 07:51:25', '2017-10-13 14:16:57');


INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (120, 'Historial de Facturas NO Pagadas', '36', '3', 'vista_salud_facturas_no_pagas.php', '_SELF', b'1', 'historial2.png', '5', '2017-12-18 07:51:25', '2017-10-13 14:16:57');


INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (121, 'Historial de Facturas Con Diferencias', '36', '3', 'vista_salud_facturas_diferencias.php', '_SELF', b'1', 'historial3.png', '6', '2017-12-18 07:51:25', '2017-10-13 14:16:57');

CREATE TABLE IF NOT EXISTS `productos_lista_precios` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `Descripcion` text COLLATE latin1_spanish_ci NOT NULL,
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `productos_lista_precios`
--

INSERT INTO `productos_lista_precios` (`ID`, `Nombre`, `Descripcion`, `idUser`, `Updated`, `Sync`) VALUES
(1, 'Distribuidor', 'Precio dado para un distribuidor', 3, '2017-12-19 13:27:55', '0000-00-00 00:00:00'),
(2, 'Intermediario', '', 3, '2017-12-19 13:27:55', '0000-00-00 00:00:00'),
(3, 'Morosos', '', 3, '2017-12-19 13:27:55', '0000-00-00 00:00:00');


CREATE TABLE IF NOT EXISTS `productos_precios_adicionales` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idProducto` bigint(20) NOT NULL,
  `idListaPrecios` int(11) NOT NULL,
  `PrecioVenta` double NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci COMMENT='tabla para agregar precios a los productos' AUTO_INCREMENT=1 ;


ALTER TABLE `productos_precios_adicionales` ADD `TablaVenta` VARCHAR(45) NOT NULL AFTER `PrecioVenta`;

ALTER TABLE `productos_precios_adicionales` ADD `idUser` INT NOT NULL AFTER `TablaVenta`;

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (122, 'Listas de precios', '22', '3', 'productos_lista_precios.php', '_SELF', b'1', 'listasprecios.png', '5', '2017-10-13 14:16:57', '2017-10-13 14:16:57');

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (123, 'Precios Adicionales', '22', '3', 'productos_precios_adicionales.php', '_SELF', b'1', 'productos_precios.png', '5', '2017-10-13 14:16:57', '2017-10-13 14:16:57');

INSERT INTO `menu_pestanas` (`ID`, `Nombre`, `idMenu`, `Orden`, `Estado`, `Updated`, `Sync`) VALUES
(39, 'Legal', 26, 3, b'1', '2017-12-20 15:06:39', '2017-10-13 14:16:55'),
(38, 'Archivos', 26, 4, b'1', '2017-12-20 15:06:39', '2017-10-13 14:16:55'),
(37, 'Auditoria', 26, 2, b'1', '2017-12-20 15:07:49', '2017-10-13 14:16:55');
INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (124, 'Glosas y Devoluciones', '37', '3', 'SaludGlosasDevoluciones.php', '_SELF', b'1', 'glosas.png', '1', '2017-12-18 07:51:25', '2017-10-13 14:16:57');

INSERT INTO `menu_pestanas` (`ID`, `Nombre`, `idMenu`, `Orden`, `Estado`, `Updated`, `Sync`) VALUES (40, 'Informes', '26', '5', b'1', '2017-12-20 10:06:39', '2017-10-13 14:16:55');

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (125, 'Informe de Estado de Rips', '40', '3', 'SaludInformeEstadoRips.php', '_SELF', b'1', 'estadorips.png', '1', '2017-12-20 10:14:35', '2017-10-13 14:16:57');
INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (126, 'Cartera X Edades', '40', '3', 'salud_edad_cartera.php', '_SELF', b'1', 'cartera.png', '2', '2017-12-20 10:14:35', '2017-10-13 14:16:57');
INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (127, 'Registro de Glosas', '36', '3', 'salud_registro_glosas.php', '_SELF', b'1', 'glosas2.png', '7', '2017-12-18 07:51:25', '2017-10-13 14:16:57');
INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (128, 'Archivo de Consultas AC', '38', '3', 'salud_archivo_consultas.php', '_SELF', b'1', 'ac.png', '1', '2017-12-18 07:51:25', '2017-10-13 14:16:57');
INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (129, 'Archivo de Hospitalizaciones AH', '38', '3', 'salud_archivo_hospitalizaciones.php', '_SELF', b'1', 'ah.png', '2', '2017-12-18 07:51:25', '2017-10-13 14:16:57');


INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (130, 'Archivo de Medicamentos AM', '38', '3', 'salud_archivo_medicamentos.php', '_SELF', b'1', 'am.png', '3', '2017-12-18 07:51:25', '2017-10-13 14:16:57');
INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (131, 'Otros Servicios AT', '38', '3', 'salud_archivo_otros_servicios.php', '_SELF', b'1', 'at.png', '4', '2017-12-18 07:51:25', '2017-10-13 14:16:57');

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (132, 'Archivo de Procedimientos AP', '38', '3', 'salud_archivo_procedimientos.php', '_SELF', b'1', 'ap.jpg', '5', '2017-12-18 07:51:25', '2017-10-13 14:16:57');
INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (134, 'Archivo de usuarios US', '38', '3', 'salud_archivo_usuarios.php', '_SELF', b'1', 'us.png', '6', '2017-12-18 07:51:25', '2017-10-13 14:16:57');

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (135, 'Facturacion Generada AF', '38', '3', 'salud_archivo_facturacion_mov_generados.php', '_SELF', b'1', 'af.png', '7', '2017-12-18 07:51:25', '2017-10-13 14:16:57');
INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (136, 'Facturacion Recaudada AR', '38', '3', 'salud_archivo_facturacion_mov_pagados.php', '_SELF', b'1', 'ar.png', '8', '2017-12-18 07:51:25', '2017-10-13 14:16:57');

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (137, 'Listado de EPS', '36', '3', 'salud_eps.php', '_SELF', b'1', 'eps.png', '8', '2017-12-18 07:51:25', '2017-10-13 14:16:57');

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (138, 'Facturas Pagas No Generadas', '37', '3', 'vista_salud_pagas_no_generadas.php', '_SELF', b'1', 'factura3.png', '8', '2017-12-18 07:51:25', '2017-10-13 14:16:57');

DROP TABLE IF EXISTS `libromayorbalances`;
CREATE TABLE IF NOT EXISTS `libromayorbalances` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `FechaInicial` date NOT NULL,
  `FechaFinal` date NOT NULL,
  `CuentaPUC` bigint(20) DEFAULT NULL,
  `NombreCuenta` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `SaldoAnterior` double NOT NULL,
  `Debito` double DEFAULT NULL,
  `Credito` double DEFAULT NULL,
  `NuevoSaldo` double NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (139, 'Libro Mayor y Balances', '16', '3', 'libromayorbalances.php', '_SELF', b'1', 'libromayor.png', '1', '2017-10-13 14:16:57', '2017-10-13 14:16:57');


INSERT INTO `menu_carpetas` (`ID`, `Ruta`, `Updated`, `Sync`) VALUES (6, '../Salud/', '2017-10-13 14:16:51', '2017-10-13 14:16:51');

ALTER TABLE `salud_archivo_facturacion_mov_pagados` ADD `Soporte` VARCHAR(45) NOT NULL AFTER `Estado`;
ALTER TABLE `salud_archivo_facturacion_mov_pagados_temp` ADD `Soporte` VARCHAR(45) NOT NULL AFTER `Estado`;



INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (140, 'Generar Prejuridicos', '39', '6', 'SaludPrejuridicos.php', '_SELF', b'1', 'prejuridico.jpg', '1', '2018-01-04 08:40:15', '2017-10-13 14:16:57');

INSERT INTO `formatos_calidad` (`ID`, `Nombre`, `Version`, `Codigo`, `Fecha`, `NotasPiePagina`, `Updated`, `Sync`) VALUES (27, 'COBRO PREJURIDICO 1', '001', 'F-GSL-001', '2018-01-02', '', '2017-10-20 10:30:00', '2017-10-20 10:30:00');
INSERT INTO `formatos_calidad` (`ID`, `Nombre`, `Version`, `Codigo`, `Fecha`, `NotasPiePagina`, `Updated`, `Sync`) VALUES (28, 'COBRO PREJURIDICO 2', '001', 'F-GSL-002', '2018-01-02', '', '2017-10-20 10:30:00', '2017-10-20 10:30:00');

ALTER TABLE `prod_bajas_altas` CHANGE `Fecha` `Fecha` DATE NOT NULL;
ALTER TABLE `prod_bajas_altas` CHANGE `Cantidad` `Cantidad` DOUBLE NOT NULL;


INSERT INTO `menu` (`ID`, `Nombre`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) 
VALUES (28, 'Graficos', '1', 'MnuGraficosVentas.php', '_BLANK', '0', 'graficos.png', '1', '2017-10-13 14:16:49', '2017-10-13 14:16:49');

INSERT INTO `menu_pestanas` (`ID`, `Nombre`, `idMenu`, `Orden`, `Estado`, `Updated`, `Sync`) 
VALUES (41, 'Reportes Graficos', '17', '7', b'1', '2017-12-26 21:55:19', '2017-10-13 14:16:55');

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) 
VALUES (141, 'Reportes Graficos', '41', '1', 'MnuGraficosVentas.php', '_SELF', b'1', 'graficos.png', '1', '2017-12-19 11:03:31', '2017-10-13 14:16:57');

INSERT INTO `menu_pestanas` (`ID`, `Nombre`, `idMenu`, `Orden`, `Estado`, `Updated`, `Sync`) 
VALUES (42, 'Ventas', '28', '1', b'1', '2018-01-22 15:05:00', '2017-10-13 14:16:55');

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) 
VALUES (142, 'Comparacion Anual', '42', '5', 'YearsComparison.php', '_SELF', b'1', 'anualcomp.jpg', '1', '2017-11-23 13:19:43', '2017-10-13 14:16:57');

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) 
VALUES (143, 'Comparacion Diaria', '42', '5', 'DiasComparacion.php', '_SELF', b'1', 'diascomp.png', '2', '2017-10-13 14:16:57', '2017-10-13 14:16:57');

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) 
VALUES (144, 'Graficos Ventas Departamentos', '42', '3', 'GraficosVentasXDepartamentos.php', '_SELF', b'1', 'graficos.png', '2', '2017-10-13 14:16:57', '2017-10-13 14:16:57');

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (145, 'Circular 030', '40', '6', 'salud_edad_cartera.php', '_SELF', b'1', '030.jpg', '3', '2018-01-04 08:40:18', '2017-10-13 14:16:57');
INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (146, 'SIHO', '40', '6', 'salud_edad_cartera.php', '_SELF', b'1', 'siho.png', '4', '2018-01-04 08:40:18', '2017-10-13 14:16:57');

INSERT INTO `menu_pestanas` (`ID`, `Nombre`, `idMenu`, `Orden`, `Estado`, `Updated`, `Sync`) VALUES (43, 'Tesoreria', '26', '6', b'1', '2017-12-26 21:55:19', '2017-10-13 14:16:55');

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (147, 'Totales en Compras', '13', '3', 'vista_factura_compra_totales.php', '_SELF', b'1', 'historial3.png', '6', '2017-10-13 14:16:57', '2017-10-13 14:16:57');

ALTER TABLE `prod_comisiones` CHANGE `Dep_Comision` `Dep_Comision` INT NOT NULL;

ALTER TABLE `prod_comisiones` CHANGE `Porcentaje_Comision` `Porcentaje_Comision` DOUBLE NOT NULL;
ALTER TABLE `prod_comisiones` CHANGE `Valor_Comision` `Valor_Comision` DOUBLE NOT NULL;

ALTER TABLE `preventa` CHANGE `Fecha` `Fecha` DATE NULL DEFAULT NULL;

ALTER TABLE `productos_impuestos_adicionales` ADD `Incluido` ENUM('SI','NO') NOT NULL DEFAULT 'NO' AFTER `NombreCuenta`;

ALTER TABLE `prod_comisiones` CHANGE `Valor_Comision` `ValorComision1` DOUBLE NOT NULL;
ALTER TABLE `prod_comisiones` ADD `ValorComision2` DOUBLE NOT NULL AFTER `ValorComision1`;
ALTER TABLE `prod_comisiones` ADD `ValorComision3` DOUBLE NOT NULL AFTER `ValorComision2`;

ALTER TABLE `facturas_items` CHANGE `Referencia` `Referencia` VARCHAR(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL ;
ALTER TABLE `productosventa` CHANGE `Referencia` `Referencia` VARCHAR(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL ;


ALTER TABLE `productosventa` ADD `ValorComision1` INT NOT NULL AFTER `CuentaPUC`, 
ADD `ValorComision2` INT NOT NULL AFTER `ValorComision1`,
 ADD `ValorComision3` INT NOT NULL AFTER `ValorComision2`;

INSERT INTO `formatos_calidad` (`ID`, `Nombre`, `Version`, `Codigo`, `Fecha`, `NotasPiePagina`, `Updated`, `Sync`) VALUES (29, 'COMPROBANTE DE MOVIMIENTOS CONTABLES', '001', 'F-GFC-003', '2018-02-13', '', '2018-01-10 17:22:33', '2017-10-20 10:30:00');
INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (148, 'Generar Comprobante de movimientos contables', '16', '3', 'ComprobantesContables.php', '_SELF', b'1', 'comprobantes.png', '3', '2017-10-13 14:16:57', '2017-10-13 14:16:57');

ALTER TABLE `preventa` ADD `idSistema` INT NOT NULL AFTER `TipoItem`;

ALTER TABLE `kardexmercancias` CHANGE `ProductosVenta_idProductosVenta` `ProductosVenta_idProductosVenta` BIGINT NOT NULL;

ALTER TABLE `proveedores` ADD `Soporte` VARCHAR(150) NOT NULL AFTER `Cupo`;
ALTER TABLE `clientes` ADD `Soporte` VARCHAR(150) NOT NULL AFTER `Cupo`;

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (149, 'Diagnostico de RIPS Circular 030', '40', '6', 'salud_edad_cartera.php', '_SELF', b'1', 'diagnostico.png', '3', '2018-01-04 08:40:18', '2017-10-13 14:16:57');

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (150, 'Historial Prejuridicos', '39', '6', 'salud_cobros_prejuridicos.php', '_SELF', b'1', 'historial.png', '1', '2018-01-10 11:39:14', '2017-10-13 14:16:57');

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (151, 'Historial de pagos ingresados por tesoreria', '43', '6', 'salud_tesoreria.php', '_SELF', b'1', 'historial2.png', '1', '2018-01-10 11:39:14', '2017-10-13 14:16:57');
INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (152, 'Registrar Pago', '43', '6', 'Salud_Ingresar_Pago_Tesoreria.php', '_SELF', b'1', 'pago.png', '2', '2018-01-10 11:39:14', '2017-10-13 14:16:57');


INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (153, 'Procesos Gerenciales', '40', '6', 'salud_procesos_gerenciales.php', '_SELF', b'1', 'gestion.png', '6', '2018-01-10 11:39:14', '2017-10-13 14:16:57');

DROP TABLE IF EXISTS `inventarios_temporal`;
CREATE TABLE IF NOT EXISTS `inventarios_temporal` (
  `idProductosVenta` bigint(20) NOT NULL AUTO_INCREMENT,
  `CodigoBarras` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Referencia` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Nombre` varchar(70) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Existencias` double DEFAULT '0',
  `PrecioVenta` double DEFAULT NULL,
  `PrecioMayorista` double NOT NULL,
  `CostoUnitario` double DEFAULT NULL,
  `CostoTotal` double DEFAULT NULL,
  `CostoUnitarioPromedio` double NOT NULL,
  `CostoTotalPromedio` double NOT NULL,
  `IVA` varchar(10) COLLATE utf8_spanish_ci NOT NULL DEFAULT '0',
  `Bodega_idBodega` int(11) NOT NULL DEFAULT '1',
  `Departamento` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Sub1` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub2` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub3` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub4` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub5` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Kit` int(11) NOT NULL,
  `RutaImagen` text COLLATE utf8_spanish_ci NOT NULL,
  `Especial` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `CuentaPUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL DEFAULT '4135',
  `ValorComision1` int(11) NOT NULL,
  `ValorComision2` int(11) NOT NULL,
  `ValorComision3` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idProductosVenta`),
  UNIQUE KEY `Referencia` (`Referencia`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- tabla para visualizar los campos
--

CREATE TABLE IF NOT EXISTS `tablas_campos_control` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `NombreTabla` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `Campo` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `Visible` int(1) NOT NULL,
  `Editable` int(1) NOT NULL,
  `Habilitado` int(1) NOT NULL,
  `TipoUser` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `idUser` int(11) NOT NULL,
   `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tablas_campos_control`
--

INSERT INTO `tablas_campos_control` (`ID`, `NombreTabla`, `Campo`, `Visible`, `Editable`, `Habilitado`, `TipoUser`, `idUser`) VALUES
(1, 'usuarios', 'Password', 0, 1, 1, 'administrador', 3);

INSERT INTO `menu` (`ID`, `Nombre`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (29, 'Reservas', '1', 'MnuReservas.php', '_BLANK', '1', 'reservas.png', '22', '2017-10-13 14:16:49', '2017-10-13 14:16:49');
INSERT INTO `menu_pestanas` (`ID`, `Nombre`, `idMenu`, `Orden`, `Estado`, `Updated`, `Sync`) VALUES (44, 'Reservas', '29', '1', b'1', '2017-12-26 21:55:19', '2017-10-13 14:16:55');
INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (154, 'Reserva de Espacios', '44', '3', 'ReservaEspacios.php', '_SELF', b'1', 'reservas2.png', '1', '2018-02-19 11:38:42', '2017-10-13 14:16:57');

INSERT INTO `parametros_contables` (`ID`, `Descripcion`, `CuentaPUC`, `NombreCuenta`, `Updated`, `Sync`) VALUES (21, 'Cuenta para utilizar en operaciones donde el ingreso o la salida van a la caja general, ejemplo facturacion desde Reservas', '110505', 'CAJA GENERAL', '2017-10-13 14:28:42', '2017-10-13 14:28:42');

--
-- Table structure for table `reservas_espacios`
--

DROP TABLE IF EXISTS `reservas_espacios`;
CREATE TABLE IF NOT EXISTS `reservas_espacios` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `HoraInicial` int(11) NOT NULL,
  `HoraFinal` int(11) NOT NULL,
  `TarifaNormal` double NOT NULL,
  `TarifaMinima` double NOT NULL,
  `idProductoRelacionado` bigint(20) NOT NULL COMMENT 'Indica el producto que esta relacionado al momento de realizar una factura',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Dumping data for table `reservas_espacios`
--

INSERT INTO `reservas_espacios` (`ID`, `Nombre`, `HoraInicial`, `HoraFinal`, `TarifaNormal`, `TarifaMinima`, `idProductoRelacionado`, `Updated`, `Sync`) VALUES
(1, 'Cancha 1', 8, 23, 70000, 55000, 0, '2018-03-27 02:10:23', '0000-00-00 00:00:00'),
(2, 'Cancha 2', 8, 23, 70000, 55000, 0, '2018-03-27 02:10:23', '0000-00-00 00:00:00'),
(3, 'Cancha 3', 8, 23, 70000, 55000, 0, '2018-03-27 02:10:23', '0000-00-00 00:00:00'),
(4, 'Espacio para Fiestas', 8, 23, 70000, 55000, 0, '2018-03-27 02:10:23', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `reservas_eventos`
--

DROP TABLE IF EXISTS `reservas_eventos`;
CREATE TABLE IF NOT EXISTS `reservas_eventos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idEspacio` int(11) NOT NULL,
  `NombreEvento` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `FechaInicio` datetime NOT NULL,
  `FechaFin` datetime NOT NULL,
  `idCliente` bigint(20) NOT NULL,
  `Telefono` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `Observaciones` text COLLATE latin1_spanish_ci NOT NULL,
  `Tarifa` double NOT NULL,
  `Estado` enum('RE','FA','AN') COLLATE latin1_spanish_ci NOT NULL DEFAULT 'RE' COMMENT 'FA:Facturado,RE:Reservado,AN:Anulado',
  `idFactura` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `idUser` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `FechaInicio` (`FechaInicio`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (155, 'Subir Circular 030 inicial', '40', '6', 'salud_subir_circular_030_inicial.php', '_SELF', b'1', '030_inicial.png', '2', '2018-03-11 11:38:11', '2017-10-13 14:16:57');


CREATE TABLE IF NOT EXISTS `registro_autorizaciones_pos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` datetime NOT NULL,
  `idProducto` bigint(20) NOT NULL,
  `TablaItem` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `ValorUnitario` double NOT NULL,
  `ValorAcordado` double NOT NULL,
  `Cantidad` double NOT NULL,
  `PorcentajeIVA` double NOT NULL,
  `Total` double NOT NULL,
  `idFactura` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `idUser` bigint(20) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (156, 'Historial de Autorizaciones', '21', '3', 'registro_autorizaciones_pos.php', '_SELF', b'1', 'autorizacion.png', '4', '2017-10-13 14:16:57', '2017-10-13 14:16:57');

ALTER TABLE `facturas` CHANGE `idFacturas` `idFacturas` VARCHAR(45) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL;
ALTER TABLE `ori_facturas_items` CHANGE `idFactura` `idFactura` VARCHAR(45) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL;
ALTER TABLE `facturas_items` CHANGE `idFactura` `idFactura` VARCHAR(45) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL;

ALTER TABLE `cartera` CHANGE `Facturas_idFacturas` `Facturas_idFacturas` VARCHAR(45) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL;

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (157, 'Inventarios Selectivos', '28', '3', 'vista_diferencia_inventarios_selectivos.php', '_SELF', b'1', 'diferencias.png', '6', '2017-10-13 14:16:57', '2017-10-13 14:16:57');
UPDATE `menu_submenus` SET `Pagina` = 'vista_diferencia_inventarios.php' WHERE `menu_submenus`.`ID` = 81;
INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (158, 'Conteo Selectivo', '28', '3', 'ConteoFisicoSelectivo.php', '_SELF', b'1', 'conteo_selectivo.png', '7', '2018-04-04 17:19:47', '2017-10-13 14:16:57');

ALTER TABLE `registro_basculas` DROP `ID`;
ALTER TABLE `registro_basculas` ADD UNIQUE(`idBascula`);


--
-- Table structure for table `inventarios_conteo_selectivo`
--

CREATE TABLE IF NOT EXISTS `inventarios_conteo_selectivo` (
  `Referencia` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `Cantidad` double NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`Referencia`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

ALTER TABLE `cajas` ADD `idBascula` INT NOT NULL AFTER `idResolucionDian`;

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (159, 'Actualizacion de Precios Manual', '26', '3', 'ActualizarPreciosManual.php', '_SELF', b'1', 'pagos.png', '2', '2017-10-13 14:16:57', '2017-10-13 14:16:57');
ALTER TABLE `formatos_calidad` ADD `CuerpoFormato` TEXT NOT NULL AFTER `Fecha`;
ALTER TABLE `conceptos` ADD `TerceroCuentaCobro` ENUM('SI','NO') NOT NULL DEFAULT 'NO' AFTER `Activo`;
INSERT INTO `formatos_calidad` (`ID`, `Nombre`, `Version`, `Codigo`, `Fecha`, `CuerpoFormato`, `NotasPiePagina`, `Updated`, `Sync`) VALUES (30, 'CUENTA DE COBRO', '001', 'F-GFC-004', '2018-02-13', '', '', '2018-02-19 11:39:11', '2017-10-20 10:30:00');

CREATE TABLE IF NOT EXISTS `terceros_cuentas_cobro` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Tercero` bigint(20) NOT NULL,
  `idConceptoContable` int(11) NOT NULL COMMENT 'relacion que mostrara el concepto y movimientos contables a realizar viene de la tabla conceptos',
  `Valor` double NOT NULL,
  `idUser` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci COMMENT='Tabla para realizar cuentas de cobro por parte de terceros' AUTO_INCREMENT=9 ;


INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (160, 'Informes', '44', '3', 'ReservasInformes.php', '_SELF', b'1', 'informes.png', '2', '2018-03-21 19:23:50', '2017-10-13 14:16:57');

ALTER TABLE `facturas` CHANGE `Subtotal` `Subtotal` DOUBLE NOT NULL;
ALTER TABLE `facturas` CHANGE `IVA` `IVA` DOUBLE NOT NULL;
ALTER TABLE `facturas` CHANGE `SaldoFact` `SaldoFact` DOUBLE NOT NULL;

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (161, 'Historial de Documentos Equivalentes', '12', '3', 'vista_documentos_equivalentes.php', '_SELF', b'1', 'equivalente.png', '7', '2017-10-13 14:16:57', '2017-10-11 14:16:57');
INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (162, 'Realizar un documento equivalente', '12', '3', 'CrearDocumentoEquivalente.php', '_SELF', b'1', 'docequivalente.png', '8', '2017-10-13 14:16:57', '2017-10-11 14:16:57');

CREATE TABLE IF NOT EXISTS `documento_equivalente` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Tercero` bigint(20) NOT NULL,
  `Estado` enum('AB','CE') COLLATE latin1_spanish_ci NOT NULL DEFAULT 'AB' COMMENT 'AB abierto,CE Cerrado',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `documento_equivalente_items`
--

CREATE TABLE IF NOT EXISTS `documento_equivalente_items` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Descripcion` text COLLATE latin1_spanish_ci NOT NULL,
  `Cantidad` double NOT NULL,
  `ValorUnitario` double NOT NULL,
  `Total` double NOT NULL,
  `idDocumento` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


