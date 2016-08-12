<?php


namespace Code\Sistema\Services;

use Code\Sistema\Entities\Produto;
use Code\Sistema\Mappers\ProdutoMapper;
use Particle\Validator\Validator;

class ProdutoService
{

    private $produto;
     private $mapper;
    private $validator;

    /**
     * ProdutoService constructor.
     */
    public function __construct(Produto $produto, ProdutoMapper $mapper, Validator $validator)
    {
        $this->produto = $produto;
        $this->mapper = $mapper;
        $this->validator = $validator;
    }

    /**
     * @param array $data
     * @return array
     */
    public function insert(array $data)
    {
        $this->validator->optional('nome')->string();
        $this->validator->optional('descricao')->string();
        $this->validator->optional('valor')->numeric();
        $validate = $this->validator->validate($data);

        if($validate->isNotValid()) {
            return ['success'=>false, 'message'=>$validate->getMessages()];
        }
        $produtoEntity = $this->produto;
        $produtoEntity->setNome($data['nome'])
            ->setDescricao($data['descricao'])
            ->setValor($data['valor']);

        return ['success'=>true, 'result'=>$this->mapper->insert($produtoEntity)];
    }

    public function find($id) {
        $data['id'] = $id;
        $this->validator->required('id')->numeric();
        $validate = $this->validator->validate($data);
        if($validate->isNotValid()) {
            return ['success'=>false, 'message'=>$validate->getMessages()];
        }
        return ['success'=>true, 'result'=> $this->mapper->find($id)];
    }

    public function fetchAll(){

        return ['success'=>true, 'result'=>$this->mapper->fetchAll()];
    }
    public function update($id, $dados){
        $this->validator->optional('nome')->string();
        $this->validator->optional('descricao')->string();
        $this->validator->optional('valor')->numeric();
        $validate = $this->validator->validate($dados);
        if($validate->isNotValid()) {
            return ['success'=>false, 'message'=>$validate->getMessages()];
        }
        return ['success'=>true, 'result'=>$this->mapper->update($id, $dados)];
    }
    
    public function delete($id){
        $data['id'] = $id;
        $this->validator->required('id')->numeric();
        $validate = $this->validator->validate($data);
        if($validate->isNotValid()) {
            return ['success'=>false, 'message'=>$validate->getMessages()];
        }else{
            return ['success' => true, 'result' => $this->mapper->delete($id)];
        }
    }    
}