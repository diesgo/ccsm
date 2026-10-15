<?php

define('APP_ENV', 'local');
define('DEMO_ENABLED', true);

define('DB_HOST', '127.0.0.1');
define('DB_PORT', 3306);
define('DB_USER', 'ccsm_local');
define('DB_PASS', '');
define('DB_NAME', 'ccsm_local');
define('DB_CHARSET', 'utf8mb4');

define('URL_ROOT', 'http://ccsm.dbold.local');
define('ROOT_PATH', dirname(__DIR__));

if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', '1');
    ini_set('session.use_only_cookies', '1');
    session_save_path('/tmp');
    session_start();
}
