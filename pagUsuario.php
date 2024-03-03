<html lang="pt-br">

<head>
    <title>Sistema de Anúncio</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="..\CSS\estiloPagUsuario.css">
    
</head>

<body>

    <!-- Barra de navegação no topo -->
    <div class="navbar-top">
    
        <a href="..\index.php">Home</a>
        <a href="Pagsobre.php">Sobre</a>
        <a href="PagUsuarioAvali.php">Minhas Avaliações</a>
        <a href="PagVizuAuto.php">Vizualizar Autonomos</a>
        <a href="PagCompOrc.php">Comparar Orcamentos</a>
        <a href="..\includes\delete_account.php">Apagar Conta</a>
        <a href="..\index.php">Sair</a>
    </div>


    <?php
    // Incluir a classe de consulta e a classe de conexão
    require_once("..\includes\conexao.php");
    require_once("..\includes\ConsultaBD.php");

    // Criar uma instância da classe de conexão
    $minhaConexao = new Conexao();

    // Criar uma instância da classe de consulta
    $consulta = new ConsultaBanco($minhaConexao);

    // Obter os dados dos autônomos
    $anuncios = $consulta->obterAnuncios();

    // Fechar a conexão
    $minhaConexao->fecharConexao();
    ?>

    <?php
    // Função para converter a classificação em estrelas
    function classificacaoEmEstrelas($classificacao)
    {
        $estrelas = '';
        for ($i = 1; $i <= 5; $i++) {
            // Verifica se a posição da estrela é menor ou igual à classificação
            $estrelas .= ($i <= $classificacao) ? '★' : '☆'; // ★ para estrelas coloridas, ☆ para estrelas vazias
        }
        return '<span class="estrela">' . $estrelas . '</span>';
    }

    // Exibir os serviços
    foreach ($anuncios as $servico) {
        echo "<div class='card'>";
        // Exibir a imagem à esquerda
        echo "<img class='imagem-servico' src='" . $servico["imagem"] . "' alt='Imagem do Serviço'>";
        echo "<div class='texto'>"; // Contêiner para o texto
        echo "<h2>" . $servico["nome_servico"] . "</h2>";
        echo "<p>Descrição: " . $servico["descricao"] . "</p>";
        echo "<p>Orçamento: " . $servico["orcamento"] . "</p>";
        echo "<p>Código do Serviço: " . $servico["codservico"] . "</p>";
        echo "<p>Categoria: " . $servico["categoria"] . "</p>";
        echo "<p>Especialização: " . $servico["especializacao"] . "</p>";
        echo "<p>Autônomo: " . $servico["nome_autonomo"] . "</p>";

        // Verificar se há avaliações do autônomo
        if (!empty($servico["avaliacoes"])) {
            echo "<p>Avaliações do Autônomo:</p>";
            echo "<ul>";
            foreach ($servico["avaliacoes"] as $avaliacao) {
                echo "<li>" . classificacaoEmEstrelas($avaliacao["classificacao"]) . " " . $avaliacao["descricao"] . "</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>O autônomo ainda não possui avaliações.</p>";
        }
        echo "</div>"; // Fim do contêiner do texto
        echo "</div>";
    }
    ?>

</body>

</html>
