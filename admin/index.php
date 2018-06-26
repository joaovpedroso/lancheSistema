<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login - Painel</title>
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="../css/estilo.css">

    </head>
    <body>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <img src="../img/logo.png" class="img-responsive img-panel center-block">
                </div>
            </div>
            <hr>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                    <div class="col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-4 col-sm-4 col-sm-offset-4 col-xs-12">

                        <div class="panel">
                            <div class="row">
                                <div class="panel-heading" style="background: black; color: lightgray;">
                                    <h4 class="text-center">Login - Painel</h4>
                                </div>
                            </div>

                            <div class="row">

                                <div class="panel-body">

                                    <form name="login" action="verifica.php" method="post" novalidate>

                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label>Email: </label>
                                                <div class="controls">
                                                    <input type="text" name="usuario" placeholder="Login / Email" maxlength="50" class="form-control" autofocus required data-validation-required-message="Campo de preenchimento obrigatório">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label>Senha:</label>	
                                                <div class="controls">
                                                    <input type="password" name="senha" placeholder="Senha" maxlength="20" class="form-control" required data-validation-required-message="Campo de preenchimento obrigatório">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label>Função:</label> 
                                                <div class="controls">
                                                    <select class="form-control" name="tipo" required data-validation-required-message="Campo de preenchimento obrigatório">
                                                        <option value="">Selecione Uma Função</option>
                                                        <option value="1">Administrador</option>
                                                        <option value="3">Funcionario</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <button type="submit" class="btn center-block">Entrar</button>
                                        </div>

                                    </form>

                                </div>

                            </div>

                        </div>

                    </div>


                </div>
            </div>

        </div>
        <script src="../js/jquery.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script type="text/javascript" src="../js/jqBootstrapValidation.js"></script>
        <script>
            $(document).ready(function(){
                $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
            });
        </script>
    </body>
</html>