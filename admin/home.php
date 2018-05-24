<?php
include "menu.php";
include "estiloFontesAdmin.html";

$sql = "SELECT count(*) as total FROM usuario";
$consulta = $pdo->prepare($sql);
$consulta->execute();
$totalUsuarios = $dados = $consulta->fetch(PDO::FETCH_OBJ)->total;

$sqlPedidos = "SELECT count(*) as total FROM pedido";
$consultaPedidos = $pdo->prepare($sqlPedidos);
$consultaPedidos->execute();
$totalPedidos = $dados = $consultaPedidos->fetch(PDO::FETCH_OBJ)->total;

$sqlProdutos = "SELECT count(*) as total FROM produto";
$consultaProdutos = $pdo->prepare($sqlProdutos);
$consultaProdutos->execute();
$totalProdutos = $dados = $consultaProdutos->fetch(PDO::FETCH_OBJ)->total;
?>
    <div class="container">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mar-top-100">

            <div class="formulario pad-15">

                <div class="row pad-bottom-15">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <h1 class="text-center categoria">Bem Vindo(a) <?= $_SESSION["admin"]["nome"]; ?></h1>
                    </div>
                </div>


                <!-- Navegação -->
                <div class="row pad-bottom-15">

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <a href="listarCliente.php" class="link white">
                                <div class="box text-center">
                                    <span><i class="fas fa-user box-icon"></i> </span>
                                    <span> <span class="stats"><?=$totalUsuarios?></span> Clientes Cadastrados</span>
                                </div>
                            </a>

                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <a href="listarPedido.php" class="link white">
                                <div class="box text-center">
                                    <span><i class="fas fa-align-justify box-icon"></i> </span>
                                    <span> <span class="stats"><?=$totalPedidos?></span> Pedidos já realizados</span>
                                </div>
                            </a>

                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <a href="listarProduto.php" class="link white">
                                <div class="box text-center">
                                    <span><i class="fas fa-boxes box-icon"></i> </span>
                                    <span> <span class="stats"><?=$totalProdutos?></span> Produtos Cadastrados</span>
                                </div>
                            </a>

                        </div>

                    </div>

                </div>
                <!--Fim Navegação-->

                <div class="row pad-bottom-15">

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                        <div class="data">
                            <?= "Data: " . $data . " Hora: " . $hora; ?>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>

</body>
</html>