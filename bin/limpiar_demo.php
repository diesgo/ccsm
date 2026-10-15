<?php

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit('Solo disponible desde la terminal.');
}

require __DIR__ . '/../config/config.php';
require __DIR__ . '/../config/database.php';

Demo::limpiarCaducadas();
echo "Sesiones demo caducadas eliminadas.\n";
