<?php
include "menu.php";
verificaPermissao();

$id = $categoria = $ativo = "";

if (isset($_GET['id'])) {
    $id = trim($_GET['id']);

    $sql = "SELECT id,categoria,ativo FROM categoria WHERE id = ? LIMIT 1";
    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(1, $id);
    $consulta->execute();
    $dados = $consulta->fetch(PDO::FETCH_OBJ);
    if (empty($dados->id)) {
        $id = $categoria = $ativo = "";
    } else {
        $id = $dados->id;
        $categoria = $dados->categoria;
        $ativo = $dados->ativo;
    }
}
?>

<div class="container well">
    <h1>Cadastro de Categorias</h1>

    <a href="categoria.php" class="btn btn-default pull-right">
        <i class="glyphicon glyphicon-file"></i>
        Novo Cadastro
    </a>

    <a href="listarCategoria.php" class="btn btn-default pull-right">
        <i class="glyphicon glyphicon-search"></i> Listar Cadastros
    </a>

    <div class="clearfix"></div>

    <form name="cadastrarCategoria" method="POST" action="salvarCategoria.php">

        <div class="col-md-12">
            <label for="id">ID:</label>
            <input type="text" name="id" readonly class="form-control" value="<?= $id; ?>">
        </div>

        <div class="col-md-8">
            <label for="categoria">Categoria:</label>
            <input type="text" name="categoria" class="form-control" placeholder="Categoria" value="<?= $categoria; ?>">
        </div>

        <div class="col-md-4">
            <label for="ativo">Status</label>
            <select name="ativo" id="ativo" class="form-control">
                <option value="">Selecione um Status</option>
                <option value="1">Ativo</option>
                <option value="0">Inativo</option>
            </select>
        </div>

        <script type="text/javascript">
<?php
if ($ativo == 0) {
    $ativo = 2;
    ?>

                $("#ativo").val("<?= $ativo; ?>");
    <?php
} else {
    ?>
                $("#ativo").val("<?= $ativo; ?>");
    <?php
}
?>
        </script>

        <div class="col-md-12">
            <br>
            <button type="submit" class="btn btn-default pull-right"><i class="glyphicon glyphicon-floppy-save"> Salvar</i></button>
        </div>
    </form>
</div>