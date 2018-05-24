<?php
include "menu.html";

$sobre = "";

$sql = "SELECT * FROM sobre LIMIT 1";
$resultado = $pdo->prepare($sql);
$resultado->execute();

$dados = $resultado->fetch(PDO::FETCH_OBJ);
if (!empty($dados->id)) {

    $sobre = $dados->sobre;
}
?>
<div class="linha"></div>

<div class="fullbg">
    <div class="formulario">
        <div class="content container min-heigth-100">

            <div class="row sobre">
                <div class="col-md-6 text-center sobre-text">
                    <h1 class="text-center">Sobre nossa empresa</h1>
                    <p><?= $sobre; ?></p>
                </div>

                <div class="col-md-6 sobre-map" align="center">
                    <h1>Localização</h1>

                    <iframe class='embed-responsive-item' src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3651.9322579379404!2d-53.28289388555388!3d-23.749794984589656!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94f2d3df719c5ad5%3A0x4c7f9692a23bfdf6!2sR.+Amaro+Tav%C3%A1res%2C+3428+-+Jardim.+Cruzeiro%2C+Umuarama+-+PR%2C+87504-575!5e0!3m2!1spt-BR!2sbr!4v1496278995141" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen alt="Rua amaro tavares, 3428, Conjunto Ouro Preto, Umuarama - PR" title="Rua amaro tavares, 3428, Conjunto Ouro Preto, Umuarama - PR"></iframe>

                </div>
            </div>
        </div>
    </div>
</div>

<?php
include "rodape.html";
?>
