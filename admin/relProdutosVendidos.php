<title>Relatório de Produtos Mais Vendidos</title>
<?php

require_once('../pdf/vendor/autoload.php');

use Mpdf\Mpdf;

require('../config/conecta.php');

$pdf = new Mpdf(['setAutoTopMargin' => 'stretch']);


$stylesheet = file_get_contents('../css/bootstrap.min.css');
$css = file_get_contents('../css/estilo.css');
$pdf->WriteHTML($stylesheet, 1);
$pdf->WriteHTML($css, 1);
$pdf->SetTitle('Relatório de Produtos Mais Vendidos');

//Sql para selecao dos mais vendidos
$sql = "SELECT p.*, p.nome as produto, count(pp.quantidade) as qtdVenda, c.categoria FROM produto_pedido pp 
        INNER JOIN produto p ON pp.id_produto = p.id 
        INNER JOIN categoria c on p.id_categoria = c.id
        GROUP BY pp.id_produto ORDER BY count(pp.quantidade) desc LIMIT 5";

$consulta = $pdo->prepare($sql);
$consulta->execute();


$pdf->SetHTMLHeader("
    <div class='container pad-bottom-50'>
        <div class='row'>
            <div class='col-xs-1'>
                <img src='../img/logo.png' width='65' class='center-block'>
            </div>
            <div class='col-xs-6'>
                <h3 class='text-left pad-top-10'>Relatório de Produtos Mais Vendidos</h3>
            </div>
        </div>
    </div>
    <table class='table table-bordered table-stripped mar-bottom-0'>
        <thead>
            <tr>
                <td class='text-center pad-10' width='50%'>Produto</td>
                <td class='text-center pad-10' width='20%'>Categoria</td>
                <td class='text-center pad-10' width='15%'>Valor</td>
                <td class='text-center pad-10' width='15%'>Quantidade</td>
            </tr>
        </thead>
    </table>");

while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
    $preco = number_format($dados->preco, 2, ",", ".");
    $html = "
        <table class='table table-bordered mar-0 pad-0'>
        <tbody>
            <tr>
                <td class='text-center pad-10' width='50%'>$dados->nome</td>
                <td class='text-center pad-10' width='20%'>$dados->categoria</td>
                <td class='text-center pad-10' width='15%'>R$ $preco</td>
                <td class='text-center pad-10' width='15%'>$dados->qtdVenda</td>
            </tr>
        </tbody>
        </table>";

    $pdf->WriteHTML($html,2);
}
$pdf->Output();
