<?php

// Esse PHP vai validar o código que é enviado para o email da Instituição;

require_once('../Model/conexaoBanco/Conexao.php');

$codigo = $_POST['codigo'] ?? '';

// Se não houver código, cai nesse loop abaixo:

if (empty($codigo)) {

    echo "<script>
    alert ('Por favor, preencha o campo.'); 
    window.history.back();
    </script>";

    exit;
}

// Se houver, roda as linhas e faz a consulta no banco;

$sql = "SELECT * FROM autenticacao WHERE codigo = :codigo";
$stmt = $conexao->prepare($sql);
$stmt -> bindParam(':codigo', $codigo, PDO::PARAM_STR);
$stmt -> execute([':codigo' => $codigo]);
$dados = $stmt->fetch(PDO::FETCH_ASSOC);

// Inserindo o código errado:

if (!$dados) {

    echo "<script>
    alert ('Código incorreto. Tente novamente.'); 
    window.history.back();
    </script>";
    
    exit;
}

// Verificação de tempo de expiração do código:

$dataAtual = date('Y-m-d H:i:s');

if ($dados['data_aut'] < $dataAtual) {
    echo "<script>
    alert('O código expirou. Solicite um novo.');
    </script>";
    exit;
    
}

// Inserindo o código corretamente, redireciona:

echo "<script>
alert('Código verificado com sucesso! Acesso liberado.'); 
window.location.href='../View/auth/institution/login/institution-login.html';
</script>";