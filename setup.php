<?php
/* conexao com o banco */
require_once __DIR__ . '/database/connect.php';

try {
    /* cria a tabela de usuarios incluindo o campo perfil */
    $sqlUsuarios = "
        CREATE TABLE IF NOT EXISTS usuarios (
            id SERIAL PRIMARY KEY,
            nome VARCHAR(100) NOT NULL,
            email VARCHAR(100) UNIQUE NOT NULL,
            senha VARCHAR(255) NOT NULL,
            perfil VARCHAR(20) DEFAULT 'user'
        );
    ";
    $conexao->exec($sqlUsuarios);

    /* garante que a coluna perfil exista caso a tabela ja tenha sido criada anteriormente */
    $conexao->exec("ALTER TABLE usuarios ADD COLUMN IF NOT EXISTS perfil VARCHAR(20) DEFAULT 'user';");

    /* cria a tabela de produtos */
    $sqlProdutos = "
        CREATE TABLE IF NOT EXISTS produtos (
            id SERIAL PRIMARY KEY,
            codigo VARCHAR(20) UNIQUE NOT NULL,
            nome VARCHAR(100) NOT NULL,
            categoria VARCHAR(50) NOT NULL,
            preco NUMERIC(10, 2) NOT NULL,
            estoque INT NOT NULL DEFAULT 0,
            imagem TEXT
        );
    ";
    $conexao->exec($sqlProdutos);

    /* cadastra ou garante o usuario padrao de teste como ADMIN */
    $stmtCheck = $conexao->prepare("SELECT id FROM usuarios WHERE email = :email");
    $stmtCheck->bindValue(':email', 'naruto@viladafolha.com');
    $stmtCheck->execute();
    $adminExiste = $stmtCheck->fetch();

    if (!$adminExiste) {
        $senhaSegura = password_hash('123456', PASSWORD_DEFAULT); // gera o hash da senha 123456
        
        $stmt = $conexao->prepare("INSERT INTO usuarios (nome, email, senha, perfil) VALUES (:nome, :email, :senha, :perfil)");
        $stmt->bindValue(':nome', 'Naruto Uzumaki');
        $stmt->bindValue(':email', 'naruto@viladafolha.com');
        $stmt->bindValue(':senha', $senhaSegura);
        $stmt->bindValue(':perfil', 'admin');
        $stmt->execute();
    } else {
        /* garante que o perfil do Naruto seja 'admin' mesmo que ja estivesse cadastrado */
        $stmtUpdate = $conexao->prepare("UPDATE usuarios SET perfil = 'admin' WHERE email = :email");
        $stmtUpdate->bindValue(':email', 'naruto@viladafolha.com');
        $stmtUpdate->execute();
    }

    echo "<h2 style='color: #4ade80; font-family: sans-serif; padding: 20px;'>Tabelas criadas e configuradas com sucesso!</h2>";
    echo "<p style='padding: 0 20px; font-family: sans-serif;'>Usuário Admin para teste: <b>naruto@viladafolha.com</b> | Senha: <b>123456</b> (Perfil: <b>admin</b>)</p>";
    echo "<a href='/login/login.php' style='padding: 20px; font-family: sans-serif;'>Ir para a tela de login</a>";

} catch (PDOException $e) {
    echo "<h2 style='color: #ef4444;'>Erro:</h2> " . $e->getMessage();
}