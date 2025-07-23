<h1> Página de despliege con github actions </h1>

<?php
if (file_exists(__DIR__ . '/../config/db.php')) {
    echo "ejecución en local <br>";
    $configPath = __DIR__ . '/../config/';
} elseif (file_exists(__DIR__ . '/src/config/db.php')) {
    echo "ejecución en producción <br>";
    $configPath = __DIR__ . '/src/config/';
} else {
    die("Error: No se encontró el directorio config.");
}

require_once $configPath . 'db.php';
require_once $configPath . 'server.php';

phpinfo();