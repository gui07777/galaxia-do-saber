<?php

session_start();

require_once('../Model/conexaoBanco/Conexao.php');

$email = $_POST['email'];
$senha = $_POST['senha'];

if (!empty($email) && !empty($senha)) {

    $sql = 'SELECT * FROM professor WHERE email = :email';

    $requisicao = $conexao->prepare($sql);
    $requisicao->bindParam(':email', $email);
    $requisicao->execute();

    $professor = $requisicao->fetch(PDO::FETCH_ASSOC);

    if ($professor) {

        if (password_verify($senha, $professor['senha'])) {

            $_SESSION['id_professor'] = $professor['id'];
            $_SESSION['professor_nome'] = $professor['nome'];

            echo "<script> 
            alert('Login feito com sucesso!'); 
            setTimeout(function() { 
            window.location.href = '../View/logged/teacher/teacher-home/teacher-home.html'; 
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
    alert('Usuário não encontrado!');
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