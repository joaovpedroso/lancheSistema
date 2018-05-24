<?php
include "menu.php";
verificaPermissao();
$sql = "";
$consulta = $pdo->prepare($sql);
$consulta->execute();
?>
<div class=" container well ">
    <h1>Vendas</h1>
    <hr>
    <h4>Filtros</h4>
    <div class="row container">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 thumbnail text-center pad-15">
                <p>Filtrar Por Dia:</p>
                <form name="filterDay" action="filtrar.php?f=dt" method="POST">
                    <div class="control-group">
                        <label for="data">Selecione o Dia:</label>
                        <div class="controls">
                            <input type="date" name="data" class="form-control" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </form>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 thumbnail text-center pad-15">
                <p>Filtrar Por Cliente:</p>
                <form name="filterUser" action="filtrar.php?f=cli" method="POST">
                    <div class="control-group">
                        <label for="cliente">Selecione o Cliente:</label>
                        <div class="controls">
                            <select name="cliente" class="form-control" required>
                                <option value="">Selecione um Cliente</option>
                                <?php
                                $sql = "SELECT id,nome FROM usuario WHERE id_tipo = 2 or id_tipo = 3 ORDER BY nome";
                                $consulta = $pdo->prepare($sql);
                                $consulta->execute();

                                while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
                                    $id = $dados->id;
                                    $nome = $dados->nome;
                                    echo "<option value='$id'>$nome</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </form>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 thumbnail text-center pad-15">
                <p>Filtrar Por Produto:</p>
                <form name="filterProduct" action="filtrar.php?f=pro" method="POST">
                    <div class="control-group">
                        <label for="produto">Selecione o Produto:</label>
                        <div class="controls">
                            <select name="produto" class="form-control" required>
                                <option value="">Selecione o Produto</option>
                                <?php
                                $sql = "SELECT id, nome FROM produto ORDER BY id_categoria";
                                $consulta = $pdo->prepare($sql);
                                $consulta->execute();
                                while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
                                    $id_produto = $dados->id;
                                    $produto = $dados->nome;
                                    echo "<option value='$id_produto'>$produto</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </form>
            </div>
        </div>
    </div>
    <div class="row container">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 thumbnail text-center pad-15">
                <div class="row">
                    <br><p class="font-600">Usuários que nunca compraram</p>
                    <a href="relUsuariosPedidos.php" class="btn btn-primary">Gerar Relatório</a>
                    <br>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 thumbnail text-center pad-15">
                <div class="row">
                    <br><p class="font-600">Produtos que nunca foram vendidos</p>
                    <a href="relProdutosPedidos.php" class="btn btn-primary">Gerar Relatório</a>
                    <br>
                </div>
            </div>
            
        </div>
    </div>

    <br><hr>
