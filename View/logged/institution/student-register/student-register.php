<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
<!-- <link rel="stylesheet" href="student-register.css"> -->
<div id="student-register">
    <form class="form" method="POST" form action="../../../../Controller/AlunoController.php">
        <div class="container">
            <h2>Cadastro de Alunos</h2>
            <div class="fields">
                <div class="left-side">
                    <div>
                        <label>Nome:</label>
                        <input type="text" name="nome" required>
                    </div>
                    <div>
                        <label>Número da matrícula:</label>
                        <input type="text" name="numero_matricula" required></input>
                    </div>
                    <div>
                        <label>Data de Nascimento:</label>
                        <input type="text" name="data_nasc" required>
                    </div>
                </div>
                <div class="right-side">
                    <div>
                        <label>Email:</label>
                        <input type="text" name="email" required>
                    </div>
                    <div>
                        <label>Senha:</label>
                        <input type="password" name="senha" required></input>
                    </div>
                    <div>
                        <label>Repetir senha:</label>
                        <input type="password" name="repetir_senha" required></input>
                    </div>
                </div>
            </div>
            <div class="buttons">
                <input type="submit" name="requisicao" value="Cadastrar">
            </div>
        </div>
    </form>
</div>