<?php
session_start();
require_once '../../../../Model/conexaoBanco/Conexao.php';

if (!isset($_SESSION['email_professor'])) {
    header("Location: ../../../auth/teacher/login/teacher-login.html");
    exit;
}

$emailProfessor = $_SESSION['email_professor'];

$sqlProfessor = $conexao->prepare("
    SELECT id_professor 
    FROM professor 
    WHERE email = ?
");
$sqlProfessor->execute([$emailProfessor]);
$professor = $sqlProfessor->fetch(PDO::FETCH_ASSOC);

if (!$professor) {
    die("Erro ao identificar professor logado.");
}

$id_professor = $professor['id_professor'];


$sqlTurma = $conexao->prepare("
    SELECT t.id_turma
    FROM ensina e
    JOIN turma t ON t.id_turma = e.id_turma
    WHERE e.id_professor = ?
    LIMIT 1
");

$sqlTurma->execute([$id_professor]);
$turma = $sqlTurma->fetch(PDO::FETCH_ASSOC);

if (!$turma) {
    die("Nenhuma turma vinculada ao professor.");
}

$id_turma = $turma['id_turma'];

$sql = $conexao->prepare("
    SELECT 
        r.id_resposta,
        a.nome AS aluno_nome,
        atv.titulo AS atividade_titulo,
        r.nome_arquivo,
        r.nota,
        r.data_envio
    FROM resposta r
    JOIN aluno a ON a.id_aluno = r.id_aluno
    JOIN atividades atv ON atv.id_atividade = r.id_atividade
    WHERE a.id_turma = ?
");
$sql->execute([$id_turma]);
$entregas = $sql->fetchAll(PDO::FETCH_ASSOC);
?>



<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
<link rel="stylesheet" href="activities-delivered.css">

<div id="activities-delivered">
  <div class="container">

    <h1>Atividades entregues</h1>

    <table>
      <thead>
        <tr>
          <th>Aluno</th>
          <th>Atividade</th>
          <th>Entrega</th>
          <th>-</th>
        </tr>
      </thead>
      <tbody>

        <?php if (count($entregas) > 0): ?>
          <?php foreach ($entregas as $resp): ?>
            <tr>
              <td><?= htmlspecialchars($resp['aluno_nome']) ?></td>
              <td><?= htmlspecialchars($resp['atividade_titulo']) ?></td>
              <td><?= date("d/m/Y H:i", strtotime($resp['data_envio'])) ?></td>

              <td>
                <button class="btn-visualizar"
                        data-id="<?= $resp['id_resposta'] ?>"
                        data-aluno="<?= htmlspecialchars($resp['aluno_nome']) ?>"
                        data-atividade="<?= htmlspecialchars($resp['atividade_titulo']) ?>"
                        data-arquivo="<?= htmlspecialchars($resp['nome_arquivo'] ?? '') ?>"
                        data-nota="<?= htmlspecialchars($resp['nota'] ?? '') ?>">
                  Visualizar
                </button>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="4" style="text-align:center;">Nenhuma atividade entregue ainda.</td>
          </tr>
        <?php endif; ?>

      </tbody>
    </table>
  </div>
</div>

<div id="overlay-hide"></div>

<div id="activities-delivered-modal-hide">

    <header>
        <h2 id="modal-title">Detalhes da entrega</h2>
        <i class="material-symbols-outlined" id="closeModal">close</i>
    </header>

    <div class="content">

        <div class="feedback">
            <b>Aluno:</b> <span id="modal-aluno"></span>
        </div>

        <div class="feedback">
            <b>Atividade:</b> <span id="modal-atividade"></span>
        </div>

        <div class="feedback">
            <b>Arquivo enviado:</b>
            <a id="modal-arquivo" href="#" target="_blank">Baixar arquivo</a>
        </div>

        <div class="nota">
            <b>Nota:</b>
            <input type="number" id="modal-nota" min="0" max="10" placeholder="0 a 10">
        </div>

        <input type="hidden" id="modal-id-resposta">

        <div class="buttons">
            <button id="btnSalvarNota">Salvar nota</button>
        </div>

    </div>
</div>

<script src="activities-delivered.js"></script>
