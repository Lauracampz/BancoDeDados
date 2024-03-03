<?php
class ConsultaBanco {
    private $conexao;

    public function __construct(Conexao $conexao) {
        $this->conexao = $conexao;
    }

    public function obterAnuncios() {
        $sql = "SELECT DISTINCT s.nome AS nome_servico, s.descricao, s.orcamento, s.codservico, 
        s.categoria, s.especializacao, s.imagem, a.telefone, a.nome AS nome_autonomo, a.cpf AS autonomo_cpf
        FROM servico s
        JOIN autonomos_area aa ON s.autonomo_cpf = aa.autonomo_cpf
        JOIN autonomo a ON aa.autonomo_cpf = a.cpf";

        
        $result = $this->conexao->getConexao()->query($sql);

        $anuncios = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Adiciona o nome do autônomo e suas avaliações ao resultado
                $row['avaliacoes'] = $this->obterAvaliacoesAutonomo($row['autonomo_cpf']);
                $anuncios[] = $row;
            }
        }

        return $anuncios;
    }

    private function obterAvaliacoesAutonomo($cpfAutonomo) {
        // Consulta as avaliações do autônomo pelo CPF
        $sql = "SELECT * FROM avaliacao WHERE autonomo_cpf = '$cpfAutonomo'";
        $result = $this->conexao->getConexao()->query($sql);

        $avaliacoes = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $avaliacoes[] = $row;
            }
        }

        return $avaliacoes;
    }
    public function obterAnunciosAutonomoLogado($cpfAutonomo) {
        $sql = "SELECT s.nome AS nome_servico, s.descricao, s.orcamento, s.codservico, s.categoria, 
                s.especializacao, s.imagem, a.telefone, a.nome AS nome_autonomo, a.cpf AS autonomo_cpf
                FROM servico s
                JOIN autonomos_area aa ON s.autonomo_cpf = aa.autonomo_cpf
                JOIN autonomo a ON aa.autonomo_cpf = a.cpf
                WHERE a.cpf = '$cpfAutonomo'";
        
        $result = $this->conexao->getConexao()->query($sql);

        $anuncios = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Adiciona o nome do autônomo e suas avaliações ao resultado
                $row['avaliacoes'] = $this->obterAvaliacoesAutonomo($row['autonomo_cpf']);
                $anuncios[] = $row;
            }
        }

        return $anuncios;
    }

    public function obterAutonomosNaoAvaliados($cpfUsuario) {
        $sql = "SELECT DISTINCT a.cpf, a.nome, a.telefone
                FROM autonomo a
                LEFT JOIN avaliacao av ON a.cpf = av.autonomo_cpf AND av.usuario_cpf = '$cpfUsuario'
                WHERE av.autonomo_cpf IS NULL";
    
        $result = $this->conexao->getConexao()->query($sql);
    
        $autonomosNaoAvaliados = array();
    
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $autonomosNaoAvaliados[] = $row;
            }
        }
    
        return $autonomosNaoAvaliados;
    }

    public function obterAvaliacoesUsuario($cpfUsuario) {
        $sql = "SELECT * FROM avaliacao WHERE usuario_cpf = '$cpfUsuario'";
        $result = $this->conexao->getConexao()->query($sql);
    
        $avaliacoes = array();
    
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $avaliacoes[] = $row;
            }
        }
    
        return $avaliacoes;
    }
    public function contarAutonomosNaoAvaliados($cpfUsuario) {
        $sql = "SELECT COUNT(DISTINCT a.cpf) AS total_autonomos_nao_avaliados
                FROM autonomo a
                LEFT JOIN avaliacao av ON a.cpf = av.autonomo_cpf AND av.usuario_cpf = '$cpfUsuario'
                WHERE av.autonomo_cpf IS NULL";
    
        $result = $this->conexao->getConexao()->query($sql);
    
        $row = $result->fetch_assoc();
    
        return $row['total_autonomos_nao_avaliados'];
    }
    public function obterAutonomosPorCategoria() {
        $sql = "SELECT a.nome, a.telefone, a.cpf, s.categoria
                FROM autonomo a
                JOIN autonomos_area aa ON a.cpf = aa.autonomo_cpf
                JOIN servico s ON aa.autonomo_cpf = s.autonomo_cpf
                GROUP BY a.cpf, s.categoria";
        
        $result = $this->conexao->getConexao()->query($sql);

        $autonomosPorCategoria = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $autonomosPorCategoria[$row['categoria']][] = $row;
            }
        }

        return $autonomosPorCategoria;
    }
    public function obterAnunciosPorCategoria() {
        $sql = "SELECT s.categoria, COUNT(DISTINCT s.codservico) as total_anuncios
        FROM servico s
        JOIN autonomos_area aa ON s.autonomo_cpf = aa.autonomo_cpf
        JOIN autonomo a ON aa.autonomo_cpf = a.cpf
        GROUP BY s.categoria";
        
        $anunciosPorCategoria = $this->conexao->getConexao()->query($sql);


        return $anunciosPorCategoria;
    }
    public function obterCategoriasComMaisDeUmAutonomo() {
        $sql = "SELECT s.categoria, COUNT(DISTINCT a.cpf) AS total_autonomos
                FROM servico s
                JOIN autonomos_area aa ON s.autonomo_cpf = aa.autonomo_cpf
                JOIN autonomo a ON aa.autonomo_cpf = a.cpf
                GROUP BY s.categoria
                HAVING total_autonomos > 1";
    
        $result = $this->conexao->getConexao()->query($sql);
    
        if ($result === false) {
            // Tratar erro de consulta, se necessário
            die('Erro na consulta: ' . $this->conexao->getConexao()->error);
        }
    
        $categoriasComMaisDeUmAutonomo = [];
    
        while ($row = $result->fetch_assoc()) {
            $categoria = $row['categoria'];
            $totalAutonomos = $row['total_autonomos'];
    
            $categoriasComMaisDeUmAutonomo[] = [
                'categoria' => $categoria,
                'total_autonomos' => $totalAutonomos,
            ];
        }
    
        return $categoriasComMaisDeUmAutonomo;
    }

    public function compararOrcamentos() {
        $sql = "SELECT
            s.categoria,
            s.especializacao,
            MIN(s.orcamento) AS orcamento_minimo,
            MAX(s.orcamento) AS orcamento_maximo,
            AVG(s.orcamento) AS orcamento_medio
        FROM
            servico s
        JOIN
            autonomos_area aa ON s.autonomo_cpf = aa.autonomo_cpf
        JOIN
            autonomo a ON aa.autonomo_cpf = a.cpf
        GROUP BY
            s.categoria,
            s.especializacao";
    
        $result = $this->conexao->getConexao()->query($sql);
    
        $estatisticas = array();
    
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $estatisticas[] = $row;
            }
        }
    
        return $estatisticas;
    }

    public function excluirUsuarios($usuarioID) {
        $sql = "DELETE FROM usuario WHERE cpf = '$usuarioID' ";

        try {
            $resultado = $this->conexao->getConexao()->query($sql);

            // Verifica se a consulta foi bem-sucedida
            if ($resultado) {
              //  $resultado->close();
            } else {
                // Tratar erro de consulta
                echo "Erro ao executar a consulta.";
                return false;
            }
        } catch (Exception $e) {
            // Tratar exceções ou registre conforme necessário
            echo "Erro ao excluir o usuário: " . $e->getMessage();
            return false;
        }

        return true;
    }
    
    
    
    
}
?>
