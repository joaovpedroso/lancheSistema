<?php

include "menu.php";

$id = "";

if (isset($_GET['id'])) {
    $id = trim($_GET['id']);
}

$sqlEntrega = "SELECT * FROM entrega WHERE id = ? LIMIT 1";
$consultaEntrega = $pdo->prepare($sqlEntrega);
$consultaEntrega->bindParam(1, $id);
$consultaEntrega->execute();
if (!empty($dados = $consultaEntrega->fetch(PDO::FETCH_OBJ)->id)) {



    $sql = "SELECT * FROM pedido WHERE id_entrega = ? LIMIT 1";
    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(1, $id);
    $consulta->execute();
    $dados = $consulta->fetch(PDO::FETCH_OBJ);

    if (empty($dados->id_usuario)) {
        $sql = "DELETE FROM forma_entrega WHERE id = ? LIMIT 1";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(1, $id);

        if ($consulta->execute()) {
            echo "<script>location.href='listarEntrega.php';</script>";
        } else {
            echo "<script>alert('Erro ao excluir Forma de Entrega!');history.back();</script>";
        }
    } else {
        echo "<script>alert('Erro ao excluir Forma de Entrega. Existem Pedidos Cadastrados Com Ela');history.back();</script>";
    }
} else {
    echo "<script>alert('Não é possivel excluir a Entrega. Cadastro não encontrado');history.back();</script>";
    exit;
}
