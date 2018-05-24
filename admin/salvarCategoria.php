<?php

include "menu.php";

if ($_POST) {

    $id = trim($_POST['id']);
    $categoria = trim($_POST['categoria']);
    $ativo = trim($_POST['ativo']);

    if (empty($categoria)) {
        echo "<script>alert('Informe uma categoria'); history.back();</script>";
        exit;
    }


//		echo "<br>$id<br>$categoria<br>$descricao";

    if (empty($id)) {

        $sql = "INSERT INTO categoria (id, categoria, ativo ) VALUES (NULL, ?, ?) ";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(1, $categoria);
        $consulta->bindParam(2, $ativo);
    } else {

        $sql = "UPDATE categoria SET categoria = ?, ativo = ? WHERE id = ? LIMIT 1";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(1, $categoria);
        $consulta->bindParam(2, $ativo);
        $consulta->bindParam(3, $id);
    }

    if ($consulta->execute()) {
        echo "<script>alert('Categoria Salva com Sucesso !'); location.href='listarCategoria.php'</script>";
    } else {
        echo "<script>alert('Erro ao Salvar !'); history.back();</script>";
    }
}
?>