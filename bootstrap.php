<?php

require_once "vendor/autoload.php";

use Symfony\Component\HttpFoundation\Request;


$app = new Silex\Application();

$app['debug'] = true;

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver'   => 'pdo_sqlite',
        'path'     => __DIR__. '/db/son-silex.sqlite',
    ),
));

$db = $app["db"];


$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
));

$app->register(new Silex\Provider\UrlGeneratorServiceProvider());


Request::enableHttpMethodParameterOverride();