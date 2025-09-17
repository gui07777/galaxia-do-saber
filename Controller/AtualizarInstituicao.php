<?php

require_once('../Model/conexaoBanco/Conexao.php');

$email = $_POST['email'];
$nome = $_POST['nome'];
$novaSenha = $_POST['senha'];

if (!empty($nome) && !empty($email)) {

    if (!empty($novaSenha)) {

        $senhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);

        $sql = "UPDATE aluno SET nome = :nome, senha = :senha WHERE email = :email";


    } else {

        $sql = "UPDATE aluno SET nome = :nome WHERE email = :email";

    }

    $requisicao = $conexao->prepare($sql);

    $requisicao->bindParam(':email', $email);
    $requisicao->bindParam(':nome', $nome);

    if (!empty($novaSenha)) {

        $requisicao->bindParam(':senha', $senhaHash);

    }

    try {

        $requisicao->execute();
        echo 'Informações do Aluno atualizadas.';

    } catch (PDOException $e) {

        echo 'Erro: ' . $e->getMessage();

    }

} else {

    echo 'Preencha o nome e o email para formalizar a atualização.';

}

?>