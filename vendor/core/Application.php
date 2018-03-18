<?php

namespace Core;

use Core\Route\Router;

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