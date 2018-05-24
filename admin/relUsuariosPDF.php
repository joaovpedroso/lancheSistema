<?php

require_once('../pdf/vendor/autoload.php');
use Mpdf\Mpdf;
require('../config/conecta.php');

$pdf = new Mpdf(['setAutoTopMargin' => 'stretch']);


$stylesheet = file_get_contents('../css/bootstrap.min.css');
$css = file_get_contents('../css/estilo.css');
$pdf->WriteHTML($stylesheet,1);
$pdf->WriteHTML($css,1);

$sql = "SELECT id,nome,cpf,telefone,email,endereco,cidade FROM usuario WHERE id_tipo = 2 OR id_tipo = 3 ORDER BY Nome";
$consulta = $pdo->prepare($sql);
$consulta->execute();


$pdf->SetHTMLHeader("<div class='row impressao'>
        <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12 relatorio-header'>
            
            <div class='col-lg-3 col-md-3 col-sm-3 col-xs-5 relatorio-header-item'>
                <p>Nome</p>
            </div>
            <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3 relatorio-header-item'>
                <p>Email</p>
            </div>
            <div class='col-lg-3 col-md-3 col-sm-3 col-xs-2 relatorio-header-item'>
                <p>Telefone</p>
            </div>
        </div>");

while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
    $html = "
        <div class='row relatorio-header'>
            <div class='col-lg-5 col-md-5 col-sm-5 col-xs-5 text-center'>
                <p>$dados->nome</p>
            </div>
            <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3 text-center'>
                <p>$dados->email</p>
            </div>
            <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2 text-center'>
                <p>$dados->telefone</p>
            </div>
        </div>
    </div>";

    
    $pdf->WriteHTML($html,2);
}
$pdf->Output();
