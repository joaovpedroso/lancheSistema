<?php

require_once('../pdf/vendor/autoload.php');

use Mpdf\Mpdf;

require('../config/conecta.php');

$pdf = new Mpdf(['setAutoTopMargin' => 'stretch']);


$stylesheet = file_get_contents('../css/bootstrap.min.css');
$css = file_get_contents('../css/estilo.css');
$pdf->WriteHTML($stylesheet, 1);
$pdf->WriteHTML($css, 1);

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
                    <div class='row relatorio-header'>
                        <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2 text-center'>
                            <p>$id</p>
                        </div>
                        <div class='col-lg-6 col-md-6 col-sm-6 col-xs-6 text-center'>
                            <p>$nomeCliente</p>
                        </div>
                        <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2 text-center'>
                            <p>R$ $valorTotal</p>
                        </div>
                    </div>
                </div>";


        $pdf->WriteHTML($html, 2);
    }
}

$pdf->OutPut(); 