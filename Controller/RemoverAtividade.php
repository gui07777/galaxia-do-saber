<?php
require_once(__DIR__ . '/../Model/conexaoBanco/Conexao.php');
ob_start();

$id_atividade = $_GET['id_atividade'] ?? null;

if (!$id_atividade || !ctype_digit($id_atividade)) {
    echo "<script>
            alert('ID da atividade inválido!');
            window.history.back();
          </script>";
    exit;
}

try {

    $sqlCheck = "SELECT id_atividade FROM atividades WHERE id_atividade = :id";
    $stmtCheck = $conexao->prepare($sqlCheck);
    $stmtCheck->bindParam(':id', $id_atividade, PDO::PARAM_INT);
    $stmtCheck->execute();

    if ($stmtCheck->rowCount() === 0) {
        echo "<script>
                alert('Atividade não encontrada!');
                window.history.back();
              </script>";
        exit;
    }

    $sqlRelacionamento = "DELETE FROM turmaAtividade WHERE id_atividade = :id";
    $stmtRelacionamento = $conexao->prepare($sqlRelacionamento);
    $stmtRelacionamento->bindParam(':id', $id_atividade, PDO::PARAM_INT);
    $stmtRelacionamento->execute();

    $sqlDelete = "DELETE FROM atividades WHERE id_atividade = :id";
    $stmtDelete = $conexao->prepare($sqlDelete);
    $stmtDelete->bindParam(':id', $id_atividade, PDO::PARAM_INT);
    $stmtDelete->execute();

    echo "<script>
            alert('Atividade removida com sucesso!');
            window.history.back();
          </script>";
    exit;

} catch (Exception $e) {

    echo "<script>
            alert('Erro ao remover atividade: " . $e->getMessage() . "');
            window.history.back();
          </script>";
    exit;
}
?>