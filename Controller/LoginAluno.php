<?php

// Arquivo de Login simples do Aluno:

session_start();
require_once('../Model/conexaoBanco/Conexao.php');

$email = $_POST['email'] ?? "";
$senha = $_POST['senha'] ?? "";

// Vai rodar a verificação no banco pelo email:

if (!empty($email) && !empty($senha)) {

    try {
        $sql = 'SELECT * FROM aluno WHERE email = :email';
        $requisicao = $conexao->prepare($sql);
        $requisicao->bindParam(':email', $email);
        $requisicao->execute();

        $aluno = $requisicao->fetch(PDO::FETCH_ASSOC);

        // Se existir o aluno, vai verificar se a senha coincide com a inserida no cadastro:

        if ($aluno) {
            if (password_verify($senha, $aluno['senha'])) {

                // Se coincidir, salva o id do aluno, nome e email, e SE já existir a id da turma, também irá salvar e permitirá o Login. 

                $_SESSION['id_aluno'] = $aluno['id_aluno'];
                $_SESSION['nome_aluno'] = $aluno['nome'];
                $_SESSION['email_aluno'] = $aluno['email']; 

                $_SESSION['id_turma'] = $aluno['id_turma'] ?? null;

                echo "<script> 
                    alert('Login feito com sucesso!'); 
                    setTimeout(function() { 
                        window.location.href = '../View/logged/student/student-home/student-home.php'; 
                    }, 500); 
                </script>";
                exit;

                // Se não, não permitirá o Login.

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
            alert('Erro no banco de dados: " . addslashes($e->getMessage()) . "');
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
