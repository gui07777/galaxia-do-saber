<?php

require_once('../Model/conexaoBanco/Conexao.php');

$email = $_POST['email'];

if (!empty($email)) {

    $sql = "SELECT * FROM instituicao WHERE email = :email";

    $requisicao = $conexao->prepare($sql);

    $requisicao->bindParam(':email', $email);

    try {

        $requisicao->execute();
        $instituicao = $requisicao->fetch(PDO::FETCH_ASSOC);

        if ($instituicao) {

            echo 'Instituição no sistema: ' . '<br>';
            echo 'Nome: ' . $instituicao['nome'] . '<br>';
            echo 'Email: ' . $instituicao['email'] . '<br>';

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