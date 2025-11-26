<?php
require_once '../Model/conexaoBanco/Conexao.php';

if (!isset($_GET['id'])) {
    die("ID inválido.");
}

$id = intval($_GET['id']);

$sql = $conexao->prepare("
    SELECT nome_arquivo, anexo
    FROM resposta
    WHERE id_resposta = ?
");
$sql->execute([$id]);
$arquivo = $sql->fetch(PDO::FETCH_ASSOC);

if (!$arquivo) {
    die("Arquivo não encontrado.");
}

$nomeArquivo = $arquivo['nome_arquivo'];
$dadosArquivo = $arquivo['anexo'];

if (empty($dadosArquivo)) {
    die("Nenhum arquivo anexado para esta resposta.");
}

header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . basename($nomeArquivo) . '"');
header('Content-Length: ' . strlen($dadosArquivo));
header('Pragma: public');

echo $dadosArquivo;
exit;
