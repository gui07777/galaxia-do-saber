<?php

require_once('../Model/conexaoBanco/Conexao.php');

$codigo = $_POST['codigo'] ?? '';

if (empty($codigo)) {

    echo "<script>
    alert ('Por favor, preencha o campo.'); 
    window.history.back();
    </script>";

    exit;
}

$sql = "SELECT * FROM autenticacao WHERE codigo = :codigo";
$stmt = $conexao->prepare($sql);
$smtm -> bindParam(':codigo', $codigo, PDO::PARAM_STR);
$stmt->execute([':codigo' => $codigo]);
$dados = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$dados) {

    echo "<script>
    alert ('Código incorreto. Tente novamente.'); 
    window.history.back();
    </script>";
    
    exit;
}


$dataAtual = date('Y-m-d H:i:s');

if ($dados['data_aut'] < $dataAtual) {
    echo "<script>
    alert('O código expirou. Solicite um novo.'); 
    window.location.href='index.html';
    </script>";
    exit;
    
}


echo "<script>
alert('Código verificado com sucesso! Acesso liberado.'); 
window.location.href='../View/logged/institution/sidebar/sidebar.html';
</script>";