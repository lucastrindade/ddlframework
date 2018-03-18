<?php

namespace Core\Route;

use Core\Utils\Str;
use Core\Url\Url;
use Core\Request\Request;

class Router
{
    /** 
     * @var array $routes rotas do sistema 
     */
    private static $routes;

    /**
     * Adiciona uma rota para verbo get
     *
     * @param string $url
     * @param callable|string $callable
     * @param string $name
     * @return void
     */
    public static function get(string $url, $callable, string $name = null)
    {
        self::append('GET', $url, $callable, $name);
    }

    /**
     * Adiciona uma rota para verbo post
     *
     * @param string $url
     * @param callable|string $callable
     * @param string $name
     * @return void
     */
    public static function post(string $url, $callable, string $name = null)
    {
        self::append('POST', $url, $callable, $name);
    }

    /**
     * Adiciona uma rota para verbo put
     *
     * @param string $url
     * @param callable|string $callable
     * @param string $name
     * @return void
     */
    public static function put(string $url, $callable, string $name = null)
    {
        self::append('PUT', $url, $callable, $name);
    }

    /**
     * Devolve a rota da url atual
     *
     * @throws Exception
     * @return array
     */
    public static function matched(): array
    {
        $current = (new Url())->current();
        $method = (new Request())->method();

        $routes = self::$routes[$method];
        if(count($routes) == 0){
            throw new \Exception('route not found');
        }

        $matched = [];
        foreach($routes as $route){
            if(preg_match($route['regex'], $current)){
                $matched = $route;
                break;
            }
        }

        if(count($matched) == 0){
            throw new \Exception('route not found');
        }
        
        return $matched;
    }

    /**
     * Monta um array com os parâmetros da rota atual 
     *
     * @param string $url
     * @return array
     */
    public static function buildParams(string $url): array
    {
        $current = (new Url())->current();

		if(strpos($url, '{') === false){
			return [];
		}

		$current = explode('/', $current);
		$url = explode('/', $url);
		$params = array();
        foreach($url as $k => $v){
            if(Str::startsWith($v, '{') && Str::endsWith($v, '}')){
				$params[] = $current[$k];
            }
		}
		
		return $params;
    } 

    /**
     * Adiciona uma nova rota
     *
     * @param string $verb
     * @param string $url
     * @param callable|string $callable
     * @param string $name
     * @return $this
     */
    private static function append(string $verb, string $url, $callable, string $name = null)
    {
        self::$routes[$verb][] = [
            'url'       => $url, 
            'callable'  => $callable,
            'name'      => $name,
            'regex'     => self::buildRegex($url)
        ];
    }

    /**
     * Undocumented function
     *
     * @param string $url
     * @return string
     */
    private static function buildRegex(string $url): string
    {
        if($url == '/'){
            return "/^(\/?)$/";    
        }

        $url = explode('/', $url);
        $regex = '';
        foreach($url as $u){
            if(Str::startsWith($u, '{') && Str::endsWith($u, '}')){
                $regex .= '(\/.{1,}\/)';
            }else{
                $regex .= "({$u}\b)";
            }
        }
        
        return "/^(\/?){$regex}(\/?)$/";
    }
}