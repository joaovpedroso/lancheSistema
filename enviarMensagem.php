<?php

include "config/conecta.php";
include "menu.html";

if ($_POST) {
    $nome = trim($_POST["nome"]);
    $email = trim($_POST["email"]);
    $telefone = trim($_POST["telefone"]);
    $mensagem = trim($_POST["mensagem"]);
    $data = explode("-", $data);
    $dia = $data[0];
    $mes = $data[1];
    $ano = $data[2];
    $data = $ano . "-" . $mes . "-" . $dia;

    if (empty($nome)) {
        echo "<script>alert('Informe seu nome !'); history.back();</script>";
    } else if (empty($email)) {
        echo "<script>alert('Informe seu E-Mail !'); history.back();</script>";
    } else if (empty($telefone)) {
        echo "<script>alert('Informe seu Telefne !'); history.back();</script>";
    } else if (empty($mensagem)) {
        echo "<script>alert('Preencha o campo mensagem !'); history.back();</script>";
    } else {
        $sql = "INSERT INTO mensagem (id, nome, email, telefone, mensagem, data ) VALUES( NULL, ?, ?, ?, ?, ? ) ";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(1, $nome);
        $consulta->bindParam(2, $email);
        $consulta->bindParam(3, $telefone);
        $consulta->bindParam(4, $mensagem);
        $consulta->bindParam(5, $data);

        if ($consulta->execute()) {
            echo "<script>alert('Mensagem enviada com sucesso !'); location.href='contato.php';</script>";
        } else {
            echo "<script>alert('Falha ao enviar a mensagem !'); history.back();</script>";
        }
    }
} else {
    echo "
        <div class='alert alert-danger text-center'>
                <p>Você não pode acessar esta página !</p>
        </div>";
    echo "<script>alert('Você não pode acessar esta página !'); history.back();</script>";
}
?>