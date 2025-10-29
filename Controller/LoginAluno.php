<?php

session_start();

require_once('../Model/conexaoBanco/Conexao.php');

$email = $_POST['email'];
$senha = $_POST['senha'];

if (!empty($email) && !empty($senha)) {

    $sql = 'SELECT * FROM aluno WHERE email = :email';

    $requisicao = $conexao->prepare($sql);
    $requisicao->bindParam(':email', $email);
    $requisicao->execute();

    $aluno = $requisicao->fetch(PDO::FETCH_ASSOC);

    if ($aluno) {
        if (password_verify($senha, $aluno['senha'])) {

            $_SESSION['aluno_id'] = $aluno['id'];
            $_SESSION['aluno_nome'] = $aluno['nome'];

            echo "<script> 
            alert('Login feito com sucesso!'); 
            setTimeout(function() { 
            window.location.href = '../View/logged/student/student-home/student-home.html'; 
            }, 30); 
            </script>";
            
            exit;

        } else {

            echo "<script>
        alert('Senha incorreta');
        window.history.back()
        </script>";

        }

    } else {

        echo "<script>
    alert('Aluno não encontrado!');
    window.history.back()
    </script>";

    }

} else {

    echo "<script>
    alert('Preencha todos os campos');
    window.history.back()
    </script>";

}
?>