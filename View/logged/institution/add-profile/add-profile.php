<?php

session_start();

if (!isset($_SESSION['email_instituicao'])) {
  header("Location: ../../../auth/institution/login/institution-login.html");    
  exit;
}
?>

<link rel="stylesheet" href="add-profile.css">
<div id="add-profile">
  <form class="form" method="POST" action="../../../../Controller/RelacionarPerfil.php">
    <div class="container">
      <h1>Participantes da Turma</h1>
      <div class="fields">
        <div class="options">
          <div>
            <input type="checkbox" name="tipo[]" value="professor" id="professor">
            <label for="professor">Professor</label>
          </div>
          <div>
            <input type="checkbox" name="tipo[]" value="aluno" id="aluno">
            <label for="aluno">Aluno</label>
          </div>
        </div>
        <div id="professorSelect" style="display:none;">
          <label for="id_professor">Selecione o Professor:</label>
          <select name="id_professor" id="selectProfessor">
            <option value="">-- Escolha um professor --</option>
          </select>
        </div>
        <div id="alunoSelect" style="display:none;">
          <label for="id_aluno">Selecione o Aluno:</label>
          <select name="id_aluno" id="selectAluno">
            <option value="">-- Escolha um aluno --</option>
          </select>
        </div>
        <div class="turma">
          <label for="id_turma">Turma:</label>
          <select name="id_turma" id="selectTurma" required>
            <option value="">-- Escolha uma turma --</option>
          </select>
        </div>
      </div>
      <div class="buttons">
        <!-- <img src="../../../../assets/icons/volte.png" alt="Voltar" onclick="navigationBack()"> -->
        <input type="submit" value="Salvar" name="relacionar">
      </div>
    </div>
  </form>
</div>
<script src="add-profile.js"></script>