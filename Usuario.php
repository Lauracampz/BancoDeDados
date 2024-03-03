<?php
require_once("conexao.php");

class Usuario {
    private $db;

    public function __construct() {
        $this->db = new conexao();
    }

    public function cadastrarUsuario($cpf, $senha, $nome, $telefone, $email) {
        
        $sql = "INSERT INTO usuario(cpf, senha, nome, telefone, email) 
        VALUES ('$cpf','$senha','$nome','$telefone','$email') ";

        if ($this->db->conn->query($sql) === TRUE) {
            return "Cadastro realizado com sucesso";
        } else {
            return "Erro no cadastro: " . $this->db->conn->error;
        }
    }


    public function logarUsuario($cpf, $senha) {
        $sql = "SELECT * FROM usuario WHERE cpf='$cpf' AND senha='$senha'";
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
