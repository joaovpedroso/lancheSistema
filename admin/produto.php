<?php
include "menu.php";
$id = $nome = $descricao = $id_categoria = $preco = $imagem = $ativo = $cat = "";

if (isset($_GET['id'])) {

    $id = trim($_GET['id']);
    $sql = "SELECT id,nome, descricao, id_categoria, preco, imagem, ativo FROM produto WHERE id = ? LIMIT 1 ";
    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(1, $id);
    $consulta->execute();
    $dados = $consulta->fetch(PDO::FETCH_OBJ);
    if (empty($dados->id)) {
        $id = $nome = $descricao = $id_categoria = $preco = $ativo = "";
    } else {
        $id = $dados->id;
        $nome = $dados->nome;
        $descricao = $dados->descricao;
        $categoria = $dados->id_categoria;
        $cat = $dados->id_categoria;
        $preco = $dados->preco;
        $imagem = $dados->imagem;
        $ativo = $dados->ativo;
    }
}
?>
<div class="container well">
    <h1>Cadastro de Produtos</h1>

    <a href="produto.php" class="btn btn-default pull-right">
        <i class="glyphicon glyphicon-file"></i>
        Novo Cadastro
    </a>
    <a href="listarProduto.php" class="btn btn-default pull-right">
        <i class="glyphicon glyphicon-search"></i> Listar Cadastros
    </a>

    <div class="clearfix"></div>

    <form name="cadProduto" method="POST" action="salvarProduto.php" enctype="multipart/form-data">

        <div class="control-group">
            <label for="id" class="label-control">ID:</label>
            <div class="controls">
                <input type="text" name="id" value="<?= $id; ?>" readonly class='form-control'>
            </div>
        </div>

        <div class="control-group">
            <label for="nome" class="label-control">Produto:</label>
            <div class="controls">
                <input type="text" name="nome" value="<?= $nome; ?>" required placeholder="Nome do produto" class='form-control'>
            </div>
        </div>

        <div class="control-group">
            <label for="descricao" class="label-control">Descrição:</label>
            <div class="controls">
                <textarea name="descricao" maxlength="255" class="form-control" required><?= $descricao; ?></textarea>
            </div>
        </div>

        <div class="control-group">
            <label for="preco" class="label-control">Preço:</label>
            <div class="controls">
                <input type="text" name="preco" value="<?= $preco; ?>" placeholder="Informe o Valor R$" class="form-control valor" required></input>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="imagem">Imagem</label>
            <div class="controls">
                <input type="file" name="imagem" class="form-control">
                <!-- Campo para receber a imagem quando for editar -->
                <input type="hidden" name="imagem" value="<?= $imagem; ?>">
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="control-group">
                    <label for="categoria">Categoria:</label>
                    <div class="controls">
                        <select name="categoria" id="categoria" class="form-control" required>
                            <option value="">Selecione Uma Categoria</option>
                            <?php
                            $sql = "SELECT id, categoria FROM categoria ORDER BY categoria";
                            $consulta = $pdo->prepare($sql);
                            $consulta->execute();

                            while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
                                $id = $dados->id;
                                $categoria = $dados->categoria;

                                echo "<option value='$id'> $categoria</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>	

            <div class="col-md-3">
                <label class="label-control" for="ativo">Status</label>
                <div class="controls">
                    <select name="ativo" id="ativo" class="form-control">
                        <option value="">Selecione uma opção </option>
                        <option value="1">Ativo</option>
                        <option value="2">Inativo</option>
                    </select>
                </div>
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
                $("#categoria").val("<?= $cat; ?>");
            </script>	

        </div>	



        <br>
        <button class="btn btn-default pull-right" type="submit"><i class="glyphicon glyphicon-floppy-save"> Salvar</i></button>

    </form>
</div>
