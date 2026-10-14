# Naruto Store — Gestão de Estoque

Sistema web para controle de estoque de uma loja temática do universo de Naruto. Desenvolvido como projeto acadêmico para praticar rotinas de CRUD, controle de acesso e integração com banco de dados relacional.

---

## Figma

* **Link para o meu Figma:** https://www.figma.com/design/lqtZDe0TALyaODf1Alrbr0/Prototipagem-Trabalho-Integrado?node-id=0-1&p=f&t=1iQ0mReWa8enld6O-0

##  Tecnologias

* **Backend:** PHP 8 (puro, sem frameworks)
* **Banco de Dados:** PostgreSQL (integração via PDO)
* **Frontend:** HTML5 e CSS3 (layout responsivo com tema escuro)
* **Segurança:** Autenticação via `$_SESSION`, senhas criptografadas (`password_hash`) e consultas seguras com Prepared Statements contra SQL Injection.

---

##  O que o sistema faz

* **Autenticação:** Cadastro de usuários, login, controle de sessão e logout.
* **Proteção de Rotas:** Impede o acesso direto às páginas restritas caso o usuário não esteja logado.
* **Gestão do Estoque (CRUD):**
  * **Cadastrar (`create.php`):** Adiciona produtos com código, nome, categoria, preço e quantidade.
  * **Listar (`select.php`):** Tabela completa de produtos no estoque.
  * **Buscar (`select_w.php`):** Consulta rápida de um item específico por ID.
  * **Editar (`update.php`):** Atualização dos dados do produto.
  * **Excluir (`delete.php`):** Remoção de itens do banco de dados.

---

##  Estrutura de Arquivos

```text
projeto_integrador/
├── app/
│   ├── create.php       # Formulário e lógica de cadastro
│   ├── delete.php       # Exclusão de itens por ID
│   ├── select.php       # Listagem geral do estoque
│   ├── select_w.php     # Consulta por ID
│   └── update.php       # Formulário de edição
├── css/
│   └── style.css        # Estilos globais (Dark Theme)
├── database/
│   └── connect.php      # Configuração da conexão PDO
├── includes/
│   ├── footer.php       # Rodapé
│   ├── functions.php    # Lógica auxiliar e manipulação de imagens
│   └── header.php       # Menu de navegação
├── login/
│   ├── cadastrar.php    # Registro de novos usuários
│   ├── login.php        # Autenticação
│   ├── logout.php       # Encerramento de sessão
│   └── verifica_user.php# Trava de segurança das páginas internas
├── index.php            # Dashboard principal
├── postgres.SQL         # Script de criação das tabelas e massa de dados
└── README.md            # Documentação


## 3. Dicionário de Dados

### Tabela: `usuarios`
| Coluna | Tipo de Dado | Restrições | Descrição |
| :--- | :--- | :--- | :--- |
| `id` | `SERIAL` | `PRIMARY KEY` | Identificador único do usuário |
| `nome` | `VARCHAR(100)` | `NOT NULL` | Nome completo |
| `usuario` | `VARCHAR(50)` | `UNIQUE`, `NOT NULL` | E-mail / Login de acesso |
| `senha` | `VARCHAR(255)` | `NOT NULL` | Senha hash (`PASSWORD_DEFAULT`) |
| `tipo` | `VARCHAR(20)` | `DEFAULT 'usuario'` | Perfil de acesso (`admin` ou `usuario`) |

### Tabela: `produtos`
| Coluna | Tipo de Dado | Restrições | Descrição |
| :--- | :--- | :--- | :--- |
| `id` | `SERIAL` | `PRIMARY KEY` | Identificador único do produto |
| `nome` | `VARCHAR(150)` | `NOT NULL` | Nome do produto/equipamento |
| `categoria` | `VARCHAR(100)` | - | Categoria (Armas, Vestuário, etc.) |
| `preco` | `NUMERIC(10, 2)`| `NOT NULL` | Valor unitário em R$ |
| `quantidade` | `INTEGER` | `DEFAULT 0` | Quantidade disponível no estoque |
| `imagem` | `TEXT` | - | URL da imagem do produto |

---

## 4. Diagrama de Entidade-Relacionamento (D.E.R.)

```mermaid
erDiagram
    USUARIOS {
        int id PK
        string nome
        string usuario UK
        string senha
        string tipo
    }

    PRODUTOS {
        int id PK
        string nome
        string categoria
        decimal preco
        int quantidade
        string imagem
    }
