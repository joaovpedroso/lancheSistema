<?php
	include "menu.php";
?>
<div class="container well">
	<h1>Produtos</h1>

	<div class="clearfix"></div>

	<a href="produto.php" class="btn btn-default pull-right">
		<i class="glyphicon glyphicon-file"></i>
		Novo Cadastro
	</a>

	<div class="clearfix"></div>
	
	<?php
			//buscar da categoria
			$sql = "SELECT p.id,p.nome,p.descricao,p.preco, p.ativo, c.categoria FROM produto p 
					INNER JOIN categoria c ON p.id_categoria = c.id order by nome";
			$consulta = $pdo->prepare($sql);
			//executar o sql
			$consulta->execute();

		?>

	<br>
	<div class="table-responsive">
		<table class="table table-responsive table-hover table-striped">
			<thead>
				<tr>
					<td>Produto</td>
					<td>Descricao</td>
					<td>Categoria</td>
					<td>Preço</td>
					<td>Status</td>
					<td width="150px">Opções</td>
				</tr>
			</thead>

			<tbody>
				<?php
					
					while ( $dados = $consulta->fetch(PDO::FETCH_OBJ) ) {
						$id 		= $dados->id;
						$produto 	= $dados->nome;
						$descricao 	= $dados->descricao;
						$categoria 	= $dados->categoria;
						$preco 		= $dados->preco;
						$preco 		= number_format($preco,2,",",".");
						$id_status 	= $dados->ativo;

						if ( $id_status == 1 ) {
							$status = "Ativo";
						} else {
							$status = "Inativo";
						}

						echo "
						<tr>
							<td>$produto</td>
							<td>$descricao</td>
							<td>$categoria</td>
							<td>$preco</td>
							<td>$status</td>
							<td>
								<a href='produto.php?id=$id'>
									<button class='btn btn-primary'>
									<i class='glyphicon glyphicon-pencil'></i>
									</button>
								</a>

								<a href='javascript:deletar($id)'>
									<button class='btn btn-danger'>
									<i class='glyphicon glyphicon-erase'></i>
									</button>
								</a>
							</td>
						</tr>";
					}
				?>
			</tbody>
		</table>		
	</div>
</div>			
<script type="text/javascript">
	//funcao para perguntar se quer deletar
	function deletar(id) {
		if ( confirm("Deseja mesmo excluir?") ) {
			//enviar o id para uma página
			location.href = "excluirProduto.php?id="+id;
		}
	};

	$(document).ready( function() {

			//Aplicar a formatacao na tabela
			$("table").dataTable({

				//Alterar Linguagem dos atributos
				"language" : {

					//Quantidade de Itens por pagina
					"lengthMenu" : "Mostrando _MENU_ registros por página",

					//Quando não há dados para listar
					"zeroRecords" : "Nenhum Produto Cadastrado",

					//Qual pagina está mostrando
					"info" : "Mostrando _PAGE_ de _PAGES_",

					//QUando não a paginas para mostrar
					"infoEmpty" : "Nenhum Produto encontrado",

					//Quantos valores encontrados na busca
					"infoFiltered" : "(Encontrado de um total de _MAX_ registros)",

					//Label do campo de busca
					"search" : "Buscar:",

					//Botões de Paginação
					"paginate" : {

						//Anterior
						"previous" : "Anterior",

						//Próxima
						"next" : "Proxima"
					}
				}
			});
	})
</script>
	