<?php
// Inicia a sessão do PHP apenas se ainda não existir uma ativa no momento
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Recupera o nome do usuário salvo na sessão (ou define 'Visitante' caso não esteja logado)
$nome_usuario = $_SESSION['usuario_nome'] ?? 'Visitante';
?>
<!-- Estrutura do cabeçalho com estilos inline no tema Dark Mode + Ouro/Laranja -->
<header style="background-color: #111827; border-bottom: 2px solid #ff6600; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center;">
    
    <!-- Logo do projeto com link relativo absoluto para a página inicial -->
    <div style="font-size: 1.5rem; font-weight: bold;">
        <a href="/projeto_integrador/index.php" style="color: #ff6600; text-decoration: none;">NARUTO STORE</a>
    </div>

    <!-- Menu de navegação principal da aplicação -->
    <nav style="display: flex; gap: 20px;">
        <a href="/projeto_integrador/index.php" style="color: #9ca3af; text-decoration: none;">Início</a>
        <a href="/projeto_integrador/app/select.php" style="color: #9ca3af; text-decoration: none;">Relatório de Produtos</a>
    </nav>

    <!-- Área do usuário logado e botão de sair -->
    <div style="color: #f3f4f6;">
        <!-- Exibe o nome do usuário ativo (higienizado para evitar ataques XSS) -->
        <span><?= htmlspecialchars($nome_usuario) ?></span>
        
        <!-- Botão Sair apontando com a rota absoluta correta para o logout -->
        <a href="/projeto_integrador/login/logout.php" style="color: #ef4444; text-decoration: none; margin-left: 15px; font-weight: bold;">Sair</a>
    </div>

</header>