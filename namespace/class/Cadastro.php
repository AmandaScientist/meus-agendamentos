<?php 

class Cadastro {

    //atributos
    private $nome;
    private $email;
    private $senha;
    private $endereco;
    private $telefone;

    //métodos "gets" para os atributos
    public function getNome(): string //tipo string
    {
        return $this->nome;  //usamos o $this qdo referenciamos um atributo dentro do MÉTODO
                             //nesse caso estamos chamando o atributo "nome" na linha 6.
    }

    public function getEmail(): string //tipo string
    {
        return $this->email;  
    }

    public function getSenha(): int //tipo inteiro
    
    {
        return $this->senha;  
    }

    public function getEndereco(): string { //tipo string

        return $this->endereco;
    }
  
    public function getTelefone(): int { //tipo inteiro

        return $this->telefone;
    }

    //métodos "sets" para os atributos
    public function setNome($nome){ //o método set tem parâmetro e não é necessário return

        $this->nome = $nome; //referência o objeto no método ($this)

    }

    public function setEmail($email){ //o método set tem parâmetro e não é necessário return

        $this-> email = $email; //referência o objeto no método

    }

    public function setSenha($senha){ //o método set tem parâmetro e não é necessário return

        $this-> senha = $senha; //referência o objeto no método

    }

    public function setEndereco($endereco){

        $this -> enderco = $endereco; //referência o objeto no método
    }

    public function setTelefone($telefone){ // o método set tem parâmetro e não é necessário return

        $this -> telefone = $telefone; //referência o objeto no método
    }

    //criando um método mágico (to string) para os três atributos
    //O método __toString permite que uma classe decida como se comportar quando for convertida para uma string.
    public function __toString(){

        //json_encode -> Retorna uma string contendo a representação JSON do value. 
        //Se o parâmetro for um array ou objeto , ele será serializado recursivamente.
        return json_encode(array(
            "nome"=>$this->getNome(),
            "email"=>$this->getEmail(),
            "senha"=>$this->getSenha(),
            "endereco"=>$this->getEndereco(),
            "telefone"=>$this->getTelefone()
        ));
    }
}

?>