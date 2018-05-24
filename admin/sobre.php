<?php  

	include "menu.php";

	$id 				= $endereco = $email = $horarioAbertura = $horarioFechamento = $telefoneFixo = $telefoneCel = $sobre = "";

	$sql 				= "SELECT * FROM sobre LIMIT 1";
	$resultado 			= $pdo->prepare( $sql );
	$resultado			->execute();

	$dados 				= $resultado->fetch( PDO::FETCH_OBJ );

	if( !empty( $dados->id ) ) {

		$id 				= $dados->id;
		$endereco			= $dados->endereco;
		$email 				= $dados->email;
		$horarioAbertura	= $dados->horarioAbertura;
		$horarioFechamento	= $dados->horarioFechamento;
		$telefoneFixo		= $dados->telefoneFixo;
		$telefoneCel		= $dados->telefoneCel;
		$sobre 				= $dados->sobre;

	}

	
?>
<div class="container well">

	<h1>Cadastrar Dados da Empresa</h1><br>

	<form name="cadDados" action="salvarSobre.php" method="POST" novalidate>

		<div class="control-group" style="visibility: hidden;">
			<label>Codigo da empresa</label>
			<div class="controls">
				<input type="text" name="id" readonly value="<?=$id;?>">
			</div>
		</div>

		<div class="control-group">
			<label>Endereço</label>
			<div class="controls">
				<input type="text" name="endereco" class="form-control" required data-validation-required-message="Informe o Endereço da Empresa" placeholder="Informe o Endereço da Empresa" value="<?=$endereco?>">
			</div>
		</div>

		<div class="control-group">
			<label>Email</label>
			<div class="controls">
				<input type="email" name="email" class="form-control" required data-validation-required-message="Informe o e-Mail Corretamente" placeholder="exemplo@exemplo.com" value="<?=$email?>">
			</div>
		</div>

		<div class="row">
			<div class="col-sm-6">
				<div class="control-group">
					<label>Horário de Abertura</label>
					<div class="controls">
						<input type="time" name="horarioAbertura" class="form-control" required data-validation-required-message="Informe o Horário de Abertura" value="<?=$horarioAbertura?>">
					</div>
				</div>
			</div>

			<div class="col-sm-6">
				<div class="control-group">
					<label>Horário de Fechamento</label>
					<div class="controls">
						<input type="time" name="horarioFechamento" class="form-control" required data-validation-required-message="Informe o Horário de Fechamento" value="<?=$horarioFechamento?>">
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-6">
				<div class="control-group">
					<label>Telefone Fixo</label>
					<div class="controls">
						<input type="text" name="telefoneFixo" class="form-control" required data-validation-required-message="Informe o Telefone Fixo da Empresa" data-mask="(99)9999-9999" value="<?=$telefoneFixo?>">
					</div>
				</div>
			</div>

			<div class="col-sm-6">
				<div class="control-group">
					<label>Telefone Celular</label>
					<div class="controls">
						<input type="text" name="telefoneCel" class="form-control" required data-validation-required-message="Informe o Telefone Celular da Empresa" data-mask="(99)9999-9999?9" value="<?=$telefoneCel?>">
					</div>
				</div>
			</div>
		</div>

		
		<div class="control-group">
			<label>Sobre a Empresa</label>
			<div class="controls">
				<textarea name="sobre" class="form-control" required data-validation-required-message="Escreva um pouco sobre a empresa" rows="6"><?=$sobre;?></textarea>
			</div>
		</div>
		
		<button type="submit" class="btn btn-default">Salvar</button>

	</form>

</div>

<!-- 
<script type="text/javascript">
	$(document).ready( function() {
		$("textarea").summernote({
			
			//Definindo Linguagem a ser mostrada nos comandos
			lang : 'pt-BR',

			//Altura - Tamanho - do editor
			height : 200
		});
	})
</script>
-->