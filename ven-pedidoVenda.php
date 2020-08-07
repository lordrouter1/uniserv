<?php
if(isset($_GET['iLinhas'])){
    setcookie('iLinhas',$_GET['iLinhas']);
    $_COOKIE['iLinhas'] = $_GET['iLinhas'];
}
if(isset($_GET['display'])){
    setcookie('display',$_GET['display']);
    $_COOKIE['display'] = $_GET['display'];
}

if(isset($_COOKIE['carrinho'])){
    $carrinho = (array) json_decode($_COOKIE['carrinho']);
}
else{
    $carrinho = array();
}
if($_POST['id']){
    $carrinho['prod-'.$_POST['id']] = isset($carrinho['prod-'.$_POST['id']])? $carrinho['prod-'.$_POST['id']] + $_POST['qtd'] : $_POST['qtd'];
    setcookie('carrinho',json_encode($carrinho));
}

$qtdCarrinho = sizeof($carrinho);

include('header.php');
?>

<?php
if(isset($_POST['cmd'])){
    $cmd = $_POST['cmd'];
    if($cmd == "add"){
        $query = 'insert into tbl_ordemServico(cliente,descricao,solicitacao,prevEntrega,status) values(
            '.$_POST['cliente'].',
            "'.$_POST['descricao'].'",
            "'.$_POST['solicitacao'].'",
            "'.$_POST['previsao'].'",
            '.$_POST['status'].'
        )';
        #$con->query($query);
        #redirect($con->error);
    }
}

$pedidosCarrinho = 0;

