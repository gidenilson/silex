<?php


require_once __DIR__ . '/../bootstrap.php';

$clientes = [
    [
        "id" => 1,
        "name" => "João da Silva",
        "email" => "joaodasilva@yahoo.com",
        "cpf" => "43983891560"
    ],
    [
        "id" => 2,
        "name" => "Carlos Roberto",
        "email" => "carlosrob@gmail.com",
        "cpf" => "01951824482"
    ],
    [
        "id" => 3,
        "name" => "Daniela Freitas",
        "email" => "danifrts@hotmail.com",
        "cpf" => "25215118388"
    ],
    [
        "id" => 4,
        "name" => "Elias Gomes",
        "email" => "eligomes@live.com",
        "cpf" => "62389049680"
    ]

];



$app->get('/', function ()  {
    return "<a href='/clientes' >click here</a>";
});
$app->get('/clientes', function () use ($app, $clientes) {
    return $app->json($clientes);
});

$app->run();