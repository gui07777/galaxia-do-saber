<?php

require_once(__DIR__ . '/../Model/conexaoBanco/Conexao.php');
ob_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $titulo = $_POST['titulo'] ?? null;
    $prazo = $_POST['prazo'] ?? null;
    $id_turma = $_POST['id_turma'] ?? null;
    $data_post = date("Y-m-d H:i:s");

    if (!$titulo || !$prazo || !$id_turma) {
        echo "<script>
        alert('Preencha todos os campos obrigatórios!');
        window.history.back();
        </script>";
        exit;
    }

    $nomeArquivo = null;
    $conteudoArquivo = null;

    if (!empty($_FILES['anexo']['name']) && $_FILES['anexo']['error'] === UPLOAD_ERR_OK) {

        $nomeArquivo = basename($_FILES['anexo']['name']);

        $arquivoTemp = $_FILES['anexo']['tmp_name'];

        $conteudoArquivo = file_get_contents($arquivoTemp);
    }

    try {

        $sql = "INSERT INTO atividades (titulo, anexo, nome_arquivo, data_post, prazo)
                VALUES (:titulo, :anexo, :nome_arquivo, :data_post, :prazo)";

        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':data_post', $data_post);
        $stmt->bindParam(':prazo', $prazo);
        $stmt->bindParam(':nome_arquivo', $nomeArquivo);

        if ($conteudoArquivo !== null) {
           
            $stmt->bindParam(':anexo', $conteudoArquivo, PDO::PARAM_LOB);

        } else {
            
            $arquivoNull = null;
            $stmt->bindParam(':anexo', $arquivoNull, PDO::PARAM_NULL);

        }

        $stmt->execute();

        $id_atividade = $conexao->lastInsertId();

        $sql2 = "INSERT INTO turmaAtividade (id_atividade, id_turma)
                 VALUES (:id_atividade, :id_turma)";

        $stmt2 = $conexao->prepare($sql2);
        $stmt2->bindParam(':id_atividade', $id_atividade);
        $stmt2->bindParam(':id_turma', $id_turma);
        $stmt2->execute();

        echo "<script>
                alert('Atividade criada com sucesso!');
                window.location.href = document.referrer;
              </script>";
        exit;

    } catch (Exception $e) {
        echo "<script>
        alert('Erro ao criar atividade: " . addslashes($e->getMessage()) . "');
        window.history.back();
        </script>";
        exit;
    }
}
?>
