<?php
namespace App\Providers;

use Pimple\ServiceProviderInterface;
use Pimple\Container;
use App\Actions\TestAction;

class ActionProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        // Test action
        $container['test_action'] = function ($container) {
            return new TestAction(
                $container->result
            );
        };
    }
}