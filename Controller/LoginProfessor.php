<?php

// Arquivo simples de login, onde:

session_start();

require_once('../Model/conexaoBanco/Conexao.php');

$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';

// Vai rodar a verificação no banco pelo email:

if (!empty($email) && !empty($senha)) {

    $sql = 'SELECT * FROM professor WHERE email = :email';
    $requisicao = $conexao->prepare($sql);
    $requisicao->bindParam(':email', $email);
    $requisicao->execute();

    $professor = $requisicao->fetch(PDO::FETCH_ASSOC);

    // Se existir o professor, vai verificar se a senha coincide com a inserida no cadastro:

    if ($professor) {

        if (password_verify($senha, $professor['senha'])) {
            
            // Se coincidir, salva o id do professor, nome e email, e permite o login. 

            $_SESSION['id_professor'] = $professor['id_professor'];
            $_SESSION['professor_nome'] = $professor['nome'];
            $_SESSION['email_professor'] = $professor['email'];

            echo "<script> 
                alert('Login feito com sucesso!'); 
                setTimeout(function() { 
                    window.location.href = '../View/logged/teacher/teacher-sidebar/teacher-sidebar.php'; 
                }, 30); 
            </script>";
            exit;

        } else {

            // Se não, não permite o Login.
            
            echo "<script>
                alert('Senha incorreta');
                window.history.back();
            </script>";
            exit;
        }

    } else {
        echo "<script>
            alert('Usuário não encontrado!');
            window.history.back();
        </script>";
        exit;
    }

} else {
    echo "<script>
        alert('Preencha todos os campos');
        window.history.back();
    </script>";
    exit;
}
?>
