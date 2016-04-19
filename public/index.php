<?php


require_once __DIR__ . '/../bootstrap.php';

use Code\Sistema\Entities\Cliente;
use Code\Sistema\Mappers\ClienteMapper;
use Code\Sistema\Services\ClienteService;

use Code\Sistema\Entities\Produto;
use Code\Sistema\Mappers\ProdutoMapper;
use Code\Sistema\Services\ProdutoService;

$app['clienteService'] = function () {
    $client = new Cliente();
    $mapper = new ClienteMapper();

    return new ClienteService($client, $mapper);
};

$app['produtoService'] = function () {
    $produto = new Produto();
    $mapper = new ProdutoMapper();

    return new ProdutoService($produto, $mapper);
};

$app->get('/', function () {
    return "<a href='/cliente' >mostra cliente</a>"
    . "<br/><a href='/produto' >mostra produto</a>";
});

$app->get('/cliente', function () use ($app) {
    $dados = [
        "nome" => "Marcelo da Silva",
        "email" => "marcelodasilva@marceloemail.com"
    ];

    $clienteService = $app['clienteService'];
    $result = $clienteService->insert($dados);

    return $app->json($result);
});
$app->get('/produto', function () use ($app) {
    $dados = [
        "nome" => "Sapato",
        "descricao" => "Sapato social masculino",
        "valor" => "249.00",
    ];

    $produtoService = $app['produtoService'];
    $result = $produtoService->insert($dados);

    return $app->json($result);
});

$app->run();