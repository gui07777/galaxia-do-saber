CREATE DATABASE GalaxiaDoSaber;
USE GalaxiaDoSaber;

CREATE TABLE endereco(
id_end INT AUTO_INCREMENT PRIMARY KEY,
cep VARCHAR(9),
rua VARCHAR(255),
numero VARCHAR(10),
complemento VARCHAR(100),
bairro VARCHAR(100),
municipio VARCHAR(100),
estado VARCHAR(2)
);

CREATE TABLE instituicao(
id_instituicao INT AUTO_INCREMENT PRIMARY KEY,
nome_fantasia VARCHAR(150) NOT NULL,
razao_social VARCHAR(150) NOT NULL,
cnpj VARCHAR(20) NOT NULL,
email VARCHAR(100) UNIQUE NOT NULL,
senha VARCHAR(255) NOT NULL,
codigo_inep INT NOT NULL,
telefone VARCHAR(15) NOT NULL,
id_end INT,
FOREIGN KEY(id_end) REFERENCES endereco(id_end)
);

CREATE TABLE professor(
id_professor INT AUTO_INCREMENT PRIMARY KEY,
nome VARCHAR(150) NOT NULL,
cpf VARCHAR(15) NOT NULL,
email VARCHAR(100) UNIQUE NOT NULL,
senha VARCHAR(255) NOT NULL,
cargo VARCHAR(100) NOT NULL,
disciplina VARCHAR(100) NOT NULL,
id_instituicao INT,
FOREIGN KEY (id_instituicao) REFERENCES instituicao(id_instituicao)
);

CREATE TABLE turma(
id_turma INT AUTO_INCREMENT PRIMARY KEY,
nome VARCHAR(100),
descricao VARCHAR(255),
id_instituicao INT,
FOREIGN KEY(id_instituicao) REFERENCES instituicao(id_instituicao)
);

CREATE TABLE aluno(
id_aluno INT AUTO_INCREMENT PRIMARY KEY,
id_turma INT,
nome VARCHAR(150) NOT NULL,
numero_matricula VARCHAR(255) NOT NULL,
email VARCHAR(100) UNIQUE NOT NULL,
senha VARCHAR(255) NOT NULL,
data_nasc VARCHAR(10),
FOREIGN KEY(id_turma) REFERENCES turma(id_turma)
);

CREATE TABLE matricula(
id_matricula INT AUTO_INCREMENT PRIMARY KEY,
id_aluno INT,
id_turma INT,
FOREIGN KEY(id_aluno) REFERENCES aluno(id_aluno),
FOREIGN KEY (id_turma) REFERENCES turma(id_turma)
);

CREATE TABLE ensina(
id_ensina INT AUTO_INCREMENT PRIMARY KEY,
id_professor INT,
id_turma INT,
FOREIGN KEY(id_professor) REFERENCES professor(id_professor),
FOREIGN KEY (id_turma) REFERENCES turma(id_turma)
);

CREATE TABLE comunicados(
id_comunicado INT AUTO_INCREMENT PRIMARY KEY,
titulo VARCHAR(100),
conteudo VARCHAR(255),
data_post VARCHAR(10)
);

CREATE TABLE turmaComunicado(
id_comunicado INT,
id_turma INT,
FOREIGN KEY (id_comunicado) REFERENCES comunicados(id_comunicado),
FOREIGN KEY (id_turma) REFERENCES turma(id_turma)
);

CREATE TABLE profComunicado(
id_comunicado INT,
id_professor INT,
FOREIGN KEY (id_comunicado) REFERENCES comunicados(id_comunicado),
FOREIGN KEY (id_professor) REFERENCES professor(id_professor)
);

CREATE TABLE status(
id_status INT AUTO_INCREMENT PRIMARY KEY,
descricao VARCHAR(50)
);

CREATE TABLE atividades(
id_atividade INT AUTO_INCREMENT PRIMARY KEY,
titulo VARCHAR(100),
anexo LONGBLOB,
data_post DATETIME,
prazo VARCHAR(10)
);

CREATE TABLE turmaAtividade(
id_turmaAt INT AUTO_INCREMENT PRIMARY KEY,
id_atividade INT,
id_turma INT,
FOREIGN KEY (id_atividade) REFERENCES atividades(id_atividade),
FOREIGN KEY (id_turma) REFERENCES turma(id_turma)
);

CREATE TABLE resposta(
id_resposta INT AUTO_INCREMENT PRIMARY KEY,
data_envio DATETIME, 
anexo LONGBLOB,
nota DECIMAL(5,2),
comentario VARCHAR(100),
id_atividade INT,
id_aluno INT,
FOREIGN KEY (id_atividade) REFERENCES atividades(id_atividade),
FOREIGN KEY (id_aluno) REFERENCES aluno(id_aluno)
);

CREATE TABLE autenticacao(
id_autenticacao INT AUTO_INCREMENT PRIMARY KEY,
data_aut DATETIME NOT NULL,
email VARCHAR(100) NOT NULL,
codigo VARCHAR(10) NOT NULL,
id_status INT,
FOREIGN KEY (id_status) REFERENCES status(id_status)
);

ALTER TABLE instituicao ADD COLUMN notificado TINYINT(1) DEFAULT 0;
ALTER TABLE atividades ADD COLUMN nome_arquivo VARCHAR(100) AFTER anexo;
ALTER TABLE resposta ADD COLUMN nome_arquivo VARCHAR(100) AFTER anexo;

CREATE TABLE IF NOT EXISTS notifications(
    sender_id INT AUTO_INCREMENT PRIMARY KEY,
    receiver_id INT AUTO_INCREMENT,
    message_text VARCHAR(200),
    send_date DATE,
    is_read (0);
);