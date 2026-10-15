<?php
// /src/Controllers/SocioController.php

// 1. Cargamos el controlador base de forma segura usando la constante absoluta
require_once ROOT_PATH . '/core/Controller.php';

// 2. Cargamos los modelos necesarios para interactuar con la base de datos
require_once ROOT_PATH . '/src/Models/Socio.php';
require_once ROOT_PATH . '/src/Models/Perfil.php';

class SocioController extends Controller
{

    /**
     * Muestra el listado general de todos los socios registrados
     */
    public function index()
    {
        // Obtenemos los socios desde el modelo relacional
        $busqueda = trim((string) ($_GET['q'] ?? ''));
        $listaSocios = Socio::all($busqueda);

        // Enviamos los datos empaquetados a la vista de Bootstrap en local
        $this->render('socios/index', [
            'titulo' => 'Gestión de Socios - GreenPower',
            'socios' => $listaSocios,
            'busqueda' => $busqueda
        ]);
    }

    /**
     * Muestra el formulario para inscribir un nuevo socio en el club
     */
    public function create()
    {
        $this->render('socios/create', [
            'titulo'   => 'Nuevo Socio - GreenPower',
            'generos'  => Socio::getGeneros(),
            'paises'   => Socio::getPaises(),
            'cuotas'   => Socio::getCuotas() // 🌟 Inyectamos las tarifas de la nueva tabla maestra
        ]);
    }

    /**
     * Procesa la inserción de un nuevo socio (POST) - CONFIGURADO DE FORMA SEGURA
     */
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (ob_get_length()) ob_clean();

            // Los usuarios rasos mandarán cuota_id = 1 de forma automatizada por el input hidden
            $data = [
                'nombre'    => trim($_POST['nombre'] ?? ''),
                'apellidos' => trim($_POST['apellidos'] ?? ''),
                'card_id'   => trim($_POST['card_id'] ?? ''),
                'birth'     => trim($_POST['birth'] ?? ''),
                'genero_id' => $_POST['genero_id'] ?? null,
                'pais_id'   => $_POST['pais_id'] ?? null,
                'cuota_id'  => intval($_POST['cuota_id'] ?? 1),
                'exento'    => isset($_POST['exento']) ? 1 : 0,
                'consumo'   => floatval($_POST['consumo'] ?? 0),
                'saldo'     => floatval($_POST['saldo'] ?? 0)
            ];

