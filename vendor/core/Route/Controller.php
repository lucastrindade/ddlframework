<?php

namespace Core\Route;

use Core\View\Renderer;

class Controller
{
    /**
     * Renderiza a view com base nos parâmetros
     *
     * @param string $view
     * @param array $params
     * @param string $template
     */
    protected function view(string $view, array $params = [], string $template = null)
    {
        return (new Renderer($view, $params, $template))->render();
    }
}