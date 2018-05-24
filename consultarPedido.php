<?php include "menu.html"; ?>

<?php
    $data = "";

    if (isset($_GET['data'])) {

        $id = $_SESSION['usuario']['id'];

        $data = trim($_GET['data']);

        if( empty($data) ){
            $erro = "<h3 class='alert alert-danger text-center'><b>Nenhuma data Informada</b></h3>";
        }else {
            $erro = "";   
        }
    } else {
        $erro = "<h3 class='alert alert-danger text-center'><b>Nenhuma data Informada</b></h3>";
    }

    $sql = "SELECT p.id, e.entrega, s.status, pag.pagamento, p.data, p.valorTotal FROM pedido p 
            INNER JOIN forma_entrega e ON ( e.id = p.id_entrega )
            INNER JOIN status s ON ( s.id = p.id_status )
            INNER JOIN pagamento pag ON ( pag.id = p.id_pagamento )
            WHERE p.data = ? and p.id_usuario = ? ORDER BY p.data ";
    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(1, $data);
    $consulta->bindParam(2, $id_user);
    $consulta->execute();
?>


<div class="container well formulario mar-top-100">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

        <div class="row">
            <form name="consulta" method="get" class="form-inline">
                <label class="control-label white"><b>Data do pedido:</b></label>
                <input type="date" name="data" class="form-control" id="calendario">
                <button class="btn btn-default" type="submit">Pesquisar</button><br>
            </form>
        </div>

        <div class="row">

            <h1 class="titulo text-center">Pedidos do dia</h1>
            <?= $erro; ?>


            <!-- Listagem de Produtos -->
            <?php
            while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
                $id = $dados->id;
                $data = $dados->data;
                $data = explode("-", $data);
                $dia = $data[2];
                $mes = $data[1];
                $ano = $data[0];
                $data = $dia . "/" . $mes . "/" . $ano;
                $status = $dados->status;
                $pagamento = $dados->pagamento;
                $valorTotal = $dados->valorTotal;
                $valorTotal = number_format($valorTotal, 2, ",", ".");
                $cliente = $_SESSION['usuario']['nome'];
                ?>
                <div class='col-md-4'>
                    <div class='panel'>
                        <h3 class='text-center'>Pedido</h3>
                        <div class='panel-heading'>
                            <div class='col-sm-7'>
                                <p>Nº <?=$id;?> / <?=$cliente;?> </p>
                                <br>
                            </div>
                        </div>
                        <div class='panel-body'>
                            <table class='table table-responsive'>
                                <tr>
                                    <td><b>Quantidade</b></td>
                                    <td><b>Produto</b></td>
                                </tr>
                <?php
                $sql3 = "SELECT p.valorTotal, pr.nome, pp.quantidade FROM pedido p
				INNER JOIN produto_pedido pp ON pp.id_pedido = p.id
				INNER JOIN produto pr ON pr.id = pp.id_produto WHERE p.id_usuario = ? AND p.id = ?";
                $consulta3 = $pdo->prepare($sql3);
                $consulta3->bindParam(1, $id_user);
                $consulta3->bindParam(2, $id);
                $consulta3->execute();
                while ($dados3 = $consulta3->fetch(PDO::FETCH_OBJ)) {
                    $produto = $dados3->nome;
                    $quantidade = $dados3->quantidade;
                ?>
                                <tr>
                                    <td class='text-center'><?=$quantidade;?></td>
                                    <td><?=$produto;?></td>
                                </tr>
                <?php
                }

                $sql4 = "SELECT p.valorTotal, p.data, e.entrega, pg.pagamento, p.observacao, p.troco FROM pedido p
						INNER JOIN forma_entrega e ON e.id = p.id_entrega
						INNER JOIN pagamento pg ON pg.id = p.id_pagamento WHERE p.id = ?";
                $consulta4 = $pdo->prepare($sql4);
                $consulta4->bindParam(1, $id);
                $consulta4->execute();
                $dados4 = $consulta4->fetch(PDO::FETCH_OBJ);
                $observacao = $dados4->observacao;
                $troco = $dados4->troco;
                $troco = number_format($troco, 2, ',', '.');
                $forma_entrega = $dados4->entrega;
                $pagamento = $dados4->pagamento;
                $data = $dados4->data;
                $data = explode("-", $data);
                $dia = $data[2];
                $mes = $data[1];
                $ano = $data[0];
                $data = $dia . "/" . $mes . "/" . $ano;

                $valorTotal = $dados4->valorTotal;
                $valorTotal = number_format($valorTotal, 2, ',', '.');
                ?>
                            </table>
                            <p><b>Observações:</b><?=$observacao;?></p>
                            <p><b>Forma de Entrega:</b> <?=$forma_entrega;?></p>
                            <p><b>Status:</b> <?=$status;?></p>
                            <p><b>Pagamento:</b> <?=$pagamento;?></p>
                            <p><b>Troco:</b> R$ <?=$troco;?></p>
                            <p><b>Data do Pedido:</b> <?=$data;?></p>
                            <p><b>Valor Total:</b> R$ <?=$valorTotal;?></p>
                        </div>
                    </div>
		</div>
            <?php
            }
            ?>
            <!-- Fim Listagem de Produtos -->

        </div>

    </div>
</div>