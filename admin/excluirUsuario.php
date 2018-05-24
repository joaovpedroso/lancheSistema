<?php

include "menu.php";

$id = "";

if (isset($_GET['id'])) {
    $id = trim($_GET['id']);
}

$sqlUsuario = "SELECT * FROM usuario WHERE id = ? LIMIT 1";
$consultaUsuario = $pdo->prepare($sql);
$consultaUsuario->bindParam(1, $id);
$consultaUsuario->execute();
if (!empty($dados = $consultaUsuario->fetch(PDO::FETCH_OBJ)->id)) {


    $sql = "SELECT * FROM pedido WHERE id_usuario = ? LIMIT 1";
    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(1, $id);
    $consulta->execute();
    $dados = $consulta->fetch(PDO::FETCH_OBJ);

    if (empty($dados->id_usuario)) {
        $sql = "UPDATE usuario SET ativo = 0 WHERE id = ? LIMIT 1";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(1, $id);

        if ($consulta->execute()) {
            echo "<script>location.href='listarUsuario.php';</script>";
        } else {
            echo "<script>alert('Erro ao excluir Usuario!');history.back();</script>";
        }
    } else {
        echo "<script>alert('Erro ao excluir Usuario. Existem pedidos efetuados por ele');history.back();</script>";
    }
} else {

    echo "<script>alert('Não é possivel excluir o Usuário. Cadastro não encontrado');history.back();</script>";
    exit;
}