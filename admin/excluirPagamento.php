<?php

include "menu.php";

$id = "";

if (isset($_GET['id'])) {
    $id = trim($_GET['id']);
}

$sqlPagamento = "SELECT * FROM pagamento WHERE id = ? LIMIT 1";
$consultaPagamento = $pdo->prepare($sqlPagamento);
$consultaPagamento->bindParam(1, $id);
$consultaPagamento->execute();
if (!empty($dados = $consultaPagamento->fetch(PDO::FETCH_OBJ)->id)) {



    $sql = "SELECT * FROM pedido WHERE id_pagamento = ? LIMIT 1";
    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(1, $id);
    $consulta->execute();
    $dados = $consulta->fetch(PDO::FETCH_OBJ);

    if (empty($dados->id_usuario)) {
        $sql = "DELETE FROM pagamento WHERE id = ? LIMIT 1";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(1, $id);

        if ($consulta->execute()) {
            echo "<script>location.href='listarPagamento.php';</script>";
        } else {
            echo "<script>alert('Erro ao excluir Forma de Pagamento!');history.back();</script>";
        }
    } else {
        echo "<script>alert('Erro ao excluir Forma de Pagamento. Existem Pedidos Cadastrados Com Ele');history.back();</script>";
    }
} else {
    echo "<script>alert('Não é possivel excluir o Pagamento. Cadastro não encontrado');history.back();</script>";
    exit;
}