<?php
require_once('../pdf/vendor/autoload.php');
use Mpdf\Mpdf;
require('../config/conecta.php');

$pdf = new Mpdf(['setAutoTopMargin' => 'stretch']);


$stylesheet = file_get_contents('../css/bootstrap.min.css');
$css = file_get_contents('../css/estilo.css');
$pdf->WriteHTML($stylesheet,1);
$pdf->WriteHTML($css,1);
$pdf->SetTitle('Relatório de Produtos Nunca Vendidos');

$sql = "SELECT * FROM produto p 
        INNER JOIN categoria c ON p.id_categoria = c.id 
        WHERE NOT EXISTS ( SELECT id_produto FROM produto_pedido pp WHERE pp.id_produto = p.id )";
$consulta = $pdo->prepare($sql);
$consulta->execute();


$pdf->SetHTMLHeader("
    <div class='container pad-bottom-50'>
        <div class='row'>
            <div class='col-xs-1'>
                <img src='../img/logo.png' width='65' class='center-block'>
            </div>
            <div class='col-xs-6'>
                <h3 class='text-left pad-top-10'>Relatório de Produtos Nunca Vendidos</h3>
            </div>
        </div>
    </div>
    <table class='table table-bordered table-stripped mar-bottom-0'>
        <thead>
            <tr>
                <td class='text-center pad-10' width='55%'>Produto</td>
                <td class='text-center pad-10' width='30%'>Categoria</td>
                <td class='text-center pad-10' width='15%'>Valor</td>
            </tr>
        </thead>
    </table>");

while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
    $preco = number_format($dados->preco, 2, ",",".");
    $html = "
        <table class='table table-bordered table-stripped mar-bottom-0'>
        <tbody>
            <tr>
                <td class='text-center pad-10' width='55%'>$dados->nome</td>
                <td class='text-center pad-10' width='30%'>$dados->categoria</td>
                <td class='text-center pad-10' width='15%'>$preco</td>
            </tr>
        </tbody>
    </table>";

    
    $pdf->WriteHTML($html,2);
}
$pdf->Output();