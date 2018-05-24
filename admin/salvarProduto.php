<?php

include "menu.php";

if ($_POST) {


    //Setando nome padrao para imagens
    $img = "";

    //Verificando se foi enviada imagem no formulário
    if (!empty($_FILES["imagem"]["name"])) {

        //Pegar o tipo do arquivo enviado
        $tipoImg = $_FILES["imagem"]["type"];
        $tamanhoImg = $_FILES["imagem"]["size"];

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
                        $_FILES["imagem"]["tmp_name"],
                        //Salvar na pasta "../img/produtos" com o nome da imagem
                        "../img/produtos/" . $_FILES["imagem"]["name"]
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
            $destino = $pastaImg . $_FILES["imagem"]["name"];

            //Novo nome da imagem de acordo com a hora do momento
            $img = time();

            //Enviar a imagem para pasta -> Destino da imagem, nome da imagem, pasta da imagem
            LoadImg($destino, $img, $pastaImg);
        }

        //Verificar a edição se esta trocando a imagem
    } else if (!empty($_POST["imagem"])) {

        //Variavel da imagem vai receber o nome do campo IMG que esta HIDDEN
        $img = trim($_POST["imagem"]);
    }




    $id = trim($_POST['id']);
    $nome = trim($_POST['nome']);
    $descricao = trim($_POST['descricao']);
    $id_categoria = trim($_POST['categoria']);
    $preco = trim($_POST['preco']);
    $imagem = $img;
    $ativo = trim($_POST['ativo']);

    if (empty($nome)) {
        echo "<script>alert('Preencha o Campo Nome'); history.back();</script>";
        exit;
    }

    if (empty($descricao)) {
        echo "<script>alert('Preencha o Campo Descrição'); history.back();</script>";
        exit;
    }

    if (empty($id_categoria)) {
        echo "<script>alert('Preencha o Campo Categoria'); history.back();</script>";
        exit;
    }

    if (empty($preco)) {
        echo "<script>alert('Preencha o Campo Preço'); history.back();</script>";
        exit;
    }

    if (empty($ativo)) {
        echo "<script>alert('Preencha o Campo Status'); history.back();</script>";
        exit;
    }

    $preco = str_replace(".", "", $preco);
    $preco = str_replace(",", ".", $preco);

    //Se todas validações estiverem corretas, verifica se esta sendo enviado o ID, se não faz um INSERT no BD
    if (empty($id)) {
        $sql = "INSERT INTO produto (id, nome, descricao, id_categoria, preco, imagem, ativo ) VALUES ( NULL, ?, ?, ?, ?, ?, ? ) ";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(1, $nome);
        $consulta->bindParam(2, $descricao);
        $consulta->bindParam(3, $id_categoria);
        $consulta->bindParam(4, $preco);
        $consulta->bindParam(5, $imagem);
        $consulta->bindParam(6, $ativo);
    } else {
        $sql = "UPDATE produto SET nome = ?, descricao = ?, id_categoria = ?, preco = ?, imagem = ?, ativo = ? WHERE id = ? LIMIT 1 ";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(1, $nome);
        $consulta->bindParam(2, $descricao);
        $consulta->bindParam(3, $id_categoria);
        $consulta->bindParam(4, $preco);
        $consulta->bindParam(5, $imagem);
        $consulta->bindParam(6, $ativo);
        $consulta->bindParam(7, $id);
    }

    if ($consulta->execute()) {
        echo "<script>alert('Produto Salvo Com Sucesso'); location.href='listarProduto.php';</script>";
    } else {
        echo "<script>alert('Erro Ao Salvar Produto'); history.back();</script>";
    }
}
?>