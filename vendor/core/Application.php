<?php

namespace Core;

use Core\Route\Router;
use Core\Config\Config;

/**
 * @class Application
 */
class Application
{
	/**
	 * Inicializa a aplicação
	 * Analisa a url, e envia para a rota correta
	 *
	 * @return void
	 */
	public function bootstrap()
	{
		$this->loadRoutes();
		$this->loadConfigs();
	}

	/**
	 * Carrega as configurações
	 *
	 * @return void
	 */
	private function loadConfigs()
	{
		(new Config())->load();
	}

	/**
	 * Carrega as rotas e redireciona para a área correta
	 *
	 * @return void
	 */
	private function loadRoutes()
	{
		require_once APPLICATION_PATH . 'routes/routes.php'; 
		$matched = Router::matched();
		$params = Router::buildParams($matched['url']);
		
		if(is_callable($matched['callable'])){
			call_user_func_array($matched['callable'], $params);
		}else{
			list($controller, $method) = explode('@', $matched['callable']);
			call_user_func_array([new $controller(), $method], $params);
		}
	}
}