<?php
// /src/Controllers/UserController.php

// 1. Cargamos el controlador base de forma segura usando la constante absoluta
require_once ROOT_PATH . '/core/Controller.php';

// 2. Cargamos los modelos necesarios para interactuar con la base de datos
require_once ROOT_PATH . '/src/Models/User.php';
require_once ROOT_PATH . '/src/Models/Perfil.php';

class UserController extends Controller {

    /**
     * Listar todos los usuarios/empleados registrados en el sistema
     */
    public function index() {
        $this->render('users/index', [
            'titulo'   => 'Gestión de Personal - GreenPower',
            'usuarios' => User::all()
        ]);
    }

    /**
     * Mostrar el formulario de alta para un nuevo empleado
     */
    public function create() {
        $this->render('users/create', [
            'titulo'   => 'Añadir Empleado - GreenPower',
            'perfiles' => Perfil::all() // Cargamos los roles dinámicos reales del SQL
        ]);
    }

    /**
     * Procesar la inserción de un nuevo empleado (POST)
     */
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = trim($_POST['password'] ?? '');

            // Verificar si el username ya está ocupado en el SQL
            if (User::findByUsername($username)) {
                $this->render('users/create', [
                    'titulo'   => 'Añadir Empleado - GreenPower',
                    'error'    => "El nombre de usuario '{$username}' ya está registrado.",
                    'perfiles' => Perfil::all()
                ]);
                return;
            }

            $data = [
                'nombre'    => trim($_POST['nombre'] ?? ''),
                'apellidos' => trim($_POST['apellidos'] ?? ''),
                'email'     => trim($_POST['email'] ?? ''),
                'username'  => $username,
                'password'  => password_hash($password, PASSWORD_BCRYPT), // Encriptación segura BCRYPT
                'perfil_id' => intval($_POST['perfil_id'] ?? 3),
                'activo'    => isset($_POST['activo']) ? 1 : 0
            ];

            if (User::save($data)) {
                AnaliticaDemo::resultado(true);
                header('Location: ' . URL_ROOT . '/usuarios');
                exit;
            } else {
                AnaliticaDemo::resultado(false);
                die("Error crítico: No se pudo guardar el registro del empleado.");
            }
        }
    }

    /**
     * Mostrar el formulario de edición de un empleado existente
     */
    public function edit() {
        $id = intval($_GET['id'] ?? 0);
        $usuario = User::find($id);

        if (!$usuario) {
            header('Location: ' . URL_ROOT . '/usuarios');
            exit;
        }

        $this->render('users/edit', [
            'titulo'   => 'Editar Empleado - GreenPower',
            'usuario'  => $usuario,
            'perfiles' => Perfil::all() // Cargamos los roles dinámicos reales del SQL
        ]);
    }

    /**
     * Procesar la actualización de los datos del empleado (POST)
     */
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval($_POST['id_user'] ?? 0);
            $userOriginal = User::find($id);

            if (!$userOriginal) {
                AnaliticaDemo::resultado(false);
                header('Location: ' . URL_ROOT . '/usuarios');
                exit;
            }

            $username = trim($_POST['username'] ?? '');
            
            // Validación de seguridad: el nuevo username no debe pertenecer a otro empleado diferente
            $userExistente = User::findByUsername($username);
            if ($userExistente && $userExistente['id_user'] != $id) {
                $this->render('users/edit', [
                    'titulo'   => 'Editar Empleado - GreenPower',
                    'error'    => "El nombre de usuario '{$username}' ya está siendo usado por otro empleado.",
                    'usuario'  => User::find($id),
                    'perfiles' => Perfil::all()
                ]);
                return;
            }

            // Datos estructurados del formulario
            $data = [
                'nombre'    => trim($_POST['nombre'] ?? ''),
                'apellidos' => trim($_POST['apellidos'] ?? ''),
                'email'     => trim($_POST['email'] ?? ''),
                'username'  => $username,
                'perfil_id' => intval($_POST['perfil_id'] ?? 3),
                'activo'    => isset($_POST['activo']) ? 1 : 0
            ];

            // Lógica inteligente para la contraseña opcional
            $passwordNueva = trim($_POST['password'] ?? '');
            $updatePassword = false;

            if (!empty($passwordNueva)) {
                $data['password'] = password_hash($passwordNueva, PASSWORD_BCRYPT);
                $updatePassword = true;
            }

            // Guardar cambios invocando al modelo
            if (User::update($id, $data, $updatePassword)) {
                AnaliticaDemo::resultado(true);
                header('Location: ' . URL_ROOT . '/usuarios');
                exit;
            } else {
                AnaliticaDemo::resultado(false);
                die("Error crítico: No se pudieron salvar las modificaciones del empleado.");
            }
        }
    }
}
?>