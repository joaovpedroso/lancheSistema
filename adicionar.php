<?php
	
	//Inclui o menu com as verificações e configurações
	include "menu.html";
		
	//Verificar se e um cliente que esta logado
	if( !isset( $_SESSION["usuario"]["id"] ) ) {
		
		echo "<script>location.href='pedidos.php';</script>";
		header( "Location: pedidos.php" );
		exit;
		exit;
	}


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