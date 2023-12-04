<?php 

//informando o namespace desse arquivo
//nome da pasta,nesse caso é Cliente
namespace Cliente;

//classe para o cadastro Cliente
class Cadastro extends \Cadastro { //O \Cadastro volta na raíz e acha a classe Cadastro
                                  //vai extender e herdar tudo o q tem lá

    //método
    public function registrarVenda(){

        echo "Foi registrada uma venda para o cliente ".$this->getNome(),
        //echo "<br/>";
        $this->getEmail(),
        $this->getSenha();

        //TESTE
        //echo "Esse é o seu endereco de entrega".$this->getEndereco();
        //echo "Esse é o seu endereco de email".$this->getEmail();
    }
}


?>