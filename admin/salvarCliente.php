<?php

include "menu.php";

if ($_POST) {

    //Recebendo valores do formulario removendo os espaços

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

    $ativo = trim($_POST['ativo']);
    //Verificações de campos em branco //Caso tenha sido desativado o JavaScript

    if (empty($nome)) {
        echo "<script>alert('Preencha o campo Nome '); history.back();</script>";
        exit;
    }

    if (empty($cpf)) {
        echo "<script>alert('Preencha o campo CPF '); history.back();</script>";
        exit;
    }


    if (empty($rg)) {
        echo "<script>alert('Preencha o campo RG '); history.back();</script>";
        exit;
    }

    if (empty($email)) {
        echo "<script>alert('Preencha o campo E-Mail '); history.back();</script>";
        exit;
    }

    if (empty($senha)) {
        echo "<script>alert('Preencha o campo Senha '); history.back();</script>";
        exit;
    }

    if (empty($telefone)) {
        echo "<script>alert('Preencha o campo Telefone '); history.back();</script>";
        exit;
    }

    if (empty($cep)) {
        echo "<script>alert('Preencha o campo CEP '); history.back();</script>";
        exit;
    }

    if (empty($endereco)) {
        echo "<script>alert('Preencha o campo Endereco '); history.back();</script>";
        exit;
    }

    if (empty($numero)) {
        echo "<script>alert('Preencha o campo Numero '); history.back();</script>";
        exit;
    }

    if (empty($cidade)) {
        echo "<script>alert('Preencha o campo Cidade '); history.back();</script>";
        exit;
    }

    if (empty($ativo)) {
        if (empty($cidade)) {
            echo "<script>alert('Preencha o campo Status '); history.back();</script>";
            exit;
        }
    }


    if (empty($id)) {
        $sql = "SELECT * FROM usuario";
        $consulta = $pdo->prepare($sql);
        $consulta->execute();
        while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
            $verificaCpf = $dados->cpf;

            if ($cpf == $verificaCpf) {
                echo "<script>alert('CPF Já Cadastrado'); history.back();</script>";
                exit;
            }
        }

        $sql = "INSERT INTO usuario ( id, nome, cpf, rg, email, senha, telefone, cep, endereco, numero, cidade, id_tipo, ativo ) VALUES ( NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 2, ? ) ";

        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(1, $nome);
        $consulta->bindParam(2, $cpf);
        $consulta->bindParam(3, $rg);
        $consulta->bindParam(4, $email);
        $consulta->bindParam(5, $senha);
        $consulta->bindParam(6, $telefone);
        $consulta->bindParam(7, $cep);
        $consulta->bindParam(8, $endereco);
        $consulta->bindParam(9, $numero);
        $consulta->bindParam(10, $cidade);
        $consulta->bindParam(11, $ativo);
    } else {

        $sql = " UPDATE usuario SET nome = ?, cpf = ?, rg = ?, email = ?, senha = ?, telefone = ?, cep = ?, endereco = ?, numero = ?, cidade = ?, ativo = ? WHERE id = ? LIMIT 1 ";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(1, $nome);
        $consulta->bindParam(2, $cpf);
        $consulta->bindParam(3, $rg);
        $consulta->bindParam(4, $email);
        $consulta->bindParam(5, $senha);
        $consulta->bindParam(6, $telefone);
        $consulta->bindParam(7, $cep);
        $consulta->bindParam(8, $endereco);
        $consulta->bindParam(9, $numero);
        $consulta->bindParam(10, $cidade);
        $consulta->bindParam(11, $ativo);
        $consulta->bindParam(12, $id);
    }

    if ($consulta->execute()) {
        echo "<script>alert('Cliente Salvo Com Sucesso ! '); location.href='listarCliente.php';</script>";
    } else {
        echo "<script>alert('Erro ao Salvar'); history.back();</script>";
    }
}
?>