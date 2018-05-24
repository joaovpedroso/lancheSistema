<?php
    include "menu.php";
    
	$sql = "SELECT id,nome,cpf,telefone,email,endereco,cidade FROM usuario WHERE id_tipo = 2 OR id_tipo = 3 ORDER BY Nome";
	$consulta = $pdo->prepare($sql);
	$consulta->execute();

	$itens = $consulta->rowCount();

?>
<div class=" container well ">
	<h1>Usuarios Cadastrados</h1>

	<a href="relUsuariosPDF.php" class="btn btn-success pull-right">Gerar PDF</a>

	<div class="clearfix"></div>

	<br>
	<br>
	<div class="table-responsive">
		<table class="table table-responsive table-bordered table-striped">
			<thead>
				<tr>
					<td>Nome</td>
					<td>Telefone</td>
					<td>Cidade</td>
				</tr>
			</thead>	
			<?php

				if( $itens == 0 ) {
					echo "
					<div class='alert alert-danger'>
						Nenhum Resultado Encontrado
					</div>										
					";


				}

				while( $dados = $consulta->fetch( PDO::FETCH_OBJ ) ) {
					$id 		= $dados->id;
					$nome 		= $dados->nome;
					$telefone 	= $dados->telefone;
					$email 		= $dados->email;
					$cpf 		= $dados->cpf;
					$endereco 	= $dados->endereco;
					$cidade 	= $dados->cidade;

					echo "
					<tr>
						<td>$nome</td>
						<td>$telefone</td>
						<td>$cidade</td>
					</tr>
					";
				}
			?>
		</table>	
	</div>	
	<br>
	<a href="relVendas.php" class="btn btn-primary">Voltar</a>
</div>
<script type="text/javascript">
	$(document).ready( function() {

			//Aplicar a formatacao na tabela
			$(".table").dataTable({

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