?>
<script>
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

        <div class="page-title-heading btn" onclick="$('#tblCarrinho').toggle('slow');">

            <div class="page-title-icon">
                <i class="fas fa-shopping-basket icon-gradient bg-happy-itmeo"></i>
            </div>
            <div>
                <span>Carrinho</span>
                <div class="page-title-subheading">
                    Total de <span class="badge badge-primary"><?=$qtdCarrinho?></span> itens no carrinho
                </div>
            </div>

        </div>
        
        <div class="page-title-actions">

            <a href="ven-pedidoVenda.php">
                <button class="btn-shadow mr-3 btn btn-info" id="btn-modal" type="button">
                    Finalizar
                </button>
            </a>

        </div>
    </div>

    <div class="row mt-4 p-2 bg-light rounded shadow" id="tblCarrinho" style="display:none">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th></th>
                    <th style="width:18%">Nome</th>
                    <th>Quantidade</th>
                    <th>Descrição</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?
                    $keys = array_keys($carrinho);
                    foreach($keys as $key){
                        $resp = $con->query('select * from tbl_produtos where id = '.explode('-',$key)[1]);
                        $row = $resp->fetch_assoc();
                        echo '
                            <tr>
                                <td><img src="'.$row['imagem'].'" width="30"></td>
                                <td>'.$row['nome'].'</td>
                                <td>'.$row['descricao'].'</td>
                                <td>'.$carrinho[$key].'</td>
                                <td><button class="btn"><i class="fa fa-trash"></i></button></td>
                            </tr>
                        ';
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>
<!-- fim cabeçalho-->

<!-- conteúdo -->
<div class="content">

    <div class="row">
        <div class="col">
            
            <div class="card main-card mb-3">
                <div class="card-body">

                    <div class="row mb-3">
                        <div class="col">
                            <?if($_COOKIE['display']=='grid'):?>
                                <a class="btn text-center" href="?display=list"><h3><i class="fas fa-th"></i></h3></a>
                            <?else:?>
                                <a class="btn text-center" href="?display=grid"><h3><i class="fas fa-bars"></i></h3></a>
                            <?endif;?>
                        </div>
                        <div class="col-6">
                            <input type="text" class="mb-2 form-control" placeholder="Pesquisar" id="campoPesquisa">
                        </div>
                        <div class="col">    
                            <select class="form-control" onchange="location.href='?iLinhas='+$(this).val();">
                                <option selected disabled>Itens por linha</option>
                                <option value="7">7</option>
                                <option value="6">6</option>
                                <option value="5">5</option>
                                <option value="4">4</option>
                                <option value="3">3</option>
                                <option value="2">2</option>
                            </select>
                        </div>
                    </div>

                    <div class="content venda">
                        <?                      
                            $resp = $con->query('select * from tbl_produtos');
                            $itens = $resp->num_rows;
                            $itensLinha = isset($_COOKIE['iLinhas'])?$_COOKIE['iLinhas']:7;
                            $linhas = intval(($itens-1)/$itensLinha)+1;
                            
                            if($_COOKIE['display'] == 'grid'){
                                $cont = 0;
                                for($i=0; $i<$linhas; $i++){
                                    echo '<div class="row mb-2">';
                                    
                                    for($j=0; $j<$itensLinha; $j++){
                                        if($cont == $itens){
                                            echo '
                                                <div class="col d-flex">
                                                </div>
                                            ';
                                        }
                                        else{
                                            $cont++;
                                            $row = $resp->fetch_assoc();
                                            echo '
                                                <div class="col d-flex" style="max-width:50%">
                                                    <div class="card">
                                                        <div class="card-body p-2 d-flex">
                                                            <img class="m-auto" src="'.$row['imagem'].'" style="max-width:100%">
                                                        </div>
                                                        <div class="car-footer p-2" style="bottom:0">
                                                            <h4 class="card-title">'.$row['nome'].'</h4>
                                                            <p class="card-text vendas">'.$row['descricao'].'</p>
                                                            <form method="post">
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <input type="submit" class="btn btn-dark" value="Adicionar">
                                                                    </div>
                                                                    <input type="number" class="form-control" name="qtd" value="1">
                                                                    <input type="hidden" value="'.$row['id'].'" name="id">
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            ';
                                        }
                                    }
                                    
                                    echo '</div>';
                                }
                            }
                            else{
                                while($row = $resp->fetch_assoc()){
                                    echo '
                                        <div class="row mb-3 pb-2 border-bottom">
                                            <div class="col d-flex">
                                                <img class="m-auto" src="'.$row['imagem'].'" height="40">
                                            </div>
                                            <div class="col">
                                                <h4 class="card-title">'.$row['nome'].'</h4>
                                            </div>
                                            <div class="col">
                                                <p class="card-text vendas">'.$row['descricao'].'</p>
                                            </div>
                                            <div class="col d-flex">
                                                <a href="?add='.$row['id'].'" class="btn btn-dark m-auto">Adicionar</a>
                                            </div>
                                        </div>
                                    ';
                                }
                            }
                        ?>
                    
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
<!-- fim conteúdo -->

<?php include('footer.php');?>

<!-- modal -->
<div class="modal show" tabindex="-1" role="dialog" id="mdl-cliente">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adicionar novo cliente</h5>
                <button type="button" class="close" onclick="location.href='?'" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post">

                    <?php
                        if(isset($_GET['edt'])){
                            $resp = $con->query('select * from tbl_ordemServico where id = '.$_GET['edt']);
                            $ordemServico = $resp->fetch_assoc();
                        }
                    ?>

                    <input type="hidden" value="<?php echo isset($_GET['edt'])?'edt':'add';?>" name="cmd">
                    <input type="hidden" value="<?php echo $_GET['edt'];?>" name="id" id="id">

                    <div class="row">
                        <div class="col">
                            <label for="cliente">Cliente<span class="ml-2 text-danger">*</span></label>
                            <select class="form-control mb-3" name="cliente" id="cliente" required>
                                <option <?php echo isset($_GET['edt'])? '':'selected';?> disabled>Selecione o cliente</option>
                                <?php
                                    $resp = $con->query('select id, razaoSocial_nome from tbl_clientes where tipoCliente="on"');
                                    while($row = $resp->fetch_assoc()){
                                        $selected = $ordemServico['cliente'] == $row['id']? 'selected':'';
                                        echo '<option value="'.$row['id'].'" '.$selected.'>'.$row['razaoSocial_nome'].'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-3">
                            <label for="status">Status</label>
                            <select class="form-control mb-3" name="status" id="status">
                                <option value="1" <?php echo $ordemServico['status'] == '2' || !isset($_GET['edt'])? 'selected':'';?>>Aguardando</option>
                                <option value="2" <?php echo $ordemServico['status'] == '2'? 'selected':'';?>>Em andamento</option>
                                <option value="3" <?php echo $ordemServico['status'] == '3'? 'selected':'';?>>Aguardando aprovação</option>
                                <option value="4" <?php echo $ordemServico['status'] == '4'? 'selected':'';?>>Finalizado</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label for="solicitacao">Data de Solicitação</label>
                            <input type="date" value="<?php echo $ordemServico['solicitacao'];?>" class="form-control mb-3" name="solicitacao" id="solicitacao">
                        </div>
                        <div class="col">
                            <label for="previsao">Previsão de entrega</label>
                            <input type="date" value="<?php echo $ordemServico['prevEntrega'];?>" class="form-control mb-3" name="previsao" id="previsao">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label for="descricao">Descrição</label>
                            <textarea class="form-control mb-3" name="descricao" id="descricao" style="resize:none;"><?php echo $ordemServico['descricao'];?></textarea>
                        </div>
                    </div>

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