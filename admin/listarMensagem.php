<?php
include "menu.php";
verificaPermissao();

$sql = "SELECT *, date_format(data, '%d/%m/%Y') as dt FROM mensagem ORDER BY data";
$consulta = $pdo->prepare($sql);
$consulta->execute();
?>
<div class="container">
    <div class="well">
        <h1>Mensagens</h1>

        <div class="table-responsive">
            <table class="table table-responsive table-hover table-striped">
                <thead>
                    <tr class="text-center">
                        <td>Nome</td>
                        <td>E-Mail</td>
                        <td>Telefone</td>
                        <td>Data</td>
                        <td>Mensagem</td>
                    </tr>
                </thead>

                <tbody>	
                    <?php
                    while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
                        $id = $dados->id;
                        $nome = $dados->nome;
                        $email = $dados->email;
                        $telefone = $dados->telefone;
                        $data = $dados->dt;
                        $mensagem = $dados->mensagem;

                        echo "
							<tr>
								<td>$nome</td>
								<td>$email</td>
								<td>$telefone</td>
								<td>$data</td>
								<td  class='text-justify'>$mensagem</td>
							</tr>
							";
                    }
                    ?>
                </tbody>	
            </table>
        </div>
        <a href="home.php" class="btn btn-primary">Voltar</a>
    </div>
</div>
<script type="text/javascript">

    $(document).ready(function () {

        //Aplicar a formatacao na tabela
        $("table").dataTable({
            //Alterar Linguagem dos atributos
            "language": {
                //Quantidade de Itens por pagina
                "lengthMenu": "Mostrando _MENU_ registros por página",
                //Quando não há dados para listar
                "zeroRecords": "Nenhuma mensagem encontrada",
                //Qual pagina está mostrando
                "info": "Mostrando _PAGE_ de _PAGES_",
                //QUando não a paginas para mostrar
                "infoEmpty": "Nenhuma mensagem encontrada",
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