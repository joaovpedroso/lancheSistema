<?php
	include "menu.html";	

	$sqlCat = "SELECT * FROM categoria WHERE categoria like 'Lan%' LIMIT 1";
	$consultaCat = $pdo->prepare( $sqlCat );
	$consultaCat ->execute();
	$dadosCat 	 = $consultaCat->fetch( PDO::FETCH_OBJ );
		
		//Pesquisa se há categoria cadastrada
		$resultados = $consultaCat->rowCount();


		//Se existe categoria cadastrada seleciona dados dos produtos
		if( !$resultados == 0 ) {
				
			//Armazena o id da categoria com nome Lanc...
			$categoria = $dadosCat->id;
			
			//Seleciona os produtos com a categoria selecionada
			$sql 		= "SELECT * FROM produto WHERE id_categoria = ? AND ativo = 1 ORDER BY quantidadeVendida DESC LIMIT 1";
			$consulta 	= $pdo->prepare($sql);
			$consulta	->bindParam(1, $categoria);
			$consulta	->execute();

			$dados 	= $consulta->fetch( PDO::FETCH_OBJ );
				
				//Contagem se existem lanches cadastrados
				$lanches = $consulta->rowCount();

				//Se existe lanche cadastrado entra e recebe os dados nas variaveis
				if( !$lanches == 0 ) {						

					$id 		= $dados->id;
					$nome 		= $dados->nome;
					$descricao 	= $dados->descricao;
					$preco 		= $dados->preco;
					$imagem 	= $dados->imagem;
					$imagem 	= $imagem.'m.jpg';


				//Fecha PHP para mostrar HTML
				?>
				<div class="container">
					<h1 class="text-center titulo">Lanche Mais Comprado</h1>
						<div class="text-center thumbnail">
						<!-- ABRE PHP para mostrar dados da consulta -->
						<?php

							//Mostra dados do lanche
							echo "<img src='img/produtos/$imagem' class='img-responsive'>

								<h2 class='categoria'>$nome</h2>
								<p class='fonteNome'>R$ $preco,00</p>
								<div class='row'>

									
										<a href='adicionar.php?prod=$id' class='btn btn-danger'>Comprar</a>
										<a href='cardapio.php' class='btn btn-orange'>Ver Mais Lanches</a>
									
									
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
						</div>