<?php

require_once('../Model/conexaoBanco/Conexao.php');

$email = $_POST['email'];
$nome = $_POST['nome'];
$senha = $_POST['senha'];
$repetirSenha = $_POST['repetir_senha'];
$cpf = $_POST['cpf'];
$cargo = $_POST['cargo'];
$disciplina = $_POST['disciplina'];
$instituicaoNome = $_POST['razao_social'];

if (!empty($email) && !empty($senha) && !empty($nome)) {

    if ($senha !== $repetirSenha) {

        echo "<script>
        alert('As senhas não coincidem!');
        window.history.back()
        </script>";

        exit;

    }

    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    try {

        $conexao->beginTransaction();

            $sqlInst = "SELECT id_instituicao FROM instituicao WHERE razao_social = :nome";
            $stmtInst = $conexao->prepare($sqlInst);
            $stmtInst->bindParam(':nome', $instituicaoNome);
            $stmtInst->execute();
            $instituicao = $stmtInst->fetch(PDO::FETCH_ASSOC);
            $idInstituicao = $instituicao['id_instituicao'] ?? null;

        if (!$instituicao) {

            echo "<script>
            alert('Instituição não encontrada!');
            window.history.back()
            </script>";
            exit;

        }

        $idInstituicao = $instituicao['id_instituicao'];

        $sql = "INSERT INTO professor 
        (email, 
        nome, 
        senha,
        cpf,
        cargo,
        disciplina,
        id_instituicao)
        VALUES 
        (:email, 
        :nome, 
        :senha,
        :cpf,
        :cargo,
        :disciplina,
        :id_instituicao)";

        $requisicao = $conexao->prepare("$sql");

        $requisicao->bindParam(':nome', $nome);
        $requisicao->bindParam(':email', $email);
        $requisicao->bindParam(':senha', $senhaHash);
        $requisicao->bindParam(':cpf', $cpf);
        $requisicao->bindParam(':cargo', $cargo);
        $requisicao->bindParam(':disciplina', $disciplina);
        $requisicao->bindParam(':id_instituicao', $idInstituicao);

        $requisicao -> execute();

        $idProfessor = $conexao -> lastInsertId();

    
        $conexao->commit();

        echo "<script>
            alert('Professor Cadastrado');
                window.history.back();
          </script>";

    } catch (PDOException $e) {
        $conexao -> rollBack();
        echo"<script>
            alert('Professor não cadastrado, erro: " . addslashes($e -> getMessage()) . "');
            window.history.back()
        </script>";
    }

} else {

    echo "<script>
    alert('Insira todos os valores nos respectivos campos');
    window.history.back()
    </script>";
    
}

?>