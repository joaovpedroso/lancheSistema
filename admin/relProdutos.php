<?php
include "menu.php";
verificaPermissao();

$sql = "SELECT p.id, p.nome, p.descricao, p.preco, c.categoria FROM produto p 
	INNER JOIN categoria c ON p.id_categoria = c.id ORDER BY p.nome";
$consulta = $pdo->prepare($sql);
$consulta->execute();

$itens = $consulta->rowCount();
?>
<div class="container well">    

    <h1>Produtos Cadastrados</h1>

    <a href="relProdutosPDF.php" class="btn btn-success pull-right">Gerar PDF</a>

    <div class="clearfix"></div>

    <br>
    <?php
    //Verificar se retornou registro no Relatório caso nao tenha retornado mostra mensagem e para execucao
    if ($itens == 0) {
        echo "
			<div class='alert alert-danger'>
				Nenhum Resultado Encontrado
			</div>										
			<a href='relVendas.php' class='btn btn-primary'>Voltar</a>";
        exit;
    } else {
        echo "";
    }
    ?>
    <div class="table-responsive">
        <table class="table table-responsive table-bordered table-striped" id="tblProdutos">
            <thead>
                <tr>
                    <td width='10px'>ID</td>
                    <td>Produto</td>
                    <td>Preço</td>
                    <td>Categoria</td>
                </tr>
            </thead>	
            <?php
            while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
                $id = $dados->id;
                $produto = $dados->nome;
                $descricao = $dados->descricao;
                $preco = number_format($dados->preco, 2, ',', '.');
                $categoria = $dados->categoria;

                echo "
					<tr>
						<td>$id</td>
						<td>$produto</td>
						<td>R$ $preco</td>
						<td>$categoria</td>
					</tr>";
            }
            ?>
        </table>
        <br>
    </div>	
    <a href="relVendas.php" class="btn btn-primary">Voltar</a>		
</div>
<script type="text/javascript">
    $(document).ready(function () {

        //Aplicar a formatacao na tabela
        $(".table").dataTable({
            //Alterar Linguagem dos atributos
            "language": {
                //Quantidade de Itens por pagina
                "lengthMenu": "Mostrando _MENU_ registros por página",
                //Quando não há dados para listar
                "zeroRecords": "Nenhum Produto Cadastrado",
                //Qual pagina está mostrando
                "info": "Mostrando _PAGE_ de _PAGES_",
                //QUando não a paginas para mostrar
                "infoEmpty": "Nenhum Produto Encontrado",
                //Quantos valores encontrados na busca
                "infoFiltered": "(Encontrado de um total de _MAX_ registros)",
                //Label do campo de busca
                "search": "Buscar:",
                //Botões de Paginação
                "paginate": {
                    //Anterior
                    "previous": "Anterior",
                    //Próxima
                    "next": "Proxima"
                }
            }
        });
    })
</script>
