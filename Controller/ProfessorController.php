<?php

$requisicao = $_POST['requisicao'];

switch($requisicao){

case 'Atualizar':

    include 'AtualizarProfessor.php';
    break;

case 'Cadastrar':

    include 'CadastroProfessor.php';
    break;

case 'Consultar':

    include 'ConsultaProfessor.php';
    break;

case 'Remover':

    include 'RemoverProfessor.php';
    break;


default:

    echo"Ação inválida, selecione uma opção válida.";
    break;
    
}

?>