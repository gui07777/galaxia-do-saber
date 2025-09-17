<?php

session_start();

require_once('../../../../Model/conexaoBanco/Conexao.php');

$email = $_POST['email'];
$senha = $_POST['senha'];

if (!empty($email) && !empty($senha)) {

    $sql = 'SELECT * FROM instituicao WHERE email = :email';

    $requisicao = $conexao->prepare($sql);
    $requisicao->bindParam(':email', $email);
    $requisicao->execute();

    $instituicao = $requisicao->fetch(PDO::FETCH_ASSOC);

    if ($instituicao) {
        if (password_verify($senha, $instituicao['senha'])) {

            $_SESSION['id_instituicao'] = $instituicao['id'];
            $_SESSION['instituicao_nome'] = $instituicao['nome'];

            header('Location: ../../../logged/institution/instituion-home/institution-home.html');
            exit;

        } else {

            echo 'Senha incorreta';

        }

    } else {

        echo 'Usuário não encontrado!';

    }

} else {

    echo 'Preencha todos os campos';

}
?>