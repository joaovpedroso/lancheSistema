<?php
include "menu.html";
?>
<style>
    .promocao-ativa{
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.8);
        color: #fff;
        position: fixed;
        z-index: 999;
    }
    .btn-close{
        margin-top: 20px;
        margin-bottom: 20px;
        background: transparent;
        border: 1px solid #f2f2f2;
        border-radius: 2px;
    }
    .btn-close:hover{
        color: #fff;
        text-decoration: none;
        border: 1px solid #f2f2f2;
        border-radius: 2px;
    }
    .btn-close:focus{
        color: #fff;
        text-decoration: none;
        border: 1px solid #f2f2f2;
        border-radius: 2px;
    }
</style>

<body>
    <?php
    $sql = "SELECT * FROM promocao WHERE data_inicio <= ? AND data_fim >= ? ORDER BY RAND() LIMIT 1";
    $consulta = $pdo->prepare($sql);
    $now = data($data);
    $consulta->bindParam(1, $now);
    $consulta->bindParam(2, $now);
    $consulta->execute();
    $dadosPromo = $consulta->fetch(PDO::FETCH_OBJ);
    if( !empty($dadosPromo->id) ){
        $total = number_format($dadosPromo->total, 2, ",", ".");
        $imagem = $dadosPromo->imagem . "m.jpg";
    ?>
    <div class="promocao-ativa">
        <div class="container">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                    <button class="btn-close">x</button>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <img src="img/produtos/<?=$imagem;?>" class="img-responsive">
                </div>
                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                    <h3>Promoção do Dia</h3>
                    <p>
                        <span class="titulo"><?= $dadosPromo->titulo; ?></span><br>
                        <span>R$ <?= $total; ?></span>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
    <script>
        $('.btn-close').click(function () {
            $('.promocao-ativa').css('display', 'none');
        });
    </script>

    <!-- BANNER -->
    <div class="fullbg">
        <div class="formulario">
            <div class="content container min-heigth-100">
                <div class="top_title shaddow">
                    <h2>Lanxonets - Umuarama Paraná</h2><br>
                    <a href="#melhores" class="btn btn-warning" style="opacity: 1;">Peça Já o Seu</a>
                </div>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>

    <section id="melhores">
        <div class="col-md-12">
            <h1 class="titulo" align="center">Experimente nossas delicias</h1>
        </div>
        <div class="col-md-12">
            <p class="center">Veja o que nossos clientes mais gostam</p>
        </div>

        <div class="col-md-12">
            <?php
            $sql = "SELECT * FROM produto WHERE ativo = 1 ORDER BY quantidadeVendida LIMIT 3";
            $consulta = $pdo->prepare($sql);
            $consulta->execute();
            while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
                $imagem = $dados->imagem . "m.jpg";
                $preco = number_format($dados->preco, 2, ",", ".");
                echo "
                            <div class='col-md-4' align='center'>
                                <div class='thumbnail col-md-8 col-md-offset-2'>
                                    <div class='min-heigth'>
                                        <img src='img/produtos/$imagem' class='img-responsive'>
                                    </div>
                                    <div class='caption text-center'>
                                        <div class='titulo'>$dados->nome</div>
                                        <p class='preco'>R$ $preco</p>";
                if ($aberto == 1) {
                    echo "<a href='adicionar.php?prod=$dados->id' class='btn btn-warning'>Comprar</a>";
                } else {
                    echo "<a href='' class='btn btn-warning' disabled onclick='mensagemFuncionamento()';>Comprar</a>";
                }
                echo "  </div>
                                </div>
                            </div>";
            }
            ?>
        </div>
        <hr><br>
        <?php
        $date = date("Y-m-d");
        $sqlB = "SELECT * FROM promocao WHERE data_inicio <= ? LIMIT 1";
        $consultaB = $pdo->prepare($sqlB);
        $consultaB->bindParam(1, $date);
        $consultaB->execute();
        $dadosB = $consultaB->fetch(PDO::FETCH_OBJ);
        if (!empty($dadosB->id)) {

            echo "<div class='col-md-12'>";
            echo "<h1 class='titulo' align='center'>Promoções</h1>";
            echo "</div>";
            echo "<div class='col-md-12'>";
            $sqlD = "SELECT * FROM promocao WHERE data_inicio <= ? and data_fim >= ? LIMIT 3";
            $consultaD = $pdo->prepare($sqlD);
            $consultaD->bindParam(1, $date);
            $consultaD->bindParam(2, $date);
            $consultaD->execute();
            while ($dadosD = $consultaD->fetch(PDO::FETCH_OBJ)) {
                $id = $dadosD->id;
                $imagem = $dadosD->imagem . "m.jpg";
                $preco = $dadosD->total;
                echo "
                            <div class='col-md-4' align='center'>
                                <div class='thumbnail promo-height col-md-8 col-md-offset-2'>
                                    <div class='min-heigth'>
                                        <img src='img/produtos/$imagem' class='img-responsive img-promo'>
                                    </div>
                                    <div class='caption text-center'>
                                        <div class='titulo'>$dadosD->titulo</div>";

                $sqlP = "SELECT *, p.nome FROM promocao_produto pp 
                                                INNER JOIN produto p
                                                ON pp.id_produto = p.id 
                                                WHERE id_promocao = ?";
                $consultaP = $pdo->prepare($sqlP);
                $consultaP->bindParam(1, $id);
                $consultaP->execute();
                while ($dadosP = $consultaP->fetch(PDO::FETCH_OBJ)) {
                    echo "<span>| $dadosP->nome </span>";
                }
                echo "<div class='clearfix'></div>";
                echo "<p class='preco'>R$ $preco</p>";
//                                        if($aberto == 1){
//                                        echo "<a href='adicionar.php?prod=$dados->id' class='btn btn-warning'>Comprar</a>";
//                                        }else {
//                                            echo "<a href='' class='btn btn-warning' disabled onclick='mensagemFuncionamento()';>Comprar</a>";
//                                        }
                echo "  </div>
                                </div>
                            </div>";
            }
            echo "</div>";
        }
        ?>
        <div class="col-md-12 center">
            <a href="cardapio.php" class="btn btn-veja-mais">Veja Mais</a>
        </div>
        <div class="clearfix"></div>
    </section>
    <div id="depoimentos" class="center">
        <div class="formulario" style="padding: 5vh;">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h1 class="titulo">Localize - nos</h1>
            </div>
            <?php
            $telefoneFixo = $telefoneCel = "";

            $sql = "SELECT * FROM sobre LIMIT 1";
            $resultado = $pdo->prepare($sql);
            $resultado->execute();

            $dados = $resultado->fetch(PDO::FETCH_OBJ);
            ?>
            <div class="clearfix"></div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 depoimentos-item">
                    <div class="depoimentos-item-center">
                        <i class="fas fa-map-marker-alt"></i><br>
                        <span>Rua Amaro Tavares, 3428<span><br>
                                <span>Umuarama - PR</span>
                                </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 depoimentos-item">
                                    <div class="depoimentos-item-center">
                                        <i class="fas fa-mobile-alt"></i><br>
                                        <span><?= $dados->telefoneFixo; ?></span><br>
                                        <span><?= $dados->telefoneCel; ?></span>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 depoimentos-item">
                                    <iframe class='embed-responsive-item' src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3651.9322579379404!2d-53.28289388555388!3d-23.749794984589656!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94f2d3df719c5ad5%3A0x4c7f9692a23bfdf6!2sR.+Amaro+Tav%C3%A1res%2C+3428+-+Jardim.+Cruzeiro%2C+Umuarama+-+PR%2C+87504-575!5e0!3m2!1spt-BR!2sbr!4v1496278995141" width="100%" height="200" frameborder="0" style="border:0" allowfullscreen alt="Rua amaro tavares, 3428, Conjunto Ouro Preto, Umuarama - PR" title="Rua amaro tavares, 3428, Conjunto Ouro Preto, Umuarama - PR"></iframe>
                                </div>
                                </div>
                                <div class="clearfix"></div>
                                </div>
                                </div>
                                </body>
                                <?php
                                include "rodape.html";
                                ?>
                                <style>body{background: #fff;}</style>