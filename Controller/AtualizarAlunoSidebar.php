<?php
session_start();
require_once('../Model/conexaoBanco/Conexao.php');

if (!isset($_SESSION['email_instituicao'])) {
    echo "<script>
        alert('Sessão expirada. Faça login novamente.');
        window.location.href='../../auth/login/institution-login.html';
    </script>";
    exit;
}

$nome = $_POST['nome'] ?? null;
$matricula = $_POST['numero_matricula'] ?? null;
$dataNasc = $_POST['data_nasc'] ?? null;
$email = $_POST['email'] ?? null;
$senha = $_POST['senha'] ?? null;
$repetirSenha = $_POST['repetir_senha'] ?? null;
$requisicao = $_POST['requisicao'] ?? null;

if ($requisicao !== "Atualizar") {
    echo "<script>
        alert('Requisição inválida.');
        window.history.back();
    </script>";
    exit;
}

if (empty($email)) {
    echo "<script>
        alert('Informe o email do aluno para realizar a atualização.');
        window.history.back();
    </script>";
    exit;
}

try {

    $stmtCheck = $conexao->prepare("
        SELECT id_aluno 
        FROM aluno 
        WHERE email = :email
        LIMIT 1
    ");
    $stmtCheck->bindParam(':email', $email);
    $stmtCheck->execute();

    if ($stmtCheck->rowCount() == 0) {
        echo "<script>
            alert('Nenhum aluno encontrado com este email.');
            window.history.back();
        </script>";
        exit;
    }

    if (!empty($senha) && $senha !== $repetirSenha) {
        echo "<script>
            alert('As senhas digitadas não conferem.');
            window.history.back();
        </script>";
        exit;
    }

    if (!empty($senha)) {

        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        $stmt = $conexao->prepare("
            UPDATE aluno
            SET nome = :nome,
                numero_matricula = :matricula,
                data_nasc = :data_nasc,
                senha = :senha
            WHERE email = :email
        ");

        $stmt->bindParam(':senha', $senhaHash);

    } else {

        $stmt = $conexao->prepare("
            UPDATE aluno
            SET nome = :nome,
                numero_matricula = :matricula,
                data_nasc = :data_nasc
            WHERE email = :email
        ");
    }

    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':matricula', $matricula);
    $stmt->bindParam(':data_nasc', $dataNasc);
    $stmt->bindParam(':email', $email);

    if ($stmt->execute()) {
        echo "<script>
            alert('Aluno atualizado com sucesso!');
            window.location.href='../View/logged/institution/sidebar/sidebar.html';
        </script>";
    } else {
        echo "<script>
            alert('Erro ao atualizar aluno.');
            window.history.back();
        </script>";
    }

} catch (Exception $e) {

    echo "<script>
        alert('Erro no servidor: " . $e->getMessage() . "');
        window.history.back();
    </script>";
}
?>
