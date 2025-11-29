<link rel="stylesheet" href="institution-communication.css">
<div id="general-comunication">
  <div class="header">
    <div class="container">


      <h1 class="titulo">Comunicados</h1>
      <div class="layout">
        <aside class="publicados">
          <h2>Publicados</h2>
          <ul id="lista-comunicados"></ul>
          <p id="sem-comunicados">Você não tem comunicados publicados</p>
        </aside>

        <main class="painel">
          <div id="mensagem-inicial" class="mensagem">
            <p>Você não selecionou nenhum comunicado. Deseja criar um comunicado?</p>
            <button id="btn-adicionar" class="btn">Adicionar</button>
          </div>
          <form id="form-comunicado" class="form hidden">

            <label for="assunto">Ass:</label>
            <input type="text" id="assunto" required />

            <label for="descricao">Descrição:</label>
            <textarea id="descricao" required></textarea>

            <div class="checkbox-area">
              <label>
                <input type="checkbox" id="cbProfessor" name="professor"> Enviar para Professores
              </label>

              <label>
                <input type="checkbox" id="cbAluno" name="aluno"> Enviar para Alunos
              </label>
            </div>

            <button type="submit" class="btn">Salvar</button>
          </form>


          <div id="detalhes-comunicado" class="detalhes hidden">
            <p><strong>Ass:</strong> <span id="detalhe-assunto"></span></p>
            <p><strong>Descrição:</strong> <span id="detalhe-descricao"></span></p>
            <button id="btn-editar" class="btn">Editar</button>
          </div>
        </main>
      </div>
    </div>

    <script src="institution-communication.js"></script>