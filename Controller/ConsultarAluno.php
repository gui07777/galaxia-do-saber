<?php

require_once('../Model/conexaoBanco/Conexao.php');

$email = $_POST['email'];

if (!empty($email)) {

    $sql = "SELECT * FROM aluno WHERE email = :email";

    $requisicao = $conexao->prepare($sql);

    $requisicao->bindParam(':email', $email);

    try {

        $requisicao->execute();
        $aluno = $requisicao->fetch(PDO::FETCH_ASSOC);

        if ($aluno) {

            echo 'Aluno no sistema: ' . '<br>';
            echo 'Nome: ' . $aluno['nome'] . '<br>';
            echo 'Email: ' . $aluno['email'] . '<br>';

        } else {

            echo 'Usuário não existente no sistema.';

        }

    } catch (PDOException $e) {

        echo 'Erro: ' . $e->getMessage();

    }

} else {

    echo 'Insira um e-mail válido.';

}

?>