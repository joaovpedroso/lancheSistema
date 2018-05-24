<?php
	include "menu.php";
        verificaPermissao();
        $sql = "SELECT *, date_format(p.data_inicio, '%d/%m/%Y') as datainicio, date_format(p.data_fim, '%d/%m/%Y') as datafim  FROM promocao p ORDER BY data_inicio ";
        $consulta = $pdo->prepare($sql);
        $consulta->execute();
?>
<div class="container well">
	<h1>Promoções</h1>

	<div class="clearfix"></div>

	<a href="promocao.php" class="btn btn-default pull-right">
		<i class="glyphicon glyphicon-file"></i>
		Novo Cadastro
	</a>

	<div class="clearfix"></div>

	<br>
	<div class="table-responsive">
		<table class="table table-responsive table-hover table-striped">
			<thead>
				<tr>
					<td>ID</td>
					<td>Titulo</td>
					<td>Data de Início</td>
					<td>Data de Término</td>
					<td>Valor</td>
					<td width="150px">Opções</td>
				</tr>
			</thead>
			
			<tbody>	
				<?php
				    while( $dados = $consulta->fetch(PDO::FETCH_OBJ) ){
                                        $id = $dados->id;
                                        $titulo = $dados->titulo;
                                        $datainicio = $dados->datainicio;
                                        $datatermino = $dados->datafim;
                                        $total = number_format($dados->total, 2, ",",".");
                                        echo "
                                        <tr>
                                                <td>$id</td>
                                                <td>$titulo</td>
                                                <td>$datainicio</td>
                                                <td>$datatermino</td>
                                                <td>$total</td>
                                                <td>
                                                <a href='promocao.php?id=$id'>
                                                                <button class='btn btn-primary'>
                                                                <i class='glyphicon glyphicon-pencil'></i> Editar
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
    $(document).ready( function() {

        //Aplicar a formatacao na tabela
        $("table").dataTable({

            //Alterar Linguagem dos atributos
            "language" : {

                //Quantidade de Itens por pagina
                "lengthMenu" : "Mostrando _MENU_ registros por página",

                //Quando não há dados para listar
                "zeroRecords" : "Nenhuma Promoção Encontrada",

                //Qual pagina está mostrando
                "info" : "Mostrando _PAGE_ de _PAGES_",

                //QUando não a paginas para mostrar
                "infoEmpty" : "Nenhuma Promoção Encontrada",

                //Quantos valores encontrados na busca
                "infoFiltered" : "(Encontrado de um total de _MAX_ registros)",

                //Label do campo de busca
                "search" : "Buscar:",

                //Botões de Paginação
                "paginate" : {

                    //Anterior
                    "previous" : "Anterior",

                    //Próxima
                    "next" : "Proxima"
                }
            }
        });
    })
</script>