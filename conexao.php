<?php
class Conexao {
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = " dadosanuncio";
    public $conn;

    public function __construct() {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        if ($this->conn->connect_error) {
            die("Conexão falhou: " . $this->conn->connect_error);
        }
    }
    public function getConexao() {
        return $this->conn;
    }

    public function fecharConexao() {
        $this->conn->close();
    }
}
?>

