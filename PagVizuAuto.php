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

// Obtenha autônomos por categoria
$autonomosPorCategoria = $consultaBanco->obterAutonomosPorCategoria();

// Exiba autônomos por categoria em cards
foreach ($autonomosPorCategoria as $categoria => $autonomos) {
    echo "<h2>Autônomos na Categoria: $categoria</h2>";
    foreach ($autonomos as $autonomo) {
        echo "<div class='card'>
                <h2>{$autonomo['nome']}</h2>
                <p><strong>Categoria:</strong> $categoria</p>
                <p><strong>Telefone:</strong> {$autonomo['telefone']}</p>
                <p><strong>CPF:</strong> {$autonomo['cpf']}</p>
              </div>";
    }
}

// Obtenha anúncios por categoria
$anunciosPorCategoria = $consultaBanco->obterAnunciosPorCategoria();

// Exiba anúncios por categoria em cards
//foreach ($anunciosPorCategoria as $categoria => $anuncios) {
    echo "<h2>Anúncios por Categoria:</h2>";
    //foreach ($anuncios as $anuncio) {
        while ($row = $anunciosPorCategoria->fetch_assoc()) {
            echo "<div class='card'>
                 <tr>
                 <p><strong>Categoria:</strong> {$row['categoria']}</p>
                  <p><strong>Num:</strong> {$row['total_anuncios']}</p>
                  </tr>
                  </div>";
        }
              
    //}
//}



// Exiba categorias com mais de um autônomo em um card


// Exiba categorias com mais de um autônomo em um card
$categoriasComMaisDeUmAutonomo = $consultaBanco->obterCategoriasComMaisDeUmAutonomo();

// Exiba categorias com mais de um autônomo em um card
echo "<h2>Categorias com Mais de um Autônomo</h2>";

foreach ($categoriasComMaisDeUmAutonomo as $row) {
    echo "<div class='card'>";
    echo "<p><strong>Categoria:</strong> {$row['categoria']}</p>";
    echo "<p><strong>Num:</strong> {$row['total_autonomos']}</p>";
    echo "</div>";
}


?>

</body>
</html>
