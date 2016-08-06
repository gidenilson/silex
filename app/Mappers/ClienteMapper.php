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

    public function fetchAll()
    {
        $statement = $this->db->executeQuery('SELECT * FROM clientes');
        $dados = $statement->fetchAll();
        return $dados;
    }

    public function update($id, $dados)
    {

        $cliente = $this->find($id);
        if (!$cliente) {
            return ["success" => false, "message" => "not found."];
        }
        $cliente['nome'] = ($dados['nome']) ? $dados['nome'] : $cliente['nome'];
        $cliente['email'] = ($dados['email']) ? $dados['email'] : $cliente['email'];
        $sql = "update clientes set nome = :nome, email = :email where id = :id";
        $statement = $this->db->prepare($sql);
        $statement->bindValue("nome", $cliente['nome']);
        $statement->bindValue("email", $cliente['email']);
        $statement->bindValue("id", $cliente['id']);
        $statement->execute();
        return ["success" => true];
    }

    public function find($id)
    {
        $statement = $this->db->executeQuery('SELECT * FROM clientes WHERE id = ?', [$id]);
        $dados = $statement->fetch();
        return $dados;
    }

    public function delete($id)
    {
        $entity = $this->find($id);
        if (!$entity) {
            return ["success" => false, 'message' => 'not found."'];
        }
        $sql = "delete from clientes where id = :id";
        $statement = $this->db->prepare($sql);
        $statement->bindValue('id', $id);
        $statement->execute();
        return ['success'=>true];
    }
}