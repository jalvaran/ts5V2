DROP VIEW IF EXISTS `vista_030_prueba`;
CREATE VIEW vista_030_prueba AS 
SELECT '2' as TipoRegistro, @rownum:=@rownum+1 as ConsecutivoRegistro, 
tipo_ident_prest_servicio as TipoIdentificacionERP, 
(SELECT nit FROM salud_eps WHERE salud_eps.cod_pagador_min=t1.cod_enti_administradora) as NumeroIdentificacionERP, 
(SELECT RazonSocial FROM empresapro WHERE idEmpresaPro=1) as RazonSocialIPS, 
'NI' as TipoIdentificacionIPS, 
(SELECT NIT FROM empresapro WHERE idEmpresaPro=1) as NumeroIdentificacionIPS, 
'F' as TipoCobro,num_factura,'I' as IndicadorActualizacion,valor_neto_pagar as Valor,
fecha_factura as FechaEmision,fecha_radicado as FechaPresentacion,'' as FechaDevolucion,
'0' as ValorPagado,'0' as ValorGlosaAceptada,'NO' as GlosaRespondida, 
valor_neto_pagar as SaldoFactura, 'NO' as CobroJuridico, '0' as EtapaCobroJuridico
FROM (SELECT @rownum:=0) r, salud_archivo_facturacion_mov_generados t1 
WHERE t1.tipo_negociacion='evento' AND t1.estado='RADICADO' AND fecha_radicado>='2018-01-01' AND fecha_radicado<='2018-03-31'
UNION
SELECT '2' as TipoRegistro, @rownum:=@rownum+1 as ConsecutivoRegistro, 
tipo_ident_prest_servicio as TipoIdentificacionERP, 
(SELECT nit FROM salud_eps WHERE salud_eps.cod_pagador_min=t1.cod_enti_administradora) as NumeroIdentificacionERP, 
(SELECT RazonSocial FROM empresapro WHERE idEmpresaPro=1) as RazonSocialIPS, 
'NI' as TipoIdentificacionIPS, 
(SELECT NIT FROM empresapro WHERE idEmpresaPro=1) as NumeroIdentificacionIPS, 
'F' as TipoCobro,num_factura,'I' as IndicadorActualizacion,valor_neto_pagar as Valor,
fecha_factura as FechaEmision,fecha_radicado as FechaPresentacion,'' as FechaDevolucion,
'0' as ValorPagado,'0' as ValorGlosaAceptada,'NO' as GlosaRespondida, 
valor_neto_pagar as SaldoFactura, 'SI' as CobroJuridico, EstadoCobro as EtapaCobroJuridico
FROM (SELECT @rownum:=0) r, salud_archivo_facturacion_mov_generados t1 
WHERE t1.tipo_negociacion='evento' AND t1.estado='JURIDICO' AND fecha_radicado>='2018-01-01' AND fecha_radicado<='2018-03-31'

UNION

SELECT '2' as TipoRegistro, @rownum:=@rownum+1 as ConsecutivoRegistro, 
tipo_ident_prest_servicio as TipoIdentificacionERP, 
(SELECT nit FROM salud_eps WHERE salud_eps.cod_pagador_min=t1.cod_enti_administradora) as NumeroIdentificacionERP, 
(SELECT RazonSocial FROM empresapro WHERE idEmpresaPro=1) as RazonSocialIPS, 
'NI' as TipoIdentificacionIPS, 
(SELECT NIT FROM empresapro WHERE idEmpresaPro=1) as NumeroIdentificacionIPS, 
'F' as TipoCobro,num_factura,'A' as IndicadorActualizacion,valor_neto_pagar as Valor,
fecha_factura as FechaEmision,fecha_radicado as FechaPresentacion,'' as FechaDevolucion,
'0' as ValorPagado,'0' as ValorGlosaAceptada,'NO' as GlosaRespondida, 
valor_neto_pagar as SaldoFactura, 'NO' as CobroJuridico, '0' as EtapaCobroJuridico
FROM (SELECT @rownum:=0) r, salud_archivo_facturacion_mov_generados t1 
WHERE t1.tipo_negociacion='evento' AND t1.estado='RADICADO' AND fecha_radicado<'2018-01-01'
UNION
SELECT '2' as TipoRegistro, @rownum:=@rownum+1 as ConsecutivoRegistro, 
tipo_ident_prest_servicio as TipoIdentificacionERP,  
(SELECT nit FROM salud_eps WHERE salud_eps.cod_pagador_min=t1.cod_enti_administradora) as NumeroIdentificacionERP, 
(SELECT RazonSocial FROM empresapro WHERE idEmpresaPro=1) as RazonSocialIPS, 
'NI' as TipoIdentificacionIPS, 
(SELECT NIT FROM empresapro WHERE idEmpresaPro=1) as NumeroIdentificacionIPS, 
'F' as TipoCobro,num_factura,'A' as IndicadorActualizacion,valor_neto_pagar as Valor,
fecha_factura as FechaEmision,fecha_radicado as FechaPresentacion,'' as FechaDevolucion,
'0' as ValorPagado,'0' as ValorGlosaAceptada,'NO' as GlosaRespondida, 
valor_neto_pagar as SaldoFactura, 'SI' as CobroJuridico, EstadoCobro as EtapaCobroJuridico
FROM (SELECT @rownum:=0) r, salud_archivo_facturacion_mov_generados t1 
WHERE t1.tipo_negociacion='evento' AND t1.estado='JURIDICO' AND fecha_radicado<'2018-01-01'

