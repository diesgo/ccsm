<?php
// /src/Controllers/PerfilController.php

require_once ROOT_PATH . '/core/Controller.php';
require_once ROOT_PATH . '/src/Models/Perfil.php';

class PerfilController extends Controller {

    // Listar todos los roles existentes
    public function index() {
        $this->render('perfiles/index', [
            'titulo'   => 'Roles y Permisos - GreenPower',
            'perfiles' => Perfil::all()
        ]);
    }

    // Procesar la creación de un nuevo rol (POST)
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombrePerfil = trim($_POST['perfil'] ?? '');

            if (empty($nombrePerfil)) {
                AnaliticaDemo::resultado(false);
                header('Location: ' . URL_ROOT . '/perfiles');
                exit;
            }

            AnaliticaDemo::resultado(Perfil::save($nombrePerfil));
            header('Location: ' . URL_ROOT . '/perfiles');
            exit;
        }
    }

    // Mostrar formulario de edición de un rol
    public function edit() {
        $id = intval($_GET['id'] ?? 0);
        $perfil = Perfil::find($id);

        if (!$perfil) {
            header('Location: ' . URL_ROOT . '/perfiles');
            exit;
        }

        $this->render('perfiles/edit', [
            'titulo' => 'Modificar Rol - GreenPower',
            'perfil' => $perfil
        ]);
    }

    // Procesar la actualización del nombre y permisos de un rol (POST)
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval($_POST['id_perfil'] ?? 0);
            $nombrePerfil = trim($_POST['perfil'] ?? '');

            // Empaquetamos los 24 estados binarios del formulario (8 módulos x Ver/Crear/Editar)
            $permisos = [
                'ver_socios'         => isset($_POST['ver_socios']) ? 1 : 0,
                'crear_socios'       => isset($_POST['crear_socios']) ? 1 : 0,
                'edit_socios'        => isset($_POST['edit_socios']) ? 1 : 0,
                'ver_productos'      => isset($_POST['ver_productos']) ? 1 : 0,
                'crear_productos'    => isset($_POST['crear_productos']) ? 1 : 0,
                'edit_productos'     => isset($_POST['edit_productos']) ? 1 : 0,
                'ver_variedades'     => isset($_POST['ver_variedades']) ? 1 : 0,
                'crear_variedades'   => isset($_POST['crear_variedades']) ? 1 : 0,
                'edit_variedades'    => isset($_POST['edit_variedades']) ? 1 : 0,
                'ver_categorias'     => isset($_POST['ver_categorias']) ? 1 : 0,
                'crear_categorias'   => isset($_POST['crear_categorias']) ? 1 : 0,
                'edit_categorias'    => isset($_POST['edit_categorias']) ? 1 : 0,
                'ver_proveedores'    => isset($_POST['ver_proveedores']) ? 1 : 0,
                'crear_proveedores'  => isset($_POST['crear_proveedores']) ? 1 : 0,
                'edit_proveedores'   => isset($_POST['edit_proveedores']) ? 1 : 0,
                'ver_personal'       => isset($_POST['ver_personal']) ? 1 : 0,
                'crear_personal'     => isset($_POST['crear_personal']) ? 1 : 0,
                'edit_personal'      => isset($_POST['edit_personal']) ? 1 : 0,
                'ver_roles'          => isset($_POST['ver_roles']) ? 1 : 0,
                'crear_roles'        => isset($_POST['crear_roles']) ? 1 : 0,
                'edit_roles'         => isset($_POST['edit_roles']) ? 1 : 0,
                'ver_cuotas'         => isset($_POST['ver_cuotas']) ? 1 : 0,
                'crear_cuotas'       => isset($_POST['crear_cuotas']) ? 1 : 0,
                'edit_cuotas'        => isset($_POST['edit_cuotas']) ? 1 : 0
            ];

            // Candado de Seguridad: El Administrador maestro siempre retiene el acceso total a todas las llaves
            if ($id === 1) { 
                $permisos = [
                    'ver_socios' => 1, 'crear_socios' => 1, 'edit_socios' => 1,
                    'ver_productos' => 1, 'crear_productos' => 1, 'edit_productos' => 1,
                    'ver_variedades' => 1, 'crear_variedades' => 1, 'edit_variedades' => 1,
                    'ver_categorias' => 1, 'crear_categorias' => 1, 'edit_categorias' => 1,
                    'ver_proveedores' => 1, 'crear_proveedores' => 1, 'edit_proveedores' => 1,
                    'ver_personal' => 1, 'crear_personal' => 1, 'edit_personal' => 1,
                    'ver_roles' => 1, 'crear_roles' => 1, 'edit_roles' => 1,
                    'ver_cuotas' => 1, 'crear_cuotas' => 1, 'edit_cuotas' => 1
                ];
            }

            if (!empty($nombrePerfil)) {
                // Pasamos los parámetros ordenados directos hacia tu modelo Perfil.php
                AnaliticaDemo::resultado(Perfil::update($id, $nombrePerfil, $permisos));
            } else {
                AnaliticaDemo::resultado(false);
            }

            header('Location: ' . URL_ROOT . '/perfiles');
            exit;
        }
    }



}
?>