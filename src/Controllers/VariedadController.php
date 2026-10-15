<?php
// /src/Controllers/VariedadController.php

require_once ROOT_PATH . '/core/Controller.php';
require_once ROOT_PATH . '/src/Models/Variedad.php';

class VariedadController extends Controller {

    // Listar variedades
    public function index() {
        $this->render('variedades/index', [
            'titulo'     => 'Variedades y Tipos - GreenPower',
            'variedades' => Variedad::all()
        ]);
    }

    // Procesar alta por POST
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['variedad'] ?? '');
            $descripcion = trim($_POST['descripcion_variedad'] ?? '');

            if (!empty($nombre)) {
                AnaliticaDemo::resultado(Variedad::save($nombre, $descripcion));
            } else {
                AnaliticaDemo::resultado(false);
            }

            header('Location: ' . URL_ROOT . '/variedades');
            exit;
        }
    }

    // Formulario de edición
    public function edit() {
        $id = intval($_GET['id'] ?? 0);
        $variedad = Variedad::find($id);

        if (!$variedad) {
            header('Location: ' . URL_ROOT . '/variedades');
            exit;
        }

        $this->render('variedades/edit', [
            'titulo'   => 'Modificar Tipo - GreenPower',
            'variedad' => $variedad
        ]);
    }

    // Procesar cambios por POST
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval($_POST['id_variedad'] ?? 0);
            $nombre = trim($_POST['variedad'] ?? '');
            $descripcion = trim($_POST['descripcion_variedad'] ?? '');

            if (!empty($nombre)) {
                AnaliticaDemo::resultado(Variedad::update($id, $nombre, $descripcion));
            } else {
                AnaliticaDemo::resultado(false);
            }

            header('Location: ' . URL_ROOT . '/variedades');
            exit;
        }
    }
}
?>