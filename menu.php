<?php
include "conecta.php";
include "verificaHorario.php";

//Definindo o Local que será padronizada a hora
date_default_timezone_set('America/Sao_Paulo');
$data = date("d-m-Y");
$hora = date("H:i");

//Se não existir sessão aberta, abre uma nova
if (!isset($_SESSION)) {
    session_start();
}

//Função que verifica se o usuário está logado ou não
function verificaSessao() {
    if (isset($_SESSION["usuario"]["id"])) {
        include "menuCliente.html";
        $id_user = trim($_SESSION["usuario"]["id"]);
        
    } else {
        include "menuVisitante.html";
    }
}

//Executar função que verifica se o usuário está logado ou não
verificaSessao();

//Função para formatação de data
function data($date) {

    $hjData = explode("-", $date);
    $dia = $hjData[0];
    $mes = $hjData[1];
    $ano = $hjData[2];

    $hjData = $ano . "-" . $mes . "-" . $dia;

    return $hjData;
}
?>
<script>

    //Validação de CPF com JS
    $('.cpf').change(function(){

    if ($(this).val().length < 14){
    window.alert('CPF Inválido');
    $('.cpf').val('');
    $('.cpf').focus();
    }

//Validar CPF
    if (!validarCpf($(this).val())){
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
    var novo_cpf = calc_digitos_posicoes(digitos);
// Faz o cálculo dos 10 dígitos do CPF para obter o último dígito
    var novo_cpf = calc_digitos_posicoes(novo_cpf, 11);
// Verifica se o novo CPF gerado é idêntico ao CPF enviado
    if (novo_cpf === valor) {
// CPF válido
    return true;
    } else {
// CPF inválido
    return false;
    }
    };
    function calc_digitos_posicoes(digitos, posicoes = 10, soma_digitos = 0) {

// Garante que o valor é uma string
    digitos = digitos.toString();
// Faz a soma dos dígitos com a posição
// Ex. para 10 posições:
//   0    2    5    4    6    2    8    8   4
// x10   x9   x8   x7   x6   x5   x4   x3  x2
//   0 + 18 + 40 + 28 + 36 + 10 + 32 + 24 + 8 = 196
    for (var i = 0;
    i < digitos.length;
    i++) {
// Preenche a soma com o dígito vezes a posição
    soma_digitos = soma_digitos + (digitos[i] * posicoes);
// Subtrai 1 da posição
    posicoes--;
// Parte específica para CNPJ
// Ex.: 5-4-3-2-9-8-7-6-5-4-3-2
    if (posicoes < 2) {
// Retorno a posição para 9
    posicoes = 9;
    }
    }

// Captura o resto da divisão entre soma_digitos dividido por 11
// Ex.: 196 % 11 = 9
    soma_digitos = soma_digitos % 11;
// Verifica se soma_digitos é menor que 2
    if (soma_digitos < 2) {
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