<?php

require_once "vendor/autoload.php";


$app = new Silex\Application();

$app['debug'] = true;

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver'   => 'pdo_sqlite',
        'path'     => __DIR__. '/db/son-silex.sqlite',
    ),
));

$db = $app["db"];