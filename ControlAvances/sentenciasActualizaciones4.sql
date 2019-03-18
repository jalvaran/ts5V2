DROP TABLE `salud_archivo_conceptos_glosas`, 
`salud_archivo_consultas`, `salud_archivo_consultas_temp`, `salud_archivo_facturacion_mov_generados`, 
`salud_archivo_facturacion_mov_pagados`, `salud_archivo_facturacion_mov_pagados_temp`, 
`salud_archivo_hospitalizaciones`, `salud_archivo_hospitalizaciones_temp`, `salud_archivo_medicamentos`, 
`salud_archivo_medicamentos_temp`, `salud_archivo_nacidos`, `salud_archivo_nacidos_temp`, 
`salud_archivo_otros_servicios`, `salud_archivo_otros_servicios_temp`, `salud_archivo_procedimientos`, 
`salud_archivo_procedimientos_temp`, `salud_archivo_urgencias`, `salud_archivo_usuarios`, 
`salud_archivo_usuarios_temp`, `salud_bancos`, `salud_cie10`, `salud_circular030_2`, 
`salud_circular030_3`, `salud_circular030_4`, `salud_circular030_inicial`, `salud_circular_030_control`, 
`salud_cobros_prejuridicos`, `salud_cobros_prejuridicos_relaciones`, `salud_cups`, `salud_dias_habiles`, 
`salud_eps`, `salud_facturas_radicacion_numero`, `salud_pagos_temporal`, `salud_procesos_gerenciales`, 
`salud_procesos_gerenciales_archivos`, `salud_procesos_gerenciales_conceptos`, `salud_registro_glosas`, 
`salud_rips_diferencias`, `salud_rips_facturas_generadas_temp`, `salud_rips_nopagados`;

DROP VIEW `vista_salud_facturas_diferencias`, `vista_salud_facturas_no_pagas`, `vista_salud_facturas_pagas`,
 `vista_salud_facturas_prejuridicos`, `vista_salud_pagas_no_generadas`, `vista_salud_procesos_gerenciales`, `vista_siho`;

ALTER TABLE `empresapro` ADD `DigitoVerificacion` INT(1) NOT NULL AFTER `NIT`;
ALTER TABLE `empresapro` CHANGE `NIT` `NIT` BIGINT NULL DEFAULT NULL;
ALTER TABLE `empresapro` ADD `MatriculoMercantil` BIGINT NOT NULL AFTER `Regimen`;
ALTER TABLE `empresapro` ADD `Barrio` VARCHAR(70) NOT NULL AFTER `Direccion`;
ALTER TABLE `empresapro` CHANGE `PuntoEquilibrio` `PuntoEquilibrio` BIGINT NULL DEFAULT NULL;

