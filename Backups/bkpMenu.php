<?php
	include "verificaCep.php";
	include "estiloFontes.html";

?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>LanXonetis</title>
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="css/estilo.css">
		<link rel="shortcut icon" href="arquivos/log.ico">
	</head>
	<script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
	<script type="text/javascript" src="js/bootstrap-inputmask.min.js"></script>
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>	
	<script type="text/javascript" src="js/jquery.mask.js"></script>

	<nav class="navbar navbar-default navbar-fixed-top" style="background: transparent; padding: 0.2em; height: 5em; border: 0px transparent;">
		<div class="container-fluid" >
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="index.php" style= "font: 22px Tahoma, Verdana; opacity:0.85;">
					<img src="img/logo.png" class="img-responsive logo">
				</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav" >
					<li style="margin-right: 1em; font: 18px Tahoma, Verdana"><a href="index.php">Home</a></li>
					<li style="margin-right: 1em; font: 18px Tahoma, Verdana"><a href="sobre.php">Quem Somos</a></li>
					<li style="margin-right: 1em; font: 18px Tahoma, Verdana"><a href="cardapio.php">Cardápio</a></li>
					<li style="margin-right: 1em; font: 18px Tahoma, Verdana"><a href="contato.php">Contato</a></li>
				</ul>
				<form name="login" method="POST" action="verifica.php" class="form-inline" style="margin-left: 50px;margin-top: -2px; float: right;">
					<div class="control-group">
						<div class="controls text-right">
							<label for="usuario">Usuário</label>
								<input type="text" name="usuario" class="form-control mr-sm-2" placeholder="CPF" style="width: 15em;" data-mask="999.999.999-99">
							</label>	
							<label for="senha">Senha
								<input type="password" name="senha" class="form-control mr-sm-2" style="width: 10em;">
							</label>
							<button type="submit" name="logar" class="btn btn-default" widt="10%">Entrar</button>
						</div>
					</div>	
				</form>	
					<a href="usuario.php"><p class="text-center" style="float: right;margin-top: -1em; margin-bottom: -15px; margin-left: 7em;color: black;">Cadastrar - se</p></a>
			</div>
		</div>
	</nav>		
