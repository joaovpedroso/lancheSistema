<?php

include "menu.php";

$id = "";

if (isset($_GET['id'])) {
    $id = trim($_GET['id']);
}

$sqlProduto = "SELECT * FROM produto WHERE id = ? LIMIT 1";
$consultaProduto = $pdo->prepare($sqlProduto);
$consultaProduto->bindParam(1, $id);
$consultaProduto->execute();
if (!empty($dados = $consultaProduto->fetch(PDO::FETCH_OBJ)->id)) {

    $sql = "SELECT * FROM produto_pedido WHERE id_produto = ? LIMIT 1";
    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(1, $id);
    $consulta->execute();
    $dados = $consulta->fetch(PDO::FETCH_OBJ);

    if (empty($dados->id_usuario)) {
        $sql = "UPDATE produto SET ativo = 0 WHERE id = ? LIMIT 1";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(1, $id);

        if ($consulta->execute()) {
            echo "<script>location.href='listarProduto.php';</script>";
        } else {
            echo "<script>alert('Erro ao excluir Produto!');history.back();</script>";
        }
    } else {
        echo "<script>alert('Erro ao excluir Produto. Existem Pedidos Realizados Com Ele');history.back();</script>";
    }
} else {
    echo "<script>alert('Não é possivel excluir o Produto. Cadastro não encontrado');history.back();</script>";
    exit;
}