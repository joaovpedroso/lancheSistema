<?php

require_once('../pdf/vendor/autoload.php');
use Mpdf\Mpdf;
require('../config/conecta.php');

$pdf = new Mpdf(['setAutoTopMargin' => 'stretch']);


$stylesheet = file_get_contents('../css/bootstrap.min.css');
$css = file_get_contents('../css/estilo.css');
$pdf->WriteHTML($stylesheet,1);
$pdf->WriteHTML($css,1);

$sql = "SELECT p.id, p.nome, p.descricao, p.preco, c.categoria FROM produto p 
	INNER JOIN categoria c ON p.id_categoria = c.id ORDER BY p.nome";
$consulta = $pdo->prepare($sql);
$consulta->execute();


$pdf->SetHTMLHeader("<div class='row impressao'>
        <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12 relatorio-header'>
            
            <div class='col-lg-3 col-md-3 col-sm-3 col-xs-5 relatorio-header-item'>
                <p>Produto</p>
            </div>
            <div class='col-lg-3 col-md-3 col-sm-3 col-xs-2 relatorio-header-item'>
                <p>Valor</p>
            </div>
            <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3 relatorio-header-item'>
                <p>Categoria</p>
            </div>
        </div>");

while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
    $preco = number_format($dados->preco,2, ',','.');
    $html = "
        <div class='row relatorio-header'>
            <div class='col-lg-5 col-md-5 col-sm-5 col-xs-5 text-center'>
                <p>$dados->nome</p>
            </div>
            <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2 text-center'>
                <p>R$ $preco</p>
            </div>
            <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3 text-center'>
                <p>$dados->categoria</p>
            </div>
        </div>
    </div>";

    
    $pdf->WriteHTML($html,2);
}
$pdf->Output();