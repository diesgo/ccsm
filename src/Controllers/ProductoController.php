<?php
// /src/Controllers/ProductoController.php

require_once ROOT_PATH . '/core/Controller.php';
require_once ROOT_PATH . '/src/Models/Producto.php';
require_once ROOT_PATH . '/src/Models/Categoria.php';
require_once ROOT_PATH . '/src/Models/Variedad.php';
require_once ROOT_PATH . '/src/Models/Configuracion.php';
// 🌟 DEPURADO: Se eliminó por completo el require_once de Impuesto.php que rompía el servidor

class ProductoController extends Controller
{

    /**
     * Listado general del catálogo - REFACTORIZADO CON INNER/LEFT JOIN EN CALIENTE
     */
    public function index()
    {
        // En lugar de llamar de forma ciega a Producto::all(), ejecutamos una consulta relacional segura
        $productosMapeados = [];
        $categoriaFiltro = intval($_GET['categoria'] ?? 0);
        try {
            $db = Database::getConnection();

            // Cruzamos productos con sus categorías, unidades de medida e impuestos.
            $sql = "SELECT p.*, c.categoria, c.servicio_id, s.servicio, i.valor AS impuesto_porcentaje
                    FROM productos p
                    LEFT JOIN categorias c ON p.categoria_id = c.id_categoria
                    LEFT JOIN servicios s ON c.servicio_id = s.id_servicio
                    LEFT JOIN impuestos i ON p.impuesto_id = i.id_impuesto";
            $params = [];
            if ($categoriaFiltro > 0) {
                $sql .= " WHERE p.categoria_id = :cat";
                $params['cat'] = $categoriaFiltro;
            }
            $sql .= " ORDER BY p.id_producto DESC";

            $stmt = $db->prepare($sql);
            $stmt->execute($params);
            $productosMapeados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Si la consulta relacional fallara de forma preventiva, usamos el método de respaldo base
            $productosMapeados = Producto::all();
        }

        // Enviamos la matriz completa con los nombres de categorías listos a la vista
        $this->render('productos/index', [
            'titulo'    => 'Inventario de Almacén - GreenPower',
            'productos' => $productosMapeados,
            'categorias' => Categoria::all(),
            'categoriaFiltro' => $categoriaFiltro,
            'errorImagen' => $_SESSION['producto_imagen_error'] ?? null
        ]);
        unset($_SESSION['producto_imagen_error']);
    }

    /**
     * Muestra el formulario de edición de un producto
     */
    public function edit()
    {
        $id = intval($_GET['id'] ?? 0);
        $producto = Producto::find($id);

        if (!$producto) {
            header('Location: ' . URL_ROOT . '/productos');
            exit;
        }

        // EXTRACCIÓN PDO DIRECTA: Leemos tu tabla 'impuestos' de phpMyAdmin sin usar modelos inventados
        $listaImpuestos = [];
        try {
            $db = Database::getConnection();
            $listaImpuestos = $db->query("SELECT * FROM impuestos ORDER BY id_impuesto ASC")->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $listaImpuestos = [];
        }

        $this->render('productos/edit', [
            'titulo'     => 'Editar Producto - GreenPower',
            'producto'   => $producto,
            'categorias' => Categoria::all(), // Envía el servicio_id real para discriminar el granel
            'variedades' => Variedad::all(),
            'margen'     => Configuracion::margenBeneficio(),
            'impuestos'  => $listaImpuestos   // Inyecta las tasas reales ("ES Standard rate (21%)", etc.)
        ]);
    }

    /**
     * Procesa la modificación del artículo
     */
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (ob_get_length()) ob_clean();

