<?php
// 1. Conecta-se а sessгo ativa do navegador/servidor
session_start();

// 2. Limpa todas as variбveis da sessгo (usuario_id, usuario_nome, usuario_tipo)
session_unset();

// 3. Destrуi permanentemente o registro da sessгo no servidor
session_destroy();

// 4. Redireciona o usuбrio com a rota absoluta correta para a pбgina de login
header('Location: /projeto_integrador/login/login.php');

// 5. Encerra a execuзгo do PHP para garantir o redirecionamento
exit;
?>