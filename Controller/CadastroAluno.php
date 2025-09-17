<?php

require_once('../Model/conexaoBanco/Conexao.php');

$email = $_POST['email'];
$nome = $_POST['nome'];
$senha = $_POST['senha'];
$numero_matricula = $_POST['numero_matricula'];
$data_nasc = $_POST['data_nasc'];

if (!empty($email) && !empty($senha) && !empty($nome)) {

    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    $sql = "INSERT INTO aluno (email, nome, senha, numero_matricula, data_nasc) VALUES (:email, :nome, :senha, :numero_matricula, :data_nasc)";

    $requisicao = $conexao->prepare("$sql");

    $requisicao->bindParam(':nome', $nome);
    $requisicao->bindParam(':email', $email);
    $requisicao->bindParam(':senha', $senhaHash);
    $requisicao->bindParam('numero_matricula', $numero_matricula);
    $requisicao->bindParam('data_nasc', $data_nasc);

    try {

        $requisicao->execute();
        echo 'Aluno Cadastrado';

    } catch (PDOException $e) {

        echo 'Aluno não cadastrado, erro: ' . $e->getMessage();

    }

} else {

    echo '<p style = "color: red;"> Insira todos os valores nos respectivos campos. </p>';

}


?>