<?php

namespace Core\View;

/**
 * Renderizador de view juntamente com template
 * 
 * @class Renderer
 */
class Renderer
{
    /** @var string $view caminho para a view separado por pontos */
    private $view;

    /** @var array $params parâmetros enviados para a view */
    private $params;

    /** @var string $template nome do template que a view usará */
    private $template;

    /**
     * Construtor do renderizador de views
     *
     * @param string $view
     * @param array $params
     * @param string $template
     */
    public function __construct(string $view, array $params = [], string $template = null)
    {
        $this->view = $view;
        $this->params = $params;
        $this->template = $template;
    }

    /**
     * Seta o nome do template que a view usará
     *
     * @param string $template
     * @return $this
     */
    public function template(string $template)
    {
        $this->template = $template;
        return $this;
    }

    /**
     * Renderiza a view juntamente com o template
     *
     * @return void
     */
    public function render()
    {       
        $view = str_replace('.', '/', $this->view);
        
        $content = $this->content(APPLICATION_PATH . "app/View/{$view}.php");
        if(!$this->template){
            echo $content;
            return;
        }

        $template = $this->content(APPLICATION_PATH . "app/View/template/{$this->template}/index.php");
        $page = str_replace('##CONTENT##', $content, $template);

        // verificação da existência de um header
        if(strpos($page, '##HEADER##') !== false){
            $header = $this->content(APPLICATION_PATH . "app/View/template/{$this->template}/header.php");
            $page = str_replace('##HEADER##', $header, $template);
        }

        // verificação da existência de um footer
        if(strpos($page, '##FOOTER##') !== false){
            $footer = $this->content(APPLICATION_PATH . "app/View/template/{$this->template}/footer.php");
            $page = str_replace('##FOOTER##', $header, $footer);
        }

        // inclusão de páginas personalizadas
        $page = $this->includes($page);

        echo $page;
        return;
    }

    /**
     * Devolve o conteúdo de um arquivo, passando as devidas variáveis
     *
     * @param string $path
     * @return void
     */
    private function content(string $path)
    {
        ob_start();
        extract($this->params, EXTR_OVERWRITE);
        include $path;
        return ob_get_clean();
    }

    /**
     * Aplicação, se houver, dos includes da view
     *
     * @param string $page
     * @return string
     */
    private function includes($page): string
    {
        $position = 0;
        $needle = '##INCLUDE';
        while(($position = strpos($page, $needle, $position)) !== false){
            $endPosition = strpos($page, ')##', $position); // posição final da string de include
            $start = ($position + strlen($needle)); // posição inicial para nome do arquivo

            $path = trim(substr($page, ++$start, ($endPosition - $start)), "'"); // consulta do nome do arquivo
            $path = str_replace('.', '/', $path); // troca do separador para barras

            $include = $this->content(APPLICATION_PATH . "app/View/{$path}.php"); // captura do conteúdo do arquivo incluído
            $page = substr_replace($page, $include, $position, (($endPosition + 3) - $position)); // replace do arquivo incluído na página

            $position = $position + strlen($needle); // adição de valores no "contador"
        }

        return $page;
    }
}