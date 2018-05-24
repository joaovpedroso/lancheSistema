<script>
    // VERIFICAR CEP

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