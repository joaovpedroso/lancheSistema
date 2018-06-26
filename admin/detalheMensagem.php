<?php
include "menu.php";
verificaPermissao();

if (isset($_POST['id_mensagem'])) {

    $id_mensagem = trim($_POST['id_mensagem']);

    $sql = "SELECT *, date_format(data, '%d/%m/%Y') as dt FROM mensagem WHERE id = ? LIMIT 1";
    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(1, $id_mensagem);
    $consulta->execute();
    $dados = $consulta->fetch(PDO::FETCH_OBJ);
} else {
    echo '<script>history.back();</script>';
    return;
}
?>
<div class="container">
    <div class="well">
        <h1>Detalhe da Mensagen</h1>

        <div class="row">

            <?php
            $nome = $dados->nome;
            $email = $dados->email;
            $telefone = $dados->telefone;
            $data = $dados->dt;
            $mensagem = $dados->mensagem;

            echo "
            <div class='col-lg-8 col-md-8 col-sm-8 col-xs-12'>
                <p><span><b>Enviada Por: </b></span> $nome</p>
            </div>
            <div class='col-lg-4 col-md-4 col-sm-4 col-xs-12 text-right'>
                <h5><span><b>Recebida em: </b></span> $data</h5>
            </div>
            <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12 text-left'>
                <p><span><b>Email do remetente: </b></span> $email</p>
            </div>
            <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12 text-left'>
                <p><span><b>Telefone para contato: </b></span>  $telefone</p>
            </div>

            <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                <p><span><b>Mensagem: </b></span></p>
                <p>
                    $mensagem
                </p>
            </div>
            ";
            ?>
        </div>

    </div>
</div>