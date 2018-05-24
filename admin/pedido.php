<?php
include "menu.php";

$data = date('d-m-Y');

//Excluir Produto
if (isset($_GET["del"])) {

    //Receber o ID q deseja excluir na variavel DEL
    $del = trim($_GET["del"]);

    //Verificar se existe produto com o id informado no carrinho
    if (isset($_SESSION["produtos"][$del])) {

        //Verificar se existe mais de 1 quantidade do produto se SIm ele só diminui 1
        if ($_SESSION["produtos"][$del] > 1) {

            $_SESSION["produtos"][$del] += -1;
        } else {

            // Se não ele Exclui o registro
            unset($_SESSION["produtos"][$del]);
        }
    }
}
?>

<div class="container well">

    <h1 class="titulo text-center">Novo Pedido</h1>
    <hr>
    <div class="row">
        <a href="listarPedido.php" class="btn btn-default pull-right">
            <i class="glyphicon glyphicon-search"></i> Listar Pedidos
        </a>
    </div>
    <br>

    <form name="novoPedido" method="POST" action="salvarPedido.php" novalidate>

        <div class="row">
            <div class="col-md-2">
                <label>#</label>
                <input type="text" name="cliente" id="id_cliente" class="form-control" readonly>
            </div>
            <div class="col-md-10">
                <label for="cliente_nome">Cliente</label>
                <input type="text" name="cliente_nome" id="cliente" class="form-control" placeholder="Informe um cliente" required data-validation-required-message="Informe um Cliente">
            </div>
        </div>

        <div class="control-group col-md-4">
            <label for="forma_pagamento">Forma de Pagamento:</label>
            <div class="controls">
                <select name="forma_pagamento" class="form-control" required data-validation-required-message="Informe uma forma de pagamento">
                    <option value="">Selecione a Forma de Pagamento:</option>
<?php
$sql = "SELECT id,pagamento FROM pagamento ORDER BY pagamento";
$consulta = $pdo->prepare($sql);
$consulta->execute();

while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
    $id = $dados->id;
    $pagamento = $dados->pagamento;

    echo "<option value='$id'>$pagamento</option>";
}
?>
                </select>
            </div>
        </div>

        <div class="control-group col-md-4">
            <label for="forma_entrega">Forma de Entrega:</label>
            <div class="controls">
                <select name="forma_entrega" class="form-control" required data-validation-required-message="Informe uma forma de entrega">
                    <option value="">Selecione uma Forma de Entrega</option>
<?php
$sql = "SELECT id, entrega FROM forma_entrega ORDER BY entrega";
$consulta = $pdo->prepare($sql);
$consulta->execute();

while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
    $id = $dados->id;
    $entrega = $dados->entrega;

    echo "<option value='$id'>$entrega</option>";
}
?>
                </select>
            </div>
        </div>

        <div class="control-group col-md-4">
            <label for="hora_pedido">Hora do Pedido:</label>
            <div class="controls">
                <input type="text" name="hora_pedido" value="<?= $hora ?>" class="form-control text-center" readonly>
            </div>
        </div>

        <div class="row">
            <div class="col-md-7">
                <div class="control-group">
                    <label for="observacao">Observações:</label>
                    <div class="controls">
                        <textarea name="observacao" class="form-control" placeholder="Retirada de Ingrediente"></textarea>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="control-group">
                    <label for="troco">Troco:</label>
                    <div class="controls">
                        <input type="text" name="troco" class="form-control valor" placeholder="Valor do troco">
                    </div>
                </div>
            </div>
        </div>	

</div>

<div class="container well">
    <div class="table-responsive">
        <table class="table table-bordered table-stripped">

            <thead>
                <tr class="text-center">
                    <td>Imagem</td>
                    <td>Produto</td>
                    <td>Quantidade</td>
                    <td>Valor Unitário</td>
                    <td>Sub. Total</td>
                    <td>Ações</td>
                </tr>
            </thead>
            <tbody>

