
ALTER TABLE `salud_eps` ADD `saldo_inicial` DOUBLE NOT NULL AFTER `Nombre_gerente`;
ALTER TABLE `salud_eps` ADD `fecha_saldo_inicial` DATE NOT NULL AFTER `saldo_inicial`;

DROP TABLE IF EXISTS `salud_tesoreria`;
CREATE TABLE IF NOT EXISTS `salud_tesoreria` (
  `ID` bigint(20) NOT NULL,
  `cod_enti_administradora` varchar(6) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Código entidad que paga',
  `nom_enti_administradora` varchar(30) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre entidad que paga',
  `fecha_transaccion` date NOT NULL COMMENT 'fecha entra el dinero al banco',
  `num_transaccion` varchar(45) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Numero de la transaccion con la cual entra al banco',
  `banco_transaccion` varchar(10) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre del banco donde entra la transaccion',
  `num_cuenta_banco` varchar(30) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Numero de cuenta en la cual entra la transaccion',
  `valor_transaccion` double(15,2) NOT NULL COMMENT 'Valor de transaccion ',
  `Soporte` varchar(200) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Soporte que argumenta  o justifica el pago',
  `observacion` text COLLATE utf8_spanish_ci COMMENT 'observaciones de diagnostico ',
  `fecha_hora_registro` datetime DEFAULT NULL COMMENT 'fecha y hora del registro',
  `idUser` int(11) DEFAULT NULL COMMENT 'usuario que registra',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Archivo de tesoreria';

ALTER TABLE `salud_tesoreria` CHANGE `ID` `ID` BIGINT(20) NOT NULL AUTO_INCREMENT;

ALTER TABLE `salud_bancos` CHANGE `ID` `ID` BIGINT NOT NULL AUTO_INCREMENT;

ALTER TABLE `salud_archivo_facturacion_mov_generados` CHANGE `Soporte` `Soporte` VARCHAR(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL COMMENT 'Ruta de Archivo de comprobación de radicado';


--
-- Table structure for table `salud_procesos_gerenciales`
--

CREATE TABLE IF NOT EXISTS `salud_procesos_gerenciales` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `EPS` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `NombreProceso` text COLLATE latin1_spanish_ci NOT NULL,
  `Concepto` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `idUser` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `salud_procesos_gerenciales_archivos`
--

CREATE TABLE IF NOT EXISTS `salud_procesos_gerenciales_archivos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idProceso` int(11) NOT NULL,
  `Fecha` date NOT NULL,
  `Observaciones` text COLLATE latin1_spanish_ci NOT NULL,
  `Soporte` varchar(200) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `salud_procesos_gerenciales_conceptos`
--

CREATE TABLE IF NOT EXISTS `salud_procesos_gerenciales_conceptos` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Concepto` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `Observaciones` text COLLATE latin1_spanish_ci NOT NULL,
  `idUser` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=10 ;

--
-- Dumping data for table `salud_procesos_gerenciales_conceptos`
--

INSERT INTO `salud_procesos_gerenciales_conceptos` (`ID`, `Concepto`, `Observaciones`, `idUser`) VALUES
(1, 'MINSALUD', '', 3),
(2, 'SUPERSALUD', '', 3),
(3, 'PROCURADURIA', '', 3),
(4, 'CONTRALORIA', '', 3),
(5, 'SECRETARIA DE SALUD DEPARTAMENTALES', '', 3),
(6, 'ASAMBLEA DEPARTAMENTAL DEL CAUCA', '', 3),
(7, 'GOBERNACION', '', 3),
(8, 'ALCALDIA DE GUAPI', '', 3),
(9, 'CONTRATACIONES', '', 3);


--
-- Table structure for table `salud_pagos_temporal`
--

CREATE TABLE IF NOT EXISTS `salud_pagos_temporal` (
  `id_temp_rips_generados` varchar(1) COLLATE latin1_spanish_ci NOT NULL,
  `Proceso` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `CodigoEPS` varchar(10) COLLATE latin1_spanish_ci NOT NULL,
  `NombreEPS` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `FormaContratacion` enum('Evento','Capitacion') COLLATE latin1_spanish_ci NOT NULL,
  `Departamento` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `Municipio` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `FechaFactura` date NOT NULL,
  `PrefijoFactura` varchar(10) COLLATE latin1_spanish_ci NOT NULL,
  `NumeroFactura` bigint(20) NOT NULL,
  `ValorGiro` double NOT NULL,
  `FechaPago` date NOT NULL,
  `NumeroGiro` bigint(20) NOT NULL,
  `nom_cargue` varchar(20) COLLATE latin1_spanish_ci NOT NULL,
  `fecha_cargue` datetime NOT NULL,
  `Soporte` varchar(200) COLLATE latin1_spanish_ci NOT NULL,
  `numero_factura` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `idUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


ALTER TABLE `salud_eps` ADD `TipoIdentificacion` ENUM('MU','DE','DI','NI') NOT NULL AFTER `nit`;

UPDATE `menu_submenus` SET `Pagina` = 'salud_genere_circular_030.php' WHERE `menu_submenus`.`ID` = 145;

--
-- 2018-03-28
--

ALTER TABLE `salud_archivo_facturacion_mov_generados` ADD `Arma030Anterior` ENUM('S','N') NOT NULL DEFAULT 'N' AFTER `EstadoCobro`;
ALTER TABLE `salud_archivo_facturacion_mov_pagados` ADD `Arma030Anterior` ENUM('S','N') NOT NULL DEFAULT 'N' AFTER `idUser`;

ALTER TABLE `salud_archivo_facturacion_mov_generados` CHANGE `nom_enti_administradora` `nom_enti_administradora` VARCHAR(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre entidad administradora \" Ver Alineamientos tecnicos para ips ver pag 13\" ';

ALTER TABLE `empresapro` ADD `CodigoPrestadora` bigint(20) NOT NULL AFTER `NIT`;

ALTER TABLE `salud_rips_facturas_generadas_temp` ADD `LineaArchivo` INT NOT NULL AFTER `idUser`;

