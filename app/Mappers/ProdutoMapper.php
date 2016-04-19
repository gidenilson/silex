<?php


namespace Code\Sistema\Mappers;

use Code\Sistema\Entities\Produto;

class ProdutoMapper
{
    public function insert(Produto $produto)
    {
        return [
            "id" => 1,
            "nome" => $produto->getNome(),
            "descricao" => $produto->getDescricao(),
            "valor" => $produto->getValor(),
        ];
    }
}