<?php
	//iniciar a sessao
	session_start();
	//apagar os dados da sessao
	unset( $_SESSION["usuario"] );
	//direcionar para o index.php
	header( "Location: pedidos.php" );