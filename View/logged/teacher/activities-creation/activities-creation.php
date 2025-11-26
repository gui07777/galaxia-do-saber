<?php
session_start();

if (!isset($_SESSION['email_professor'])) {
header("Location: ../../../auth/teacher/login/teacher-login.html");
exit;
}
?>


<link rel="stylesheet" href="activities-creation.css">

<div id="activities-creation">
    <form class="form" method="POST" enctype="multipart/form-data"
        action="../../../../Controller/AtividadeController.php">

        <div class="container">
            <h1>Adicionar atividade</h1>

            <div class="fields">

                <div>
                    <label for="titulo">Título da Atividade:</label>
                    <input type="text" name="titulo" id="titulo" required>
                </div>

                <div>
                    <label for="prazo">Prazo (data limite):</label>
                    <input type="date" name="prazo" id="prazo" required>
                </div>

                <div>
                    <label for="id_turma">Turma: </label>
                    <select name="id_turma" id="id_turma" required>
                        <option value="">Selecione a turma</option>

                        <?php
                        require_once('../../../../Model/conexaoBanco/Conexao.php');
                        $t = $conexao->query("SELECT id_turma, nome FROM turma ORDER BY nome");
                        foreach ($t->fetchAll(PDO::FETCH_ASSOC) as $turma):
                        ?>
                            <option value="<?= $turma['id_turma'] ?>">
                                <?= htmlspecialchars($turma['nome']) ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>

                <div>
                    <label for="nome_arquivo">Nome do arquivo (como será exibido):</label>
                    <input type="text" name="nome_arquivo" id="nome_arquivo" placeholder="Ex.: Lista 01 - Matemática" maxlength="255">
                </div>

                <div>
                    <label for="anexo">Anexo (opcional):</label>
                    <input type="file" name="anexo" id="anexo"
                        accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.zip,.rar">
                </div>
            </div>

            <div class="buttons">
                <img src="../../../../assets/icons/volte.png" alt="" onclick="navigationBack()">
                <input type="submit" value="Criar" name="requisicao">
            </div>

        </div>
    </form>
</div>