            $id           = intval($_POST['id_producto'] ?? 0);
            $nombre       = is_string($_POST['producto'] ?? null) ? trim($_POST['producto']) : '';
            $categoria_id = intval($_POST['categoria_id'] ?? 0);
            $variedad_id  = intval($_POST['variedad_id'] ?? 0) ?: null;
            $impuesto_id  = intval($_POST['impuesto_id'] ?? 1);
            $pvp          = floatval($_POST['pvp'] ?? 0);
            $precio_compra = self::leerPrecioCompra($_POST['precio_compra'] ?? '');
            $dispensario  = floatval($_POST['dispensario'] ?? 0);
            $visible      = isset($_POST['visible']) ? 1 : 0;

            $prodActual = Producto::find($id);
            if ($nombre === '' || $id <= 0 || !$prodActual) {
                $errorFormulario = !$_FILES ? self::guardarImagenProducto()[1] : null;
                $_SESSION['producto_imagen_error'] = $errorFormulario ?? ($nombre === ''
                    ? 'Introduce el nombre del artículo. No se ha guardado ninguna imagen.'
                    : 'El artículo no existe. No se ha guardado ninguna imagen.');
                header('Location: ' . URL_ROOT . '/productos');
                exit;
            }
            $imagen = $prodActual ? $prodActual['imagen_producto'] : 'default.png';

            [$imagenSubida, $errorImagen] = self::guardarImagenProducto();
            if ($imagenSubida !== null) {
                $imagen = $imagenSubida;
            }
            if ($errorImagen !== null) {
                $_SESSION['producto_imagen_error'] = $errorImagen;
            }

            if ($nombre !== '' && $id > 0) {
                $actualizado = Producto::update($id, $nombre, $categoria_id, $variedad_id, $pvp, $impuesto_id, $dispensario, $visible, $imagen, $precio_compra);
                AnaliticaDemo::resultado($actualizado);
                if ($actualizado && $imagenSubida !== null && $prodActual && $prodActual['imagen_producto'] !== 'default.png') {
                    $imagenAnterior = Demo::carpetaImagenes('productos') . basename($prodActual['imagen_producto']);
                    if (is_file($imagenAnterior)) {
                        unlink($imagenAnterior);
                    }
                }
                if (!$actualizado) {
                    if ($imagenSubida !== null) {
                        unlink(Demo::carpetaImagenes('productos') . $imagenSubida);
                    }
                    $_SESSION['producto_imagen_error'] = 'No se pudieron guardar los cambios del artículo; la imagen no quedó asociada.';
                }
            }

