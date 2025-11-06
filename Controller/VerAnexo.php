<?php
require_once('../Model/conexaoBanco/Conexao.php');

$id_atividade = $_GET['id_atividade'] ?? null;

if (!$id_atividade) {
    die("Atividade não especificada.");
}

try {
    $sql = "SELECT anexo FROM atividades WHERE id_atividade = :id";
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':id', $id_atividade, PDO::PARAM_INT);
    $stmt->execute();

    $atividade = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($atividade && !empty($atividade['anexo'])) {
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=atividade_{$id_atividade}.bin");
        echo $atividade['anexo'];
        exit;
    } else {
        echo "Nenhum anexo encontrado para esta atividade.";
    }

} catch (PDOException $e) {
    echo "Erro: " . htmlspecialchars($e->getMessage());
}
