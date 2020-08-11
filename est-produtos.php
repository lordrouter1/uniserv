<?php include('header.php'); ?>

<?php

if(isset($_POST['cmd'])){
    $cmd = $_POST['cmd'];

    if($cmd == "add"){
        $target_dir = 'upload/';
        $target_file = $target_dir . date('dmY') .basename($_FILES['imagem']['name']);
        $uploadOk = 1;

        $check = getimagesize($_FILES["imagem"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }

        if($uploadOk === 1){
            if(move_uploaded_file($_FILES["imagem"]["tmp_name"],$target_file)){
                $query = 'INSERT INTO `tbl_produtos`(`valor`,`referencia`,`nome`,`unidadeEstoque`,`grupo`,`subgrupo`,`tipoProduto`,`fornecedor`,`usoConsumo`, `comercializavel`, `descontoMinimo`, `descontoMaximo`, `classificacaoFiscal`, `codBarras`, `descricao`, `imagem`) VALUES (
                    "'.$_POST['valor'].'",
                    "'.$_POST['referencia'].'",
                    "'.$_POST['nome'].'",
                    "'.$_POST['un_estoque'].'",
                    "'.$_POST['grupo'].'",
                    "'.$_POST['subgrupo'].'",
                    "'.$_POST['tipoDeProduto'].'",
                    "'.$_POST['fornecedor'].'",
                    "'.isset($_POST['usoConsumo']).'",
                    "'.isset($_POST['comercializavel']).'",
                    "'.$_POST['descontoMinimo'].'",
                    "'.$_POST['descontoMaximo'].'",
                    "'.$_POST['classificacao_fiscal'].'",
                    "'.$_POST['codigoBarras'].'",
                    "'.addslashes($_POST['descricao']).'",
                    "'.$target_file.'"           
                )';
                $con->query($query);
                redirect($con->error);
            }
        }
    }
    elseif($cmd == "edt"){
        if($_FILES['imagem']['name'] != ''){
            $target_dir = 'upload/';
            $target_file = $target_dir . date('dmY') .basename($_FILES['imagem']['name']);
            $uploadOk = 1;

            $check = getimagesize($_FILES["imagem"]["tmp_name"]);
            if($check !== false) {
                $uploadOk = 1;
            } else {
                $uploadOk = 0;
            }

            if($uploadOk === 1){
                if(move_uploaded_file($_FILES["imagem"]["tmp_name"],$target_file)){
                    unlink($_POST['imagemAntiga']);
                    $query = 'UPDATE `tbl_produtos` SET 
                        `referencia`= "'.$_POST['referencia'].'",
                        `nome`= "'.$_POST['nome'].'",
                        `unidadeEstoque`= "'.$_POST['un_estoque'].'",
                        `grupo`= "'.$_POST['grupo'].'",
                        `subgrupo`= "'.$_POST['subgrupo'].'",
                        `tipoProduto`= "'.$_POST['tipoDeProduto'].'",
                        `fornecedor`= "'.$_POST['fornecedor'].'",
                        `usoConsumo`= "'.isset($_POST['usoConsumo']).'",
                        `comercializavel`= "'.isset($_POST['comercializavel']).'",
                        `descontoMinimo`= "'.$_POST['descontoMinimo'].'",
                        `descontoMaximo`= "'.$_POST['descontoMaximo'].'",
                        `classificacaoFiscal`= "'.$_POST['classificacao_fiscal'].'",
                        `codBarras`= "'.$_POST['codigoBarras'].'",
                        `descricao`= "'.addslashes($_POST['descricao']).'",
                        `imagem`= "'.$target_file.'",
                        `valor` = "'.$_POST['valor'].'"
                        WHERE `id` = "'.$_POST['id'].'"
                    ';
                }
            }
        }
        else{
            $query = 'UPDATE `tbl_produtos` SET 
                `referencia`= "'.$_POST['referencia'].'",
                `nome`= "'.$_POST['nome'].'",
                `unidadeEstoque`= "'.$_POST['un_estoque'].'",
                `grupo`= "'.$_POST['grupo'].'",
                `subgrupo`= "'.$_POST['subgrupo'].'",
                `tipoProduto`= "'.$_POST['tipoDeProduto'].'",
                `fornecedor`= "'.$_POST['fornecedor'].'",
                `usoConsumo`= "'.isset($_POST['usoConsumo']).'",
                `comercializavel`= "'.isset($_POST['comercializavel']).'",
                `descontoMinimo`= "'.$_POST['descontoMinimo'].'",
                `descontoMaximo`= "'.$_POST['descontoMaximo'].'",
                `classificacaoFiscal`= "'.$_POST['classificacao_fiscal'].'",
                `codBarras`= "'.$_POST['codigoBarras'].'",
                `descricao`= "'.addslashes($_POST['descricao']).'",
                `valor` = "'.$_POST['valor'].'"
                WHERE `id` = "'.$_POST['id'].'"
            ';
        }
        $con->query($query);
        redirect($con->error);
    }
}
elseif(isset($_GET['del'])){
    $con->query('delete from tbl_produtos where id = '.$_GET['del']);
    redirect($con->error);
}

