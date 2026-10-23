# Naruto Store - Gestão de Estoque

Projeto acadêmico em PHP e PostgreSQL para controle de estoque de uma loja temática do universo de Naruto. Feito para praticar rotinas de CRUD, controle de acesso com sessão e modelagem de banco de dados relacional.

---

## 🚀 Link de Acesso e Credenciais
* **URL da Aplicação (Rede Local):** `http://192.168.10.57/projeto_integrador`
* **Login do Administrador:** `naruto@viladafolha.com`
* **Senha do Administrador:** `123456`

## 🎨 Protótipo no Figma
* **Link do Figma:** [Protótipo no Figma](https://www.figma.com/design/lqtZDe0TALyaODf1Alrbr0/Prototipagem-Trabalho-Integrado?node-id=0-1&p=f&t=1iQ0mReWa8enld6O-0)

## 🛠️ Tecnologias Utilizadas
* **PHP 8** (puro, sem frameworks)
* **PostgreSQL** (conectado via PDO)
* **HTML5 / CSS3** (layout em Dark Mode)
* **Apache / Linux** (MobaXterm)

---

## ⚡ O que o Sistema Faz
* **Login e Usuários:** Tela de login, cadastro de contas, controle de sessão (`$_SESSION`) e logout (`login/`).
* **Segurança:** Trava de acesso nas páginas internas (`verifica_user.php`) e consultas tratadas com Prepared Statements contra SQL Injection.
* **Inicialização e Setup:** Script automatizado (`setup.php`) para preparação inicial do ambiente.
* **CRUD de Produtos:**
  * `app/select.php`: Listagem geral do estoque.
  * `app/update.php`: Edição dos dados do produto.
  * `app/delete.php`: Exclusão de produtos (exclusivo para perfil `admin`).

---

## 🖥️ Implantação e Execução (Servidor Linux / Deploy Local)

O sistema roda sob o servidor web Apache e banco de dados PostgreSQL.

### 1. Clonar e posicionar o projeto
No diretório padrão de hospedagem do Apache (`/var/www/html/`):

```bash
cd /var/www/html/
git clone [https://github.com/Lucas-Galdino18/projeto_integrador.git](https://github.com/Lucas-Galdino18/projeto_integrador.git)
cd projeto_integrador
