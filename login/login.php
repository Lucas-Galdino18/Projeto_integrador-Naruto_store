<?php
// Inicia a sessão para gerenciamento de login
session_start();
require_once __DIR__ . '/../database/connect.php';

$mensagem = '';

// Processa o envio das credenciais via formulário POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario_input = trim($_POST['email'] ?? $_POST['usuario'] ?? '');
    $senha_input   = trim($_POST['senha'] ?? '');

    if (!empty($usuario_input) && !empty($senha_input)) {
        try {
            // Consulta o usuário na coluna 'usuario' do PostgreSQL
            $stmt = $conexao->prepare("SELECT * FROM usuarios WHERE usuario = :usuario LIMIT 1");
            $stmt->bindValue(':usuario', $usuario_input);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Validação das credenciais
            if ($user && $user['senha'] === $senha_input) {
                $_SESSION['usuario_id']   = $user['id'];
                $_SESSION['usuario_nome'] = $user['nome'];
                $_SESSION['usuario_tipo'] = $user['tipo'];

                // Redireciona para o painel de produtos
                header('Location: /projeto_integrador/app/select.php');
                exit;
            } else {
                $mensagem = 'Usuário ou senha inválidos!';
            }
        } catch (PDOException $e) {
            $mensagem = 'Erro ao consultar o banco de dados!';
        }
    } else {
        $mensagem = 'Preencha todos os campos!';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login - Naruto Store</title>
    <link rel="stylesheet" href="/projeto_integrador/css/style.css">
</head>
<body class="page-home">
    <main class="hero-section">
        <div class="card" style="max-width: 400px; margin: 0 auto;">
            <h1>Acesso ao Sistema</h1>
            <p class="subtitle">Identifique-se para gerenciar o estoque</p>

            <?php if (!empty($mensagem)): ?>
                <div style="color: #ef4444; background: rgba(239, 68, 68, 0.1); padding: 12px; border-radius: 6px; margin-bottom: 20px; font-size: 0.9rem; text-align: center; border: 1px solid rgba(239, 68, 68, 0.3);">
                    <?= htmlspecialchars($mensagem) ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="/projeto_integrador/login/login.php">
                <div class="form-group">
                    <label>E-mail Shinobi</label>
                    <input type="email" name="email" placeholder="seu@email.com" required>
                </div>

                <div class="form-group">
                    <label>Senha</label>
                    <input type="password" name="senha" placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn-laranja" style="width: 100%; margin-top: 10px;">ENTRAR</button>
            </form>

            <!-- Link de navegação para cadastro de novos usuários -->
            <p style="text-align: center; margin-top: 20px; color: #9ca3af; font-size: 0.9rem;">
                Ainda não é um Shinobi? 
                <a href="/projeto_integrador/login/cadastrar.php" style="color: #ff6600; font-weight: bold; text-decoration: none;">Cadastre-se</a>
            </p>
        </div>
    </main>
</body>
</html>