DROP TABLE IF EXISTS `configuraciones_nombres_campos`;
CREATE TABLE `configuraciones_nombres_campos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `NombreDB` varchar(50) NOT NULL,
  `Visualiza` varchar(50) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `menu_submenus` ADD `idMenu` INT NOT NULL AFTER `idCarpeta`, ADD `TablaAsociada` VARCHAR(45) NOT NULL AFTER `idMenu`;

ALTER TABLE `menu` ADD `CSS_Clase` VARCHAR(20) NOT NULL AFTER `Image`;

UPDATE `menu` SET `CSS_Clase`='fa fa-share';

ALTER TABLE `menu_submenus` ADD `TipoLink` INT(1) NOT NULL AFTER `TablaAsociada`, ADD `JavaScript` VARCHAR(90) NOT NULL AFTER `TipoLink`;

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `idMenu`, `TablaAsociada`, `TipoLink`, `JavaScript`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (183, 'Verificar Orden', '47', '3', '0', '', '0', '', '../modulos/compras/ReciboOrdenCompra.php', '_SELF', b'1', 'verificarOC.jpg', '5', '2018-10-18 09:56:38', '2017-10-13 14:16:57');
UPDATE menu_submenus SET Target="_BLANK";

INSERT INTO `menu_carpetas` (`ID`, `Ruta`, `Updated`, `Sync`) VALUES (7, '../modulos/', '2018-01-04 13:29:26', '2017-10-13 14:16:51');
UPDATE `menu` SET `idCarpeta` = '7' WHERE `menu`.`ID` = 1;
UPDATE `menu` SET `Pagina` = 'administrador/Admin.php' WHERE `menu`.`ID` = 1;
UPDATE `menu_submenus` SET `JavaScript` = 'onclick=\"DibujeTabla(\'empresapro\')\";' WHERE `menu_submenus`.`ID` = 1;
UPDATE `menu_submenus` SET `Target` = '_SELF' WHERE `menu_submenus`.`ID` = 1;
UPDATE `menu_submenus` SET `TipoLink` = '1' WHERE `menu_submenus`.`ID` = 1;
UPDATE `menu_submenus` SET `TablaAsociada` = 'empresapro' WHERE `menu_submenus`.`ID` = 1;


CREATE TABLE `configuraciones_nombres_campos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `NombreDB` varchar(50) NOT NULL,
  `Visualiza` varchar(50) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `configuracion_campos_asociados` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TablaOrigen` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `CampoTablaOrigen` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `TablaAsociada` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `CampoAsociado` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `IDCampoAsociado` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;



INSERT INTO `configuracion_campos_asociados` (`ID`, `TablaOrigen`, `CampoTablaOrigen`, `TablaAsociada`, `CampoAsociado`, `IDCampoAsociado`) VALUES
(1,	'empresapro',	'Ciudad',	'cod_municipios_dptos',	'Ciudad',	'Ciudad'),
(2,	'empresapro',	'Regimen',	'empresapro_regimenes',	'Regimen',	'Regimen');

CREATE TABLE `configuracion_control_tablas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TablaDB` varchar(50) NOT NULL,
  `Agregar` int(1) NOT NULL,
  `Editar` int(1) NOT NULL,
  `Ver` int(1) NOT NULL,
  `Exportar` int(1) NOT NULL,
  `AccionesAdicionales` int(1) NOT NULL,
  `Eliminar` int(1) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `configuracion_control_tablas`;
CREATE TABLE `configuracion_control_tablas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TablaDB` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `Agregar` int(1) NOT NULL,
  `Editar` int(1) NOT NULL,
  `Ver` int(1) NOT NULL,
  `LinkVer` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `Exportar` int(1) NOT NULL,
  `AccionesAdicionales` int(1) NOT NULL,
  `Eliminar` int(1) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `configuracion_control_tablas` (`ID`, `TablaDB`, `Agregar`, `Editar`, `Ver`, `LinkVer`, `Exportar`, `AccionesAdicionales`, `Eliminar`, `Updated`, `Sync`) VALUES
(1,	'empresapro',	1,	1,	0,	'',	1,	0,	0,	'2018-12-13 15:18:46',	'2018-12-12 09:05:19'),
(2,	'formatos_calidad',	1,	1,	0,	'',	1,	0,	0,	'2018-12-13 15:18:50',	'2018-12-12 09:05:19'),
(3,	'facturas',	0,	0,	1,	'PDF_Documentos.draw.php?idDocumento=2&ID=',	1,	1,	0,	'2018-12-13 16:53:17',	'2018-12-12 09:05:19');


CREATE TABLE `configuracion_tablas_acciones_adicionales` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TablaDB` varchar(50) NOT NULL,
  `JavaScript` varchar(100) NOT NULL,
  `CSS_Clase` varchar(20) NOT NULL,
  `Titulo` varchar(20) NOT NULL,
  `Ruta` varchar(100) NOT NULL,
  `ColumnaID` varchar(45) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `empresapro_regimenes` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Regimen` varchar(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `empresapro_regimenes` (`ID`, `Regimen`, `Updated`, `Sync`) VALUES
(1,	'COMUN',	'2018-10-08 04:03:47',	'0000-00-00 00:00:00'),
(2,	'SIMPLIFICADO',	'2018-10-08 04:03:47',	'0000-00-00 00:00:00');


UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'empresa_pro_sucursales\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'empresa_pro_sucursales' WHERE `menu_submenus`.`ID` = 2;

UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'empresapro_resoluciones_facturacion\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'empresapro_resoluciones_facturacion' WHERE `menu_submenus`.`ID` = 3;

UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'formatos_calidad\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'formatos_calidad' WHERE `menu_submenus`.`ID` = 4;



UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'centrocosto\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'centrocosto' WHERE `menu_submenus`.`ID` = 5;

UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'cajas\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'cajas' WHERE `menu_submenus`.`ID` = 6;


UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'config_tiketes_promocion\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'config_tiketes_promocion' WHERE `menu_submenus`.`ID` = 7;


UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'costos\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'costos' WHERE `menu_submenus`.`ID` = 8;


UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'usuarios\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'usuarios' WHERE `menu_submenus`.`ID` = 9;


UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'usuarios_tipo\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'usuarios_tipo' WHERE `menu_submenus`.`ID` = 10;


UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'impret\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'impret' WHERE `menu_submenus`.`ID` = 12;


UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'colaboradores\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'colaboradores' WHERE `menu_submenus`.`ID` = 13;


UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'fechas_descuentos\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'fechas_descuentos' WHERE `menu_submenus`.`ID` = 14;

UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'librodiario\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'librodiario' WHERE `menu_submenus`.`ID` = 15;

UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'facturas\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'facturas' WHERE `menu_submenus`.`ID` = 16;

UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'subcuentas\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'subcuentas' WHERE `menu_submenus`.`ID` = 17;


UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'cuentasfrecuentes\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'cuentasfrecuentes' WHERE `menu_submenus`.`ID` = 18;



UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'config_puertos\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'config_puertos' WHERE `menu_submenus`.`ID` = 20;



UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'cajas_aperturas_cierres\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'cajas_aperturas_cierres' WHERE `menu_submenus`.`ID` = 22;



UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'separados\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'separados' WHERE `menu_submenus`.`ID` = 23;




UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'facturas_abonos\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'facturas_abonos' WHERE `menu_submenus`.`ID` = 24;



UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'prod_codbarras\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'prod_codbarras' WHERE `menu_submenus`.`ID` = 25;


UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'cotizacionesv5\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'cotizacionesv5' WHERE `menu_submenus`.`ID` = 27;


UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'cot_itemscotizaciones\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'cot_itemscotizaciones' WHERE `menu_submenus`.`ID` = 28;

UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'cotizaciones_anexos\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'cotizaciones_anexos' WHERE `menu_submenus`.`ID` = 29;

UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'facturas\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'facturas' WHERE `menu_submenus`.`ID` = 32;

UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'vista_facturacion_detalles\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'vista_facturacion_detalles' WHERE `menu_submenus`.`ID` = 33;

UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'notascredito\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'notascredito' WHERE `menu_submenus`.`ID` = 34;

UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'factura_compra\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'factura_compra' WHERE `menu_submenus`.`ID` = 36;

UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'vista_compras_productos\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'vista_compras_productos' WHERE `menu_submenus`.`ID` = 37;

UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'vista_compras_productos_devoluciones\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'vista_compras_productos_devoluciones' WHERE `menu_submenus`.`ID` = 38;

UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'vista_compras_servicios\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'vista_compras_servicios' WHERE `menu_submenus`.`ID` = 39;

UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'egresos\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'egresos' WHERE `menu_submenus`.`ID` = 41;


UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'notascontables\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'notascontables' WHERE `menu_submenus`.`ID` = 42;


UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'compras_activas\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'compras_activas' WHERE `menu_submenus`.`ID` = 44;


UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'registra_ediciones\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'registra_ediciones' WHERE `menu_submenus`.`ID` = 54;



UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'productosalquiler\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'productosalquiler' WHERE `menu_submenus`.`ID` = 56;



UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'servicios\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'servicios' WHERE `menu_submenus`.`ID` = 57;



UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'vista_kardex\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'vista_kardex' WHERE `menu_submenus`.`ID` = 59;



UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'prod_codbarras\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'prod_codbarras' WHERE `menu_submenus`.`ID` = 61;


UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'prod_departamentos\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'prod_departamentos' WHERE `menu_submenus`.`ID` = 63;


UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'prod_sub1\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'prod_sub1' WHERE `menu_submenus`.`ID` = 64;


UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'prod_sub2\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'prod_sub2' WHERE `menu_submenus`.`ID` = 65;

UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'prod_sub3\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'prod_sub3' WHERE `menu_submenus`.`ID` = 66;

UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'prod_sub4\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'prod_sub4' WHERE `menu_submenus`.`ID` = 67;

UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'prod_sub5\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'prod_sub5' WHERE `menu_submenus`.`ID` = 68;

UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'bodega\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'bodega' WHERE `menu_submenus`.`ID` = 69;

UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'bodegas_externas\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'bodegas_externas' WHERE `menu_submenus`.`ID` = 70;

UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'prod_bajas_altas\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'prod_bajas_altas' WHERE `menu_submenus`.`ID` = 71;

UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'vista_sistemas\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'vista_sistemas' WHERE `menu_submenus`.`ID` = 74;

UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'inventarios_temporal\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'inventarios_temporal' WHERE `menu_submenus`.`ID` = 78;

UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'vista_diferencia_inventarios\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'vista_diferencia_inventarios' WHERE `menu_submenus`.`ID` = 81;

UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'restaurante_mesas\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'restaurante_mesas' WHERE `menu_submenus`.`ID` = 86;

UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'titulos_promociones\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'titulos_promociones' WHERE `menu_submenus`.`ID` = 87;

UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'titulos_asignaciones\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'titulos_asignaciones' WHERE `menu_submenus`.`ID` = 89;

UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'titulos_ventas\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'titulos_ventas' WHERE `menu_submenus`.`ID` = 91;

UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'titulos_abonos\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'titulos_abonos' WHERE `menu_submenus`.`ID` = 92;

UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'titulos_devoluciones\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'titulos_devoluciones' WHERE `menu_submenus`.`ID` = 93;

UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'titulos_cuentasxcobrar\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'titulos_cuentasxcobrar' WHERE `menu_submenus`.`ID` = 94;

UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'titulos_comisiones\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'titulos_comisiones' WHERE `menu_submenus`.`ID` = 95;

UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'titulos_traslados\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'titulos_traslados' WHERE `menu_submenus`.`ID` = 96;

UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'comprobantes_ingreso_anulaciones\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'comprobantes_ingreso_anulaciones' WHERE `menu_submenus`.`ID` = 97;

UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'traslados_mercancia\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'traslados_mercancia' WHERE `menu_submenus`.`ID` = 99;


UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'kardex_alquiler\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'kardex_alquiler' WHERE `menu_submenus`.`ID` = 106;

UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'restaurante_cierres\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'restaurante_cierres' WHERE `menu_submenus`.`ID` = 107;

UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'restaurante_pedidos\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'restaurante_pedidos' WHERE `menu_submenus`.`ID` = 108;


UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'registra_eliminaciones\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'registra_eliminaciones' WHERE `menu_submenus`.`ID` = 109;


UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'traslados_items\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'traslados_items' WHERE `menu_submenus`.`ID` = 111;


UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'sistemas\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'sistemas' WHERE `menu_submenus`.`ID` = 112;


UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'vista_inventario_separados\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'vista_inventario_separados' WHERE `menu_submenus`.`ID` = 113;


UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'productos_lista_precios\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'productos_lista_precios' WHERE `menu_submenus`.`ID` = 122;


UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'productos_precios_adicionales\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'productos_precios_adicionales' WHERE `menu_submenus`.`ID` = 123;


UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'libromayorbalances\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'libromayorbalances' WHERE `menu_submenus`.`ID` = 139;


UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'vista_factura_compra_totales\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'vista_factura_compra_totales' WHERE `menu_submenus`.`ID` = 147;


UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'registro_autorizaciones_pos\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'registro_autorizaciones_pos' WHERE `menu_submenus`.`ID` = 156;


UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'vista_diferencia_inventarios_selectivos\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'vista_diferencia_inventarios_selectivos' WHERE `menu_submenus`.`ID` = 157;


UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'documento_equivalente_items\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'documento_equivalente_items' WHERE `menu_submenus`.`ID` = 161;

UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'modelos_db\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'modelos_db' WHERE `menu_submenus`.`ID` = 163;

UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'modelos_agenda\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'modelos_agenda' WHERE `menu_submenus`.`ID` = 165;

UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'vista_totales_facturacion\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'vista_totales_facturacion' WHERE `menu_submenus`.`ID` = 167;

UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'modelos_cierres\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'modelos_cierres' WHERE `menu_submenus`.`ID` = 168;

UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'factura_compra_notas_devolucion\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'factura_compra_notas_devolucion' WHERE `menu_submenus`.`ID` = 170;


UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'vista_libro_diario\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'vista_libro_diario' WHERE `menu_submenus`.`ID` = 171;


UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'documentos_contables_control\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'documentos_contables_control' WHERE `menu_submenus`.`ID` = 174;


UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'restaurante_pedidos_items\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'restaurante_pedidos_items' WHERE `menu_submenus`.`ID` = 175;

UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'insumos\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'insumos' WHERE `menu_submenus`.`ID` = 177;

UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'prod_sub6\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'prod_sub6' WHERE `menu_submenus`.`ID` = 178;

UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'ordenesdecompra\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'ordenesdecompra' WHERE `menu_submenus`.`ID` = 180;

UPDATE `menu_submenus` 
SET `JavaScript` = 'onclick=\"DibujeTabla(\'nomina_documentos_equivalentes\')\";',`Target` = '_SELF',`TipoLink` = '1',
`TablaAsociada` = 'nomina_documentos_equivalentes' WHERE `menu_submenus`.`ID` = 181;


UPDATE menu_submenus SET JavaScript = REPLACE ( JavaScript, 'DibujeTabla', 'SeleccioneTablaDB' );
ALTER TABLE `usuarios` ADD `Habilitado` VARCHAR(2) NOT NULL DEFAULT 'SI' AFTER `Role`;


DROP TABLE IF EXISTS `configuracion_tablas_acciones_adicionales`;
CREATE TABLE `configuracion_tablas_acciones_adicionales` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TablaDB` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `JavaScript` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `ClaseIcono` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Titulo` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Ruta` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Target` varchar(6) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `configuracion_tablas_acciones_adicionales` (`ID`, `TablaDB`, `JavaScript`, `ClaseIcono`, `Titulo`, `Ruta`, `Target`, `Updated`, `Sync`) VALUES
(1,	'facturas',	'',	'fa fa-fw fa-copy',	'Copia',	'../../general/Consultas/PDF_Documentos.draw.php?TipoFactura=COPIA&idDocumento=2&ID=	',	'_BLANK',	'2018-12-13 16:59:41',	'0000-00-00 00:00:00'),
(2,	'facturas',	'',	'fa fa-fw fa-book',	'Contabilidad',	'../../general/Consultas/PDF_Documentos.draw.php?TipoFactura=CONTABILIDAD&idDocumento=2&ID=	',	'_BLANK',	'2018-12-13 17:15:35',	'0000-00-00 00:00:00'),
(3,	'facturas',	'',	'fa fa-fw fa-close',	'Anular',	'../../VAtencion/AnularFactura.php?idFactura=',	'_BLANK',	'2018-12-13 17:15:35',	'0000-00-00 00:00:00');

DROP TABLE IF EXISTS `fe_webservice`;
CREATE TABLE `fe_webservice` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `DireccionWebService` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `User` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Pass` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