?>
<script>
    async function imprimir(){
        const divPrint = document.getElementById('tablePrint');
        newWin = window.open('');
        newWin.document.write('<link href="./main.css" rel="stylesheet">');
        newWin.document.write('<link href="./assets/css/print.css" rel="stylesheet">');
        newWin.document.write('<button class="btn m-2 bg-primary noPrint" onclick="window.print();window.close()"><i class="fa fa-print text-white"></i></button><br><br><h5 class="mb-3">Unidades Cadastradas</h5>');
        newWin.document.write(divPrint.outerHTML);
    }

    function selecionaGrupo(self){
        $('#grupoUnidadeNome').val($(self).val());
        $('#unBase').val(0);
    }

    function gerarCodBarras(){
        const codBarras = ('0000000000000' + $('#referencia').val()).slice(-13);
        $('#codigoBarras').val(codBarras);
    }

    $(document).ready(function(){
        $("#campoPesquisa").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#tablePrint tbody tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>

<!-- cabeçalho da página -->
<div class="app-page-title">

    <div class="page-title-wrapper">

        <div class="page-title-heading">

            <div class="page-title-icon">
                <i class="fas fa-boxes icon-gradient bg-happy-itmeo"></i>
            </div>
            <div>
                <span>Cadastro de produtos</span>
                <div class="page-title-subheading">
                    Campo para adição, remoção e edição de produtos
                </div>
            </div>

        </div>
        <div class="page-title-actions">

            <button class="btn-shadow mr-3 btn btn-dark" id="btn-modal" type="button" data-toggle="modal" data-target="#mdl-cliente">
                <i class="fas fa-plus"></i>
            </button>

            <div class="d-inline-block dropdown">
                <button class="btn-shadow dropdown-toggle btn btn-info" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="btn-icon-wrapper pr-2 opacity-7">
                        <i class="fa fa-business-time fa-w-20"></i>
                    </span>
                    Ações
                </button>
                <div class="dropdown-menu dropdown-menu-right" tabindex="-1" role="menu" x_placement="bottom-end">
                    <ul class="nav flex-column">
                        <li class="nav-item">

                            <a class="nav-link text-dark" onclick="imprimir()">
                                Imprimir
                            </a>
                            <a class="nav-link text-dark" target="_blank" href="exp.php?tbl=unidades">
                                Exportar
                            </a>
                        
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- fim cabeçalho-->

<!-- conteúdo -->
<div class="content">

    <div class="row">
        <div class="col">
            
            <div class="card main-card mb-3">
                <div class="card-body">

                    <h5 class="card-title">Produtos</h5>
                    <input type="text" class="mb-2 form-control w-25" placeholder="Pesquisar" id="campoPesquisa">

                    <table class="table mb-0 table-striped table-hover" id="tablePrint">
                        <thead >
                            <tr>
                                <th style="width:2%">ID</th>
                                <th></th>
                                <th style="width:20%">Nome</th>
                                <th style="width:8%">referencia</th>
                                <th style="width:14%">Grupo</th>
                                <th style="width:14%">Subgrupo</th>
                                <th>Descricao</th>
                                <th class="noPrint"></th>
                                <th class="noPrint"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $resp = $con->query('select * from tbl_produtos');
                            
                                while($row = $resp->fetch_assoc()){
                                    echo '
                                        <tr>
                                            <td>'.str_pad($row['id'],3,"0",STR_PAD_LEFT).'</td>
                                            <td><img src="'.$row['imagem'].'" width="60"></td>
                                            <td>'.$row['nome'].'</td>
                                            <td>'.$row['referencia'].'</td>
                                            <td>'.$row['grupo'].'</td>
                                            <td>'.$row['subgrupo'].'</td>
                                            <td>'.$row['descricao'].'</td>
                                            <td class="noPrint text-center"><a href="?edt='.$row['id'].'" class="btn"><i class="fas fa-user-edit icon-gradient bg-happy-itmeo"></i></a></td>
                                            <td class="noPrint text-center"><a href="?del='.$row['id'].'" class="btn"><i class="fas fa-trash icon-gradient bg-happy-itmeo"></i></a></td>
                                        </tr>
                                    ';
                                }
                        
                            ?>
                        </tbody>
                    </table>

                </div>
            </div>

        </div>
    </div>

</div>
<!-- fim conteúdo -->

<?php include('footer.php');?>

<!-- modal -->
<div class="modal show" tabindex="-1" role="dialog" id="mdl-cliente">
    <div class="modal-dialog modal-xg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adicionar novo produto</h5>
                <button type="button" class="close" onclick="location.href='?'" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" autocomplete="off" enctype="multipart/form-data">

                    <?php
                        if(isset($_GET['edt'])){
                            $resp = $con->query('select * from tbl_produtos where id = '.$_GET['edt']);
                            $prod = $resp->fetch_assoc();
                        }
                        else{
                            $resp = $con->query('select id from tbl_produtos order by id desc limit 1');
                            $lastid = $resp->fetch_assoc()['id']+1;
                        }
                    ?>

                    <input type="hidden" value="<?php echo isset($_GET['edt'])?'edt':'add';?>" name="cmd">
                    <input type="hidden" value="<?php echo $_GET['edt'];?>" name="id" id="id">

                    <div class="row">
                        <div class="col-1">
                            <label for="codigo">codigo</label>
                            <input type="text" value="<?= isset($_GET['edt'])?$_GET['edt']:$lastid;?>" class="form-control mb-3" name="codigo" id="codigo" maxlength="" readonly>
                        </div>
                        <div class="col-2">
                            <label for="referencia">Referência</label>
                            <input type="text" value="<?= isset($_GET['edt'])?$prod['referencia']:$lastid;?>" class="form-control mb-3" name="referencia" id="referencia" maxlength="20">
                        </div>
                        <div class="col">
                            <label for="nome">Nome<span class="ml-2 text-danger">*</span></label>
                            <input type="text" value="<?=$prod['nome'];?>" class="form-control mb-3" name="nome" id="nome" maxlength="200" required>
                        </div>
                        <div class="col-2">
                            <label for="un_estoque">Únidade de estoque<span class="ml-2 text-danger">*</span></label>
                            <select class="form-control mb-3" name="un_estoque" id="un_estoque" required>
                                <option selected disabled>Selecione</option>
                                <?php
                                    $resp = $con->query('select simbolo,nome,id from tbl_unidades order by grupoNome');
                                    while($row = $resp->fetch_assoc()){
                                        echo '<option value="'.$row['id'].'" '.($prod['unidadeEstoque'] == $row['id']?'selected':'').'>'.$row['simbolo'].' - '.$row['nome'].'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                        
                    </div>

                    <div class="row">
                                              
                        <div class="col">
                            <label for="grupo">Grupo<span class="ml-2 text-danger">*</span></label>
                            <input type="text" value="<?=$prod['grupo'];?>" list="listaGrupo" class="form-control mb-3" name="grupo" id="grupo" autocomplete="false" maxlength="80" required>
                            <datalist id="listaGrupo">
                                <?
                                    $resp = $con->query('select grupo from tbl_produtos group by grupo;');
                                    while($row = $resp->fetch_assoc()){
                                        echo '<option value="'.$row['grupo'].'">';
                                    }
                                ?>
                            </datalist>
                        </div>
                        <div class="col">
                            <label for="subgrupo">Subgrupo</label>
                            <input type="text" value="<?=$prod['subgrupo'];?>" class="form-control mb-3" list="listaSubgrupo" name="subgrupo" id="subgrupo" maxlength="80" autocomplete="false">
                            <datalist id="listaSubgrupo">
                                <?
                                    $resp = $con->query('select subgrupo from tbl_produtos group by subgrupo;');
                                    while($row = $resp->fetch_assoc()){
                                        echo '<option value="'.$row['subgrupo'].'">';
                                    }
                                ?>
                            </datalist>
                        </div>
                        <div class="col">
                            <label for="fornecedor">Fornecedor<span class="ml-2 text-danger">*</span></label>
                            <select class="form-control mb-3" name="fornecedor" id="fornecedor" required>
                                <option selected disabled>Selecione</option>
                                <?php
                                    $resp = $con->query('select id,razaoSocial_nome from tbl_clientes where tipoFornecedor = "on"');
                                    while($row = $resp->fetch_assoc()){
                                        echo '<option value="'.$row['id'].'" '.($prod['fornecedor'] == $row['id']?'selected':'').'>'.$row['razaoSocial_nome'].'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-2 d-flex">
                            <div class="form-check mt-auto mb-auto">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" value="" name="usoConsumo" <?=$prod['usoConsumo']?'checked':'';?>>Uso e consumo
                                </label>
                            </div>
                        </div>
                        <div class="col-2 d-flex">
                            <div class="form-check mt-auto mb-auto">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" value="" name="comercializavel" <?=$prod['comercializavel']?'checked':'';?>>Comercializável
                                </label>
                            </div>
                        </div>
                        <div class="col">
                            <label for="tipodeProduto">Tipo de produto<span class="ml-2 text-danger">*</span></label>
                            <select name="tipoDeProduto" id="tipoDeProduto" class="form-control">
                                <option value="0" <?=$prod['tipoProduto']==0?'selected':'';?>>Acabado</option>
                                <option value="1" <?=$prod['tipoProduto']==1?'selected':'';?>>Semi acabado</option>
                                <option value="2" <?=$prod['tipoProduto']==2?'selected':'';?>>Matéria prima</option>
                            </select>
                        </div>
                        <div class="col">
                            <label for="descontoMinimo">Desconto mínimo</label>
                            <input type="number" value="<?=$prod['descontoMinimo'];?>" step="0.01" min="0" class="form-control" name="descontoMinimo">
                        </div>
                        <div class="col">
                            <label for="valor">Valor</label>
                            <input type="number" value="<?=$prod['valor'];?>" step="0.01" min="0" class="form-control" name="valor">
                        </div>
                        <div class="col">
                            <label for="descontoMaximo">Desconto máximo</label>
                            <input type="number" value="<?=$prod['descontoMaximo'];?>" step="0.01" min="0" class="form-control" name="descontoMaximo">
                        </div>
                        <div class="col-3">
                            <label for="classificacao_fiscal">Classificação fiscal<span class="ml-2 text-danger">*</span></label>
                            <select class="form-control mb-3" name="classificacao_fiscal" id="classificacao_fiscal" required>
                                <option selected disabled>Selecione</option>
                                <?php
                                    $resp = $con->query('select id,nome from tbl_classificacaoFiscal');
                                    while($row = $resp->fetch_assoc()){
                                        echo '<option value="'.$row['id'].'" '.($prod['classificacaoFiscal'] == $row['id']?'selected':'').'>'.$row['nome'].'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="divider"></div>

                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a href="#codBarras" data-toggle="tab" class="nav-link">Código de barras</a>
                        </li>
                        <li class="nav-item">
                            <a href="#outros" data-toggle="tab" class="nav-link">Outros</a>
                        </li>
                    </ul>

                    <div class="tab-contents">
                        <div class="tab-pane active fade" id="codBarras">
                            <div class="row">
                                <div class="col-3">
                                    <label for="codigoBarras">Código de Barras</label>
                                    <div class="input-group d-flex">
                                        <input type="text" value="<?=str_pad($prod['codBarras'],13,'0',STR_PAD_LEFT);?>" class="form-control" maxlength="14" name="codigoBarras" id="codigoBarras">
                                        <span class="btn btn-link mt-auto mb-auto" onclick="gerarCodBarras()">Gerar</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="outros">
                            <div class="row">
                                <div class="col">
                                    <label for="descricao">Descricao<span class="ml-2 text-danger">*</span></label>
                                    <!--<input type="text" value="" class="form-control mb-3" name="descricao" id="descricao" maxlength="" required>-->
                                    <textarea class="form-control mb-3" style="resize:none;" rows="5" name="descricao"><?=$prod['descricao'];?></textarea>
                                </div>
                                <div class="col">
                                    <label for="imagem">Imagem</label>
                                    <input type="file" class="form-control p-0" name="imagem" accept="image/*">
                                    <input type="hidden" name="imagemAntiga" value="<?=$prod['imagem'];?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--<div id="accordion" class="border">

                        <div class="card mb-1">
                            <a href="#campoPermissoes" class="card-link" data-toggle="collapse">
                                <div class="card-header bg-light text-dark">
                                    <i class="fas fa-bars mr-3"></i>Permissões
                                </div>
                            </a>
                            <div id="campoPermissoes" class="collapse show" data-parent="#accordion">
                                <div class="card-body">
                                    teset
                                </div>
                            </div>
                        </div>

                        <div class="card mb-1">
                            <a href="#campoProducaoOutros" class="card-link" data-toggle="collapse">
                                <div class="card-header bg-light text-dark">
                                    <i class="fas fa-bars mr-3"></i>Produção e outros
                                </div>
                            </a>
                            <div id="campoProducaoOutros" class="collapse" data-parent="#accordion">
                                <div class="card-body">
                                    teset
                                </div>
                            </div>
                        </div>

                        <div class="card mb-1">
                            <a href="#campoEspecificacoesTecnicas" class="card-link" data-toggle="collapse">
                                <div class="card-header bg-light text-dark">
                                    <i class="fas fa-bars mr-3"></i>Especificações técnicas
                                </div>
                            </a>
                            <div id="campoEspecificacoesTecnicas" class="collapse" data-parent="#accordion">
                                <div class="card-body">
                                    teset
                                </div>
                            </div>
                        </div>

                        <div class="card mb-1">
                            <a href="#campoParametrosEstoqueLocal" class="card-link" data-toggle="collapse">
                                <div class="card-header bg-light text-dark">
                                    <i class="fas fa-bars mr-3"></i>Parâmetros de estoque por local
                                </div>
                            </a>
                            <div id="campoParametrosEstoqueLocal" class="collapse" data-parent="#accordion">
                                <div class="card-body">
                                    teset
                                </div>
                            </div>
                        </div>

                        <div class="card mb-1">
                            <a href="#campoParametrosCusto" class="card-link" data-toggle="collapse">
                                <div class="card-header bg-light text-dark">
                                    <i class="fas fa-bars mr-3"></i>Parâmetros de custo
                                </div>
                            </a>
                            <div id="campoParametrosCusto" class="collapse" data-parent="#accordion">
                                <div class="card-body">
                                    teset
                                </div>
                            </div>
                        </div>

                        <div class="card mb-1">
                            <a href="#campoCodigoBarras" class="card-link" data-toggle="collapse">
                                <div class="card-header bg-light text-dark">
                                    <i class="fas fa-bars mr-3"></i>Código de barras
                                </div>
                            </a>
                            <div id="campoCodigoBarras" class="collapse" data-parent="#accordion">
                                <div class="card-body">
                                    teset
                                </div>
                            </div>
                        </div>

                        <div class="card mb-1">
                            <a href="#campoTabelaPreco" class="card-link" data-toggle="collapse">
                                <div class="card-header bg-light text-dark">
                                    <i class="fas fa-bars mr-3"></i>Tabela de preço
                                </div>
                            </a>
                            <div id="campoTabelaPreco" class="collapse" data-parent="#accordion">
                                <div class="card-body">
                                    teset
                                </div>
                            </div>
                        </div>

                        <div class="card mb-1">
                            <a href="#campoDatas" class="card-link" data-toggle="collapse">
                                <div class="card-header bg-light text-dark">
                                    <i class="fas fa-bars mr-3"></i>Datas
                                </div>
                            </a>
                            <div id="campoDatas" class="collapse" data-parent="#accordion">
                                <div class="card-body">
                                    teste
                                </div>
                            </div>
                        </div>

                        <div class="card mb-1">
                            <a href="#campoMarketPlace" class="card-link" data-toggle="collapse">
                                <div class="card-header bg-light text-dark">
                                    <i class="fas fa-bars mr-3"></i>Integração Market Place
                                </div>
                            </a>
                            <div id="campoMarketPlace" class="collapse" data-parent="#accordion">
                                <div class="card-body">
                                    teset
                                </div>
                            </div>
                        </div>

                        <div class="card mb-1">
                            <a href="#campoCaracteristicasProdutos" class="card-link" data-toggle="collapse">
                                <div class="card-header bg-light text-dark">
                                    <i class="fas fa-bars mr-3"></i>Características dos produtos
                                </div>
                            </a>
                            <div id="campoCaracteristicasProdutos" class="collapse" data-parent="#accordion">
                                <div class="card-body">
                                    teset
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <a href="#campoChecagem" class="card-link" data-toggle="collapse">
                                <div class="card-header bg-light text-dark">
                                    <i class="fas fa-bars mr-3"></i>Tipos de checagem - Equipamentos na OS
                                </div>
                            </a>
                            <div id="campoChecagem" class="collapse" data-parent="#accordion">
                                <div class="card-body">
                                    teset
                                </div>
                            </div>
                        </div>

                    </div>-->

                    <input id="needs-validation" class="d-none" type="submit" value="enviar">

                </form>
                <script>
                    $(document).ready(function(){
                        $("#cpfResponsavel").mask('000.000.000-00', {reverse: true});
                        $("#telefoneEmpresa").mask('(99) 99999-9999');
                        $("#telefoneWhatsapp").mask('(99) 99999-9999');
                        $("#cep").mask('99999-999');
                    });
                </script>

            </div>
            <div class="modal-footer">
                <p class="text-start"><span class="ml-2 text-danger">*</span> Campos obrigatórios</p>
                <button type="button" class="btn btn-secondary" onclick="location.href='?'">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="document.getElementById('needs-validation').click();"><?php echo isset($_GET['edt'])? 'Atualizar':'Salvar';?></button>
            </div>
        </div>
    </div>
</div>
<!-- fim modal -->

<div id="toast-container" class="toast-top-center">
    <div id="toast-success" class="toast toast-success" aria-live="polite" style="opacity: 0.899999;display:none;">
        <div class="toast-title">Sucesso!</div>
    </div>
    <div id="toast-error" class="toast toast-error hidden" aria-live="polite" style="opacity: 0.899999;display:none;">
        <div class="toast-title">Erro!</div>
    </div>
    <?php
        if(isset($_GET['s']))
            echo "<script>loadToast(true);</script>";
        else if(isset($_GET['e']))
            echo "<script>loadToast(false);</script>";
    ?>
</div>

<?php if(isset($_GET['edt'])) echo "<script>$('#btn-modal').click()</script>"; ?>