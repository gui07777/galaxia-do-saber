<?php

session_start();

require_once('../Model/conexaoBanco/Conexao.php');

$email = $_POST['email'] ?? "";
$senha = $_POST['senha'] ?? "";

if (!empty($email) && !empty($senha)) {

    try {
        $sql = 'SELECT * FROM aluno WHERE email = :email';
        $requisicao = $conexao->prepare($sql);
        $requisicao->bindParam(':email', $email);
        $requisicao->execute();

        $aluno = $requisicao->fetch(PDO::FETCH_ASSOC);

        if ($aluno) {
            if (password_verify($senha, $aluno['senha'])) {

                $_SESSION['id_aluno'] = $aluno['id_aluno'];
                $_SESSION['nome_aluno'] = $aluno['nome'];

                if (!empty($aluno['id_turma'])) {
                    $_SESSION['id_turma'] = $aluno['id_turma'];
                } else {
                    $_SESSION['id_turma'] = null;
                }

                echo "<script> 
                    alert('Login feito com sucesso!'); 
                    setTimeout(function() { 
                        window.location.href = '../View/logged/student/activities-zone/activities-zone.php'; 
                    }, 500); 
                </script>";
                exit;

            } else {
                echo "<script>
                    alert('Senha incorreta');
                    window.history.back();
                </script>";
                exit;
            }

        } else {
            
            echo "<script>
                alert('Aluno não encontrado!');
                window.history.back();
            </script>";
            exit;
        }

    } catch (PDOException $e) {
        echo "<script>
            alert('Erro no banco de dados: " . $e->getMessage() . "');
            window.history.back();
        </script>";
        exit;
    }

} else {
    echo "<script>
        alert('Preencha todos os campos!');
        window.history.back();
    </script>";
    exit;
}
?>
