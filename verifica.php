<?php

session_start();

if ($_POST) {

    //Incluir arquivo de conexao com o BD
    include "config/conecta.php";

    $usuario = $senha = "";

    if (isset($_POST['usuario'])) {
        $usuario = trim($_POST['usuario']);
        $usuario = str_replace(".", "", $usuario);
        $usuario = str_replace("-", "", $usuario);
    }
    if (isset($_POST['senha'])) {
        $senha = trim($_POST['senha']);
        $senha = md5($senha);
    }


    if (empty($usuario)) {
        echo "<script>alert('Preencha o campo Usuario');history.back();</script>";
    } else if (empty($senha)) {
        echo "<script>alert('Preencha o campo senha');history.back();</script>";
    } else {
        $sql = "SELECT * FROM usuario WHERE cpf = ? and ( id_tipo = 2 or id_tipo = 3 )  and ativo = 1 LIMIT 1";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(1, $usuario);
        $consulta->execute();

        $dados = $consulta->fetch(PDO::FETCH_OBJ);

        if (empty($dados->id)) {
            echo "<script>alert('Usuario não encontrado e/ou inativo');location.href='pedidos.php';</script>";
        } else if ($senha != $dados->senha) {
            //senha incorreta
            echo "<script>alert('Senha incorreta');history.back();</script>";
        } else {
            $_SESSION['usuario'] = array(
                "id" => $dados->id,
                "nome" => $dados->nome,
                "cpf" => $dados->cpf
            );

            header("Location: indexPedido.php");
        }
    }
}
?>