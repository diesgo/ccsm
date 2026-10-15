<?php

require_once ROOT_PATH . '/core/Controller.php';
require_once ROOT_PATH . '/src/Models/Informe.php';

class InformeController extends Controller
{
    public function demo()
    {
        if (Demo::activa() || intval($_SESSION['perfil_id'] ?? 0) !== 1) {
            http_response_code(403);
            $this->render('informes/demo', [
                'titulo' => 'Seguimiento demo - GreenPower',
                'error' => 'El registro real de visitantes solo está disponible para administradores fuera del modo demo.'
            ]);
            return;
        }
        try {
            $pagina = Informe::filtros(['pagina' => $_GET['pagina'] ?? 1])['pagina'];
            $registro = RegistroDemo::informe($pagina);
        } catch (InvalidArgumentException $e) {
            http_response_code(400);
            $this->render('informes/demo', ['titulo' => 'Seguimiento demo - GreenPower', 'error' => $e->getMessage()]);
            return;
        } catch (PDOException $e) {
            error_log('Error al consultar registro demo: ' . $e->getMessage());
            http_response_code(503);
            $this->render('informes/demo', [
                'titulo' => 'Seguimiento demo - GreenPower',
                'error' => 'No se pudo consultar el registro de demos. Revisa la migración y el registro del servidor.'
            ]);
            return;
        }
        $this->render('informes/demo', ['titulo' => 'Seguimiento demo - GreenPower', 'registro' => $registro]);
    }

    public function index()
    {
        if (intval($_SESSION['perfil_id'] ?? 0) !== 1) {
            http_response_code(403);
            echo 'Acceso restringido a informes.';
            return;
        }
        try {
            $filtros = Informe::filtros($_GET);
        } catch (InvalidArgumentException $e) {
            http_response_code(400);
            $this->render('informes/index', [
                'titulo' => 'Informes - GreenPower', 'error' => $e->getMessage(),
                'filtros' => Informe::filtros([])
            ]);
            return;
        }
        try {
            $informe = Informe::obtener($filtros);
            $opciones = Informe::opciones();
        } catch (PDOException $e) {
            error_log('Error al consultar informes: ' . $e->getMessage());
            http_response_code(503);
            $this->render('informes/index', [
                'titulo' => 'Informes - GreenPower', 'filtros' => $filtros,
                'error' => 'No se pudo cargar el informe. Revisa el registro de errores del servidor.'
            ]);
            return;
        }
        $this->render('informes/index', [
            'titulo' => 'Informes - GreenPower', 'filtros' => $filtros,
            'informe' => $informe, 'opciones' => $opciones
        ]);
    }
}
