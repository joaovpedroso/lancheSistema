<?php

require_once('../pdf/vendor/autoload.php');

use Mpdf\Mpdf;

require('../config/conecta.php');

$pdf = new Mpdf(['setAutoTopMargin' => 'stretch']);


$stylesheet = file_get_contents('../css/bootstrap.min.css');
$css = file_get_contents('../css/estilo.css');
$pdf->WriteHTML($stylesheet, 1);
$pdf->WriteHTML($css, 1);

if (isset($_GET['p'])) {
    $produto = trim($_GET["p"]);
} else {
    $produto = "";
}

$sqlP = "SELECT nome FROM produto WHERE id = ? LIMIT 1";
$consultaP = $pdo->prepare($sqlP);
$consultaP->bindParam(1, $produto);
$consultaP->execute();
$produtoNome = $dadosP = $consultaP->fetch(PDO::FETCH_OBJ)->nome;


$pdf->SetHTMLHeader("<div class='row'>
        <div class='row relatorio-header'>
            
                <div class='col-lg-1 col-md-1 col-sm-1 col-xs-4 relatorio-header-item'>
                    <p>Produto</p>
                </div>
                <div class='col-lg-1 col-md-1 col-sm-1 col-xs-1 relatorio-header-item'>
                    <p>Ped.</p>
                </div>
                <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2 relatorio-header-item'>
                    <p>Data</p>
                </div>
                <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2 relatorio-header-item'>
                    <p>R$</p>
                </div>
            </div>
        </div>");


$sql1 = "SELECT id_pedido FROM produto_pedido WHERE id_produto = ? GROUP BY id_pedido";
$consulta1 = $pdo->prepare($sql1);
$consulta1->bindParam(1, $produto);
$consulta1->execute();


while ($dados1 = $consulta1->fetch(PDO::FETCH_OBJ)) {
    $id_pedido = $dados1->id_pedido;

    $sql2 = "SELECT p.valorTotal, p.data, s.status, u.nome FROM pedido p
                    INNER JOIN status s ON s.id = p.id_status 
                    INNER JOIN usuario u ON u.id = p.id_usuario
                    WHERE p.id = ? ORDER BY p.data";
    $consulta2 = $pdo->prepare($sql2);
    $consulta2->bindParam(1, $id_pedido);
    $consulta2->execute();

    while ($dados2 = $consulta2->fetch(PDO::FETCH_OBJ)) {
        $valorTotal = $dados2->valorTotal;
        $valorTotal = number_format($valorTotal, 2, ",", '.');
        $status = $dados2->status;
        $data = $dados2->data;
        $data = explode("-", $data);
        $dia = $data[2];
        $mes = $data[1];
        $ano = $data[0];
        $data = $dia . "/" . $mes . "/" . $ano;
        $nomeCliente = $dados2->nome;

        $html = "<div class='row'>
                    <div class='row relatorio-header'>
                        <div class='col-lg-2 col-md-2 col-sm-2 col-xs-4 text-center'>
                            <p>$produtoNome</p>
                        </div>
                        <div class='col-lg-2 col-md-2 col-sm-2 col-xs-1 text-center'>
                            <p>$id_pedido</p>
                        </div>
                        <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2 text-center'>
                            <p>$data</p>
                        </div>
                        <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2 text-center'>
                            <p>$valorTotal</p>
                        </div>
                </div>";
        $pdf->WriteHTML($html, 2);
    }
}

$pdf->Output();
