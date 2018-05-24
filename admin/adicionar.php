<?php
	
    //Inclui o menu com as verificações e configurações
    include "menu.php";

    //VErifica se existe uma sessão de produtos se nao ele inicia com um Array
    if( !isset ( $_SESSION["produtos"] ) ) {
        $_SESSION["produtos"] = array();
    }


    //verifica se foi enviado ID do Produto pela URL atraves do atributo PROD
    if( isset( $_GET["prod"] ) ) {

        //Recebe o valor do ID do Produto
        $id 	= trim( $_GET["prod"] );
        //Declara uma variavel quantidade recebendo 0 para setar a quantidade de cada produto a ser adicionado
        $qtd 	= 0;

        //Consulta no banco pra ver se existe produto com o id cadastrado
        $sql 	= "SELECT * FROM produto WHERE id = ? LIMIT 1";
        $result = $pdo->prepare( $sql );
        $result	->bindParam( 1, $id );
        $result	->execute();
        $dados 	= $result->fetch( PDO::FETCH_OBJ );
        if( !isset( $dados->id ) ){
            echo "<script>alert('Produto não encontrado'); history.back();</script>";
            echo "<h1 class='alert alert-danger'>Produto não encontrado</h1>";
            exit;
            header( "Location: home.php" );
        }else {
            if( isset( $_SESSION["produtos"][$id] ) ) {
                    //Caso seja adicionado + de 1 produto com o mesmo ID ele soma a quantidade de produtos ao inves de adicionar um novo
                    $qtd = $_SESSION["produtos"][$id] + 1;
            } else {
                    $qtd = 1;
            }


            //Adiciona o Produto atraves de seu ID na sessão com sua respectiva quantidade
            $_SESSION["produtos"][$id] = $qtd;

            //Mostra mensagem de produto adicionado e direciona para o Carrinho ou tela de pedidos
            echo "<script>location.href='pedido.php';</script>";	
        }
    }
?>	