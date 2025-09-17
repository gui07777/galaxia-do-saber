<?php

session_start();

require_once('../../../../Model/conexaoBanco/Conexao.php');

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

            header('Location: ../../../logged/teacher/teacher-home/teacher-home.html');

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