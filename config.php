<?php

return [
    /*
     * Habilita ou não o modo debug da aplicação 
     */
    'debug' => true,

    /*
     * Indica o ambiente atual da aplicação
     */
    'environment' => 'development',

    /*
     * Arquivo de configuração utilizado por cada ambiente disponível na aplicação
     * O arquivo deve estar localizado no diretório configs, na raiz do projeto
     */
    'config_files' => [
        'development'   => 'development.php',
        'homologation'  => 'homologation.php',
        'production'    => 'production.php',
    ]
];