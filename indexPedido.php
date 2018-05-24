<?php
include "menu.html";

$sql = "SELECT nome FROM usuario WHERE id = ? ";
$consulta = $pdo->prepare($sql);
$consulta->bindParam(1, $_SESSION["usuario"]["id"]);
$consulta->execute();
$dados = $consulta->fetch(PDO::FETCH_OBJ);
$usuario = $dados->nome;
?>
<div class="container">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mar-top-100">
        <div class="formulario pad-15">

            <div class="row pad-bottom-15">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <h2 class="text-center categoria">Bem vindo <?= $usuario; ?></h2>
                </div>
            </div>

            <!-- Navegação -->
            <div class="row pad-bottom-15">

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <a href="usuario.php?id=<?= $_SESSION["usuario"]["id"]; ?>" class="link white">
                            <div class="box text-center">
                                <span><i class="fas fa-user box-icon"></i> </span>
                                <span> Dados Cadastrais</span>
                            </div>
                        </a>

                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <a href="cardapio.php" class="link white">
                            <div class="box text-center">
                                <span><i class="fas fa-plus box-icon"></i> </span>
                                <span>Novo Pedido</span>
                            </div>
                        </a>

                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <a href="logout.php" class="link white">
                            <div class="box text-center">
                                <span><i class="fas fa-sign-out-alt box-icon"></i> </span>
                                <span>Sair</span>
                            </div>
                        </a>

                    </div>
                </div>

            </div>
            <!--Fim Navegação-->

        </div>

    </div>
</div>