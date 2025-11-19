<?php
require_once('../../../../Model/conexaoBanco/Conexao.php');

function sendNotification($senderId, $receiverId, $message, $conexao)
{
  $stmt = $conexao->prepare("INSERT INTO notifications (sender_id, receiver_id, message) VALUES (?, ?, ?)");
  $stmt->bind_param("iis", $senderId, $receiverId, $message);
  return $stmt->execute();
}
?>

<link rel="stylesheet" href="teacher-communication.css">
<div id="teacher-communication">
    <div class="header">
    <div class="container">

   <aside class="sidebar" id="sidebar">
     
    </aside>

    <main class="content">
      <h1 id="titulo">Comunicados 1</h1>

      <textarea id="texto" placeholder="Selecione um comunicado e clique em Editar para alterar." disabled></textarea>

     <div class="buttons">
        <button id="btnEditar" class="btn">Editar</button>
        <button id="btnRemover" class="btn">Remover</button>
        <button id="btnAdicionar" class="btn">Adicionar</button>
        <button id="btnSalvar" class="btn" onclick="sendNotification()">Salvar</button>
      </div>
    </main>

  </div>

<script src="teacher-communication.js"></script>