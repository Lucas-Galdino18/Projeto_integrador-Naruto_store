<?php
// puxa o arquivo de conexao com o banco postgresql
require_once __DIR__ . '/../database/connect.php';

// define a foto automaticamente buscando palavras chave no nome
function obterImagemAutomatica($nome) {
    // deixa o nome em minusculo pra nao ter problema com letras maiusculas
    $nomeLower = mb_strtolower($nome, 'UTF-8');
    
    if (strpos($nomeLower, 'itachi') !== false) {
        return 'https://cdn.awsli.com.br/800x800/919/919645/produto/24800844830a27d26b3.jpg';
    } elseif (strpos($nomeLower, 'akatsuki') !== false || strpos($nomeLower, 'manto') !== false) {
        return 'https://down-br.img.susercontent.com/file/f715432b8680f8cb27c356f26d8b954b';
    } elseif (strpos($nomeLower, 'kakashi') !== false) {
        return 'https://m.media-amazon.com/images/I/61pHnKKFrNL.jpg';
    } elseif (strpos($nomeLower, 'bandana') !== false) {
        return 'https://down-br.img.susercontent.com/file/f562a34ade1b99957a50bc12f5f5ef43';
    }
    
    // imagem padrao caso seja outro produto
    return 'https://down-br.img.susercontent.com/file/f562a34ade1b99957a50bc12f5f5ef43';
}

// insere um novo produto no banco de dados
function cadastrar($conexao, $nome, $categoria, $preco, $disponivel, $codigo, $imagemCustom = ''){
    try {
        // garante que a coluna imagem existe no postgres
        $conexao->exec("ALTER TABLE produtos ADD COLUMN IF NOT EXISTS imagem TEXT;");

        // Se digitou uma URL personalizada, usa ela. Senao, usa a foto automatica
        if (!empty($imagemCustom)) {
            $imagem = $imagemCustom;
        } else {
            $imagem = obterImagemAutomatica($nome);
        }

        $sql = "INSERT INTO produtos (nome, categoria, preco, disponivel, codigo, imagem) VALUES
        (:nome, :categoria, :preco, :disponivel, :codigo, :imagem)";
        
        // usa prepared statement para seguranca contra sql injection
        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(":nome", $nome);
        $stmt->bindValue(":categoria", $categoria);
        $stmt->bindValue(":preco", $preco);
        $stmt->bindValue(":disponivel", $disponivel);
        $stmt->bindValue(":codigo", $codigo);
        $stmt->bindValue(":imagem", $imagem);

        $stmt->execute();
    } catch (PDOException $e) {
        echo "Erro ao cadastrar: " . $e->getMessage();
        exit;
    }
}

// altera os dados de um produto ja existente
function atualizar($conexao, $id, $nome, $categoria, $preco, $disponivel, $codigo, $imagemCustom = ''){
    try {
        if (!empty($imagemCustom)) {
            $imagem = $imagemCustom;
        } else {
            $imagem = obterImagemAutomatica($nome);
        }

        $sql = "UPDATE produtos SET 
                nome = :nome, 
                categoria = :categoria, 
                preco = :preco, 
                disponivel = :disponivel, 
                codigo = :codigo, 
                imagem = :imagem 
                WHERE id = :id";
        
        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmt->bindValue(":nome", $nome);
        $stmt->bindValue(":categoria", $categoria);
        $stmt->bindValue(":preco", $preco);
        $stmt->bindValue(":disponivel", $disponivel);
        $stmt->bindValue(":codigo", $codigo);
        $stmt->bindValue(":imagem", $imagem);

        $stmt->execute();
    } catch (PDOException $e) {
        echo "Erro ao atualizar: " . $e->getMessage();
    }
}

// apaga o produto do banco usando o id
function apagar($conexao, $id){
    $sql = "DELETE FROM produtos WHERE id = :id";
    try {
        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmt->execute();
    } catch (PDOException $e) {
        echo "Erro ao apagar: " . $e->getMessage();
    }
}

// busca todos os produtos cadastrados para o relatorio
function listarProdutos($conexao) {
    try {
        $stmt = $conexao->query("SELECT * FROM produtos ORDER BY id ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}

// busca apenas um produto especifico pelo id
function buscarProdutoPorId($conexao, $id) {
    try {
        $stmt = $conexao->prepare("SELECT * FROM produtos WHERE id = :id");
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return null;
    }
}
?>