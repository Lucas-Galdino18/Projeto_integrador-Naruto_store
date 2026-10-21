# Naruto Store - Gestão de Estoque

Projeto acadômico em PHP e PostgreSQL para controle de estoque de uma loja temática do universo de Naruto. Feito para praticar rotinas de CRUD, controle de acesso com sessão e modelagem de banco de dados relacional.

---

## Link de Acesso ao Sistema
- **URL da Aplicação:** `http://192.168.10.57/projeto_integrador`

---

## Protótipo no Figma
- Link do Figma: https://www.figma.com/design/lqtZDe0TALyaODf1Alrbr0/Prototipagem-Trabalho-Integrado?node-id=0-1&p=f&t=1iQ0mReWa8enld6O-0

---

## Tecnologias Usadas
- PHP 8 (puro, sem framework)
- PostgreSQL (conexão via PDO)
- HTML5 / CSS3 (layout Dark Mode)
- Apache / Linux (MobaXterm)

---

## O que o sistema faz
- **Login e Usuários:** Tela de login, cadastro de contas, controle de sessão (`$_SESSION`) e logout.
- **Segurança:** Senhas salvas com hash (`password_hash`), trava de acesso nas páginas internas (`verifica_user.php`) e consultas com Prepared Statements contra SQL Injection.
- **CRUD de Produtos:**
  - `create.php` - Cadastra novos produtos (nome, categoria, preço, quantidade e imagem).
  - `select.php` - Tabela de listagem geral do estoque.
  - `select_w.php` - Busca rápida de um item por ID.
  - `update.php` - Edita os dados do produto.
  - `delete.php` - Exclui produtos (exclusivo para perfil admin).

---

## Script do Banco de Dados (`postgres.SQL`)

```sql
-- Criação do banco de dados (executar no terminal do PostgreSQL)
-- CREATE DATABASE escola;

-- Conectar ao banco escola:
-- \c escola;

-- 1. Tabela de Usuários
CREATE TABLE IF NOT EXISTS usuarios (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    usuario VARCHAR(50) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    tipo VARCHAR(20) DEFAULT 'usuario'
);

-- 2. Tabela de Produtos
CREATE TABLE IF NOT EXISTS produtos (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    categoria VARCHAR(100),
    preco NUMERIC(10, 2) NOT NULL,
    quantidade INTEGER DEFAULT 0,
    imagem TEXT
);

-- Inserção de Usuário Administrador Padrão
-- E-mail: naruto@viladafolha.com / Senha: 123456 (hash gerado por password_hash)
INSERT INTO usuarios (nome, usuario, senha, tipo)
VALUES (
    'Naruto Uzumaki',
    'naruto@viladafolha.com',
    '$2y$10$e0MYzXyjpJS7Pd0RVvHwHe8fS.g4u8L5aE5yq0IeQd21yvB5k3mK6',
    'admin'
) ON CONFLICT (usuario) DO NOTHING;

-- Inserção de Produtos Exemplo
INSERT INTO produtos (nome, categoria, preco, quantidade, imagem) VALUES
('Kunai Minato Namikaze', 'Armas', 45.90, 10, '[https://m.media-amazon.com/images/I/61xtL.jpg](https://m.media-amazon.com/images/I/61xtL.jpg)'),
('Manto da Akatsuki', 'Acessórios', 30.00, 2, '[https://soi-bucket.s3.amazonaws.com/manto.jpg](https://soi-bucket.s3.amazonaws.com/manto.jpg)'),
('Crocs Sasuke Uchiha', 'Colecionável', 199.90, 0, '[https://droper-media.s3.amazonaws.com/sasuke.jpg](https://droper-media.s3.amazonaws.com/sasuke.jpg)');
