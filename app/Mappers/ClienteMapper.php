<?php


namespace Code\Sistema\Mappers;

use Code\Sistema\Entities\Cliente;

class ClienteMapper
{
    private $db;


    public function __construct($db)
    {
        $this->db = $db;
    }

    public function insert(Cliente $cliente)
    {

        $dados = [
            "nome" => $cliente->getNome(),
            "email" => $cliente->getEmail()
        ];
        $this->db->insert('clientes', $dados);
        $dados["success"] = true;
        return $dados;
    }
    
    public function find($id){
        $statement = $this->db->executeQuery('SELECT * FROM clientes WHERE id = ?', [$id]);
        $dados = $statement->fetch();
        return $dados;
    }
    
    public function fetchAll(){
        $statement = $this->db->executeQuery('SELECT * FROM clientes');
        $dados = $statement->fetchAll();
        return $dados;
    }    
}