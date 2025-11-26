<?php
require_once ('../Model/conexaoBanco/Conexao.php');

$id = $_GET['id'];

$sql = $conexao->prepare("
    SELECT r.arquivo, r.nota,
           a.nome AS aluno,
           atv.titulo AS atividade
    FROM resposta r
    JOIN aluno a ON a.id_aluno = r.id_aluno
    JOIN atividades atv ON atv.id_atividade = r.id_atividade
    WHERE r.id_resposta = ?
");

$sql->execute([$id]);
$resp = $sql->fetch(PDO::FETCH_ASSOC);

echo json_encode($resp);
