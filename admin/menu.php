<?php
    include "../config/conecta.php";
    include "estiloFontes.html";
    date_default_timezone_set('America/Sao_Paulo');
    $data = date("d-m-Y");
    $hora = date("H:i");

    //Inicia a Sessão
    session_start();

    //Bloqueio de Usuario sem login na sessao ADMIN
    if ( !isset( $_SESSION["admin"]["id"] ) ) {
            //direcionar para o index
            header( "Location: index.php" );
    }

    $tipoSs = $_SESSION['admin']['tipo'];

    if( $tipoSs == 1 ){
            include "menuGerente.php";
    } else {
            include "menuFuncionario.php";
    }

    function data($date){

            $hjData = explode("-", $date);
            $dia  = $hjData[0];
            $mes  = $hjData[1];
            $ano  = $hjData[2];

            $hjData = $ano."-".$mes."-".$dia;

            return $hjData;
    }

    function verificaPermissao(){
        
        $permissao = $_SESSION['admin']['tipo'];
        if( $permissao != 1 ){
            echo "<script>location.href='index.php';</script>";
        }
        
    }
    
?>
<style type="text/css">
    body {
        background: url(../img/bkhome7.jpg) fixed no-repeat top;
        background-size: cover;
    }
</style>