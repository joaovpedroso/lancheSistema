<?php
require_once 'menu.php';

if (isset($_POST['data'])) {
    $data = trim($_POST['data']);

    if (empty($data)) {
        echo "<script>alert('Informe uma Data Para Continuar'); history.back();</script>";
    } else {
        $dataD = $data;
        $dataD = explode("-", $dataD);
        $dia = $dataD[2];
        $mes = $dataD[1];
        $ano = $dataD[0];
        $dataD = $dia . "/" . $mes . "/" . $ano;

        $sql = "
            SELECT 
                p.id as pedidoID, date_format(p.data, '%d/%m/%Y') as data, p.valorTotal,
                pro.nome, 
                u.nome as cliente,
                fe.entrega as entrega,
                st.status as status
                FROM pedido p 
                INNER JOIN produto_pedido pp on pp.id_pedido = p.id
                INNER JOIN produto pro ON pp.id_produto = pro.id
                INNER JOIN usuario u ON p.id_usuario = u.id
                INNER JOIN forma_entrega fe ON p.id_entrega = fe.id
                INNER JOIN status st ON p.id_status = st.id
            WHERE p.data = ? 
            GROUP BY p.id
            ORDER BY p.id
        ";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(1, $data);
        $consulta->execute();
    }
} else {
    echo "<script>alert('Informe uma Data Para Continuar'); history.back();</script>";
    exit;
}
?>
<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">
<div class="container">
    <div class="well">
        <form action="vendaDataPDF.php" method="POST">
            <input type="hidden" name="data" value="<?=$data;?>">
            <button type="submit" class="btn btn-success" target="_blank">Gerar PDF</button>
        </form>
        <div class="clearfix"></div>
        <table id="example" class="display nowrap" style="width:100%">
            <thead>
                <tr>
                    <th data-priority="1">Nº Pedido</th>
                    <th data-priority="1">Cliente</th>
                    <th>Data</th>
                    <th>Valor Total</th>
                    <th>Status</th>
                    <th>Visualizar</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) { ?>
                    <tr>
                        <td><?= $dados->pedidoID ?></td>
                        <td><?= $dados->cliente ?></td>
                        <td><?= $dados->data ?></td>
                        <td><?= number_format($dados->valorTotal, 2, ",", "."); ?></td>
                        <td><?= $dados->status ?></td>
                        <td>
                            <button type='button' class='btn btn-primary btn-lg' data-toggle='modal' data-target='#modal<?= $dados->pedidoID ?>'>
                                <i class="fas fa-search"></i>
                            </button>
                        </td>
                <div class="modal fade" id="modal<?= $dados->pedidoID ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <div class="row">
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                        <h4 class="modal-title" id="myModalLabel">Pedido: <?= $dados->pedidoID ?></h4> 
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        Data: <?= $dados->data ?>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                        Cliente: <?= $dados->cliente ?>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        Status: <?= $dados->status ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <hr>
                                        <h4 class="text-center">Produtos:</h4>
                                        <br>
                                        <div class="col-lg-6 col-md-6 col-sm-12 hidden-xs text-left">Produto</div>
                                        <div class="col-lg-3 col-md-3 col-sm-6 hidden-xs text-left">Categoria</div>
                                        <div class="col-lg-3 col-md-3 col-sm-6 hidden-xs text-left">Valor</div>
                                        <hr>
                                    </div>
                                    <?php
                                    $sqlProdutos = "
                                        SELECT p.nome, p.preco, c.categoria 
                                        FROM produto_pedido pp 
                                        INNER JOIN produto p ON pp.id_produto = p.id
                                        INNER JOIN categoria c ON p.id_categoria = c.id
                                        WHERE id_pedido = ?";
                                    $consultaProdutos = $pdo->prepare($sqlProdutos);
                                    $consultaProdutos->bindParam(1, $dados->pedidoID);
                                    $consultaProdutos->execute();
                                    while ($dadosProdutos = $consultaProdutos->fetch(PDO::FETCH_OBJ)) {
                                        ?>
                                        <div class="">
                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-left">
        <?= $dadosProdutos->nome; ?>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <?= $dadosProdutos->categoria; ?>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <?= number_format($dadosProdutos->preco, 2, ",", "."); ?>
                                            </div>
                                            <div class="clearfix"></div>
                                            <hr>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                            </div>
                        </div>
                    </div>
                </div>
                </tr>
<?php } ?>
            </tbody>
        </table>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script>
    $(document).ready(function () {
        $('#example').DataTable({
            responsive: true,
            "language": {
                //Quantidade de Itens por pagina
                "lengthMenu": "Mostrando _MENU_ registros por página",
                //Quando não há dados para listar
                "zeroRecords": "Nenhum resultado encontrado",
                //Qual pagina está mostrando
                "info": "Mostrando _PAGE_ de _PAGES_",
                //QUando não a paginas para mostrar
                "infoEmpty": "Nenhum resultado encontrado",
                //Quantos valores encontrados na busca
                "infoFiltered": "(Encontrado de um total de _MAX_ registros)",
                //Label do campo de busca
                "search": "Buscar:",
                //Botões de Paginação
                "paginate": {
                    //Anterior
                    "previous": "Anterior",
                    //Próxima
                    "next": "Proxima"
                }
            }
        });
    });
</script>