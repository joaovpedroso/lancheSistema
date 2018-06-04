<?php

include "menu.php";

if ($_POST) {

    //Cadastrar os dados dos campos e depois inserir o array da session
    $cliente = trim($_POST["cliente"]);
    if (empty($cliente)) {
        echo "<script>alert('Selecione uma forma de Entrega');history.back();</script>";
    }

    $id_entrega = trim($_POST["forma_entrega"]);

    if (empty($id_entrega)) {
        echo "<script>alert('Selecione uma forma de Entrega');history.back();</script>";
    }

    $id_status = 1;

    $id_pagamento = trim($_POST["forma_pagamento"]);

    if (empty($id_pagamento)) {
        echo "<script>alert('Selecione uma forma de Pagamento');history.back();</script>";
    }

    $hjData = data($data);

    $observacao = trim($_POST["observacao"]);
    if (empty($observacao)) {
        $observacao = "";
    }

    $troco = trim($_POST["troco"]);
    if (empty($troco)) {
        $troco = "";
    }


    $total = 0;
    foreach ($_SESSION["produtos"] as $prods => $quantidade) {

        //Selecionar os dados dos produtos
        $sql = "SELECT * FROM produto WHERE id = ? ";
        $resultado = $pdo->prepare($sql);
        $resultado->bindParam(1, $prods);
        $resultado->execute();

        while ($dados = $resultado->fetch(PDO::FETCH_OBJ)) {
            $preco = $dados->preco;
            $qtd = $quantidade;
            $subTotal = $preco * $qtd;
            $total += $subTotal;
        }
    }

    $valorTotal = $total;

    //	echo "DADOS --> <br>USUARIO $id_usuario <br>Entrega $id_entrega<br> Pagamento $id_pagamento<br> STATUS $id_status<br> OBSERVA $observacao<br> TROCO $troco<br>TOTAL $valorTotal<br>";
    //	exit;
    //Inserir dados na tabela Pedido
    $sql = "INSERT INTO pedido (id, id_usuario, id_entrega, id_status, id_pagamento, valorTotal, data, observacao, troco) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?)";
    $resultado = $pdo->prepare($sql);
    $resultado->bindParam(1, $cliente);
    $resultado->bindParam(2, $id_entrega);
    $resultado->bindParam(3, $id_status);
    $resultado->bindParam(4, $id_pagamento);
    $resultado->bindParam(5, $valorTotal);
    $resultado->bindParam(6, $hjData);
    $resultado->bindParam(7, $observacao);
    $resultado->bindParam(8, $troco);
    $resultado->execute();

    $idPedido = $pdo->lastInsertId();

    foreach ($_SESSION["produtos"] as $prods => $quantidade) {

        //Selecionar os dados dos produtos
        $sql = "SELECT * FROM produto WHERE id = ? ";
        $resultado = $pdo->prepare($sql);
        $resultado->bindParam(1, $prods);
        $resultado->execute();

        while ($dados = $resultado->fetch(PDO::FETCH_OBJ)) {
            $preco = $dados->preco;
            $qtd = $quantidade;

            $sql = "INSERT INTO produto_pedido (id, id_produto, id_pedido, quantidade, valor ) VALUES (NULL, ?, ?, ?, ?)";
            $resultado = $pdo->prepare($sql);
            $resultado->bindParam(1, $prods);
            $resultado->bindParam(2, $idPedido);
            $resultado->bindParam(3, $qtd);
            $resultado->bindParam(4, $preco);

            if ($resultado->execute()) {

                //Se inseriu tudo corretamente limpa os dados da sessão e mostra mensagem de sucesso
                echo "<script>sessionStorage.clear();</script>";
                echo "<script>alert('Pedido Realizado Com Sucesso'); location.href='listarPedido.php';</script>";

                //FInaliza a Sessão - LIMPA o CArrinho
                unset($_SESSION["produtos"]);
            } else {

                echo "<script>alert('ERRO: O pedido não pode ser finalizado. Entre em contato com nossa empresa'); location.href='home.php';</script>";
            }
        }
    }
}
?>