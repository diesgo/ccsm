<?php

class AnaliticaDemo
{
    private static $resultado = null;

    public static function resultado($correcto)
    {
        self::$resultado = $correcto === true ? 'ok' : 'error';
    }

    public static function ruta($ruta, $metodo)
    {
        $partes = explode('/', strtolower(trim($ruta, '/')));
        $seccion = $partes[0] === '' ? 'panel' : $partes[0];
        $seccion = ['personal' => 'usuarios', 'roles' => 'perfiles'][$seccion] ?? $seccion;
        if (!in_array($seccion, ['panel', 'socios', 'productos', 'categorias', 'usuarios', 'personal',
            'perfiles', 'proveedores', 'variedades', 'cuotas', 'configuracion', 'compras', 'dispensario', 'informes'], true)) {
            return null;
        }
        $accion = $partes[1] ?? 'visitar';
        if (count($partes) > 2 || !in_array($accion, ['visitar', 'nuevo', 'crear', 'editar', 'guardar',
            'actualizar', 'eliminar', 'socio', 'recargar', 'cobrar', 'anular', 'factura', 'ticket', 'demo'], true)) {
            return null;
        }
        // Las consultas del socio y las fotos son datos auxiliares, no nuevas visitas.
        if ($seccion === 'dispensario' && $accion === 'socio') {
            return null;
        }
        return ['seccion' => $seccion, 'accion' => $metodo === 'GET' && in_array($accion, ['nuevo', 'crear', 'editar'], true) ? 'abrir_formulario' : $accion];
    }

    public static function registrarPeticion($ruta, $metodo)
    {
        if (empty($_SESSION['demo']['registro_id'])) {
            return;
        }
        $evento = self::ruta($ruta, $metodo);
        if ($evento === null) {
            return;
        }
        $id = $_SESSION['demo']['registro_id'];
        if ($evento['seccion'] === 'informes' && $evento['accion'] === 'visitar') {
            $tipo = $_GET['tipo'] ?? 'ventas';
            if (is_string($tipo) && in_array($tipo, ['ventas', 'compras', 'productos', 'socios'], true)) {
                $evento['accion'] = 'informe_' . $tipo;
            }
        }
        register_shutdown_function(static function () use ($id, $evento) {
            $codigo = http_response_code() ?: 200;
            $esOperacion = in_array($evento['accion'], ['guardar', 'actualizar', 'eliminar', 'cobrar', 'recargar', 'anular'], true);
            $resultado = self::$resultado ?? ($esOperacion ? 'desconocido' : 'ok');
            if ($codigo >= 400) {
                $resultado = 'error';
            }
            $fatal = error_get_last();
            if ($fatal && in_array($fatal['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR], true)) {
                $resultado = 'error';
            }
            if ($esOperacion && (($evento['seccion'] === 'productos' && !empty($_SESSION['producto_imagen_error']))
                || ($evento['seccion'] === 'socios' && !empty($_SESSION['socio_actualizacion_error'])))) {
                $resultado = 'error';
            }
            try {
                RegistroDemo::evento($id, $evento['seccion'], $evento['accion'], $resultado);
                foreach (['imagen_producto', 'imagen_perfil', 'idFront', 'idBack'] as $campo) {
                    if (isset($_FILES[$campo]['error']) && $_FILES[$campo]['error'] !== UPLOAD_ERR_NO_FILE) {
                        RegistroDemo::evento($id, $evento['seccion'], 'subir_imagen', $resultado);
                    }
                }
            } catch (PDOException $e) {
                error_log('No se pudo registrar una acción de la demo (SQLSTATE ' . $e->getCode() . ').');
            }
        });
    }
}
