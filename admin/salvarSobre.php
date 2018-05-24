<?php

include "menu.php";

$id = trim($_POST["id"]);
$endereco = trim($_POST["endereco"]);
$email = trim($_POST["email"]);
$horarioAbertura = trim($_POST["horarioAbertura"]);
$horarioFechamento = trim($_POST["horarioFechamento"]);
$telefoneFixo = trim($_POST["telefoneFixo"]);
$telefoneCel = trim($_POST["telefoneCel"]);
$sobre = trim($_POST["sobre"]);

if (empty($endereco)) {

    echo "<script>alert('Informe o Endereço da Empresa'); history.back();</script>";
} else if (empty($email)) {

    echo "<script>alert('Informe o e-Mail Para Contato Com a Empresa'); history.back();</script>";
} else if (empty($horarioAbertura)) {

    echo "<script>alert('Informe o Horário de Abertura da Empresa'); history.back();</script>";
} else if (empty($horarioFechamento)) {

    echo "<script>alert('Informe o Horário de Fechamento da Empresa'); history.back();</script>";
} else if (empty($telefoneFixo)) {

    echo "<script>alert('Informe o Telefone Fixo da Empresa'); history.back();</script>";
} else if (empty($telefoneCel)) {

    echo "<script>alert('Informe o Telefone Celular da Empresa'); history.back();</script>";
} else if (empty($sobre)) {

    echo "<script>alert('Descreva sobre sua empresa'); history.back();</script>";
}

if (empty($id)) {

    $sql = "INSERT INTO sobre (id, horarioAbertura, horarioFechamento, endereco, telefoneFixo, telefoneCel, email, sobre, created ) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?)";
    $resultado = $pdo->prepare($sql);
    $resultado->bindParam(1, $horarioAbertura);
    $resultado->bindParam(2, $horarioFechamento);
    $resultado->bindParam(3, $endereco);
    $resultado->bindParam(4, $telefoneFixo);
    $resultado->bindParam(5, $telefoneCel);
    $resultado->bindParam(6, $email);
    $resultado->bindParam(7, $sobre);
    $resultado->bindParam(8, $data);
} else {

    $sql = "UPDATE sobre SET horarioAbertura = ?, horarioFechamento = ?, endereco = ?, telefoneFixo = ?, telefoneCel = ?, email = ?, sobre = ?, updated = ? WHERE id = ? LIMIT 1";
    $resultado = $pdo->prepare($sql);
    $resultado->bindParam(1, $horarioAbertura);
    $resultado->bindParam(2, $horarioFechamento);
    $resultado->bindParam(3, $endereco);
    $resultado->bindParam(4, $telefoneFixo);
    $resultado->bindParam(5, $telefoneCel);
    $resultado->bindParam(6, $email);
    $resultado->bindParam(7, $sobre);
    $resultado->bindParam(8, $data);
    $resultado->bindParam(9, $id);
}


if ($resultado->execute()) {

    echo "<script>alert('Dados Salvos com Sucesso'); location.href='home.php';</script>";
} else {

    echo "<script>alert('Falha ao Salvar Dados'); history.back();</script>";
}
?>