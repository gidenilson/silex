<?php


namespace Code\Sistema\Services;

use Code\Sistema\Entities\Cliente;
use Code\Sistema\Mappers\ClienteMapper;

class ClienteService
{
    /**
     * @var Cliente
     */
    private $cliente;
    /**
     * @var ClienteMapper
     */
    private $mapper;

    /**
     * ClienteService constructor.
     */
    public function __construct(Cliente $cliente, ClienteMapper $mapper)
    {
        $this->cliente = $cliente;
        $this->mapper = $mapper;
    }

    public function insert(array $data)
    {
        $clientEntity = $this->cliente;

        $clientEntity->setNome($data['nome']);
        $clientEntity->setEmail($data['email']);

        return $this->mapper->insert($clientEntity);
    }
}