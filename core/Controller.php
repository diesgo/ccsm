<?php
// /core/Controller.php

class Controller {
    public function render($view, $data = []) {
        if (!empty($data['error']) && class_exists('AnaliticaDemo')) {
            AnaliticaDemo::resultado(false);
        }
        // 1. Extraer los datos primero para que estén disponibles en el hilo de ejecución
        extract($data);

        $viewFile = ROOT_PATH . '/src/Views/' . $view . '.php';

        if (!file_exists($viewFile)) {
            die("La vista src/Views/{$view}.php no existe.");
        }

        // 2. Iniciar el almacenamiento en memoria intermedia
        ob_start();
        include $viewFile; // Aquí se ejecuta la vista y lee las variables extraídas arriba
        $content = ob_get_clean(); // Guardamos el HTML resultante en $content

        // 3. Incluir el Layout Maestro (que leerá $content, $titulo, etc.)
        include ROOT_PATH . '/src/Views/layout/main.php';
    }
}
?>