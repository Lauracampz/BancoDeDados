<?php
// Incluir a classe de consulta e a classe de conexão
require_once("..\includes\conexao.php");
require_once("..\includes\ConsultaBD.php");

// Criar uma instância de Conexao (substitua com sua lógica de conexão)
$conexao = new Conexao( /* parâmetros de conexão */);

// Criar uma instância da ConsultaBanco
$consulta = new ConsultaBanco($conexao);
session_start();

// Verifique se a variável de sessão está definida
if (isset($_SESSION['cpfAutonomoLogado'])) {
    // O CPF do autônomo logado está disponível na variável de sessão
    $cpfAutonomoLogado = $_SESSION['cpfAutonomoLogado'];
    echo $cpfAutonomoLogado;
} else {
    // Se a variável de sessão não estiver definida, o usuário não está logado
    echo "Usuário não autenticado";
    // Adicione redirecionamento ou outras ações conforme necessário
}

// Obter os anúncios do autônomo logado
$anuncios = $consulta->obterAnunciosAutonomoLogado($_SESSION['cpfAutonomoLogado']);
?>

<!DOCTYPE html>
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
        <a href="..\index.php">Sair</a>
    </div>


    <!-- Formulário para inserir área de serviço -->
    <div class="inserir-area-servico">
        <div class="categoria-container">
            <h2 class="categoria-titulo">Incluir Categorias</h2>
            <form action="processaInserirServico.php" method="POST">
                <label for="tipo_insercao">Escolha o tipo de insercao:</label>
                <select id="tipo_insercao" name="tipo_insercao">
                    <option value="usuario">Inserir anuncio</option>
                    <option value="autonomo">Inserir categorias</option>
                </select>
                <div id="dados_usuario" style="display: none;">
                    <div class="anuncio-container">
                        <h2 class="anuncio-titulo">Inserir Anúncio</h2>
                        <form action="processaInserirAnuncio.php" method="POST">
                            <label for="nome">Nome:</label>
                            <input type="text" id="nome" name="nome" required>
                            <br>

                            <label for="descricao">Descrição:</label>
                            <textarea id="descricao" name="descricao" required></textarea>
                            <br>

                            <label for="orcamento">Orçamento:</label>
                            <input type="text" id="orcamento" name="orcamento" required>
                            <br>

                            <label for="codservico">Código do Serviço:</label>
                            <input type="text" id="codservico" name="codservico" required>
                            <br>

                            <label for="catego">Categoria:</label>
                            <input type="text" id="catego" name="catego" required>
                            <br>

                            <label for="especi">Especialização:</label>
                            <input type="text" id="especi" name="especi" required>
                            <br>

                            <label for="autonomo_cpf">CPF do Autônomo:</label>
                            <input type="text" id="autonomo_cpf" name="autonomo_cpf" required>
                            <br>

                            <label for="imagem">Imagem:</label>
                            <input type="text" id="imagem" name="imagem" required>
                            <br>

                            <input type="submit" value="Inserir Anúncio">
                        </form>
                    </div>
                </div>

                <div id="dados_autonomo" style="display: none;">
                    <label for="categoria">Categoria:</label>
                    <select id="categoria" name="categoria">
                        <option value="beleza">Serviços de beleza</option>
                        <option value="construcao">Serviços de construção</option>
                        <option value="marcenaria">Serviços de marcenaria</option>
                        <option value="alimentacao">Serviços de alimentação</option>
                        <option value="mecanica">Serviço de mecânica</option>
                    </select>

                    <div id="especializacoes" style="display: none;">
                        <input type="text" id="anos_experiencia" name="anos_experiencia">
                        <br>

                        <label>Especializações:</label><br>


                        <!-- Checkboxes e campos de anos de experiência para especializações -->
                    </div>
                    <input type="submit" value="Inserir Área de Serviço">
                </div>

                <!--<input type="submit" value="Inserir Área de Serviço">-->
            </form>
        </div>
    </div>



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


    <script>
        // Script para mostrar/ocultar os dados adicionais para autônomos
        document.getElementById("tipo_insercao").addEventListener("change", function () {
            var dadosAutonomo = document.getElementById("dados_autonomo");
            var dadosUsuario = document.getElementById("dados_usuario");
            var especializacoesDiv = document.getElementById("especializacoes");
            if (this.value === "usuario") {
                dadosUsuario.style.display = (this.value === "usuario") ? "block" : "none";
                dadosAutonomo.style.display = "none";
                especializacoesDiv.style.display = "none"; // Oculta as especializações por padrão
            } else if (this.value === "autonomo") {
                dadosAutonomo.style.display = (this.value === "autonomo") ? "block" : "none";
                especializacoesDiv.style.display = "none"; // Oculta as especializações por padrão
                dadosUsuario.style.display = "none";
            } else {
                dadosUsuario.style.display = "none";
                dadosAutonomo.style.display = "none";
                especializacoesDiv.style.display = "none";
            }

            dadosAutonomo.style.display = (this.value === "autonomo") ? "block" : "none";
            especializacoesDiv.style.display = "none"; // Oculta as especializações por padrão
        });

        // Exibe as especializações quando uma categoria é selecionada
        document.getElementById("categoria").addEventListener("change", function () {
            var especializacoesDiv = document.getElementById("especializacoes");
            var categoriaSelecionada = this.value;

            // Mapeamento de especializações com base na categoria
            var especializacoesMap = {
                beleza: ["cabelereira", "manicure", "esteticista"],
                construcao: ["piscina", "reforma", "projetos arquitetônicos"],
                marcenaria: ["armários planejados", "quiosques"],
                alimentacao: ["Confeiteira", "Salgadeira", "Buffe"],
                mecanica: ["manutenção preventiva", "troca de óleo", "consertos"]
            };

            // Remove as opções existentes
            especializacoesDiv.innerHTML = "";

            // Adiciona a label "Anos de Experiência:"
            var labelAnosExperiencia = document.createElement("label");
            labelAnosExperiencia.setAttribute("for", "anos_experiencia");
            labelAnosExperiencia.appendChild(document.createTextNode("Anos de Experiência:"));
            var inputAnosExperiencia = document.createElement("input");
            inputAnosExperiencia.type = "text";
            inputAnosExperiencia.id = "anos_experiencia";
            //inputAnosExperiencia.name = "anos_experiencia";
            //especializacoesDiv.appendChild(labelAnosExperiencia);
            //especializacoesDiv.appendChild(inputAnosExperiencia);
            especializacoesDiv.appendChild(document.createElement("br"));

            // Adiciona as novas opções com base na categoria selecionada
            especializacoesMap[categoriaSelecionada].forEach(function (especializacao) {
                var checkbox = document.createElement("input");
                checkbox.type = "checkbox";
                checkbox.name = "especializacao[]";
                checkbox.value = especializacao;
                var label = document.createElement("label");
                label.appendChild(document.createTextNode(especializacao));

                // Adiciona campos de anos de experiência para cada especialização
                var labelAnosExperienciaEspecializacao = document.createElement("label");
                labelAnosExperienciaEspecializacao.setAttribute("for", "anos_experiencia_" + especializacao);
                labelAnosExperienciaEspecializacao.appendChild(document.createTextNode("Anos de Experiência para " + especializacao + ":"));
                var inputAnosExperienciaEspecializacao = document.createElement("input");
                inputAnosExperienciaEspecializacao.type = "text";
                inputAnosExperienciaEspecializacao.id = "anos_experiencia_" + especializacao;
                inputAnosExperienciaEspecializacao.name = "anos_experiencia_" + especializacao;

                especializacoesDiv.appendChild(checkbox);
                especializacoesDiv.appendChild(label);
                especializacoesDiv.appendChild(document.createElement("br"));
                especializacoesDiv.appendChild(labelAnosExperienciaEspecializacao);
                especializacoesDiv.appendChild(inputAnosExperienciaEspecializacao);
                especializacoesDiv.appendChild(document.createElement("br"));
            });

            // Exibe as especializações
            especializacoesDiv.style.display = "block";
        });

    </script>
</body>

</html>