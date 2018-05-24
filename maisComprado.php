<?php
include "menu.html";

$sqlCat = "SELECT * FROM categoria WHERE categoria like 'Lan%' LIMIT 1";
$consultaCat = $pdo->prepare($sqlCat);
$consultaCat->execute();
$dadosCat = $consultaCat->fetch(PDO::FETCH_OBJ);

//Pesquisa se há categoria cadastrada
$resultados = $consultaCat->rowCount();


//Se existe categoria cadastrada seleciona dados dos produtos
if (!$resultados == 0) {

    //Armazena o id da categoria com nome Lanc...
    $categoria = $dadosCat->id;

    //Seleciona os produtos com a categoria selecionada
    $sql = "SELECT * FROM produto WHERE id_categoria = ? AND ativo = 1 ORDER BY quantidadeVendida DESC LIMIT 1";
    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(1, $categoria);
    $consulta->execute();

    $dados = $consulta->fetch(PDO::FETCH_OBJ);

    //Contagem se existem lanches cadastrados
    $lanches = $consulta->rowCount();

    //Se existe lanche cadastrado entra e recebe os dados nas variaveis
    if (!$lanches == 0) {

        $id = $dados->id;
        $nome = $dados->nome;
        $descricao = $dados->descricao;
        $preco = number_format($dados->preco, 2, ",", ".");
        $imagem = $dados->imagem;
        $imagem = $imagem . 'm.jpg';


        //Fecha PHP para mostrar HTML
        ?>
        <div class="container">
            <h1 class="text-center titulo">Lanche Mais Comprado</h1>
            <!-- ABRE PHP para mostrar dados da consulta -->
            <?php
            //Mostra dados do lanche
            echo "
                <div class='col-md-5 thumbnail'>

                        <img src='img/produtos/$imagem' class='img-responsive'>

                </div>	
                <div class='col-md-7'>

                        <h3><b>Lanche:</b>  $nome</h3>
                        <p><b>Valor: R$</b> $preco</p>
                        <p><b>Ingredientes: </b>
                        <p>$descricao</p>

                        <a href='adicionar.php?prod=$id' class='btn btn-danger'>Comprar</a>
                        <a href='cardapio.php' class='btn btn-orange' style='color: white;'>Ver Mais Lanches</a>
                </div>
                ";

            //Fecha IF dos lanches cadastrados
        } else {

            //Se nao tem produto cadastrado mostra mensagem
            echo "
                <div class='alert alert-danger text-center'>
                        <h3>Nenhum Lanche Cadastrado</h3>
                </div>
                ";
        }
    }
    //Mostrar mensagem de erro se nao existir categoria cadastrada
    else {
        echo "
            <div class='alert alert-danger text-center'>
                    <h3>Nenhuma Categoria Cadastrada</h3>
            </div>
            ";
    }
    ?>