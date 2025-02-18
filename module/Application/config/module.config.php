<?php

declare(strict_types=1);

namespace Application;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    // Configuración del enrutador
    'router' => [
        'routes' => [
            // Ruta para la página de inicio
            'home' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            // Ruta para el controlador de la aplicación
            'application' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/application[/:action]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            // Ruta para el formulario
            'formulario' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/formulario',
                    'defaults' => [
                        'controller' => Controller\FormularioController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            // Ruta para la confirmación del formulario
            'confirmacion' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/confirmacion',
                    'defaults' => [
                        'controller' => Controller\FormularioController::class,
                        'action'     => 'confirmacion',
                    ],
                ],
            ],
            // Ruta para la prueba de base de datos
            'test-db' => [
                'type' => \Laminas\Router\Http\Literal::class,
                'options' => [
                    'route'    => '/test-db',
                    'defaults' => [
                        'controller' => Controller\FormularioController::class,
                        'action'     => 'testDb',
                    ],
                ],
            ],
        ],
    ],
    // Configuración de los controladores
    'controllers' => [
        'factories' => [
            // Fábrica para el controlador del formulario
            Controller\FormularioController::class => function ($container) {
                // Recuperar el adaptador de base de datos desde el contenedor de servicios
                $adapter = $container->get(\Laminas\Db\Adapter\Adapter::class);
                return new Controller\FormularioController($adapter);
            },
            // Fábrica invocable para el controlador de índice
            Controller\IndexController::class => InvokableFactory::class,
        ],
    ],
    // Configuración del gestor de vistas
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'application/formulario/index' => __DIR__ . '/../view/application/index/form.phtml',
            'application/formulario/confirmacion' => __DIR__ . '/../view/application/index/confirmacion.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
