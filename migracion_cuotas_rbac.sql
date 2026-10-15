-- ============================================================
-- Migración: Añadir permisos granulares para el módulo de Cuotas
-- Ejecutar UNA VEZ sobre la base de datos existente (phpMyAdmin / consola mysql)
-- ============================================================

ALTER TABLE `perfiles`
  ADD COLUMN `ver_cuotas`  tinyint(1) NOT NULL DEFAULT 0 AFTER `edit_variedades`,
  ADD COLUMN `edit_cuotas` tinyint(1) NOT NULL DEFAULT 0 AFTER `ver_cuotas`;

-- El Administrador Supremo (id_perfil = 1) siempre tiene acceso total
UPDATE `perfiles` SET `ver_cuotas` = 1, `edit_cuotas` = 1 WHERE `id_perfil` = 1;

-- (Opcional) Si quieres que el rol "colaborador" (id 2) pueda ver pero no editar cuotas, descomenta:
-- UPDATE `perfiles` SET `ver_cuotas` = 1, `edit_cuotas` = 0 WHERE `id_perfil` = 2;
