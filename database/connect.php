<?php
// Conexao com o banco postgresql
$host     = '192.168.10.57'; // IP do servidor PostgreSQL da imagem
$db       = 'escola';        // Nome da base de dados
$user     = 'postgres';      // Utilizador do Postgres 
$pass     = 'turma1';        // Palavra-passe do utilizador do Postgres
$port     = '5432';

try {
    $conexao = new PDO("pgsql:host=$host;port=$port;dbname=$db", $user, $pass);
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao ligar ao PostgreSQL: " . $e->getMessage());
}
?>