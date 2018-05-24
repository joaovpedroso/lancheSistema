<?php
	include "menu.php";

	if( isset( $_GET['st'] ) ) {
		$statusPed = trim( $_GET['st'] );
		
		if ( $statusPed == 2 ){
			$statusPed = trim( $_GET['st'] );
		} else if ( $statusPed == 3 ) {
			$statusPed = trim( $_GET['st'] );
		} else {
			$statusPed = 1;
		}
	} else {
		$statusPed = 1;
	}
	$sqlStatus = "SELECT status FROM status WHERE id = ? LIMIT 1";
	$consultaStatus = $pdo->prepare( $sqlStatus );
	$consultaStatus->bindParam(1, $statusPed);
	$consultaStatus->execute();
	$dadosSt = $consultaStatus->fetch( PDO::FETCH_OBJ );
		$st = $dadosSt->status;
?>

<div class="container well">
	<h1 class="titulo text-center">Pedidos</h1>
	<br>

	<ul class="nav nav-tabs">
	  <li role="presentation"><a href="listarPedido.php" class="btn btn-primary">Pendentes</a></li>
	  <li role="presentation"><a href="listarPedido.php?st=2" class="btn btn-success">Prontos</a></li>
	  <li role="presentation"><a href="listarPedido.php?st=3" class='btn btn-danger'>Em Entrega</a></li>
	</ul>
	<br>
	<!-- ABRE SEPARACAO DE PEDIDOS -->

		<?php
			/*MONTAGEM DA TABELA DIVIDIDA EM 3 ETAPAS
			1º Select - PEGO O ID DE TODOS OS CLIENTES QUE POSSUEM PEDIDOS COM STATUS = 1 -> Pendentes
			2º Select - CAPTURO O NOME DO CLIENTE ATRAVES DE SEU ID
			3º Select - CAPTURO TODOS OS PRODUTOS INCLUIDOS NO PEDIDO DE UM CLIENTE ATRAVES DE SEU ID (cliente) CAPTURADO NO 1º SELECT
			4º Select - 
			*/
			
			$dataP = $data;
			$dataP = explode("-", $dataP);
			$dia = $dataP[0];
			$mes = $dataP[1];
			$ano = $dataP[2];
			$dataP = $ano."-".$mes."-".$dia;

			$sql1 = "SELECT id_usuario, id FROM pedido WHERE id_status = ? and data = ?";
			$consulta1 = $pdo->prepare($sql1);
			$consulta1->bindParam(1, $statusPed);
			$consulta1->bindParam(2, $dataP);
			$consulta1->execute();
			$linhas = $consulta1->rowCount();
			
			if( $linhas == 0 ) {
				echo "<p class='alert alert-danger'>Nenhum Pedido Com Status ".$st." Encontrado</p>";
			}

			while ( $dados1 = $consulta1->fetch( PDO::FETCH_OBJ ) ) {

				$cli_id = $dados1->id_usuario;
				$ped_id = $dados1->id;	
			

				$sql2 = "SELECT nome, cep, endereco, numero, cidade FROM usuario WHERE id = ?";
				$consulta2 = $pdo->prepare($sql2);
				$consulta2->bindParam(1, $cli_id);
				$consulta2->execute();

				$dados2 = $consulta2->fetch( PDO::FETCH_OBJ );
					$cliente 	= $dados2->nome;
					$cep 	 	= $dados2->cep;
					$endereco 	= $dados2->endereco;
					$numero 	= $dados2->numero;
					$cidade 	= $dados2->cidade;

				echo "<div class='col-md-4'>
					<div class='panel'>
						<div class='panel-heading'>
							<div class='col-sm-7'>
								<p>Nº $ped_id / $cliente </p>
								<br>
							</div>
							<div class='col-md-5'>
								<a href='alterarStatus.php?action=ep&id=$ped_id' class='btn btn-primary'  title='Em Preparo' style='height: 30px; width: 30px; text-align: center; padding: 5px;'>
									<i class='glyphicon glyphicon-fire'></i>
								</a>

								<a href='alterarStatus.php?action=p&id=$ped_id' class='btn btn-success' title='Pronto' style='height: 30px; width: 30px; text-align: center; padding: 5px;'>
									<i class='glyphicon glyphicon-ok'></i>
								</a>

								<a href='alterarStatus.php?action=e&id=$ped_id' class='btn btn-danger' title='Entrega' style='height: 30px; width: 30px; text-align: center; padding: 5px;'>
									<i class='glyphicon glyphicon-plane'></i>
								</a>
							</div>	
						</div>
						<div class='panel-body'>
							<table class='table table-responsive'>
								<tr>
									<td>Quantidade</td>
									<td>Produto</td>
								</tr>";

						$sql3 = "SELECT p.valorTotal, pr.nome, pp.quantidade FROM pedido p
						INNER JOIN produto_pedido pp ON pp.id_pedido = p.id
						INNER JOIN produto pr ON pr.id = pp.id_produto WHERE p.id_status = ? and p.id_usuario = ? AND p.id = ?";
						$consulta3 = $pdo->prepare($sql3);
						$consulta3->bindParam(1, $statusPed);
						$consulta3->bindParam(2, $cli_id);
						$consulta3->bindParam(3, $ped_id);
						$consulta3->execute();
						while ( $dados3 = $consulta3->fetch( PDO::FETCH_OBJ ) ) {
							$produto = $dados3->nome;
							$quantidade = $dados3->quantidade;

							echo "<tr>
									<td>$quantidade</td>
									<td>$produto</td>
								</tr>";
						}

						$sql4 = "SELECT p.valorTotal, p.data, e.entrega, pg.pagamento, p.observacao, p.troco FROM pedido p
								INNER JOIN forma_entrega e ON e.id = p.id_entrega
								INNER JOIN pagamento pg ON pg.id = p.id_pagamento WHERE p.id = ?";
						$consulta4 = $pdo->prepare( $sql4 );
						$consulta4->bindParam(1, $ped_id);
						$consulta4->execute();
						$dados4 = $consulta4->fetch( PDO::FETCH_OBJ );
							$observacao 	= $dados4->observacao;
							$troco			= $dados4->troco;
							$troco 			= number_format($troco, 2, ',', '.');
							$forma_entrega 	= $dados4->entrega;
							$pagamento 		= $dados4->pagamento;
							$data 			= $dados4->data;
							$data 			= explode("-", $data);
								$dia 		= $data[2];
								$mes 		= $data[1];
								$ano 		= $data[0];
							$data 			= $dia."/".$mes."/".$ano;

							$valorTotal 	= $dados4->valorTotal;
							$valorTotal 	= number_format($valorTotal, 2, ',', '.');

						echo "</table>
							<p><b>Observações:</b>$observacao</p>
							<p><b>Forma de Entrega:</b> $forma_entrega</p>
							<p><b>Pagamento:</b> $pagamento</p>
							<p><b>Troco:</b> R$ $troco</p>
							<p><b>Data do Pedido:</b> $data</p>
							<p><b>Valor Total:</b> R$ $valorTotal</p>
							<p><b>**** Endereço de Entrega: ****</b></p>
							<p><b>CEP: </b>$cep</p>
							<p><b>Rua: </b>$endereco , $numero</p>
							</div>
						</div>
		</div>				";			
			}
		?>
	
	<!-- FECHA COLUNA DE PEDIDOS -->

</div>