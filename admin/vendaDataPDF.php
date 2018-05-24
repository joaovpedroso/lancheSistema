<?php

require_once('../pdf/vendor/autoload.php');

use Mpdf\Mpdf;

require('../config/conecta.php');

$pdf = new Mpdf(['setAutoTopMargin' => 'stretch']);


$stylesheet = file_get_contents('../css/bootstrap.min.css');
$css = file_get_contents('../css/estilo.css');
$pdf->WriteHTML($stylesheet, 1);
$pdf->WriteHTML($css, 1);

if (isset($_GET['dt'])) {
    $data = trim($_GET["dt"]);
} else {
    $data = "";
}

$sql1 = "SELECT id FROM pedido WHERE data = ?";
$consulta1 = $pdo->prepare($sql1);
$consulta1->bindParam(1, $data);
$consulta1->execute();


$pdf->SetHTMLHeader("<div class='row impressao'>
        <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12 relatorio-header'>
            
            <div class='col-lg-1 col-md-1 col-sm-1 col-xs-2 relatorio-header-item'>
                <p>Nº Pedido</p>
            </div>
            <div class='col-lg-7 col-md-7 col-sm-7 col-xs-6 relatorio-header-item'>
                <p>Cliente</p>
            </div>
            <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2 relatorio-header-item'>
                <p>Valor</p>
            </div>
        </div>");


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
                    <div class='row relatorio-header'>
                        <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2 text-center'>
                            <p>$id_pedido</p>
                        </div>
                        <div class='col-lg-6 col-md-6 col-sm-6 col-xs-6 text-center'>
                            <p>$nomeCliente</p>
                        </div>
                        <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2 text-center'>
                            <p>$valorTotal</p>
                        </div>
                    </div>
                </div>";


        $pdf->WriteHTML($html, 2);
    }
}
$pdf->Output();  