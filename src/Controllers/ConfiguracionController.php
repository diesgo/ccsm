<?php
// /src/Controllers/ConfiguracionController.php

require_once ROOT_PATH . '/core/Controller.php';
require_once ROOT_PATH . '/src/Models/Configuracion.php';

class ConfiguracionController extends Controller {
    
    public function index() {
        // Inmunidad: Solo el administrador maestro (perfil_id = 1) altera las opciones del núcleo
        if (intval($_SESSION['perfil_id'] ?? 0) !== 1) {
            header('Location: ' . URL_ROOT . '/');
            exit;
        }

        $this->render('configuracion/index', [
            'titulo' => 'Opciones del Sistema - GreenPower',
            'opciones_sistema' => Configuracion::all()
        ]);
    }

    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (intval($_SESSION['perfil_id'] ?? 0) !== 1) { exit; }

            $data = [
                'imprimir_ticket_termico' => isset($_POST['imprimir_ticket_termico']) ? '1' : '0',
                'generar_factura_pdf'     => isset($_POST['generar_factura_pdf']) ? '1' : '0'
            ];

            $margen = str_replace(',', '.', trim((string) ($_POST['margen_beneficio'] ?? '')));
            if (is_numeric($margen) && $margen >= 0 && $margen <= 1000) {
                $data['margen_beneficio'] = (string) round((float) $margen, 2);
            }

            AnaliticaDemo::resultado(Configuracion::guardarMasivo($data));
            header('Location: ' . URL_ROOT . '/configuracion');
            exit;
        }
    }
}
?>