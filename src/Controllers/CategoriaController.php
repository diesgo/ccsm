<?php
// /src/Controllers/CategoriaController.php

require_once ROOT_PATH . '/core/Controller.php';
require_once ROOT_PATH . '/src/Models/Categoria.php';

class CategoriaController extends Controller {

    // Listar todas las categorías
    public function index() {
        $this->render('categorias/index', [
            'titulo'     => 'Categorías de Inventario - GreenPower',
            'categorias' => Categoria::all()
        ]);
    }

    // Procesar la creación de una nueva categoría (POST)
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre      = trim($_POST['categoria'] ?? '');
            $activo      = isset($_POST['activo']) ? 1 : 0;
            $servicio_id = intval($_POST['servicio_id'] ?? 2);
            $icono = is_string($_POST['icono'] ?? '') ? trim($_POST['icono'] ?? '') : null;

            $error = null;
            if ($nombre === '') {
                $error = 'Introduce el nombre de la categoría.';
            } elseif ($icono === null || !array_key_exists($icono, Categoria::iconosDisponibles())) {
                $error = 'Selecciona un icono válido.';
            } elseif (!Categoria::save($nombre, $activo, $servicio_id, $icono)) {
                $error = 'No se pudo guardar la categoría. Revisa el registro de errores del servidor.';
            }
            if ($error !== null) {
                $this->render('categorias/index', [
                    'titulo' => 'Categorías de Inventario - GreenPower',
                    'categorias' => Categoria::all(),
                    'formulario' => ['categoria' => $nombre, 'activo' => $activo, 'servicio_id' => $servicio_id, 'icono' => $icono ?? ''],
                    'error' => $error
                ]);
                return;
            }

            AnaliticaDemo::resultado(true);
            header('Location: ' . URL_ROOT . '/categorias');
            exit;
        }
    }

    // Mostrar formulario de edición
    public function edit() {
        $id = intval($_GET['id'] ?? 0);
        $categoria = Categoria::find($id);

        if (!$categoria) {
            header('Location: ' . URL_ROOT . '/categorias');
            exit;
        }

        $this->render('categorias/edit', [
            'titulo'    => 'Modificar Categoría - GreenPower',
            'categoria' => $categoria
        ]);
    }

    // Procesa la actualización de la categoría desde el formulario (POST)
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id          = intval($_POST['id_categoria'] ?? 0);
            $nombre      = trim($_POST['categoria'] ?? '');
            $activo      = isset($_POST['activo']) ? 1 : 0;
            $servicio_id = intval($_POST['servicio_id'] ?? 2);
            $icono = is_string($_POST['icono'] ?? '') ? trim($_POST['icono'] ?? '') : null;
            $categoria = Categoria::find($id);
            if (!$categoria) {
                http_response_code(404);
                $this->render('categorias/index', [
                    'titulo' => 'Categorías de Inventario - GreenPower',
                    'categorias' => Categoria::all(),
                    'error' => 'La categoría no existe.'
                ]);
                return;
            }
            $error = null;
            if ($nombre === '') {
                $error = 'Introduce el nombre de la categoría.';
            } elseif ($icono === null || !array_key_exists($icono, Categoria::iconosDisponibles())) {
                $error = 'Selecciona un icono válido.';
            } elseif (!Categoria::update($id, $nombre, $activo, $servicio_id, $icono)) {
                $error = 'No se pudo guardar la categoría. Revisa el registro de errores del servidor.';
            }
            if ($error !== null) {
                $this->render('categorias/edit', [
                    'titulo' => 'Modificar Categoría - GreenPower',
                    'categoria' => array_merge($categoria, ['categoria' => $nombre, 'activo' => $activo, 'servicio_id' => $servicio_id, 'icono' => $icono ?? '']),
                    'error' => $error
                ]);
                return;
            }

            AnaliticaDemo::resultado(true);
            header('Location: ' . URL_ROOT . '/categorias');
            exit;
        }
    }

}
?>