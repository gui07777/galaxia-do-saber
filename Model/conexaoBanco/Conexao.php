<?php

$host = 'localhost';
$nomeBanco = 'GalaxiaDoSaber';
$usuario = 'root';
$senha = '';

try {

    $conexao = new PDO(

        "mysql:host=$host;
        dbname=$nomeBanco;
        charset=UTF8",
        $usuario,
        $senha

    );

    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // echo "Conexão bem sucedida! <br><hr><br>";

} catch (PDOException $e) {

    echo "Erro: " . $e->getMessage();

}

?>