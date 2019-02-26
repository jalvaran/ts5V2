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