UNION 

SELECT '2' as TipoRegistro, @rownum:=@rownum+1 as ConsecutivoRegistro, 
tipo_ident_prest_servicio as TipoIdentificacionERP, 
(SELECT nit FROM salud_eps WHERE salud_eps.cod_pagador_min=t1.cod_enti_administradora) as NumeroIdentificacionERP, 
(SELECT RazonSocial FROM empresapro WHERE idEmpresaPro=1) as RazonSocialIPS, 
'NI' as TipoIdentificacionIPS, 
(SELECT NIT FROM empresapro WHERE idEmpresaPro=1) as NumeroIdentificacionIPS, 
'F' as TipoCobro,num_factura,'I' as IndicadorActualizacion,valor_neto_pagar as Valor,
fecha_factura as FechaEmision,fecha_radicado as FechaPresentacion,'' as FechaDevolucion,
(SELECT SUM(valor_pagado) FROM salud_archivo_facturacion_mov_pagados WHERE salud_archivo_facturacion_mov_pagados.num_factura=t1.num_factura)   as ValorPagado,
(SELECT SUM(GlosaAceptada) FROM salud_registro_glosas WHERE salud_registro_glosas.num_factura=t1.num_factura) as ValorGlosaAceptada,
(SELECT IF((SELECT SUM(GlosaAceptada) FROM salud_registro_glosas WHERE salud_registro_glosas.num_factura=t1.num_factura)>0,'SI','NO')) as GlosaRespondida, 
valor_neto_pagar as SaldoFactura, 'NO' as CobroJuridico, '0' as EtapaCobroJuridico
FROM (SELECT @rownum:=0) r, salud_archivo_facturacion_mov_generados t1 
WHERE t1.tipo_negociacion='evento' AND t1.estado='DIFERENCIA' AND fecha_radicado>='2018-01-01' AND fecha_radicado<='2018-03-31'

UNION 

SELECT '2' as TipoRegistro, @rownum:=@rownum+1 as ConsecutivoRegistro, 
tipo_ident_prest_servicio as TipoIdentificacionERP, 
(SELECT nit FROM salud_eps WHERE salud_eps.cod_pagador_min=t1.cod_enti_administradora) as NumeroIdentificacionERP, 
(SELECT RazonSocial FROM empresapro WHERE idEmpresaPro=1) as RazonSocialIPS, 
'NI' as TipoIdentificacionIPS, 
(SELECT NIT FROM empresapro WHERE idEmpresaPro=1) as NumeroIdentificacionIPS, 
'F' as TipoCobro,num_factura,'A' as IndicadorActualizacion,valor_neto_pagar as Valor,
fecha_factura as FechaEmision,fecha_radicado as FechaPresentacion,'' as FechaDevolucion,
(SELECT SUM(valor_pagado) FROM salud_archivo_facturacion_mov_pagados WHERE salud_archivo_facturacion_mov_pagados.num_factura=t1.num_factura)   as ValorPagado,
(SELECT SUM(GlosaAceptada) FROM salud_registro_glosas WHERE salud_registro_glosas.num_factura=t1.num_factura) as ValorGlosaAceptada,
(SELECT IF((SELECT SUM(GlosaAceptada) FROM salud_registro_glosas WHERE salud_registro_glosas.num_factura=t1.num_factura)>0,'SI','NO')) as GlosaRespondida, 
valor_neto_pagar as SaldoFactura, 'NO' as CobroJuridico, '0' as EtapaCobroJuridico
FROM (SELECT @rownum:=0) r, salud_archivo_facturacion_mov_generados t1 
WHERE t1.tipo_negociacion='evento' AND t1.estado='DIFERENCIA' AND fecha_radicado<'2018-01-01' 

