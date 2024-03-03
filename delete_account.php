<?php
// Incluir a classe de consulta e a classe de conexão
require_once("conexao.php");
require_once("ConsultaBD.php");

// Criar uma instância da classe de conexão
$minhaConexao = new Conexao();

// Criar uma instância da classe de consulta
$consulta = new ConsultaBanco($minhaConexao);
session_start();


$usuarioID = $_SESSION['cpfUsuarioLogado']; 

// Excluir o usuário do banco de dados
$consulta->excluirUsuarios($usuarioID);

// Fechar a conexão
$minhaConexao->fecharConexao();

// Redirecionar para a página de login
header("Location: ..\index.php");
exit();
?>
