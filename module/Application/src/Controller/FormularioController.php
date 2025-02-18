<?php

// Este archivo define el controlador FormularioController, que maneja las acciones relacionadas con el formulario de contacto.

declare(strict_types=1);

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Form\Element;
use Laminas\Form\Form;
use Laminas\Validator;
use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Sql\Sql;

class FormularioController extends AbstractActionController
{
    private $adapter;

    // Constructor que recibe el adaptador de base de datos
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    // Acción de confirmación que muestra un mensaje de éxito
    public function confirmacionAction()
    {
        return ['message' => '¡Hemos recibido tu mensaje!'];
    }

    // Acción principal que maneja el formulario de contacto
    public function indexAction()
    {
        $form = new Form();

        // Elemento para el nombre
        $form->add([
            'name' => 'nombre',
            'type' => Element\Text::class,
            'options' => [
                'label' => 'Nombre',
            ],
            'validators' => [
                ['name' => Validator\NotEmpty::class],
            ],
        ]);

        // Elemento para el correo electrónico
        $form->add([
            'name' => 'email',
            'type' => Element\Email::class,
            'options' => [
                'label' => 'Correo electrónico',
            ],
            'validators' => [
                ['name' => Validator\NotEmpty::class],
                ['name' => Validator\EmailAddress::class],
            ],
        ]);

        // Elemento para el mensaje
        $form->add([
            'name' => 'mensaje',
            'type' => Element\Textarea::class,
            'options' => [
                'label' => 'Mensaje',
            ],
            'validators' => [
                ['name' => Validator\NotEmpty::class],
            ],
        ]);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $data = $form->getData();
                $sql = new Sql($this->adapter);
                $insert = $sql->insert('mensajes');
                $insert->values($data);
                $statement = $sql->prepareStatementForSqlObject($insert);
                $results = $statement->execute();
                return $this->redirect()->toRoute('confirmacion'); 
            }
        }

        return ['form' => $form];
    }

    // Acción de prueba que verifica la versión de SQLite
    public function testDbAction()
    {
        $sql = 'SELECT sqlite_version() AS version';
        $statement = $this->adapter->query($sql);
        $result = $statement->execute();

        foreach ($result as $row) {
            var_dump($row); // Muestra el resultado en pantalla
        }

        return $this->getResponse();
    }
}
