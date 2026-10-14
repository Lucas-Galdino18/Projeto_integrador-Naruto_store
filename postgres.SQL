-- 1. Limpa tabelas antigas para evitar erros
DROP TABLE IF EXISTS usuarios CASCADE;
DROP TABLE IF EXISTS produtos CASCADE;

-- 2. Tabela de utilizadores
CREATE TABLE usuarios (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    usuario VARCHAR(50) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    tipo VARCHAR(20) DEFAULT 'usuario'
);

-- 3. Tabela de produtos (vazia, pronta para cadastrar pelo site)
CREATE TABLE produtos (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    categoria VARCHAR(100),
    preco NUMERIC(10, 2) NOT NULL,
    quantidade INT DEFAULT 0,
    imagem TEXT
);

-- 4. Administrador para fazer login
INSERT INTO usuarios (nome, usuario, senha, tipo)
VALUES ('Naruto Uzumaki', 'naruto@viladafolha.com', '123456', 'admin');;
