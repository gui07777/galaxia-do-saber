<?php
require_once '../Model/conexaoBanco/Conexao.php';

$id = $_POST['id_resposta'] ?? null;
$nota = $_POST['nota'] ?? null;

if (!$id) {
    echo "ID inválido";
    exit;
}

$sql = $conexao->prepare("
    UPDATE resposta
    SET nota = ?
    WHERE id_resposta = ?
");

if ($sql->execute([$nota, $id])) {
    echo "OK";
} else {
    echo "Erro ao salvar";
}
