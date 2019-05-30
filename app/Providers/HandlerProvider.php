<?php
namespace App\Providers;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use App\Handlers\ErrorHandler;
use App\Handlers\NotFoundHandler;
use App\Handlers\NotAllowedHandler;

class HandlerProvider implements ServiceProviderInterface {

    public function register(Container $container)
    {
        // Not found handler
        $container['notFoundHandler'] = function ($container) {
            return new NotFoundHandler(
                $container->result,
                $container->json
            );
        };

        // Not found handler
        $container['notAllowedHandler'] = function ($container) {
            return new NotAllowedHandler(
                $container->result,
                $container->json
            );
        };

        // Error handler
        $container['errorHandler'] = function ($container) {
            return new ErrorHandler(
                $container->result,
                $container->json,
                $container->log,
                $container->config->get('app.debug')
            );

        };

        $container['phpErrorHandler'] = function ($container) {
            return $container['errorHandler'];
        };
    }
}
