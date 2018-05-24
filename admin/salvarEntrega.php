<?php

include "menu.php";

if ($_POST) {
    $id = trim($_POST['id']);
    $entrega = trim($_POST['entrega']);

    if (empty($entrega)) {
        echo "<script>alert('Preencha o campo entrega'); history.back();</script>";
        exit;
    }

    if (empty($id)) {
        $sql = "INSERT INTO forma_entrega (id, entrega) VALUES (NULL, ?)";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(1, $entrega);
    } else {
        $sql = "UPDATE forma_entrega SET entrega = ? WHERE id = ? LIMIT 1";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(1, $entrega);
        $consulta->bindParam(2, $id);
    }

    if ($consulta->execute()) {
        echo "<script>alert('Cadastro Salvo Com Sucesso'); location.href='listarEntrega.php';</script>";
    } else {
        echo "<script>alert('Erro ao salvar'); history.back();</script>";
    }
}
?>