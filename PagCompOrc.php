<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Autônomos e Anúncios por Categoria</title>
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
        .card {
            width: 50%;
            margin-top: 20px;
            padding: 15px;
            background-color: #f2f2f2;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        h2 {
            color: #333;
        }
    </style>
</head>
<body>

<?php
// Inclua a classe ConsultaBanco e crie uma instância
require_once("..\includes\conexao.php");
require_once("..\includes\ConsultaBD.php");

$conexao = new Conexao();
$consultaBanco = new ConsultaBanco($conexao);

// Obtenha estatísticas de serviços
$estatisticasServicos = $consultaBanco->compararOrcamentos();

// Exiba estatísticas de serviços em um card
echo "<h2>Estatísticas de Serviços</h2>";
foreach ($estatisticasServicos as $estatistica) {
    echo "<div class='card'>";
    echo "<p><strong>Categoria:</strong> {$estatistica['categoria']}</p>";
    echo "<p><strong>Especialização:</strong> {$estatistica['especializacao']}</p>";
    echo "<p><strong>Orcamento Mínimo:</strong> {$estatistica['orcamento_minimo']}</p>";
    echo "<p><strong>Orcamento Máximo:</strong> {$estatistica['orcamento_maximo']}</p>";
    echo "<p><strong>Orcamento Médio:</strong> {$estatistica['orcamento_medio']}</p>";
    echo "</div>";
}

// Restante do código para exibir autônomos e anúncios por categoria, e categorias com mais de um autônomo...

?>

</body>
</html>
