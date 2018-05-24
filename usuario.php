<?php
include "config/conecta.php";

$id = $nome = $cpf = $rg = $email = $telefone = $cep = $endereco = $numero = $cidade = "";


//Verifica se vai editar algum usuario ( NÂO NECESSITA DE TIPO -> Pois o TIPO nunca será alterado apos a criação do usuario )
if (isset($_GET['id'])) {

    include "menuCliente.html";

    $id = trim($_GET['id']);
    $sql = "SELECT * FROM usuario WHERE id = ? LIMIT 1";
    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(1, $id);
    $consulta->execute();

    $dados = $consulta->fetch(PDO::FETCH_OBJ);

    if (empty($dados->nome)) {
        $id = $nome = $cpf = $rg = $email = $senha = $telefone = $cep = $endereco = $numero = $cidade = "";
    } else {

        $id = $dados->id;
        $nome = $dados->nome;
        $cpf = $dados->cpf;
        $rg = $dados->rg;
        $email = $dados->email;
        $senha = $dados->senha;
        $telefone = $dados->telefone;
        $cep = $dados->cep;
        $endereco = $dados->endereco;
        $numero = $dados->numero;
        $cidade = $dados->cidade;
    }
} else {
    include "menuVisitante.html";
}
?>
<!-- <div id="tela_cadastro" class="fullbg"> -->
<div class="fullbg">
    <div class="formulario cadastro-usuario">

    <!-- <div class="container formulario mar-top-100"> -->
        <div class="content container min-heigth-100">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <h1>Cadastro de Usuário</h1>
                    </div>
                </div>

                <form name="caduser" method="post" action="salvarUsuario.php" novalidate>
                    <input type="text" name="id" value="<?= $id; ?>" style="visibility: hidden;">

                    <!--Nome-->
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="control-group">
                                <label for="nome">Nome:</label>
                                <div class="controls">
                                    <input type="text" name="nome" class="form-control" placeholder="Digite seu nome" value="<?= $nome ?>" required data-validation-required-message="Campo de preenchimento obrigatório">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Fim Nome-->

                    <!--CPF RG-->
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="control-group">
                                <label for="cpf">CPF:</label>
                                <div class="controls">
                                    <input type="text" name="cpf" placeholder="Informe seu CPF" class="form-control cpf" value="<?= $cpf ?>" required maxlenght="13" minlength="13" data-validation-minlength-message="Informe no mínimo 13 caracteres" data-mask="999.999.999-99" data-validation-required-message="Campo de preenchimento obrigatório" >
                                </div>  
                            </div>  
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="control-group">
                                <label for="rg">RG:</label>
                                <div class="controls">
                                    <input type="text" name="rg" placeholder="Informe seu RG" class="form-control rg" value="<?= $rg ?>" required data-mask="99.999.999-9" maxlenght="9" minlength="9" data-validation-minlength-message="Informe no mínimo 9 caracteres" data-validation-required-message="Campo de preenchimento obrigatório" >
                                </div>  
                            </div>
                        </div>
                    </div>
                    <!--Fim CPF RG-->

                    <!--Email Telefone-->
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="control-group">
                                <label for="email">E-mail:</label>
                                <div class="controls">
                                    <input type="email" name="email" class="form-control" placeholder="Informe seu E-mail" value="<?= $email ?>" required data-validation-required-message="Campo de preenchimento obrigatório" 
                                           data-validation-email-message="Digite um e-mail válido" maxlenght="80">
                                </div>  
                            </div>  
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="control-group">
                                <label for="telefone">Telefone:</label>
                                <div class="controls">
                                    <input type="text" name="telefone" class="form-control" placeholder="Informe um telefone para contato" value="<?= $telefone ?>" required maxlenght="12" minlength="8" data-mask="(99)9999-9999?9"  data-validation-required-message="Campo de preenchimento obrigatório"  data-validation-minlength-message="Informe pelo menos 8 caracteres">
                                </div>  
                            </div>  
                        </div>
                    </div>
                    <!--Fim Email Telefone-->

                    <!--Senha-->
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="control-group">
                                <label for="senha">Senha:</label>
                                <div class="controls">
                                    <input type="password" name="senha" id="senha" class="form-control" placeholder="Informe uma senha" required maxlenght="12" minlength="8" data-validation-minlength-message="Informe no mínimo 8 caracteres" data-validation-required-message="Campo de preenchimento obrigatório" >
                                </div>  
                            </div>  
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="control-group">
                                <label for="senha">Re-Digite a Senha:</label>
                                <div class="controls">
                                    <input type="password" name="senha" class="form-control" placeholder="Informe uma senha" required maxlenght="12" minlength="8" data-validation-minlength-message="Informe no mínimo 8 caracteres" data-validation-required-message="Campo de preenchimento obrigatório"  data-validation-match-match="senha" data-validation-match-message="As senhas digitadas são diferentes">
                                </div>  
                            </div>  
                        </div>
                    </div>
                    <!--Fim Senha-->

                    <!--Endereco-->
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="control-group">
                                <label for="cep">CEP:</label>
                                <div class="controls">
                                    <input type="text" name="cep" class="form-control cep" placeholder="Informe seu CEP" value="<?= $cep ?>" onblur="pesquisacep(this.value);" required maxlenght="9" minlength="9" data-validation-minlength-message="Informe pelo menos 9 caracteres" data-mask="99999-999"  data-validation-required-message="Campo de preenchimento obrigatório" >
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="control-group">
                                <label for="endereco">Endereço:</label>
                                <div class="controls">
                                    <input type="text" name="endereco" id="endereco" class="form-control" value="<?= $endereco ?>" required  data-validation-required-message="Campo de preenchimento obrigatório" >
                                </div>  
                            </div>  
                        </div>

                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <div class="control-group">
                                <label for="numero">Numero</label>
                                <div class="controls">
                                    <input type="text" name="numero" class="form-control" value="<?= $numero ?>" required maxlenght="6" minlength="4" data-validation-minlength-message="Informe pelo menos 4 caracteres" data-validation-required-message="Campo de preenchimento obrigatório" >
                                </div>
                            </div>  
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="control-group">
                                <label for="cidade">Cidade:</label>
                                <div class="controls">
                                    <input type="text" name="cidade" id="cidade" class="form-control" value="<?= $cidade ?>" required data-validation-required-message="Campo de preenchimento obrigatório" >
                                </div>
                            </div>  
                        </div>

                    </div>
                    <!--Fim Endereco-->

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button type="submit" class="btn btn-default center-block">Salvar</button>
                        </div>
                    </div>

                </form>    

            </div>

        
        </div>

    </div>
