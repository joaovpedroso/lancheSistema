<?php

//Transformando o arquivo em JSON
header("Content-type:application/json");

include "../config/conecta.php";

//Selecionando os dados no banco
$sql = "SELECT id, nome, cpf FROM usuario ORDER BY nome";
$consulta = $pdo->prepare($sql);
$consulta->execute();
while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
    //Juntando o nome com o CPF
    $dados->nome = $dados->nome . " - " . $dados->cpf;

    //Criar array com os dados
    $array[] = $dados;
}

//Converter o conteúdo do Array em JSON
echo json_encode($array);
?>