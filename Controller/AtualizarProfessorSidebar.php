<?php
require_once('../Model/conexaoBanco/Conexao.php');

$email = $_POST['email'];

$sql = $conexao->prepare("SELECT id_professor FROM professor WHERE email = :email");
$sql->bindParam(':email', $email);
$sql->execute();

if ($sql->rowCount() == 0) {
    echo "<script>
        alert('Nenhum professor encontrado com este email.');
        window.history.back();
    </script>";
    exit;
}

$sql = $conexao->prepare("
    UPDATE professor
    SET nome = :nome,
        cpf = :cpf,
        cargo = :cargo,
        disciplina = :disciplina
    WHERE email = :email
");

$sql->bindParam(':nome', $_POST['nome']);
$sql->bindParam(':cpf', $_POST['cpf']);
$sql->bindParam(':cargo', $_POST['cargo']);
$sql->bindParam(':disciplina', $_POST['disciplina']);
$sql->bindParam(':email', $email);

if ($sql->execute()) {
    echo "<script>
        alert('Professor atualizado com sucesso!');
        window.location.href='../View/logged/institution/sidebar/sidebar.html';
    </script>";
} else {
    echo "<script>
        alert('Erro ao atualizar.');
        window.history.back();
    </script>";
}
