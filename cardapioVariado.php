<?php
    include "menu.html";
    include "estiloFontes.html";
    include "verificaHorario.php";
?>
<div class="container">
    <h1 class="text-center titulo">Cardápio Variado</h1>
    <hr>

        <?php
            $sqlCat 		= "SELECT * FROM categoria WHERE ativo = 1 ORDER BY categoria";
            $consultaCat 	= $pdo->prepare( $sqlCat );
            $consultaCat	->execute();

            $categoriasCadastradas = $consultaCat->rowCount();
            if ( $categoriasCadastradas == 0 ) {
                    echo "
                    <div class='alert alert-danger'>
                            <h3>Nenhum Produto Cadastrado</h3>
                    </div>
                    ";
            }

            while( $dadosCat = $consultaCat->fetch( PDO::FETCH_OBJ ) ){
                $idCat 		= $dadosCat->id;
                $categoria  = $dadosCat->categoria;

                echo "
                <div class='col-md-6'>
                        <h3 class='categoria'>$categoria</h3>
                ";

                $sqlProd 		= "SELECT * FROM produto WHERE id_categoria = ? and ativo = 1 ORDER BY nome";
                $consultaProd 	= $pdo->prepare( $sqlProd );
                $consultaProd	->bindParam(1, $idCat );
                $consultaProd 	->execute();

                while( $dadosProd = $consultaProd->fetch( PDO::FETCH_OBJ ) ) {
                    $id 		= $dadosProd->id;
                    $produto 	= $dadosProd->nome;
                    $valor 		= $dadosProd->preco;
                    $valor 		= number_format($valor, 2, ",",".");
                    $descricao  = $dadosProd->descricao;
                    $imagem		= $dadosProd->imagem;

                    $imagem 	= $imagem."p.jpg";
                    $img 		= "<img src= 'img/produtos/$imagem' width='100px' class='img-responsive'>";

                    echo "
                    <div class='col-md-8'>
                        <a data-toggle='collapse' href='#descricao$id' aria-expanded='true' aria-controls='descricao'>
                                <h4 class='fonteNome'>$produto</h4>
                        </a>
                        <div id='descricao$id' class='fonte collapse '>
                            <div class='row'>
                                <div class='col-md-4'>
                                        $img
                                </div>
                                <div class='col-md-8'>
                                        $descricao
                                </div>	
                            </div>	
                        </div>
                    </div>
                    <div class='col-md-4 text-center'>";
                        if( $aberto == 1 ){
                            echo "<a href='adicionar.php?prod=$id' class='btn btn-default'>Comprar</a>";
                        } else {
                            echo "<a href='' class='btn btn-default' disabled onclick='mensagemFuncionamento();'>Comprar</a>";
                        }
                        echo "
                    </div>";
                }
                echo "</div>";
            }
	?>
	<div class="clearfix"></div>
</div>