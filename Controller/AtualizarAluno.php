<?php
session_start();
require_once('../Model/conexaoBanco/Conexao.php');


$email = $_SESSION['email_aluno'] ?? '';
$novaSenha = $_POST['novaSenha'] ?? '';

if (empty($email)) {
    echo "<script>
        alert('Sessão expirada. Faça login novamente.');
        window.location.href = '../../../auth/student/login/student-login.html';
    </script>";
    exit;
}


if (empty($novaSenha)) {
    echo "<script>
        alert('Digite uma nova senha para atualizar.');
        window.history.back();
    </script>";
    exit;
}

try {

    $senhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);


    $sql = "UPDATE aluno SET senha = :senha WHERE email = :email";
    $requisicao = $conexao->prepare($sql);
    $requisicao->execute([
        ':senha' => $senhaHash,
        ':email' => $email
    ]);

    echo "<script>
        alert('Senha atualizada com sucesso!');
        window.history.back();
    </script>";

} catch (PDOException $e) {
    echo "<script>
        alert('Erro ao atualizar senha: " . addslashes($e->getMessage()) . "');
        window.history.back();
    </script>";
}
?>
