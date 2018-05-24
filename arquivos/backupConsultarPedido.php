<?php
	include "menu.html";

?>
	
	<div id="tela_pedido">
		<div class="col-md-5">
			<form name="consulta" method="get">
				<label>Data do pedido:</label>
				<input type="date" name="data" class="form-control" id="calendario">
				<br>
				<button class="btn pull-right" type="submit">Pesquisar</button>
			</forn>
		</div>	

		<?php
			$data = "";
			
			if ( isset( $_GET['data'] ) ){
				
				$id = $_SESSION['usuario']['id'];

				$data = $_GET['data'];
			}

			$sql = "SELECT p.id, e.entrega, s.status, pag.pagamento, p.data, p.valorTotal FROM pedido p 
				INNER JOIN forma_entrega e ON ( e.id = p.id_entrega )
				INNER JOIN status s ON ( s.id = p.id_status )
				INNER JOIN pagamento pag ON ( pag.id = p.id_pagamento )
				WHERE p.data = ? and p.id_usuario = ? ORDER BY p.data ";
				$consulta = $pdo->prepare($sql);
				$consulta->bindParam(1, $data);
				$consulta->bindParam(2, $id_user);
				$consulta->execute();

		?>

		<div class="col-md-12">
			<br>
			<div class="table-responsive">
				<table class="table table-bordered table-stripped" style=" background: #f1f1f1; color: black;">
					<tr class="text-center">
						<td><b>Data</b></td>
						<td><b>Status</b></td>
						<td><b>Pagamento</b></td>
						<td><b>Valor Total</b></td>
					</tr>
					<?php
						while( $dados = $consulta->fetch( PDO::FETCH_OBJ ) ) {
							$id = $dados->id;
							$data 	 	= $dados->data;
							$data 		= explode("-", $data);
							$dia		= $data[2];
							$mes 		= $data[1];
							$ano 		= $data[0];
							$data 		= $dia."/".$mes."/".$ano;
							$status 	= $dados->status;
							$pagamento 	= $dados->pagamento;
							$valorTotal = $dados->valorTotal;
							$valorTotal = number_format($valorTotal, 2, ",",".");
							echo "
							<tr>
								<td class='text-center'>$data</td>
								<td class='text-center'>$status</td>
								<td class='text-center'>$pagamento</td>
								<td class='text-center'>$valorTotal</td>
							</tr>";
						}
					?>	
				</table>
			</div>	
		</div>	

	</div>

<?php
	include "rodape.html";
?>