<?php
include "menu.php";
include "../verificaHorario.php";
?>
<body id="cardapio">

    <div class="col-md-12 center">
        <h1 class="cardapio-fonts cardapio-title">Cardápio</h1>
    </div>

    <div class="col-md-12 container">
        <?php
        //Selecionar as categorias cadastradas e ativas
        $sqlCat = "SELECT * FROM categoria WHERE ativo = 1 ORDER BY categoria";
        $consultaCat = $pdo->prepare($sqlCat);
        $consultaCat->execute();

        //Receber a quantidade de categorias cadastradas
        $categoriasCadastradas = $consultaCat->rowCount();
        if ($categoriasCadastradas == 0) {
            echo "
                    <div class='alert alert-danger text-center'>
                            <h3><b>Nenhum Produto Cadastrado !</b></h3>
                    </div>
                ";
        }

        while ($dadosCat = $consultaCat->fetch(PDO::FETCH_OBJ)) {
            //ID da Categoria
            $idCat = $dadosCat->id;

            //Nome da Categoria
            $categoria = $dadosCat->categoria;

            //Selecionar os dados dos produtos de cada categoria
            $sqlProd = "SELECT * FROM produto WHERE id_categoria = ? and ativo = 1 ORDER BY nome";
            $consultaProd = $pdo->prepare($sqlProd);
            $consultaProd->bindParam(1, $idCat);
            $consultaProd->execute();

            //Verificar se a categoria é de Lanches | Bebidas Para poder indexar a imagem
            if ($categoria == "Lanches") {
                echo "
                        <div class='col-md-6 category center'>
                            <div class='col-md-12 category-img' align='center'>
                                <img src='../img/icons/burguer.png' class='img-responsive'>
                            </div>

                            <div class='clearfix'></div>

                            <hr class='category-hr'>

                            <div class='row category-title'>
                                <h1 class='cardapio-fonts'>$categoria</h1>
                            </div>
                    ";

                //Listar os produtos da categoria
                while ($dadosProd = $consultaProd->fetch(PDO::FETCH_OBJ)) {
                    $id = $dadosProd->id;
                    $produto = $dadosProd->nome;
                    $valor = $dadosProd->preco;
                    $valor = number_format($valor, 2, ",", ".");
                    $descricao = $dadosProd->descricao;
                    $imagem = $dadosProd->imagem;

                    $imagem = $imagem . "p.jpg";
                    $img = "<img src= '../img/produtos/$imagem' class='img-responsive'>";

                    echo "
                            <div class='category-item'>

                                <div class='row'>

                                    <div class='col-md-8 category-item-name'>
                                        <a data-toggle='collapse' href='#descricao$id' aria-expanded='true' aria-controls='descricao'>
                                            <p class='cardapio-fonts category-item-name-font-item'>
                                                <i class='fas fa-chevron-down produto-down'></i>$produto
                                            </p>
                                        </a>
                                    </div>

                                    <div class='col-md-4 category-item-price'>
                                        <p class='cardapio-fonts category-item-name-font-item'>R$ $valor</p>
                                    </div>

                                </div>
                                
                                <div id='descricao$id' class='category-item-details col-md-8 col-md-offset-2 collapse' align='center'>
                                    <div class='row'>
                                        <div class='col-md-4'>
                                                $img
                                        </div>
                                        <div class='col-md-8'>
                                                <p class='cardapio-fonts'>$descricao</p>
                                        </div>	
                                    </div>	
                                </div>
                                <div class='clearfix'></div>

                                <div class='row category-item-buy center'>";
                    if ($aberto == 1) {
                        echo "<a href='adicionar.php?prod=$id' class='btn-buy'>Comprar</a>";
                    } else {
                        echo "<a href='' class='btn-buy btn-buy-disabled' disabled onclick='mensagemFuncionamento();'>Comprar</a>";
                    }
                    echo "
                                </div>

                            </div>
                        ";
                }

                echo "
                       
                    <!-- END col-md-6 category center-->    
                    </div>
                    ";
            } else if ($categoria == "Bebidas") {

                echo "
                        <div class='col-md-6 category center'>
                            <div class='col-md-12 category-img' align='center'>
                                <img src='../img/icons/drink.png' class='img-responsive'>
                            </div>

                            <div class='clearfix'></div>

                            <hr class='category-hr'>

                            <div class='row category-title'>
                                <h1 class='cardapio-fonts'>$categoria</h1>
                            </div>
                    ";

                //Listar os produtos da categoria
                while ($dadosProd = $consultaProd->fetch(PDO::FETCH_OBJ)) {
                    $id = $dadosProd->id;
                    $produto = $dadosProd->nome;
                    $valor = $dadosProd->preco;
                    $valor = number_format($valor, 2, ",", ".");
                    $descricao = $dadosProd->descricao;
                    $imagem = $dadosProd->imagem;

                    $imagem = $imagem . "p.jpg";
                    $img = "<img src= 'img/produtos/$imagem' class='img-responsive'>";

                    echo "
                            <div class='category-item'>

                                <div class='row'>

                                    <div class='col-md-8 category-item-name'>
                                        <a data-toggle='collapse' href='#descricao$id' aria-expanded='true' aria-controls='descricao'>
                                            <p class='cardapio-fonts category-item-name-font-item'>
                                                <i class='fas fa-chevron-down produto-down'></i>$produto
                                            </p>
                                        </a>
                                    </div>

                                    <div class='col-md-4 category-item-price'>
                                        <p class='cardapio-fonts category-item-name-font-item'>R$ $valor</p>
                                    </div>

                                </div>
                                
                                <div id='descricao$id' class='category-item-details col-md-8 col-md-offset-2 collapse' align='center'>
                                    <div class='row'>
                                        <div class='col-md-4'>
                                                $img
                                        </div>
                                        <div class='col-md-8'>
                                                <p class='cardapio-fonts'>$descricao</p>
                                        </div>	
                                    </div>	
                                </div>
                                <div class='clearfix'></div>

                                <div class='row category-item-buy center'>";
                    if ($aberto == 1) {
                        echo "<a href='adicionar.php?prod=$id' class='btn-buy'>Comprar</a>";
                    } else {
                        echo "<a href='' class='btn-buy btn-buy-disabled' disabled onclick='mensagemFuncionamento();'>Comprar</a>";
                    }
                    echo "
                                </div>

                            </div>
                        ";
                }

                echo "
                        
                    <!-- END col-md-6 category center-->    
                    </div>
                    ";
            } else {

                echo "
                        <div class='col-md-6 category center'>
                            <!-- 
                            <div class='col-md-12 category-img' align='center'>
                                <img src='img/icons/drink.png' class='img-responsive'>
                            </div>

                            <div class='clearfix'></div>

                            <hr class='category-hr'>
                            -->

                            <div class='row category-title'>
                                <h1 class='cardapio-fonts'>$categoria</h1>
                            </div>
                    ";

                //Listar os produtos da categoria
                while ($dadosProd = $consultaProd->fetch(PDO::FETCH_OBJ)) {
                    $id = $dadosProd->id;
                    $produto = $dadosProd->nome;
                    $valor = $dadosProd->preco;
                    $valor = number_format($valor, 2, ",", ".");
                    $descricao = $dadosProd->descricao;
                    $imagem = $dadosProd->imagem;

                    $imagem = $imagem . "p.jpg";
                    $img = "<img src= '../img/produtos/$imagem' class='img-responsive'>";

                    echo "
                            <div class='category-item'>

                                <div class='row'>

                                    <div class='col-md-8 category-item-name'>
                                        <a data-toggle='collapse' href='#descricao$id' aria-expanded='true' aria-controls='descricao'>
                                            <p class='cardapio-fonts category-item-name-font-item'>
                                                <i class='glyphicon glyphicon-resize-vertical'></i>$produto
                                            </p>
                                        </a>
                                    </div>

                                    <div class='col-md-4 category-item-price'>
                                        <p class='cardapio-fonts category-item-name-font-item'>R$ $valor</p>
                                    </div>

                                </div>
                                
                                <div id='descricao$id' class='category-item-details col-md-8 col-md-offset-2 collapse' align='center'>
                                    <div class='row'>
                                        <div class='col-md-4'>
                                                $img
                                        </div>
                                        <div class='col-md-8'>
                                                <p class='cardapio-fonts'>$descricao</p>
                                        </div>	
                                    </div>	
                                </div>
                                <div class='clearfix'></div>

                                <div class='row category-item-buy center'>";
                    if ($aberto == 1) {
                        echo "<a href='adicionar.php?prod=$id' class='btn-buy'>Comprar</a>";
                    } else {
                        echo "<a href='' class='btn-buy btn-buy-disabled' disabled onclick='mensagemFuncionamento();'>Comprar</a>";
                    }
                    echo "
                                </div>

                            </div>
                        ";
                }

                echo "
                       
                    <!-- END col-md-6 category center-->    
                    </div>
                    ";
            }
        }
        ?>
    </div>
</body>