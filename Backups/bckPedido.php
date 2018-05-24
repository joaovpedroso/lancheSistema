<?php
	include "menu.html";

	//Excluir Produto
	if( isset( $_GET["del"] ) ){

		//Receber o ID q deseja excluir na variavel DEL
		$del = $_GET["del"];

		//Excluir Produto na posicao com o id informado
		unset( $_SESSION["produtos"][$del] );

	}
?>
<div class="container well">
	<h1>Seu Pedido</h1>
	<hr>

	<div class="row">
		<div class="col-md-8">
			<div class="control-group text-center">
				<label class="control-label">Cliente</label>
				<div class="controls">
					<div class="col-md-2">
						<input type="text" name="id_cliente" class="form-control text-center" value="<?php echo $_SESSION['usuario']['id'];?>" readonly>
					</div>	
					<div class="col-md-10">
						<input type="text" name="cliente" class="form-control" value="<?php echo $_SESSION['usuario']['nome']; ?>" readonly>
					</div>	
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="control-group text-center">
				<label class="control-label">Horário</label>
				<div class="controls">
				<input type="text" name="horaPedido" value="<?=$hora?>" class="form-control text-center" readonly>
				</div>
			</div>
		</div>
	</div><br>

	
	<div class="control-group col-md-4">
		<label for="forma_pagamento">Forma de Pagamento:</label>
		<div class="controls">
			<select name="forma_pagamento" class="form-control">
				<option value="">Selecione a Forma de Pagamento:</option>
				<?php
					$sql = "SELECT id,pagamento FROM pagamento ORDER BY pagamento";
					$consulta = $pdo->prepare( $sql );
					$consulta->execute();

					while( $dados = $consulta->fetch( PDO::FETCH_OBJ ) ) {
						$id 		= $dados->id;
						$pagamento  = $dados->pagamento;

						echo "<option value='$id'>$pagamento</option>";
					}

				?>
			</select>
		</div>
	</div>

	<div class="control-group col-md-4">
		<label for="forma_entrega">Forma de Entrega:</label>
		<div class="controls">
			<select name="forma_entrega" class="form-control">
				<option value="">Selecione uma Forma de Entrega</option>
				<?php
					$sql = "SELECT id, entrega FROM forma_entrega ORDER BY entrega";
					$consulta = $pdo->prepare( $sql );
					$consulta->execute();

					while( $dados = $consulta->fetch( PDO::FETCH_OBJ ) ) {
						$id = $dados->id;
						$entrega = $dados->entrega;

						echo "<option value='$id'>$entrega</option>";
					}
				?>
			</select>
		</div>
	</div>

</div>	