            header('Location: ' . URL_ROOT . '/productos');
            exit;
        }
    }

    /**
     * 🌟 NUEVO MÉTODO DE CREACIÓN: Levanta el formulario de alta de artículos
     */
    public function create()
    {
        // EXTRACCIÓN PDO DIRECTA: Leemos tu tabla 'impuestos' de phpMyAdmin igual que en edit()
        $listaImpuestos = [];
        try {
            $db = Database::getConnection();
            $listaImpuestos = $db->query("SELECT * FROM impuestos ORDER BY id_impuesto ASC")->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $listaImpuestos = [];
        }

        $this->render('productos/create', [
            'titulo'     => 'Añadir Producto - GreenPower',
            'categorias' => Categoria::all(), // Envía las familias para asociar los IDs
            'variedades' => Variedad::all(),   // Envía los tipos orgánicos, picantes, etc.
            'margen'     => Configuracion::margenBeneficio(),
            'impuestos'  => $listaImpuestos   // Inyecta las tasas reales ("ES Standard rate (21%)", etc.)
        ]);
    }

    /**
     * 🌟 NUEVO MÉTODO DE GUARDADO: Procesa e inserta el nuevo artículo en MariaDB (POST)
     */
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (ob_get_length()) ob_clean();

            // Recogemos y saneamos las variables del formulario
            $nombre       = is_string($_POST['producto'] ?? null) ? trim($_POST['producto']) : '';
            $categoria_id = intval($_POST['categoria_id'] ?? 0);
            $variedad_id  = intval($_POST['variedad_id'] ?? 0) ?: null;
            $impuesto_id  = intval($_POST['impuesto_id'] ?? 1);
            $pvp          = floatval($_POST['pvp'] ?? 0);
            $precio_compra = self::leerPrecioCompra($_POST['precio_compra'] ?? '');
            $dispensario  = floatval($_POST['dispensario'] ?? 0);
            $visible      = isset($_POST['visible']) ? 1 : 0;
            $imagen       = 'default.png'; // Imagen de respaldo por defecto

            if ($nombre === '') {
                $errorFormulario = !$_FILES ? self::guardarImagenProducto()[1] : null;
                $_SESSION['producto_imagen_error'] = $errorFormulario ?? 'Introduce el nombre del artículo. No se ha guardado ninguna imagen.';
                header('Location: ' . URL_ROOT . '/productos');
                exit;
            }

            [$imagenSubida, $errorImagen] = self::guardarImagenProducto();
            if ($imagenSubida !== null) {
                $imagen = $imagenSubida;
            }
            if ($errorImagen !== null) {
                $_SESSION['producto_imagen_error'] = $errorImagen;
            }

            // Si el nombre no está vacío, delegamos la inserción en tu modelo Producto.php
            if ($nombre !== '') {
                $guardado = Producto::save($nombre, $categoria_id, $variedad_id, $pvp, $impuesto_id, $dispensario, $visible, $imagen, $precio_compra);
                AnaliticaDemo::resultado($guardado);
                if (!$guardado) {
                    if ($imagenSubida !== null) {
                        unlink(Demo::carpetaImagenes('productos') . $imagenSubida);
                    }
                    $_SESSION['producto_imagen_error'] = 'No se pudo guardar el artículo; la imagen no quedó asociada.';
                }
            }

            header('Location: ' . URL_ROOT . '/productos');
            exit;
        }
    }

    private static function guardarImagenProducto()
    {
        if (!isset($_FILES['imagen_producto'])) {
            $longitudSolicitud = (int) ($_SERVER['CONTENT_LENGTH'] ?? 0);
            $limitePost = trim((string) ini_get('post_max_size'));
            if ($longitudSolicitud > 0 && preg_match('/^(\d+)\s*([KMG])?$/i', $limitePost, $coincidencias)) {
                $multiplicadores = ['K' => 1024, 'M' => 1048576, 'G' => 1073741824];
                $limiteBytes = (int) $coincidencias[1] * ($multiplicadores[strtoupper($coincidencias[2] ?? '')] ?? 1);
                if ($limiteBytes > 0 && $longitudSolicitud > $limiteBytes) {
                    return [null, 'El formulario supera el límite total de subida de PHP (' . $limitePost . '). Reduce el tamaño de la imagen.'];
                }
            }

            return [null, null];
        }

        $archivo = $_FILES['imagen_producto'];
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

        $uploadDir = Demo::carpetaImagenes('productos');
        if (!is_dir($uploadDir) && !mkdir($uploadDir, 0775, true) && !is_dir($uploadDir)) {
            return [null, 'No se pudo crear la carpeta de imágenes del inventario.'];
        }
        if (!is_writable($uploadDir)) {
            return [null, 'El servidor no tiene permiso para escribir en la carpeta de imágenes del inventario.'];
        }

        $nombre = 'prod_' . bin2hex(random_bytes(12)) . '.' . $extension;
        if (!move_uploaded_file($archivo['tmp_name'], $uploadDir . $nombre)) {
            return [null, 'El servidor recibió la imagen, pero no pudo guardarla en la carpeta del inventario.'];
        }

        return [$nombre, null];
    }

    // El precio de compra es opcional: vacío o no válido se guarda como NULL
    private static function leerPrecioCompra($valor)
    {
        $valor = str_replace(',', '.', trim((string) $valor));

        return is_numeric($valor) && $valor >= 0 ? $valor : null;
    }
}
?>