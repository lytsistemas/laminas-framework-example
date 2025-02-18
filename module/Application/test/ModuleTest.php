<?php
// Este archivo contiene pruebas unitarias para la clase Module de la aplicación.

declare(strict_types=1);

namespace ApplicationTest;

use Application\Module;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Application\Module;
 */
class ModuleTest extends TestCase
{
    // Esta prueba verifica que el método getConfig de la clase Module
    // proporciona una configuración que contiene las claves 'router' y 'controllers'.
    public function testProvidesConfig(): void
    {
        $module = new Module();
        $config = $module->getConfig();

        self::assertArrayHasKey('router', $config);
        self::assertArrayHasKey('controllers', $config);
    }
}
