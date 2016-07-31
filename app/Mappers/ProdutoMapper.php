<?php


namespace Code\Sistema\Mappers;

use Code\Sistema\Entities\Produto;

class ProdutoMapper
{
    private $db;


    public function __construct($db)
    {
        $this->db = $db;
    }

    public function insert(Produto $produto)
    {
        $dados = [
            "nome" => $produto->getNome(),
            "descricao" => $produto->getDescricao(),
            "valor" => $produto->getValor(),
        ];
        $this->db->insert('produtos', $dados);
        $dados["success"] = true;
        return $dados;
    }

    public function find($id){
        $statement = $this->db->executeQuery('SELECT * FROM produtos WHERE id = ?', [$id]);
        $dados = $statement->fetch();
        return $dados;
    }

    public function fetchAll(){
        $statement = $this->db->executeQuery('SELECT * FROM produtos');
        $dados = $statement->fetchAll();
        return $dados;
    }
}