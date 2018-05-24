<?php
include "menu.php";
verificaPermissao();
?>
<div class="container well">
    <h1>Formas de Pagamento</h1>

    <div class="clearfix"></div>

    <a href="pagamento.php" 
       class="btn btn-default pull-right">
        <i class="glyphicon glyphicon-file"></i>
        Novo Cadastro
    </a>

    <div class="clearfix"></div>

    <?php
    //buscar da categoria
    $sql = "SELECT id, pagamento FROM pagamento ORDER BY pagamento";
    $consulta = $pdo->prepare($sql);
    //executar o sql
    $consulta->execute();
    ?>
    <br>
    <div class="table-responsive">
        <table class="table table-responsive table-hover table-striped">
            <thead>	
                <tr>
                    <td>Pagamento</td>			
                    <td width="150px">Opções</td>
                </tr>
            </thead>	

            <tbody>
                <?php
                while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
                    $id = $dados->id;
                    $pagamento = $dados->pagamento;
                    echo "
						<tr>
							<td>$pagamento</td>
							<td>
								<a href='pagamento.php?id=$id'>
									<button class='btn btn-primary'>
									<i class='glyphicon glyphicon-pencil'></i>
									</button>
								</a>

								<a href='javascript:deletar($id)'>
									<button class='btn btn-danger'>
									<i class='glyphicon glyphicon-erase'></i>
									</button>
								</a>
							</td>
						</tr>";
                }
                ?>
            </tbody>
        </table>		
    </div>
</div>	
<script type="text/javascript">
    //funcao para perguntar se quer deletar
    function deletar(id) {
        if (confirm("Deseja mesmo excluir?")) {
            //enviar o id para uma página
            location.href = "excluirPagamento.php?id=" + id;
        }
    }
    ;

    $(document).ready(function () {

        //Aplicar a formatacao na tabela
        $("table").dataTable({
            //Alterar Linguagem dos atributos
            "language": {
                //Quantidade de Itens por pagina
                "lengthMenu": "Mostrando _MENU_ registros por página",
                //Quando não há dados para listar
                "zeroRecords": "Nenhuma Forma de Pagamento Cadastrada",
                //Qual pagina está mostrando
                "info": "Mostrando _PAGE_ de _PAGES_",
                //QUando não a paginas para mostrar
                "infoEmpty": "Nenhuma Forma de Pagamento Cadastrada",
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