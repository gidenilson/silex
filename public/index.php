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

$app->get('/', function () use ($app) {
    return $app['twig']->render('index.twig', []);
})->bind('index');



////// cliente /////
// mostra todos
$app->get('cliente', function () use ($app) {

    $clienteService = $app['clienteService'];
    $result = $clienteService->fetchAll();

    return $app['twig']->render('clientes/list.twig', ['clientes'=>$result]);
})->bind('cliente/fetchall');

// insert
$app->post('cliente', function (Request $request) use ($app) {
    $dados = [
        "nome" => $request->get("nome"),
        "email" => $request->get("email")
    ];

    $clienteService = $app['clienteService'];
    $clienteService->insert($dados);

    $result = $clienteService->fetchAll();

    return $app['twig']->render('clientes/list.twig', ['clientes'=>$result]);

})->bind('cliente/insert');

// update
$app->put('cliente/{id}', function (Request $request, $id) use ($app) {
    $dados = [
        "nome" => $request->get("nome"),
        "email" => $request->get("email")
    ];

    $clienteService = $app['clienteService'];
    $clienteService->update($id, $dados);

    $result = $clienteService->fetchAll();
    return $app['twig']->render('clientes/list.twig', ['clientes'=>$result]);

})->bind('cliente/update');

// delete
$app->delete('cliente/{id}', function ($id) use ($app) {

    $clienteService = $app['clienteService'];
    $result = $clienteService->delete($id);
    $result = $clienteService->fetchAll();
    return $app['twig']->render('clientes/list.twig', ['clientes'=>$result]);
})->bind('cliente/delete');




////// produto /////
// mostra todos
$app->get('produto', function () use ($app) {

    $produtoService = $app['produtoService'];
    $result = $produtoService->fetchAll();
    return $app['twig']->render('produtos/list.twig', ['produtos'=>$result]);
})->bind('produto/fetchall');

// Insert
$app->post('produto', function (Request $request) use ($app) {
    $dados = [
        "nome" => $request->get("nome"),
        "descricao" => $request->get("descricao"),
        "valor" => $request->get("valor")
    ];

    $produtoService = $app['produtoService'];
    $produtoService->insert($dados);
    $result = $produtoService->fetchAll();
    return $app['twig']->render('produtos/list.twig', ['produtos'=>$result]);

})->bind('produto/insert');


// update
$app->put('produto/{id}', function (Request $request, $id) use ($app) {
    $dados = [
        "nome" => $request->get("nome"),
        "descricao" => $request->get("email"),
        "valor" => $request->get('valor')
    ];

    $produtoService = $app['produtoService'];
    $produtoService->update($id, $dados);
    $result = $produtoService->fetchAll();
    return $app['twig']->render('produtos/list.twig', ['produtos'=>$result]);
})->bind('produto/update');

// delete
$app->delete('produto/{id}', function ($id) use ($app) {

    $produtoService = $app['produtoService'];
    $result = $produtoService->delete($id);
    $result = $produtoService->fetchAll();
    return $app['twig']->render('produtos/list.twig', ['produtos'=>$result]);
})->bind('produto/delete');



///// API /////
///////////////

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
})->bind('api/cliente/insert');

// mostra um
$app->get('api/cliente/{id}', function ($id) use ($app) {

    $clienteService = $app['clienteService'];
    $result = $clienteService->find($id);

    return $app->json($result);
})->bind('api/cliente/fetch');

// mostra todos
$app->get('api/cliente', function () use ($app) {

    $clienteService = $app['clienteService'];
    $result = $clienteService->fetchAll();

    return $app->json($result);
})->bind('api/cliente/fetchall');

// update
$app->put('api/cliente/{id}', function (Request $request, $id) use ($app) {
    $dados = [
        "nome" => $request->get("nome"),
        "email" => $request->get("email")
    ];

    $clienteService = $app['clienteService'];
    $result = $clienteService->update($id, $dados);

    return $app->json($result);    
})->bind('api/cliente/update');

// delete
$app->delete('api/cliente/{id}', function ($id) use ($app) {

    $clienteService = $app['clienteService'];
    $result = $clienteService->delete($id);

    return $app->json($result);
})->bind('api/cliente/delete');



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
})->bind('api/produto/insert');

// mostra um
$app->get('api/produto/{id}', function ($id) use ($app) {

    $produtoService = $app['produtoService'];
    $result = $produtoService->find($id);

    return $app->json($result);
})->bind('api/produto/fetch');

// mostra todos
$app->get('api/produto', function () use ($app) {

    $produtoService = $app['produtoService'];
    $result = $produtoService->fetchAll();

    return $app->json($result);
})->bind('api/produto/fetchall');

// update
$app->put('api/produto/{id}', function (Request $request, $id) use ($app) {
    $dados = [
        "nome" => $request->get("nome"),
        "descricao" => $request->get("email"),
        "valor" => $request->get('valor')
    ];

    $produtoService = $app['produtoService'];
    $result = $produtoService->update($id, $dados);

    return $app->json($result);
})->bind('api/produto/update');

// delete
$app->delete('api/produto/{id}', function ($id) use ($app) {

    $produtoService = $app['produtoService'];
    $result = $produtoService->delete($id);

    return $app->json($result);
})->bind('api/produto/delete');


$app->run();