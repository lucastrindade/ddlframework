<?php

namespace Core\Url;

/**
 * Manipulação de URL
 * 
 * @class Url
 */
class Url
{
    /**
     * Consulta da url atual do usuário
     *
     * @return string
     */
    public function current(): string
    {
        if(!isset($_GET['path'])){
			return '/';
		}

		// Captura o valor de $_GET['path']
		$path = $_GET['path'];
		
		// Limpa os dados
		$path = rtrim($path, '/');
        $path = filter_var($path, FILTER_SANITIZE_URL);
		return "{$path}";
    }
}