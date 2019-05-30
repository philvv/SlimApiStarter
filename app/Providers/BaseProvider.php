<?php
namespace App\Providers;

use Pimple\ServiceProviderInterface;
use Pimple\Container;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\SlackHandler;
use Monolog\Handler\DeduplicationHandler;

class BaseProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        // Logger
        $container['log'] = function ($container) {
            $logger = new Logger($container->config->get('app.brand_name'));

            $file_handler = new StreamHandler(
                base_path() . '/log/app.log',
                Logger::DEBUG
            );

            $slack_handler = new SlackHandler(
                $container->config->get('slack.token'),
                '#error',
                $container->config->get('slack.username'),
                true,
                null,
                Logger::ERROR,
                true,
                true,
                true
            );

            $slack_handler = new DeduplicationHandler(
                $slack_handler,
                base_path() . '/log/dup.log',
                Logger::ERROR,
                5
            );

            $logger->pushHandler($slack_handler);
            $logger->pushHandler($file_handler);

            return $logger;
        };
    }
}
