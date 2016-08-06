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
    
    public function update($id, $dados)
    {

        $produto = $this->find($id);
        if (!$produto) {
            return ["success" => false, "message" => "not found."];
        }
        $produto['nome'] = ($dados['nome']) ? $dados['nome'] : $produto['nome'];
        $produto['descricao'] = ($dados['descricao']) ? $dados['descricao'] : $produto['descricao'];
        $produto['valor'] = ($dados['valor']) ? $dados['valor'] : $produto['valor'];
        $sql = "update produtos set nome = :nome, descricao = :descricao, valor = :valor where id = :id";
        $statement = $this->db->prepare($sql);
        $statement->bindValue("nome", $produto['nome']);
        $statement->bindValue("descricao", $produto['descricao']);
        $statement->bindValue("valor", $produto['valor']);
        $statement->bindValue("id", $produto['id']);
        $statement->execute();
        return ["success"=>true];
    }

    public function delete($id)
    {
        $entity = $this->find($id);
        if (!$entity) {
            return ["success" => false, 'message' => 'not found."'];
        }
        $sql = "delete from produtos where id = :id";
        $statement = $this->db->prepare($sql);
        $statement->bindValue('id', $id);
        $statement->execute();
        return ['success'=>true];
    }
}