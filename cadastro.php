
</html>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <title>Cadastro</title>
    <link rel="stylesheet" href="../CSS/estiloCadastro.css">
</head>

<body>
    <div id="corpo-form">
        <form method="POST">
            <h1>Cadastro</h1>

            <label for="tipo_cadastro">Escolha o tipo de cadastro:</label>
            <select id="tipo_cadastro" name="tipo_cadastro">
                <option value="usuario">Usuário</option>
                <option value="autonomo">Autônomo</option>
            </select>

            <label for="tipo_servico" id="label_tipo_servico" style="display: none;">Tipo de Serviço:</label>
            <input type="text" id="tipo_servico" name="tipo_servico" maxlength="100" style="display: none;">

            <label for="cpf">CPF:</label>
            <input type="text" id="cpf" name="cpf" maxlength="11" required>

            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" maxlength="100" required>

            <label for="telefone">Telefone:</label>
            <input type="text" id="telefone" name="telefone" maxlength="16" required>

            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" maxlength="100" required>

            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" maxlength="20" required>

            <input type="submit" style="width: 100%; padding: 5px; font-size: 14px;border: 1px black; border-radius: 5px; cursor: pointer;" value="Cadastrar">

        </form>
    </div>

    <script>
        document.getElementById("tipo_cadastro").addEventListener("change", function () {
            var tipoServicoLabel = document.getElementById("label_tipo_servico");
            var tipoServicoInput = document.getElementById("tipo_servico");

            if (this.value === "autonomo") {
                tipoServicoLabel.style.display = "block";
                tipoServicoInput.style.display = "block";
            } else {
                tipoServicoLabel.style.display = "none";
                tipoServicoInput.style.display = "none";
            }
        });
    </script>
</body>

</html>

<?php

require_once('..\includes\Usuario.php');
require_once('..\includes\Autonomo.php'); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipo_cadastro = $_POST['tipo_cadastro'];
    $tipo_servico = $_POST['tipo_servico'];
    $cpf = $_POST['cpf'];
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    if ($tipo_cadastro === "usuario") {
        $usuarioObj = new Usuario();
        $resultadoCadastro = $usuarioObj->cadastrarUsuario($cpf, $senha, $nome, $telefone, $email);
    } elseif ($tipo_cadastro === "autonomo") {
        
        $autonomoObj = new Autonomo();
        $resultadoCadastro = $autonomoObj->cadastrarAutonomo ($cpf, $nome, $telefone, $email, $senha, $tipo_servico);
    } else {
        // Lógica de erro se o tipo de cadastro não for reconhecido
        $resultadoCadastro = "Tipo de cadastro não reconhecido";
    }

    echo $resultadoCadastro;
}
?>

