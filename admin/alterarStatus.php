<?php
    include "menu.php";

    if( isset( $_GET['action'] ) ) {
        $acao 	= trim( $_GET['action'] );
        $ped_id = (int) trim( $_GET['id'] );

        if( empty ( $acao ) ) {
            echo "<script>alert('Voce nao pode acessar Esta Página');history.back();</script>";
            exit;
        }
        if( empty ( $ped_id ) ) {
            echo "<script>alert('Voce nao pode acessar Esta Página');history.back();</script>";
            exit;
        }

        //Verificar qual ação de Status será realizada -> 
        // Status 1 - EP -> Em Preparo
        // Status 2 - P  -> Pronto
        // Status 3 - E  -> Em Entrega

        if( $acao == 'ep') {
                $sql = "UPDATE pedido SET id_status = 1 WHERE id = ? LIMIT 1";
                $consulta = $pdo->prepare( $sql );
                $consulta->bindParam(1, $ped_id);
                if ( $consulta->execute() ) {
                        echo "<script>alert('Status Alterado com Sucesso');history.back();</script>";
                } else {
                        echo "<script>alert('Falha ao Alterar Status');history.back();</script>";
                }

        } else if ( $acao == 'p' ) {
                $sql = "UPDATE pedido SET id_status = 2 WHERE id = ? LIMIT 1";
                $consulta = $pdo->prepare( $sql );
                $consulta->bindParam(1, $ped_id);
                if ( $consulta->execute() ) {
                        echo "<script>alert('Status Alterado com Sucesso');history.back();</script>";
                } else {
                        echo "<script>alert('Falha ao Alterar Status');history.back();</script>";
                }
        } else if ( $acao == 'e' ) {
                $sql = "UPDATE pedido SET id_status = 3 WHERE id = ? LIMIT 1";
                $consulta = $pdo->prepare( $sql );
                $consulta->bindParam(1, $ped_id);
                if ( $consulta->execute() ) {
                        echo "<script>alert('Status Alterado com Sucesso');history.back();</script>";
                } else {
                        echo "<script>alert('Falha ao Alterar Status');history.back();</script>";
                }
        } else {
                echo "<script>alert('Voce nao pode acessar Esta Página');history.back();</script>";
        }
    } else {
        echo "<script>alert('Voce nao pode acessar Esta Página');history.back();</script>";
    }
?>