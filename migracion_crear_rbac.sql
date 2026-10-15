-- ============================================================
-- Migración: Añadir el tercer nivel de permisos (CREAR) a la matriz RBAC
-- Pasa la matriz de 2 niveles (Ver / Editar) a 3 niveles (Ver / Crear / Editar)
-- Ejecutar UNA VEZ sobre la base de datos existente (phpMyAdmin / consola mysql)
-- ============================================================

ALTER TABLE `perfiles`
  ADD COLUMN `crear_socios`      tinyint(1) NOT NULL DEFAULT 0 AFTER `ver_socios`,
  ADD COLUMN `crear_productos`   tinyint(1) NOT NULL DEFAULT 0 AFTER `ver_productos`,
  ADD COLUMN `crear_variedades`  tinyint(1) NOT NULL DEFAULT 0 AFTER `ver_variedades`,
  ADD COLUMN `crear_categorias`  tinyint(1) NOT NULL DEFAULT 0 AFTER `ver_categorias`,
  ADD COLUMN `crear_proveedores` tinyint(1) NOT NULL DEFAULT 0 AFTER `ver_proveedores`,
  ADD COLUMN `crear_personal`    tinyint(1) NOT NULL DEFAULT 0 AFTER `ver_personal`,
  ADD COLUMN `crear_roles`       tinyint(1) NOT NULL DEFAULT 0 AFTER `ver_roles`,
  ADD COLUMN `crear_cuotas`      tinyint(1) NOT NULL DEFAULT 0 AFTER `ver_cuotas`;

-- El Administrador Supremo (id_perfil = 1) siempre tiene acceso total
UPDATE `perfiles` SET
  crear_socios = 1, crear_productos = 1, crear_variedades = 1, crear_categorias = 1,
  crear_proveedores = 1, crear_personal = 1, crear_roles = 1, crear_cuotas = 1
WHERE `id_perfil` = 1;

-- (Opcional) Si quieres que un rol que ya tenía "Ver y Editar" en un módulo también pueda Crear
-- de forma automática al migrar (mantener el comportamiento antiguo), descomenta esta línea:
-- UPDATE `perfiles` SET crear_socios=edit_socios, crear_productos=edit_productos, crear_variedades=edit_variedades,
--   crear_categorias=edit_categorias, crear_proveedores=edit_proveedores, crear_personal=edit_personal,
--   crear_roles=edit_roles, crear_cuotas=edit_cuotas WHERE id_perfil <> 1;
