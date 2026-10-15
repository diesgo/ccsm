<?php
if (PHP_SAPI !== 'cli-server') {
    http_response_code(404);
    exit;
}
$_GET['url'] = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
require __DIR__ . '/../public/index.php';
