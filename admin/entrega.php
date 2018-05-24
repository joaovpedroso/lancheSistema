<?php
include "menu.php";
verificaPermissao();
$id = $entrega = "";

if (isset($_GET['id'])) {
    $id = trim($_GET['id']);

    $sql = "SELECT id, entrega FROM forma_entrega WHERE id = ? LIMIT 1";
    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(1, $id);
    $consulta->execute();
    $dados = $consulta->fetch(PDO::FETCH_OBJ);
    if (empty($dados->id)) {
        $id = $entrega = "";
    } else {
        $id = $dados->id;
        $entrega = $dados->entrega;
    }
}
?>

<div class="container well">
    <h1>Cadastro de Formas de Entrega</h1>

    <a href="entrega.php" class="btn btn-default pull-right">
        <i class="glyphicon glyphicon-file"></i>
        Novo Cadastro
    </a>
    <a href="listarEntrega.php" class="btn btn-default pull-right">
        <i class="glyphicon glyphicon-search"></i> Listar Cadastros
    </a>

    <div class="clearfix"></div>

    <form name="cadastrarEntrega" method="POST" action="salvarEntrega.php">

        <div class="col-md-12">
            <label for="id">ID:</label>
            <input type="text" name="id" value="<?= $id; ?>" readonly class="form-control">
        </div>

        <div class="col-md-12">
            <label for="entrega">Entrega:</label>
            <input type="text" name="entrega" value="<?= $entrega; ?>"class="form-control" placeholder="Forma de Entrega">
        </div>

        <div class="col-md-12">
            <br>
            <button type="submit" class="btn pull-right"><i class="glyphicon glyphicon-floppy-save"> Salvar</i></button>
        </div>
    </form>
</div>