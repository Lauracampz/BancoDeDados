<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            overflow: hidden; /* Impede a barra de rolagem horizontal */
        }

        .background-image {
            background-image: url("../Imagens/sobre.jpeg");
            background-size: 1300px 700px; /* Define o tamanho original da imagem */
            background-position: center center;
            background-attachment: fixed;
            color: #fff;
            text-align: center;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden; /* Impede a barra de rolagem horizontal dentro da div */
        }

        .content {
            z-index: 1; /* Garante que o conteúdo fique sobre a imagem de fundo */
        }

        h1 {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="background-image">
        <div class="content">
            
        </div>
    </div>
</body>
</html>
