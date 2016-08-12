<?php


namespace Code\Sistema\Services;

use Code\Sistema\Entities\Cliente;
use Code\Sistema\Mappers\ClienteMapper;
use Particle\Validator\Validator;


class ClienteService
{

    private $cliente;
    private $mapper;
    private $validator;

    /**
     * ClienteService constructor.
     */
    public function __construct(Cliente $cliente, ClienteMapper $mapper, Validator $validator)
    {
        $this->cliente = $cliente;
        $this->mapper = $mapper;
        $this->validator = $validator;
    }
    public function update($id, $dados){
        $this->validator->optional('nome')->alpha(true);
        $this->validator->optional('email')->email();
        $validate = $this->validator->validate($dados);
        if($validate->isNotValid()) {
            return ['success'=>false, 'message'=>$validate->getMessages()];
        }
        return ['success'=>true, 'result'=>$this->mapper->update($id, $dados)];
    }
    public function insert(array $data)
    {
        $this->validator->optional('nome')->alpha(true);
        $this->validator->optional('email')->email();

        $validate = $this->validator->validate($data);
        if($validate->isNotValid()) {
            return ['success'=>false, 'message'=>$validate->getMessages()];
        }
        $clientEntity = $this->cliente;
        $clientEntity->setNome($data['nome']);
        $clientEntity->setEmail($data['email']);

        return ['success'=>true, 'result'=>$this->mapper->insert($clientEntity)];
    }
    
    public function find($id) {
        $data['id'] = $id;
        $this->validator->required('id')->numeric();
        $validate = $this->validator->validate($data);
        if($validate->isNotValid()) {
            return ['success'=>false, 'message'=>$validate->getMessages()];
        }
        return ['success'=>true, 'result'=>$this->mapper->find($id)];
    }
    
    public function fetchAll(){
        return ['success'=>true, 'result'=>$this->mapper->fetchAll()];
    }


    public function delete($id){
        $data['id'] = $id;
        $this->validator->required('id')->numeric();
        $validate = $this->validator->validate($data);
        if($validate->isNotValid()) {
            return ['success'=>false, 'message'=>$validate->getMessages()];
        }
        return ['success'=>true, 'result'=>$this->mapper->delete($id)];
    }
}