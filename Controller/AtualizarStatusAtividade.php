<?php

require_once(__DIR__ . '/../Model/conexaoBanco/Conexao.php');
ob_start();

try {

    $agora = date("Y-m-d H:i:s");

    $sql = "UPDATE atividades
            SET status = 'Atrasado'
            WHERE status = 'Pendente'
            AND prazo < :agora";

    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':agora', $agora);
    $stmt->execute();

    $quantidade = $stmt->rowCount();

    echo "<script>
            alert('$quantidade atividade(s) atualizada(s) para Atrasado.');
            window.history.back();
          </script>";
    exit;

} catch (Exception $e) {

    echo "<script>
            alert('Erro ao atualizar status: " . $e->getMessage() . "');
            window.history.back();
          </script>";
    exit;
}
?>
