<?php

declare(strict_types=1);

namespace Application;

use Laminas\Db\Adapter\Adapter;
use Laminas\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface
{
    public function getConfig(): array
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig(): array
    {
        return [
            'factories' => [
                // Registro del adaptador de base de datos
                Adapter::class => function ($container) {
                    $config = $container->get('config');
                    $dbConfig = $config['db']; // Acceso directo
                    return new Adapter($dbConfig);
                },
                // Registro del controlador con dependencias
                Controller\FormularioController::class => function ($container) {
                    return new Controller\FormularioController($container->get(Adapter::class));
                },
            ],
        ];
    }
}

