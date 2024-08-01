CREATE TABLE IF NOT EXISTS alunos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    data_nascimento DATE NOT NULL,
    usuario VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS turmas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    descricao TEXT,
    tipo VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS matriculas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    aluno_id INT,
    turma_id INT,
    FOREIGN KEY (aluno_id) REFERENCES alunos(id) ON DELETE CASCADE,
    FOREIGN KEY (turma_id) REFERENCES turmas(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL
);

INSERT INTO alunos (nome, data_nascimento, usuario) VALUES
('Ana Silva', '2001-01-15', 'ana.silva'),
('Bruno Costa', '2002-03-22', 'bruno.costa'),
('Carlos Oliveira', '2000-05-30', 'carlos.oliveira'),
('Daniela Santos', '1999-07-11', 'daniela.santos'),
('Eduardo Pereira', '2001-09-03', 'eduardo.pereira'),
('Fernanda Lima', '2002-11-18', 'fernanda.lima'),
('Gabriel Almeida', '2000-12-25', 'gabriel.almeida'),
('Helena Martins', '1999-04-17', 'helena.martins'),
('Igor Ribeiro', '2001-06-29', 'igor.ribeiro'),
('Juliana Ferreira', '2002-08-04', 'juliana.ferreira'),
('Karen Souza', '2000-10-15', 'karen.souza'),
('Leonardo Gomes', '1999-12-05', 'leonardo.gomes'),
('Mariana Rocha', '2001-02-20', 'mariana.rocha'),
('Natália Campos', '2002-04-11', 'natalia.campos'),
('Otávio Martins', '2000-06-23', 'otavio.martins'),
('Paula Almeida', '1999-08-14', 'paula.almeida'),
('Rafael Lima', '2001-11-30', 'rafael.lima'),
('Sofia Fernandes', '2002-01-12', 'sofia.fernandes'),
('Tatiane Silva', '2000-03-07', 'tatiane.silva'),
('Ulysses Ferreira', '1999-10-22', 'ulysses.ferreira');

INSERT INTO turmas (nome, descricao, tipo) VALUES
('Matemática I', 'Curso básico de Matemática', 'Fundamental'),
('História Geral', 'Curso de História Geral', 'Médio'),
('Química Orgânica', 'Curso avançado de Química Orgânica', 'Superior'),
('Programação Web', 'Curso de Desenvolvimento Web', 'Superior'),
('Física Experimental', 'Curso de Física Experimental', 'Médio');

INSERT INTO matriculas (aluno_id, turma_id) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 1),
(7, 2),
(8, 3),  
(9, 4),
(10, 5),
(11, 1), 
(12, 2),
(13, 3),
(14, 4),
(15, 5),
(16, 1),
(17, 2),
(18, 3),
(19, 4),
(20, 5);

INSERT INTO usuarios (email, senha) VALUES
('root@root.com', '$argon2id$v=19$m=65536,t=4,p=1$Mm9ZQXVsTkczUFAuY0VmUg$xqjmd8LKdTrqe5TSJIyAmUur19ykvzZMtoRn9kpY5gc');