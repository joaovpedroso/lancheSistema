<?php
include "menuVisitante.html";
?>              
<div class="fullbg">
    <div class="formulario">
        <div id="tela_pedido">
            <div class="content container min-heigth-100">
                <div class="top_title shaddow">
                    <h2 class="center">Efetue Login para continuar</h2>

                    <form name="loginUsuario" class="shaddow" method="post" action="verifica.php" novalidate>
                        <div class="row">
                            <div class="control-group">
                                <label class="control-label">CPF: </label>
                                <div class="controls">
                                    <input type="text" name="usuario" class="form-control cpf" placeholder="Preencha CPF" maxlength="14" required  data-mask="999.999.999-99" autofocus data-validation-required-message="Preencha CPF">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="control-group">
                                <label class="control-label"> Senha: </label>
                                <div class="controls">
                                    <input type="password" name="senha" class="form-control" placeholder="Preencha a senha" required data-validation-required-message="Preencha a senha">
                                </div>
                            </div>
                        </div>

                        <div class="row center">
                            <button type="submit" class="btn btn-default">Entrar</button>		
                    </form>
                    <a href="usuario.php" class="btn btn-default">Cadastre - se</a>	
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php
include "rodape.html";
?>
