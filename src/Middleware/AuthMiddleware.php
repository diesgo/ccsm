<?php
// /src/Middleware/AuthMiddleware.php

class AuthMiddleware {
    private static $rutasPublicas = ['login', 'logout', 'demo/entrar', 'demo/salir', 'demo/actividad', 'contacto'];

    public static function handle($url) {
        // 🌟 CORRECCIÓN ATÓMICA DE PRODUCCIÓN: 
        // Si la URL que viene del servidor contiene la palabra 'login', cortamos el paso y le dejamos entrar a la vista sin bucles
        if (strpos($url, 'login') !== false || in_array($url, self::$rutasPublicas)) { 
            return; 
        }

        if (empty($url) && !isset($_SESSION['user_id'])) {
            header('Location: ' . URL_ROOT . '/login');
            exit;
        }

        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . URL_ROOT . '/login');
            exit;
        }

        // 🌟 CANDADO DE INMUNIDAD SUPREMA: Si eres el Administrador Maestro (ID 1), pasas directo a todo sin consultar la BBDD
        $perfilId = intval($_SESSION['perfil_id'] ?? 0);
        if ($perfilId === 1) { 
            return; 
        }
        if ($url === 'informes' || strpos($url, 'informes/') === 0) {
            self::denegarAcceso();
        }

        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("SELECT * FROM perfiles WHERE id_perfil = :id LIMIT 1");
            $stmt->execute(['id' => $perfilId]);
            $permisos = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$permisos) { self::denegarAcceso(); }

            // ====================================================================
            // 🛡️ MATRIZ RBAC: VALIDACIÓN GRANULAR DE RUTAS (VER / CREAR / EDITAR)
            // ====================================================================

            // 1. Módulo de Categorías
            if (
                (strpos($url, 'categorias') === 0)
                && intval($permisos['ver_categorias']) !== 1
                && intval($permisos['edit_categorias']) !== 1
            ) {
                self::denegarAcceso();
            }
            if ((strpos($url, 'categorias/nuevo') === 0 || strpos($url, 'categorias/guardar') === 0) && intval($permisos['crear_categorias']) !== 1) {
                self::denegarAcceso();
            }
            if ((strpos($url, 'categorias/editar') === 0 || strpos($url, 'categorias/actualizar') === 0 || strpos($url, 'categorias/eliminar') === 0) && intval($permisos['edit_categorias']) !== 1) {
                self::denegarAcceso();
            }

            // 2. Módulo de Personal / Usuarios (con su alias /personal)
            if ((strpos($url, 'usuarios') === 0 || strpos($url, 'personal') === 0) && intval($permisos['ver_personal']) !== 1) {
                self::denegarAcceso();
            }
            if ((strpos($url, 'usuarios/nuevo') === 0 || strpos($url, 'usuarios/guardar') === 0 || strpos($url, 'personal/nuevo') === 0 || strpos($url, 'personal/guardar') === 0) && intval($permisos['crear_personal']) !== 1) {
                self::denegarAcceso();
            }
            if ((strpos($url, 'usuarios/editar') === 0 || strpos($url, 'usuarios/actualizar') === 0 || strpos($url, 'usuarios/eliminar') === 0 || strpos($url, 'personal/editar') === 0 || strpos($url, 'personal/actualizar') === 0 || strpos($url, 'personal/eliminar') === 0) && intval($permisos['edit_personal']) !== 1) {
                self::denegarAcceso();
            }

            // 3. Módulo de Roles / Perfiles (con su alias /roles)
            if ((strpos($url, 'perfiles') === 0 || strpos($url, 'roles') === 0) && intval($permisos['ver_roles']) !== 1) {
                self::denegarAcceso();
            }
            if ((strpos($url, 'perfiles/nuevo') === 0 || strpos($url, 'perfiles/guardar') === 0 || strpos($url, 'roles/nuevo') === 0 || strpos($url, 'roles/guardar') === 0) && intval($permisos['crear_roles']) !== 1) {
                self::denegarAcceso();
            }
            if ((strpos($url, 'perfiles/editar') === 0 || strpos($url, 'perfiles/actualizar') === 0 || strpos($url, 'perfiles/eliminar') === 0 || strpos($url, 'roles/editar') === 0 || strpos($url, 'roles/actualizar') === 0 || strpos($url, 'roles/eliminar') === 0) && intval($permisos['edit_roles']) !== 1) {
                self::denegarAcceso();
            }

            // 4. Módulo de Proveedores
            if ((strpos($url, 'proveedores') === 0) && intval($permisos['ver_proveedores']) !== 1) {
                self::denegarAcceso();
            }
            if ((strpos($url, 'proveedores/nuevo') === 0 || strpos($url, 'proveedores/guardar') === 0) && intval($permisos['crear_proveedores']) !== 1) {
                self::denegarAcceso();
            }
            if ((strpos($url, 'proveedores/editar') === 0 || strpos($url, 'proveedores/actualizar') === 0 || strpos($url, 'proveedores/eliminar') === 0) && intval($permisos['edit_proveedores']) !== 1) {
                self::denegarAcceso();
            }

            // 5. Módulo Administrativo de Socios
            if ((strpos($url, 'socios') === 0) && intval($permisos['ver_socios']) !== 1) {
                self::denegarAcceso();
            }
            if ((strpos($url, 'socios/nuevo') === 0 || strpos($url, 'socios/guardar') === 0) && intval($permisos['crear_socios']) !== 1) {
                self::denegarAcceso();
            }
            if ((strpos($url, 'socios/editar') === 0 || strpos($url, 'socios/actualizar') === 0 || strpos($url, 'socios/eliminar') === 0) && intval($permisos['edit_socios']) !== 1) {
                self::denegarAcceso();
            }

            // 6. Módulo Administrativo de Productos
            if ((strpos($url, 'productos') === 0) && intval($permisos['ver_productos']) !== 1) {
                self::denegarAcceso();
            }
            if ((strpos($url, 'productos/nuevo') === 0 || strpos($url, 'productos/guardar') === 0) && intval($permisos['crear_productos']) !== 1) {
                self::denegarAcceso();
            }
            if ((strpos($url, 'productos/editar') === 0 || strpos($url, 'productos/actualizar') === 0 || strpos($url, 'productos/eliminar') === 0) && intval($permisos['edit_productos']) !== 1) {
                self::denegarAcceso();
            }

            // 7. Módulo Administrativo de Variedades
            if ((strpos($url, 'variedades') === 0) && intval($permisos['ver_variedades']) !== 1) {
                self::denegarAcceso();
            }
            if ((strpos($url, 'variedades/nuevo') === 0 || strpos($url, 'variedades/guardar') === 0) && intval($permisos['crear_variedades']) !== 1) {
                self::denegarAcceso();
            }
            if ((strpos($url, 'variedades/editar') === 0 || strpos($url, 'variedades/actualizar') === 0 || strpos($url, 'variedades/eliminar') === 0) && intval($permisos['edit_variedades']) !== 1) {
                self::denegarAcceso();
            }

            // 8. Módulo de Cuotas (tarifas de socio)
            if ((strpos($url, 'cuotas') === 0) && intval($permisos['ver_cuotas']) !== 1) {
                self::denegarAcceso();
            }
            if ((strpos($url, 'cuotas/nuevo') === 0 || strpos($url, 'cuotas/guardar') === 0) && intval($permisos['crear_cuotas']) !== 1) {
                self::denegarAcceso();
            }
            if ((strpos($url, 'cuotas/editar') === 0 || strpos($url, 'cuotas/actualizar') === 0 || strpos($url, 'cuotas/eliminar') === 0) && intval($permisos['edit_cuotas']) !== 1) {
                self::denegarAcceso();
            }

        } catch (PDOException $e) {
            self::denegarAcceso();
        }
    }

    private static function denegarAcceso() {
        header("HTTP/1.1 403 Forbidden");
        $rutaPanel = htmlspecialchars(rtrim(URL_ROOT, '/') . '/', ENT_QUOTES, 'UTF-8');
        echo "<!DOCTYPE html><html lang='es'><head><meta charset='UTF-8'><title>Acceso Denegado</title><link href='" . URL_ROOT . "/css/bootstrap.min.css' rel='stylesheet'></head><body class='bg-light d-flex align-items-center justify-content-center' style='min-height: 100vh;'><div class='text-center p-5 card shadow border-0 rounded-3' style='max-width: 500px;'><i class='bi bi-shield-slash text-danger display-1 mb-4'></i><h1 class='h3 fw-bold text-dark mb-2'>Acceso Restringido</h1><p class='text-muted mb-4'>Tu rol de usuario actual no tiene asignados los privilegios dinámicos para operar en este módulo.</p><a href='" . $rutaPanel . "' class='btn btn-dark fw-bold px-4 shadow-sm'><i class='bi bi-arrow-left me-1'></i> Volver al Panel</a></div></body></html>";
        exit;
    }
}
?>
