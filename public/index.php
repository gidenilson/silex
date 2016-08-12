<?php


require_once __DIR__ . '/../bootstrap.php';

use Code\Sistema\Entities\Cliente;
use Code\Sistema\Mappers\ClienteMapper;
use Code\Sistema\Services\ClienteService;

use Code\Sistema\Entities\Produto;
use Code\Sistema\Mappers\ProdutoMapper;
use Code\Sistema\Services\ProdutoService;

use Doctrine\DBAL\Connection;
use Particle\Validator\Validator;
use Symfony\Component\HttpFoundation\Request;


$app['clienteService'] = function () use ($db) {
    $client = new Cliente();
    $mapper = new ClienteMapper($db);
    $validator = new Validator();
    return new ClienteService($client, $mapper, $validator);
};

$app['produtoService'] = function () use ($db) {
    $produto = new Produto();
    $mapper = new ProdutoMapper($db);
    $validator = new Validator();
    return new ProdutoService($produto, $mapper, $validator);
};

$app->get('/', function () use ($app) {
    return $app['twig']->render('index.twig', []);
})->bind('index');



////// cliente /////
// mostra todos
$app->get('cliente', function () use ($app) {

    $clienteService = $app['clienteService'];
    $result = $clienteService->fetchAll();
    if($result['success']) {
        return $app['twig']->render('clientes/list.twig', ['clientes' => $result['result']]);
    }else{
        return $app['twig']->render('erro.twig');
    }

})->bind('cliente/fetchall');

// insert
$app->post('cliente', function (Request $request) use ($app) {
    $dados = [
        "nome" => $request->get("nome") ? $request->get("nome") : "",
        "email" => $request->get("email") ? $request->get("email") : ""
    ];

    $clienteService = $app['clienteService'];
    $result = $clienteService->insert($dados);
    if($result['success']) {
        $res = $clienteService->fetchAll();
        return $app['twig']->render('clientes/list.twig', ['clientes' => $res['result']]);
    }else{
        return $app['twig']->render('erro.twig');
    }
})->bind('cliente/insert');

// update
$app->put('cliente/{id}', function (Request $request, $id) use ($app) {
    $dados = [
        "nome" => $request->get("nome") ? $request->get("nome") : "",
        "email" => $request->get("email") ? $request->get("email") : ""
    ];

    $clienteService = $app['clienteService'];
    $result = $clienteService->update($id, $dados);

    if($result['success']){
        $res = $clienteService->fetchAll();
        return $app['twig']->render('clientes/list.twig', ['clientes'=>$res['result']]);
    }else{
        return $app['twig']->render('erro.twig');
    }

 })->bind('cliente/update');

// delete
$app->delete('cliente/{id}', function ($id) use ($app) {

    $clienteService = $app['clienteService'];
    $result = $clienteService->delete($id);
    if($result['success']){
        $res = $clienteService->fetchAll();
        return $app['twig']->render('clientes/list.twig', ['clientes'=>$res['result']]);
    }else{
        return $app['twig']->render('erro.twig');
    }

})->bind('cliente/delete');




////// produto /////
// mostra todos
$app->get('produto', function () use ($app) {

    $produtoService = $app['produtoService'];
    $result = $produtoService->fetchAll();
    if($result['success']){
        return $app['twig']->render('produtos/list.twig', ['produtos'=>$result['result']]);
    }else{
        return $app['twig']->render('erro.twig');
    }

})->bind('produto/fetchall');

// Insert
$app->post('produto', function (Request $request) use ($app) {
    $dados = [
        "nome" => $request->get("nome") ? $request->get("nome") : "",
        "descricao" => $request->get("descricao") ? $request->get("descricao") : "",
        "valor" => $request->get("valor") ? $request->get("valor") : ""
    ];

    $produtoService = $app['produtoService'];
    $result = $produtoService->insert($dados);
    if($result['success']){
        $res = $produtoService->fetchAll();
        return $app['twig']->render('produtos/list.twig', ['produtos'=>$res['result']]);
    }
    else{
        return $app['twig']->render('erro.twig');
    }


})->bind('produto/insert');


