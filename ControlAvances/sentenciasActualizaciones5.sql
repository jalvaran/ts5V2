ALTER TABLE `cotizacionesv5` CHANGE `Fecha` `Fecha` DATE NOT NULL;
ALTER TABLE `cotizacionesv5` ADD `Estado` VARCHAR(25) NOT NULL AFTER `Seguimiento`;
ALTER TABLE `cotizacionesv5` ADD INDEX(`Estado`);