</div>	
<script type="text/javascript">
    $('.cpf').change(function(){
       
        if( $(this).val().length < 14){
            window.alert('CPF Inválido');
            $('.cpf').val('');
            $('.cpf').focus();
        }

        //Validar CPF
        if ( !validarCpf($(this).val()) ){
            window.alert('CPF Inválido');
            $('.cpf').val('');
            $('.cpf').focus();
        }
    });

    function validarCpf(valor){
        // Garante que o valor é uma string
        valor = valor.toString();
        
        // Remove caracteres inválidos do valor
        valor = valor.replace(/[^0-9]/g, '');


        if (
            valor == "00000000000" ||
            valor == "11111111111" ||
            valor == "22222222222" ||
            valor == "33333333333" ||
            valor == "44444444444" ||
            valor == "55555555555" ||
            valor == "66666666666" ||
            valor == "77777777777" ||
            valor == "88888888888" ||
            valor == "99999999999"
        ){
            return false;
        }
                

        // Captura os 9 primeiros dígitos do CPF
        // Ex.: 02546288423 = 025462884
        var digitos = valor.substr(0, 9);

        // Faz o cálculo dos 9 primeiros dígitos do CPF para obter o primeiro dígito
        var novo_cpf = calc_digitos_posicoes( digitos );

        // Faz o cálculo dos 10 dígitos do CPF para obter o último dígito
        var novo_cpf = calc_digitos_posicoes( novo_cpf, 11 );

        // Verifica se o novo CPF gerado é idêntico ao CPF enviado
        if ( novo_cpf === valor ) {
            // CPF válido
            return true;
        } else {
            // CPF inválido
            return false;
        }
    };

    function calc_digitos_posicoes( digitos, posicoes = 10, soma_digitos = 0 ) {

        // Garante que o valor é uma string
        digitos = digitos.toString();

        // Faz a soma dos dígitos com a posição
        // Ex. para 10 posições:
        //   0    2    5    4    6    2    8    8   4
        // x10   x9   x8   x7   x6   x5   x4   x3  x2
        //   0 + 18 + 40 + 28 + 36 + 10 + 32 + 24 + 8 = 196
        for ( var i = 0; i < digitos.length; i++  ) {
            // Preenche a soma com o dígito vezes a posição
            soma_digitos = soma_digitos + ( digitos[i] * posicoes );

            // Subtrai 1 da posição
            posicoes--;

            // Parte específica para CNPJ
            // Ex.: 5-4-3-2-9-8-7-6-5-4-3-2
            if ( posicoes < 2 ) {
                // Retorno a posição para 9
                posicoes = 9;
            }
        }

        // Captura o resto da divisão entre soma_digitos dividido por 11
        // Ex.: 196 % 11 = 9
        soma_digitos = soma_digitos % 11;

        // Verifica se soma_digitos é menor que 2
        if ( soma_digitos < 2 ) {
            // soma_digitos agora será zero
            soma_digitos = 0;
        } else {
            // Se for maior que 2, o resultado é 11 menos soma_digitos
            // Ex.: 11 - 9 = 2
            // Nosso dígito procurado é 2
            soma_digitos = 11 - soma_digitos;
        }

        // Concatena mais um dígito aos primeiro nove dígitos
        // Ex.: 025462884 + 2 = 0254628842
        var cpf = digitos + soma_digitos;

        // Retorna
        return cpf;
        
    };

</script>