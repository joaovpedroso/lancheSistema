<?php

include "menu.php";
verificaPermissao();

$id = "";

if (isset($_GET['id'])) {
    $id = trim($_GET['id']);
}

//VErificar se existe categoria cadastrada com o ID
$sqlCat = "SELECT * FROM categoria WHERE id = ? LIMIT 1";
$consultaCat = $pdo->prepare($sqlCat);
$consultaCat->bindParam(1, $id);
$consultaCat->execute();
if (!empty($dados = $consultaCat->fetch(PDO::FETCH_OBJ)->id)) {
    $id = $dados->id;


    //Verificar se há algum Produto Cadastrado na Categoria
    $sql = "SELECT * FROM produto WHERE id_categoria = ? LIMIT 1 ";
    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(1, $id);
    $consulta->execute();

    $dados = $consulta->fetch(PDO::FETCH_OBJ);

    //Se nao retornar nem um registro de produto na categoria Efetuar Exclusão
    if (empty($dados->id_categoria)) {
        $sql = "UPDATE categoria SET ativo = 0 WHERE id = ? LIMIT 1";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(1, $id);

        if ($consulta->execute()) {
            echo "<script>location.href='listarCategoria.php';</script>";
        } else {
            echo "<script>alert('Erro ao excluir Categoria!');history.back();</script>";
        }
    } else {
        echo "<script>alert('Não é possivel excluir Categoria. Existem produtos cadastrados');history.back();</script>";
    }
} else {
    echo "<script>alert('Não é possivel excluir Categoria. Categoria não encontrada');history.back();</script>";
    exit;
}