ALTER TABLE `empresapro` ADD `TipoPersona` ENUM("1","2","3") NOT NULL COMMENT '1 Persona jurica, 2 persona natural,3 grandes contribuyentes' AFTER `Regimen`, ADD `TipoDocumento` INT NOT NULL AFTER `TipoPersona`;

ALTER TABLE `empresapro` ADD `ActividadesEconomicas` TEXT NOT NULL AFTER `MatriculoMercantil`;

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `idMenu`, `TablaAsociada`, `TipoLink`, `JavaScript`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (184, 'Reportes', '16', '3', '0', '', '0', '', '../modulos/contabilidad/ReportesContabilidad.php', '_BLANK', '1', 'reportes.jpg', '4', '2018-12-19 11:51:07', '2018-12-19 11:51:07');

INSERT INTO `configuracion_control_tablas` (`ID`, `TablaDB`, `Agregar`, `Editar`, `Ver`, `LinkVer`, `Exportar`, `AccionesAdicionales`, `Eliminar`, `Updated`, `Sync`) VALUES (6, 'empresapro_resoluciones_facturacion', '1', '1', '0', '', '1', '0', '0', '2018-12-19 11:29:55', '2018-12-19 11:29:55');
ALTER TABLE `empresapro_resoluciones_facturacion` CHANGE `Fecha` `Fecha` DATE NOT NULL;
ALTER TABLE `empresapro_resoluciones_facturacion` CHANGE `FechaVencimiento` `FechaVencimiento` DATE NOT NULL;

