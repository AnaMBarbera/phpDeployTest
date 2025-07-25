<?php
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Detectar entorno local o producción según existencia de carpeta o archivo
if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    // Estamos en entorno local (estructura estándar Laravel)
    $basePath = realpath(__DIR__ . '/../');
    //echo "Ejecución en local<br>";
} elseif (file_exists(__DIR__ . '/src/vendor/autoload.php')) {
    // Estamos en producción en InfinityFree con estructura modificada
    $basePath = realpath(__DIR__ . '/src/');
    echo "Ejecución en producción <br>";
} else {
    die("No se ha podido detectar el entorno de ejecución. Path:" . realpath(__DIR__ . '/src/'));
}

// Modo mantenimiento
if (file_exists($maintenance = $basePath . 'storage/framework/maintenance.php')) {
    require $maintenance;
}

// Autoloader de Composer
require $basePath . '/vendor/autoload.php';

// Bootstrap Laravel y manejo de la petición
/** @var Application $app */
$app = require_once $basePath . '/bootstrap/app.php';

// Capturar la petición HTTP y manejarla
$response = $app->handle(
    $request = Request::capture()
);

$response->send();

$app->terminate($request, $response);