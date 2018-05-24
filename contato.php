<?php
    include "menu.html";

    $telefoneFixo = $telefoneCel = $email = $horarioAbertura = $horarioFechamento = "";

    $sql = "SELECT * FROM sobre LIMIT 1";
    $resultado= $pdo->prepare( $sql );
    $resultado->execute();

    $dados = $resultado->fetch( PDO::FETCH_OBJ );
?>
    <body>
        <div class="linha"></div>
        
        <div class="fullbg">
            <div class="formulario">
                <div class="content container min-heigth-100">
                    <div class="contato col-md-12">
                        
                        <div class="col-md-6">
                            <h2 class="text-center">Formulário de Contato</h2>
                            <form action="enviarMensagem.php" method="POST" novalidate>
                                <div class="col-md-12">
                                    <div class="control-group">
                                        <label for="nome">Nome</label>
                                        <div class="controls">
                                            <input type="text" name="nome" class="form-control" required data-validation-required-message="Informe seu nome" placeholder="Informe seu nome">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="control-group">
                                        <label for="email">Email</label>
                                        <div class="controls">
                                            <input type="email" name="email" class="form-control" required data-validation-email-message="Informe seu email corretamente" data-validation-required-message="Informe o Email" placeholder="exemplo@exemplo.com">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="control-group">
                                        <label for="telefone">Telefone</label>
                                        <div class="controls">
                                            <input type="text" name="telefone" class="form-control" required data-validation-required-message="Informe seu telefone" data-mask="(99)9999-9999?9" placeholder="(XX)x - xxxx - xxxx">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="control-group">
                                        <label for="mensagem">Mensagem</label>
                                        <div class="controls">
                                            <textarea name="mensagem" class="form-control" required data-validation-required-message="Informe sua mengagem" placeholder="Informe sua mensagem"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12" align="center">
                                    <button type="submit" class="btn btn-warning">Enviar</button>
                                </div>
                            </form>
                        </div>
                        
                        <div class="col-md-6 text-left" align="center">
                            <?php
                                if( !empty( $dados->id ) ) {

                                        $telefoneFixo		= $dados->telefoneFixo;
                                        $telefoneCel		= $dados->telefoneCel;
                                        $email 				= $dados->email;
                                        $hoarioAbertura 	= $dados->horarioAbertura;
                                        $horarioFechamento 	= $dados->horarioFechamento;

                                        echo "
                                            <h2>Email:</h2>
                                            <p>$email</p>

                                            <h2>Telefones:</h2>
                                            <p>$telefoneFixo</p>
                                            <p>$telefoneCel</p>

                                            <h2> Horário de Funcionamento</h2>
                                            <p>
                                                Das: $hoarioAbertura às $horarioFechamento
                                            </p>
                                        ";
                                }
                        ?>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        
    </body>
<?php
    include "rodape.html";
?>