ALTER TABLE `porcentajes_iva` ADD `ClaseImpuesto` VARCHAR(2) NOT NULL DEFAULT '01' COMMENT '01 para IVA, 02 impoconsumo, 03 ICA' AFTER `Valor`;
ALTER TABLE `facturas` ADD `ReporteFacturaElectronica` INT(1) NOT NULL COMMENT 'indica si ya fue reportada como factura electronica' AFTER `idTarjetas`;
ALTER TABLE `ori_facturas` ADD `ReporteFacturaElectronica` INT(1) NOT NULL COMMENT 'indica si ya fue reportada como factura electronica' AFTER `idTarjetas`;
UPDATE `facturas` SET `ReporteFacturaElectronica`=1;
ALTER TABLE `facturas` ADD INDEX(`ReporteFacturaElectronica`);

INSERT INTO `parametros_contables` (`ID`, `Descripcion`, `CuentaPUC`, `NombreCuenta`, `Updated`, `Sync`) VALUES ('24', 'Retefuente por compra de productos', '236540', 'Retencion en la fuente por compras', CURRENT_TIMESTAMP, '0000-00-00 00:00:00.000000');
INSERT INTO `parametros_contables` (`ID`, `Descripcion`, `CuentaPUC`, `NombreCuenta`, `Updated`, `Sync`) VALUES ('25', 'ReteICA por compra de productos', '236801', 'Retencion de industria y comercio', CURRENT_TIMESTAMP, '0000-00-00 00:00:00.000000');
INSERT INTO `parametros_contables` (`ID`, `Descripcion`, `CuentaPUC`, `NombreCuenta`, `Updated`, `Sync`) VALUES ('26', 'ReteIVA en Compras', '236701', 'ReteIVA', CURRENT_TIMESTAMP, '0000-00-00 00:00:00.000000');
INSERT INTO `parametros_contables` (`ID`, `Descripcion`, `CuentaPUC`, `NombreCuenta`, `Updated`, `Sync`) VALUES ('27', 'Retefuente por compra de servicios', '236525', 'Retencion en la fuente por servicios', CURRENT_TIMESTAMP, '0000-00-00 00:00:00.000000');
INSERT INTO `parametros_contables` (`ID`, `Descripcion`, `CuentaPUC`, `NombreCuenta`, `Updated`, `Sync`) VALUES ('28', 'Descuentos Comerciales en compras', '421040', 'Descuentos comerciales condicionados', CURRENT_TIMESTAMP, '0000-00-00 00:00:00.000000');
INSERT INTO `parametros_contables` (`ID`, `Descripcion`, `CuentaPUC`, `NombreCuenta`, `Updated`, `Sync`) VALUES ('29', 'Impuestos asumidos, aplica para el impoconsumo cuando no se puede descontar', '531520', 'Impuestos Asumidos', CURRENT_TIMESTAMP, '0000-00-00 00:00:00.000000');

