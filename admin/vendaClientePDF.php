<?php

require_once('../pdf/vendor/autoload.php');

use Mpdf\Mpdf;

require('../config/conecta.php');

$pdf = new Mpdf(['setAutoTopMargin' => 'stretch']);


$stylesheet = file_get_contents('../css/bootstrap.min.css');
$css = file_get_contents('../css/estilo.css');
$pdf->WriteHTML($stylesheet, 1);
$pdf->WriteHTML($css, 1);
$pdf->SetTitle('Relatório de Vendas por Cliente');

if (isset($_GET['c'])) {
    $cliente = trim($_GET["c"]);
} else {
    $cliente = "";
}

$sqlU = "SELECT nome FROM usuario WHERE id = ?";
$consultaU = $pdo->prepare($sqlU);
$consultaU->bindParam(1, $cliente);
$consultaU->execute();
$dadosU = $consultaU->fetch(PDO::FETCH_OBJ);
$nomeCliente = $dadosU->nome;

//Selecionar COMPRAS com o Cliente Informado
$sql1 = "SELECT id,data FROM pedido WHERE id_usuario = ?";
$consulta1 = $pdo->prepare($sql1);
$consulta1->bindParam(1, $cliente);
$consulta1->execute();

$pdf->SetHTMLHeader("
    <div class='container pad-bottom-50'>
        <div class='row'>
            <div class='col-xs-1'>
                <img src='../img/logo.png' width='65' class='center-block'>
            </div>
            <div class='col-xs-6'>
                <h3 class='text-left pad-top-10 pad-bottom-15'>Relatório de Vendas</h3>
                <p class='pad-top-10'>Cliente: $nomeCliente</p>
            </div>
        </div>
    </div>
    <table class='table table-bordered table-stripped mar-bottom-0'>
        <thead>
            <tr>
                <td class='text-center pad-10' width='15%'>Nº Pedido</td>
                <td class='text-center pad-10' width='50%'>Cliente</td>
                <td class='text-center pad-10' width='15%'>Data</td>
                <td class='text-center pad-10' width='20%'>Valor</td>
            </tr>
        </thead>
    </table>");


while ($dados1 = $consulta1->fetch(PDO::FETCH_OBJ)) {

    $id = $dados1->id;

    $data = date("d-m-Y");
    $data = explode("-", $data);
    $mes = $data[1];
    $ano = $data[2];

    $data = $ano . "-" . $mes . "-%";

    $sql2 = "SELECT p.valorTotal,p.data, s.status FROM pedido p 
        INNER JOIN status s ON s.id = p.id_status 
        WHERE p.id = ? ORDER BY p.data";
    $consulta2 = $pdo->prepare($sql2);
    $consulta2->bindParam(1, $id);
    //$consulta2->bindParam(2, $data);
    $consulta2->execute();

    while ($dados2 = $consulta2->fetch(PDO::FETCH_OBJ)) {
        $valorTotal = $dados2->valorTotal;
        $valorTotal = number_format($valorTotal, 2, ",", '.');

        $dataPed = $dados2->data;
        $dataPed = explode("-", $dataPed);
        $dia = $dataPed[2];
        $mes = $dataPed[1];
        $ano = $dataPed[0];
        $dataPed = $dia . "/" . $mes . "/" . $ano;

        $status = $dados2->status;
        
        $html = "
            <table class='table table-bordered table-stripped mar-bottom-0'>
                <thead>
                    <tr>
                        <td class='text-center pad-10' width='15%'>$id</td>
                        <td class='text-left pad-10' width='50%'>$nomeCliente</td>
                        <td class='text-left pad-10' width='15%'>$dataPed</td>
                        <td class='text-center pad-10' width='20%'>$valorTotal</td>
                    </tr>
                </thead>
            </table>";


        $pdf->WriteHTML($html, 2);
    }
}

$pdf->OutPut(); 