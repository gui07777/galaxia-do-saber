<?php

// Arquivo simples de Login da Instituição:

session_start();
require_once('../Model/conexaoBanco/Conexao.php');

$email = $_POST['email'];
$senha = $_POST['senha'];

// Começa verificando pelo email:

if (!empty($email) && !empty($senha)) {

    $sql = 'SELECT * FROM instituicao WHERE email = :email';

    $requisicao = $conexao->prepare($sql);
    $requisicao->bindParam(':email', $email);
    $requisicao->execute();

    $instituicao = $requisicao->fetch(PDO::FETCH_ASSOC);

     // Se existir, verifica se a senha é igual a do banco:

    if ($instituicao) {

        // Se for, salva o id, nome e email da instituição e permite o login

        if (password_verify($senha, $instituicao['senha'])) {

            $_SESSION['id_instituicao'] = $instituicao['id_instituicao'];
            $_SESSION['instituicao_nome'] = $instituicao['nome_fantasia'];
            $_SESSION['email_instituicao'] = $instituicao['email'];

            echo "<script> 
                alert('Login feito com sucesso!'); 
                setTimeout(function() { 
                    window.location.href = '../View/logged/institution/sidebar/sidebar.php'; 
                }, 30); 
            </script>";

            exit;

            // Se não, não permite o Login.

        } else {

            echo "<script>
            alert('Senha incorreta');
            window.history.back();
            </script>";
        }

    } else {
        echo "<script>
        alert('Instituição não encontrada!');
        window.history.back();
        </script>";
    }

} else {

    echo "<script>
    alert('Preencha todos os campos');
    window.history.back();
    </script>";
}

?>
