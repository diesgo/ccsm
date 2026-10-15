<?php
// /core/Router.php

class Router
{
    protected $routes = [];

    /**
     * Registra una ruta dinámica para peticiones GET
     */
    public function get($route, $controllerMethod)
    {
        $this->routes['GET'][strtolower($route)] = $controllerMethod;
    }

    /**
     * Registra una ruta dinámica para peticiones POST
     */
    public function post($route, $controllerMethod)
    {
        $this->routes['POST'][strtolower($route)] = $controllerMethod;
    }

    /**
     * Captura la URL solicitada, aplica filtros de seguridad y despacha al controlador correspondiente
     */
    public function dispatch($url)
    {
        $method = $_SERVER['REQUEST_METHOD'];

        // CORRECCIÓN ABSOLUTA DE LIMPIEZA:
        // Aseguramos quitar CUALQUIER barra frontal o trasera y forzar minúsculas limpias
        $url = trim($url);
        $url = trim($url, '/');
        $url = strtolower($url);

        // ESCUDO DE SEGURIDAD CENTRALIZADO
        require_once ROOT_PATH . '/src/Middleware/AuthMiddleware.php';
        AuthMiddleware::handle($url);

        // Buscar si la ruta actual existe en el mapa registrado del sistema
        if (isset($this->routes[$method][$url])) {
            // Desestructuramos 'HomeController@index' en dos variables independientes sin usar índices numéricos
            list($controllerName, $action) = explode('@', $this->routes[$method][$url]);

            // 4. REGLA ESTRICTA PARA SERVIDORES LINUX / LAMPP:
            // Forzamos el formateo de mayúsculas correcto del controlador para que coincida con el disco duro (Case Sensitive)
            if (strpos($controllerName, 'controller') !== false) {
                $modulo = str_replace('controller', '', $controllerName);
                $controllerName = ucfirst($modulo) . 'Controller';
            } else {
                $controllerName = ucfirst($controllerName);
            }

            // Determinamos la ubicación física exacta usando la constante absoluta ROOT_PATH
            $controllerFile = ROOT_PATH . "/src/Controllers/" . $controllerName . ".php";

            if (file_exists($controllerFile)) {
                require_once $controllerFile;

                // Instanciamos el controlador dinámicamente y ejecutamos su método correspondiente
                $controller = new $controllerName();
                $controller->$action();
            } else {
                $this->send404("Controlador '{$controllerName}' no encontrado en el sistema físico: <br><small class='text-muted'>{$controllerFile}</small>");
            }
        } else {
            $this->send404("La ruta '<code>{$url}</code>' no está registrada en el sistema.");
        }
    }

    /**
     * Renderiza una pantalla de error 404 estandarizada con estilos limpios
     */
    private function send404($msg = "")
    {
        header("HTTP/1.0 404 Not Found");
        echo "<div style='font-family:sans-serif; text-align:center; padding:50px;'>";
        echo "<h1 style='color:#dc3545; font-size:40px; margin-bottom:10px;'>Error 404</h1>";
        echo "<p style='color:#6c757d; font-size:18px;'>Página o recurso no encontrado.</p>";
        echo "<div style='background:#f8f9fa; padding:15px; display:inline-block; border-radius:6px; border:1px solid #dee2e6; max-width:80%; text-align:left; font-family:monospace;'>$msg</div>";
        echo "</div>";
        exit;
    }
}
?>