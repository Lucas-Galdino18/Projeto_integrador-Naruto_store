<?php
// Autenticação e conexão com o banco
require_once __DIR__ . '/../login/verifica_user.php';
require_once __DIR__ . '/../database/connect.php';

// Identifica se o usuário é administrador
$is_admin = (($_SESSION['usuario_tipo'] ?? '') === 'admin');

// Busca a lista de produtos cadastrados
try {
    $stmt = $conexao->query("SELECT * FROM produtos ORDER BY id ASC");
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $produtos = [];
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Produtos - Naruto Store</title>
    <link rel="stylesheet" href="/projeto_integrador/css/style.css">
</head>
<body class="page-home">
    <?php include __DIR__ . '/../includes/header.php'; ?>

    <main class="hero-section" style="padding: 20px;">
        <div class="card" style="max-width: 1000px; margin: 0 auto;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <div>
                    <h1>Catálogo de Produtos</h1>
                    <p class="subtitle">Lista de equipamentos cadastrados na loja</p>
                </div>
                
                <!-- Botão visível apenas para administradores -->
                <?php if ($is_admin): ?>
                    <a href="/projeto_integrador/app/create.php" class="btn-laranja" style="text-decoration: none; padding: 10px 20px; font-weight: bold;">+ NOVO PRODUTO</a>
                <?php endif; ?>
            </div>

            <table style="width: 100%; border-collapse: collapse; text-align: left; margin-top: 10px;">
                <thead>
                    <tr style="border-bottom: 2px solid #ff6600; color: #ff6600;">
                        <th style="padding: 10px;">ID</th>
                        <th style="padding: 10px;">FOTO</th>
                        <th style="padding: 10px;">NOME</th>
                        <th style="padding: 10px;">CATEGORIA</th>
                        <th style="padding: 10px;">PREÇO</th>
                        <th style="padding: 10px;">DISPONIBILIDADE</th>
                        
                        <!-- Coluna de ações visível apenas para admin -->
                        <?php if ($is_admin): ?>
                            <th style="padding: 10px; text-align: center;">AÇÕES</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($produtos)): ?>
                        <tr>
                            <td colspan="<?= $is_admin ? '7' : '6' ?>" style="text-align: center; padding: 30px; color: #9ca3af;">
                                Nenhum produto cadastrado até ao momento.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($produtos as $p): ?>
                            <tr style="border-bottom: 1px solid rgba(255,255,255,0.1);">
                                <td style="padding: 10px;"><?= $p['id'] ?></td>
                                
                                <td style="padding: 10px;">
                                    <?php if (!empty($p['imagem'])): ?>
                                        <img src="<?= htmlspecialchars($p['imagem']) ?>" alt="Produto" style="width: 45px; height: 45px; object-fit: cover; border-radius: 4px;">
                                    <?php else: ?>
                                        <span style="color: #6b7280;">Sem foto</span>
                                    <?php endif; ?>
                                </td>
                                
                                <td style="padding: 10px; font-weight: bold;"><?= htmlspecialchars($p['nome']) ?></td>
                                <td style="padding: 10px;"><?= htmlspecialchars($p['categoria'] ?? '-') ?></td>
                                <td style="padding: 10px; color: #10b981;">R$ <?= number_format($p['preco'], 2, ',', '.') ?></td>
                                
                                <!-- Verificação de disponibilidade pelo estoque -->
                                <td style="padding: 10px;">
                                    <?php if ((int)$p['quantidade'] > 0): ?>
                                        <span style="color: #10b981; font-weight: bold;">Disponível</span>
                                        <span style="color: #9ca3af; font-size: 0.85rem;">(<?= $p['quantidade'] ?> un.)</span>
                                    <?php else: ?>
                                        <span style="color: #ef4444; font-weight: bold;">Indisponível</span>
                                    <?php endif; ?>
                                </td>
                                
                                <!-- Links de edição e exclusão apenas para admin -->
                                <?php if ($is_admin): ?>
                                    <td style="padding: 10px; text-align: center;">
                                        <a href="/projeto_integrador/app/update.php?id=<?= $p['id'] ?>" style="color: #3b82f6; text-decoration: none; margin-right: 10px; font-weight: bold;">Editar</a>
                                        <a href="/projeto_integrador/app/delete.php?id=<?= $p['id'] ?>" onclick="return confirm('Deseja realmente apagar este produto?');" style="color: #ef4444; text-decoration: none; font-weight: bold;">Apagar</a>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>