<meta charset="utf-8">
<?php
	session_start();
	//Incluir arquivo de conexao com o BD
	include "../config/conecta.php";

	if ( $_POST ) {
		$tipoFuncionario = 3;
		$tipo = $usuario = $senha = "";

		if ( isset( $_POST['usuario'] ) ) {
			$usuario = trim( $_POST['usuario'] );
		}
		if ( isset( $_POST['senha'] ) ) {
			$senha = trim( $_POST['senha'] );
			$senha = md5($senha);
		}

		if( isset( $_POST['tipo'] ) ) {
			$tipo = $_POST['tipo'];
		}

		if ( empty( $usuario ) ){

			echo "<script>alert('Preencha o campo Email');history.back();</script>";

		} else if ( empty( $senha ) ) {

			echo "<script>alert('Preencha o campo Senha');history.back();</script>";

		} else if( empty( $tipo ) ) {
			echo "<script>alert('Selecione o campo Função');history.back();</script>";

		} else {

			$sql = "SELECT * FROM usuario WHERE email = ? and id_tipo = ? and ativo = 1 LIMIT 1";
			$consulta = $pdo->prepare($sql);
			//$consulta->bindParam(1, 1);
			$consulta->bindParam(1, $usuario);
			$consulta->bindParam(2, $tipo);
			//$consulta->bindParam(3, $tipoFuncionario);
			$consulta->execute();

			$dados = $consulta->fetch(PDO::FETCH_OBJ);
			

			if ( empty( $dados->id ) ) {
				//Email Incorreto ou Não Cadastrado
				echo "<script>alert('Email não encontrado');history.back();</script>";
			} else if ( $senha != $dados->senha ) {
				//senha incorreta
				echo "<script>alert('Senha incorreta');history.back();</script>";
			} else {				
				$_SESSION['admin'] = array ( 
							"id" 	=> $dados->id,
							"nome" 	=> $dados->nome,
							"email" => $dados->email,
							"tipo"  => $dados->id_tipo
							 );
				header( "Location: home.php" );
			}

		}

	}
?>