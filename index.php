<html lang="pt-br">

<head>
    <title>Sistema de login</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="CSS\estiloLogin.css">
</head>

<body>
    <div id="corpo-form">
        <form method="POST">
            <h1>Entrar</h1>
            <input type="text" name="cpf" placeholder="Usuário(CPF)" maxlength="11" required>
            <input type="password" name="senha" placeholder="Senha" maxlength="20" required>

            <input type="submit" value="ACESSAR">
            <fieldset>
                <legend>Escolha seu tipo de login:</legend>
                <label for="tipo_login">Tipo de Login:</label>
                <select id="tipo_login" name="tipo_login">
                    <option value="Autônomo" selected>Autônomo</option>
                    <option value="Usuário">Usuário</option>
                </select>
            </fieldset>
            <a href="pags\cadastro.php">Ainda não é inscrito ?<strong> Cadastre-se! <strong> </a>
        </form>
    </div>
</body>

</html>

<?php

require_once('includes/Usuario.php');
require_once('includes/Autonomo.php'); // Certifique-se de incluir o arquivo Autonomo.php se ainda não o fez.
session_start();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtenha os dados do formulário
    $cpf = $_POST['cpf'];
    $senha = $_POST['senha'];
    $tipoLogin = $_POST['tipo_login'];

    // Salve o CPF na sessão de acordo com o tipo de login
    if ($tipoLogin == "Autônomo") {
        $_SESSION['cpfAutonomoLogado'] = $cpf;
    } elseif ($tipoLogin == "Usuário") {
        $_SESSION['cpfUsuarioLogado'] = $cpf;
    }

    // Verifique o tipo de login selecionado
    if ($tipoLogin == "Autônomo") {
        // Se for "Autônomo", instancie um objeto Autonomo
        $autonomoObj = new Autonomo();
        $resultadoLogin = $autonomoObj->logarAutonomo($cpf, $senha);
    } elseif ($tipoLogin == "Usuário") {
        // Se for "Usuário", instancie um objeto Usuario
        $usuarioObj = new Usuario();
        $resultadoLogin = $usuarioObj->logarUsuario($cpf, $senha);
    } else {
        // Tipo de login inválido
        $resultadoLogin = "Tipo de login inválido.";
    }

    if ($resultadoLogin == "Login realizado com sucesso") {
        if($tipoLogin == "Usuário"){
            header("Location: pags\pagUsuario.php");
            exit(); // Certifique-se de sair após o redirecionamento
        } else {
            header("Location: pags\pagAutonomo.php");
            // exit(); // Certifique-se de sair após o redirecionamento
        }
    } else {
        // Exiba o resultado
        echo $resultadoLogin;
    }
}

?>
