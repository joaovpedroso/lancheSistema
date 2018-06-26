<?php

require_once('../pdf/vendor/autoload.php');

use Mpdf\Mpdf;

require('../config/conecta.php');

$pdf = new Mpdf(['setAutoTopMargin' => 'stretch']);


$stylesheet = file_get_contents('../css/bootstrap.min.css');
$css = file_get_contents('../css/estilo.css');
$pdf->WriteHTML($stylesheet, 1);
$pdf->WriteHTML($css, 1);
$pdf->SetTitle('Relatório de Vendas por Data');

if (isset($_POST['data'])) {
    $data = trim($_POST["data"]);
} else {
    $data = "";
    echo "<script>history.back();</script>";
    exit;
}

$sql1 = "SELECT id FROM pedido WHERE data = ?";
$consulta1 = $pdo->prepare($sql1);
$consulta1->bindParam(1, $data);
$consulta1->execute();

$pdf->SetHTMLHeader("
    <div class='container pad-bottom-50'>
        <div class='row'>
            <div class='col-xs-1'>
                <img src='../img/logo.png' width='65' class='center-block'>
            </div>
            <div class='col-xs-6'>
                <h3 class='text-left pad-top-10 pad-bottom-15'>Relatório de Vendas</h3>
                <p class='pad-top-10'>Data: $data</p>
            </div>
        </div>
    </div>
    <table class='table table-bordered table-stripped mar-bottom-0'>
        <thead>
            <tr>
                <td class='text-center pad-10' width='15%'>Nº Pedido</td>
                <td class='text-center pad-10' width='65%'>Cliente</td>
                <td class='text-center pad-10' width='20%'>Valor</td>
            </tr>
        </thead>
    </table>");


$data = explode("-", $data);
$dia = $data[2];
$mes = $data[1];
$ano = $data[0];
$data = $dia . "/" . $mes . "/" . $ano;

while ($dados1 = $consulta1->fetch(PDO::FETCH_OBJ)) {

    $id_pedido = $dados1->id;

    $sql2 = "SELECT p.data, p.valorTotal, s.status, u.nome FROM pedido p 
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


        $html = "
            <table class='table table-bordered table-stripped mar-bottom-0'>
                <thead>
                    <tr>
                        <td class='text-center pad-10' width='15%'>$id_pedido</td>
                        <td class='text-left pad-10' width='65%'>$nomeCliente</td>
                        <td class='text-center pad-10' width='20%'>$valorTotal</td>
                    </tr>
                </thead>
            </table>";


        $pdf->WriteHTML($html, 2);
    }
}
$pdf->Output();
