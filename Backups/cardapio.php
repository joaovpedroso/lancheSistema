<?php
	include "menu.php";
?>
<style>
    body{
        background: #fff;
    }
</style>
<div class="linha"></div>
<div class="container">
	<h1 class="text-center titulo">Cardápio</h1>
	<hr>

	<?php
		$sqlCat 		= "SELECT * FROM categoria WHERE ativo = 1 ORDER BY categoria";
		$consultaCat 	= $pdo->prepare( $sqlCat );
		$consultaCat	->execute();
		
		$categoriasCadastradas = $consultaCat->rowCount();
		if ( $categoriasCadastradas == 0 ) {
			echo "
			<div class='alert alert-danger text-center'>
				<h3><b>Nenhum Produto Cadastrado !</b></h3>
			</div>
			";
		}

		while( $dadosCat = $consultaCat->fetch( PDO::FETCH_OBJ ) ){
			$idCat 		= $dadosCat->id;
			$categoria  = $dadosCat->categoria;

			echo "
			<div class='col-md-6'>
				<h3 class='categoria' style='color: lightgray; font-weight: ;'>$categoria</h3>
			";

				$sqlProd 		= "SELECT * FROM produto WHERE id_categoria = ? and ativo = 1 ORDER BY nome";
				$consultaProd 	= $pdo->prepare( $sqlProd );
				$consultaProd	->bindParam(1, $idCat );
				$consultaProd 	->execute();

				while( $dadosProd = $consultaProd->fetch( PDO::FETCH_OBJ ) ) {
					$id 		= $dadosProd->id;
					$produto 	= $dadosProd->nome;
					$valor 		= $dadosProd->preco;
					$valor 		= number_format($valor, 2, ",",".");
					$descricao  = $dadosProd->descricao;
					$imagem		= $dadosProd->imagem;

					$imagem 	= $imagem."p.jpg";
					$img 		= "<img src= '../img/produtos/$imagem' width='100px' class='img-responsive'>";

					echo "
					

							<div class='col-md-8'>
								<a data-toggle='collapse' href='#descricao$id' aria-expanded='true' aria-controls='descricao'>
									<h4 class='fonteNome'>$produto</h4>
								</a>
								<div id='descricao$id' class='fonte collapse '>
									<div class='row'>
										<div class='col-md-4'>
											$img
										</div>
										<div class='col-md-8'  style='color: white;'>
											$descricao
										</div>	
									</div>	
								</div>
							</div>
							<div class='col-md-4 text-center'>
								<h4 class='fonteNome'>$valor</h4>";
									echo "<a href='adicionar.php?prod=$id' class='btn btn-default'>Comprar</a>
							</div>";

				}
			echo "</div>";
		}
	?>

<!-- LISTAEGM FIXA -->
<!--

	<div class='col-md-6'>
		<h3 class="categoria">Lanches</h3>
		<?php
			$sql = "SELECT * FROM produto WHERE id_categoria = ( SELECT id FROM categoria WHERE categoria like 'Lanches%') ORDER BY nome";
			$consulta = $pdo->prepare($sql);
			//$consulta->bindParam(1,);
			$consulta->execute();

			while ( $dados = $consulta->fetch(PDO::FETCH_OBJ) ) {
				$id 		= $dados->id;
				$produto 	= $dados->nome;
				$valor		= $dados->preco;
				$valor 		= number_format($valor, 2, ",",".");
				$descricao  = $dados->descricao;

				echo "
				<div class='col-md-8'>
					 <a data-toggle='collapse' href='#descricao$id' aria-expanded='true' aria-controls='descricao'>
					 <h4 class='fonteNome'>$produto</h4>
					 </a>
					<div id='descricao$id' class='fonte collapse '>$descricao</div>
				</div>
				<div class='col-md-4 text-center'>
					<h4 class='fonteNome'>$valor</h4>
					<button class='btn'>Comprar</button>
				</div>";
			}
		?>
	</div>	

	<div class='col-md-6'>
		<h3 class="categoria">Pizzas</h3>
		<?php
			$sql = "SELECT * FROM produto WHERE id_categoria = ( SELECT id FROM categoria WHERE categoria like 'Piz%') ORDER BY produto";
			$consulta = $pdo->prepare($sql);
			//$consulta->bindParam(1,);
			$consulta->execute();

			while ( $dados = $consulta->fetch(PDO::FETCH_OBJ) ) {
				$id 		= $dados->id;
				$produto 	= $dados->produto;
				$valor		= $dados->preco;
				$valor 		= number_format($valor, 2, ",",".");
				$descricao  = $dados->descricao;

				echo "
				<div class='col-md-8'>
					<a data-toggle='collapse' href='#descricao$id' aria-expanded='true' aria-controls='descricao'>
						<h4 class='fonteNome'>$produto</h4>
					</a>	
					<div id='descricao$id' class='fonte collapse '>$descricao</div>
				</div>
				<div class='col-md-4 text-center'>
					<h4 class='fonteNome'>$valor</h4>
					<button class='btn'>Comprar</button>
				</div>";
			}
		?>
	</div>

	<div class="clearfix"></div><hr>

	<div class='col-md-6'>
		<h3 class="categoria">Porções</h3>
		<?php
			$sql = "SELECT * FROM produto WHERE id_categoria = ( SELECT id FROM categoria WHERE categoria like 'Porcoes%') ORDER BY produto";
			$consulta = $pdo->prepare($sql);
			//$consulta->bindParam(1,);
			$consulta->execute();

			while ( $dados = $consulta->fetch(PDO::FETCH_OBJ) ) {
				$id 		= $dados->id;
				$produto 	= $dados->produto;
				$valor		= $dados->preco;
				$valor 		= number_format($valor, 2, ",",".");
				$descricao  = $dados->descricao;

				echo "
				<div class='col-md-8'>
					<a data-toggle='collapse' href='#descricao$id' aria-expanded='true' aria-controls='descricao'>
						<h4 class='fonteNome'>$produto</h4>
					</a>	
					<div id='descricao$id' class='fonte collapse '>$descricao</div>
				</div>
				<div class='col-md-4 text-center'>
					<h4 class='fonteNome'>$valor</h4>
					<button class='btn'>Comprar</button>
				</div>";
			}
		?>
	</div>

	<div class='col-md-6'>
		<h3 class="categoria">Bebidas</h3>
		<?php
			$sql = "SELECT * FROM produto WHERE id_categoria = ( SELECT id FROM categoria WHERE categoria like 'Bebidas%') ORDER BY produto";
			$consulta = $pdo->prepare($sql);
			//$consulta->bindParam(1,);
			$consulta->execute();

			while ( $dados = $consulta->fetch(PDO::FETCH_OBJ) ) {
				$id 		= $dados->id;
				$produto 	= $dados->produto;
				$valor		= $dados->preco;
				$valor 		= number_format($valor, 2, ",",".");
				$descricao  = $dados->descricao;

				echo "
				<div class='col-md-8'>
					<a data-toggle='collapse' href='#descricao$id' aria-expanded='true' aria-controls='descricao'>
						<h4 class='fonteNome'>$produto</h4>
					</a>	
					<div id='descricao$id' class='fonte collapse '>$descricao</div>
				</div>
				<div class='col-md-4 text-center'>
					<h4 class='fonteNome'>$valor</h4>
					<button class='btn'>Comprar</button>
				</div>";
			}
		?>
	</div>
-->

	<div class="clearfix"></div>
</div>
