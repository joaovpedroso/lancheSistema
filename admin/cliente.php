<?php
include "menu.php";
//include "cpfMask.php";

$id = $nome = $cpf = $rg = $email = $senha = $telefone = $cep = $endereco = $numero = $cidade = $ativo = "";

if (isset($_GET['id'])) {

    $id = trim($_GET['id']);

    $sql = "SELECT id, nome, cpf, rg, email, senha, telefone, cep, endereco, numero, cidade,ativo FROM usuario WHERE id = ? LIMIT 1";

    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(1, $id);
    $consulta->execute();

    $dados = $consulta->fetch(PDO::FETCH_OBJ);

    if (empty($dados->id)) {
        $id = $nome = $cpf = $rg = $email = $senha = $telefone = $cep = $endereco = $numero = $cidade = $ativo = "";
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
        $ativo = $dados->ativo;
    }
}
?>

<div class="container well">
    <h1>Cadastro de Clientes</h1>

    <a href="cliente.php" 
       class="btn btn-default pull-right">
        <i class="glyphicon glyphicon-file"></i>
        Novo Cadastro
    </a>
    <a href="listarCliente.php" 
       class="btn btn-default pull-right">
        <i class="glyphicon glyphicon-search"></i> Listar Cadastros
    </a>

    <div class="clearfix"></div>

    <form name="cadastrarCliente" method="POST" action="salvarCliente.php" novalidate>
        <div class="col-md-12">
            <div class="control-group">
                <label for="id">ID:</label>
                <div class="controls">
                    <input type="text" name="id" value="<?= $id; ?>" class="form-control" readonly>
                </div>
            </div>	
        </div>

        <div class="col-md-12">
            <div class="control-group">
                <label for="nome">Nome:</label>
                <div class="controls">
                    <input type="text" name="nome" class="form-control" placeholder="Digite seu nome" value="<?= $nome ?>" required data-validation-required-message="Preencha o Nome Do Cliente">
                </div>	
            </div>	
        </div>

        <div class="col-md-6">
            <div class="control-group">
                <label for="cpf">CPF:</label>
                <div class="controls">
                    <input type="text" name="cpf" placeholder="Informe seu CPF" class="form-control cpf" value="<?= $cpf ?>" required
                           data-validation-required-message="Preencha o CPF do Cliente" maxlenght="14" data-mask="999.999.999-99">
                </div>
            </div>		
        </div>	
        <div class="col-md-6">
            <div class="control-group">
                <label for="rg">RG:</label>
                <div class="controls">
                    <input type="text" name="rg" placeholder="Informe seu RG" class="form-control rg" value="<?= $rg ?>" required
                           data-validation-required-message="Preencha o RG do Cliente" maxlength="12">
                </div>
            </div>	
        </div>	

        <div class="col-md-6">
            <div class="control-group">
                <label for="email">E-mail:</label>
                <div class="controls">
                    <input type="email" name="email" class="form-control" placeholder="Informe seu E-mail" value="<?= $email ?>" required data-validation-required-message="Preencha o E-Mail Do Cliente" data-validation-email-message="Digite um e-mail válido" maxlenght="80">
                </div>	
            </div>	
        </div>

        <div class="col-md-6">
            <div class="control-group">
                <label for="telefone">Telefone:</label>
                <div class="controls">
                    <input type="text" name="telefone" class="form-control" placeholder="Informe um telefone para contato" value="<?= $telefone ?>" required data-validation-required-message="Informe o telefone do Cliente" maxlenght="12" data-mask="(99) 9999-9999?9">
                </div>
            </div>		
        </div>

        <div class="col-md-6">
            <div class="control-group">
                <label for="senha">Senha:</label>
                <div class="controls">
                    <input type="password" name="senha" class="form-control" placeholder="Informe uma senha" maxlenght="12">
                </div>
            </div>		
        </div>

        <div class="col-md-6">
            <div class="control-group">
                <label for="senha">Re-Digite a Senha:</label>
                <div class="controls">
                    <input type="password" name="senha" class="form-control" placeholder="Informe uma senha" maxlenght="12" minlength="8" data-validation-minlength-message="Informe pelo menos 8 caracteres"  data-validation-match-match="senha" data-validation-match-message="As senhas digitadas são diferentes">
                </div>	
            </div>	
        </div>


        <div class="col-md-3">
            <div class="control-group">
                <label for="cep">CEP:</label>
                <div class="controls">
                    <input type="text" name="cep" class="form-control cep" placeholder="Informe seu CEP" value="<?= $cep ?>" onblur="pesquisacep(this.value);" required data-validation-required-message="Informe o CEP do Cliente" maxlenght="9" data-mask="99999-999">
                </div>
            </div>		
        </div>


        <div class="col-md-4">
            <div class="control-group">
                <label for="endereco">Endereço:</label>
                <div class="controls">
                    <input type="text" name="endereco" id="endereco" class="form-control" value="<?= $endereco ?>" required data-validation-required-message="Informe a Rua do Cliente">
                </div>
            </div>		
        </div>


        <div class="col-md-2">
            <div class="control-group">
                <label for="numero">Numero</label>
                <div class="controls">
                    <input type="text" name="numero" class="form-control" value="<?= $numero ?>" required minlength="4" maxlenght="6" data-validation-minlength-message="Informe pelo menos 4 caracteres" data-validation-required-message="Informe o número de sua residência" data-validation-minlength-message="Numero máximo de Caracteres 6">
                </div>
            </div>		
        </div>

        <div class="col-md-3">
            <div class="control-group">
                <label for="cidade">Cidade:</label>
                <div class="controls">
                    <input type="text" name="cidade" id="cidade" class="form-control" value="<?= $cidade ?>" required data-validation-required-message="Informe qual a cidade que o Cliente mora">
                </div>
            </div>		
        </div>

        <div class="col-md-3">
            <div class="control-group">
                <label for="ativo">Status</label>
                <div class="controls">	
                    <select name="ativo" id="ativo" class="form-control" required data-validation-required-message="Selecione o Status do Cliente">
                        <option value="">Selecione uma Opção</option>
                        <option value="1">Ativo</option>
                        <option value="0">Inativo</option>
                    </select>
                </div>
            </div>		
        </div>
        <script type="text/javascript">
<?php
if ($ativo == 0) {
    ?>
                $("#ativo").val("<?= $ativo; ?>");
    <?php
} else {
    ?>
                $("#ativo").val("<?= $ativo; ?>");
    <?php
}
?>
        </script>

        <div class="clearfix"></div>
        <div class="col-md-12">
            <br>
            <button type="submit" class="btn btn-default pull-right"><i class="glyphicon glyphicon-floppy-save"> Salvar</i></button>
        </div>	
    </form>
</div>