<?php
session_start();
require_once __DIR__ . '/../database/connect.php';

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome    = trim($_POST['nome'] ?? '');
    $usuario = strtolower(trim($_POST['email'] ?? $_POST['usuario'] ?? ''));
    $senha   = trim($_POST['senha'] ?? '');

    if (!empty($nome) && !empty($usuario) && !empty($senha)) {
        try {
            // 1. Verifica com COUNT(*) se o e-mail já existe na base de dados
            $stmtCheck = $conexao->prepare("SELECT COUNT(*) FROM usuarios WHERE LOWER(usuario) = :usuario");
            $stmtCheck->bindValue(':usuario', $usuario);
            $stmtCheck->execute();
            $total = (int) $stmtCheck->fetchColumn();

            if ($total > 0) {
                $mensagem = 'Este e-mail já está em uso. Tente outro!';
            } else {
                // 2. Insere o novo utilizador com perfil comum (tipo = 'usuario')
                $stmtInsert = $conexao->prepare("INSERT INTO usuarios (nome, usuario, senha, tipo) VALUES (:nome, :usuario, :senha, 'usuario')");
                $stmtInsert->bindValue(':nome', $nome);
                $stmtInsert->bindValue(':usuario', $usuario);
                $stmtInsert->bindValue(':senha', $senha);

                if ($stmtInsert->execute()) {
                    // Redireciona para o login após cadastrar com sucesso
                    header('Location: /projeto_integrador/login/login.php?cadastrado=1');
                    exit;
                }
            }
        } catch (PDOException $e) {
            $mensagem = 'Erro no banco de dados: ' . $e->getMessage();
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
    <title>Cadastrar - Naruto Store</title>
    <link rel="stylesheet" href="/projeto_integrador/css/style.css">
</head>
<body class="page-home">
    <main class="hero-section">
        <div class="card" style="max-width: 400px; margin: 0 auto;">
            <h1>Criar Conta Shinobi</h1>
            <p class="subtitle">Registe-se para aceder ao sistema</p>

            <?php if (!empty($mensagem)): ?>
                <div style="color: #ef4444; background: rgba(239, 68, 68, 0.1); padding: 12px; border-radius: 6px; margin-bottom: 20px; font-size: 0.9rem; text-align: center; border: 1px solid rgba(239, 68, 68, 0.3);">
                    <?= htmlspecialchars($mensagem) ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="/projeto_integrador/login/cadastrar.php">
                <div class="form-group" style="margin-bottom: 15px;">
                    <label>Nome Completo</label>
                    <input type="text" name="nome" placeholder="Ex: Sasuke Uchiha" required style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #374151; background: #1f2937; color: #fff;">
                </div>

                <div class="form-group" style="margin-bottom: 15px;">
                    <label>E-mail Shinobi</label>
                    <input type="email" name="email" placeholder="kakashi@gmail.com" required style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #374151; background: #1f2937; color: #fff;">
                </div>

                <div class="form-group" style="margin-bottom: 20px;">
                    <label>Senha</label>
                    <input type="password" name="senha" placeholder="••••••••" required style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #374151; background: #1f2937; color: #fff;">
                </div>

                <button type="submit" class="btn-laranja" style="width: 100%; padding: 12px; font-weight: bold; cursor: pointer;">CADASTRAR</button>
            </form>

            <p style="text-align: center; margin-top: 20px; color: #9ca3af; font-size: 0.9rem;">
                Já tem uma conta? 
                <a href="/projeto_integrador/login/login.php" style="color: #ff6600; font-weight: bold; text-decoration: none;">Faça Login</a>
            </p>
        </div>
    </main>
</body>
</html>