<?php
namespace App\Providers;

use Pimple\ServiceProviderInterface;
use Pimple\Container;
use App\Services\InputService;
use App\Services\JsonService;
use App\Services\ResultService;
use App\Services\ValidatorService;
use App\Services\JwtService;

class HttpProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        // Input service
        $container['input'] = function ($container) {
            return new InputService(
                $container->request
            );
        };

        // Json service
        $container['json'] = function ($container) {
            return new JsonService(
                $container->response,
                $container->result
            );
        };

        // Result service
        $container['result'] = function ($container) {
            return new ResultService(
                $container->config->get('results')
            );
        };

        // Validator service
        $container['validator'] = function () {
            return new ValidatorService();
        };

        // Jwt service
        $container['jwt'] = function ($container) {
            return new JwtService(
                $container->config->get('app.key'),
                $container->request->getUri()->getHost(),
                $container->config->get('auth.jwt.lifetime'),
                $container->log
            );
        };
    }
}