<div class="container">
	<div class="table-responsive">
		<table class="table table-bordered table-stripped">
			
			<thead>
				<tr class="text-center">
					<td>Imagem</td>
					<td>Produto</td>
					<td>Quantidade</td>
					<td>Valor Unitário</td>
					<td>Sub. Total</td>
					<td>Ações</td>
				</tr>
			</thead>
			<tbody>
				
				<?php

					//Iniciar a variavel para soma do valor total dos produtos e os sub-totais de cada produto
					$total 		= 0;
					$subTotal 	= 0;

					//Percorrer o array e listar os produtos adicionados
					foreach ($_SESSION["produtos"] as $prods =>$quantidade) {

						//Selecionar os dados de cada produto
						$sql 		= "SELECT * FROM produto WHERE id = ? ";
						$resultado 	= $pdo->prepare( $sql );
						$resultado	->bindParam( 1, $prods );
						$resultado	->execute();

						while( $dados = $resultado->fetch(PDO::FETCH_OBJ) ) {

							//id do produto
							$id 		= $dados->id;
							$imagem 	= $dados->imagem;
							//Definir que sera selecionada a imagem com tamanho P para exibição
							$imagem 	= $imagem."p.jpg";
							//Definir o diretorio da Imagem para listagem na tabela dos produtos
							$img 		= "<img src= 'img/produtos/$imagem' width='100px' class='img-responsive'>";
							$nome 		= $dados->nome;
							$preco 		= $dados->preco;
							$qtd 		= $quantidade;
							$subTotal 	= $preco * $qtd;
							$sub 		= $subTotal;
							$sub 		= number_format($sub, 2, ",",".");
							$total 		+= $subTotal;
							$preco 		= number_format($preco, 2, ",",".");
							
							//Listar Produtos
							echo 
							"<tr>
								<td>$img</td>
								<td>$nome</td>
								<td>$qtd</td>
								<td>$preco</td>
								<td>$sub</td>
								<td>
									<a href='pedido.php?del=$id' class='btn btn-danger'>
										<i class='glyphicon glyphicon-erase'></i>
									</a>
								</td>
							</tr>";

						}

					}
					?>
					<div class="row">
						<div class="col-md-7">
							<div class="control-group">
								<label for="observacao">Observações:</label>
								<div class="controls">
									<textarea name="observacao" class="form-control" placeholder="Retirada de Ingrediente"></textarea>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="control-group">
								<label for="troco">Troco:</label>
								<div class="controls">
									<input type="text" name="troco" class="form-control valor" placeholder="Valor do troco">
								</div>
							</div>
						</div>
					</div>		

					<?php
					//Mostar o valor total dos produtos
					$total 		= number_format($total, 2, ",",".");
					echo 
					"<tr>
						<td colspan='6' class='text-right'><b>Valor Total: R$ <b>$total</td>
					</tr>";
				?>
			</tbody>

			<?php

				//Verificar se foi clicado no Botão Finalizar Pedido e realizar os procedimentos de ligacao e inserção com o banco de dados
				if( isset( $_POST["enviar"] ) ) {

					$id_usuario 	= trim( $_SESSION["usuario"]["id"] );
					
					$id_entrega 	= "";
					if( isset( $_POST["id_entrega"] ) ) {
						$id_entrega 	= trim( $_POST["forma_entrega"] );
					}
					if( empty( $id_entrega ) ) {
						echo "<script>alert('Informe uma forma de entrega');</script>";
						exit;
					}

					$id_status 		= 1;

					$id_pagamento	= "";
					if( isset( $_POST["id_pagamento"] ) ) {
						$id_pagamento	= trim( $_POST["forma_pagamento"] );
					}
					if( empty( $id_pagamento ) ) {
						echo "<script>alert('Informe uma forma de Pagamento');</script>";
						exit;
					}

					$data 			= $data;

					$observacao 	=  "";
					if( isset( $observacao ) ) {
						$observacao 	=  trim( $_POST["observacao"] );
					}
					if( empty( $observacao ) ) {
						$observacao = "";
					}

					$troco 			=  "";
					if( isset( $_POST["troco"] ) ) {
						$troco = trim( $_POST["troco"] );
					}
					if( empty( $troco ) ) {
						$troco = 0;
					}		

					$sql 		="INSERT INDO pedido (id, id_usuario, id_entrega, id_status, id_pagamento, valorTotal, data, observacao, troco ) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?)";
					$resultado 	= $pdo->prepare( $sql );
					$resultado	->bindParam( 1, $id_usuario );
					$resultado	->bindParam( 2, $id_entrega );
					$resultado	->bindParam( 3, $id_status );
					$resultado	->bindParam( 4, $id_pagamento );
					$resultado	->bindParam( 5, $total );
					$resultado	->bindParam( 6, $data );
					$resultado	->bindParam( 7, $observacao );
					$resultado	->bindParam( 8, $troco );
					$resultado	->execute();



				}
			?>

		</table>
	</div>

	<form action="" enctype="multipart/form-data" method="POST">
		<!-- Botão para acionar o Método POST que vai ser o responsavel por salvar os dados no banco -->
		<input type="submit" name="enviar" value="Finalizar Pedido" class="btn btn-orange pull-right">
	</form>	

	<a href="cardapio.php" class="btn btn-success pull-left">Adicionar Mais Produtos</a>

</div>