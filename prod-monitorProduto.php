<?php include('header.php'); ?>

<?

?>

<script>

    $(document).ready(function(){
        $("#campoPesquisa").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#tablePrint tbody tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

        $('.select2').select2({
            theme: "bootstrap"
        });
    });
</script>

<!-- conteúdo -->
<div class="content">

    <form id="formularioOrdem" method="POST">
        <input type="hidden" name="cmd" value="add">

        <div class="row mb-3">
            <div class="col">
                <a href="prod-ordem.php" class="btn btn-primary"><i class="fas fa-chevron-left"></i></a>
            </div>
            <div class="col d-flex">
                <button class="btn btn-success ml-auto"><i class="fas fa-save mr-2"></i><strong>Salvar</strong></button>
            </div>
        </div>

        <div class="row">
            <div class="col">

                <h3>Grade</h3>
                <div class="card main-card mb-3">
                    <div class="card-body">

                        <div class="row mb-3">
                            <div class="col-2">
                                <label for="op">O.P.</label>
                                <input type="text" name="op" id="op" value="0" class="form-control" readonly>
                            </div>
                            <div class="col">
                                <label for="lEstoque">Local de estoque</label>
                                <select name="lEstoque" id="lEstoque" class="form-control">
                                    <option selected disabled>Selecione</option>
                                    <?
                                        $resp = $con->query('select nome,id from tbl_locaisEstoque where status = 1');
                                        while($row = $resp->fetch_assoc()){
                                            echo '<option value="'.$row['id'].'">'.$row['nome'].'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-2">
                                <label for="prazo">Prazo de entrega</label>
                                <input type="date" class="form-control" name="prazo" id="prazo" min="<?=date('Y-m-d')?>" required>
                            </div>
                            <div class="col-2">
                                <label for="movimento">Tipo de movimento</label>
                                <select name="movimento" id="movimento" class="form-control">
                                    <option value="0" selected>Estoque</option>
                                    <option value="1">Venda</option>
                                </select>
                            </div>
                            <div class="col-2">
                                <label for="emissao">Emissão</label>
                                <input type="date" name="emissao" id="emissao" class="form-control" value="<?=date('Y-m-d')?>" readonly>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <label for="cliente">Cliente</label>
                                <select name="cliente" id="cliente" class="form-control select2">
                                    <option value="-1" selected disabled>Selecione o cliente</option>
                                    <?
                                        $resp = $con->query('select razaoSocial_nome,id from tbl_clientes where tipoCliente = "on"');
                                        while($row = $resp->fetch_assoc()){
                                            echo '<option value="'.$row['id'].'">'.$row['razaoSocial_nome'].'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col">
                                <label for="observacoes">Observações</label>
                                <textarea name="observacoes" id="observacoes" class="form-control" row="40" style="resize:none" maxlength="400"></textarea>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </form>

</div>
<!-- fim conteúdo -->

<?php include('footer.php');?>