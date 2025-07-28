<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use Illuminate\Foundation\Application;
use Illuminate\Console\Application as ArtisanConsole;

require __DIR__ . '/src/vendor/autoload.php';

// Definir la clave para acceder
define('SECRET_KEY', 'PhpDeploy');

// Validar key y acción
$key = $_GET['key'] ?? '';
$action = $_GET['action'] ?? '';

if ($key !== SECRET_KEY) {
    http_response_code(403);
    exit('Acceso denegado.');
}

$allowedActions = ['migrate', 'reset', 'fresh'];

if (!in_array($action, $allowedActions)) {
    http_response_code(400);
    exit('Acción no permitida.');
}

$basePath = __DIR__ . '/src';

// Bootstrap de la aplicación Laravel
$app = require_once $basePath . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

// Capturar la salida
ob_start();

try {
    switch ($action) {
        case 'migrate':
            $exitCode = $kernel->call('migrate', ['--force' => true]);
            break;
        case 'reset':
            $exitCode = $kernel->call('migrate:reset', ['--force' => true]);
            break;
        case 'fresh':
            $exitCode = $kernel->call('migrate:fresh', ['--force' => true]);
            break;
    }
} catch (Exception $e) {
    ob_end_clean();
    http_response_code(500);
    exit("Error ejecutando comando Artisan: " . $e->getMessage());
}

$output = ob_get_clean();

// Enviar resultado
header('Content-Type: text/plain; charset=utf-8');
echo "Ejecutando comando: $action\n\n";
echo $output;