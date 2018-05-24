<?php

if (isset($_POST["cpf"])) {
    include "config/conecta.php";

    $cpf = trim($_POST["cpf"]);

    $sql = "SELECT * FROM usuario WHERE cpf = ? LIMIT 1";
    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(1, $cpf);
    $consulta->execute();
    $dados = $consulta->fetch(PDO::FETCH_OBJ);

    if (empty($dados->id)) {
        //Retorna mensagem de OK se nao houver cpf cadastrado
        $msg = "ok";
    } else {
        $msg = "CPF Já Cadastrado !";
    }
}