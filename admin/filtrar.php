<?php
include "menu.php";

/* FILTROS - LEGENDA
  CLI -> CLIENTE
  DT  -> DATA
  PRO -> PRODUTO
 */
?>
<div class="container well">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <td width="10%"><b>Nº Pedido</b></td>
                    <td><b>Cliente</b></td>
                    <td><b>Valor Total</b></td>
                    <td><b>Data</b></td>
                    <td><b>Status</b></td>
                </tr>
            </thead>	

            <?php
            if (isset($_GET['f'])) {

                $filtro = trim($_GET['f']);

                if (empty($filtro)) {
                    echo "<script>alert('Selecione um Filtro Para Pesquisa');history.back();</script>";
                    exit;
                } else {

                    if ($filtro == 'cli') {
                        if ($_POST['cliente']) {
                            $cliente = trim($_POST['cliente']);

                            if (empty($cliente)) {
                                echo "<script>alert('Selecione um Cliente Para Pesquisa');history.back();</script>";
                                exit;
                            } else {
                                $sqlU = "SELECT nome FROM usuario WHERE id = ?";
                                $consultaU = $pdo->prepare($sqlU);
                                $consultaU->bindParam(1, $cliente);
                                $consultaU->execute();
                                $dadosU = $consultaU->fetch(PDO::FETCH_OBJ);
                                $nomeCliente = $dadosU->nome;

                                //Selecionar COMPRAS com o Cliente Informado
                                $sql1 = "SELECT id FROM pedido WHERE id_usuario = ?";
                                $consulta1 = $pdo->prepare($sql1);
                                $consulta1->bindParam(1, $cliente);
                                $consulta1->execute();

                                $itens = $consulta1->rowCount();

                                if ($itens != 0) {

                                    echo "<a href='vendaClientePDF.php?c=$cliente' target='_blank' class='btn btn-success pull-right'>Gerar PDF</a>";
                                    echo "<div class='clearfix'></div><br>";

                                    while ($dados1 = $consulta1->fetch(PDO::FETCH_OBJ)) {

                                        $id = $dados1->id;

                                        $data = explode("-", $data);
                                        $mes = $data[1];
                                        $ano = $data[2];

                                        $data = $ano . "-" . $mes . "-%";

                                        $sql2 = "SELECT p.valorTotal,p.data, s.status FROM pedido p 
											INNER JOIN status s ON s.id = p.id_status 
											WHERE p.id = ? ORDER BY p.data";
                                        $consulta2 = $pdo->prepare($sql2);
                                        $consulta2->bindParam(1, $id);
                                        //$consulta2->bindParam(2, $data);
                                        $consulta2->execute();

                                        while ($dados2 = $consulta2->fetch(PDO::FETCH_OBJ)) {
                                            $valorTotal = $dados2->valorTotal;
                                            $valorTotal = number_format($valorTotal, 2, ",", '.');

                                            $dataPed = $dados2->data;
                                            $dataPed = explode("-", $dataPed);
                                            $dia = $dataPed[2];
                                            $mes = $dataPed[1];
                                            $ano = $dataPed[0];
                                            $dataPed = $dia . "/" . $mes . "/" . $ano;

                                            $status = $dados2->status;

                                            echo "
												<tr>
													<td>$id</a></td>
													<td>$nomeCliente</td>
													<td>$valorTotal</td>
													<td>$dataPed</td>
													<td>$status</td>
												</tr>";
                                        }
                                    }
                                } else {
                                    echo "
											<div class='alert alert-danger'>
												Nenhum Resultado Encontrado
											</div>";
                                }
                            }
                        }
                    } else if ($filtro == 'dt') {
                        if ($_POST['data']) {
                            $data = trim($_POST['data']);

                            if (empty($data)) {
                                echo "<script>alert('Informe uma Data Para Continuar'); history.back();</script>";
                            } else {
                                $dataD = $data;
                                $dataD = explode("-", $dataD);
                                $dia = $dataD[2];
                                $mes = $dataD[1];
                                $ano = $dataD[0];
                                $dataD = $dia . "/" . $mes . "/" . $ano;

                                echo "<h3>Pedidos do dia: $dataD</h3>";

                                $sql1 = "SELECT id FROM pedido WHERE data = ?";
                                $consulta1 = $pdo->prepare($sql1);
                                $consulta1->bindParam(1, $data);
                                $consulta1->execute();

                                $itens = $consulta1->rowCount();

                                if ($itens == 0) {
                                    echo "
										<div class='alert alert-danger'>
											Nenhum Resultado Encontrado
										</div>										
										";
                                }

                                echo "<a href='vendaDataPDF.php?dt=$data' target='_blank' class='btn btn-success pull-right'>Gerar PDF</a>";
                                echo "<div class='clearfix'></div><br>";

                                while ($dados1 = $consulta1->fetch(PDO::FETCH_OBJ)) {

                                    $id_pedido = $dados1->id;

                                    $sql2 = "SELECT p.data, p.valorTotal, s.status, u.nome FROM pedido p 
										INNER JOIN status s ON s.id = p.id_status 
										INNER JOIN usuario u ON u.id = p.id_usuario
										WHERE p.id = ? ORDER BY p.data";
                                    $consulta2 = $pdo->prepare($sql2);
                                    $consulta2->bindParam(1, $id_pedido);
                                    $consulta2->execute();

                                    while ($dados2 = $consulta2->fetch(PDO::FETCH_OBJ)) {
                                        $valorTotal = $dados2->valorTotal;
                                        $valorTotal = number_format($valorTotal, 2, ",", '.');
                                        $status = $dados2->status;
                                        $data = $dados2->data;
                                        $data = explode("-", $data);
                                        $dia = $data[2];
                                        $mes = $data[1];
                                        $ano = $data[0];
                                        $data = $dia . "/" . $mes . "/" . $ano;
                                        $nomeCliente = $dados2->nome;

                                        echo "
											<tr>
												<td>$id_pedido</a></td>
												<td>$nomeCliente</td>
												<td>$valorTotal</td>
												<td>$data</td>
												<td>$status</td>
											</tr>";
                                    }
                                }
                            }
                        } else {
                            echo "<scritp>alert('Informe uma Data Para Continuar'); history.back();</script>";
                            exit;
                        }
                    } else if ($filtro == 'pro') {
                        if ($_POST['produto']) {
                            $produto = trim($_POST['produto']);

                            if (empty($produto)) {
                                echo "<script>alert('Selecione um Produto Para Continuar'); history.back();</script>";
                                exit;
                            } else {
                                $sql1 = "SELECT id_pedido FROM produto_pedido WHERE id_produto = ? GROUP BY id_pedido";
                                $consulta1 = $pdo->prepare($sql1);
                                $consulta1->bindParam(1, $produto);
                                $consulta1->execute();

                                $itens = $consulta1->rowCount();

                                if ($itens == 0) {
                                    echo "
										<div class='alert alert-danger'>
											Nenhum Resultado Encontrado
										</div>										
										";
                                }

                                echo "<a href='vendaProdutoPDF.php?p=$produto' target='_blank' class='btn btn-success pull-right'>Gerar PDF</a>";
                                echo "<div class='clearfix'></div><br>";

                                while ($dados1 = $consulta1->fetch(PDO::FETCH_OBJ)) {
                                    $id_pedido = $dados1->id_pedido;

                                    $sql2 = "SELECT p.valorTotal, p.data, s.status, u.nome FROM pedido p
												 INNER JOIN status s ON s.id = p.id_status 
												 INNER JOIN usuario u ON u.id = p.id_usuario
												 WHERE p.id = ? ORDER BY p.data";
                                    $consulta2 = $pdo->prepare($sql2);
                                    $consulta2->bindParam(1, $id_pedido);
                                    $consulta2->execute();

                                    while ($dados2 = $consulta2->fetch(PDO::FETCH_OBJ)) {
                                        $valorTotal = $dados2->valorTotal;
                                        $valorTotal = number_format($valorTotal, 2, ",", '.');
                                        $status = $dados2->status;
                                        $data = $dados2->data;
                                        $data = explode("-", $data);
                                        $dia = $data[2];
                                        $mes = $data[1];
                                        $ano = $data[0];
                                        $data = $dia . "/" . $mes . "/" . $ano;
                                        $nomeCliente = $dados2->nome;

                                        echo "
											<tr>
												<td>$id_pedido</a></td>
												<td>$nomeCliente</td>
												<td>$valorTotal</td>
												<td>$data</td>
												<td>$status</td>
											</tr>";
                                    }
                                }
                            }
                        } else {
                            echo "<script>alert('Informe um Produto Para Continuar'); history.back();</script>";
                            exit;
                        }
                    } else {
                        echo "<script>alert('Selecione um Filtro Para Pesquisa');history.back();</script>";
                        exit;
                    }
                }
            }
            ?>	
        </table>
    </div>	
    <a href="relVendas.php" class="btn btn-primary">Voltar</a>
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
                "zeroRecords": "Nenhum Dado Cadastrado",
                //Qual pagina está mostrando
                "info": "Mostrando _PAGE_ de _PAGES_",
                //QUando não a paginas para mostrar
                "infoEmpty": "Nenhum Dado encontrado",
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