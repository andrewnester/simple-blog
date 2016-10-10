<?php

return [
    'basePath' => 'http://localhost:8888',
    'routes' => [
        ['GET', '/', ['App\\Controller\\CrudController', 'main']],
        ['GET', '/posts/create', ['App\\Controller\\CrudController', 'create']],
        ['POST', '/posts/create', ['App\\Controller\\CrudController', 'saveNew']],
        ['GET', '/posts/<id>', ['App\\Controller\\CrudController', 'edit']],
        ['POST', '/posts/<id>', ['App\\Controller\\CrudController', 'saveExisting']],
        ['POST', '/posts/<id>/delete', ['App\\Controller\\CrudController', 'delete']]
    ],
    'services' => [
        PDO::class => new PDO('mysql:dbname=blog;host=127.0.0.1', 'root', '')
    ],
    'templatePath' => __DIR__ . '/../templates',
];
