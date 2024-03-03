<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Minhas Avaliações</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            background-image: url("../Imagens/fundoLoginCadastro.png");
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            
        }

        h2 {
            color: #333;
        }

        .card {
            width: 50%;
            margin-top: 20px;
            padding: 15px;
            background-color: #f2f2f2;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
        }

        a {
            text-decoration: none;
            color: blue;
        }

        .star {
            color: gold;
        }
    </style>
</head>

<body>
    <?php
    require_once("..\includes\conexao.php");
    require_once("..\includes\ConsultaBD.php");
    session_start();

    $conexao = new Conexao();
    $consultaBanco = new ConsultaBanco($conexao);

    if (isset($_SESSION['cpfUsuarioLogado'])) {
        $cpfUsuario = $_SESSION['cpfUsuarioLogado'];

        // Obtém avaliações do usuário
        $avaliacoesUsuario = $consultaBanco->obterAvaliacoesUsuario($cpfUsuario);

        // Obtém autônomos não avaliados pelo usuário
        $autonomosNaoAvaliados = $consultaBanco->obterAutonomosNaoAvaliados($cpfUsuario);

        echo "<div class='card'>
            <h2>Suas Avaliações</h2>";

        if (empty($avaliacoesUsuario)) {
            echo "<p>Você ainda não fez nenhuma avaliação.</p>";
        } else {
            echo "<table>
                <tr>
                    <th>CPF Autônomo</th>
                    <th>Classificação</th>
                    <th>Descrição</th>
                </tr>";

            foreach ($avaliacoesUsuario as $avaliacao) {
                echo "<tr>
                    <td>{$avaliacao['autonomo_cpf']}</td>
                    <td>" . generateStarRating($avaliacao['classificacao']) . "</td>
                    <td>{$avaliacao['descricao']}</td>
                </tr>";
            }

            echo "</table>";
        }

        echo "</div>";

        echo "<div class='card'>
            <h2>Autônomos Não Avaliados</h2>";

        if (empty($autonomosNaoAvaliados)) {
            echo "<p>Você avaliou todos os autônomos disponíveis.</p>";
        } else {
            echo "<ul>";

            foreach ($autonomosNaoAvaliados as $autonomo) {
                echo "<li>{$autonomo['nome']} (CPF: {$autonomo['cpf']}) - <a href='avaliar.php?cpf_autonomo={$autonomo['cpf']}'>Avaliar</a></li>";
            }

            echo "</ul>";
        }

        echo "</div>";
    } else {
        echo "<p>Usuário não autenticado. Faça login para acessar esta página.</p>";
    }

    // Função para gerar estrelas com base na classificação
    function generateStarRating($rating) {
        $stars = '';
        for ($i = 1; $i <= 5; $i++) {
            $stars .= ($i <= $rating) ? '<span class="star">&#9733;</span>' : '<span class="star">&#9734;</span>';
        }
        return $stars;
    }

    ?>

</body>

</html>

