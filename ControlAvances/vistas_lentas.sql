--Hecha para alturas
DROP VIEW IF EXISTS `vista_libro_diario`;
CREATE VIEW vista_libro_diario AS
SELECT `idLibroDiario`,`Fecha`,`Tipo_Documento_Intero`,(select if((`librodiario`.`Tipo_Documento_Intero` = 'FACTURA'),(select `facturas`.`NumeroFactura` from `facturas` where (`facturas`.`idFacturas` = `librodiario`.`Num_Documento_Interno`)), `librodiario`.`Num_Documento_Interno`)) AS `NumDocumento`,`Num_Documento_Externo`,`Tercero_Tipo_Documento`,
`Tercero_Identificacion`,`Tercero_DV`,`Tercero_Primer_Apellido`,
`Tercero_Segundo_Apellido`,`Tercero_Primer_Nombre`,`Tercero_Otros_Nombres`,
`Tercero_Razon_Social`,`Tercero_Direccion`,`Tercero_Cod_Dpto`,`Tercero_Cod_Mcipio`,`Tercero_Pais_Domicilio`,
`Concepto`,`CuentaPUC`,`NombreCuenta`,`Detalle`,sum(`Debito`) as Debito,sum(`Credito`) as Credito,sum(`Neto`) as Neto,`idCentroCosto`,
`idEmpresa`,`idSucursal`,`Estado`,`idUsuario` FROM `librodiario` GROUP BY CuentaPUC,`Tipo_Documento_Intero`,`Num_Documento_Interno` ORDER BY `idLibroDiario`;


DROP VIEW IF EXISTS `vista_facturacion_detalles`;
CREATE VIEW vista_facturacion_detalles AS
SELECT `ID`,`FechaFactura`,
(SELECT NumeroFactura FROM facturas WHERE idFacturas=`idFactura`) as NumeroFactura,
(SELECT FormaPago FROM facturas WHERE idFacturas=`idFactura`) as TipoFactura, 
`TablaItems`,`Referencia`,`Nombre`,
(SELECT Nombre FROM prod_departamentos WHERE prod_departamentos.idDepartamentos=facturas_items.Departamento) AS Departamento,
(SELECT NombreSub1 FROM prod_sub1 WHERE prod_sub1.idSub1=facturas_items.SubGrupo1 ) as SubGrupo1,
(SELECT NombreSub2 FROM prod_sub2 WHERE prod_sub2.idSub2=facturas_items.SubGrupo2 ) as SubGrupo2,
(SELECT NombreSub3 FROM prod_sub3 WHERE prod_sub3.idSub3=facturas_items.SubGrupo3 ) as SubGrupo3,
(SELECT NombreSub4 FROM prod_sub4 WHERE prod_sub4.idSub4=facturas_items.SubGrupo4 ) as SubGrupo4,
(SELECT NombreSub5 FROM prod_sub5 WHERE prod_sub5.idSub5=facturas_items.SubGrupo5 ) as SubGrupo5,
`ValorUnitarioItem`,`Cantidad`,`SubtotalItem`,`IVAItem`,`TotalItem`,
`PorcentajeIVA`,`PrecioCostoUnitario`,`SubtotalCosto`,CuentaPUC,idUsuarios,idCierre,
(SELECT ObservacionesFact FROM facturas WHERE idFacturas=`idFactura`) as Observaciones 
FROM `facturas_items` ;



