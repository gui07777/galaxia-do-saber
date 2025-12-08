<?php

// Esse PHP tem a função de salvar a nota na tela de atividades entregues do professor;

require_once '../Model/conexaoBanco/Conexao.php';

$id = $_POST['id_resposta'] ?? null;
$nota = $_POST['nota'] ?? null;

// Aqui ele verifica se o id resposta existe

if (!$id) {
    echo "ID inválido";
    exit;
}

// Se houver o id existente, e se o professor tiver modificado a nota, ele roda o Update:

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
