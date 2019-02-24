ALTER TABLE `cotizacionesv5` CHANGE `Fecha` `Fecha` DATE NOT NULL;
ALTER TABLE `cotizacionesv5` ADD `Estado` VARCHAR(25) NOT NULL AFTER `Seguimiento`;
ALTER TABLE `cotizacionesv5` ADD INDEX(`Estado`);

INSERT INTO `menu_pestanas` (`ID`, `Nombre`, `idMenu`, `Orden`, `Estado`, `Updated`, `Sync`) VALUES (49, 'Ingresos', '23', '1', b'1', '2019-01-13 09:12:43', '2019-01-13 09:12:43');
INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `idMenu`, `TablaAsociada`, `TipoLink`, `JavaScript`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (186, 'Historial Comprobantes Ingreso', '49', '3', '0', 'comprobantes_ingreso', '1', 'onclick=\"SeleccioneTablaDB(`comprobantes_ingreso`)\";', 'comprobantes_ingreso.php', '_SELF', '1', 'historial3.png', '1', '2019-01-13 09:12:44', '2019-01-13 09:12:44');

INSERT INTO `configuracion_control_tablas` (`ID`, `TablaDB`, `Agregar`, `Editar`, `Ver`, `LinkVer`, `Exportar`, `AccionesAdicionales`, `Eliminar`, `Updated`, `Sync`) VALUES (7, 'comprobantes_ingreso', '0', '0', '1', 'PDF_Documentos.php?idDocumento=4&idIngreso=', '1', '1', '0', '2019-01-13 09:04:48', '2019-01-13 09:04:48');
INSERT INTO `configuracion_campos_asociados` (`ID`, `TablaOrigen`, `CampoTablaOrigen`, `TablaAsociada`, `CampoAsociado`, `IDCampoAsociado`, `Updated`, `Sync`) VALUES (3, 'comprobantes_ingreso', 'Clientes_idClientes', 'clientes', 'idClientes', 'Num_Identificacion', '2019-01-13 09:04:47', '2019-01-13 09:04:47');

