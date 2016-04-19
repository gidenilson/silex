<?php


namespace Code\Sistema\Mappers;

use Code\Sistema\Entities\Cliente;

class ClienteMapper
{
    public function insert(Cliente $cliente)
    {
        return [
            "nome" => $cliente->getNome(),
            "email" => $cliente->getEmail()
        ];
    }
}