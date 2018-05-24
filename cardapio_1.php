<?php
include "menu.html";
include "verificaHorario.php";
?>
<body id="cardapio">

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h1 class="cardapio-fonts cardapio-title">Cardápio</h1>
    </div>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
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
                        <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12 category text-center'>

                            <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                                <div class='row'>
                                    <img src='img/icons/burguer.png' class='img-responsive center-block'>
                                </div>
                            </div>

                            <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                                <hr class='category-hr'>
                            </div>

                            <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
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
                            <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>

                                <div class='row'>
                                    <div class='col-lg-9 col-md-9 col-sm-9 col-xs-12 category-item-name'>
                                        <a data-toggle='collapse' href='#descricao$id' aria-expanded='true' aria-controls='descricao' class='category-item-name-font-item cardapio-fonts'>
                                                
                                            <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>
                                                <i class='fas fa-chevron-down produto-down'></i>
                                            </div>
                                            <div class='col-lg-10 col-md-10 col-sm-12 col-xs-10 text-left'>
                                                <span>$produto</span>
                                            </div>
                                        </a>
                                    </div>

                                    <div class='col-lg-3 col-md-3 col-sm-3 col-xs-12 category-item-price'>
                                        <p class='cardapio-fonts category-item-name-font-item'>R$ $valor</p>
                                    </div>
                                </div>
                                
                               <div id='descricao$id' class='category-item-details collapse'>
                                    
                                    <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                                        
                                        <div class='col-lg-3 col-md-3 col-sm-3 col-xs-12 center-block'>
                                            $img
                                        </div>
                                        
                                        <div class='col-lg-9 col-md-9 col-sm-9 col-xs-12'>
                                                <p class='cardapio-fonts'>$descricao</p>
                                        </div>	
                                    </div>	

                                </div>

                                <div class='row category-item-buy text-center'>";
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
                        <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12 category text-center'>
                            <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                                <div class='row'>
                                    <img src='img/icons/drink.png' class='img-responsive center-block'>
                                </div>
                            </div>
                            
                            <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                                <hr class='category-hr'>
                            </div>

                            <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
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

                            <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>

                                <div class='row'>
                                    <div class='col-lg-9 col-md-9 col-sm-9 col-xs-12 category-item-name'>
                                        <a data-toggle='collapse' href='#descricao$id' aria-expanded='true' aria-controls='descricao' class='category-item-name-font-item cardapio-fonts'>
                                                
                                            <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>
                                                <i class='fas fa-chevron-down produto-down'></i>
                                            </div>
                                            <div class='col-lg-10 col-md-10 col-sm-12 col-xs-10 text-left'>
                                                <span>$produto</span>
                                            </div>
                                        </a>
                                    </div>

                                    <div class='col-lg-3 col-md-3 col-sm-3 col-xs-12 category-item-price'>
                                        <p class='cardapio-fonts category-item-name-font-item'>R$ $valor</p>
                                    </div>
                                </div>
                                
                               <div id='descricao$id' class='category-item-details collapse'>
                                    
                                    <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                                        
                                        <div class='col-lg-3 col-md-3 col-sm-3 col-xs-12 center-block'>
                                            $img
                                        </div>
                                        
                                        <div class='col-lg-9 col-md-9 col-sm-9 col-xs-12'>
                                                <p class='cardapio-fonts'>$descricao</p>
                                        </div>  
                                    </div>  

                                </div>

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
                        <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12 category text-center'>
                            
                            <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
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
                            <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>

                                <div class='row'>
                                    <div class='col-lg-9 col-md-9 col-sm-9 col-xs-12 category-item-name'>
                                        <a data-toggle='collapse' href='#descricao$id' aria-expanded='true' aria-controls='descricao' class='category-item-name-font-item cardapio-fonts'>
                                                
                                            <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>
                                                <i class='fas fa-chevron-down produto-down'></i>
                                            </div>
                                            <div class='col-lg-10 col-md-10 col-sm-12 col-xs-10 text-left'>
                                                <span>$produto</span>
                                            </div>
                                        </a>
                                    </div>

                                    <div class='col-lg-3 col-md-3 col-sm-3 col-xs-12 category-item-price'>
                                        <p class='cardapio-fonts category-item-name-font-item'>R$ $valor</p>
                                    </div>
                                </div>
                                
                               <div id='descricao$id' class='category-item-details collapse'>
                                    
                                    <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                                        
                                        <div class='col-lg-3 col-md-3 col-sm-3 col-xs-12 center-block'>
                                            $img
                                        </div>
                                        
                                        <div class='col-lg-9 col-md-9 col-sm-9 col-xs-12'>
                                                <p class='cardapio-fonts'>$descricao</p>
                                        </div>  
                                    </div>  

                                </div>

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