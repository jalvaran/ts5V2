--Hecha para alturas
DROP VIEW IF EXISTS `vista_libro_diario`;
CREATE VIEW vista_libro_diario AS
SELECT `idLibroDiario`,`Fecha`,`Tipo_Documento_Intero`,(select if((`librodiario`.`Tipo_Documento_Intero` = 'FACTURA'),(select `facturas`.`NumeroFactura` from `facturas` where (`facturas`.`idFacturas` = `librodiario`.`Num_Documento_Interno`)), `librodiario`.`Num_Documento_Interno`)) AS `NumDocumento`,`Num_Documento_Externo`,`Tercero_Tipo_Documento`,
`Tercero_Identificacion`,`Tercero_DV`,`Tercero_Primer_Apellido`,
`Tercero_Segundo_Apellido`,`Tercero_Primer_Nombre`,`Tercero_Otros_Nombres`,
`Tercero_Razon_Social`,`Tercero_Direccion`,`Tercero_Cod_Dpto`,`Tercero_Cod_Mcipio`,`Tercero_Pais_Domicilio`,
`Concepto`,`CuentaPUC`,`NombreCuenta`,`Detalle`,sum(`Debito`) as Debito,sum(`Credito`) as Credito,sum(`Neto`) as Neto,`idCentroCosto`,
`idEmpresa`,`idSucursal`,`Estado`,`idUsuario` FROM `librodiario` GROUP BY CuentaPUC,`Tipo_Documento_Intero`,`Num_Documento_Interno` ORDER BY `idLibroDiario`;


