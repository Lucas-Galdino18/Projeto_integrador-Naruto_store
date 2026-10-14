<?php
// 1. Verifica se o utilizador está autenticado no sistema
require_once __DIR__ . '/../login/verifica_user.php';
require_once __DIR__ . '/../database/connect.php';

// 2. Trava de segurança: Garante que apenas o perfil 'admin' acede ao formulário
if (($_SESSION['usuario_tipo'] ?? '') !== 'admin') {
    header('Location: /projeto_integrador/app/select.php?erro=sem_permissao');
    exit;
}

$mensagem = '';
$erro = false;

// 3. Processa o envio do formulário via método POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome       = trim($_POST['nome'] ?? '');
    $categoria  = trim($_POST['categoria'] ?? '');
    $preco      = trim($_POST['preco'] ?? '');
    $quantidade = trim($_POST['quantidade'] ?? '');
    $imagem     = trim($_POST['imagem'] ?? '');

    // Validação básica dos campos obrigatórios
    if (!empty($nome) && !empty($preco)) {
        try {
            // Insere o produto na tabela do PostgreSQL
            $sql = "INSERT INTO produtos (nome, categoria, preco, quantidade, imagem) 
                    VALUES (:nome, :categoria, :preco, :quantidade, :imagem)";
            $stmt = $conexao->prepare($sql);
            $stmt->bindValue(':nome', $nome);
            $stmt->bindValue(':categoria', $categoria);
            $stmt->bindValue(':preco', str_replace(',', '.', $preco));
            $stmt->bindValue(':quantidade', (int)$quantidade);
            $stmt->bindValue(':imagem', $imagem);

            if ($stmt->execute()) {
                // Redireciona de volta para o relatório com mensagem de sucesso
                header('Location: /projeto_integrador/app/select.php?sucesso=1');
                exit;
            }
        } catch (PDOException $e) {
            $mensagem = 'Erro ao salvar no banco de dados: ' . $e->getMessage();
            $erro = true;
        }
    } else {
        $mensagem = 'Preencha os campos obrigatórios (Nome e Preço)!';
        $erro = true;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Novo Produto - Naruto Store</title>
    <link rel="stylesheet" href="/projeto_integrador/css/style.css">
</head>
<body class="page-home">
    <?php include __DIR__ . '/../includes/header.php'; ?>

    <main class="hero-section" style="padding: 20px;">
        <div class="card" style="max-width: 600px; margin: 0 auto;">
            <h1>Cadastrar Novo Produto</h1>
            <p class="subtitle">Adicione um novo equipamento ao estoque</p>

            <?php if (!empty($mensagem)): ?>
                <div style="background: <?= $erro ? 'rgba(239, 68, 68, 0.1)' : 'rgba(16, 185, 129, 0.1)' ?>; color: <?= $erro ? '#ef4444' : '#10b981' ?>; padding: 12px; border-radius: 6px; margin-bottom: 20px; text-align: center; border: 1px solid <?= $erro ? 'rgba(239, 68, 68, 0.3)' : 'rgba(16, 185, 129, 0.3)' ?>;">
                    <?= htmlspecialchars($mensagem) ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="/projeto_integrador/app/create.php">
                <div class="form-group" style="margin-bottom: 15px;">
                    <label>Nome do Produto *</label>
                    <input type="text" name="nome" placeholder="Ex: Kunai Tática" required style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #374151; background: #1f2937; color: #fff;">
                </div>

                <div class="form-group" style="margin-bottom: 15px;">
                    <label>Categoria</label>
                    <input type="text" name="categoria" placeholder="Ex: Armas, Vestuário, Acessórios" style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #374151; background: #1f2937; color: #fff;">
                </div>

                <div style="display: flex; gap: 15px; margin-bottom: 15px;">
                    <div class="form-group" style="flex: 1;">
                        <label>Preço (R$) *</label>
                        <input type="number" step="0.01" name="preco" placeholder="15.00" required style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #374151; background: #1f2937; color: #fff;">
                    </div>

                    <div class="form-group" style="flex: 1;">
                        <label>Quantidade em Estoque</label>
                        <input type="number" name="quantidade" value="0" style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #374151; background: #1f2937; color: #fff;">
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 20px;">
                    <label>URL da Imagem</label>
                    <input type="text" name="imagem" placeholder="https://exemplo.com/imagem.jpg" style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #374151; background: #1f2937; color: #fff;">
                </div>

                <div style="display: flex; gap: 10px;">
                    <button type="submit" class="btn-laranja" style="flex: 1; padding: 12px; font-weight: bold; cursor: pointer;">SALVAR PRODUTO</button>
                    <a href="/projeto_integrador/app/select.php" style="padding: 12px 20px; background: #374151; color: #fff; text-decoration: none; border-radius: 6px; font-weight: bold; text-align: center;">Voltar</a>
                </div>
            </form>
        </div>
    </main>

    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>