// update
$app->put('produto/{id}', function (Request $request, $id) use ($app) {
    $dados = [
        "nome" => $request->get("nome") ? $request->get("nome") : "",
        "descricao" => $request->get("descricao") ? $request->get("descricao") : "",
        "valor" => $request->get("valor") ? $request->get("valor") : ""
    ];

    $produtoService = $app['produtoService'];
    $result = $produtoService->update($id, $dados);
    if($result['success']){
        $res = $produtoService->fetchAll();
        return $app['twig']->render('produtos/list.twig', ['produtos'=>$res['result']]);
    }else{
        return $app['twig']->render('erro.twig');
    }

})->bind('produto/update');

// delete
$app->delete('produto/{id}', function ($id) use ($app) {

    $produtoService = $app['produtoService'];
    $result = $produtoService->delete($id);
    if($result['success']){
        $res = $produtoService->fetchAll();
        return $app['twig']->render('produtos/list.twig', ['produtos'=>$res['result']]);
    }else{
        return $app['twig']->render('erro.twig');
    }
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
    $status = $result['success'] ? 200 : 400;
    return $app->json($result, $status);
})->bind('api/cliente/insert');

// mostra um
$app->get('api/cliente/{id}', function ($id) use ($app) {

    $clienteService = $app['clienteService'];
    $result = $clienteService->find($id);
    $status = $result['success'] ? 200 : 400;

     return $app->json($result, $status);
})->bind('api/cliente/fetch');

// mostra todos
$app->get('api/cliente', function () use ($app) {

    $clienteService = $app['clienteService'];
    $result = $clienteService->fetchAll();
    $status = $result['success'] ? 200 : 400;

    return $app->json($result, $status);
})->bind('api/cliente/fetchall');

// update
$app->put('api/cliente/{id}', function (Request $request, $id) use ($app) {
    $dados = [
        "nome" => $request->get("nome"),
        "email" => $request->get("email")
    ];

    $clienteService = $app['clienteService'];
    $result = $clienteService->update($id, $dados);
    $status = $result['success'] ? 200 : 400;

    return $app->json($result, $status);
})->bind('api/cliente/update');

// delete
$app->delete('api/cliente/{id}', function ($id) use ($app) {

    $clienteService = $app['clienteService'];
    $result = $clienteService->delete($id);
    $status = $result['success'] ? 200 : 400;

    return $app->json($result, $status);
})->bind('api/cliente/delete');



///// produto//////
// Insert
$app->post('api/produto', function (Request $request) use ($app) {
    $dados = [
        "nome" => $request->get("nome") ? $request->get("nome") : "",
        "descricao" => $request->get("descricao") ? $request->get("descricao") : "",
        "valor" => $request->get("valor") ? $request->get("valor") : ""
    ];

    $produtoService = $app['produtoService'];
    $result = $produtoService->insert($dados);
    $status = $result['success'] ? 200 : 400;

    return $app->json($result, $status);
})->bind('api/produto/insert');

// mostra um
$app->get('api/produto/{id}', function ($id) use ($app) {

    $produtoService = $app['produtoService'];
    $result = $produtoService->find($id);
    $status = $result['success'] ? 200 : 400;
    return $app->json($result, $status);
})->bind('api/produto/fetch');

// mostra todos
$app->get('api/produto', function () use ($app) {

    $produtoService = $app['produtoService'];
    $result = $produtoService->fetchAll();
    $status = $result['success'] ? 200 : 400;
    return $app->json($result, $status);

})->bind('api/produto/fetchall');

// update
$app->put('api/produto/{id}', function (Request $request, $id) use ($app) {
    $dados = [
        "nome" => $request->get("nome") ? $request->get("nome") : "",
        "descricao" => $request->get("descricao") ? $request->get("descricao") : "",
        "valor" => $request->get("valor") ? $request->get("valor") : ""
    ];

    $produtoService = $app['produtoService'];
    $result = $produtoService->update($id, $dados);
    $status = $result['success'] ? 200 : 400;
    return $app->json($result, $status);
})->bind('api/produto/update');

// delete
$app->delete('api/produto/{id}', function ($id) use ($app) {

    $produtoService = $app['produtoService'];
    $result = $produtoService->delete($id);
    $status = $result['success'] ? 200 : 400;
    return $app->json($result, $status);
})->bind('api/produto/delete');

// erro
$app->error(function (\Exception $e, $code) use ($app){
    switch ($code) {
        case 404:
            $message = ['success'=>false, 'message'=>'The requested page could not be found.'];
            break;
        default:
            $message = ['success'=>false, 'message'=>'We are sorry, but something went terribly wrong.'];
    }

    return $app->json($message, $code);
});
$app->run();