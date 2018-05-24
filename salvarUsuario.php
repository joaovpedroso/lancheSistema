<?php

include "menu.html";

if ($_POST) {

    $id = trim($_POST['id']);
    $nome = trim($_POST['nome']);

    $cpf = trim($_POST['cpf']);
    //Retirar . e , do conteudo
    $cpf = str_replace(".", "", $cpf);
    $cpf = str_replace("-", "", $cpf);

    $rg = trim($_POST['rg']);
    //Retirar . e , do conteudo
    $rg = str_replace(".", "", $rg);
    $rg = str_replace("-", "", $rg);

    $email = trim($_POST['email']);

    $senha = trim($_POST['senha']);
    $senha = md5($senha);

    $telefone = trim($_POST['telefone']);
    $cep = trim($_POST['cep']);
    $endereco = trim($_POST['endereco']);
    $numero = trim($_POST['numero']);
    $cidade = trim($_POST['cidade']);

    //Se nenhum ID for informado Vai cadastrar novo Usuario
    if (empty($id)) {

        $sql = "SELECT * FROM usuario";
        $consulta = $pdo->prepare($sql);
        $consulta->execute();
        while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
            $conCPF = $dados->cpf;
            $conEmail = $dados->email;


            if ($cpf == $conCPF) {
                echo "<script>alert('CPF já cadastrado'); history.back();</script>";
                exit;
            } else if ($email == $conEmail) {
                echo "<script>alert('Email já cadastrado'); history.back();</script>";
                exit;
            }
        }
        //Cadastrar Novo Cliente TIPO 2
        $sql = "INSERT INTO usuario ( id, nome, senha, telefone, email, cpf, rg, endereco, cep, numero, cidade, id_tipo, ativo ) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 2, 1) ";

        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(1, $nome);
        $consulta->bindParam(2, $senha);
        $consulta->bindParam(3, $telefone);
        $consulta->bindParam(4, $email);
        $consulta->bindParam(5, $cpf);
        $consulta->bindParam(6, $rg);
        $consulta->bindParam(7, $endereco);
        $consulta->bindParam(8, $cep);
        $consulta->bindParam(9, $numero);
        $consulta->bindParam(10, $cidade);
    } else {
        //Atualizar Cliente TIPO 2
        $sql = " UPDATE usuario SET nome = ?, senha = ?, telefone = ?, email = ?, cpf = ?, rg = ?, endereco = ?, cep = ?, numero = ?, cidade = ? WHERE id = ? LIMIT 1";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(1, $nome);
        $consulta->bindParam(2, $senha);
        $consulta->bindParam(3, $telefone);
        $consulta->bindParam(4, $email);
        $consulta->bindParam(5, $cpf);
        $consulta->bindParam(6, $rg);
        $consulta->bindParam(7, $endereco);
        $consulta->bindParam(8, $cep);
        $consulta->bindParam(9, $numero);
        $consulta->bindParam(10, $cidade);
        $consulta->bindParam(11, $id);
    }

    if ($consulta->execute()) {
        echo "<script>alert('Usuário cadastrado com sucesso'); location.href='pedidos.php';</script>";
    } else {
        echo "<script>alert('Erro ao cadastrar Usuário'); history.back();</script>";
    }
}
?>