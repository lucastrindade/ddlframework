<?php

namespace Core\Request;

/**
 * Manipulação das requisições
 * 
 * @class Request
 */
class Request
{
    /**
     * Consulta do método da requisição
     *
     * @return string
     */
    public function method(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}