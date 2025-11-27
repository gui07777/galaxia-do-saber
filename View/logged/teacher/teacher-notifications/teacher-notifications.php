<?php
require_once '../../../../Model/conexaoBanco/Conexao.php';

$idProfessor = 1; // força para testar

$stmt = $conexao->prepare("SELECT * FROM notifications WHERE receiver_id = ?");
$stmt->execute([$idProfessor]);

$notificacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo '<pre>';
print_r($notificacoes);
echo '</pre>';
?>


<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
<link rel="stylesheet" href="teacher-notifications.css">
<div id="teacher-notifications">
    <div class="container">
        <div class="header">
            <h2>Notificações</h2>
        </div>
        <div class="fields" id="notifications-container">
        </div>
    </div>
</div>
<script src="teacher-notifications.js"></script>