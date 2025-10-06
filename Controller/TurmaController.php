<?php

$requisicao = $_POST['requisicao'];

switch($requisicao){

case 'Atualizar':

    include 'AtualizarTurma.php';
    break;

case 'Cadastrar':

    include 'CadastroTurma.php';
    break;

case 'Consultar':

    include 'ConsultarTurma.php';
    break;

case 'Remover':

    include 'RemoverTurma.php';
    break;

default:

    echo"Ação inválida, selecione uma opção válida.";
    break;
    
}

?>