<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

use Dotenv\Dotenv;
use Adbar\Dot;
use App\Providers\BaseProvider;

require __DIR__ . '/../vendor/autoload.php';

// Load env file
$env = Dotenv::create(base_path());
$env->load();

// -----------------------------------------------------------------------------
// Build container
// -----------------------------------------------------------------------------

$container = new \Slim\Container();

$container['config'] = function ($container) {
    // Create dot for config
    $dot = new Dot();

    foreach(glob(base_path() . '/config/*.php') as $file) {
        $dot->add(require($file));
    }

    return $dot;
};

// -----------------------------------------------------------------------------
// Register providers
// -----------------------------------------------------------------------------

$container->register(new BaseProvider());

// -----------------------------------------------------------------------------
// Determine application type
// -----------------------------------------------------------------------------

if (PHP_SAPI !== 'cli') {
    require 'http.php';
} else {
    require 'console.php';
}