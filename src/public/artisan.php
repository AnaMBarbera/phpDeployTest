<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use Illuminate\Foundation\Application;
use Illuminate\Console\Application as ArtisanConsole;

require __DIR__ . '/src/vendor/autoload.php';

define('SECRET_KEY', 'PhpDeploy'); // 🔑 cambia esta clave

$key = $_GET['key'] ?? '';
$command = $_GET['cmd'] ?? '';

if ($key !== SECRET_KEY) {
    http_response_code(403);
    exit('Acceso denegado.');
}

// Lista blanca de comandos permitidos
$allowedCommands = [
    'migrate',
    'migrate:reset',
    'migrate:fresh',
    'migrate --seed',
    'db:seed',
    'cache:clear',
    'config:clear',
    'route:clear',
    'view:clear',
];

if (!in_array($command, $allowedCommands)) {
    http_response_code(400);
    exit('Comando no permitido.');
}

$basePath = __DIR__ . '/src';
$app = require_once $basePath . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

ob_start();

try {
    // Convertir comando en array de argumentos
    $parts = preg_split('/\s+/', $command);
    $artisanCommand = array_shift($parts);
    $params = ['--force' => true];

    foreach ($parts as $part) {
        if (str_starts_with($part, '--')) {
            [$key, $value] = array_pad(explode('=', $part, 2), 2, true);
            $params[$key] = $value;
        }
    }

    $exitCode = $kernel->call($artisanCommand, $params);
} catch (Exception $e) {
    ob_end_clean();
    http_response_code(500);
    exit("Error ejecutando comando Artisan: " . $e->getMessage());
}

$output = ob_get_clean();

header('Content-Type: text/plain; charset=utf-8');
echo "Ejecutando comando: $command\n\n";
echo $output;