<?php
//Iniciar a variavel para soma do valor total dos produtos e os sub-totais de cada produto
$total = 0;
$subTotal = 0;

if (!isset($_SESSION["produtos"])) {
    echo "<h3 class='alert alert-success text-center'>Adicione Produtos ao Pedido</h3>";
} else {


    //Percorrer o array e listar os produtos adicionados
    foreach ($_SESSION["produtos"] as $prods => $quantidade) {

        //Selecionar os dados de cada produto
        $sql = "SELECT * FROM produto WHERE id = ? ";
        $resultado = $pdo->prepare($sql);
        $resultado->bindParam(1, $prods);
        $resultado->execute();

        while ($dados = $resultado->fetch(PDO::FETCH_OBJ)) {

            //id do produto
            $id = $dados->id;
            $imagem = $dados->imagem;
            //Definir que sera selecionada a imagem com tamanho P para exibição
            $imagem = $imagem . "p.jpg";
            //Definir o diretorio da Imagem para listagem na tabela dos produtos
            $img = "<img src= '../img/produtos/$imagem' width='100px' class='img-responsive'>";
            $nome = $dados->nome;
            $preco = $dados->preco;
            $qtd = $quantidade;
            $subTotal = $preco * $qtd;
            $sub = $subTotal;
            $sub = number_format($sub, 2, ",", ".");
            $total += $subTotal;
            $preco = number_format($preco, 2, ",", ".");

            //Listar Produtos
            echo
            "<tr>
									<td>$img</td>
									<td>$nome</td>
									<td>$qtd</td>
									<td>$preco</td>
									<td>$sub</td>
									<td>
										<a href='pedido.php?del=$id' class='btn btn-danger' title='Excluir Produto' alt='Excluir Produto'>
											<i class='glyphicon glyphicon-erase'></i>
										</a>
									</td>
								</tr>";
        }
    }
}
//Mostar o valor total dos produtos
$total = number_format($total, 2, ",", ".");
echo
"<tr>
							<td colspan='6' class='text-right'><b>Valor Total: R$ <b>$total</td>
						</tr>";
?>
            </tbody>

        </table>
    </div>
    <div class="clearfix"></div><br>

    <!-- Botão para acionar o Método POST que vai ser o responsavel por salvar os dados no banco -->
    <input type="submit" name="enviar" value="Finalizar Pedido" class="btn btn-orange pull-right">
    </form>	
    <div class="clearfix"></div><br>
    <a href="cardapio.php" class="btn btn-primary pull-right">Adicionar Produtos</a>

    <a href="javascript:deletar()" class="btn btn-danger pull-right">Cancelar Pedido</button></a>


</div>

<script>
    function deletar() {
        if (confirm("Deseja mesmo excluir?")) {
            //enviar o id para uma página
            location.href = "cancelarPedido.php";
        }
    }
</script>

<!-- Importar arquivos de configuração do Easy AutoComplete -->
<script type="text/javascript" src="../js/jquery.easy-autocomplete.min.js"></script>
<link rel="stylesheet" type="text/css" href="../css/easy-autocomplete.min.css">
<script type="text/javascript">
    //Opções de busca
    options = {
        //Url da pagina JSON com o conteudo
        url: "clientes.php",
        //Em qual atributo sera feita a busca
        getValue: function (element) {
            return element.nome; //Selecionar o Cliente pelo nome
        },
        //opções de listagem
        list: {
            //Numero maximo de registros
            maxNumberOfElements: 5,
            // Ir eliminando registros que nao coincidem com a busca
            match: {
                enabled: true,
            },
            //Selecionar o campo ID do cliente
            onSelectItemEvent: function (  ) {
                //Selecionando o campo de Nome do funcionario
                item = $("#cliente").getSelectedItemData().id;

                //Inserir o valor no campo ID
                $("#id_cliente").val(item).trigger("change");
            }
        }
    };
    //Associar a função do Auto Complete ao campo input Cliente
    $("#cliente").easyAutocomplete(options);
</script>