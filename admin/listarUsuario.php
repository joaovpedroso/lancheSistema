<?php
	include "menu.php";
        verificaPermissao();
?>
<div class="container well">
	<h1>Usuarios</h1>

	<div class="clearfix"></div>

	<a href="usuario.php" class="btn btn-default pull-right">
		<i class="glyphicon glyphicon-file"></i>
		Novo Cadastro
	</a>

	<div class="clearfix"></div>

	<?php
			//buscar da categoria
			$sql = "SELECT id,nome,cpf,telefone,email,endereco,cidade, ativo FROM usuario WHERE id_tipo = 3 order by nome";
			$consulta = $pdo->prepare($sql);
			//executar o sql
			$consulta->execute();

		?>


	<br>
	<div class="table-responsive">
		<table class="table table-responsive table-hover table-striped">
			<thead>
				<tr>
					<td>Nome</td>
					<td>CPF</td>
					<td>Telefone</td>
					<td>E-Mail</td>
					<td>Cidade</td>
					<td>Status</td>
					<td width="150px">Opções</td>
				</tr>
			</thead>	

			<tbody>
				<?php
					while( $dados = $consulta->fetch( PDO::FETCH_OBJ ) ) {
						$id 		= $dados->id;
						$nome 		= $dados->nome;
						$telefone 	= $dados->telefone;
						$email 		= $dados->email;
						$cpf 		= $dados->cpf;
						$endereco 	= $dados->endereco;
						$cidade 	= $dados->cidade;
						$status  	= $dados->ativo;
						if ( $status == 1 ) {
							$status = "Ativo";
						} else {
							$status = "Inativo";
						}

						echo "
						<tr>
							<td>$nome</td>
							<td>$cpf</td>
							<td>$telefone</td>
							<td>$email</td>
							<td>$cidade</td>
							<td>$status</td>
							<td>
							<a href='usuario.php?id=$id'>
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
			location.href = "excluirUsuario.php?id="+id;
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
					"zeroRecords" : "Nenhum Usuário Cadastrado",

					//Qual pagina está mostrando
					"info" : "Mostrando _PAGE_ de _PAGES_",

					//QUando não a paginas para mostrar
					"infoEmpty" : "Nenhum Usuário Encontrado",

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