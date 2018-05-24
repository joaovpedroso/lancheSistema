<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Painel de Administração</title>
        <link rel="stylesheet" type="text/css" href="../css/estilo.css">
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/jquery-ui.css">
        <link rel="stylesheet" href="../css/fontawesome/fontawesome-all.min.css">
        <link rel="stylesheet" type="text/css" href="../css/jquery.dataTables.min.css"> 
        <link rel="stylesheet" type="text/css" href="../css/summernote.css">
        <link rel="stylesheet" type="text/css" href="../css/multi-select.css">

        <style type="text/css">
            .topo {
                margin-top: 10em;
            }

        </style>

        <script type="text/javascript" src="../js/jquery-1.9.1.min.js"></script>
        <script type="text/javascript" src="../js/jquery-ui.js"></script>
        <script type="text/javascript" src="../js/bootstrap.min.js"></script>
        <script type="text/javascript" src="../js/bootstrap-inputmask.min.js"></script>
        <script type="text/javascript" src="../js/jquery.maskMoney.min.js"></script>
        <script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="../js/summernote.min.js"></script>
        <script type="text/javascript" src="../lang/summernote-pt-BR.js"></script>
        <script type="text/javascript" src="../js/jqBootstrapValidation.js"></script>
        <script type="text/javascript" src="../js/jquery.multi-select.js"></script>

        <script>
            $(function () {
                //validação dos campos
                $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
                //colocar a máscara nos campos .valor - classes
                $(".valor").maskMoney({
                    thousands: ".",
                    decimal: ","
                });
            });

            // SCRIPT VERIFICADOR DE CEP

            //Função para limpar valores dos formularios informados
            function limpaFormulário() {
                //Limpa valores do formulário de cep.
                document.getElementById('cep').value = ("");
                document.getElementById('endereco').value = ("");
                document.getElementById('cidade').value = ("");
            }

            function meu_callback(conteudo) {
                if (!("erro" in conteudo)) {
                    //Atualiza os campos com os valores.
                    document.getElementById('endereco').value = (conteudo.logradouro);
                    document.getElementById('cidade').value = (conteudo.localidade);
                } else {
                    //Mostra mensagem de CEP não Encontrado.
                    alert("CEP não encontrado.");
                    limpaFormulário();
                }
            }

            function pesquisacep(valor) {

                //Nova variável "cep" somente com dígitos.
                var cep = valor.replace(/\D/g, '');

                //Verifica se o campo cep possui valor informado.
                if (cep != "") {

                    //Expressão regular para validar o CEP.
                    var validacep = /^[0-9]{8}$/;

                    //Valida o formato do CEP.
                    if (validacep.test(cep)) {

                        //Preenche os campos com "..." enquanto consulta webservice.
                        document.getElementById('endereco').value = "...";
                        document.getElementById('cidade').value = "...";

                        //Cria um elemento javascript.
                        var script = document.createElement('script');

                        //Sincroniza com o callback.
                        script.src = '//viacep.com.br/ws/' + cep + '/json/?callback=meu_callback';

                        //Insere script no documento e carrega o conteúdo.
                        document.body.appendChild(script);

                    } else {
                        //Mensagem de cep inválido.
                        alert("Formato de CEP inválido.");
                    }
                } else {
                    //cep sem valor -> Mstra mensagem de erro
                    alert("Cep não encontrado");
                    limpaFormulário();
                }
            }
            ;


        </script>
    </head>

    <body>
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container-fluid">

                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" 
                            data-target="#menu" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="home.php">
                        <img src="../img/logo.png" class="img-responsive logo">
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="menu">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="pedido.php">Pedidos</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Cadastros <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="produto.php">Produto</a>
                                </li>
                                <li>
                                    <a href="promocao.php">Promoção</a>
                                </li>
                                <li>
                                    <a href="cliente.php">Cliente</a>
                                </li>
                                <li>
                                    <a href="categoria.php">Categoria</a>
                                </li>
                                <li>
                                    <a href="entrega.php">Entrega</a>
                                </li>
                                <li>
                                    <a href="pagamento.php">Pagamento</a>
                                </li>
                                <li>
                                    <a href="usuario.php">Usuário</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Relatórios <span class="caret"></span></a>
                            <ul class="dropdown-menu">

                                <li>
                                    <a href="relVendas.php">Vendas</a>
                                </li>

                                <li>
                                    <a href="relProdutos.php">Produtos Cadastrados</a>
                                </li>

                                <li>
                                    <a href="relUsuarios.php">Usuarios Cadastrados</a>
                                </li>

                            </ul>
                        </li>
                        <li>
                            <a href="listarMensagem.php">Mensagens</a>
                        </li>
                        <li>
                            <a href="sobre.php">Dados da Empresa</a>
                        </li>
                        <li><a href="logout.php">Sair</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <br><br><br><br><br>