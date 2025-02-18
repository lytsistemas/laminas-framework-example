<?php
// Este archivo define pruebas unitarias para el controlador IndexController.

declare(strict_types=1);

namespace ApplicationTest\Controller;

use Application\Controller\IndexController;
use Laminas\Stdlib\ArrayUtils;
use Laminas\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class IndexControllerTest extends AbstractHttpControllerTestCase
{
    public function setUp(): void
    {
        // La configuración del módulo debería seguir siendo aplicable para las pruebas.
        // Puedes sobrescribir la configuración aquí con valores específicos del caso de prueba,
        // como plantillas de vista de ejemplo, pilas de rutas, opciones del oyente del módulo, etc.
        $configOverrides = [];

        $this->setApplicationConfig(ArrayUtils::merge(
            include __DIR__ . '/../../../../config/application.config.php',
            $configOverrides
        ));

        parent::setUp();
    }

    // Prueba que la acción index se puede acceder
    public function testIndexActionCanBeAccessed(): void
    {
        $this->dispatch('/', 'GET');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('application');
        $this->assertControllerName(IndexController::class); // como se especifica en el alias del nombre del controlador del enrutador
        $this->assertControllerClass('IndexController');
        $this->assertMatchedRouteName('home');
    }

    // Prueba que la plantilla del ViewModel de la acción index se renderiza dentro del layout
    public function testIndexActionViewModelTemplateRenderedWithinLayout(): void
    {
        $this->dispatch('/', 'GET');
        $this->assertQuery('body h1');
    }

    // Prueba que una ruta inválida no causa un fallo
    public function testInvalidRouteDoesNotCrash(): void
    {
        $this->dispatch('/invalid/route', 'GET');
        $this->assertResponseStatusCode(404);
    }
}
