<?php

//realizando o require_once do arquivo de configuração
//para ter certeza q ele existe
require_once("config.php");

//usando a classe do nomespace Cliente, para isso usa a palavra "use"
use Cliente\Cadastro;

//criando um objeto da classe Cadastro
$cad = new Cadastro();

//colocando os dados no objeto (set + nome do atributo + o dado)
$cad->setNome("<b> Amanda Farias </b>");
$cad->setEmail("<b> amandafharias@gmail.com </b>");
$cad->setSenha("ASF@asf0711");
$cad->setEndereco("Rua Presidente Artur Bernardes, 475, Edson Queiroz");
$cad->setTelefone("(85) 98779-9625");

//esse método já tem um echo p mostrar na tela
$cad->registrarVenda();
