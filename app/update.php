<?php
require_once __DIR__ . '/../login/verifica_user.php';
require_once __DIR__ . '/../database/connect.php';

// Bloqueia se não for admin
if (($_SESSION['usuario_tipo'] ?? '') !== 'admin') {
    header('Location: /projeto_integrador/app/select.php?erro=sem_permissao');
    exit;
}

$id = $_GET['id'] ?? null;
if (!$id) { header('Location: /projeto_integrador/app/select.php'); exit; }

// Busca o produto
$stmt = $conexao->prepare("SELECT * FROM produtos WHERE id = :id");
$stmt->execute([':id' => $id]);
$produto = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$produto) { header('Location: /projeto_integrador/app/select.php'); exit; }

$mensagem = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome       = trim($_POST['nome'] ?? '');
    $categoria  = trim($_POST['categoria'] ?? '');
    $preco      = str_replace(',', '.', trim($_POST['preco'] ?? '0'));
    $quantidade = (int)($_POST['quantidade'] ?? 0);
    $imagem     = trim($_POST['imagem'] ?? '');

    if ($nome && $preco) {
        $sql = "UPDATE produtos SET nome = :n, categoria = :c, preco = :p, quantidade = :q, imagem = :img WHERE id = :id";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([':n' => $nome, ':c' => $categoria, ':p' => $preco, ':q' => $quantidade, ':img' => $imagem, ':id' => $id]);
        header('Location: /projeto_integrador/app/select.php?sucesso=editado');
        exit;
    } else {
        $mensagem = 'Preencha os campos obrigatórios!';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Produto - Naruto Store</title>
    <link rel="stylesheet" href="/projeto_integrador/css/style.css">
</head>
<body class="page-home">
    <?php include __DIR__ . '/../includes/header.php'; ?>

    <main class="hero-section" style="padding: 20px;">
        <div class="card" style="max-width: 450px; margin: 0 auto;">
            <h1>Editar Produto #<?= $produto['id'] ?></h1>

            <?php if ($mensagem): ?>
                <p style="color: #ef4444; text-align: center; font-size: 0.9rem;"><?= $mensagem ?></p>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label>Nome do Produto *</label>
                    <input type="text" name="nome" value="<?= htmlspecialchars($produto['nome']) ?>" required>
                </div>

                <div class="form-group">
                    <label>Categoria</label>
                    <input type="text" name="categoria" value="<?= htmlspecialchars($produto['categoria'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label>Preço (R$) *</label>
                    <input type="number" step="0.01" name="preco" value="<?= $produto['preco'] ?>" required>
                </div>

                <div class="form-group">
                    <label>Quantidade</label>
                    <input type="number" name="quantidade" value="<?= $produto['quantidade'] ?>">
                </div>

                <div class="form-group">
                    <label>URL da Imagem</label>
                    <input type="text" name="imagem" value="<?= htmlspecialchars($produto['imagem'] ?? '') ?>">
                </div>

                <br>
                <button type="submit" class="btn-laranja" style="width: 100%;">SALVAR ALTERAÇÕES</button>
                <p style="text-align: center; margin-top: 15px;">
                    <a href="/projeto_integrador/app/select.php" style="color: #9ca3af; text-decoration: none;">Cancelar</a>
                </p>
            </form>
        </div>
    </main>

    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>