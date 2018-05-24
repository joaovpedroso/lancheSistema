<?php

include "menu.php";

if ($_POST) {
    $id = trim($_POST['id']);
    $pagamento = trim($_POST['pagamento']);

    if (empty($pagamento)) {
        echo "<script>alert('Preencha a Forma de Pagamento'); history.back();</script>";
        exit;
    }

    if (empty($id)) {
        $sql = "SELECT * FROM pagamento";
        $consulta = $pdo->prepare($sql);
        $consulta->execute();

        while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
            if ($pagamento == $dados->pagamento) {
                echo "<script>alert('Metodo de Pagamento Já Cadastrado'); history.back();</script>";
                exit;
            }
        }
        $sql = "INSERT INTO pagamento ( id, pagamento ) VALUES (NULL, ?)";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(1, $pagamento);
    } else {
        $sql = "UPDATE pagamento SET pagamento = ? WHERE id = ? LIMIT 1";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(1, $pagamento);
        $consulta->bindParam(2, $id);
    }

    if ($consulta->execute()) {
        echo "<script>alert('Pagamento Salvo Com Sucesso'); location.href='listarPagamento.php';</script>";
    } else {
        echo "<script>alert('Erro Ao Cadastrar Pagamento'); history.back();</script>";
    }
}
?>