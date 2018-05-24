<?php
require_once('../pdf/vendor/autoload.php');
use Mpdf\Mpdf;
require('../config/conecta.php');

$pdf = new Mpdf(['setAutoTopMargin' => 'stretch']);


$stylesheet = file_get_contents('../css/bootstrap.min.css');
$css = file_get_contents('../css/estilo.css');
$pdf->WriteHTML($stylesheet,1);
$pdf->WriteHTML($css,1);

$sql = "SELECT * FROM usuario u WHERE NOT EXISTS ( SELECT id_usuario FROM pedido p WHERE p.id_usuario = u.id )";
$consulta = $pdo->prepare($sql);
$consulta->execute();


$pdf->SetHTMLHeader("<div class='row impressao'>
        <div class='row relatorio-header'>
            
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
        <div class='row'>
            <div class='row relatorio-header'>
                <div class='col-lg-5 col-md-5 col-sm-5 col-xs-5'>
                    <p>$dados->nome</p>
                </div>
                <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'>
                    <p>$dados->email</p>
                </div>
                <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>
                    <p>$dados->telefone</p>
                </div>
            </div>
        </div>
    </div>";

    
    $pdf->WriteHTML($html,2);
}
$pdf->Output();