<?php


namespace Code\Sistema\Services;

use Code\Sistema\Entities\Produto;
use Code\Sistema\Mappers\ProdutoMapper;

class ProdutoService
{
    /**
     * @var Produto
     */
    private $produto;
    /**
     * @var ProdutoMapper
     */
    private $mapper;

    /**
     * ProdutoService constructor.
     */
    public function __construct(Produto $produto, ProdutoMapper $mapper)
    {
        $this->produto = $produto;
        $this->mapper = $mapper;
    }

    /**
     * @param array $data
     * @return array
     */
    public function insert(array $data)
    {
        $produtoEntity = $this->produto;

        $produtoEntity->setNome($data['nome'])
            ->setDescricao($data['descricao'])
            ->setValor($data['valor']);

        return $this->mapper->insert($produtoEntity);
    }

    public function find($id) {
        return $this->mapper->find($id);
    }

    public function fetchAll(){
        return $this->mapper->fetchAll();
    }
    public function update($id, $dados){
        return $this->mapper->update($id, $dados);
    }
    
    public function delete($id){
        return $this->mapper->delete($id);
    }    
}