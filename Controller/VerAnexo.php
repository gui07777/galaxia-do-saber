<?php
require_once('../Model/conexaoBanco/Conexao.php');

$id_atividade = $_GET['id_atividade'] ?? null;

if (!$id_atividade || !ctype_digit($id_atividade)) {
    http_response_code(400);
    exit("ID de atividade inválido.");
}

try {

    $sql = "SELECT anexo, nome_arquivo FROM atividades WHERE id_atividade = :id";
    $stmt = $conexao->prepare($sql);
    $stmt->bindValue(':id', $id_atividade, PDO::PARAM_INT);
    $stmt->execute();

    $atividade = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$atividade || empty($atividade['anexo'])) {
        http_response_code(404);
        exit("Nenhum anexo encontrado para esta atividade.");
    }

    $binario = $atividade['anexo'];
    $nomeArquivo = !empty($atividade['nome_arquivo'])
        ? $atividade['nome_arquivo']
        : "anexo_atividade_$id_atividade";

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->buffer($binario) ?: 'application/octet-stream';

    header("Content-Type: $mime");
    header("Content-Disposition: attachment; filename=\"$nomeArquivo\"");
    header("Content-Length: " . strlen($binario));
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Pragma: no-cache");

    echo $binario;
    exit;

} catch (PDOException $e) {
    http_response_code(500);
    exit("Erro no servidor: " . htmlspecialchars($e->getMessage()));
}
