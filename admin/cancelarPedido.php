<?php
    include "menu.php";

    unset( $_SESSION["produtos"] );

    echo "<script>alert('Pedido Cancelado com Sucesso'); location.href='home.php';</script>";

?>