<?php

include "menu.php";

$id = "";

if (isset($_GET['id'])) {
    $id = trim($_GET['id']);
    $ativo = 0;
}

$sqlUser = "SELECT * FROM usuario WHERE id = ? LIMIT 1";
$consultaUser = $pdo->prepare($sqlUser);
$consultaUser->bindParam(1, $id);
$consultaUser->execute();
if (!empty($dados = $consultaUser->fetch(PDO::FETCH_OBJ)->id)) {

    $sql = "SELECT * FROM pedido WHERE id_usuario = ? LIMIT 1";
    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(1, $id);
    $consulta->execute();
    $dados = $consulta->fetch(PDO::FETCH_OBJ);

    if (empty($dados->id_usuario)) {
        $sql = "update usuario set ativo = ? WHERE id = ? LIMIT 1";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(1, $ativo);
        $consulta->bindParam(2, $id);
    } else {
        $sql = "update usuario set ativo = ? WHERE id = ? LIMIT 1";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(1, $ativo);
        $consulta->bindParam(2, $id);
        echo "<script>alert('Erro ao excluir Cliente. Existem Pedidos Efetuados Por Ele');history.back();</script>";
    }

    if ($consulta->execute()) {
        echo "<script>location.href='listarCliente.php';</script>";
    } else {
        echo "<script>alert('Erro ao excluir Cliente!');history.back();</script>";
    }
} else {

    echo "<script>alert('Não é possivel excluir o Cliente. Cadastro não encontrado');history.back();</script>";
    exit;
}