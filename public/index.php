<?php


require_once __DIR__ . '/../bootstrap.php';

use Code\Sistema\Entities\Cliente;
use Code\Sistema\Mappers\ClienteMapper;
use Code\Sistema\Services\ClienteService;

use Code\Sistema\Entities\Produto;
use Code\Sistema\Mappers\ProdutoMapper;
use Code\Sistema\Services\ProdutoService;

use Doctrine\DBAL\Connection;
use Symfony\Component\HttpFoundation\Request;

$app['clienteService'] = function () use ($db) {
    $client = new Cliente();
    $mapper = new ClienteMapper($db);

    return new ClienteService($client, $mapper);
};

$app['produtoService'] = function () use ($db) {
    $produto = new Produto();
    $mapper = new ProdutoMapper($db);

    return new ProdutoService($produto, $mapper);
};

$app->get('/', function () {
    return "<a href='api/cliente' >mostra clientes</a>"
    . "<br/><a href='api/produto' >mostra produtos</a>";
});

///// cliente //////
// Insert
$app->post('api/cliente', function (Request $request) use ($app) {
    $dados = [
        "nome" => $request->get("nome"),
        "email" => $request->get("email")
    ];

    $clienteService = $app['clienteService'];
    $result = $clienteService->insert($dados);

    return $app->json($result);
});

// mostra um
$app->get('api/cliente/{id}', function ($id) use ($app) {

    $clienteService = $app['clienteService'];
    $result = $clienteService->find($id);

    return $app->json($result);
});

// mostra todos
$app->get('api/cliente', function () use ($app) {

    $clienteService = $app['clienteService'];
    $result = $clienteService->fetchAll();

    return $app->json($result);
});

///// produto//////
// Insert
$app->post('api/produto', function (Request $request) use ($app) {
    $dados = [
        "nome" => $request->get("nome"),
        "descricao" => $request->get("descricao"),
        "valor" => $request->get("valor")
    ];

    $produtoService = $app['produtoService'];
    $result = $produtoService->insert($dados);

    return $app->json($result);
});

// mostra um
$app->get('api/produto/{id}', function ($id) use ($app) {

    $produtoService = $app['produtoService'];
    $result = $produtoService->find($id);

    return $app->json($result);
});

// mostra todos
$app->get('api/produto', function () use ($app) {

    $produtoService = $app['produtoService'];
    $result = $produtoService->fetchAll();

    return $app->json($result);
});
$app->run();