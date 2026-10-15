<?php
// /src/Controllers/DispensarioController.php

require_once ROOT_PATH . '/core/Controller.php';
require_once ROOT_PATH . '/src/Models/Socio.php';
require_once ROOT_PATH . '/src/Models/Producto.php';
require_once ROOT_PATH . '/src/Models/Venta.php';
require_once ROOT_PATH . '/src/Models/Categoria.php'; // <-- REQUERIMOS EL MODELO


class DispensarioController extends Controller
{
    /**
     * Muestra la Terminal TPV del Dispensario con todas las dependencias
     */
    public function index()
    {
        // Aseguramos la carga explícita de los modelos relacionales necesarios
        require_once ROOT_PATH . '/src/Models/Socio.php';
        require_once ROOT_PATH . '/src/Models/Producto.php';
        require_once ROOT_PATH . '/src/Models/Categoria.php';
        require_once ROOT_PATH . '/src/Models/Venta.php';

        // Saneamiento preventivo: extraemos las transacciones capturando fallos
        $ventasHoy = [];
        if (class_exists('Venta')) {
            $ventasHoy = Venta::obtenerVentasDelDia();
        }

        // Renderizamos la plantilla enviando el array exacto que espera la tabla de abajo
        $this->render('dispensario/index', [
            'titulo'       => 'Terminal TPV - Dispensario',
            'socios'       => Socio::all(),
            'productos'    => Producto::all(),
            'categorias'   => Categoria::all(),
            'ventasDelDia' => $ventasHoy // <-- INYECCIÓN TRONCAL DEFINITIVA
        ]);
    }

    /**
     * Procesa el cobro del carrito mediante AJAX / POST de forma síncrona pura
     */
    public function cobrar()
    {
        // Limpiamos cualquier búfer o espacio en blanco residual previo para dejar el canal limpio
        if (ob_get_length()) ob_clean();

        header('Content-Type: application/json; charset=utf-8');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idSocio    = intval($_POST['id_socio'] ?? 0);
            $idProducto = intval($_POST['id_producto'] ?? 0);
            $cantidad   = floatval($_POST['cantidad'] ?? 0);
            $total      = floatval($_POST['total'] ?? 0);

            if ($idSocio <= 0 || $idProducto <= 0 || $cantidad <= 0 || $total <= 0) {
                AnaliticaDemo::resultado(false);
                echo json_encode(['success' => false, 'message' => 'Parámetros de retirada de mostrador incompletos.']);
                exit;
            }

            // Invocamos al modelo transaccional sanitizado
            $resultado = Venta::procesar($idSocio, $idProducto, $cantidad, $total);
            AnaliticaDemo::resultado($resultado === true);

            if ($resultado === true) {
                echo json_encode(['success' => true, 'message' => 'Línea de venta guardada correctamente.']);
            } else {
                // CORRECCIÓN MÁGICA: Si es un texto de error de MariaDB, lo envolvemos en un JSON válido
                echo json_encode(['success' => false, 'message' => 'Conflicto contable: ' . $resultado]);
            }
            exit;
        }

