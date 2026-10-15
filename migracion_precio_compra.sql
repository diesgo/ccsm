-- ============================================================
-- Migración: precio de compra del producto y margen de beneficio configurable
-- Ejecutar UNA VEZ sobre la base de datos existente (phpMyAdmin / consola mysql)
-- ============================================================

ALTER TABLE `productos`
  ADD COLUMN IF NOT EXISTS `precio_compra` decimal(9,2) DEFAULT NULL AFTER `pvp`;

INSERT IGNORE INTO `configuracion_sistema` (`clave`, `valor`, `descripcion`) VALUES
  ('margen_beneficio', '30', 'Porcentaje de beneficio sobre el precio de compra para calcular el precio orientativo de venta.');
