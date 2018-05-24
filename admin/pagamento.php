<?php
include "menu.php";
verificaPermissao();

$id = $pagamento = "";

if (isset($_GET['id'])) {
    $id = trim($_GET['id']);

    $sql = "SELECT id, pagamento FROM pagamento WHERE id = ? LIMIT 1";
    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(1, $id);
    $consulta->execute();

    $dados = $consulta->fetch(PDO::FETCH_OBJ);

    if (empty($dados->id)) {
        $id = $pagamento = "";
    } else {
        $id = $dados->id;
        $pagamento = $dados->pagamento;
    }
}
?>

<div class="container well">
    <h1>Cadastro de Pagamento</h1>


    <a href="pagamento.php" 
       class="btn btn-default pull-right">
        <i class="glyphicon glyphicon-file"></i>
        Novo Cadastro
    </a>
    <a href="listarPagamento.php" 
       class="btn btn-default pull-right">
        <i class="glyphicon glyphicon-search"></i> Listar Cadastros
    </a>

    <div class="clearfix"></div>

    <form name="cadastrarPagamento" method="POST" action="salvarPagamento.php">

        <div class="col-md-12">
            <label for="id">ID:</label>
            <input type="text" name="id" value="<?= $id ?>" readonly class="form-control">
        </div>

        <div class="col-md-12">
            <label for="pagamento">Pagamento:</label>
            <input type="text" name="pagamento" value="<?= $pagamento ?>" class="form-control" placeholder="Forma de pagamento">
        </div>

        <div class="col-md-12">
            <br>
            <button type="submit" class="btn btn-default pull-right"><i class="glyphicon glyphicon-floppy-save"> Salvar</i></button>
        </div>
    </form>
</div>