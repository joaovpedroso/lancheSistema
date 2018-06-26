<?php
require_once('../pdf/vendor/autoload.php');
use Mpdf\Mpdf;
require('../config/conecta.php');

$pdf = new Mpdf(['setAutoTopMargin' => 'stretch']);


$stylesheet = file_get_contents('../css/bootstrap.min.css');
$css = file_get_contents('../css/estilo.css');
$pdf->WriteHTML($stylesheet,1);
$pdf->WriteHTML($css,1);
$pdf->SetTitle('Relatório de Usuários/Clientes que Nunca Compraram');

$sql = "SELECT * FROM usuario u WHERE NOT EXISTS ( SELECT id_usuario FROM pedido p WHERE p.id_usuario = u.id )";
$consulta = $pdo->prepare($sql);
$consulta->execute();


$pdf->SetHTMLHeader("
    <div class='container pad-bottom-50'>
        <div class='row'>
            <div class='col-xs-1'>
                <img src='../img/logo.png' width='65' class='center-block'>
            </div>
            <div class='col-xs-6'>
                <h3 class='text-left pad-top-10'>Relatório de Usuários/Clientes Nunca Compraram</h3>
            </div>
        </div>
    </div>
    <table class='table table-bordered table-stripped mar-bottom-0'>
        <thead>
            <tr>
                <td class='text-center pad-10' width='40%'>Nome</td>
                <td class='text-center pad-10' width='35%'>Email</td>
                <td class='text-center pad-10' width='25%'>Telefone</td>
            </tr>
        </thead>
    </table>");

while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
    $html = "
        <table class='table table-bordered table-stripped mar-bottom-0'>
        <thead>
            <tr>
                <td class='text-left pad-10' width='40%'>$dados->nome</td>
                <td class='text-left pad-10' width='35%'>$dados->email</td>
                <td class='text-left pad-10' width='25%'>$dados->telefone</td>
            </tr>
        </thead>
    </table>";

    
    $pdf->WriteHTML($html,2);
}
$pdf->Output();