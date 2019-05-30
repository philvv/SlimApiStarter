<?php
set_error_handler(function ($severity, $message, $file, $line) {
    throw new \ErrorException($message, 0, $severity, $file, $line);
});

use Lib\Slim\App;
use App\Providers\HandlerProvider;
use App\Providers\HttpProvider;
use App\Providers\ActionProvider;
use App\Providers\ServiceProvider;
use App\Http\Middleware\ApiContentType;
use Tuupola\Middleware\CorsMiddleware;

// -----------------------------------------------------------------------------
// Init Slim application
// -----------------------------------------------------------------------------

$app = new App($container);

$container = $app->getContainer();

// -----------------------------------------------------------------------------
// Register providers
// -----------------------------------------------------------------------------

$container->register(new HandlerProvider());
$container->register(new HttpProvider());
$container->register(new ServiceProvider());
$container->register(new ActionProvider());

// -----------------------------------------------------------------------------
// Add routes
// -----------------------------------------------------------------------------

require '../routes/api.php';

// -----------------------------------------------------------------------------
// Add middleware
// -----------------------------------------------------------------------------

$app->add(ApiContentType::class);
$app->add(new CorsMiddleware([
    "origin" => ["*"],
    "methods" => ["GET", "POST", "PUT", "PATCH", "DELETE"],
    "headers.allow" => ["X-Requested-With", "Content-Type", "Accept", "Origin", "Authorization"],
    "headers.expose" => [],
    "credentials" => true,
    "cache" => 0
]));

// -----------------------------------------------------------------------------
// Run app
// -----------------------------------------------------------------------------

$app->run();