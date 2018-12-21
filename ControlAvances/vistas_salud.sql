--
-- 1.  Vista para ver las facturas pagas
--
DROP VIEW IF EXISTS `vista_salud_facturas_pagas`;
CREATE VIEW vista_salud_facturas_pagas AS 
SELECT t1.`id_fac_mov_generados` as id_factura_generada,t1.`cod_prest_servicio`,t1.`razon_social`,t1.`num_factura`,t1.`fecha_factura`,
t1.`cod_enti_administradora`,t1.`nom_enti_administradora`,t1.`valor_neto_pagar`,t2.`id_pagados` as id_factura_pagada,t2.`fecha_pago_factura`,t2.`valor_pagado`,t2.`num_pago` ,t1.`tipo_negociacion`,
t1.`dias_pactados`,t1.`fecha_radicado`,t1.`numero_radicado`,t1.`Soporte` 
FROM salud_archivo_facturacion_mov_generados t1 INNER JOIN salud_archivo_facturacion_mov_pagados t2 ON t1.`num_factura`=t2.`num_factura`
WHERE t1.estado='PAGADA';
--
-- 2. Vista para seleccionar lo que se pagó pero no fue generado
--
DROP VIEW IF EXISTS `vista_salud_facturas_no_pagas`;
CREATE VIEW vista_salud_facturas_no_pagas AS 
SELECT t1.`id_fac_mov_generados` as id_factura_generada, 
(SELECT DATEDIFF(now(),t1.`fecha_radicado` ) - t1.`dias_pactados`) as DiasMora ,t1.`cod_prest_servicio`,t1.`razon_social`,t1.`num_factura`,
t1.`fecha_factura`, t1.`fecha_radicado`,t1.`numero_radicado`,t1.`cod_enti_administradora`,t1.`nom_enti_administradora`,t1.`valor_neto_pagar` ,t1.`tipo_negociacion`, 
t1.`dias_pactados`,t1.`Soporte`,t1.`EstadoCobro`
FROM salud_archivo_facturacion_mov_generados t1 WHERE t1.tipo_negociacion='evento' AND (t1.estado='RADICADO' OR t1.estado=''); 
--
-- 3. Vista para ver las facturas con diferencias
--
DROP VIEW IF EXISTS `vista_salud_facturas_diferencias`;
CREATE VIEW vista_salud_facturas_diferencias AS 
SELECT t1.`id_fac_mov_generados` as id_factura_generada,t1.`cod_prest_servicio`,t1.`razon_social`,t1.`num_factura`,t1.`fecha_factura`,
t1.`cod_enti_administradora`,t1.`nom_enti_administradora`,t1.`valor_neto_pagar`,t2.`id_pagados` as id_factura_pagada,t2.`fecha_pago_factura`,t2.`valor_pagado`,t2.`num_pago` ,
(SELECT t1.`valor_neto_pagar`-t2.`valor_pagado`) as DiferenciaEnPago ,t1.`tipo_negociacion`,
t1.`dias_pactados`,t1.`fecha_radicado`,t1.`numero_radicado`,t1.`Soporte` 
FROM salud_archivo_facturacion_mov_generados t1 INNER JOIN salud_archivo_facturacion_mov_pagados t2 ON t1.`num_factura`=t2.`num_factura`
WHERE t1.estado='DIFERENCIA' AND t1.tipo_negociacion='evento';

--
-- 4. Vista para seleccionar lo que se pagó pero no fue generado
--
DROP VIEW IF EXISTS `vista_salud_pagas_no_generadas`;
CREATE VIEW vista_salud_pagas_no_generadas AS 
Select T1.* From salud_archivo_facturacion_mov_pagados T1 
Left Outer Join salud_archivo_facturacion_mov_generados T2 ON T1.num_factura = T2.num_factura 
where T2.num_factura is null ;
--
-- 5. Vista para ver los cobros prejuridicos
--

DROP VIEW IF EXISTS `vista_salud_facturas_prejuridicos`;
CREATE VIEW vista_salud_facturas_prejuridicos AS 
SELECT t2.`id_fac_mov_generados` as ID,t1.idCobroPrejuridico,t2.`num_factura`,`cod_prest_servicio`,`razon_social`,`num_ident_prest_servicio`,`fecha_factura`,`cod_enti_administradora`,`nom_enti_administradora`,`valor_neto_pagar`,`tipo_negociacion`,`fecha_radicado`,`numero_radicado`,`Soporte` as SoporteRadicado,(SELECT Soporte FROM salud_cobros_prejuridicos WHERE ID=t1.idCobroPrejuridico) AS SoporteCobro,`estado` as EstadoFactura,`EstadoCobro` FROM `salud_cobros_prejuridicos_relaciones` t1 
INNER JOIN salud_archivo_facturacion_mov_generados t2 ON t1.`num_factura`=t2.`num_factura`
WHERE t2.EstadoCobro='PREJURIDICO1' OR t2.EstadoCobro='PREJURIDICO2';

--
-- 6. Vista para los procesos gerenciales
--
DROP VIEW IF EXISTS `vista_salud_procesos_gerenciales`;
CREATE VIEW vista_salud_procesos_gerenciales AS 
SELECT t1.`ID` as ID,t1.`idProceso` as idProceso,t1.`Fecha` as Fecha,
(SELECT nombre_completo FROM salud_eps WHERE cod_pagador_min=t2.EPS) as EPS,
t2.`NombreProceso`,t2.`Concepto`,t1.`Observaciones`,t1.`Soporte`
FROM `salud_procesos_gerenciales_archivos` t1 
INNER JOIN salud_procesos_gerenciales t2 ON t1.`idProceso`=t2.`ID`;

DROP VIEW IF EXISTS `vista_af`;
CREATE VIEW vista_af AS
SELECT *,(SELECT Genera030 FROM salud_eps WHERE salud_eps.cod_pagador_min=`salud_archivo_facturacion_mov_generados`. cod_enti_administradora) as GeneraCircular FROM `salud_archivo_facturacion_mov_generados` ;


DROP VIEW IF EXISTS `vista_SIHO`;
CREATE VIEW vista_SIHO AS 
SELECT t1.`id_fac_mov_generados` as id_factura_generada, (SELECT dias_convenio FROM salud_eps WHERE salud_eps.cod_pagador_min=t1.cod_enti_administradora) as diasPago,
(SELECT DATEDIFF('2018-05-02',t1.`fecha_radicado` ) - (SELECT(diasPago))) as DiasMora ,t1.`cod_prest_servicio`,t1.`razon_social`,t1.`num_factura`,
t1.`fecha_factura`, t1.`fecha_radicado`,t1.`numero_radicado`,t1.`cod_enti_administradora`,t1.`nom_enti_administradora`,t1.`valor_neto_pagar` ,t1.`tipo_negociacion`, 
 t1.estado
FROM salud_archivo_facturacion_mov_generados t1 WHERE (t1.estado != 'PAGADA' AND t1.estado != 'DEVUELTA'  AND t1.estado != ''); 


DROP VIEW IF EXISTS `vista_af_duplicados`;
CREATE VIEW vista_af_duplicados AS 
SELECT t2.`id_fac_mov_generados` as ID,t1.`num_factura`,t1.`fecha_factura`,t1.`LineaArchivo`,t2.CuentaGlobal, t2.CuentaRIPS,
t2.EstadoGlosa,t2.fecha_cargue FROM `salud_rips_facturas_generadas_temp` t1 
INNER JOIN salud_archivo_facturacion_mov_generados t2 ON t1.`num_factura`=t2.`num_factura` 
WHERE t2.`EstadoGlosa`<>9;


