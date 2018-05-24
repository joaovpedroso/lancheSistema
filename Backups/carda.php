<?php
	include "menu.html";
	include "verificaHorario.php";
?>
<style>
    body{
        background: #4b4b4d;
    }
    .cardapio-fonts{
        color: #e1e1e3;
        font-family: Satisfy-Regular;
    }
    .cardapio-title{
        font-size: 4em;
    }
    .category {
        //border: 1px solid #e1e1e3;
        margin-top: 15px;
        padding-top: 10px;
        padding-bottom: 10px;
    }
    .category-title h1 {
        font-size: 3em;
    }
    .category-item {
        padding-top: 10px;
    }
    .category-item-name-font-item {
        font-size: 1.8em;
    }
    .category-item-buy {
        padding-top: 5px;
        padding-bottom: 15px;
    }
    .btn-buy {
        background: transparent;
        color: #e1e1e3;
        border: 1px solid #e1e1e3;
        border-radius: 4px;
        display: inline-block;
        padding: 6px 12px;
    }
</style>

<body>
    <div class="col-md-12 center">
        <h1 class="cardapio-fonts cardapio-title">Cardápio</h1>
    </div>
    
    <div class="col-md-12 container">
        
        <div class="col-md-6 category center">
            
            <div class="col-md-12 category-img" align="center">
                <img src="img/icons/burguer.png" class="img-responsive">
            </div>
            
            <div class="clearfix"></div>
            
            <hr>
            
            <div class="row category-title">
                <h1 class="cardapio-fonts">Lanches</h1>
            </div>
            
            <div class="category-item">
                
                <div class="row">
                    
                    <div class="col-md-8 category-item-name">
                        <p class="cardapio-fonts category-item-name-font-item">X-Salada</p>
                    </div>
                    
                    <div class="col-md-4 category-item-price">
                        <p class="cardapio-fonts category-item-name-font-item">R$ 9,00</p>
                    </div>
                    
                </div>
                
                <div class="row category-item-buy center">
                    <button class="btn-buy">Comprar</button>
                </div>
                
            </div> 
            <hr>
        </div>
        
        <div class="col-md-6 category">
            
            <div class="col-md-12 category-img" align="center">
                <img src="img/icons/drink.png" class="img-responsive">
            </div>
            <div class="clearfix"></div>
            <hr class="category-hr">
            <div class="row category-title center">
                <h1 class="cardapio-fonts">Bebidas</h1>
            </div>
            <div class="category-item">
                <div class="row">
                    <div class="col-md-8 category-item-name">
                        
                    </div>
                    <div class="col-md-4 category-item-price">
                        
                    </div>
                </div>
                <div class="row category-item-buy center">
                    <button class="btn-buy">Comprar</button>
                </div>
            </div>
            <hr>
        </div>
        
    </div>
    
    
    <div class="col-md-12 center">
        <h1 class="cardapio-fonts cardapio-title">Cardápio</h1>
    </div>
    
    <div class="col-md-12 container">
        <?php
        
            //Selecionar as categorias cadastradas e ativas
            $sqlCat 		= "SELECT * FROM categoria WHERE ativo = 1 ORDER BY categoria";
            $consultaCat 	= $pdo->prepare( $sqlCat );
            $consultaCat	->execute();
        
            //Receber a quantidade de categorias cadastradas
            $categoriasCadastradas = $consultaCat->rowCount();
            if ( $categoriasCadastradas == 0 ) {
                echo "
                    <div class='alert alert-danger text-center'>
                            <h3><b>Nenhum Produto Cadastrado !</b></h3>
                    </div>
                ";
            }
            
            while( $dadosCat = $consultaCat->fetch( PDO::FETCH_OBJ ) ){
                //ID da Categoria
                $idCat = $dadosCat->id;
                
                //Nome da Categoria
                $categoria = $dadosCat->categoria;
                
                //Selecionar os dados dos produtos de cada categoria
                $sqlProd 	= "SELECT * FROM produto WHERE id_categoria = ? and ativo = 1 ORDER BY nome";
                $consultaProd 	= $pdo->prepare( $sqlProd );
                $consultaProd	->bindParam(1, $idCat );
                $consultaProd 	->execute();
                
                //Verificar se a categoria é de Lanches | Bebidas Para poder indexar a imagem
                if( $categoria == "Lanches" ){
                    echo "
                        <div class='col-md-6 category center'>
                            <div class='col-md-12 category-img' align='center'>
                                <img src='img/icons/burguer.png' class='img-responsive'>
                            </div>

                            <div class='clearfix'></div>

                            <hr>

                            <div class='row category-title'>
                                <h1 class='cardapio-fonts'>$categoria</h1>
                            </div>
                    ";
                    
                    //Listar os produtos da categoria
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
                            <div class='category-item'>

                                <div class='row'>

                                    <div class='col-md-8 category-item-name'>
                                        <p class='cardapio-fonts category-item-name-font-item'>$produto</p>
                                    </div>

                                    <div class='col-md-4 category-item-price'>
                                        <p class='cardapio-fonts category-item-name-font-item'>R$ $valor</p>
                                    </div>

                                </div>

                                <div class='row category-item-buy center'>
                                    <button class='btn-buy'>Comprar</button>
                                </div>

                            </div>
                        ";
                    }
                    
                    echo "
                        <hr>
                    <!-- END col-md-6 category center-->    
                    </div>
                    ";
                    
                } else if( $categoria == "Bebidas" ){
                    
                    echo "
                        <div class='col-md-6 category center'>
                            <div class='col-md-12 category-img' align='center'>
                                <img src='img/icons/drink.png' class='img-responsive'>
                            </div>

                            <div class='clearfix'></div>

                            <hr>

                            <div class='row category-title'>
                                <h1 class='cardapio-fonts'>$categoria</h1>
                            </div>
                    ";
                    
                    //Listar os produtos da categoria
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
                            <div class='category-item'>

                                <div class='row'>

                                    <div class='col-md-8 category-item-name'>
                                        <p class='cardapio-fonts category-item-name-font-item'>$produto</p>
                                    </div>

                                    <div class='col-md-4 category-item-price'>
                                        <p class='cardapio-fonts category-item-name-font-item'>R$ $valor</p>
                                    </div>

                                </div>

                                <div class='row category-item-buy center'>
                                    <button class='btn-buy'>Comprar</button>
                                </div>

                            </div>
                        ";
                    }
                    
                    echo "
                        <hr>
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
                            -->
                            <div class='clearfix'></div>

                            <hr>

                            <div class='row category-title'>
                                <h1 class='cardapio-fonts'>$categoria</h1>
                            </div>
                        </div>
                    ";
                    
                    //Listar os produtos da categoria
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
                            <div class='category-item'>

                                <div class='row'>

                                    <div class='col-md-8 category-item-name'>
                                        <p class='cardapio-fonts category-item-name-font-item'>$produto</p>
                                    </div>

                                    <div class='col-md-4 category-item-price'>
                                        <p class='cardapio-fonts category-item-name-font-item'>R$ $valor</p>
                                    </div>

                                </div>

                                <div class='row category-item-buy center'>
                                    <button class='btn-buy'>Comprar</button>
                                </div>

                            </div>
                        ";
                    }
                    
                    echo "
                        <hr>
                    <!-- END col-md-6 category center-->    
                    </div>
                    ";
                    
                    
                }
                           
            }
            
        ?>
        
    </div>
    
</body>