ALTER TABLE `factura_compra_descuentos` ADD `PorcentajeDescuento` DOUBLE NOT NULL AFTER `ValorDescuento`;

CREATE TABLE `factura_compra_impuestos_adicionales` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idCompra` bigint(20) NOT NULL,
  `CuentaPUC` bigint(20) NOT NULL,
  `NombreCuenta` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Valor` double NOT NULL,
  `Porcentaje` double NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

ALTER TABLE `factura_compra` ADD `idEmpresa` INT NOT NULL DEFAULT '1' AFTER `idUsuario`;

INSERT INTO `formatos_calidad` (`ID`, `Nombre`, `Version`, `Codigo`, `Fecha`, `CuerpoFormato`, `NotasPiePagina`, `Updated`, `Sync`) VALUES (34, 'CERTIFICADO DE RETENCIONES', '001', 'F-GC-006', '2018-05-15', '', '', '2019-01-13 09:11:00', '2019-01-13 09:11:00');

ALTER TABLE `factura_compra` ADD `TipoPago` VARCHAR(10) NOT NULL AFTER `TipoCompra`;
ALTER TABLE `factura_compra` ADD `idCierre` BIGINT NOT NULL AFTER `idSucursal`;

ALTER TABLE `modelos_agenda` ADD `idCierreModelo` BIGINT NOT NULL AFTER `HoraATerminar`;

UPDATE `formatos_calidad` SET `NotasPiePagina` = 'Forma Continua Impresa por Computador no necesita Firma Autografa (Art. 10 D.R. 836/91, recopilado Art. 1.6.1.12.12 del DUT 1625 de 2016-10-11, que regula el contenido del certificado de renta.' WHERE `formatos_calidad`.`ID` = 34;

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `idMenu`, `TablaAsociada`, `TipoLink`, `JavaScript`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (185, 'Reporte de compras vs ventas', '16', '3', '0', '', '0', '', '../modulos/reportes/ReportesComparativos.php', '_BLANK', '1', 'infventas.png', '5', '2019-01-13 09:12:44', '2019-01-13 09:12:44');

