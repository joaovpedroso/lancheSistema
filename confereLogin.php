<?php
    if ( !isset( $_SESSION["usuario"]["id"] ) ) {

            header( "Location: pedidos.php" );
    }
?>