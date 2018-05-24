<?php

include "menu.php";

if ($_POST) {
    $id = trim($_POST["id"]);
    $titulo = trim($_POST["titulo"]);
    $datainicio = trim($_POST["data_inicio"]);
    $datatermino = trim($_POST["data_fim"]);
    $total = trim($_POST["total"]);

    if (empty($titulo)) {
        echo "<script>alert('Preencha o Campo Título'); history.back();</script>";
        exit;
    } else if (empty($datainicio)) {
        echo "<script>alert('Preencha a Data Inicial'); history.back();</script>";
        exit;
    } else if (empty($datatermino)) {
        echo "<script>alert('Preencha a Data de Término'); history.back();</script>";
        exit;
    } else if (empty($total)) {
        echo "<script>alert('Informe o valor total dos itens'); history.back();</script>";
        exit;
    }

    $img = "";


    //Verificando se foi enviada imagem no formulário
    if (!empty($_FILES["imagem_principal"]["name"])) {

        //Pegar o tipo do arquivo enviado
        $tipoImg = $_FILES["imagem_principal"]["type"];
        $tamanhoImg = $_FILES["imagem_principal"]["size"];

        //Transformando tamanho em KBytes
        $tamanhoImg = $tamanhoImg / 1024;

        //Formatar o tamanho com 3 casas decimais após "."" e a unidade "" vazio
        $tamanhoImg = number_format($tamanhoImg, 3, ".", "");

        //Verificar se é um arquivo JPG ( IMAGEM )
        if ($tipoImg != "image/jpeg") {
            echo "<script>alert('Você pode enviar somente arquivos JPG. Formato enviado $tipoImg.');history.back();</script>";
            exit;
        }
        //Verificar o tamanho se é maior q 1 MB
        else if ($tamanhoImg > 1024) {
            echo "<script>alert('Envie imagens com até 1 MB. Tamanho da imagem atual $tamanhoImg Kb');history.back();</script>";
        }
        //Se tiver OK Verificar se a imagem foi enviada para a pasta de imagens
        else if (!copy(
                        //Pegar nome temporário
                        $_FILES["imagem_principal"]["tmp_name"],
                        //Salvar na pasta "../img/produtos" com o nome da imagem
                        "../img/produtos/" . $_FILES["imagem_principal"]["name"]
                )
        ) {

            echo "<script>alert('Erro ao enviar arquivo para o sistema');history.back();</script>";
        }
        //Se tiver tudo OK
        else {

            //Incluir arquivo que faz a formatação das imagens
            include "../externos/imagem.php";

            //Declarar locais
            //Pasta onde vai salvar as imagens
            $pastaImg = "../img/produtos/";

            //Pasta com nome da imagem - URL
            $destino = $pastaImg . $_FILES["imagem_principal"]["name"];

            //Novo nome da imagem de acordo com a hora do momento
            $img = time();

            //Enviar a imagem para pasta -> Destino da imagem, nome da imagem, pasta da imagem
            LoadImg($destino, $img, $pastaImg);
        }

        //Verificar a edição se esta trocando a imagem
    } else if (!empty($_POST["imagem_principal"])) {

        //Variavel da imagem vai receber o nome do campo IMG que esta HIDDEN
        $img = trim($_POST["imagem_principal"]);
    }

    if (empty($id)) {
        $produtos = $_POST["produtosPromo"];
        if (empty($produtos)) {
            echo "<script>alert('Selecione ao menos 1 produto'); history.back();</script>";
            exit;
        }
        $pdo->beginTransaction();
        $sql = "INSERT INTO promocao (id, titulo, data_inicio, data_fim, imagem, total) VALUES (NULL, ?, ?, ?, ?, ?)";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(1, $titulo);
        $consulta->bindParam(2, $datainicio);
        $consulta->bindParam(3, $datatermino);
        $consulta->bindParam(4, $img);
        $consulta->bindParam(5, $total);

        if ($consulta->execute()) {
            $id_promo = $pdo->lastInsertId();
            foreach ($produtos as $prods) {
                $sqlProd = "INSERT INTO promocao_produto (id_promocao, id_produto) VALUE (?, ?)";
                $consultaProd = $pdo->prepare($sqlProd);
                $consultaProd->bindParam(1, $id_promo);
                $consultaProd->bindParam(2, $prods);
                $consultaProd->execute();
            }

            $pdo->commit();
            echo "<script>alert('Promoção cadastrada'); location.href='listarPromocao.php';</script>";
        } else {
            $pdo->rollBack();
            echo "<script>alert('ERRO ao cadastrar promoção, tente novamente mais tarde'); history.back();</script>";
            exit;
        }
    } else {
        $pdo->beginTransaction();
        $sql = "UPDATE promocao SET titulo = ?, data_inicio = ?, data_fim = ?, imagem = ?, total = ? WHERE id = ? LIMIT 1";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(1, $titulo);
        $consulta->bindParam(2, $datainicio);
        $consulta->bindParam(3, $datatermino);
        $consulta->bindParam(4, $img);
        $consulta->bindParam(5, $total);
        $consulta->bindParam(6, $id);

        if ($consulta->execute()) {
            echo "<script>alert('Promoção Salva'); location.href='listarPromocao.php';</script>";
            $pdo->commit();
        } else {
            $pdo->rollBack();
            echo "<script>alert('ERRO ao salvar promoção, tente novamente mais tarde'); history.back();</script>";
            exit;
        }
    }
}