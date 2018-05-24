	
<script type="text/javascript" src="../js/jquery.mask.js"></script>

<script>
    $(document).ready(function () {
        var $cpf = $(".cpf");
        $cpf.mask('000.000.000-00', {reverse: true});
        var $rg = $(".rg");
        $rg.mask('00.000.000-0', {reverse: true});
        var $cep = $(".cep");
        $cep.mask('00000-000', {reverse: true});
    });
</script>	