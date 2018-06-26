<?php

require_once('../pdf/vendor/autoload.php');
use Mpdf\Mpdf;
require('../config/conecta.php');

$pdf = new Mpdf(['setAutoTopMargin' => 'stretch']);


$stylesheet = file_get_contents('../css/bootstrap.min.css');
$css = file_get_contents('../css/estilo.css');
$pdf->WriteHTML($stylesheet,1);
$pdf->WriteHTML($css,1);
$pdf->SetTitle('Relatório de Produtos Cadastrados');

$sql = "SELECT p.id, p.nome, p.descricao, p.preco, c.categoria FROM produto p 
	INNER JOIN categoria c ON p.id_categoria = c.id ORDER BY p.nome";
$consulta = $pdo->prepare($sql);
$consulta->execute();

$pdf->SetHTMLHeader("
    <div class='container pad-bottom-50'>
        <div class='row'>
            <div class='col-xs-1'>
                <img src='../img/logo.png' width='65' class='center-block'>
            </div>
            <div class='col-xs-6'>
                <h3 class='text-left pad-top-20 pad-bottom-15'>Relatório de Produtos Cadastrados</h3>
            </div>
        </div>
    </div>
    <table class='table table-bordered table-stripped mar-bottom-0'>
        <thead>
            <tr>
                <td class='text-center pad-10' width='45%'>Produto</td>
                <td class='text-center pad-10' width='35%'>Categoria</td>
                <td class='text-center pad-10' width='20%'>Valor</td>
            </tr>
        </thead>
    </table>");

while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
    $preco = number_format($dados->preco,2, ',','.');
    $html = "
        <table class='table table-bordered table-stripped mar-bottom-0'>
        <thead>
            <tr>
                <td class='text-center pad-10' width='45%'>$dados->nome</td>
                <td class='text-center pad-10' width='35%'>$dados->categoria</td>
                <td class='text-center pad-10' width='20%'>R$ $preco</td>
            </tr>
        </thead>
    </table>";

    
    $pdf->WriteHTML($html,2);
}
$pdf->Output();