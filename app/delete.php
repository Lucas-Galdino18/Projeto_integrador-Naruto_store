<?php
require_once __DIR__ . '/../login/verifica_user.php';
require_once __DIR__ . '/../database/connect.php';

// Bloqueia se o utilizador não for admin
if (($_SESSION['usuario_tipo'] ?? '') !== 'admin') {
    header('Location: /projeto_integrador/app/select.php?erro=sem_permissao');
    exit;
}

// Pega o ID da URL e garante que é um número inteiro
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

// Só executa o DELETE se o ID for um número válido
if ($id && $id > 0) {
    try {
        // O WHERE id = :id garante que apaga apenas o registo selecionado
        $stmt = $conexao->prepare("DELETE FROM produtos WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    } catch (PDOException $e) {
        // Regista o erro no log em caso de falha no banco
        error_log("Erro ao apagar produto: " . $e->getMessage());
    }
}

// Redireciona de volta para a tabela de produtos
header('Location: /projeto_integrador/app/select.php');
exit;
?>