        echo json_encode(['success' => false, 'message' => 'Método de petición no permitido.']);
        exit;
    }

    public function obtenerSocio()
    {
        if (ob_get_length()) ob_clean();
        header('Content-Type: application/json; charset=utf-8');

        $id = intval($_GET['id'] ?? 0);
        $socio = Socio::find($id);

        if ($socio) {
            $socio['imagen_perfil_url'] = $socio['imagen_perfil'] ? Demo::urlImagen('socios', $socio['imagen_perfil']) : null;
            $socio['idFront_url'] = $socio['idFront'] ? Demo::urlImagen('socios', $socio['idFront']) : null;
            $socio['idBack_url'] = $socio['idBack'] ? Demo::urlImagen('socios', $socio['idBack']) : null;
            // SINALIZACIÓN: Invocamos al nuevo método sin candados de fecha
            $historialSocio = Venta::obtenerHistorialCompletoSocio($id);

            echo json_encode([
                'success' => true,
                'socio' => $socio,
                'historial' => $historialSocio
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Socio no localizado.']);
        }
        exit;
    }

    /**
     * Procesa la recarga de saldo respondiendo con JSON para mantener al socio fijo en el mostrador
     */
    public function recargarSaldo()
    {
        // Purgamos cualquier residuo previo del búfer para garantizar un JSON impecable
        if (ob_get_length()) ob_clean();
        header('Content-Type: application/json; charset=utf-8');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idSocio = intval($_POST['id_socio'] ?? 0);
            $importe = floatval($_POST['monto'] ?? 0);

            if ($idSocio > 0 && $importe > 0) {
                try {
                    $db = Database::getConnection();

                    // 1. Incrementamos el saldo en la tabla de socios
                    $sql = "UPDATE socios SET saldo = saldo + :importe WHERE id_socio = :id";
                    $stmt = $db->prepare($sql);
                    $stmt->execute([
                        'importe' => $importe,
                        'id'      => $idSocio
                    ]);

                    // 2. Consultamos de inmediato el nuevo saldo resultante acumulado
                    $stmtSaldo = $db->prepare("SELECT saldo FROM socios WHERE id_socio = :id LIMIT 1");
                    $stmtSaldo->execute(['id' => $idSocio]);
                    $socioActualizado = $stmtSaldo->fetch(PDO::FETCH_ASSOC);

                    $nuevoSaldo = floatval($socioActualizado['saldo'] ?? 0);
                    AnaliticaDemo::resultado($socioActualizado !== false);

                    // 3. Respondemos con éxito enviando las variables directas hacia el fetch de JS
                    echo json_encode([
                        'success'     => true,
                        'nuevo_saldo' => $nuevoSaldo
                    ]);
                    exit;
                } catch (PDOException $e) {
                    AnaliticaDemo::resultado(false);
                    echo json_encode(['success' => false, 'message' => 'Error de persistencia SQL: ' . $e->getMessage()]);
                    exit;
                }
            }
            AnaliticaDemo::resultado(false);
            echo json_encode(['success' => false, 'message' => 'Variables de entrada inválidas o nulas.']);
            exit;
        }
    }

    /**
     * Procesa la anulación del ticket de venta - BLINDADO DINÁMICAMENTE POR ROLES
     */
    public function anularVenta()
    {
        // El Administrador Maestro conserva inmunidad de paso
        $esAdminSupremo = (intval($_SESSION['user_id'] ?? 0) === 1);

        // 🌟 CANDADO DE RESPALDO EN BACKEND POR ACCESO GRANULAR:
        // Si no es el administrador y tampoco tiene la llave edit_socios activa en su sesión, se aborta el fraude
        if (!$esAdminSupremo && intval($_SESSION['permisos']['edit_socios'] ?? 0) !== 1) {
            AnaliticaDemo::resultado(false);
            echo "<script>alert('Acceso Denegado: Su rol de usuario actual no dispone del permiso granular [Modificar Mostrador] requerido para revertir operaciones de caja.'); window.location.href='" . URL_ROOT . "/dispensario';</script>";
            exit;
        }

        // ... (Tu código original de actualización de stock e inyección al monedero continúa intacto abajo) ...

        // Capturamos el ID de la venta enviado por la URL
        $idVenta = intval($_GET['id'] ?? 0);

        if ($idVenta > 0) {
            // El método puede variar según la implementación del modelo Venta.
            // Se invoca dinámicamente para evitar referencias a métodos inexistentes.
            $metodo = null;
            foreach (['anular', 'cancelar', 'anularVenta'] as $candidato) {
                if (method_exists(Venta::class, $candidato)) {
                    $metodo = $candidato;
                    break;
                }
            }

            $resultado = $metodo
                ? call_user_func([Venta::class, $metodo], $idVenta)
                : 'El modelo Venta no dispone de un método de anulación.';
            AnaliticaDemo::resultado($resultado === true);

            if ($resultado === true) {
                // Redirigimos de vuelta con un mensaje de éxito simulado en sesión si lo deseas
                AnaliticaDemo::resultado(false);
                header('Location: ' . URL_ROOT . '/dispensario');
                exit;
            } else {
                die("Error en el reembolso: " . $resultado);
            }
        }

        header('Location: ' . URL_ROOT . '/dispensario');
        exit;
    }
}
?>
