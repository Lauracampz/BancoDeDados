<?php
require_once("conexao.php");

class Autonomo {
    private $db;

    public function __construct() {
        $this->db = new conexao();
    }
    public function cadastrarAutonomo($cpf, $nome, $telefone, $email, $senha, $tipo_servico) {
        $sql = "INSERT INTO autonomo(cpf, senha, telefone, email, tiposervico, nome)
                VALUES ('$cpf','$senha','$telefone','$email','$tipo_servico','$nome')";
        
        if ($this->db->conn->query($sql) === TRUE) {
            return "Cadastro realizado com sucesso";
        } else {
            return "Erro no cadastro: " . $this->db->conn->error;
        }
    }
    
    


    public function logarAutonomo($cpf, $senha) {
        $sql = "SELECT * FROM autonomo WHERE cpf='$cpf' AND senha='$senha'";
        //echo $this->db->conn->query($sql);
        $result =  $this->db->conn->query($sql);
        

        if ($result->num_rows > 0) {

            return "Login realizado com sucesso";

            
        } else {
            return "CPF ou senha incorretos";
        }
    }
}

?>
