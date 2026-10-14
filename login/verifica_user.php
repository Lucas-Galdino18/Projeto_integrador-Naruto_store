<?php
/* inicia a sessao no navegador se ainda nao tiver iniciada */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* se nao existir o id do usuario na sessao, redireciona para o login */
if (!isset($_SESSION['usuario_id'])) {
    header('Location: /projeto_integrador/login/login.php');
    exit;
}