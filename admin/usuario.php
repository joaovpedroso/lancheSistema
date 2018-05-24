<?php
	include "menu.php";
        verificaPermissao();

	$id = $nome = $cpf = $rg = $email = $senha = $telefone = $cep = $endereco = $numero = $cidade = $ativo = "";

	if( isset( $_GET['id'] ) ) {
		$id = trim( $_GET['id'] );

		$sql = "SELECT nome, senha, telefone, email, cpf, rg, endereco, cep, numero, cidade, ativo FROM usuario WHERE id = ? LIMIT 1";
		$consulta = $pdo->prepare($sql);
		$consulta->bindParam(1, $id);
		$consulta->execute();

		$dados = $consulta->fetch( PDO::FETCH_OBJ );
		$id = $dados->id;
                $nome = $dados->nome;
		$cpf 		= $dados->cpf;
		$rg 		= $dados->rg;
		$email 		= $dados->email;
		$senha 		= $dados->senha;
		$telefone 	= $dados->telefone;
		$cep 		= $dados->cep;
		$endereco 	= $dados->endereco;
		$numero 	= $dados->numero;
		$cidade 	= $dados->cidade;
		$ativo 		= $dados->ativo;

	}

?>


	<div class="container well">
		<h1>Cadastro de Usuario</h1>


		<a href="usuario.php" 
		class="btn btn-default pull-right">
			<i class="glyphicon glyphicon-file"></i>
			Novo Cadastro
		</a>
		<a href="listarUsuario.php" 
		class="btn btn-default pull-right">
			<i class="glyphicon glyphicon-search"></i> Listar Cadastros
		</a>

		<div class="clearfix"></div>

		<form name="cadastrarUsuario" method="POST" action="salvarUsuario.php">
			<div class="col-md-12">
				<label for="id">ID:</label>
				<input type="text" name="id" value="<?= $id; ?>" class="form-control" readonly>
			</div>

			<div class="col-md-12">
				<label for="nome">Nome:</label>
				<input type="text" name="nome" class="form-control" placeholder="Digite seu nome" value="<?=$nome?>" required>
			</div>

			<div class="col-md-6">
				<label for="cpf">CPF:</label>
				<input type="text" name="cpf" placeholder="Informe seu CPF" class="form-control cpf" value="<?=$cpf?>" required maxlenght="13" data-mask="999.999.999-99">
			</div>	
			<div class="col-md-6">
				<label for="rg">RG:</label>
				<input type="text" name="rg" placeholder="Informe seu RG" class="form-control rg" value="<?=$rg?>" required data-mask="99.999.999-9">
			</div>	

			<div class="col-md-6">
				<label for="email">E-mail:</label>
				<input type="email" name="email" class="form-control" placeholder="Informe seu E-mail" value="<?=$email?>" required maxlenght="80">
			</div>


			<div class="col-md-6">
				<label for="senha">Senha:</label>
				<input type="password" name="senha" id="senha" class="form-control" placeholder="Informe uma senha" required maxlenght="12">
			</div>

			<div class="col-md-6">
				<div class="control-group">
					<label for="senha">Re-Digite a Senha:</label>
					<div class="controls">
						<input type="password" name="senha" class="form-control" placeholder="Informe uma senha" required maxlenght="12" minlength="8" data-validation-minlength-message="Informe pelo menos 8 caracteres" data-validation-required-message="Informe sua senha" data-validation-match-match="senha" data-validation-match-message="As senhas digitadas são diferentes">
					</div>	
				</div>	
			</div>

			<div class="col-md-6">
				<label for="telefone">Telefone:</label>
				<input type="text" name="telefone" class="form-control" placeholder="Informe um telefone para contato" value="<?=$telefone?>" required maxlenght="12"  data-mask="(99) 9999-9999?9">
			</div>

			<div class="col-md-6">
				<label for="cep">CEP:</label>
				<input type="text" name="cep" id="cep" class="form-control cep" placeholder="Informe seu CEP" value="<?=$cep?>" onblur="pesquisacep(this.value);" required maxlenght="9">
			</div>


			<div class="col-md-6">
				<label for="endereco">Endereço:</label>
				<input type="text" name="endereco" id="endereco" class="form-control" value="<?=$endereco?>" required>
			</div>


			<div class="col-md-1">
				<label for="numero">Numero</label>
				<input type="text" name="numero" class="form-control" value="<?=$numero?>" required maxlenght="6">
			</div>

			<div class="col-md-2">
				<label for="cidade">Cidade:</label>
				<input type="text" name="cidade" id="cidade" class="form-control" value="<?=$cidade?>" required>
			</div>

			<div class="col-md-3">
				<label for="ativo">Status</label>
				<select name="ativo" id="ativo"class="form-control">
					<option value="">Selecione uma Opção</option>
					<option value="1">Ativo</option>
					<option value="0">Inativo</option>
				</select>
			</div>

			<script type="text/javascript">
				<?php
					if( $ativo == 0 ) {
				?>
						$("#ativo").val("<?=$ativo;?>");
				<?php	
					} else {
				?>
						$("#ativo").val("<?=$ativo;?>");
				<?php	
					}
				?>
			</script>

			<div class="col-md-4">
				<br>
				<button type="submit" class="btn"><i class="glyphicon glyphicon-floppy-save"> Salvar</i></button>
			</div>	
		</form>
	</div>