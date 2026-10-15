<?php
// /src/Controllers/ProveedorController.php

require_once ROOT_PATH . '/core/Controller.php';
require_once ROOT_PATH . '/src/Models/Proveedor.php';

class ProveedorController extends Controller {

    // Listar todos los proveedores
    public function index() {
        $this->render('proveedores/index', [
            'titulo'      => 'Gestión de Proveedores - GreenPower',
            'proveedores' => Proveedor::all()
        ]);
    }

    // Procesar inserción por POST
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['proveedor'] ?? '');
            $descripcion = trim($_POST['descripcion_proveedor'] ?? '');

            if (!empty($nombre)) {
                AnaliticaDemo::resultado(Proveedor::save($nombre, $descripcion));
            } else {
                AnaliticaDemo::resultado(false);
            }

            header('Location: ' . URL_ROOT . '/proveedores');
            exit;
        }
    }

    // Mostrar formulario de edición
    public function edit() {
        $id = intval($_GET['id'] ?? 0);
        $proveedor = Proveedor::find($id);

        if (!$proveedor) {
            header('Location: ' . URL_ROOT . '/proveedores');
            exit;
        }

        $this->render('proveedores/edit', [
            'titulo'    => 'Modificar Proveedor - GreenPower',
            'proveedor' => $proveedor
        ]);
    }

    // Procesar modificaciones por POST
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval($_POST['id_proveedor'] ?? 0);
            $nombre = trim($_POST['proveedor'] ?? '');
            $descripcion = trim($_POST['descripcion_proveedor'] ?? '');

            if (!empty($nombre)) {
                AnaliticaDemo::resultado(Proveedor::update($id, $nombre, $descripcion));
            } else {
                AnaliticaDemo::resultado(false);
            }

            header('Location: ' . URL_ROOT . '/proveedores');
            exit;
        }
    }
}
?>