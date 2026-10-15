<?php
// /src/Controllers/CuotaController.php

require_once ROOT_PATH . '/core/Controller.php';
require_once ROOT_PATH . '/src/Models/Cuota.php';

class CuotaController extends Controller
{
    /**
     * Muestra el listado de cuotas
     * (El acceso ya queda filtrado por la matriz RBAC en AuthMiddleware: ver_cuotas)
     */
    public function index()
    {
        $this->render('cuotas/index', [
            'titulo' => 'Mantenimiento de Cuotas - GreenPower',
            'cuotas' => Cuota::all()
        ]);
    }

    /**
     * Formulario de nueva cuota
     */
    public function create()
    {
        $this->render('cuotas/create', [
            'titulo' => 'Nueva Cuota - GreenPower'
        ]);
    }

    /**
     * Procesa el guardado
     */
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre  = trim($_POST['nombre_cuota'] ?? '');
            $importe = floatval($_POST['importe'] ?? 0);
            $activo  = isset($_POST['activo']) ? 1 : 0;

            if (!empty($nombre)) {
                AnaliticaDemo::resultado(Cuota::save($nombre, $importe, $activo));
            } else {
                AnaliticaDemo::resultado(false);
            }
            header('Location: ' . URL_ROOT . '/cuotas');
            exit;
        }
    }

    /**
     * Formulario de edición
     */
    public function edit()
    {
        $id = intval($_GET['id'] ?? 0);
        $cuota = Cuota::find($id);

        if (!$cuota) {
            header('Location: ' . URL_ROOT . '/cuotas');
            exit;
        }

        $this->render('cuotas/edit', [
            'titulo' => 'Editar Cuota - GreenPower',
            'cuota'  => $cuota
        ]);
    }

    /**
     * Procesa la actualización
     */
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id      = intval($_POST['id_cuota'] ?? 0);
            $nombre  = trim($_POST['nombre_cuota'] ?? '');
            $importe = floatval($_POST['importe'] ?? 0);
            $activo  = isset($_POST['activo']) ? 1 : 0;

            if ($id > 0 && !empty($nombre)) {
                AnaliticaDemo::resultado(Cuota::update($id, $nombre, $importe, $activo));
            } else {
                AnaliticaDemo::resultado(false);
            }
            header('Location: ' . URL_ROOT . '/cuotas');
            exit;
        }
    }
}
?>