            $guardado = Socio::save($data);
            AnaliticaDemo::resultado($guardado);
            header('Location: ' . URL_ROOT . '/socios');
            exit;
        }
    }

    /**
     * Procesa la modificación de datos de un socio desde el formulario (POST)
     * El acceso ya queda filtrado por la matriz RBAC en AuthMiddleware: edit_socios
     */
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id        = intval($_POST['id_socio'] ?? 0);
            $nombre    = trim($_POST['nombre'] ?? '');
            $apellidos = trim($_POST['apellidos'] ?? '');
            $card_id   = trim($_POST['card_id'] ?? '');
            $birth     = trim($_POST['birth'] ?? '');
            $genero_id = intval($_POST['genero_id'] ?? 1);
            $pais_id   = intval($_POST['pais_id'] ?? 1);
            $activo    = isset($_POST['activo']) ? 1 : 0;
            $cuota_id  = intval($_POST['cuota_id'] ?? 1);
            $exento    = isset($_POST['exento']) ? 1 : 0;
            $saldo     = floatval($_POST['saldo'] ?? 0);
            $consumo   = floatval($_POST['consumo'] ?? 0);

            // Partimos de las fotos ya existentes en el socio; si no sube nada nuevo, se conservan
            $socioActual   = Socio::find($id);
            $imagen_perfil = $socioActual['imagen_perfil'] ?? null;
            $idFront       = $socioActual['idFront'] ?? null;
            $idBack        = $socioActual['idBack'] ?? null;

            $uploadDir = Demo::carpetaImagenes('socios');

            $camposFoto = [
                'imagen_perfil' => &$imagen_perfil,
                'idFront'       => &$idFront,
                'idBack'        => &$idBack
            ];
            $imagenesSubidas = [];
            $erroresSubida = [];

            foreach ($camposFoto as $campo => &$valorActual) {
                [$nombreImagen, $errorImagen] = self::guardarFotoSocio($campo, $uploadDir);
                if ($nombreImagen !== null) {
                    $imagenesSubidas[$campo] = $nombreImagen;
                    $valorActual = $nombreImagen;
                }
                if ($errorImagen !== null) {
                    $etiquetas = [
                        'imagen_perfil' => 'Foto de perfil',
                        'idFront' => 'Documento (anverso)',
                        'idBack' => 'Documento (reverso)'
                    ];
                    $erroresSubida[] = $etiquetas[$campo] . ': ' . $errorImagen;
                }
            }
            unset($valorActual);

            if (!$erroresSubida && !$_FILES && (int) ($_SERVER['CONTENT_LENGTH'] ?? 0) > 0) {
                $limitePost = trim((string) ini_get('post_max_size'));
                if (preg_match('/^(\d+)\s*([KMG])?$/i', $limitePost, $coincidencias)) {
                    $multiplicadores = ['K' => 1024, 'M' => 1048576, 'G' => 1073741824];
                    $limiteBytes = (int) $coincidencias[1] * ($multiplicadores[strtoupper($coincidencias[2] ?? '')] ?? 1);
                    if ($limiteBytes > 0 && (int) $_SERVER['CONTENT_LENGTH'] > $limiteBytes) {
                        $erroresSubida[] = 'El formulario supera el límite total de subida de PHP (' . $limitePost . '). Reduce el tamaño de la imagen.';
                    }
                }
            }

            if (!empty($nombre) && $id > 0) {
                $actualizado = Socio::updateContable($id, $nombre, $apellidos, $card_id, $activo, $cuota_id, $exento, $saldo, $consumo, $imagen_perfil, $idFront, $idBack, $birth, $genero_id, $pais_id);
                AnaliticaDemo::resultado($actualizado);
                if ($actualizado) {
                    foreach ($imagenesSubidas as $campo => $nombreImagen) {
                        $imagenAnterior = $socioActual[$campo] ?? null;
                        if ($imagenAnterior && $imagenAnterior !== 'default.png') {
                            $rutaAnterior = $uploadDir . basename($imagenAnterior);
                            if (is_file($rutaAnterior)) {
                                unlink($rutaAnterior);
                            }
                        }
                    }
                } else {
                    foreach ($imagenesSubidas as $nombreImagen) {
                        $rutaNueva = $uploadDir . $nombreImagen;
                        if (is_file($rutaNueva)) {
                            unlink($rutaNueva);
                        }
                    }
                    $erroresSubida[] = 'No se pudieron guardar los datos del socio; las nuevas imágenes no quedaron asociadas.';
                }
            } else {
                foreach ($imagenesSubidas as $nombreImagen) {
                    $rutaNueva = $uploadDir . $nombreImagen;
                    if (is_file($rutaNueva)) {
                        unlink($rutaNueva);
                    }
                }
                $erroresSubida[] = 'No se pudieron guardar los datos del socio.';
            }

            if ($erroresSubida) {
                $_SESSION['socio_actualizacion_error'] = implode(' ', $erroresSubida);
            } else {
                unset($_SESSION['socio_actualizacion_error']);
            }
            header('Location: ' . URL_ROOT . '/socios/editar?id=' . $id);
            exit;
        }
    }

    /**
     * Muestra la ficha detallada, documentación y asignación de rol del socio
     */
    public function edit()
    {
        $id = intval($_GET['id'] ?? 0);
        $socio = Socio::find($id);

        if (!$socio) {
            header('Location: ' . URL_ROOT . '/socios');
            exit;
        }

        $this->render('socios/edit', [
            'titulo'   => 'Ficha de Socio - GreenPower',
            'socio'    => $socio,
            'generos'  => Socio::getGeneros(),
            'paises'   => Socio::getPaises(),
            'cuotas'   => Socio::getCuotas(), // 🌟 Pasamos las tarifas dinámicas
            'errorActualizacion' => $_SESSION['socio_actualizacion_error'] ?? null
        ]);
        unset($_SESSION['socio_actualizacion_error']);
    }

    private static function guardarFotoSocio($campo, $uploadDir)
    {
        if (!isset($_FILES[$campo])) {
            return [null, null];
        }

        $archivo = $_FILES[$campo];
        if ($archivo['error'] === UPLOAD_ERR_NO_FILE) {
            return [null, null];
        }
        if ($archivo['error'] !== UPLOAD_ERR_OK) {
            $errores = [
                UPLOAD_ERR_INI_SIZE => 'La imagen supera el límite de tamaño permitido por PHP.',
                UPLOAD_ERR_FORM_SIZE => 'La imagen supera el tamaño máximo permitido por el formulario.',
                UPLOAD_ERR_PARTIAL => 'La imagen solo se recibió parcialmente. Inténtalo de nuevo.',
                UPLOAD_ERR_NO_TMP_DIR => 'El servidor no tiene configurada una carpeta temporal para subir archivos.',
                UPLOAD_ERR_CANT_WRITE => 'El servidor no pudo escribir el archivo subido.',
                UPLOAD_ERR_EXTENSION => 'Una extensión de PHP detuvo la subida de la imagen.'
            ];

            return [null, $errores[$archivo['error']] ?? 'No se pudo recibir la imagen (error ' . intval($archivo['error']) . ').'];
        }

        $extension = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));
        $tiposPermitidos = [
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'webp' => 'image/webp'
        ];
        if (!isset($tiposPermitidos[$extension]) || !is_uploaded_file($archivo['tmp_name'])) {
            return [null, 'Formato de imagen no válido. Usa JPG, PNG o WEBP.'];
        }

        $tipoDetectado = (new finfo(FILEINFO_MIME_TYPE))->file($archivo['tmp_name']);
        if ($tipoDetectado !== $tiposPermitidos[$extension]) {
            return [null, 'El contenido del archivo no coincide con una imagen JPG, PNG o WEBP válida.'];
        }

        if (!is_dir($uploadDir) && !mkdir($uploadDir, 0775, true) && !is_dir($uploadDir)) {
            return [null, 'No se pudo crear la carpeta para las imágenes de socios.'];
        }
        if (!is_writable($uploadDir)) {
            return [null, 'El servidor no tiene permiso para escribir en la carpeta de imágenes de socios.'];
        }

        $prefijos = [
            'imagen_perfil' => 'p',
            'idFront' => 'f',
            'idBack' => 'b'
        ];
        $nombre = $prefijos[$campo] . '_' . bin2hex(random_bytes(8)) . '.' . $extension;
        if (!move_uploaded_file($archivo['tmp_name'], $uploadDir . $nombre)) {
            return [null, 'El servidor recibió la imagen, pero no pudo guardarla en la carpeta de socios.'];
        }

        return [$nombre, null];
    }
}
