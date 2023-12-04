<?php 

//Namespace -> permite agrupar as classes dentro de diretórios de 
//uma forma organizada

//spl_autoload_register -> Registra a função dada como implementação de __autoload()
//para a função já existente

//Funções anônimas, também conhecidas como closures, permitem a criação de funções que não tem o nome especificado
//Nome da classe como parâmetro
spl_autoload_register(function($nameClasse) { 

    //local onde deve procurar as classes
    $dirClass = "class";

    //filename é o caminho do arquivo todo
    $filename = $dirClass . DIRECTORY_SEPARATOR . $nameClasse . ".php"; //concatena com a / do S.O.
                                                                        //.php  é a extensão do arquivo
                                                                        //caminho do arquivo

    //verificando se o arquivo existe
    //se existir já traz no require_once, inclui no código (filename)
    if (file_exists($filename)) {

        require_once($filename);
    }
    //exemplo estrutural do php

//realizar o teste de conexão com o banco mySQL
//teste de inclusão de  dados na tabela
//banco mysqli/pdo/sqlServer/postgreSQL

});

?>