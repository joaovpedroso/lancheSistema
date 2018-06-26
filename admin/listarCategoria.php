<?php
include "menu.php";
verificaPermissao();
?>
<div class="container well">
    <h1>Categorias</h1>

    <div class="clearfix"></div>

    <a href="categoria.php" class="btn btn-default pull-right">
        <i class="glyphicon glyphicon-file"></i>
        Novo Cadastro
    </a>

    <div class="clearfix"></div>

    <?php
    //buscar da categoria
    $sql = "SELECT id, categoria, ativo FROM categoria ORDER BY categoria";
    $consulta = $pdo->prepare($sql);
    //executar o sql
    $consulta->execute();
    ?>

    <br>
    <!--<div class="table-responsive">-->
    <div class="">
        <table class="table display nowrap" style="width:100%" id="tabelaCategoria">
            <thead>
                <tr>
                    <td>Categoria</td>
                    <td width="70px">Status</td>
                    <td width="150px">Opções</td>
                </tr>
            </thead>	
            <tbody>
                <?php
                while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
                    $id = $dados->id;
                    $categoria = $dados->categoria;
                    $ativo = $dados->ativo;

                    if ($ativo == 1) {
                        $status = "Ativo";
                    } else {
                        $status = "Inativo";
                    }


                    echo "
						<tr>
							<td>$categoria</td>
							<td>$status</td>
							<td>
								<a href='categoria.php?id=$id'>
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
    <script type="text/javascript">
        //funcao para perguntar se quer deletar
        function deletar(id) {
            if (confirm("Deseja mesmo excluir?")) {
                //enviar o id para uma página
                location.href = "excluirCategoria.php?id=" + id;
            }
        }
        ;

        $(document).ready(function () {

            //Aplicar a formatacao na tabela
            $("#tabelaCategoria").dataTable({
                responsive: true,
                "info": false,
                "order": [[0, "desc"]],
                columnDefs: [
                    {responsivePriority: 1, targets: 0},
                    {responsivePriority: 2, targets: -2}
                ],
                //Alterar Linguagem dos atributos
                "language": {
                    //Quantidade de Itens por pagina
                    "lengthMenu": "Mostrando _MENU_ registros por página",
                    //Quando não há dados para listar
                    "zeroRecords": "Nenhuma categoria encontrada",
                    //Qual pagina está mostrando
                    "info": "Mostrando _PAGE_ de _PAGES_",
                    //QUando não a paginas para mostrar
                    "infoEmpty": "Nenhuma categoria encontrada",
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