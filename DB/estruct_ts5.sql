-- Adminer 4.7.0 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

CREATE TABLE `abonos_libro` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Cantidad` float NOT NULL,
  `idLibroDiario` bigint(20) NOT NULL,
  `idComprobanteContable` bigint(20) NOT NULL,
  `TipoAbono` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `activos` (
  `idActivos` int(16) NOT NULL AUTO_INCREMENT,
  `Referencia` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `NombreAct` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Marca` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Serie` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `ValorEstimado` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Bodega` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `CuentaPUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idActivos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `act_movimientos` (
  `idAct_Movimientos` int(16) NOT NULL AUTO_INCREMENT,
  `Fecha` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Movimiento` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Origen` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Destino` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Entrega` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Recibe` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Estado` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `MotivoMovimiento` varchar(500) COLLATE utf8_spanish_ci NOT NULL,
  `Observaciones` varchar(1000) COLLATE utf8_spanish_ci NOT NULL,
  `NumOrden` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `BodegaDestino` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idActivo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idAct_Movimientos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `act_ordenes` (
  `idAct_Ordenes` int(16) NOT NULL AUTO_INCREMENT,
  `NumOrden` int(16) NOT NULL,
  `idAct_Movimiento` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Fecha` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Entrega` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Recibe` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Usuarios_idUsuarios` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Origen` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Destino` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Cerrada` int(1) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idAct_Ordenes`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `act_pre_movimientos` (
  `idAct_Movimientos` int(16) NOT NULL AUTO_INCREMENT,
  `Fecha` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Movimiento` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Origen` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Destino` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Entrega` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Recibe` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Estado` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `MotivoMovimiento` varchar(500) COLLATE utf8_spanish_ci NOT NULL,
  `Observaciones` varchar(1000) COLLATE utf8_spanish_ci NOT NULL,
  `NumOrden` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `BodegaDestino` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idActivo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idAct_Movimientos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `act_pre_ordenes` (
  `idAct_Ordenes` int(16) NOT NULL DEFAULT '0',
  `NumOrden` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idAct_Movimiento` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Fecha` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Entrega` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Recibe` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Usuarios_idUsuarios` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `acueducto_configuraciones` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ConsumoBase` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `acueducto_lecturas` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `idCliente` bigint(20) NOT NULL,
  `LecturaContador` bigint(20) NOT NULL,
  `Facturado` int(1) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `idCliente` (`idCliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `alertas` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `AlertaTipo` varchar(45) NOT NULL,
  `Mensaje` text NOT NULL,
  `Estado` int(11) NOT NULL,
  `TablaOrigen` varchar(100) NOT NULL,
  `idTabla` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `autorizaciones_generales` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Proceso` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Clave` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `bodega` (
  `idBodega` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Direccion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Ciudad` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Telefono` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idServidor` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idBodega`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `cajas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Base` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `Estado` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `CuentaPUCEfectivo` bigint(20) NOT NULL,
  `CuentaPUCCheques` bigint(20) NOT NULL,
  `CuentaPUCOtros` bigint(20) NOT NULL,
  `CuentaPUCIVAEgresos` bigint(20) NOT NULL,
  `idTerceroIntereses` bigint(20) NOT NULL COMMENT 'Nit del Tercero al que se va a ir la cuent x parar de intereses',
  `CentroCostos` int(11) NOT NULL,
  `idResolucionDian` int(11) NOT NULL,
  `idBascula` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `cajas_aperturas_cierres` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `Movimiento` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Usuario` int(11) NOT NULL,
  `idCaja` int(11) NOT NULL,
  `Efectivo` double NOT NULL,
  `Devueltas` double NOT NULL,
  `TotalAbonos` double NOT NULL,
  `AbonosCreditos` double NOT NULL,
  `AbonosSisteCredito` double NOT NULL,
  `TotalEgresos` double NOT NULL,
  `TotalEfectivo` double NOT NULL,
  `TotalVentas` double NOT NULL,
  `TotalVentasContado` double NOT NULL,
  `TotalVentasCredito` double NOT NULL,
  `TotalVentasSisteCredito` double NOT NULL,
  `TotalRetiroSeparados` double NOT NULL,
  `TotalDevoluciones` double NOT NULL,
  `TotalTarjetas` double NOT NULL,
  `TotalCheques` double NOT NULL,
  `TotalOtros` double NOT NULL,
  `TotalEntrega` double NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `cartera` (
  `idCartera` int(11) NOT NULL AUTO_INCREMENT,
  `Facturas_idFacturas` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `FechaIngreso` date NOT NULL DEFAULT '0000-00-00' COMMENT 'Fecha en la que ingresa a Cartera',
  `FechaVencimiento` date NOT NULL DEFAULT '0000-00-00',
  `DiasCartera` int(11) DEFAULT NULL,
  `idCliente` varchar(45) NOT NULL DEFAULT '0',
  `RazonSocial` varchar(100) DEFAULT NULL,
  `Telefono` varchar(45) NOT NULL,
  `Contacto` varchar(45) NOT NULL,
  `TelContacto` varchar(45) NOT NULL,
  `TotalFactura` double NOT NULL,
  `TotalAbonos` double NOT NULL,
  `Saldo` double NOT NULL DEFAULT '0',
  `Observaciones` text,
  `TipoCartera` varchar(45) NOT NULL DEFAULT 'Interna',
  `idUsuarios` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idCartera`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `centrocosto` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `EmpresaPro` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `cierres_contables` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `ciuu` (
  `Codigo` int(11) NOT NULL,
  `Descripcion` varchar(300) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `clasecuenta` (
  `PUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Clase` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Valor` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`PUC`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `clientes` (
  `idClientes` int(11) NOT NULL AUTO_INCREMENT,
  `Tipo_Documento` int(11) NOT NULL,
  `Num_Identificacion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `DV` varchar(5) COLLATE utf8_spanish_ci NOT NULL,
  `Lugar_Expedicion_Documento` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `Primer_Apellido` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Segundo_Apellido` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Primer_Nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Otros_Nombres` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `RazonSocial` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Direccion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Cod_Dpto` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Cod_Mcipio` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Pais_Domicilio` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Telefono` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Ciudad` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Contacto` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `TelContacto` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Email` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `CIUU` int(11) NOT NULL,
  `Cupo` double NOT NULL,
  `Soporte` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idClientes`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `cod_departamentos` (
  `Cod_dpto` int(11) NOT NULL,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`Cod_dpto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `cod_documentos` (
  `Codigo` int(11) NOT NULL,
  `Descripcion` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `Codigo` (`Codigo`),
  KEY `Codigo_2` (`Codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `cod_municipios_dptos` (
  `ID` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Cod_mcipio` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Cod_Dpto` int(11) NOT NULL,
  `Departamento` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Ciudad` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `cod_paises` (
  `Codigo` int(11) NOT NULL,
  `Pais` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `colaboradores` (
  `idColaboradores` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(90) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Identificacion` bigint(20) DEFAULT NULL,
  `Telefono` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Direccion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Ciudad` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Email` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Contacto` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `NumContacto` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Cargo` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `SalarioBasico` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Activo` varchar(2) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'SI',
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idColaboradores`),
  UNIQUE KEY `Identificacion` (`Identificacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `colaboradores_ventas` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `idFactura` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Total` float NOT NULL,
  `idColaborador` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `col_registrohoras` (
  `IdColRegistro` int(11) NOT NULL AUTO_INCREMENT,
  `IdColaborador` int(11) NOT NULL,
  `RegistroFecha` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `RegistroHora` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `EntradaSalida` varchar(5) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`IdColRegistro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `comisiones` (
  `idComisiones` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Porcentaje` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idComisiones`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `comisionesporventas` (
  `idComisionesPorVentas` int(11) NOT NULL AUTO_INCREMENT,
  `CuentaPUC` varchar(45) COLLATE utf8_spanish_ci DEFAULT '5105',
  `NombreCuenta` varchar(300) COLLATE utf8_spanish_ci NOT NULL,
  `Fecha` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Valor` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `TipoVenta` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Colaboradores_idColaboradores` int(11) NOT NULL,
  `Ventas_NumVenta` int(11) NOT NULL,
  `Paga` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idComisionesPorVentas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `compras` (
  `idCompras` int(11) NOT NULL AUTO_INCREMENT,
  `CuentaPUC` varchar(45) COLLATE utf8_spanish_ci DEFAULT '62',
  `Fecha` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Descripcion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `NumFactura` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Subtotal` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `IVA` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Retenciones` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Total` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `TipoPago` varchar(45) COLLATE utf8_spanish_ci DEFAULT 'Contado',
  `Pagada` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Proveedores_idProveedores` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idCompras`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `compras_activas` (
  `idComprasActivas` int(11) NOT NULL AUTO_INCREMENT,
  `idProveedor` int(11) NOT NULL,
  `Usuarios_idUsuarios` int(11) NOT NULL,
  `Factura` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `FormaPago` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `NombrePro` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Fecha` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `FechaProg` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `CuentaOrigen` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Tipo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `TotalCompra` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `DocumentoGenerado` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `NumComprobante` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idComprasActivas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `compras_precompra` (
  `idPreCompra` int(11) NOT NULL AUTO_INCREMENT,
  `idProductosVenta` int(11) NOT NULL,
  `Referencia` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Descripcion` varchar(500) COLLATE utf8_spanish_ci NOT NULL,
  `Cantidad` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `ValorUnitario` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Subtotal` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `IVA` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Total` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idComprasActivas` int(11) NOT NULL,
  `PrecioVentaPre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idPreCompra`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `comprobantes_contabilidad` (
  `ID` int(16) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Concepto` text COLLATE utf8_spanish_ci NOT NULL,
  `Usuarios_idUsuarios` int(11) NOT NULL,
  `Estado` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `comprobantes_contabilidad_items` (
  `ID` int(16) NOT NULL AUTO_INCREMENT,
  `idComprobante` int(16) NOT NULL,
  `Fecha` date NOT NULL,
  `CentroCostos` int(11) NOT NULL,
  `Tercero` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `CuentaPUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `NombreCuenta` text COLLATE utf8_spanish_ci NOT NULL,
  `Debito` int(16) NOT NULL,
  `Credito` int(16) NOT NULL,
  `Concepto` text COLLATE utf8_spanish_ci NOT NULL,
  `NumDocSoporte` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Soporte` text COLLATE utf8_spanish_ci NOT NULL,
  `idLibroDiario` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `comprobantes_egreso_items` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idComprobante` bigint(20) NOT NULL,
  `Fecha` date NOT NULL,
  `CentroCostos` int(11) NOT NULL,
  `Tercero` int(11) NOT NULL,
  `CuentaPUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `NombreCuenta` text COLLATE utf8_spanish_ci NOT NULL,
  `Debito` int(16) NOT NULL,
  `Credito` int(16) NOT NULL,
  `Concepto` text COLLATE utf8_spanish_ci NOT NULL,
  `NumDocSoporte` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Soporte` text COLLATE utf8_spanish_ci NOT NULL,
  `idLibroDiario` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idSucursal` int(11) NOT NULL,
  `OrigenMovimiento` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idOrigen` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `comprobantes_ingreso` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Fecha` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Clientes_idClientes` int(11) NOT NULL,
  `Tercero` int(11) NOT NULL,
  `Valor` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Tipo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Concepto` text COLLATE utf8_spanish_ci NOT NULL,
  `Usuarios_idUsuarios` int(11) NOT NULL,
  `Estado` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idCierre` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `comprobantes_ingreso_anulaciones` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `Observaciones` text COLLATE utf8_spanish_ci NOT NULL,
  `idComprobanteIngreso` bigint(20) NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `Monto` double NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `comprobantes_ingreso_items` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idComprobante` int(16) NOT NULL,
  `Fecha` date NOT NULL,
  `CentroCostos` int(11) NOT NULL,
  `Tercero` bigint(20) NOT NULL,
  `CuentaPUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `NombreCuenta` text COLLATE utf8_spanish_ci NOT NULL,
  `Debito` int(16) NOT NULL,
  `Credito` int(16) NOT NULL,
  `Concepto` text COLLATE utf8_spanish_ci NOT NULL,
  `NumDocSoporte` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Soporte` text COLLATE utf8_spanish_ci NOT NULL,
  `idLibroDiario` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idSucursal` int(11) NOT NULL,
  `OrigenMovimiento` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idOrigen` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `comprobantes_pre` (
  `ID` int(16) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Concepto` text COLLATE utf8_spanish_ci NOT NULL,
  `idComprobanteContabilidad` int(16) NOT NULL,
  `Estado` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `concejales` (
  `ID` bigint(20) NOT NULL,
  `Nombre` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Cargo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Fecha_Inicio` date NOT NULL,
  `Fecha_Terminacion` date NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `concejales_intervenciones` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idConcejal` bigint(20) NOT NULL,
  `idSesionConcejo` bigint(20) NOT NULL,
  `Fecha` date NOT NULL,
  `HoraInicio` time NOT NULL,
  `HoraFin` time NOT NULL,
  `Expresado` text COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `concejo_sesiones` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Sesion` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Fecha` date NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `concejo_tipo_sesiones` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Tipo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `conceptos` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `FechaHoraCreacion` datetime NOT NULL,
  `Nombre` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `Observaciones` text COLLATE utf8_spanish_ci NOT NULL,
  `Genera` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `Completo` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `Activo` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `TerceroCuentaCobro` enum('SI','NO') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'NO',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `conceptos_montos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idConcepto` int(11) NOT NULL,
  `NombreMonto` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Depende` bigint(20) NOT NULL,
  `Operacion` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `ValorDependencia` bigint(20) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `conceptos_movimientos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idConcepto` int(11) NOT NULL,
  `idMonto` int(11) NOT NULL,
  `CuentaPUC` bigint(20) NOT NULL,
  `NombreCuentaPUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `TipoMovimiento` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `configuraciones_nombres_campos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `NombreDB` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `Visualiza` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


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


CREATE TABLE `configuracion_general` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `Valor` text COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


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


CREATE TABLE `config_codigo_barras` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TituloEtiqueta` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `DistaciaEtiqueta1` int(11) NOT NULL,
  `DistaciaEtiqueta2` int(11) NOT NULL,
  `DistaciaEtiqueta3` int(11) NOT NULL,
  `AlturaLinea1` int(11) NOT NULL,
  `AlturaLinea2` int(11) NOT NULL,
  `AlturaLinea3` int(11) NOT NULL,
  `AlturaLinea4` int(11) NOT NULL,
  `AlturaLinea5` int(11) NOT NULL,
  `AlturaCodigoBarras` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `config_puertos` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Puerto` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Utilizacion` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Habilitado` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `config_tiketes_promocion` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NombreTiket` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Tope` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Multiple` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `Activo` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `costos` (
  `idCostos` int(20) NOT NULL AUTO_INCREMENT,
  `NombreCosto` varchar(45) NOT NULL,
  `ValorCosto` double NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idCostos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `cotizacionesv5` (
  `ID` int(16) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Clientes_idClientes` int(11) NOT NULL,
  `Usuarios_idUsuarios` int(11) NOT NULL,
  `Observaciones` text COLLATE utf8_spanish_ci NOT NULL,
  `NumSolicitud` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `NumOrden` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Seguimiento` text COLLATE utf8_spanish_ci NOT NULL,
  `Estado` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `Estado` (`Estado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `cotizaciones_anexos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `FechaCreacion` datetime NOT NULL,
  `Titulo` text COLLATE utf8_spanish_ci NOT NULL,
  `NumCotizacion` bigint(20) NOT NULL,
  `Anexo` text COLLATE utf8_spanish_ci NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `cotizaciones_anticipos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Valor` double NOT NULL,
  `idCotizacion` bigint(20) NOT NULL,
  `idComprobanteIngreso` bigint(20) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `Estado` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `idCotizacion` (`idCotizacion`),
  KEY `idComprobanteIngreso` (`idComprobanteIngreso`),
  KEY `Estado` (`Estado`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `cot_itemscotizaciones` (
  `ID` int(16) NOT NULL AUTO_INCREMENT,
  `idCliente` int(11) NOT NULL DEFAULT '0',
  `NumCotizacion` int(16) NOT NULL,
  `Descripcion` text COLLATE utf8_spanish_ci,
  `Referencia` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `TablaOrigen` varchar(45) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `ValorUnitario` double NOT NULL,
  `Cantidad` double NOT NULL,
  `Multiplicador` int(11) NOT NULL,
  `Subtotal` double NOT NULL,
  `IVA` double NOT NULL,
  `Total` double NOT NULL,
  `Descuento` double NOT NULL,
  `ValorDescuento` double NOT NULL,
  `PrecioCosto` double NOT NULL,
  `SubtotalCosto` double NOT NULL,
  `TipoItem` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Devuelto` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `CuentaPUC` varchar(45) CHARACTER SET utf8 NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `NumCotizacion` (`NumCotizacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `crono_controles` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `idSesionConcejo` bigint(20) NOT NULL,
  `idConcejal` bigint(20) NOT NULL,
  `Estado` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `Inicio` time NOT NULL,
  `Fin` time NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `cuentas` (
  `idPUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Valor` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `GupoCuentas_PUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idPUC`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `cuentasfrecuentes` (
  `CuentaPUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Nombre` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `ClaseCuenta` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `UsoFuturo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`CuentaPUC`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `cuentasxpagar` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `DocumentoReferencia` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `Concepto` text COLLATE utf8_spanish_ci NOT NULL,
  `FechaProgramada` date NOT NULL,
  `Subtotal` double NOT NULL,
  `IVA` double NOT NULL,
  `Retenciones` double NOT NULL,
  `Total` double NOT NULL,
  `Abonos` double NOT NULL,
  `Saldo` double NOT NULL,
  `idProveedor` bigint(20) NOT NULL,
  `RazonSocial` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Direccion` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Ciudad` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `Telefono` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `CuentaBancaria` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `A_Nombre_De` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `TipoCuenta` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `EntidadBancaria` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Dias` int(11) NOT NULL,
  `idSucursal` int(11) NOT NULL,
  `Soporte` text COLLATE utf8_spanish_ci NOT NULL,
  `idCentroCostos` int(11) NOT NULL,
  `Origen` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `DocumentoCruce` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `Estado` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `CuentaPUC` varchar(20) COLLATE utf8_spanish_ci NOT NULL DEFAULT '220505',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `cuentasxpagar_abonos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `idCuentaXPagar` text COLLATE utf8_spanish_ci NOT NULL,
  `Monto` double NOT NULL,
  `idUsuarios` bigint(20) NOT NULL,
  `idComprobanteEgreso` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `cuentas_frecuentes` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Tercero` bigint(20) NOT NULL,
  `idCotizacion` bigint(20) NOT NULL,
  `DiaCobro` int(11) NOT NULL,
  `UltimoPago` date NOT NULL,
  `TotalCuotas` int(11) NOT NULL,
  `CuotasPagas` int(11) NOT NULL,
  `CuotasFaltantes` int(11) NOT NULL,
  `Estado` enum('A','I') COLLATE utf8_spanish_ci NOT NULL,
  `MesPago` enum('S','N') COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `devolucionesventas` (
  `idComprasDevoluciones` int(11) NOT NULL AUTO_INCREMENT,
  `NumVenta` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Fecha` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Descripcion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Cantidad` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `EfectivoDevuelto` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `ProductosVenta_idProductosVenta` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idComprasDevoluciones`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `documentos_contables` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `documentos_contables_control` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idDocumento` int(11) NOT NULL,
  `Consecutivo` bigint(20) NOT NULL,
  `Fecha` date NOT NULL,
  `Descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `Estado` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `Consecutivo` (`Consecutivo`),
  KEY `idDocumento` (`idDocumento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `documentos_contables_items` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idDocumento` int(11) NOT NULL,
  `Nombre_Documento` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Numero_Documento` bigint(20) NOT NULL,
  `Fecha` date NOT NULL,
  `CentroCostos` int(11) NOT NULL,
  `Tercero` bigint(20) NOT NULL,
  `CuentaPUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `NombreCuenta` text COLLATE utf8_spanish_ci NOT NULL,
  `Debito` int(16) NOT NULL,
  `Credito` int(16) NOT NULL,
  `Concepto` text COLLATE utf8_spanish_ci NOT NULL,
  `NumDocSoporte` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Soporte` text COLLATE utf8_spanish_ci NOT NULL,
  `idLibroDiario` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `documentos_contables_items_temp` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idDocumento` int(11) NOT NULL,
  `Nombre_Documento` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Numero_Documento` bigint(20) NOT NULL,
  `Fecha` date NOT NULL,
  `CentroCostos` int(11) NOT NULL,
  `Tercero` bigint(20) NOT NULL,
  `CuentaPUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `NombreCuenta` text COLLATE utf8_spanish_ci NOT NULL,
  `Debito` int(16) NOT NULL,
  `Credito` int(16) NOT NULL,
  `Concepto` text COLLATE utf8_spanish_ci NOT NULL,
  `NumDocSoporte` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Soporte` text COLLATE utf8_spanish_ci NOT NULL,
  `idLibroDiario` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `documentos_generados` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `Abreviatura` varchar(3) COLLATE utf8_spanish_ci NOT NULL,
  `Libro` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Abreviatura` (`Abreviatura`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `documento_equivalente` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Tercero` bigint(20) NOT NULL,
  `Estado` enum('AB','CE') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'AB' COMMENT 'AB abierto,CE Cerrado',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `documento_equivalente_items` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `Cantidad` double NOT NULL,
  `ValorUnitario` double NOT NULL,
  `Total` double NOT NULL,
  `idDocumento` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `egresos` (
  `idEgresos` int(45) NOT NULL AUTO_INCREMENT,
  `Fecha` varchar(45) NOT NULL,
  `PagoProg` varchar(10) NOT NULL,
  `FechaPagoPro` varchar(20) NOT NULL,
  `FechaPago` varchar(20) NOT NULL,
  `Concepto` varchar(300) NOT NULL,
  `TipoEgreso` varchar(45) NOT NULL,
  `ServicioPago` varchar(45) NOT NULL,
  `Beneficiario` varchar(45) NOT NULL,
  `NIT` varchar(45) NOT NULL,
  `Direccion` varchar(45) NOT NULL,
  `Ciudad` varchar(45) NOT NULL,
  `Subtotal` varchar(45) NOT NULL,
  `IVA` varchar(45) NOT NULL,
  `Valor` varchar(45) NOT NULL,
  `Retenciones` varchar(45) NOT NULL,
  `NumFactura` varchar(45) NOT NULL,
  `idProveedor` varchar(45) NOT NULL,
  `Cuenta` varchar(45) NOT NULL,
  `Soporte` text NOT NULL,
  `Usuario_idUsuario` int(11) NOT NULL,
  `CerradoDiario` varchar(3) NOT NULL,
  `FechaCierreDiario` varchar(45) NOT NULL,
  `HoraCierreDiario` varchar(45) NOT NULL,
  `UsuarioCierreDiario` varchar(45) NOT NULL,
  `CentroCostos` int(11) NOT NULL,
  `EmpresaPro` int(11) NOT NULL,
  `idSucursal` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idEgresos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `egresos_activos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) NOT NULL,
  `Cuentas_idCuentas` int(11) NOT NULL,
  `Visible` int(1) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `egresos_anulaciones` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `Observaciones` text COLLATE utf8_spanish_ci NOT NULL,
  `idComprobanteEgreso` bigint(20) NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `egresos_items` (
  `ID` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `CuentaDestino` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Tercero` int(11) NOT NULL,
  `Debito` int(11) NOT NULL,
  `Credito` int(11) NOT NULL,
  `Concepto` text COLLATE utf8_spanish_ci NOT NULL,
  `CentroCosto` int(11) NOT NULL,
  `TipoPago` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `FechaProgramada` date NOT NULL,
  `NumeroComprobante` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Soporte` text COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `egresos_pre` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idCuentaXPagar` bigint(20) NOT NULL,
  `Abono` double NOT NULL,
  `Descuento` double NOT NULL,
  `CruceNota` double NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `egresos_tipo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(100) NOT NULL,
  `Cuentas_idCuentas` int(11) NOT NULL,
  `Visible` int(1) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `empresapro` (
  `idEmpresaPro` int(11) NOT NULL AUTO_INCREMENT,
  `RazonSocial` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `NIT` bigint(20) DEFAULT NULL,
  `DigitoVerificacion` int(1) NOT NULL,
  `Direccion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Barrio` varchar(70) COLLATE utf8_spanish_ci NOT NULL,
  `Telefono` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Celular` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Ciudad` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ResolucionDian` text COLLATE utf8_spanish_ci NOT NULL,
  `Regimen` enum('SIMPLIFICADO','COMUN') COLLATE utf8_spanish_ci DEFAULT 'SIMPLIFICADO',
  `TipoPersona` enum('1','2','3') COLLATE utf8_spanish_ci NOT NULL COMMENT '1 Persona jurica, 2 persona natural,3 grandes contribuyentes',
  `TipoDocumento` int(11) NOT NULL,
  `MatriculoMercantil` bigint(20) NOT NULL,
  `ActividadesEconomicas` text COLLATE utf8_spanish_ci NOT NULL,
  `Email` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `WEB` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ObservacionesLegales` text COLLATE utf8_spanish_ci NOT NULL,
  `PuntoEquilibrio` bigint(20) DEFAULT NULL,
  `DatosBancarios` text COLLATE utf8_spanish_ci NOT NULL,
  `RutaImagen` varchar(200) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'LogosEmpresas/logotipo1.png',
  `FacturaSinInventario` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `CXPAutomaticas` varchar(2) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'SI',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idEmpresaPro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `empresapro_regimenes` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Regimen` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `empresapro_resoluciones_facturacion` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NombreInterno` text COLLATE utf8_spanish_ci NOT NULL,
  `NumResolucion` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Fecha` date NOT NULL,
  `NumSolicitud` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Tipo` varchar(4) COLLATE utf8_spanish_ci NOT NULL,
  `Factura` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Prefijo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Desde` int(16) NOT NULL,
  `Hasta` int(16) NOT NULL,
  `FechaVencimiento` date NOT NULL,
  `idEmpresaPro` int(11) NOT NULL,
  `Estado` varchar(2) COLLATE utf8_spanish_ci NOT NULL COMMENT 'OC: Ocupada',
  `Completada` varchar(2) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'NO',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `empresa_pro_sucursales` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Ciudad` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Direccion` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `idEmpresaPro` int(11) NOT NULL,
  `Visible` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `Actual` varchar(1) COLLATE utf8_spanish_ci NOT NULL,
  `idServidor` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `estadosfinancieros_mayor_temporal` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `FechaCorte` date NOT NULL,
  `Clase` int(11) NOT NULL,
  `CuentaPUC` bigint(20) NOT NULL,
  `NombreCuenta` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `SaldoAnterior` double NOT NULL,
  `Neto` double NOT NULL,
  `SaldoFinal` double NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `color` varchar(7) DEFAULT NULL,
  `start_event` datetime NOT NULL,
  `end_event` datetime DEFAULT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `facturas` (
  `idFacturas` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `idResolucion` int(11) NOT NULL,
  `TipoFactura` varchar(10) NOT NULL,
  `Prefijo` varchar(45) NOT NULL,
  `NumeroFactura` int(16) NOT NULL,
  `Fecha` date NOT NULL,
  `Hora` varchar(20) NOT NULL,
  `OCompra` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `OSalida` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `FormaPago` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `Subtotal` double NOT NULL,
  `IVA` double NOT NULL,
  `Descuentos` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `Total` double NOT NULL,
  `SaldoFact` double NOT NULL,
  `Cotizaciones_idCotizaciones` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `EmpresaPro_idEmpresaPro` int(11) NOT NULL,
  `CentroCosto` int(11) NOT NULL,
  `idSucursal` int(11) NOT NULL,
  `Usuarios_idUsuarios` int(11) NOT NULL,
  `Clientes_idClientes` int(11) NOT NULL,
  `TotalCostos` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `CerradoDiario` bigint(20) NOT NULL,
  `FechaCierreDiario` date NOT NULL,
  `HoraCierreDiario` time NOT NULL,
  `ObservacionesFact` text NOT NULL,
  `Efectivo` double NOT NULL,
  `Devuelve` double NOT NULL,
  `Cheques` double NOT NULL,
  `Otros` double NOT NULL,
  `Tarjetas` double NOT NULL,
  `idTarjetas` int(11) NOT NULL,
  `ReporteFacturaElectronica` int(1) NOT NULL COMMENT 'indica si ya fue reportada como factura electronica',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idFacturas`),
  KEY `ReporteFacturaElectronica` (`ReporteFacturaElectronica`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DELIMITER ;;

CREATE TRIGGER `InsertFacturaOri` AFTER INSERT ON `facturas` FOR EACH ROW
BEGIN

INSERT INTO ori_facturas SELECT * FROM facturas WHERE idFacturas=New.idFacturas;


END;;

CREATE TRIGGER `Actualiza_OriFacturas` AFTER UPDATE ON `facturas` FOR EACH ROW
BEGIN

REPLACE INTO ori_facturas SELECT * FROM facturas WHERE idFacturas=New.idFacturas;


END;;

DELIMITER ;

CREATE TABLE `facturas_abonos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `TipoPagoAbono` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `Valor` double NOT NULL,
  `Usuarios_idUsuarios` int(11) NOT NULL,
  `Facturas_idFacturas` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `FormaPago` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idComprobanteIngreso` int(11) NOT NULL,
  `idCierre` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `facturas_anticipos` (
  `ID` int(16) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `idCliente` int(11) NOT NULL,
  `Valor` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `CentroCosto` int(11) NOT NULL,
  `CuentaIngreso` int(11) NOT NULL,
  `Estado` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `facturas_autoretenciones` (
  `idFacturasAutoretenciones` int(11) NOT NULL AUTO_INCREMENT,
  `Fecha` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `NombreAutoRetencion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Porcentaje` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Monto` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Paga` varchar(2) COLLATE utf8_spanish_ci DEFAULT NULL,
  `FechaPago` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Soportes_idSoportes` int(11) DEFAULT NULL,
  `Facturas_idFacturas` int(11) DEFAULT NULL,
  `idImpRet` int(11) DEFAULT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idFacturasAutoretenciones`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `facturas_electronicas` (
  `idFactura` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `XmlFiscal` text COLLATE utf8_spanish_ci NOT NULL,
  `NumeroDocumento` text COLLATE utf8_spanish_ci NOT NULL,
  `idDocumento` text COLLATE utf8_spanish_ci NOT NULL,
  `EstadoCUFE` text COLLATE utf8_spanish_ci NOT NULL,
  `CUFE` text COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `facturas_electronicas_contador` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `FechaHabilitacion` date NOT NULL,
  `FechaVencimiento` date NOT NULL,
  `NumeroTransaccionesDisponibles` int(11) NOT NULL,
  `TransaccionesActuales` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `facturas_formapago` (
  `idFacturas_FormaPago` int(16) NOT NULL AUTO_INCREMENT,
  `Total` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Paga` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Devuelve` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `FormaPago` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Facturas_idFacturas` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idFacturas_FormaPago`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `facturas_frecuentes` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idCliente` bigint(20) NOT NULL,
  `Periodo` int(11) NOT NULL,
  `FacturaBase` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `UltimaFactura` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Habilitado` int(1) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `FacturaBase` (`FacturaBase`),
  KEY `UltimaFactura` (`UltimaFactura`),
  KEY `idCliente` (`idCliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `facturas_frecuentes_items_adicionales` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TablaOrigen` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idTablaOrigen` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idItem` bigint(20) NOT NULL,
  `ValorUnitario` double NOT NULL,
  `Cantidad` double NOT NULL,
  `idFacturaFrecuente` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `facturas_intereses_sistecredito` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `idFactura` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Valor` double NOT NULL,
  `idCierre` bigint(20) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `facturas_items` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `FechaFactura` date NOT NULL,
  `idFactura` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `TablaItems` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tabla donde se encuentra el producto o servicio',
  `Referencia` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL COMMENT 'Referencia del producto o servicio',
  `Nombre` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `Departamento` int(11) NOT NULL,
  `SubGrupo1` int(11) NOT NULL,
  `SubGrupo2` int(11) NOT NULL,
  `SubGrupo3` int(11) NOT NULL,
  `SubGrupo4` int(11) NOT NULL,
  `SubGrupo5` int(11) NOT NULL,
  `ValorUnitarioItem` double NOT NULL,
  `Cantidad` double NOT NULL,
  `Dias` double NOT NULL,
  `SubtotalItem` double NOT NULL,
  `IVAItem` double NOT NULL,
  `ValorOtrosImpuestos` double NOT NULL,
  `TotalItem` double NOT NULL COMMENT 'Total del valor del Item',
  `PorcentajeIVA` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL COMMENT 'que porcentaje de IVA se le aplico',
  `idOtrosImpuestos` int(11) NOT NULL,
  `idPorcentajeIVA` int(11) NOT NULL,
  `PrecioCostoUnitario` double NOT NULL,
  `SubtotalCosto` double NOT NULL COMMENT 'Costo total del item',
  `TipoItem` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL COMMENT 'Define si se realiza ajustes a inventarios',
  `CuentaPUC` int(11) NOT NULL COMMENT 'Cuenta donde se llevara el asiento contable ',
  `GeneradoDesde` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tabla que agrega el item',
  `NumeroIdentificador` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL COMMENT 'Identificar del que agrega el item',
  `idUsuarios` int(11) NOT NULL,
  `idCierre` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `idFactura` (`idFactura`),
  KEY `idCierre` (`idCierre`),
  KEY `FechaFactura` (`FechaFactura`),
  KEY `Referencia` (`Referencia`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DELIMITER ;;

CREATE TRIGGER `InsertFacturasItems` AFTER INSERT ON `facturas_items` FOR EACH ROW
BEGIN

INSERT INTO ori_facturas_items SELECT * FROM facturas_items WHERE ID=New.ID;

END;;

DELIMITER ;

CREATE TABLE `facturas_kardex` (
  `idFacturas` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `CuentaDestino` bigint(20) NOT NULL,
  `Kardex` varchar(2) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'NO',
  `idUsuario` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idFacturas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `facturas_pre` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `FechaFactura` date NOT NULL,
  `idFactura` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `TablaItems` varchar(100) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tabla donde se encuentra el producto o servicio',
  `Referencia` varchar(200) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Referencia del producto o servicio',
  `Nombre` text COLLATE utf8_spanish_ci NOT NULL,
  `Departamento` int(11) NOT NULL,
  `SubGrupo1` int(11) NOT NULL,
  `SubGrupo2` int(11) NOT NULL,
  `SubGrupo3` int(11) NOT NULL,
  `SubGrupo4` int(11) NOT NULL,
  `SubGrupo5` int(11) NOT NULL,
  `ValorUnitarioItem` double NOT NULL,
  `Cantidad` double NOT NULL,
  `Dias` double NOT NULL,
  `SubtotalItem` double NOT NULL,
  `IVAItem` double NOT NULL,
  `TotalItem` double NOT NULL,
  `PorcentajeIVA` double NOT NULL,
  `PrecioCostoUnitario` double NOT NULL,
  `SubtotalCosto` double NOT NULL,
  `TipoItem` varchar(10) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Define si se realiza ajustes a inventarios',
  `CuentaPUC` int(11) NOT NULL COMMENT 'Cuenta donde se llevara el asiento contable ',
  `GeneradoDesde` varchar(100) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tabla que agrega el item',
  `NumeroIdentificador` varchar(45) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Identificar del que agrega el item',
  `idUsuarios` int(11) NOT NULL,
  `idCierre` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `facturas_reten_aplicadas` (
  `idFacturasRetAplicadas` int(11) NOT NULL AUTO_INCREMENT,
  `Fecha` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `NombreRetencion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Porcentaje` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Monto` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Cruzada` varchar(2) COLLATE utf8_spanish_ci DEFAULT NULL,
  `FechaCruce` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Soportes_idSoportes` int(11) DEFAULT NULL,
  `Facturas_idFacturas` int(11) DEFAULT NULL,
  `idImpRet` int(11) DEFAULT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idFacturasRetAplicadas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DELIMITER ;;

CREATE TRIGGER `ActualizaSaldoFact` AFTER INSERT ON `facturas_reten_aplicadas` FOR EACH ROW
BEGIN

SELECT SaldoFact into @SaldoAnt FROM facturas WHERE idFacturas=NEW.Facturas_idFacturas;

SET @Saldo=@SaldoAnt-NEW.Monto;

UPDATE facturas SET SaldoFact=@Saldo WHERE idFacturas=NEW.Facturas_idFacturas;


END;;

CREATE TRIGGER `ActualizaSaldoFactUpdate` AFTER UPDATE ON `facturas_reten_aplicadas` FOR EACH ROW
BEGIN

SELECT SaldoFact into @SaldoAnt FROM facturas WHERE idFacturas=NEW.Facturas_idFacturas;

SET @Saldo=@SaldoAnt+(OLD.Monto-NEW.Monto);

UPDATE facturas SET SaldoFact=@Saldo WHERE idFacturas=NEW.Facturas_idFacturas;


END;;

CREATE TRIGGER `ActualizaSaldoFactDel` BEFORE DELETE ON `facturas_reten_aplicadas` FOR EACH ROW
BEGIN

SELECT SaldoFact into @SaldoAnt FROM facturas WHERE idFacturas=OLD.Facturas_idFacturas;

SET @Saldo=@SaldoAnt+OLD.Monto;

UPDATE facturas SET SaldoFact=@Saldo WHERE idFacturas=OLD.Facturas_idFacturas;


END;;

DELIMITER ;

CREATE TABLE `facturas_tipo_pago` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TipoPago` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Leyenda` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `factura_compra` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Tercero` bigint(20) NOT NULL,
  `Concepto` text COLLATE utf8_spanish_ci NOT NULL,
  `Observaciones` text COLLATE utf8_spanish_ci NOT NULL,
  `NumeroFactura` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Estado` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `TipoCompra` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `TipoPago` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Soporte` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `idEmpresa` int(11) NOT NULL DEFAULT '1',
  `idCentroCostos` int(11) NOT NULL,
  `idSucursal` int(11) NOT NULL,
  `idCierre` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `factura_compra_anulaciones` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `Observaciones` text COLLATE utf8_spanish_ci NOT NULL,
  `idCompra` bigint(20) NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `factura_compra_descuentos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idCompra` bigint(20) NOT NULL,
  `CuentaPUCDescuento` bigint(20) NOT NULL,
  `NombreCuentaDescuento` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `ValorDescuento` double NOT NULL,
  `PorcentajeDescuento` double NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


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


CREATE TABLE `factura_compra_insumos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idFacturaCompra` bigint(20) NOT NULL,
  `idProducto` bigint(20) NOT NULL,
  `Cantidad` double NOT NULL,
  `CostoUnitarioCompra` double NOT NULL,
  `SubtotalCompra` double NOT NULL,
  `ImpuestoCompra` double NOT NULL,
  `TotalCompra` double NOT NULL,
  `Tipo_Impuesto` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `ProcentajeDescuento` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `ValorDescuento` double NOT NULL,
  `SubtotalDescuento` double NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `idFacturaCompra` (`idFacturaCompra`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `factura_compra_items` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idFacturaCompra` bigint(20) NOT NULL,
  `idProducto` bigint(20) NOT NULL,
  `Cantidad` double NOT NULL,
  `CostoUnitarioCompra` double NOT NULL,
  `SubtotalCompra` double NOT NULL,
  `ImpuestoCompra` double NOT NULL,
  `TotalCompra` double NOT NULL,
  `Tipo_Impuesto` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `ProcentajeDescuento` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `ValorDescuento` double NOT NULL,
  `SubtotalDescuento` double NOT NULL,
  `PrecioVenta` double NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `idFacturaCompra` (`idFacturaCompra`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `factura_compra_items_devoluciones` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idNotaDevolucion` bigint(20) NOT NULL,
  `idFacturaCompra` bigint(20) NOT NULL,
  `idProducto` bigint(20) NOT NULL,
  `Cantidad` double NOT NULL,
  `CostoUnitarioCompra` double NOT NULL,
  `SubtotalCompra` double NOT NULL,
  `ImpuestoCompra` double NOT NULL,
  `TotalCompra` double NOT NULL,
  `Tipo_Impuesto` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `factura_compra_notas_devolucion` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Tercero` bigint(20) NOT NULL,
  `Concepto` text COLLATE utf8_spanish_ci NOT NULL,
  `idCentroCostos` int(11) NOT NULL,
  `idSucursal` int(11) NOT NULL,
  `idUser` bigint(20) NOT NULL,
  `Estado` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `factura_compra_retenciones` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idCompra` bigint(20) NOT NULL,
  `CuentaPUC` bigint(20) NOT NULL,
  `NombreCuenta` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `ValorRetencion` double NOT NULL,
  `PorcentajeRetenido` double NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `factura_compra_servicios` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idFacturaCompra` bigint(20) NOT NULL,
  `CuentaPUC_Servicio` bigint(20) NOT NULL,
  `Nombre_Cuenta` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Concepto_Servicio` text COLLATE utf8_spanish_ci NOT NULL,
  `Subtotal_Servicio` double NOT NULL,
  `Impuesto_Servicio` double NOT NULL,
  `Total_Servicio` double NOT NULL,
  `Tipo_Impuesto` double NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `fechas_descuentos` (
  `idFechaDescuentos` int(11) NOT NULL AUTO_INCREMENT,
  `Fecha` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Motivo` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Departamento` varchar(11) COLLATE utf8_spanish_ci NOT NULL,
  `Sub1` int(11) NOT NULL,
  `Sub2` int(11) NOT NULL,
  `Porcentaje` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Usuarios_idUsuarios` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idFechaDescuentos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `fe_webservice` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `DireccionWebService` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `User` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Pass` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `formatos_calidad` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` text COLLATE utf8_spanish_ci NOT NULL,
  `Version` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Codigo` text COLLATE utf8_spanish_ci NOT NULL,
  `Fecha` date NOT NULL,
  `CuerpoFormato` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `NotasPiePagina` text COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `gupocuentas` (
  `PUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Valor` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ClaseCuenta_PUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`PUC`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `impret` (
  `idImpRet` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Tipo` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Valor` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `CuentaRetFavor` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `CuentaRetRealizadas` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Aplicable_A` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idImpRet`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `ingresos` (
  `idIngresos` int(200) NOT NULL AUTO_INCREMENT,
  `Observaciones` varchar(500) NOT NULL,
  `Total` int(10) NOT NULL,
  `Fecha` varchar(10) NOT NULL,
  `Facturas_idFacturas` int(45) NOT NULL,
  `Usuarios_idUsuarios` int(11) NOT NULL,
  `CerradoDiario` varchar(5) NOT NULL,
  `FechaCierreDiario` varchar(25) NOT NULL,
  `HoraCierreDiario` varchar(25) NOT NULL,
  `UsuarioCierreDiario` varchar(45) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idIngresos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `ingresosvarios` (
  `idIngresosVarios` int(11) NOT NULL AUTO_INCREMENT,
  `Fecha` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Descripcion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Valor` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idIngresosVarios`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `insumos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Referencia` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Nombre` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Existencia` double NOT NULL,
  `CostoUnitario` double NOT NULL,
  `CostoTotal` double NOT NULL,
  `Unidad` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Referencia` (`Referencia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `insumos_kardex` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date DEFAULT NULL,
  `Movimiento` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Detalle` varchar(400) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idDocumento` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Cantidad` double DEFAULT NULL,
  `ValorUnitario` double NOT NULL,
  `ValorTotal` double NOT NULL,
  `ReferenciaInsumo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `ReferenciaInsumo` (`ReferenciaInsumo`),
  KEY `Movimiento` (`Movimiento`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `inventarios_conteo_selectivo` (
  `Referencia` bigint(20) NOT NULL,
  `Cantidad` double NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`Referencia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `inventarios_diferencias` (
  `idProductosVenta` bigint(20) NOT NULL AUTO_INCREMENT,
  `CodigoBarras` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Referencia` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Nombre` varchar(70) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ExistenciaAnterior` double NOT NULL,
  `ExistenciaActual` double NOT NULL,
  `Diferencia` double DEFAULT NULL,
  `PrecioVenta` double DEFAULT NULL,
  `CostoUnitario` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `CostoTotal` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `IVA` varchar(10) COLLATE utf8_spanish_ci NOT NULL DEFAULT '0',
  `Departamento` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Sub1` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub2` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub3` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub4` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub5` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idProductosVenta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `inventarios_temporal` (
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
  `Sub6` int(11) NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `kardexmercancias` (
  `idKardexMercancias` bigint(20) NOT NULL AUTO_INCREMENT,
  `idBodega` int(11) NOT NULL DEFAULT '1',
  `Fecha` date DEFAULT NULL,
  `Movimiento` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Detalle` varchar(400) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idDocumento` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Cantidad` double NOT NULL,
  `ValorUnitario` double NOT NULL,
  `ValorTotal` double NOT NULL,
  `CostoUnitarioPromedio` double NOT NULL,
  `CostoTotalPromedio` double NOT NULL,
  `ProductosVenta_idProductosVenta` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idKardexMercancias`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `kardexmercancias_temporal` (
  `idKardexMercancias` bigint(20) NOT NULL AUTO_INCREMENT,
  `idBodega` int(11) NOT NULL DEFAULT '1',
  `Fecha` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Movimiento` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Detalle` varchar(400) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idDocumento` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Cantidad` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ValorUnitario` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ValorTotal` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `CostoPromedioUnitario` double NOT NULL,
  `CostoPromedioTotal` double NOT NULL,
  `ProductosVenta_idProductosVenta` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idKardexMercancias`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `kardex_alquiler` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Movimiento` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Cantidad` double NOT NULL,
  `Equipo` text COLLATE utf8_spanish_ci NOT NULL,
  `idProducto` bigint(20) NOT NULL,
  `idCliente` bigint(20) NOT NULL,
  `RazonSocial` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Detalle` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `NumDocumento` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `ValorUnitario` double NOT NULL,
  `ValorTotal` double NOT NULL,
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `idProducto` (`idProducto`),
  KEY `idProducto_2` (`idProducto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `kits` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `kits_relaciones` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TablaProducto` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `ReferenciaProducto` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `IDKit` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `librodiario` (
  `idLibroDiario` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date DEFAULT NULL,
  `Tipo_Documento_Intero` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Num_Documento_Interno` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Num_Documento_Externo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Tercero_Tipo_Documento` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Tercero_Identificacion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Tercero_DV` varchar(3) COLLATE utf8_spanish_ci NOT NULL,
  `Tercero_Primer_Apellido` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Tercero_Segundo_Apellido` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Tercero_Primer_Nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Tercero_Otros_Nombres` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Tercero_Razon_Social` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Tercero_Direccion` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Tercero_Cod_Dpto` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Tercero_Cod_Mcipio` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Tercero_Pais_Domicilio` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Concepto` varchar(500) COLLATE utf8_spanish_ci NOT NULL,
  `CuentaPUC` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `NombreCuenta` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Detalle` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Debito` double DEFAULT NULL,
  `Credito` double DEFAULT NULL,
  `Neto` double DEFAULT NULL,
  `Mayor` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Esp` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idCentroCosto` int(11) NOT NULL,
  `idEmpresa` int(11) NOT NULL,
  `idSucursal` int(11) NOT NULL,
  `Estado` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idLibroDiario`),
  KEY `Tipo_Documento_Intero` (`Tipo_Documento_Intero`),
  KEY `Tercero_Identificacion` (`Tercero_Identificacion`),
  KEY `Num_Documento_Interno` (`Num_Documento_Interno`),
  KEY `CuentaPUC` (`CuentaPUC`),
  KEY `Fecha` (`Fecha`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `libromayorbalances` (
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


CREATE TABLE `maquinas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `FechaInicio` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `menu` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `idCarpeta` int(11) NOT NULL,
  `Pagina` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `Target` varchar(10) COLLATE utf8_spanish_ci NOT NULL DEFAULT '_SELF',
  `Estado` int(1) NOT NULL DEFAULT '1',
  `Image` text COLLATE utf8_spanish_ci NOT NULL,
  `CSS_Clase` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Orden` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `menu_carpetas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Ruta` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `menu_pestanas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idMenu` int(11) NOT NULL,
  `Orden` int(11) NOT NULL,
  `Estado` bit(1) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `menu_submenus` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `idPestana` int(11) NOT NULL,
  `idCarpeta` int(11) NOT NULL,
  `idMenu` int(11) NOT NULL,
  `TablaAsociada` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `TipoLink` int(1) NOT NULL,
  `JavaScript` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `Pagina` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Target` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Estado` int(1) NOT NULL,
  `Image` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Orden` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `modelos_agenda` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idModelo` int(11) NOT NULL,
  `ValorPagado` double NOT NULL,
  `ValorModelo` double NOT NULL,
  `ValorCasa` double NOT NULL,
  `Minutos` int(11) NOT NULL,
  `HoraInicial` datetime NOT NULL,
  `HoraATerminar` datetime NOT NULL,
  `idCierreModelo` bigint(20) NOT NULL,
  `idCierre` bigint(20) NOT NULL,
  `Estado` varchar(10) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Abierto',
  `Observaciones` text COLLATE utf8_spanish_ci NOT NULL,
  `idUser` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `modelos_cierres` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `idUser` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `modelos_config_factura` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `idItemFactura` bigint(20) NOT NULL,
  `TablaItem` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `modelos_db` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `NombreArtistico` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Identificacion` bigint(20) NOT NULL,
  `Telefono` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `ValorServicio1` double NOT NULL,
  `ValorServicio2` double NOT NULL,
  `ValorServicio3` double NOT NULL,
  `Estado` varchar(1) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'A',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `NombreArtistico` (`NombreArtistico`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `nomina_configuracion_documentos_equivalentes` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Titulo` text COLLATE utf8_spanish_ci NOT NULL,
  `Articulo1` text COLLATE utf8_spanish_ci NOT NULL,
  `Articulo2` text COLLATE utf8_spanish_ci NOT NULL,
  `Articulo3` text COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `nomina_documentos_equivalentes` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Tercero` bigint(20) NOT NULL,
  `Concepto` text COLLATE utf8_spanish_ci NOT NULL,
  `Valor` double NOT NULL,
  `Sucursal` int(11) NOT NULL,
  `Estado` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `nomina_parametros_contables` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `CuentaPUC` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `NombreCuenta` text COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `nomina_parametros_generales` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `Valor` double NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `nomina_servicios_turnos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Tercero` bigint(20) NOT NULL,
  `Sucursal` int(11) NOT NULL,
  `Valor` double NOT NULL,
  `idUser` int(11) NOT NULL,
  `Pagado` int(1) NOT NULL,
  `Estado` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `idDocumentoEquivalente` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `Estado` (`Estado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `notascontables` (
  `ID` int(16) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `FechaProgramada` date NOT NULL,
  `Detalle` text COLLATE utf8_spanish_ci NOT NULL,
  `idProveedor` int(11) NOT NULL,
  `Subtotal` double NOT NULL,
  `IVA` double NOT NULL,
  `Total` double NOT NULL,
  `Soporte` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `NumFactura` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Usuario_idUsuario` int(11) NOT NULL,
  `CentroCostos` int(11) NOT NULL,
  `EmpresaPro` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `notascontables_anulaciones` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `Observaciones` text COLLATE utf8_spanish_ci NOT NULL,
  `idNota` bigint(20) NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `notascredito` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `idFactura` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Concepto` text COLLATE utf8_spanish_ci NOT NULL,
  `Cliente` int(11) NOT NULL,
  `Usuarios_idUsuarios` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `ordenesdecompra` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Tercero` bigint(20) NOT NULL,
  `Descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `PlazoEntrega` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `NoCotizacion` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Condiciones` text COLLATE utf8_spanish_ci NOT NULL,
  `Solicitante` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Cargo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `UsuarioCreador` int(11) NOT NULL,
  `Estado` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `ordenesdecompra_items` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `NumOrden` bigint(20) NOT NULL,
  `idProducto` bigint(20) NOT NULL,
  `Descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `Referencia` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Cantidad` double NOT NULL,
  `ValorUnitario` double NOT NULL,
  `Subtotal` double NOT NULL,
  `IVA` double NOT NULL,
  `Total` double NOT NULL,
  `Tipo_Impuesto` double NOT NULL,
  `Faltante` double NOT NULL,
  `Devuelto` double NOT NULL,
  `Recibido` double NOT NULL,
  `TablaOrigen` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `NumOrden` (`NumOrden`),
  KEY `idProducto` (`idProducto`),
  KEY `NumOrden_2` (`NumOrden`),
  KEY `idProducto_2` (`idProducto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `ordenesdetrabajo` (
  `ID` int(16) NOT NULL AUTO_INCREMENT,
  `FechaOT` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `idCliente` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `DireccionServicio` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `NombreSolicitante` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Telefono` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Ciudad` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `TipoOrden` int(11) NOT NULL,
  `idUsuarioCreador` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Hora` time NOT NULL,
  `Estado` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `ordenesdetrabajo_items` (
  `ID` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idOT` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Actividad` text COLLATE utf8_spanish_ci NOT NULL,
  `FechaInicio` date NOT NULL,
  `FechaFin` date NOT NULL,
  `TiempoEstimadoHoras` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idColaborador` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Estado` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Observaciones` text COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `ordenesdetrabajo_tipo` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Tipo` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `ori_facturas` (
  `idFacturas` varchar(45) CHARACTER SET utf8 NOT NULL,
  `idResolucion` int(11) NOT NULL,
  `TipoFactura` varchar(10) CHARACTER SET utf8 NOT NULL,
  `Prefijo` varchar(45) CHARACTER SET utf8 NOT NULL,
  `NumeroFactura` int(16) NOT NULL,
  `Fecha` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Hora` varchar(20) CHARACTER SET utf8 NOT NULL,
  `OCompra` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `OSalida` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `FormaPago` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Subtotal` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `IVA` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Descuentos` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Total` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `SaldoFact` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Cotizaciones_idCotizaciones` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `EmpresaPro_idEmpresaPro` int(11) NOT NULL,
  `CentroCosto` int(11) NOT NULL,
  `idSucursal` int(11) NOT NULL,
  `Usuarios_idUsuarios` int(11) NOT NULL,
  `Clientes_idClientes` int(11) NOT NULL,
  `TotalCostos` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `CerradoDiario` bigint(20) NOT NULL,
  `FechaCierreDiario` date NOT NULL,
  `HoraCierreDiario` time NOT NULL,
  `ObservacionesFact` text CHARACTER SET utf8 NOT NULL,
  `Efectivo` double NOT NULL,
  `Devuelve` double NOT NULL,
  `Cheques` double NOT NULL,
  `Otros` double NOT NULL,
  `Tarjetas` double NOT NULL,
  `idTarjetas` double NOT NULL,
  `ReporteFacturaElectronica` int(1) NOT NULL COMMENT 'indica si ya fue reportada como factura electronica',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idFacturas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `ori_facturas_items` (
  `ID` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `FechaFactura` date NOT NULL,
  `idFactura` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `TablaItems` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tabla donde se encuentra el producto o servicio',
  `Referencia` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL COMMENT 'Referencia del producto o servicio',
  `Nombre` varchar(500) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `Departamento` int(11) NOT NULL,
  `SubGrupo1` int(11) NOT NULL,
  `SubGrupo2` int(11) NOT NULL,
  `SubGrupo3` int(11) NOT NULL,
  `SubGrupo4` int(11) NOT NULL,
  `SubGrupo5` int(11) NOT NULL,
  `ValorUnitarioItem` int(11) NOT NULL,
  `Cantidad` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `Dias` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `SubtotalItem` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `IVAItem` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `ValorOtrosImpuestos` double NOT NULL,
  `TotalItem` double NOT NULL COMMENT 'Total del valor del Item',
  `PorcentajeIVA` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL COMMENT 'que porcentaje de IVA se le aplico',
  `idOtrosImpuestos` int(11) NOT NULL,
  `idPorcentajeIVA` int(11) NOT NULL,
  `PrecioCostoUnitario` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `SubtotalCosto` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL COMMENT 'Costo total del item',
  `TipoItem` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL COMMENT 'Define si se realiza ajustes a inventarios',
  `CuentaPUC` int(11) NOT NULL COMMENT 'Cuenta donde se llevara el asiento contable ',
  `GeneradoDesde` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tabla que agrega el item',
  `NumeroIdentificador` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL COMMENT 'Identificar del que agrega el item',
  `idUsuarios` int(11) NOT NULL,
  `idCierre` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `idFactura` (`idFactura`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `paginas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `TipoPagina` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Visible` tinyint(1) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `paginas_bloques` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TipoUsuario` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Pagina` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `Habilitado` varchar(2) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'SI',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `parametros_contables` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `CuentaPUC` bigint(20) NOT NULL,
  `NombreCuenta` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `parametros_generales` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `KardexCotizacion` bit(1) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `plataforma_tablas` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `porcentajes_iva` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Valor` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `ClaseImpuesto` varchar(2) COLLATE utf8_spanish_ci NOT NULL DEFAULT '01' COMMENT '01 para IVA, 02 impoconsumo, 03 ICA',
  `Factor` varchar(10) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'M',
  `CuentaPUC` bigint(20) NOT NULL,
  `CuentaPUCIVAGenerado` bigint(20) NOT NULL,
  `NombreCuenta` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Habilitado` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `precotizacion` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `NumSolicitud` varchar(45) NOT NULL,
  `Cantidad` double NOT NULL,
  `Multiplicador` int(11) NOT NULL DEFAULT '1',
  `Referencia` varchar(45) NOT NULL,
  `ValorUnitario` double NOT NULL,
  `SubTotal` double NOT NULL,
  `Descripcion` text NOT NULL,
  `IVA` double NOT NULL,
  `Descuento` double NOT NULL,
  `ValorDescuento` double NOT NULL,
  `PrecioCosto` double NOT NULL,
  `SubtotalCosto` double NOT NULL,
  `Total` double NOT NULL,
  `TipoItem` varchar(10) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `CuentaPUC` varchar(45) NOT NULL,
  `Tabla` varchar(45) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `preventa` (
  `idPrecotizacion` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Fecha` date DEFAULT NULL,
  `Cantidad` double NOT NULL,
  `VestasActivas_idVestasActivas` int(11) NOT NULL,
  `idFacturas` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `ProductosVenta_idProductosVenta` bigint(20) NOT NULL,
  `TablaItem` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `ValorUnitario` double NOT NULL,
  `Subtotal` double NOT NULL,
  `ValorAcordado` double NOT NULL,
  `CostoUnitario` double NOT NULL,
  `PrecioMayorista` double NOT NULL,
  `Descuento` double NOT NULL,
  `Impuestos` double NOT NULL,
  `PorcentajeIVA` double NOT NULL,
  `TotalVenta` double NOT NULL,
  `TipoItem` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `idSistema` int(11) NOT NULL,
  `Autorizado` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idPrecotizacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `produccion_actividades` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idOrdenTrabajo` bigint(20) NOT NULL,
  `Fecha_Planeada_Inicio` date NOT NULL,
  `Fecha_Planeada_Fin` date NOT NULL,
  `Hora_Planeada_Inicio` time NOT NULL,
  `Hora_Planeada_Fin` time NOT NULL,
  `Fecha_Inicio` date NOT NULL,
  `Fecha_Fin` date NOT NULL,
  `Hora_Inicio` time NOT NULL,
  `Hora_Fin` time NOT NULL,
  `Descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `Observaciones` text COLLATE utf8_spanish_ci NOT NULL,
  `idMaquina` int(11) NOT NULL,
  `idColaborador` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Tiempo_Operacion` float NOT NULL,
  `Pausas_Operativas` float NOT NULL,
  `Pausas_No_Operativas` float NOT NULL,
  `Estado` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `produccion_horas_cronograma` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Hora` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `produccion_ordenes_trabajo` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Compromiso_Entrega` date NOT NULL,
  `FechaTerminacion` date NOT NULL,
  `Descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `TotalHorasPlaneadas` float NOT NULL,
  `TotalHorasEmpleadas` float NOT NULL,
  `Pausas_Operativas` float NOT NULL,
  `Pausas_No_Operativas` float NOT NULL,
  `Tiempo_Operacion` float NOT NULL,
  `ValorSugerido` bigint(20) NOT NULL,
  `ValorMateriales` bigint(20) NOT NULL,
  `ValorCotizado` bigint(20) NOT NULL,
  `ValorFacturado` bigint(20) NOT NULL,
  `Estado` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idCliente` int(11) NOT NULL,
  `Facturado` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `NumFactura` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `produccion_pausas_predefinidas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `Observaciones` text COLLATE utf8_spanish_ci NOT NULL,
  `Suma` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `produccion_registro_tiempos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idActividad` bigint(20) NOT NULL,
  `FechaHora` datetime NOT NULL,
  `Estado` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Suma` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `productosalquiler` (
  `idProductosVenta` int(11) NOT NULL AUTO_INCREMENT,
  `Referencia` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Nombre` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Existencias` int(11) NOT NULL,
  `EnAlquiler` int(11) NOT NULL,
  `EnBodega` int(11) NOT NULL,
  `PrecioVenta` double NOT NULL,
  `PrecioMayorista` double NOT NULL,
  `CostoUnitario` double NOT NULL,
  `IVA` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Departamento` int(11) NOT NULL,
  `CuentaPUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `ImagenRuta` text COLLATE utf8_spanish_ci NOT NULL,
  `PesoUnitario` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `PesoTotal` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `CostoUnitarioActivo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub1` int(11) NOT NULL,
  `Sub2` int(11) NOT NULL,
  `Sub3` int(11) NOT NULL,
  `Sub4` int(11) NOT NULL,
  `Sub5` int(11) NOT NULL,
  `Kit` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idProductosVenta`),
  UNIQUE KEY `Referencia` (`Referencia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `productosventa` (
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
  `Sub6` int(11) NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DELIMITER ;;

CREATE TRIGGER `insKardex` AFTER INSERT ON `productosventa` FOR EACH ROW
BEGIN

SET @fecha=CURDATE();
    INSERT INTO kardexmercancias (`Fecha`, `Movimiento`, `Detalle`, `Cantidad`,`ValorUnitario`, `ValorTotal`, `ProductosVenta_idProductosVenta`) VALUES (@fecha,'ENTRADA','INICIO',NEW.Existencias,NEW.CostoUnitario,NEW.CostoTotal,NEW.idProductosVenta);
    
    INSERT INTO kardexmercancias (`Fecha`, `Movimiento`, `Detalle`, `Cantidad`,`ValorUnitario`, `ValorTotal`, `ProductosVenta_idProductosVenta`) VALUES (@fecha,'SALDOS','INICIO',NEW.Existencias,NEW.CostoUnitario,NEW.CostoTotal,NEW.idProductosVenta);

SET @Dep=LPAD(NEW.Departamento,2,'0');

SET @Sub1=LPAD(NEW.Sub1,2,'0');

SET @id=LPAD(NEW.idProductosVenta,7,'0');
    
    
SET @Codigo=CONCAT(@Dep,@Sub1,@id);

INSERT INTO prod_codbarras (`CodigoBarras`,`ProductosVenta_idProductosVenta`) VALUES (@Codigo,NEW.idProductosVenta);

END;;

DELIMITER ;

CREATE TABLE `productosventa_bodega_1` (
  `idProductosVenta` bigint(20) NOT NULL AUTO_INCREMENT,
  `CodigoBarras` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Referencia` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Nombre` varchar(70) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Existencias` double DEFAULT '0',
  `PrecioVenta` double DEFAULT NULL,
  `PrecioMayorista` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `CostoUnitario` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `CostoTotal` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
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
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idProductosVenta`),
  UNIQUE KEY `Referencia` (`Referencia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `productosventa_bodega_2` (
  `idProductosVenta` bigint(20) NOT NULL AUTO_INCREMENT,
  `CodigoBarras` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Referencia` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Nombre` varchar(70) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Existencias` double DEFAULT '0',
  `PrecioVenta` double DEFAULT NULL,
  `PrecioMayorista` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `CostoUnitario` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `CostoTotal` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
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
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idProductosVenta`),
  UNIQUE KEY `Referencia` (`Referencia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `productosventa_bodega_3` (
  `idProductosVenta` bigint(20) NOT NULL AUTO_INCREMENT,
  `CodigoBarras` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Referencia` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Nombre` varchar(70) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Existencias` double DEFAULT '0',
  `PrecioVenta` double DEFAULT NULL,
  `PrecioMayorista` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `CostoUnitario` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `CostoTotal` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
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
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idProductosVenta`),
  UNIQUE KEY `Referencia` (`Referencia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `productosventa_bodega_4` (
  `idProductosVenta` bigint(20) NOT NULL AUTO_INCREMENT,
  `CodigoBarras` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Referencia` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Nombre` varchar(70) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Existencias` double DEFAULT '0',
  `PrecioVenta` double DEFAULT NULL,
  `PrecioMayorista` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `CostoUnitario` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `CostoTotal` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
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
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idProductosVenta`),
  UNIQUE KEY `Referencia` (`Referencia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `productosventa_bodega_5` (
  `idProductosVenta` bigint(20) NOT NULL AUTO_INCREMENT,
  `CodigoBarras` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Referencia` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Nombre` varchar(70) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Existencias` double DEFAULT '0',
  `PrecioVenta` double DEFAULT NULL,
  `PrecioMayorista` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `CostoUnitario` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `CostoTotal` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
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
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idProductosVenta`),
  UNIQUE KEY `Referencia` (`Referencia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `productos_impuestos_adicionales` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NombreImpuesto` text COLLATE utf8_spanish_ci NOT NULL,
  `idProducto` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `ValorImpuesto` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `CuentaPUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `NombreCuenta` text COLLATE utf8_spanish_ci NOT NULL,
  `Incluido` enum('SI','NO') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'NO',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `productos_lista_precios` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `productos_precios_adicionales` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idProducto` bigint(20) NOT NULL,
  `idListaPrecios` int(11) NOT NULL,
  `PrecioVenta` double NOT NULL,
  `TablaVenta` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci COMMENT='tabla para agregar precios a los productos';


CREATE TABLE `prod_bajas_altas` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Movimiento` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Fecha` date NOT NULL,
  `Departamento` int(11) NOT NULL,
  `Referencia` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Nombre` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Cantidad` double NOT NULL,
  `CostoTotal` double NOT NULL,
  `Observaciones` text COLLATE utf8_spanish_ci NOT NULL,
  `Usuarios_idUsuarios` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `prod_bodega` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `idProductoAlquiler` int(11) NOT NULL,
  `Bodega_idCliente` int(11) NOT NULL,
  `CantidadProd` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `prod_codbarras` (
  `idCodBarras` bigint(20) NOT NULL AUTO_INCREMENT,
  `ProductosVenta_idProductosVenta` bigint(20) NOT NULL,
  `CodigoBarras` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `TablaOrigen` varchar(90) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'productosventa',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idCodBarras`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `prod_codbarras_bodega_1` (
  `idCodBarras` bigint(20) NOT NULL AUTO_INCREMENT,
  `ProductosVenta_idProductosVenta` bigint(20) NOT NULL,
  `CodigoBarras` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idCodBarras`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `prod_codbarras_bodega_2` (
  `idCodBarras` bigint(20) NOT NULL AUTO_INCREMENT,
  `ProductosVenta_idProductosVenta` bigint(20) NOT NULL,
  `CodigoBarras` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idCodBarras`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `prod_codbarras_bodega_3` (
  `idCodBarras` bigint(20) NOT NULL AUTO_INCREMENT,
  `ProductosVenta_idProductosVenta` bigint(20) NOT NULL,
  `CodigoBarras` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idCodBarras`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `prod_codbarras_bodega_4` (
  `idCodBarras` bigint(20) NOT NULL AUTO_INCREMENT,
  `ProductosVenta_idProductosVenta` bigint(20) NOT NULL,
  `CodigoBarras` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idCodBarras`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `prod_codbarras_bodega_5` (
  `idCodBarras` bigint(20) NOT NULL AUTO_INCREMENT,
  `ProductosVenta_idProductosVenta` bigint(20) NOT NULL,
  `CodigoBarras` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idCodBarras`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `prod_comisiones` (
  `idProd_Comisiones` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre_Comision` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `P_V` int(2) NOT NULL COMMENT '1 Valor 0 Porcentaje',
  `ValorComision1` double NOT NULL,
  `ValorComision2` double NOT NULL,
  `ValorComision3` double NOT NULL,
  `Porcentaje_Comision` double NOT NULL,
  `Dep_Comision` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idProd_Comisiones`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `prod_departamentos` (
  `idDepartamentos` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `TablaOrigen` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `TipoItem` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `ManejaExistencias` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idDepartamentos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `prod_kits` (
  `idKits` int(11) NOT NULL AUTO_INCREMENT,
  `TablaProducto` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `ReferenciaProducto` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Cantidad` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idKits`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `prod_sinc` (
  `Referencia` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Departamento` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Nombre` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `PrecioVenta` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `PrecioMayorista` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DELIMITER ;;

CREATE TRIGGER `Productos_Sinc` AFTER INSERT ON `prod_sinc` FOR EACH ROW
BEGIN

UPDATE productosventa SET PrecioVenta=NEW.PrecioVenta WHERE Referencia=NEW.Referencia AND Departamento=NEW.Departamento;

UPDATE productosventa SET PrecioMayorista=NEW.PrecioMayorista WHERE Referencia=NEW.Referencia AND Departamento=NEW.Departamento;

END;;

DELIMITER ;

CREATE TABLE `prod_sub1` (
  `idSub1` int(11) NOT NULL AUTO_INCREMENT,
  `NombreSub1` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idDepartamento` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idSub1`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `prod_sub2` (
  `idSub2` int(11) NOT NULL AUTO_INCREMENT,
  `NombreSub2` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idSub1` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idSub2`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `prod_sub3` (
  `idSub3` int(11) NOT NULL AUTO_INCREMENT,
  `NombreSub3` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idSub2` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idSub3`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `prod_sub4` (
  `idSub4` int(11) NOT NULL AUTO_INCREMENT,
  `NombreSub4` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idSub3` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idSub4`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `prod_sub5` (
  `idSub5` int(11) NOT NULL AUTO_INCREMENT,
  `NombreSub5` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idSub4` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idSub5`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `prod_sub6` (
  `idSub6` int(11) NOT NULL AUTO_INCREMENT,
  `NombreSub6` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idSub5` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idSub6`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `proveedores` (
  `idProveedores` int(11) NOT NULL AUTO_INCREMENT,
  `Tipo_Documento` int(11) NOT NULL,
  `Num_Identificacion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `DV` varchar(5) COLLATE utf8_spanish_ci NOT NULL,
  `Lugar_Expedicion_Documento` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `Primer_Apellido` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Segundo_Apellido` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Primer_Nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Otros_Nombres` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `RazonSocial` varchar(300) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Direccion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Cod_Dpto` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Cod_Mcipio` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Pais_Domicilio` varchar(10) COLLATE utf8_spanish_ci NOT NULL DEFAULT '169',
  `Telefono` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Ciudad` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Contacto` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `TelContacto` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Email` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `CuentaBancaria` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `A_Nombre_De` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `TipoCuenta` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `EntidadBancaria` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `CIUU` int(11) NOT NULL,
  `Cupo` double NOT NULL,
  `Soporte` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idProveedores`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `publicidad_encabezado_cartel` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Titulo` text COLLATE utf8_spanish_ci NOT NULL,
  `ColorTitulo` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Desde` int(11) NOT NULL,
  `Hasta` int(11) NOT NULL,
  `Mes` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Anio` int(11) NOT NULL,
  `ColorRazonSocial` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `ColorPrecios` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `ColorBordes` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `publicidad_paginas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `idProducto` bigint(20) NOT NULL,
  `Observaciones` text COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `recetas_relaciones` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `ReferenciaProducto` varchar(100) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Referencia del producto que se realiza con receta',
  `ReferenciaIngrediente` varchar(100) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Referencia del producto o servicio que hace parte de la receta',
  `TablaIngrediente` varchar(100) COLLATE utf8_spanish_ci NOT NULL COMMENT 'tabla del producto de la receta',
  `Cantidad` double NOT NULL COMMENT 'Cantidad del insumo para crear un producto',
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `ReferenciaProducto` (`ReferenciaProducto`),
  KEY `ReferenciaIngrediente` (`ReferenciaIngrediente`),
  KEY `TablaIngrediente` (`TablaIngrediente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `registra_apertura_documentos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Documento` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `NumDocumento` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `ConceptoApertura` text COLLATE utf8_spanish_ci NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `registra_ediciones` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `Tabla` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Campo` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `ValorAnterior` text COLLATE utf8_spanish_ci NOT NULL,
  `ValorNuevo` text COLLATE utf8_spanish_ci NOT NULL,
  `ConsultaRealizada` text COLLATE utf8_spanish_ci NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `registra_eliminaciones` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `Campo` text COLLATE utf8_spanish_ci NOT NULL,
  `Valor` text COLLATE utf8_spanish_ci NOT NULL,
  `Causal` text COLLATE utf8_spanish_ci NOT NULL,
  `TablaOrigen` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `idTabla` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idItemEliminado` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `TablaOrigen` (`TablaOrigen`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `registra_eliminaciones_pedidos_items_restaurant` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idProducto` bigint(20) NOT NULL,
  `Cantidad` double NOT NULL,
  `Total` double NOT NULL,
  `idPedido` bigint(20) NOT NULL,
  `idUser` int(11) NOT NULL,
  `Observaciones` text COLLATE utf8_spanish_ci NOT NULL,
  `FechaHora` datetime NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `idPedido` (`idPedido`),
  KEY `idProducto` (`idProducto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `registro_autorizaciones_pos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` datetime NOT NULL,
  `idProducto` bigint(20) NOT NULL,
  `TablaItem` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `ValorUnitario` double NOT NULL,
  `ValorAcordado` double NOT NULL,
  `Cantidad` double NOT NULL,
  `PorcentajeIVA` double NOT NULL,
  `Total` double NOT NULL,
  `idFactura` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idUser` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `registro_basculas` (
  `Gramos` double NOT NULL,
  `idBascula` int(11) NOT NULL,
  `Leido` bit(1) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  UNIQUE KEY `idBascula` (`idBascula`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `relacioncompras` (
  `idRelacionCompras` int(11) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Documento` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `NumDocumento` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idProveedor` int(11) NOT NULL,
  `Cantidad` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `ValorUnitarioAntesIVA` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `TotalAntesIVA` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `ProductosVenta_idProductosVenta` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idRelacionCompras`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DELIMITER ;;

CREATE TRIGGER `KardexCompras` AFTER INSERT ON `relacioncompras` FOR EACH ROW
BEGIN


SELECT Existencias into @Cantidad FROM productosventa WHERE idProductosVenta=NEW.ProductosVenta_idProductosVenta;


SET @Saldo=@Cantidad+NEW.Cantidad;

SET @PrecioPromedio=NEW.TotalAntesIVA;
          
SET @TotalSaldo=NEW.ValorUnitarioAntesIVA*@Saldo;

    
 INSERT INTO kardexmercancias (`Fecha`, `Movimiento`, `Detalle`,`idDocumento`, `Cantidad`,`ValorUnitario`, `ValorTotal`, `ProductosVenta_idProductosVenta`) VALUES (NEW.Fecha,'ENTRADA',NEW.Documento,NEW.NumDocumento,NEW.Cantidad,NEW.ValorUnitarioAntesIVA,NEW.TotalAntesIVA,NEW.ProductosVenta_idProductosVenta);
    

INSERT INTO kardexmercancias (`Fecha`, `Movimiento`, `Detalle`,`idDocumento`, `Cantidad`,`ValorUnitario`, `ValorTotal`, `ProductosVenta_idProductosVenta`) VALUES (NEW.Fecha,'SALDOS',NEW.Documento,NEW.NumDocumento,@Saldo,NEW.ValorUnitarioAntesIVA,@TotalSaldo,NEW.ProductosVenta_idProductosVenta);

SELECT Existencias into @Saldoext FROM productosventa WHERE idProductosVenta = NEW.ProductosVenta_idProductosVenta;

SET @Saldoext=@Saldoext+NEW.Cantidad;

UPDATE productosventa SET `Existencias`= @Saldoext WHERE idProductosVenta = NEW.ProductosVenta_idProductosVenta;

UPDATE productosventa SET `CostoUnitario`= NEW.ValorUnitarioAntesIVA WHERE idProductosVenta = NEW.ProductosVenta_idProductosVenta;

UPDATE productosventa SET `CostoTotal`= @TotalSaldo WHERE idProductosVenta = NEW.ProductosVenta_idProductosVenta;


END;;

DELIMITER ;

CREATE TABLE `remisiones` (
  `ID` int(16) NOT NULL AUTO_INCREMENT,
  `Fecha` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Clientes_idClientes` int(11) NOT NULL,
  `Cotizaciones_idCotizaciones` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Obra` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Direccion` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Ciudad` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Telefono` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Retira` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `FechaDespacho` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `HoraDespacho` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `ObservacionesRemision` text COLLATE utf8_spanish_ci NOT NULL,
  `Anticipo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Dias` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Estado` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `CentroCosto` int(11) NOT NULL,
  `Usuarios_idUsuarios` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `rem_devoluciones` (
  `ID` int(16) NOT NULL AUTO_INCREMENT,
  `idRemision` int(16) NOT NULL,
  `idItemCotizacion` int(16) NOT NULL,
  `Cantidad` int(16) NOT NULL,
  `ValorUnitario` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Subtotal` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Dias` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Total` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `NumDevolucion` int(16) NOT NULL,
  `FechaDevolucion` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `HoraDevolucion` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Usuarios_idUsuarios` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `rem_devoluciones_totalizadas` (
  `ID` int(16) NOT NULL AUTO_INCREMENT,
  `FechaDevolucion` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `HoraDevolucion` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idRemision` int(16) NOT NULL,
  `TotalDevolucion` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `ObservacionesDevolucion` text COLLATE utf8_spanish_ci NOT NULL,
  `Usuarios_idUsuarios` int(16) NOT NULL,
  `Clientes_idClientes` int(16) NOT NULL,
  `Facturas_idFacturas` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `rem_pre_devoluciones` (
  `ID` int(16) NOT NULL AUTO_INCREMENT,
  `idRemision` int(16) NOT NULL,
  `idItemCotizacion` int(16) NOT NULL,
  `Cantidad` int(16) NOT NULL,
  `ValorUnitario` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Subtotal` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Dias` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Total` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Usuarios_idUsuarios` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `ID` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `rem_relaciones` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `FechaEntrega` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `CantidadEntregada` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Multiplicador` int(11) NOT NULL,
  `idItemCotizacion` int(11) NOT NULL,
  `idRemision` int(11) NOT NULL,
  `Usuarios_idUsuarios` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `repuestas_forma_pago` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `DiasCartera` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Etiqueta` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `requerimientos_proyectos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `Descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `idCliente` int(11) NOT NULL,
  `Estado` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `HorasDesarrollo` double NOT NULL,
  `CostoEstimado` double NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `reservas_espacios` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `HoraInicial` int(11) NOT NULL,
  `HoraFinal` int(11) NOT NULL,
  `TarifaNormal` double NOT NULL,
  `TarifaMinima` double NOT NULL,
  `TarifaNormal2` double NOT NULL,
  `idProductoRelacionado` bigint(20) NOT NULL COMMENT 'Indica el producto que esta relacionado al momento de realizar una factura',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `reservas_eventos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idEspacio` int(11) NOT NULL,
  `NombreEvento` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `FechaInicio` datetime NOT NULL,
  `FechaFin` datetime NOT NULL,
  `idCliente` bigint(20) NOT NULL,
  `Telefono` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Observaciones` text COLLATE utf8_spanish_ci NOT NULL,
  `Tarifa` double NOT NULL,
  `Estado` enum('RE','FA','AN') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'RE' COMMENT 'FA:Facturado,RE:Reservado,AN:Anulado',
  `idFactura` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idUser` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `FechaInicio` (`FechaInicio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `respuestas_condicional` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Valor` varchar(4) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `respuestas_tipo_item` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Valor` varchar(4) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `restaurante_cierres` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `restaurante_mesas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Capacidad` int(11) NOT NULL,
  `Estado` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `restaurante_pedidos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `idMesa` int(11) NOT NULL,
  `Estado` varchar(4) COLLATE utf8_spanish_ci NOT NULL COMMENT '''AB'' Abierto,''FAPE'' pedido facturado, ''FADO'' domicilio facturado, ''DEPE'' pedido descartado, ''DEDO'' domicilios descartados',
  `Tipo` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `idCliente` bigint(20) NOT NULL,
  `NombreCliente` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `DireccionEnvio` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `TelefonoConfirmacion` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Observaciones` text COLLATE utf8_spanish_ci NOT NULL,
  `idCierre` bigint(20) NOT NULL,
  `FechaCreacion` datetime NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `restaurante_pedidos_items` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `idPedido` bigint(20) NOT NULL,
  `idProducto` bigint(20) NOT NULL,
  `NombreProducto` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `ValorUnitario` double NOT NULL,
  `Subtotal` double NOT NULL,
  `IVA` double NOT NULL,
  `Total` double NOT NULL,
  `Observaciones` text COLLATE utf8_spanish_ci NOT NULL,
  `Estado` varchar(8) COLLATE utf8_spanish_ci NOT NULL,
  `ProcentajeIVA` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Departamento` int(11) NOT NULL,
  `Sub1` int(11) NOT NULL,
  `Sub2` int(11) NOT NULL,
  `Sub3` int(11) NOT NULL,
  `Sub4` int(11) NOT NULL,
  `Sub5` int(11) NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `idCierre` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `idPedido` (`idPedido`),
  KEY `Estado` (`Estado`),
  KEY `Estado_2` (`Estado`),
  KEY `Estado_3` (`Estado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `restaurante_registro_propinas` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `idFactura` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idColaborador` int(11) NOT NULL,
  `Efectivo` double NOT NULL,
  `Tarjetas` double NOT NULL,
  `idCierre` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `salud_rips_pagos_validados` (
  `id_rips_pagos_validados` int(20) NOT NULL,
  `cod_prest_servicio` bigint(12) NOT NULL COMMENT 'Código del prestador de servicios de salud " Ver Alineamientos tecnicos para ips ver pag 12"',
  `razon_social` varchar(60) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Razón social o apellidos y nombre del prestado " Ver Alineamientos tecnicos para ips ver pag 12"',
  `tipo_ident_prest_servicio` enum('NI','CC','CE','PA') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de identificación del prestador de servicios de salud " Ver Alineamientos tecnicos para ips ver pag 12"',
  `num_ident_prest_servicio` bigint(20) NOT NULL COMMENT 'Número de identificación del prestador de servicios de salud " Ver Alineamientos tecnicos para ips ver pag 12"',
  `num_factura` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Número de la factura " Ver Alineamientos tecnicos para ips ver pag 12"',
  `fecha_factura` date NOT NULL COMMENT 'Fecha de expedición de la factura " Ver Alineamientos tecnicos para ips ver pag 13"',
  `fecha_inicio` date NOT NULL COMMENT 'Fecha de inicio " Ver Alineamientos tecnicos para ips ver pag 13"',
  `fecha_final` date NOT NULL COMMENT 'Fecha final " Ver Alineamientos tecnicos para ips ver pag 13"',
  `cod_enti_administradora` varchar(6) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Código entidad administradora " Ver Alineamientos tecnicos para ips ver pag 13"',
  `nom_enti_administradora` varchar(30) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre entidad administradora " Ver Alineamientos tecnicos para ips ver pag 13" ',
  `num_contrato` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Número del contrato " Ver Alineamientos tecnicos para ips ver pag 13"',
  `plan_beneficios` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Plan de beneficios " Ver Alineamientos tecnicos para ips ver pag 13"',
  `num_poliza` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Número de la póliza " Ver Alineamientos tecnicos para ips ver pag 13" ',
  `valor_total_pago` double(15,2) NOT NULL COMMENT 'Valor total del pago compartido copago " Ver Alineamientos tecnicos para ips ver pag 14"',
  `valor_comision` double(15,2) NOT NULL COMMENT 'Valor de la comisión " Ver Alineamientos tecnicos para ips ver pag 14"',
  `valor_descuentos` double(15,2) NOT NULL COMMENT 'Valor total de descuentos " Ver Alineamientos tecnicos para ips ver pag 14"',
  `valor_neto_pagar` double(15,2) NOT NULL COMMENT 'Valor neto a pagar por la entidad contratante " Ver Alineamientos tecnicos para ips ver pag 14"',
  `valor_pagado` double(15,2) DEFAULT NULL COMMENT 'Valor que la eps pago',
  `valor_diferencia` double(15,2) DEFAULT NULL COMMENT 'Valor de la diferencia del valor neto a pagar y el valor pagado',
  `fecha_pago` date DEFAULT NULL COMMENT 'Fecha de pago del ultimo abono',
  `num_comprobante` int(15) DEFAULT NULL COMMENT 'Numero de comprobante del ultimo abono',
  `eps_radicacion` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Eps en la que se radico la factura',
  `dias_pactados` int(2) DEFAULT NULL COMMENT 'Dias que se pactaron para el pago de la factura con eps',
  `fecha_radicado` date DEFAULT NULL COMMENT 'Fecha de la radicacion de la factura',
  `numero_radicado` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Numero con que se radico la factura',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_rips_pagos_validados`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Archivo de pagos validados';


CREATE TABLE `salud_rips_vencidos` (
  `id_rips_vencidos` int(20) NOT NULL,
  `cod_prest_servicio` bigint(12) NOT NULL COMMENT 'Código del prestador de servicios de salud " Ver Alineamientos tecnicos para ips ver pag 12"',
  `razon_social` varchar(60) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Razón social o apellidos y nombre del prestado " Ver Alineamientos tecnicos para ips ver pag 12"',
  `tipo_ident_prest_servicio` enum('NI','CC','CE','PA') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de identificación del prestador de servicios de salud " Ver Alineamientos tecnicos para ips ver pag 12"',
  `num_ident_prest_servicio` bigint(20) NOT NULL COMMENT 'Número de identificación del prestador de servicios de salud " Ver Alineamientos tecnicos para ips ver pag 12"',
  `num_factura` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Número de la factura " Ver Alineamientos tecnicos para ips ver pag 12"',
  `fecha_factura` date NOT NULL COMMENT 'Fecha de expedición de la factura " Ver Alineamientos tecnicos para ips ver pag 13"',
  `fecha_inicio` date NOT NULL COMMENT 'Fecha de inicio " Ver Alineamientos tecnicos para ips ver pag 13"',
  `fecha_final` date NOT NULL COMMENT 'Fecha final " Ver Alineamientos tecnicos para ips ver pag 13"',
  `cod_enti_administradora` varchar(6) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Código entidad administradora " Ver Alineamientos tecnicos para ips ver pag 13"',
  `nom_enti_administradora` varchar(30) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre entidad administradora " Ver Alineamientos tecnicos para ips ver pag 13" ',
  `num_contrato` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Número del contrato " Ver Alineamientos tecnicos para ips ver pag 13"',
  `plan_beneficios` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Plan de beneficios " Ver Alineamientos tecnicos para ips ver pag 13"',
  `num_poliza` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Número de la póliza " Ver Alineamientos tecnicos para ips ver pag 13" ',
  `valor_total_pago` double(15,2) NOT NULL COMMENT 'Valor total del pago compartido copago " Ver Alineamientos tecnicos para ips ver pag 14"',
  `valor_comision` double(15,2) NOT NULL COMMENT 'Valor de la comisión " Ver Alineamientos tecnicos para ips ver pag 14"',
  `valor_descuentos` double(15,2) NOT NULL COMMENT 'Valor total de descuentos " Ver Alineamientos tecnicos para ips ver pag 14"',
  `valor_neto_pagar` double(15,2) NOT NULL COMMENT 'Valor neto a pagar por la entidad contratante " Ver Alineamientos tecnicos para ips ver pag 14"',
  `nom_cargue` varchar(8) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre con el que se hizo el cargue al sistema de cartera',
  `fecha_cargue` datetime NOT NULL COMMENT 'Fecha Y Hora que se hizo el cargue',
  `eps_radicacion` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Eps en la que se radico la factura',
  `dias_pactados` int(2) DEFAULT NULL COMMENT 'Dias que se pactaron para el pago de la factura con eps',
  `fecha_radicado` date DEFAULT NULL COMMENT 'Fecha de la radicacion de la factura',
  `numero_radicado` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Numero con que se radico la factura',
  `fecha_vencimiento` date NOT NULL COMMENT 'Fecha de vencimiento de la facrura ',
  `fecha_ult_validacion` datetime DEFAULT NULL COMMENT 'Fecha de ultima validacion',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_rips_vencidos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='archivos de rips vencidos';


CREATE TABLE `salud_tesoreria` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
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
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Archivo de tesoreria';


CREATE TABLE `salud_tipo_glosas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TipoGlosa` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `salud_upload_control` (
  `id_upload_control` bigint(20) NOT NULL AUTO_INCREMENT,
  `nom_cargue` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_cargue` datetime NOT NULL,
  `idUser` int(11) NOT NULL,
  `Analizado` bit(1) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_upload_control`),
  KEY `nom_cargue` (`nom_cargue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `separados` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `idCliente` int(11) NOT NULL,
  `Total` int(11) NOT NULL,
  `Saldo` int(11) NOT NULL,
  `Estado` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Observaciones` text COLLATE utf8_spanish_ci NOT NULL,
  `idUsuarios` int(11) NOT NULL,
  `idSucursal` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `separados_abonos` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `idSeparado` bigint(20) unsigned NOT NULL,
  `Valor` double NOT NULL,
  `idCliente` int(11) NOT NULL,
  `idUsuarios` int(11) NOT NULL,
  `idComprobanteIngreso` bigint(20) NOT NULL,
  `idCierre` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `separados_items` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `idSeparado` bigint(20) NOT NULL,
  `TablaItems` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Referencia` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Nombre` text COLLATE utf8_spanish_ci NOT NULL,
  `Departamento` int(11) NOT NULL,
  `SubGrupo1` int(11) NOT NULL,
  `SubGrupo2` int(11) NOT NULL,
  `SubGrupo3` int(11) NOT NULL,
  `SubGrupo4` int(11) NOT NULL,
  `SubGrupo5` int(11) NOT NULL,
  `ValorUnitarioItem` int(11) NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `SubtotalItem` int(11) NOT NULL,
  `IVAItem` int(11) NOT NULL,
  `TotalItem` int(11) NOT NULL,
  `PorcentajeIVA` varchar(5) COLLATE utf8_spanish_ci NOT NULL,
  `PrecioCostoUnitario` int(11) NOT NULL,
  `SubtotalCosto` int(11) NOT NULL,
  `TipoItem` varchar(5) COLLATE utf8_spanish_ci NOT NULL,
  `CuentaPUC` int(11) NOT NULL,
  `GeneradoDesde` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `NumeroIdentificador` int(11) NOT NULL,
  `Multiplicador` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `servicios` (
  `idProductosVenta` int(16) NOT NULL AUTO_INCREMENT,
  `Referencia` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Nombre` varchar(1000) COLLATE utf8_spanish_ci NOT NULL,
  `PrecioVenta` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `PrecioMayorista` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `CostoUnitario` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `IVA` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Departamento` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `ImagenRuta` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `CuentaPUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub1` int(11) NOT NULL,
  `Sub2` int(11) NOT NULL,
  `Sub3` int(11) NOT NULL,
  `Sub4` int(11) NOT NULL,
  `Sub5` int(11) NOT NULL,
  `Kit` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idProductosVenta`),
  UNIQUE KEY `Referencia` (`Referencia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `servidores` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `IP` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Usuario` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Password` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `DataBase` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `sistemas` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Nombre` text COLLATE utf8_spanish_ci NOT NULL,
  `RutaImagen` text COLLATE utf8_spanish_ci NOT NULL,
  `Observaciones` text COLLATE utf8_spanish_ci NOT NULL,
  `Estado` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `sistemas_relaciones` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `TablaOrigen` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `Referencia` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Cantidad` double NOT NULL,
  `ValorUnitario` double NOT NULL,
  `idSistema` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `subcuentas` (
  `PUC` int(11) NOT NULL,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Valor` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Cuentas_idPUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`PUC`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `subcuentas_equivalencias_niif` (
  `CuentaNIIF` int(11) NOT NULL,
  `NombreCuentaNIIF` int(11) NOT NULL,
  `Equivale_A` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`CuentaNIIF`),
  UNIQUE KEY `Equivale_A` (`Equivale_A`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `tablas_campos_control` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `NombreTabla` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Campo` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Visible` int(1) NOT NULL,
  `Editable` int(1) NOT NULL,
  `Habilitado` int(1) NOT NULL,
  `TipoUser` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `tablas_ventas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NombreTabla` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idTabla` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `TipoVenta` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `IVAIncluido` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `CuentaPUCDefecto` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `tarjetas_forma_pago` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Tipo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `PorcentajeComision` float NOT NULL,
  `CuentaPUC` bigint(20) NOT NULL,
  `NombreCuenta` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `terceros_cuentas_cobro` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Tercero` bigint(20) NOT NULL,
  `idConceptoContable` int(11) NOT NULL COMMENT 'relacion que mostrara el concepto y movimientos contables a realizar viene de la tabla conceptos',
  `Valor` double NOT NULL,
  `Observaciones` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `idUser` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci COMMENT='Tabla para realizar cuentas de cobro por parte de terceros';


CREATE TABLE `tiposretenciones` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `CuentaPasivo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `NombreCuentaPasivo` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `CuentaActivo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `NombreCuentaActivo` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `titulos_abonos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `idVenta` bigint(20) NOT NULL,
  `Monto` double NOT NULL,
  `idColaborador` bigint(20) NOT NULL,
  `NombreColaborador` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `idComprobanteIngreso` bigint(20) NOT NULL,
  `Observaciones` text COLLATE utf8_spanish_ci NOT NULL,
  `Estado` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `titulos_asignaciones` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Promocion` int(11) NOT NULL,
  `Desde` int(11) NOT NULL,
  `Hasta` int(11) NOT NULL,
  `idColaborador` bigint(20) NOT NULL,
  `NombreColaborador` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `Observaciones` text COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `titulos_comisiones` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `idVenta` bigint(20) NOT NULL,
  `Monto` double NOT NULL,
  `idColaborador` bigint(20) NOT NULL,
  `NombreColaborador` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `idEgreso` bigint(20) NOT NULL,
  `Observaciones` text COLLATE utf8_spanish_ci NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `titulos_cuentasxcobrar` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `FechaIngreso` date NOT NULL,
  `Origen` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idDocumento` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idTercero` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `RazonSocial` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `Direccion` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `Ciudad` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `Telefono` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `Valor` double NOT NULL,
  `TotalAbonos` double NOT NULL,
  `Saldo` double NOT NULL,
  `CicloPagos` varchar(5) COLLATE utf8_spanish_ci NOT NULL,
  `UltimoPago` date NOT NULL,
  `idColaborador` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `NombreColaborador` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `Promocion` int(11) NOT NULL,
  `Mayor` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `titulos_devoluciones` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `idVenta` bigint(20) NOT NULL,
  `Promocion` int(11) NOT NULL,
  `Mayor` bigint(20) NOT NULL,
  `Concepto` text COLLATE utf8_spanish_ci NOT NULL,
  `idColaborador` bigint(20) NOT NULL,
  `NombreColaborador` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `titulos_listados_promocion_1` (
  `Mayor1` int(11) NOT NULL,
  `Mayor2` int(11) NOT NULL,
  `Adicional` int(11) NOT NULL,
  `idColaborador` int(11) NOT NULL,
  `NombreColaborador` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `FechaEntregaColaborador` date NOT NULL,
  `idActa` bigint(20) NOT NULL,
  `TotalPagoComisiones` bigint(20) NOT NULL,
  `idCliente` int(11) NOT NULL,
  `NombreCliente` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `FechaVenta` date NOT NULL,
  `TotalAbonos` bigint(20) NOT NULL,
  `Saldo` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`Mayor1`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `titulos_listados_promocion_6` (
  `Mayor1` int(11) NOT NULL,
  `Mayor2` int(11) NOT NULL,
  `Adicional` int(11) NOT NULL,
  `idColaborador` int(11) NOT NULL,
  `NombreColaborador` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `FechaEntregaColaborador` date NOT NULL,
  `TotalPagoComisiones` bigint(20) NOT NULL,
  `idCliente` int(11) NOT NULL,
  `NombreCliente` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `FechaVenta` date NOT NULL,
  `TotalAbonos` bigint(20) NOT NULL,
  `Saldo` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`Mayor1`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `titulos_listados_promocion_7` (
  `Mayor1` int(11) NOT NULL,
  `Mayor2` int(11) NOT NULL,
  `Adicional` int(11) NOT NULL,
  `idColaborador` int(11) NOT NULL,
  `NombreColaborador` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `FechaEntregaColaborador` date NOT NULL,
  `idActa` bigint(20) NOT NULL,
  `TotalPagoComisiones` bigint(20) NOT NULL,
  `idCliente` int(11) NOT NULL,
  `NombreCliente` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `FechaVenta` date NOT NULL,
  `TotalAbonos` bigint(20) NOT NULL,
  `Saldo` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`Mayor1`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `titulos_promociones` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `MayorInicial` int(11) NOT NULL,
  `MayorFinal` int(11) NOT NULL,
  `FechaInicio` date NOT NULL,
  `FechaFin` date NOT NULL,
  `Valor` bigint(20) NOT NULL,
  `ComisionAPagar` bigint(20) NOT NULL,
  `Loteria` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `NumeroGanador` int(11) NOT NULL,
  `Activo` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `CuentaPUC` bigint(20) NOT NULL DEFAULT '413570',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `titulos_traslados` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Promocion` int(11) NOT NULL,
  `Mayor1` int(11) NOT NULL,
  `idColaboradorAnterior` bigint(20) NOT NULL,
  `NombreColaboradorAnterior` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `idColaboradorAsignado` bigint(20) NOT NULL,
  `NombreColaboradorAsignado` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `Observaciones` text COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `titulos_ventas` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Promocion` int(11) NOT NULL,
  `Mayor1` int(11) NOT NULL,
  `Mayor2` int(11) NOT NULL,
  `Adicional` int(11) NOT NULL,
  `Valor` bigint(20) NOT NULL,
  `TotalAbonos` bigint(20) NOT NULL,
  `Saldo` bigint(20) NOT NULL,
  `idCliente` bigint(20) NOT NULL,
  `NombreCliente` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `idColaborador` bigint(20) NOT NULL,
  `NombreColaborador` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `ComisionAPagar` bigint(20) NOT NULL,
  `SaldoComision` double NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `Estado` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `traslados_estados` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Estado` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `traslados_items` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `idTraslado` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Destino` int(11) NOT NULL,
  `CodigoBarras` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Referencia` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Nombre` text COLLATE utf8_spanish_ci NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `PrecioVenta` double NOT NULL,
  `PrecioMayorista` double NOT NULL,
  `CostoUnitario` double NOT NULL,
  `IVA` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Departamento` int(11) NOT NULL,
  `Sub1` int(11) NOT NULL,
  `Sub2` int(11) NOT NULL,
  `Sub3` int(11) NOT NULL,
  `Sub4` int(11) NOT NULL,
  `Sub5` int(11) NOT NULL,
  `CuentaPUC` int(11) NOT NULL,
  `Estado` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `ServerSincronizado` datetime NOT NULL,
  `DestinoSincronizado` datetime NOT NULL,
  `CodigoBarras1` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `CodigoBarras2` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `CodigoBarras3` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `CodigoBarras4` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `traslados_mercancia` (
  `ID` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `Origen` int(11) NOT NULL,
  `ConsecutivoInterno` bigint(20) NOT NULL,
  `Destino` int(11) NOT NULL,
  `Descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `idBodega` int(11) NOT NULL,
  `Estado` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Abre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Cierra` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `ServerSincronizado` datetime NOT NULL,
  `DestinoSincronizado` datetime NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `usuarios` (
  `idUsuarios` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Apellido` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Identificacion` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `Telefono` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Login` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Password` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `TipoUser` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Email` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Role` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Habilitado` varchar(2) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'SI',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idUsuarios`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `usuarios_ip` (
  `Direccion` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`Direccion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `usuarios_keys` (
  `KeyUsuario` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Usuarios_idUsuarios` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`KeyUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `usuarios_tipo` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Tipo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `ventas` (
  `idVentas` int(11) NOT NULL AUTO_INCREMENT,
  `NumVenta` int(16) DEFAULT NULL,
  `Fecha` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Productos_idProductos` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Producto` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Referencia` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Cantidad` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ValorCostoUnitario` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ValorVentaUnitario` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Impuestos` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Descuentos` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `TotalCosto` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `TotalVenta` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `TipoVenta` varchar(45) COLLATE utf8_spanish_ci DEFAULT 'Contado' COMMENT 'Credito o contado',
  `Cotizaciones_idCotizaciones` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Especial` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Clientes_idClientes` int(11) NOT NULL,
  `Usuarios_idUsuarios` int(11) NOT NULL,
  `CerradoDiario` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `FechaCierreDiario` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `HoraCierreDiario` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `UsuarioCierreDiario` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `HoraVenta` time NOT NULL,
  `NoReclamacion` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idVentas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DELIMITER ;;

CREATE TRIGGER `UpdateProductos` AFTER INSERT ON `ventas` FOR EACH ROW
BEGIN


SELECT Existencias into @Cantidad FROM productosventa WHERE idProductosVenta=NEW.Productos_idProductos;

SET @PrecioPromedio=NEW.ValorCostoUnitario;

SET @Saldo=@Cantidad-NEW.Cantidad;

SET @TotalSaldo=@Saldo*@PrecioPromedio;
SET @TotalMov=NEW.Cantidad*@PrecioPromedio;
    
 INSERT INTO kardexmercancias (`Fecha`, `Movimiento`, `Detalle`,`idDocumento`, `Cantidad`,`ValorUnitario`, `ValorTotal`, `ProductosVenta_idProductosVenta`) VALUES (NEW.Fecha,'SALIDA','VENTA',NEW.NumVenta,NEW.Cantidad,@PrecioPromedio,@TotalMov,NEW.Productos_idProductos);
    

INSERT INTO kardexmercancias (`Fecha`, `Movimiento`, `Detalle`,`idDocumento`, `Cantidad`,`ValorUnitario`, `ValorTotal`, `ProductosVenta_idProductosVenta`) VALUES (NEW.Fecha,'SALDOS','VENTA',NEW.NumVenta,@Saldo,@PrecioPromedio,@TotalSaldo,NEW.Productos_idProductos);

UPDATE productosventa SET `Existencias`= @Saldo WHERE idProductosVenta = NEW.Productos_idProductos;

UPDATE productosventa SET `CostoTotal`= @TotalSaldo WHERE idProductosVenta = NEW.Productos_idProductos;

SET @SubTotal=NEW.TotalVenta-NEW.Impuestos;

IF (NEW.Especial = "NO" ) THEN

INSERT INTO cotizaciones (`NumCotizacion`, `Fecha`, `Descripcion`,`Referencia`, `ValorUnitario`,`Cantidad`, `Subtotal`, `IVA`, `Total`, `ValorDescuento`,`Clientes_idClientes`, `SubtotalCosto`,`Usuarios_idUsuarios`, `TipoItem`, `PrecioCosto`) VALUES (NEW.Cotizaciones_idCotizaciones,NEW.Fecha,NEW.Producto,NEW.Referencia,NEW.ValorVentaUnitario,NEW.Cantidad,@SubTotal,NEW.Impuestos, NEW.TotalVenta,NEW.Descuentos,NEW.Clientes_idClientes,NEW.TotalCosto,NEW.Usuarios_idUsuarios,'PR',@PrecioPromedio);

END IF;

END;;

DELIMITER ;

CREATE TABLE `ventas_devoluciones` (
  `idDevoluciones` int(16) NOT NULL AUTO_INCREMENT,
  `Facturas_idFacturas` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `FechaDevolucion` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Descripcion` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Referencia` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `ValorUnitario` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Cantidad` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Subtotal` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `IVA` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Total` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `SubtotalCosto` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Clientes_idClientes` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Usuarios_idUsuarios` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Observaciones` varchar(500) COLLATE utf8_spanish_ci NOT NULL,
  `CerradoDiario` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `FechaCierreDiario` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `HoraCierreDiario` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `UsuarioCierreDiario` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idDevoluciones`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `ventas_fechas_especiales` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NombreFecha` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `FechaInicial` date NOT NULL,
  `FechaFinal` date NOT NULL,
  `Habilitado` int(1) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `ventas_fechas_especiales_precios` (
  `Referencia` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `PrecioVenta` double NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`Referencia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `ventas_nota_credito` (
  `idNotasCredito` int(11) NOT NULL AUTO_INCREMENT,
  `Fecha` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `CuentaPUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `NombreCuenta` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `DBCR` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Valor` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Facturas_idFacturas` int(11) NOT NULL,
  `Concepto` varchar(500) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idNotasCredito`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `ventas_separados` (
  `idVentas_Separados` int(11) NOT NULL AUTO_INCREMENT,
  `Facturas_idFacturas` int(11) NOT NULL,
  `Retirado` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `FechaRetiro` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `UsuariosEntrega` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idVentas_Separados`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `vestasactivas` (
  `idVestasActivas` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Usuario_idUsuario` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Clientes_idClientes` int(11) NOT NULL DEFAULT '0',
  `SaldoFavor` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idVestasActivas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE `vista_abonos` (`Tabla` varchar(16), `TipoAbono` varchar(45), `Fecha` date, `Valor` double, `idUsuario` int(11), `idCierre` bigint(20));


CREATE TABLE `vista_af` ();


CREATE TABLE `vista_balancextercero1` (`Tercero_Identificacion` varchar(45), `Tercero_Razon_Social` varchar(100), `CuentaPUC` varchar(45), `Debitos` double, `Creditos` double, `Neto` double);


CREATE TABLE `vista_balancextercero2` (`ID` char(0), `Identificacion` varchar(45), `Razon_Social` varchar(100), `Cuenta` varchar(45), `Nombre_Cuenta` varchar(200), `Debitos` double, `Creditos` double, `Neto` double, `idEmpresa` int(11), `idCentroCosto` int(11));


CREATE TABLE `vista_cierres_restaurante` (`ID` bigint(20), `Fecha` date, `Hora` time, `idUsuario` bigint(20), `PedidosFacturados` double, `PedidosDescartados` double, `DomiciliosFacturados` double, `DomiciliosDescartados` double, `ParaLlevarFacturado` double, `ParaLlevarDescartado` double, `PropinasEfectivo` double, `PropinasTarjetas` double);


CREATE TABLE `vista_compras_productos` (`ID` bigint(20), `Fecha` date, `NumeroFactura` varchar(100), `RazonSocial` varchar(300), `NIT` bigint(20), `idProducto` bigint(20), `Referencia` varchar(200), `Producto` varchar(70), `PrecioVenta` double, `Cantidad` double, `CostoUnitario` double, `Subtotal` double, `Impuestos` double, `Total` double, `Tipo_Impuesto` varchar(10), `Departamento` varchar(45), `Sub1` varchar(45), `Sub2` varchar(45), `Sub3` varchar(45), `Sub4` varchar(45), `Sub5` varchar(45), `Concepto` text, `Observaciones` text, `TipoCompra` varchar(2), `Soporte` varchar(150), `idUsuario` bigint(20), `idCentroCostos` int(11), `idSucursal` int(11), `Updated` timestamp, `Sync` datetime);


CREATE TABLE `vista_compras_productos_devueltos` (`ID` bigint(20), `Fecha` date, `NumeroFactura` varchar(100), `RazonSocial` varchar(300), `NIT` bigint(20), `idProducto` bigint(20), `Referencia` varchar(200), `Producto` varchar(70), `PrecioVenta` double, `Cantidad` double, `CostoUnitario` double, `Subtotal` double, `Impuestos` double, `Total` double, `Tipo_Impuesto` varchar(10), `Departamento` varchar(45), `Sub1` varchar(45), `Sub2` varchar(45), `Sub3` varchar(45), `Sub4` varchar(45), `Sub5` varchar(45), `Concepto` text, `Observaciones` text, `TipoCompra` varchar(2), `Soporte` varchar(150), `idUsuario` bigint(20), `idCentroCostos` int(11), `idSucursal` int(11), `Updated` timestamp, `Sync` datetime);


CREATE TABLE `vista_compras_servicios` (`ID` bigint(20), `Fecha` date, `NumeroFactura` varchar(100), `RazonSocial` varchar(300), `NIT` bigint(20), `Cuenta` bigint(20), `NombreCuenta` varchar(100), `Concepto_Servicio` text, `Subtotal` double, `Impuestos` double, `Total` double, `Tipo_Impuesto` double, `Concepto` text, `Observaciones` text, `TipoCompra` varchar(2), `Soporte` varchar(150), `idUsuario` bigint(20), `idCentroCostos` int(11), `idSucursal` int(11), `Updated` timestamp, `Sync` datetime);


CREATE TABLE `vista_diferencia_inventarios` (`idProductosVenta` bigint(20), `Referencia` varchar(200), `Nombre` varchar(70), `ExistenciaAnterior` double, `ExistenciaActual` double, `Diferencia` double, `PrecioVenta` double, `CostoUnitario` double, `TotalCostosDiferencia` double, `Departamento` varchar(45), `Sub1` varchar(45), `Sub2` varchar(45), `Sub3` varchar(45), `Sub4` varchar(45), `Sub5` varchar(45));


CREATE TABLE `vista_diferencia_inventarios_selectivos` (`idProductosVenta` bigint(20), `Referencia` varchar(200), `Nombre` varchar(70), `ExistenciaAnterior` double, `ExistenciaActual` double, `Diferencia` double, `PrecioVenta` double, `CostoUnitario` double, `TotalCostosDiferencia` double, `Departamento` varchar(45), `Sub1` varchar(45), `Sub2` varchar(45), `Sub3` varchar(45), `Sub4` varchar(45), `Sub5` varchar(45));


CREATE TABLE `vista_documentos_equivalentes` (`ID` bigint(20), `Fecha` date, `Tercero` bigint(20), `Estado` enum('AB','CE'), `Total` double);


CREATE TABLE `vista_estado_resultados_anio` (`idLibroDiario` bigint(20), `Fecha` date, `Tipo_Documento_Intero` varchar(45), `Num_Documento_Interno` varchar(45), `Num_Documento_Externo` varchar(45), `Tercero_Tipo_Documento` varchar(45), `Tercero_Identificacion` varchar(45), `Tercero_DV` varchar(3), `Tercero_Primer_Apellido` varchar(45), `Tercero_Segundo_Apellido` varchar(45), `Tercero_Primer_Nombre` varchar(45), `Tercero_Otros_Nombres` varchar(45), `Tercero_Razon_Social` varchar(100), `Tercero_Direccion` varchar(100), `Tercero_Cod_Dpto` varchar(10), `Tercero_Cod_Mcipio` varchar(10), `Tercero_Pais_Domicilio` varchar(10), `Concepto` varchar(500), `CuentaPUC` varchar(45), `NombreCuenta` varchar(200), `Detalle` varchar(45), `Debito` double, `Credito` double, `Neto` double, `Mayor` varchar(45), `Esp` varchar(45), `idCentroCosto` int(11), `idEmpresa` int(11), `idSucursal` int(11), `Estado` varchar(20), `idUsuario` int(11), `Updated` timestamp, `Sync` datetime);


CREATE TABLE `vista_exogena` (`Tipo_Documento_Intero` varchar(45), `NumDocumento` varchar(45), `Num_Documento_Externo` varchar(45), `Tercero_Tipo_Documento` varchar(45), `Tercero_Identificacion` varchar(45), `Tercero_DV` varchar(3), `Tercero_Primer_Apellido` varchar(45), `Tercero_Segundo_Apellido` varchar(45), `Tercero_Primer_Nombre` varchar(45), `Tercero_Otros_Nombres` varchar(45), `Tercero_Razon_Social` varchar(100), `Tercero_Direccion` varchar(100), `Tercero_Cod_Mcipio` varchar(10), `Tercero_Pais_Domicilio` varchar(10), `Concepto` varchar(500), `CuentaPUC` varchar(45), `NombreCuenta` varchar(200), `Detalle` varchar(45), `Debitos` double(17,0), `Creditos` double(17,0));


CREATE TABLE `vista_exogena2` (`Tercero_Tipo_Documento` varchar(45), `Tercero_Identificacion` varchar(45), `Tercero_DV` varchar(3), `Tercero_Primer_Apellido` varchar(45), `Tercero_Segundo_Apellido` varchar(45), `Tercero_Primer_Nombre` varchar(45), `Tercero_Otros_Nombres` varchar(45), `Tercero_Razon_Social` varchar(100), `Tercero_Direccion` varchar(100), `Tercero_Cod_Mcipio` varchar(10), `Tercero_Pais_Domicilio` varchar(10), `Concepto` varchar(500), `CuentaPUC` varchar(4), `NombreCuenta` varchar(200), `Detalle` varchar(45), `Debitos` double(17,0), `Creditos` double(17,0));


CREATE TABLE `vista_facturacion_detalles` (`ID` bigint(20) unsigned, `FechaFactura` date, `NumeroFactura` bigint(16), `TipoFactura` varchar(20), `TablaItems` varchar(100), `Referencia` varchar(200), `Nombre` text, `Departamento` int(11), `SubGrupo1` int(11), `SubGrupo2` int(11), `SubGrupo3` int(11), `SubGrupo4` int(11), `SubGrupo5` int(11), `ValorUnitarioItem` double, `Cantidad` double, `SubtotalItem` double, `IVAItem` double, `TotalItem` double, `PorcentajeIVA` varchar(10), `PrecioCostoUnitario` double, `SubtotalCosto` double, `CuentaPUC` int(11), `idUsuarios` int(11), `idCierre` bigint(20), `Observaciones` mediumtext);


CREATE TABLE `vista_factura_compra_totales` (`idFacturaCompra` bigint(20), `Sede` varchar(100), `Fecha` date, `NumeroFactura` varchar(100), `Tercero` bigint(20), `RazonSocial` varchar(300), `Subtotal` double, `Impuestos` double, `TotalRetenciones` double, `Total` double, `Concepto` text, `SubtotalServicios` double, `ImpuestosServicios` double, `TotalServicios` double, `SubtotalDevoluciones` double, `ImpuestosDevueltos` double, `TotalDevolucion` double, `Usuario` bigint(20));


CREATE TABLE `vista_inventario_separados` (`ID` bigint(20) unsigned, `Referencia` varchar(45), `Nombre` text, `Cantidad` decimal(32,0), `Departamento` int(11), `SubGrupo1` int(11), `SubGrupo2` int(11), `SubGrupo3` int(11), `SubGrupo4` int(11), `SubGrupo5` int(11));


CREATE TABLE `vista_kardex` (`ID` bigint(20), `Fecha` date, `Movimiento` varchar(45), `Detalle` varchar(400), `idDocumento` varchar(100), `Cantidad` double, `ValorUnitario` double, `ValorTotal` double, `ProductosVenta_idProductosVenta` bigint(20), `Referencia` varchar(200), `Nombre` varchar(70), `Existencias` double, `CostoUnitario` double, `CostoTotal` double, `IVA` varchar(10), `Departamento` varchar(45), `Sub1` varchar(45), `Sub2` varchar(45), `Sub3` varchar(45), `Sub4` varchar(45), `Sub5` varchar(45), `Updated` timestamp, `Sync` datetime);


CREATE TABLE `vista_libro_diario` (`idLibroDiario` bigint(20), `Fecha` date, `Tipo_Documento_Intero` varchar(45), `NumDocumento` varchar(45), `Num_Documento_Externo` varchar(45), `Tercero_Tipo_Documento` varchar(45), `Tercero_Identificacion` varchar(45), `Tercero_DV` varchar(3), `Tercero_Primer_Apellido` varchar(45), `Tercero_Segundo_Apellido` varchar(45), `Tercero_Primer_Nombre` varchar(45), `Tercero_Otros_Nombres` varchar(45), `Tercero_Razon_Social` varchar(100), `Tercero_Direccion` varchar(100), `Tercero_Cod_Dpto` varchar(10), `Tercero_Cod_Mcipio` varchar(10), `Tercero_Pais_Domicilio` varchar(10), `Concepto` varchar(500), `CuentaPUC` varchar(45), `NombreCuenta` varchar(200), `Detalle` varchar(45), `Debito` double, `Credito` double, `Neto` double, `idCentroCosto` int(11), `idEmpresa` int(11), `idSucursal` int(11), `Estado` varchar(20), `idUsuario` int(11));


CREATE TABLE `vista_nomina_servicios_turnos` (`ID` bigint(20), `Fecha` date, `Tercero` bigint(20), `Sucursal` int(11), `Valor` double, `idUser` int(11), `Pagado` int(1), `Estado` varchar(10), `idDocumentoEquivalente` bigint(20), `Updated` timestamp, `Sync` datetime, `NombreSucursal` varchar(100), `NombreTercero` varchar(300));


CREATE TABLE `vista_notas_devolucion` (`ID` bigint(20), `Fecha` date, `Tercero` bigint(20), `Concepto` text, `Subtotal` double, `IVA` double, `Total` double, `idCentroCostos` int(11), `idSucursal` int(11), `idUser` bigint(20), `Estado` varchar(10));


CREATE TABLE `vista_ori_facturas` (`Fecha` date, `idFactura` varchar(45), `Referencia` varchar(200), `Nombre` varchar(500), `Departamento` int(11), `SubGrupo1` int(11), `SubGrupo2` int(11), `SubGrupo3` int(11), `SubGrupo4` int(11), `SubGrupo5` int(11), `ValorUnitarioItem` int(11), `Cantidad` varchar(45), `Dias` varchar(45), `SubtotalItem` varchar(45), `IVAItem` varchar(45), `ValorOtrosImpuestos` double, `TotalItem` double, `PorcentajeIVA` varchar(10), `idOtrosImpuestos` int(11), `idPorcentajeIVA` int(11), `PrecioCostoUnitario` varchar(45), `SubtotalCosto` varchar(45), `TipoItem` varchar(10), `CuentaPUC` int(11), `GeneradoDesde` varchar(100), `NumeroIdentificador` varchar(45), `idUsuarios` int(11), `idCierre` bigint(20), `idResolucion` int(11), `TipoFactura` varchar(10), `Prefijo` varchar(45), `NumeroFactura` int(16), `Hora` varchar(20), `FormaPago` varchar(20), `CentroCosto` int(11), `idSucursal` int(11), `EmpresaPro_idEmpresaPro` int(11), `Clientes_idClientes` int(11), `ObservacionesFact` text);


CREATE TABLE `vista_pedidos_restaurante` (`ID` bigint(20), `Fecha` date, `Hora` time, `Estado` varchar(4), `idMesa` int(11), `idCliente` bigint(20), `NombreCliente` varchar(60), `DireccionEnvio` varchar(100), `TelefonoConfirmacion` varchar(100), `Observaciones` text, `idCierre` bigint(20), `Subtotal` double, `IVA` double, `Total` double, `idUsuario` bigint(20));


CREATE TABLE `vista_preventa` (`VestasActivas_idVestasActivas` int(11), `TablaItems` varchar(14), `Referencia` varchar(200), `Nombre` varchar(70), `Departamento` varchar(45), `SubGrupo1` varchar(45), `SubGrupo2` varchar(45), `SubGrupo3` varchar(45), `SubGrupo4` varchar(45), `SubGrupo5` varchar(45), `ValorUnitarioItem` double, `Cantidad` double, `Dias` varchar(1), `SubtotalItem` double, `IVAItem` double, `ValorOtrosImpuestos` double, `TotalItem` double, `PorcentajeIVA` varchar(24), `PrecioCostoUnitario` double, `SubtotalCosto` double, `TipoItem` varchar(2), `CuentaPUC` varchar(45), `Updated` timestamp, `Sync` datetime);


CREATE TABLE `vista_resumen_facturacion` (`ID` bigint(20) unsigned, `FechaInicial` date, `FechaFinal` date, `Referencia` varchar(200), `idProducto` bigint(20), `Nombre` text, `Departamento` int(11), `SubGrupo1` int(11), `SubGrupo2` int(11), `SubGrupo3` int(11), `SubGrupo4` int(11), `SubGrupo5` int(11), `Cantidad` double, `TotalVenta` double(19,2), `Costo` double(19,2));


CREATE TABLE `vista_resumen_ventas_departamentos` (`FechaFactura` date, `Departamento` int(11), `SubGrupo1` int(11), `SubGrupo2` int(11), `SubGrupo3` int(11), `SubGrupo4` int(11), `SubGrupo5` int(11), `Total` double);


CREATE TABLE `vista_retenciones` (`idCompra` bigint(20), `Fecha` date, `Tercero` bigint(20), `RazonSocial` varchar(300), `DV` varchar(5), `Direccion` varchar(45), `Ciudad` varchar(100), `CuentaPUC` bigint(20), `Cuenta` varchar(200), `ValorRetencion` double, `PorcentajeRetenido` double, `BaseRetencion` double(19,2), `idEmpresa` bigint(11), `idCentroCostos` bigint(11), `idSucursal` bigint(11));


CREATE TABLE `vista_retenciones_tercero` (`idCompra` bigint(20), `Fecha` date, `Tercero` bigint(20), `RazonSocial` varchar(300), `DV` varchar(5), `Direccion` varchar(45), `Ciudad` varchar(100), `CuentaPUC` bigint(20), `Cuenta` varchar(200), `ValorRetencion` double, `PorcentajeRetenido` double, `BaseRetencion` double(19,2));


CREATE TABLE `vista_sistemas` (`ID` bigint(20), `idSistema` bigint(20), `Nombre_Sistema` mediumtext, `Observaciones` mediumtext, `TablaOrigen` varchar(90), `CodigoInterno` bigint(20), `Nombre` text, `Cantidad` double, `PrecioUnitario` double, `PrecioVenta` double(17,0), `CostoUnitario` double(17,0), `Costo_Total_Item` double(17,0), `IVA` varchar(10), `Departamento` varchar(45), `Sub1` varchar(45), `Sub2` varchar(45), `Sub3` varchar(45), `Sub4` varchar(45), `Sub5` varchar(45), `Updated` timestamp, `Sync` datetime);


CREATE TABLE `vista_titulos_abonos` (`ID` bigint(20), `Fecha` date, `Hora` time, `Monto` double, `idVenta` bigint(20), `Promocion` int(11), `Mayor` int(11), `Concepto` text, `idColaborador` bigint(20), `NombreColaborador` varchar(90), `Estado` varchar(45), `idComprobanteIngreso` bigint(20), `Mayor2` int(11), `Adicional` int(11), `Valor` bigint(20), `TotalAbonos` bigint(20), `Saldo` bigint(20), `idCliente` bigint(20), `NombreCliente` varchar(90));


CREATE TABLE `vista_titulos_comisiones` (`ID` bigint(20), `Fecha` date, `Hora` time, `Monto` double, `idVenta` bigint(20), `Promocion` int(11), `Mayor` int(11), `Concepto` text, `idColaborador` bigint(20), `NombreColaborador` varchar(90), `idUsuario` int(11), `idEgreso` bigint(20), `Mayor2` int(11), `Adicional` int(11), `Valor` bigint(20), `TotalAbonos` bigint(20), `Saldo` bigint(20), `idCliente` bigint(20), `NombreCliente` varchar(90));


CREATE TABLE `vista_titulos_devueltos` (`ID` bigint(20), `Fecha` date, `idVenta` bigint(20), `Promocion` int(11), `Mayor` bigint(20), `Concepto` text, `idColaborador` bigint(20), `NombreColaborador` varchar(90), `idUsuario` int(11), `Mayor2` int(11), `Adicional` int(11), `Valor` bigint(20), `TotalAbonos` bigint(20), `Saldo` bigint(20), `idCliente` bigint(20), `NombreCliente` varchar(90));


CREATE TABLE `vista_totales_facturacion` (`FechaFactura` date, `Items` double, `Subtotal` double(17,0), `IVA` double(17,0), `OtrosImpuestos` double(17,0), `Total` double(17,0));


DROP TABLE IF EXISTS `vista_abonos`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_abonos` AS select 'abonos_factura' AS `Tabla`,`fa`.`FormaPago` AS `TipoAbono`,`fa`.`Fecha` AS `Fecha`,`fa`.`Valor` AS `Valor`,`fa`.`Usuarios_idUsuarios` AS `idUsuario`,`fa`.`idCierre` AS `idCierre` from `facturas_abonos` `fa` union select 'abonos_separados' AS `Tabla`,'Separados' AS `TipoAbono`,`fa`.`Fecha` AS `Fecha`,`fa`.`Valor` AS `Valor`,`fa`.`idUsuarios` AS `idUsuario`,`fa`.`idCierre` AS `idCierre` from `separados_abonos` `fa`;

DROP TABLE IF EXISTS `vista_af`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_af` AS select `ts5`.`salud_archivo_facturacion_mov_generados`.`id_fac_mov_generados` AS `id_fac_mov_generados`,`ts5`.`salud_archivo_facturacion_mov_generados`.`cod_prest_servicio` AS `cod_prest_servicio`,`ts5`.`salud_archivo_facturacion_mov_generados`.`razon_social` AS `razon_social`,`ts5`.`salud_archivo_facturacion_mov_generados`.`tipo_ident_prest_servicio` AS `tipo_ident_prest_servicio`,`ts5`.`salud_archivo_facturacion_mov_generados`.`num_ident_prest_servicio` AS `num_ident_prest_servicio`,`ts5`.`salud_archivo_facturacion_mov_generados`.`num_factura` AS `num_factura`,`ts5`.`salud_archivo_facturacion_mov_generados`.`fecha_factura` AS `fecha_factura`,`ts5`.`salud_archivo_facturacion_mov_generados`.`fecha_inicio` AS `fecha_inicio`,`ts5`.`salud_archivo_facturacion_mov_generados`.`fecha_final` AS `fecha_final`,`ts5`.`salud_archivo_facturacion_mov_generados`.`cod_enti_administradora` AS `cod_enti_administradora`,`ts5`.`salud_archivo_facturacion_mov_generados`.`nom_enti_administradora` AS `nom_enti_administradora`,`ts5`.`salud_archivo_facturacion_mov_generados`.`num_contrato` AS `num_contrato`,`ts5`.`salud_archivo_facturacion_mov_generados`.`plan_beneficios` AS `plan_beneficios`,`ts5`.`salud_archivo_facturacion_mov_generados`.`num_poliza` AS `num_poliza`,`ts5`.`salud_archivo_facturacion_mov_generados`.`valor_total_pago` AS `valor_total_pago`,`ts5`.`salud_archivo_facturacion_mov_generados`.`valor_comision` AS `valor_comision`,`ts5`.`salud_archivo_facturacion_mov_generados`.`valor_descuentos` AS `valor_descuentos`,`ts5`.`salud_archivo_facturacion_mov_generados`.`valor_neto_pagar` AS `valor_neto_pagar`,`ts5`.`salud_archivo_facturacion_mov_generados`.`tipo_negociacion` AS `tipo_negociacion`,`ts5`.`salud_archivo_facturacion_mov_generados`.`nom_cargue` AS `nom_cargue`,`ts5`.`salud_archivo_facturacion_mov_generados`.`fecha_cargue` AS `fecha_cargue`,`ts5`.`salud_archivo_facturacion_mov_generados`.`idUser` AS `idUser`,`ts5`.`salud_archivo_facturacion_mov_generados`.`eps_radicacion` AS `eps_radicacion`,`ts5`.`salud_archivo_facturacion_mov_generados`.`dias_pactados` AS `dias_pactados`,`ts5`.`salud_archivo_facturacion_mov_generados`.`fecha_radicado` AS `fecha_radicado`,`ts5`.`salud_archivo_facturacion_mov_generados`.`numero_radicado` AS `numero_radicado`,`ts5`.`salud_archivo_facturacion_mov_generados`.`Soporte` AS `Soporte`,`ts5`.`salud_archivo_facturacion_mov_generados`.`estado` AS `estado`,`ts5`.`salud_archivo_facturacion_mov_generados`.`EstadoCobro` AS `EstadoCobro`,`ts5`.`salud_archivo_facturacion_mov_generados`.`Arma030Anterior` AS `Arma030Anterior`,`ts5`.`salud_archivo_facturacion_mov_generados`.`Updated` AS `Updated`,`ts5`.`salud_archivo_facturacion_mov_generados`.`Sync` AS `Sync`,(select `ts5`.`salud_eps`.`Genera030` from `salud_eps` where (`ts5`.`salud_eps`.`cod_pagador_min` = `ts5`.`salud_archivo_facturacion_mov_generados`.`cod_enti_administradora`)) AS `GeneraCircular` from `salud_archivo_facturacion_mov_generados`;

DROP TABLE IF EXISTS `vista_balancextercero1`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_balancextercero1` AS select `librodiario`.`Tercero_Identificacion` AS `Tercero_Identificacion`,`librodiario`.`Tercero_Razon_Social` AS `Tercero_Razon_Social`,`librodiario`.`CuentaPUC` AS `CuentaPUC`,sum(`librodiario`.`Debito`) AS `Debitos`,sum(`librodiario`.`Credito`) AS `Creditos`,(sum(`librodiario`.`Debito`) - sum(`librodiario`.`Credito`)) AS `Neto` from `librodiario` group by `librodiario`.`Tercero_Identificacion` order by substr(`librodiario`.`CuentaPUC`,1,8);

DROP TABLE IF EXISTS `vista_balancextercero2`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_balancextercero2` AS select '' AS `ID`,`librodiario`.`Tercero_Identificacion` AS `Identificacion`,`librodiario`.`Tercero_Razon_Social` AS `Razon_Social`,`librodiario`.`CuentaPUC` AS `Cuenta`,`librodiario`.`NombreCuenta` AS `Nombre_Cuenta`,sum(`librodiario`.`Debito`) AS `Debitos`,sum(`librodiario`.`Credito`) AS `Creditos`,(sum(`librodiario`.`Debito`) - sum(`librodiario`.`Credito`)) AS `Neto`,`librodiario`.`idEmpresa` AS `idEmpresa`,`librodiario`.`idCentroCosto` AS `idCentroCosto` from `librodiario` where ((`librodiario`.`Fecha` >= '2018-10-01') and (`librodiario`.`Fecha` <= '2019-02-19')) group by `librodiario`.`Tercero_Identificacion` order by substr(`librodiario`.`CuentaPUC`,1,8),`librodiario`.`Tercero_Razon_Social`;

DROP TABLE IF EXISTS `vista_cierres_restaurante`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_cierres_restaurante` AS select `restaurante_cierres`.`ID` AS `ID`,`restaurante_cierres`.`Fecha` AS `Fecha`,`restaurante_cierres`.`Hora` AS `Hora`,`restaurante_cierres`.`idUsuario` AS `idUsuario`,(select sum(`restaurante_pedidos_items`.`Total`) AS `Total` from `restaurante_pedidos_items` where ((`restaurante_pedidos_items`.`idCierre` = `restaurante_cierres`.`ID`) and (`restaurante_pedidos_items`.`Estado` = 'FAPE'))) AS `PedidosFacturados`,(select sum(`restaurante_pedidos_items`.`Total`) AS `Total` from `restaurante_pedidos_items` where ((`restaurante_pedidos_items`.`idCierre` = `restaurante_cierres`.`ID`) and (`restaurante_pedidos_items`.`Estado` = 'DEPE'))) AS `PedidosDescartados`,(select sum(`restaurante_pedidos_items`.`Total`) AS `Total` from `restaurante_pedidos_items` where ((`restaurante_pedidos_items`.`idCierre` = `restaurante_cierres`.`ID`) and (`restaurante_pedidos_items`.`Estado` = 'FADO'))) AS `DomiciliosFacturados`,(select sum(`restaurante_pedidos_items`.`Total`) AS `Total` from `restaurante_pedidos_items` where ((`restaurante_pedidos_items`.`idCierre` = `restaurante_cierres`.`ID`) and (`restaurante_pedidos_items`.`Estado` = 'DEDO'))) AS `DomiciliosDescartados`,(select sum(`restaurante_pedidos_items`.`Total`) AS `Total` from `restaurante_pedidos_items` where ((`restaurante_pedidos_items`.`idCierre` = `restaurante_cierres`.`ID`) and (`restaurante_pedidos_items`.`Estado` = 'FALL'))) AS `ParaLlevarFacturado`,(select sum(`restaurante_pedidos_items`.`Total`) AS `Total` from `restaurante_pedidos_items` where ((`restaurante_pedidos_items`.`idCierre` = `restaurante_cierres`.`ID`) and (`restaurante_pedidos_items`.`Estado` = 'DELL'))) AS `ParaLlevarDescartado`,(select sum(`restaurante_registro_propinas`.`Efectivo`) AS `Total` from `restaurante_registro_propinas` where (`restaurante_registro_propinas`.`idCierre` = `restaurante_cierres`.`ID`)) AS `PropinasEfectivo`,(select sum(`restaurante_registro_propinas`.`Tarjetas`) AS `Total` from `restaurante_registro_propinas` where (`restaurante_registro_propinas`.`idCierre` = `restaurante_cierres`.`ID`)) AS `PropinasTarjetas` from `restaurante_cierres`;

DROP TABLE IF EXISTS `vista_compras_productos`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_compras_productos` AS select `c`.`ID` AS `ID`,`c`.`Fecha` AS `Fecha`,`c`.`NumeroFactura` AS `NumeroFactura`,`t`.`RazonSocial` AS `RazonSocial`,`c`.`Tercero` AS `NIT`,`fi`.`idProducto` AS `idProducto`,`pv`.`Referencia` AS `Referencia`,`pv`.`Nombre` AS `Producto`,`pv`.`PrecioVenta` AS `PrecioVenta`,`fi`.`Cantidad` AS `Cantidad`,`fi`.`CostoUnitarioCompra` AS `CostoUnitario`,`fi`.`SubtotalCompra` AS `Subtotal`,`fi`.`ImpuestoCompra` AS `Impuestos`,`fi`.`TotalCompra` AS `Total`,`fi`.`Tipo_Impuesto` AS `Tipo_Impuesto`,`pv`.`Departamento` AS `Departamento`,`pv`.`Sub1` AS `Sub1`,`pv`.`Sub2` AS `Sub2`,`pv`.`Sub3` AS `Sub3`,`pv`.`Sub4` AS `Sub4`,`pv`.`Sub5` AS `Sub5`,`c`.`Concepto` AS `Concepto`,`c`.`Observaciones` AS `Observaciones`,`c`.`TipoCompra` AS `TipoCompra`,`c`.`Soporte` AS `Soporte`,`c`.`idUsuario` AS `idUsuario`,`c`.`idCentroCostos` AS `idCentroCostos`,`c`.`idSucursal` AS `idSucursal`,`c`.`Updated` AS `Updated`,`c`.`Sync` AS `Sync` from (((`factura_compra` `c` join `proveedores` `t` on((`c`.`Tercero` = `t`.`Num_Identificacion`))) join `factura_compra_items` `fi` on((`fi`.`idFacturaCompra` = `c`.`ID`))) join `productosventa` `pv` on((`fi`.`idProducto` = `pv`.`idProductosVenta`))) where (`c`.`Estado` = 'CERRADA');

DROP TABLE IF EXISTS `vista_compras_productos_devueltos`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_compras_productos_devueltos` AS select `c`.`ID` AS `ID`,`c`.`Fecha` AS `Fecha`,`c`.`NumeroFactura` AS `NumeroFactura`,`t`.`RazonSocial` AS `RazonSocial`,`c`.`Tercero` AS `NIT`,`fi`.`idProducto` AS `idProducto`,`pv`.`Referencia` AS `Referencia`,`pv`.`Nombre` AS `Producto`,`pv`.`PrecioVenta` AS `PrecioVenta`,`fi`.`Cantidad` AS `Cantidad`,`fi`.`CostoUnitarioCompra` AS `CostoUnitario`,`fi`.`SubtotalCompra` AS `Subtotal`,`fi`.`ImpuestoCompra` AS `Impuestos`,`fi`.`TotalCompra` AS `Total`,`fi`.`Tipo_Impuesto` AS `Tipo_Impuesto`,`pv`.`Departamento` AS `Departamento`,`pv`.`Sub1` AS `Sub1`,`pv`.`Sub2` AS `Sub2`,`pv`.`Sub3` AS `Sub3`,`pv`.`Sub4` AS `Sub4`,`pv`.`Sub5` AS `Sub5`,`c`.`Concepto` AS `Concepto`,`c`.`Observaciones` AS `Observaciones`,`c`.`TipoCompra` AS `TipoCompra`,`c`.`Soporte` AS `Soporte`,`c`.`idUsuario` AS `idUsuario`,`c`.`idCentroCostos` AS `idCentroCostos`,`c`.`idSucursal` AS `idSucursal`,`c`.`Updated` AS `Updated`,`c`.`Sync` AS `Sync` from (((`factura_compra` `c` join `proveedores` `t` on((`c`.`Tercero` = `t`.`Num_Identificacion`))) join `factura_compra_items_devoluciones` `fi` on((`fi`.`idFacturaCompra` = `c`.`ID`))) join `productosventa` `pv` on((`fi`.`idProducto` = `pv`.`idProductosVenta`))) where (`c`.`Estado` = 'CERRADA');

DROP TABLE IF EXISTS `vista_compras_servicios`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_compras_servicios` AS select `c`.`ID` AS `ID`,`c`.`Fecha` AS `Fecha`,`c`.`NumeroFactura` AS `NumeroFactura`,`t`.`RazonSocial` AS `RazonSocial`,`c`.`Tercero` AS `NIT`,`fs`.`CuentaPUC_Servicio` AS `Cuenta`,`fs`.`Nombre_Cuenta` AS `NombreCuenta`,`fs`.`Concepto_Servicio` AS `Concepto_Servicio`,`fs`.`Subtotal_Servicio` AS `Subtotal`,`fs`.`Impuesto_Servicio` AS `Impuestos`,`fs`.`Total_Servicio` AS `Total`,`fs`.`Tipo_Impuesto` AS `Tipo_Impuesto`,`c`.`Concepto` AS `Concepto`,`c`.`Observaciones` AS `Observaciones`,`c`.`TipoCompra` AS `TipoCompra`,`c`.`Soporte` AS `Soporte`,`c`.`idUsuario` AS `idUsuario`,`c`.`idCentroCostos` AS `idCentroCostos`,`c`.`idSucursal` AS `idSucursal`,`c`.`Updated` AS `Updated`,`c`.`Sync` AS `Sync` from ((`factura_compra` `c` join `proveedores` `t` on((`c`.`Tercero` = `t`.`Num_Identificacion`))) join `factura_compra_servicios` `fs` on((`fs`.`idFacturaCompra` = `c`.`ID`))) where (`c`.`Estado` = 'CERRADA');

DROP TABLE IF EXISTS `vista_diferencia_inventarios`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_diferencia_inventarios` AS select `productosventa`.`idProductosVenta` AS `idProductosVenta`,`productosventa`.`Referencia` AS `Referencia`,`productosventa`.`Nombre` AS `Nombre`,`productosventa`.`Existencias` AS `ExistenciaAnterior`,(select ifnull((select `inventarios_temporal`.`Existencias` from `inventarios_temporal` where (`productosventa`.`Referencia` = `inventarios_temporal`.`Referencia`)),0)) AS `ExistenciaActual`,((select `ExistenciaActual`) - `productosventa`.`Existencias`) AS `Diferencia`,`productosventa`.`PrecioVenta` AS `PrecioVenta`,`productosventa`.`CostoUnitario` AS `CostoUnitario`,((select `Diferencia`) * `productosventa`.`CostoUnitario`) AS `TotalCostosDiferencia`,`productosventa`.`Departamento` AS `Departamento`,`productosventa`.`Sub1` AS `Sub1`,`productosventa`.`Sub2` AS `Sub2`,`productosventa`.`Sub3` AS `Sub3`,`productosventa`.`Sub4` AS `Sub4`,`productosventa`.`Sub5` AS `Sub5` from `productosventa` where (((select ifnull((select `inventarios_temporal`.`Existencias` from `inventarios_temporal` where (`productosventa`.`Referencia` = `inventarios_temporal`.`Referencia`)),0)) - `productosventa`.`Existencias`) <> 0);

DROP TABLE IF EXISTS `vista_diferencia_inventarios_selectivos`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_diferencia_inventarios_selectivos` AS select `productosventa`.`idProductosVenta` AS `idProductosVenta`,`productosventa`.`Referencia` AS `Referencia`,`productosventa`.`Nombre` AS `Nombre`,`productosventa`.`Existencias` AS `ExistenciaAnterior`,(select ifnull((select `inventarios_conteo_selectivo`.`Cantidad` from `inventarios_conteo_selectivo` where (`productosventa`.`idProductosVenta` = `inventarios_conteo_selectivo`.`Referencia`)),0)) AS `ExistenciaActual`,((select `ExistenciaActual`) - `productosventa`.`Existencias`) AS `Diferencia`,`productosventa`.`PrecioVenta` AS `PrecioVenta`,`productosventa`.`CostoUnitario` AS `CostoUnitario`,((select `Diferencia`) * `productosventa`.`CostoUnitario`) AS `TotalCostosDiferencia`,`productosventa`.`Departamento` AS `Departamento`,`productosventa`.`Sub1` AS `Sub1`,`productosventa`.`Sub2` AS `Sub2`,`productosventa`.`Sub3` AS `Sub3`,`productosventa`.`Sub4` AS `Sub4`,`productosventa`.`Sub5` AS `Sub5` from `productosventa` where ((select ifnull((select `inventarios_conteo_selectivo`.`Cantidad` from `inventarios_conteo_selectivo` where (`productosventa`.`idProductosVenta` = `inventarios_conteo_selectivo`.`Referencia`)),0)) > 0);

DROP TABLE IF EXISTS `vista_documentos_equivalentes`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_documentos_equivalentes` AS select `de`.`ID` AS `ID`,`de`.`Fecha` AS `Fecha`,`de`.`Tercero` AS `Tercero`,`de`.`Estado` AS `Estado`,(select sum(`dei`.`Total`) from `documento_equivalente_items` `dei` where (`dei`.`idDocumento` = `de`.`ID`)) AS `Total` from `documento_equivalente` `de`;

DROP TABLE IF EXISTS `vista_estado_resultados_anio`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_estado_resultados_anio` AS select `librodiario`.`idLibroDiario` AS `idLibroDiario`,`librodiario`.`Fecha` AS `Fecha`,`librodiario`.`Tipo_Documento_Intero` AS `Tipo_Documento_Intero`,`librodiario`.`Num_Documento_Interno` AS `Num_Documento_Interno`,`librodiario`.`Num_Documento_Externo` AS `Num_Documento_Externo`,`librodiario`.`Tercero_Tipo_Documento` AS `Tercero_Tipo_Documento`,`librodiario`.`Tercero_Identificacion` AS `Tercero_Identificacion`,`librodiario`.`Tercero_DV` AS `Tercero_DV`,`librodiario`.`Tercero_Primer_Apellido` AS `Tercero_Primer_Apellido`,`librodiario`.`Tercero_Segundo_Apellido` AS `Tercero_Segundo_Apellido`,`librodiario`.`Tercero_Primer_Nombre` AS `Tercero_Primer_Nombre`,`librodiario`.`Tercero_Otros_Nombres` AS `Tercero_Otros_Nombres`,`librodiario`.`Tercero_Razon_Social` AS `Tercero_Razon_Social`,`librodiario`.`Tercero_Direccion` AS `Tercero_Direccion`,`librodiario`.`Tercero_Cod_Dpto` AS `Tercero_Cod_Dpto`,`librodiario`.`Tercero_Cod_Mcipio` AS `Tercero_Cod_Mcipio`,`librodiario`.`Tercero_Pais_Domicilio` AS `Tercero_Pais_Domicilio`,`librodiario`.`Concepto` AS `Concepto`,`librodiario`.`CuentaPUC` AS `CuentaPUC`,`librodiario`.`NombreCuenta` AS `NombreCuenta`,`librodiario`.`Detalle` AS `Detalle`,`librodiario`.`Debito` AS `Debito`,`librodiario`.`Credito` AS `Credito`,`librodiario`.`Neto` AS `Neto`,`librodiario`.`Mayor` AS `Mayor`,`librodiario`.`Esp` AS `Esp`,`librodiario`.`idCentroCosto` AS `idCentroCosto`,`librodiario`.`idEmpresa` AS `idEmpresa`,`librodiario`.`idSucursal` AS `idSucursal`,`librodiario`.`Estado` AS `Estado`,`librodiario`.`idUsuario` AS `idUsuario`,`librodiario`.`Updated` AS `Updated`,`librodiario`.`Sync` AS `Sync` from `librodiario` where ((`librodiario`.`Fecha` >= '2019-01-01') and (`librodiario`.`Fecha` <= '2019-12-31'));

DROP TABLE IF EXISTS `vista_exogena`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_exogena` AS select `librodiario`.`Tipo_Documento_Intero` AS `Tipo_Documento_Intero`,(select if((`librodiario`.`Tipo_Documento_Intero` = 'FACTURA'),(select `facturas`.`NumeroFactura` from `facturas` where (`facturas`.`idFacturas` = `librodiario`.`Num_Documento_Interno`)),`librodiario`.`Num_Documento_Interno`)) AS `NumDocumento`,`librodiario`.`Num_Documento_Externo` AS `Num_Documento_Externo`,`librodiario`.`Tercero_Tipo_Documento` AS `Tercero_Tipo_Documento`,`librodiario`.`Tercero_Identificacion` AS `Tercero_Identificacion`,`librodiario`.`Tercero_DV` AS `Tercero_DV`,`librodiario`.`Tercero_Primer_Apellido` AS `Tercero_Primer_Apellido`,`librodiario`.`Tercero_Segundo_Apellido` AS `Tercero_Segundo_Apellido`,`librodiario`.`Tercero_Primer_Nombre` AS `Tercero_Primer_Nombre`,`librodiario`.`Tercero_Otros_Nombres` AS `Tercero_Otros_Nombres`,`librodiario`.`Tercero_Razon_Social` AS `Tercero_Razon_Social`,`librodiario`.`Tercero_Direccion` AS `Tercero_Direccion`,`librodiario`.`Tercero_Cod_Mcipio` AS `Tercero_Cod_Mcipio`,`librodiario`.`Tercero_Pais_Domicilio` AS `Tercero_Pais_Domicilio`,`librodiario`.`Concepto` AS `Concepto`,`librodiario`.`CuentaPUC` AS `CuentaPUC`,`librodiario`.`NombreCuenta` AS `NombreCuenta`,`librodiario`.`Detalle` AS `Detalle`,round(sum(`librodiario`.`Debito`),0) AS `Debitos`,round(sum(`librodiario`.`Credito`),0) AS `Creditos` from `librodiario` where ((`librodiario`.`Fecha` >= '2017-01-01') and (`librodiario`.`Fecha` <= '2017-12-31')) group by `librodiario`.`CuentaPUC`,`librodiario`.`Tercero_Identificacion`;

DROP TABLE IF EXISTS `vista_exogena2`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_exogena2` AS select `librodiario`.`Tercero_Tipo_Documento` AS `Tercero_Tipo_Documento`,`librodiario`.`Tercero_Identificacion` AS `Tercero_Identificacion`,`librodiario`.`Tercero_DV` AS `Tercero_DV`,`librodiario`.`Tercero_Primer_Apellido` AS `Tercero_Primer_Apellido`,`librodiario`.`Tercero_Segundo_Apellido` AS `Tercero_Segundo_Apellido`,`librodiario`.`Tercero_Primer_Nombre` AS `Tercero_Primer_Nombre`,`librodiario`.`Tercero_Otros_Nombres` AS `Tercero_Otros_Nombres`,`librodiario`.`Tercero_Razon_Social` AS `Tercero_Razon_Social`,`librodiario`.`Tercero_Direccion` AS `Tercero_Direccion`,`librodiario`.`Tercero_Cod_Mcipio` AS `Tercero_Cod_Mcipio`,`librodiario`.`Tercero_Pais_Domicilio` AS `Tercero_Pais_Domicilio`,`librodiario`.`Concepto` AS `Concepto`,substr(`librodiario`.`CuentaPUC`,1,4) AS `CuentaPUC`,`librodiario`.`NombreCuenta` AS `NombreCuenta`,`librodiario`.`Detalle` AS `Detalle`,round(sum(`librodiario`.`Debito`),0) AS `Debitos`,round(sum(`librodiario`.`Credito`),0) AS `Creditos` from `librodiario` where ((`librodiario`.`Fecha` >= '2017-01-01') and (`librodiario`.`Fecha` <= '2017-12-31')) group by substr(`librodiario`.`CuentaPUC`,1,4),`librodiario`.`Tercero_Identificacion`;

DROP TABLE IF EXISTS `vista_facturacion_detalles`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_facturacion_detalles` AS select `facturas_items`.`ID` AS `ID`,`facturas_items`.`FechaFactura` AS `FechaFactura`,(select `facturas`.`NumeroFactura` from `facturas` where (`facturas`.`idFacturas` = `facturas_items`.`idFactura`)) AS `NumeroFactura`,(select `facturas`.`FormaPago` from `facturas` where (`facturas`.`idFacturas` = `facturas_items`.`idFactura`)) AS `TipoFactura`,`facturas_items`.`TablaItems` AS `TablaItems`,`facturas_items`.`Referencia` AS `Referencia`,`facturas_items`.`Nombre` AS `Nombre`,`facturas_items`.`Departamento` AS `Departamento`,`facturas_items`.`SubGrupo1` AS `SubGrupo1`,`facturas_items`.`SubGrupo2` AS `SubGrupo2`,`facturas_items`.`SubGrupo3` AS `SubGrupo3`,`facturas_items`.`SubGrupo4` AS `SubGrupo4`,`facturas_items`.`SubGrupo5` AS `SubGrupo5`,`facturas_items`.`ValorUnitarioItem` AS `ValorUnitarioItem`,`facturas_items`.`Cantidad` AS `Cantidad`,`facturas_items`.`SubtotalItem` AS `SubtotalItem`,`facturas_items`.`IVAItem` AS `IVAItem`,`facturas_items`.`TotalItem` AS `TotalItem`,`facturas_items`.`PorcentajeIVA` AS `PorcentajeIVA`,`facturas_items`.`PrecioCostoUnitario` AS `PrecioCostoUnitario`,`facturas_items`.`SubtotalCosto` AS `SubtotalCosto`,`facturas_items`.`CuentaPUC` AS `CuentaPUC`,`facturas_items`.`idUsuarios` AS `idUsuarios`,`facturas_items`.`idCierre` AS `idCierre`,(select `facturas`.`ObservacionesFact` from `facturas` where (`facturas`.`idFacturas` = `facturas_items`.`idFactura`)) AS `Observaciones` from `facturas_items`;

DROP TABLE IF EXISTS `vista_factura_compra_totales`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_factura_compra_totales` AS select `fci`.`idFacturaCompra` AS `idFacturaCompra`,(select `empresa_pro_sucursales`.`Nombre` from `empresa_pro_sucursales` where (`empresa_pro_sucursales`.`ID` = `fc`.`idSucursal`)) AS `Sede`,(select `factura_compra`.`Fecha` from `factura_compra` where (`factura_compra`.`ID` = `fci`.`idFacturaCompra`)) AS `Fecha`,(select `factura_compra`.`NumeroFactura` from `factura_compra` where (`factura_compra`.`ID` = `fci`.`idFacturaCompra`)) AS `NumeroFactura`,`fc`.`Tercero` AS `Tercero`,(select `proveedores`.`RazonSocial` from `proveedores` where (`proveedores`.`Num_Identificacion` = `fc`.`Tercero`) limit 1) AS `RazonSocial`,sum(`fci`.`SubtotalCompra`) AS `Subtotal`,sum(`fci`.`ImpuestoCompra`) AS `Impuestos`,(select sum(`factura_compra_retenciones`.`ValorRetencion`) from `factura_compra_retenciones` where (`factura_compra_retenciones`.`idCompra` = `fci`.`idFacturaCompra`)) AS `TotalRetenciones`,sum(`fci`.`TotalCompra`) AS `Total`,`fc`.`Concepto` AS `Concepto`,(select sum(`factura_compra_servicios`.`Subtotal_Servicio`) from `factura_compra_servicios` where (`factura_compra_servicios`.`idFacturaCompra` = `fci`.`idFacturaCompra`)) AS `SubtotalServicios`,(select sum(`factura_compra_servicios`.`Impuesto_Servicio`) from `factura_compra_servicios` where (`factura_compra_servicios`.`idFacturaCompra` = `fci`.`idFacturaCompra`)) AS `ImpuestosServicios`,(select sum(`factura_compra_servicios`.`Total_Servicio`) from `factura_compra_servicios` where (`factura_compra_servicios`.`idFacturaCompra` = `fci`.`idFacturaCompra`)) AS `TotalServicios`,(select sum(`factura_compra_items_devoluciones`.`SubtotalCompra`) from `factura_compra_items_devoluciones` where (`factura_compra_items_devoluciones`.`idFacturaCompra` = `fci`.`idFacturaCompra`)) AS `SubtotalDevoluciones`,(select sum(`factura_compra_items_devoluciones`.`ImpuestoCompra`) from `factura_compra_items_devoluciones` where (`factura_compra_items_devoluciones`.`idFacturaCompra` = `fci`.`idFacturaCompra`)) AS `ImpuestosDevueltos`,(select sum(`factura_compra_items_devoluciones`.`TotalCompra`) from `factura_compra_items_devoluciones` where (`factura_compra_items_devoluciones`.`idFacturaCompra` = `fci`.`idFacturaCompra`)) AS `TotalDevolucion`,`fc`.`idUsuario` AS `Usuario` from (`factura_compra_items` `fci` join `factura_compra` `fc` on((`fc`.`ID` = `fci`.`idFacturaCompra`))) where (`fc`.`Estado` <> 'ANULADA') group by `fci`.`idFacturaCompra`;

DROP TABLE IF EXISTS `vista_inventario_separados`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_inventario_separados` AS select `si`.`ID` AS `ID`,`si`.`Referencia` AS `Referencia`,`si`.`Nombre` AS `Nombre`,sum(`si`.`Cantidad`) AS `Cantidad`,`si`.`Departamento` AS `Departamento`,`si`.`SubGrupo1` AS `SubGrupo1`,`si`.`SubGrupo2` AS `SubGrupo2`,`si`.`SubGrupo3` AS `SubGrupo3`,`si`.`SubGrupo4` AS `SubGrupo4`,`si`.`SubGrupo5` AS `SubGrupo5` from (`separados_items` `si` join `separados` `s` on((`s`.`ID` = `si`.`idSeparado`))) where (`s`.`Estado` = 'Abierto') group by `si`.`Referencia`;

DROP TABLE IF EXISTS `vista_kardex`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_kardex` AS select `k`.`idKardexMercancias` AS `ID`,`k`.`Fecha` AS `Fecha`,`k`.`Movimiento` AS `Movimiento`,`k`.`Detalle` AS `Detalle`,`k`.`idDocumento` AS `idDocumento`,`k`.`Cantidad` AS `Cantidad`,`k`.`ValorUnitario` AS `ValorUnitario`,`k`.`ValorTotal` AS `ValorTotal`,`k`.`ProductosVenta_idProductosVenta` AS `ProductosVenta_idProductosVenta`,`pv`.`Referencia` AS `Referencia`,`pv`.`Nombre` AS `Nombre`,`pv`.`Existencias` AS `Existencias`,`pv`.`CostoUnitario` AS `CostoUnitario`,`pv`.`CostoTotal` AS `CostoTotal`,`pv`.`IVA` AS `IVA`,`pv`.`Departamento` AS `Departamento`,`pv`.`Sub1` AS `Sub1`,`pv`.`Sub2` AS `Sub2`,`pv`.`Sub3` AS `Sub3`,`pv`.`Sub4` AS `Sub4`,`pv`.`Sub5` AS `Sub5`,`k`.`Updated` AS `Updated`,`k`.`Sync` AS `Sync` from (`kardexmercancias` `k` join `productosventa` `pv` on((`k`.`ProductosVenta_idProductosVenta` = `pv`.`idProductosVenta`)));

DROP TABLE IF EXISTS `vista_libro_diario`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_libro_diario` AS select `librodiario`.`idLibroDiario` AS `idLibroDiario`,`librodiario`.`Fecha` AS `Fecha`,`librodiario`.`Tipo_Documento_Intero` AS `Tipo_Documento_Intero`,(select if((`librodiario`.`Tipo_Documento_Intero` = 'FACTURA'),(select `facturas`.`NumeroFactura` from `facturas` where (`facturas`.`idFacturas` = `librodiario`.`Num_Documento_Interno`)),`librodiario`.`Num_Documento_Interno`)) AS `NumDocumento`,`librodiario`.`Num_Documento_Externo` AS `Num_Documento_Externo`,`librodiario`.`Tercero_Tipo_Documento` AS `Tercero_Tipo_Documento`,`librodiario`.`Tercero_Identificacion` AS `Tercero_Identificacion`,`librodiario`.`Tercero_DV` AS `Tercero_DV`,`librodiario`.`Tercero_Primer_Apellido` AS `Tercero_Primer_Apellido`,`librodiario`.`Tercero_Segundo_Apellido` AS `Tercero_Segundo_Apellido`,`librodiario`.`Tercero_Primer_Nombre` AS `Tercero_Primer_Nombre`,`librodiario`.`Tercero_Otros_Nombres` AS `Tercero_Otros_Nombres`,`librodiario`.`Tercero_Razon_Social` AS `Tercero_Razon_Social`,`librodiario`.`Tercero_Direccion` AS `Tercero_Direccion`,`librodiario`.`Tercero_Cod_Dpto` AS `Tercero_Cod_Dpto`,`librodiario`.`Tercero_Cod_Mcipio` AS `Tercero_Cod_Mcipio`,`librodiario`.`Tercero_Pais_Domicilio` AS `Tercero_Pais_Domicilio`,`librodiario`.`Concepto` AS `Concepto`,`librodiario`.`CuentaPUC` AS `CuentaPUC`,`librodiario`.`NombreCuenta` AS `NombreCuenta`,`librodiario`.`Detalle` AS `Detalle`,`librodiario`.`Debito` AS `Debito`,`librodiario`.`Credito` AS `Credito`,`librodiario`.`Neto` AS `Neto`,`librodiario`.`idCentroCosto` AS `idCentroCosto`,`librodiario`.`idEmpresa` AS `idEmpresa`,`librodiario`.`idSucursal` AS `idSucursal`,`librodiario`.`Estado` AS `Estado`,`librodiario`.`idUsuario` AS `idUsuario` from `librodiario`;

DROP TABLE IF EXISTS `vista_nomina_servicios_turnos`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_nomina_servicios_turnos` AS select `nomina_servicios_turnos`.`ID` AS `ID`,`nomina_servicios_turnos`.`Fecha` AS `Fecha`,`nomina_servicios_turnos`.`Tercero` AS `Tercero`,`nomina_servicios_turnos`.`Sucursal` AS `Sucursal`,`nomina_servicios_turnos`.`Valor` AS `Valor`,`nomina_servicios_turnos`.`idUser` AS `idUser`,`nomina_servicios_turnos`.`Pagado` AS `Pagado`,`nomina_servicios_turnos`.`Estado` AS `Estado`,`nomina_servicios_turnos`.`idDocumentoEquivalente` AS `idDocumentoEquivalente`,`nomina_servicios_turnos`.`Updated` AS `Updated`,`nomina_servicios_turnos`.`Sync` AS `Sync`,(select `empresa_pro_sucursales`.`Nombre` from `empresa_pro_sucursales` where (`empresa_pro_sucursales`.`ID` = `nomina_servicios_turnos`.`Sucursal`) limit 1) AS `NombreSucursal`,(select `proveedores`.`RazonSocial` from `proveedores` where (`proveedores`.`Num_Identificacion` = `nomina_servicios_turnos`.`Tercero`) limit 1) AS `NombreTercero` from `nomina_servicios_turnos` where (`nomina_servicios_turnos`.`Estado` <> 'ANULADO');

DROP TABLE IF EXISTS `vista_notas_devolucion`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_notas_devolucion` AS select `factura_compra_notas_devolucion`.`ID` AS `ID`,`factura_compra_notas_devolucion`.`Fecha` AS `Fecha`,`factura_compra_notas_devolucion`.`Tercero` AS `Tercero`,`factura_compra_notas_devolucion`.`Concepto` AS `Concepto`,(select sum(`factura_compra_items_devoluciones`.`SubtotalCompra`) from `factura_compra_items_devoluciones` where (`factura_compra_items_devoluciones`.`idNotaDevolucion` = `factura_compra_notas_devolucion`.`ID`)) AS `Subtotal`,(select sum(`factura_compra_items_devoluciones`.`ImpuestoCompra`) from `factura_compra_items_devoluciones` where (`factura_compra_items_devoluciones`.`idNotaDevolucion` = `factura_compra_notas_devolucion`.`ID`)) AS `IVA`,(select sum(`factura_compra_items_devoluciones`.`TotalCompra`) from `factura_compra_items_devoluciones` where (`factura_compra_items_devoluciones`.`idNotaDevolucion` = `factura_compra_notas_devolucion`.`ID`)) AS `Total`,`factura_compra_notas_devolucion`.`idCentroCostos` AS `idCentroCostos`,`factura_compra_notas_devolucion`.`idSucursal` AS `idSucursal`,`factura_compra_notas_devolucion`.`idUser` AS `idUser`,`factura_compra_notas_devolucion`.`Estado` AS `Estado` from `factura_compra_notas_devolucion`;

DROP TABLE IF EXISTS `vista_ori_facturas`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_ori_facturas` AS select `fi`.`FechaFactura` AS `Fecha`,`fi`.`idFactura` AS `idFactura`,`fi`.`Referencia` AS `Referencia`,`fi`.`Nombre` AS `Nombre`,`fi`.`Departamento` AS `Departamento`,`fi`.`SubGrupo1` AS `SubGrupo1`,`fi`.`SubGrupo2` AS `SubGrupo2`,`fi`.`SubGrupo3` AS `SubGrupo3`,`fi`.`SubGrupo4` AS `SubGrupo4`,`fi`.`SubGrupo5` AS `SubGrupo5`,`fi`.`ValorUnitarioItem` AS `ValorUnitarioItem`,`fi`.`Cantidad` AS `Cantidad`,`fi`.`Dias` AS `Dias`,`fi`.`SubtotalItem` AS `SubtotalItem`,`fi`.`IVAItem` AS `IVAItem`,`fi`.`ValorOtrosImpuestos` AS `ValorOtrosImpuestos`,`fi`.`TotalItem` AS `TotalItem`,`fi`.`PorcentajeIVA` AS `PorcentajeIVA`,`fi`.`idOtrosImpuestos` AS `idOtrosImpuestos`,`fi`.`idPorcentajeIVA` AS `idPorcentajeIVA`,`fi`.`PrecioCostoUnitario` AS `PrecioCostoUnitario`,`fi`.`SubtotalCosto` AS `SubtotalCosto`,`fi`.`TipoItem` AS `TipoItem`,`fi`.`CuentaPUC` AS `CuentaPUC`,`fi`.`GeneradoDesde` AS `GeneradoDesde`,`fi`.`NumeroIdentificador` AS `NumeroIdentificador`,`fi`.`idUsuarios` AS `idUsuarios`,`fi`.`idCierre` AS `idCierre`,`f`.`idResolucion` AS `idResolucion`,`f`.`TipoFactura` AS `TipoFactura`,`f`.`Prefijo` AS `Prefijo`,`f`.`NumeroFactura` AS `NumeroFactura`,`f`.`Hora` AS `Hora`,`f`.`FormaPago` AS `FormaPago`,`f`.`CentroCosto` AS `CentroCosto`,`f`.`idSucursal` AS `idSucursal`,`f`.`EmpresaPro_idEmpresaPro` AS `EmpresaPro_idEmpresaPro`,`f`.`Clientes_idClientes` AS `Clientes_idClientes`,`f`.`ObservacionesFact` AS `ObservacionesFact` from (`ori_facturas_items` `fi` join `facturas` `f` on((`fi`.`idFactura` = `f`.`idFacturas`)));

DROP TABLE IF EXISTS `vista_pedidos_restaurante`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_pedidos_restaurante` AS select `restaurante_pedidos`.`ID` AS `ID`,`restaurante_pedidos`.`Fecha` AS `Fecha`,`restaurante_pedidos`.`Hora` AS `Hora`,`restaurante_pedidos`.`Estado` AS `Estado`,`restaurante_pedidos`.`idMesa` AS `idMesa`,`restaurante_pedidos`.`idCliente` AS `idCliente`,`restaurante_pedidos`.`NombreCliente` AS `NombreCliente`,`restaurante_pedidos`.`DireccionEnvio` AS `DireccionEnvio`,`restaurante_pedidos`.`TelefonoConfirmacion` AS `TelefonoConfirmacion`,`restaurante_pedidos`.`Observaciones` AS `Observaciones`,`restaurante_pedidos`.`idCierre` AS `idCierre`,(select sum(`restaurante_pedidos_items`.`Subtotal`) AS `Subtotal` from `restaurante_pedidos_items` where (`restaurante_pedidos_items`.`idPedido` = `restaurante_pedidos`.`ID`)) AS `Subtotal`,(select sum(`restaurante_pedidos_items`.`IVA`) AS `IVA` from `restaurante_pedidos_items` where (`restaurante_pedidos_items`.`idPedido` = `restaurante_pedidos`.`ID`)) AS `IVA`,(select sum(`restaurante_pedidos_items`.`Total`) AS `Total` from `restaurante_pedidos_items` where (`restaurante_pedidos_items`.`idPedido` = `restaurante_pedidos`.`ID`)) AS `Total`,`restaurante_pedidos`.`idUsuario` AS `idUsuario` from `restaurante_pedidos`;

DROP TABLE IF EXISTS `vista_preventa`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_preventa` AS select `p`.`VestasActivas_idVestasActivas` AS `VestasActivas_idVestasActivas`,'productosventa' AS `TablaItems`,`pv`.`Referencia` AS `Referencia`,`pv`.`Nombre` AS `Nombre`,`pv`.`Departamento` AS `Departamento`,`pv`.`Sub1` AS `SubGrupo1`,`pv`.`Sub2` AS `SubGrupo2`,`pv`.`Sub3` AS `SubGrupo3`,`pv`.`Sub4` AS `SubGrupo4`,`pv`.`Sub5` AS `SubGrupo5`,`p`.`ValorAcordado` AS `ValorUnitarioItem`,`p`.`Cantidad` AS `Cantidad`,'1' AS `Dias`,(`p`.`ValorAcordado` * `p`.`Cantidad`) AS `SubtotalItem`,((`p`.`ValorAcordado` * `p`.`Cantidad`) * `pv`.`IVA`) AS `IVAItem`,((select `productos_impuestos_adicionales`.`ValorImpuesto` from `productos_impuestos_adicionales` where (`productos_impuestos_adicionales`.`idProducto` = `p`.`ProductosVenta_idProductosVenta`)) * `p`.`Cantidad`) AS `ValorOtrosImpuestos`,((`p`.`ValorAcordado` * `p`.`Cantidad`) + ((`p`.`ValorAcordado` * `p`.`Cantidad`) * `pv`.`IVA`)) AS `TotalItem`,concat((`pv`.`IVA` * 100),'%') AS `PorcentajeIVA`,`pv`.`CostoUnitario` AS `PrecioCostoUnitario`,(`pv`.`CostoUnitario` * `p`.`Cantidad`) AS `SubtotalCosto`,(select `prod_departamentos`.`TipoItem` from `prod_departamentos` where (`prod_departamentos`.`idDepartamentos` = `pv`.`Departamento`)) AS `TipoItem`,`pv`.`CuentaPUC` AS `CuentaPUC`,`p`.`Updated` AS `Updated`,`p`.`Sync` AS `Sync` from (`preventa` `p` join `productosventa` `pv` on((`p`.`ProductosVenta_idProductosVenta` = `pv`.`idProductosVenta`))) where (`p`.`TablaItem` = 'productosventa');

DROP TABLE IF EXISTS `vista_resumen_facturacion`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_resumen_facturacion` AS select `facturas_items`.`ID` AS `ID`,`facturas_items`.`FechaFactura` AS `FechaInicial`,`facturas_items`.`FechaFactura` AS `FechaFinal`,`facturas_items`.`Referencia` AS `Referencia`,(select `productosventa`.`idProductosVenta` from `productosventa` where (`productosventa`.`Referencia` = `facturas_items`.`Referencia`)) AS `idProducto`,`facturas_items`.`Nombre` AS `Nombre`,`facturas_items`.`Departamento` AS `Departamento`,`facturas_items`.`SubGrupo1` AS `SubGrupo1`,`facturas_items`.`SubGrupo2` AS `SubGrupo2`,`facturas_items`.`SubGrupo3` AS `SubGrupo3`,`facturas_items`.`SubGrupo4` AS `SubGrupo4`,`facturas_items`.`SubGrupo5` AS `SubGrupo5`,sum(`facturas_items`.`Cantidad`) AS `Cantidad`,round(sum(`facturas_items`.`TotalItem`),2) AS `TotalVenta`,round(sum(`facturas_items`.`SubtotalCosto`),2) AS `Costo` from `facturas_items` group by `facturas_items`.`FechaFactura`,`facturas_items`.`Referencia`;

DROP TABLE IF EXISTS `vista_resumen_ventas_departamentos`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_resumen_ventas_departamentos` AS select `facturas_items`.`FechaFactura` AS `FechaFactura`,`facturas_items`.`Departamento` AS `Departamento`,`facturas_items`.`SubGrupo1` AS `SubGrupo1`,`facturas_items`.`SubGrupo2` AS `SubGrupo2`,`facturas_items`.`SubGrupo3` AS `SubGrupo3`,`facturas_items`.`SubGrupo4` AS `SubGrupo4`,`facturas_items`.`SubGrupo5` AS `SubGrupo5`,sum(`facturas_items`.`TotalItem`) AS `Total` from `facturas_items` group by `facturas_items`.`FechaFactura`,`facturas_items`.`Departamento`,`facturas_items`.`SubGrupo1`,`facturas_items`.`SubGrupo2`,`facturas_items`.`SubGrupo3`,`facturas_items`.`SubGrupo4`,`facturas_items`.`SubGrupo5`;

DROP TABLE IF EXISTS `vista_retenciones`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_retenciones` AS select `factura_compra_retenciones`.`idCompra` AS `idCompra`,(select `factura_compra`.`Fecha` from `factura_compra` where (`factura_compra`.`ID` = `factura_compra_retenciones`.`idCompra`)) AS `Fecha`,(select `factura_compra`.`Tercero` from `factura_compra` where (`factura_compra`.`ID` = `factura_compra_retenciones`.`idCompra`)) AS `Tercero`,(select `proveedores`.`RazonSocial` from `proveedores` where (`proveedores`.`Num_Identificacion` = (select `Tercero`)) limit 1) AS `RazonSocial`,(select `proveedores`.`DV` from `proveedores` where (`proveedores`.`Num_Identificacion` = (select `Tercero`)) limit 1) AS `DV`,(select `proveedores`.`Direccion` from `proveedores` where (`proveedores`.`Num_Identificacion` = (select `Tercero`)) limit 1) AS `Direccion`,(select `proveedores`.`Ciudad` from `proveedores` where (`proveedores`.`Num_Identificacion` = (select `Tercero`)) limit 1) AS `Ciudad`,`factura_compra_retenciones`.`CuentaPUC` AS `CuentaPUC`,`factura_compra_retenciones`.`NombreCuenta` AS `Cuenta`,`factura_compra_retenciones`.`ValorRetencion` AS `ValorRetencion`,`factura_compra_retenciones`.`PorcentajeRetenido` AS `PorcentajeRetenido`,round(((`factura_compra_retenciones`.`ValorRetencion` / `factura_compra_retenciones`.`PorcentajeRetenido`) * 100),2) AS `BaseRetencion`,(select `factura_compra`.`idEmpresa` from `factura_compra` where (`factura_compra`.`ID` = `factura_compra_retenciones`.`idCompra`)) AS `idEmpresa`,(select `factura_compra`.`idCentroCostos` from `factura_compra` where (`factura_compra`.`ID` = `factura_compra_retenciones`.`idCompra`)) AS `idCentroCostos`,(select `factura_compra`.`idSucursal` from `factura_compra` where (`factura_compra`.`ID` = `factura_compra_retenciones`.`idCompra`)) AS `idSucursal` from `factura_compra_retenciones`;

DROP TABLE IF EXISTS `vista_retenciones_tercero`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_retenciones_tercero` AS select `vista_retenciones`.`idCompra` AS `idCompra`,`vista_retenciones`.`Fecha` AS `Fecha`,`vista_retenciones`.`Tercero` AS `Tercero`,`vista_retenciones`.`RazonSocial` AS `RazonSocial`,`vista_retenciones`.`DV` AS `DV`,`vista_retenciones`.`Direccion` AS `Direccion`,`vista_retenciones`.`Ciudad` AS `Ciudad`,`vista_retenciones`.`CuentaPUC` AS `CuentaPUC`,`vista_retenciones`.`Cuenta` AS `Cuenta`,`vista_retenciones`.`ValorRetencion` AS `ValorRetencion`,`vista_retenciones`.`PorcentajeRetenido` AS `PorcentajeRetenido`,`vista_retenciones`.`BaseRetencion` AS `BaseRetencion` from `vista_retenciones` where ((`vista_retenciones`.`Fecha` >= '2019-01-20') and (`vista_retenciones`.`Fecha` <= '2019-01-20') and (`vista_retenciones`.`Tercero` = '94481747'));

DROP TABLE IF EXISTS `vista_sistemas`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_sistemas` AS select `si`.`ID` AS `ID`,`st`.`ID` AS `idSistema`,`st`.`Nombre` AS `Nombre_Sistema`,`st`.`Observaciones` AS `Observaciones`,`si`.`TablaOrigen` AS `TablaOrigen`,`s`.`idProductosVenta` AS `CodigoInterno`,`s`.`Nombre` AS `Nombre`,`si`.`Cantidad` AS `Cantidad`,`si`.`ValorUnitario` AS `PrecioUnitario`,round((`si`.`ValorUnitario` * `si`.`Cantidad`),0) AS `PrecioVenta`,round(`s`.`CostoUnitario`,0) AS `CostoUnitario`,round((`si`.`Cantidad` * `s`.`CostoUnitario`),0) AS `Costo_Total_Item`,`s`.`IVA` AS `IVA`,`s`.`Departamento` AS `Departamento`,`s`.`Sub1` AS `Sub1`,`s`.`Sub2` AS `Sub2`,`s`.`Sub3` AS `Sub3`,`s`.`Sub4` AS `Sub4`,`s`.`Sub5` AS `Sub5`,`st`.`Updated` AS `Updated`,`st`.`Sync` AS `Sync` from ((`sistemas_relaciones` `si` join `servicios` `s` on((`s`.`Referencia` = `si`.`Referencia`))) join `sistemas` `st` on((`st`.`ID` = `si`.`idSistema`))) union select `si`.`ID` AS `ID`,`st`.`ID` AS `idSistema`,`st`.`Nombre` AS `Nombre_Sistema`,`st`.`Observaciones` AS `Observaciones`,`si`.`TablaOrigen` AS `TablaOrigen`,`s`.`idProductosVenta` AS `CodigoInterno`,`s`.`Nombre` AS `Nombre`,`si`.`Cantidad` AS `Cantidad`,`si`.`ValorUnitario` AS `PrecioUnitario`,round((`si`.`ValorUnitario` * `si`.`Cantidad`),0) AS `PrecioVenta`,round(`s`.`CostoUnitario`,0) AS `CostoUnitario`,round((`si`.`Cantidad` * `s`.`CostoUnitario`),0) AS `Costo_Total_Item`,`s`.`IVA` AS `IVA`,`s`.`Departamento` AS `Departamento`,`s`.`Sub1` AS `Sub1`,`s`.`Sub2` AS `Sub2`,`s`.`Sub3` AS `Sub3`,`s`.`Sub4` AS `Sub4`,`s`.`Sub5` AS `Sub5`,`st`.`Updated` AS `Updated`,`st`.`Sync` AS `Sync` from ((`sistemas_relaciones` `si` join `productosventa` `s` on((`s`.`Referencia` = `si`.`Referencia`))) join `sistemas` `st` on((`st`.`ID` = `si`.`idSistema`)));

DROP TABLE IF EXISTS `vista_titulos_abonos`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_titulos_abonos` AS select `td`.`ID` AS `ID`,`td`.`Fecha` AS `Fecha`,`td`.`Hora` AS `Hora`,`td`.`Monto` AS `Monto`,`td`.`idVenta` AS `idVenta`,`tv`.`Promocion` AS `Promocion`,`tv`.`Mayor1` AS `Mayor`,`td`.`Observaciones` AS `Concepto`,`td`.`idColaborador` AS `idColaborador`,`td`.`NombreColaborador` AS `NombreColaborador`,`td`.`Estado` AS `Estado`,`td`.`idComprobanteIngreso` AS `idComprobanteIngreso`,`tv`.`Mayor2` AS `Mayor2`,`tv`.`Adicional` AS `Adicional`,`tv`.`Valor` AS `Valor`,`tv`.`TotalAbonos` AS `TotalAbonos`,`tv`.`Saldo` AS `Saldo`,`tv`.`idCliente` AS `idCliente`,`tv`.`NombreCliente` AS `NombreCliente` from (`titulos_abonos` `td` join `titulos_ventas` `tv` on((`td`.`idVenta` = `tv`.`ID`)));

DROP TABLE IF EXISTS `vista_titulos_comisiones`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_titulos_comisiones` AS select `td`.`ID` AS `ID`,`td`.`Fecha` AS `Fecha`,`td`.`Hora` AS `Hora`,`td`.`Monto` AS `Monto`,`td`.`idVenta` AS `idVenta`,`tv`.`Promocion` AS `Promocion`,`tv`.`Mayor1` AS `Mayor`,`td`.`Observaciones` AS `Concepto`,`td`.`idColaborador` AS `idColaborador`,`td`.`NombreColaborador` AS `NombreColaborador`,`td`.`idUsuario` AS `idUsuario`,`td`.`idEgreso` AS `idEgreso`,`tv`.`Mayor2` AS `Mayor2`,`tv`.`Adicional` AS `Adicional`,`tv`.`Valor` AS `Valor`,`tv`.`TotalAbonos` AS `TotalAbonos`,`tv`.`Saldo` AS `Saldo`,`tv`.`idCliente` AS `idCliente`,`tv`.`NombreCliente` AS `NombreCliente` from (`titulos_comisiones` `td` join `titulos_ventas` `tv` on((`td`.`idVenta` = `tv`.`ID`)));

DROP TABLE IF EXISTS `vista_titulos_devueltos`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_titulos_devueltos` AS select `td`.`ID` AS `ID`,`td`.`Fecha` AS `Fecha`,`td`.`idVenta` AS `idVenta`,`td`.`Promocion` AS `Promocion`,`td`.`Mayor` AS `Mayor`,`td`.`Concepto` AS `Concepto`,`td`.`idColaborador` AS `idColaborador`,`td`.`NombreColaborador` AS `NombreColaborador`,`td`.`idUsuario` AS `idUsuario`,`tv`.`Mayor2` AS `Mayor2`,`tv`.`Adicional` AS `Adicional`,`tv`.`Valor` AS `Valor`,`tv`.`TotalAbonos` AS `TotalAbonos`,`tv`.`Saldo` AS `Saldo`,`tv`.`idCliente` AS `idCliente`,`tv`.`NombreCliente` AS `NombreCliente` from (`titulos_devoluciones` `td` join `titulos_ventas` `tv` on((`td`.`idVenta` = `tv`.`ID`)));

DROP TABLE IF EXISTS `vista_totales_facturacion`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_totales_facturacion` AS select `facturas_items`.`FechaFactura` AS `FechaFactura`,sum(`facturas_items`.`Cantidad`) AS `Items`,round(sum(`facturas_items`.`SubtotalItem`),0) AS `Subtotal`,round(sum(`facturas_items`.`IVAItem`),0) AS `IVA`,round(sum(`facturas_items`.`ValorOtrosImpuestos`),0) AS `OtrosImpuestos`,round(sum(`facturas_items`.`TotalItem`),0) AS `Total` from `facturas_items` group by `facturas_items`.`FechaFactura`;

-- 2019-02-27 15:15:32
