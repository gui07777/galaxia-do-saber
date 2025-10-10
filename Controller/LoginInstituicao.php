<?php

session_start();

require_once('../Model/conexaoBanco/Conexao.php');

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

            echo "<script> 
            alert('Login feito com sucesso!'); 
            setTimeout(function() { 
            window.location.href = '../View/logged/institution/sidebar/sidebar.html'; 
            }, 30); 
            </script>";

            exit;

        } else {

            echo "<script>
            alert('Senha incorreta');
            </script>";

        }
    } else {

        echo "<script>
        alert('Instituição não encontrado!');
        </script>";

    }
} else {

    echo "<script>
    alert('Preencha todos os campos');
    </script>";

}


?>