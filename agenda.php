<?php include('header.php'); ?>
<?php include('menu.php'); ?>

<?php
if(isset($_POST['cmd'])){
    $cmd = $_POST['cmd'];

    if($cmd == "add"){
        $query = 'insert into tbl_contratos(cliente,dataInicial,dataFinal,primeiroVencimento,diaVencimento,duracao,status) values(
            '.$_POST['cliente'].',
            "'.$_POST['dataInicial'].'",
            "'.$_POST['dataFinal'].'",
            "'.$_POST['primeiroVencimento'].'",
            '.$_POST['diaVencimento'].',
            '.$_POST['duracao'].',
            1
        )';
        $con->query($query);

        $contratoID = $con->insert_id;

        $servico = json_decode($_POST['servicos']);
        for($i = 0; $i < sizeof($servico); $i++){
            $con->query('insert into tbl_contratosServicos(servicos,valor,contrato) values('.$servico[$i]->servico.','.$servico[$i]->valor.','.$contratoID.');');
        }

        redirect($con->error);
    }
    elseif($cmd == "edt"){
        $query = 'update tbl_contratos set 
            cliente = '.$_POST['cliente'].',
            dataInicial = "'.$_POST['dataInicial'].'",
            dataFinal = "'.$_POST['dataFinal'].'",
            primeiroVencimento = "'.$_POST['primeiroVencimento'].'",
            diaVencimento = '.$_POST['diaVencimento'].',
            duracao = '.$_POST['duracao'].',
            status = '.$_POST['status'].'
            where id = '.$_POST['id'].'
        ';
        echo "<script>location.href='?s'</script>";
        $con->query($query);
        
        $con->query('delete from tbl_contratosServicos where contrato = '.$_POST['id']);
        $servico = json_decode($_POST['servicos']);
        for($i = 0; $i < sizeof($servico); $i++){
            $con->query('insert into tbl_contratosServicos(servicos,valor,contrato) values('.$servico[$i]->servico.','.$servico[$i]->valor.','.$_POST['id'].');');
        }
        
        redirect($con->error);
            
    }
}
elseif(isset($_GET['del'])){
    $con->query('delete from tbl_contratos where id ='.$_GET['del']);
    $con->query('delete from tbl_contratosServicos where contrato = '.$_GET['del']);
    redirect($con->error);
}

?>
<script src="assets/scripts/agenda.js"></script>

<!-- cabeçalho da página -->
<div class="app-page-title">

    <div class="page-title-wrapper">

        <div class="page-title-heading">

            <div class="page-title-icon">
                <i class="fas fa-file-contract icon-gradient bg-happy-itmeo"></i>
            </div>
            <div>
                <span>Cadastro de Contratos</span>
                <div class="page-title-subheading">
                    Campo para adição, remoção e edição de contratos
                </div>
            </div>

        </div>
        <div class="page-title-actions">

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
                            <a class="nav-link text-dark" target="_blank" href="exp.php?tbl=clientes">
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
                    <div class="row">

                        <div class="col">
                            <div id="calendario">
                                <?php
                                    if(isset($_GET['mes'])){
                                        $mes = strtotime($_GET['ano'].'/'.$_GET['mes'].'/01');
                                    }
                                    else{
                                        $mes = strtotime(date("Y/m/01"));
                                    }
                                    $sInicio = date("N",$mes);
                                    $dFim = date("t",$mes);
                                    $meses = ["Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro"];
                                    
                                    $nMes = date("m",$mes);
                                    $nAno = date("Y",$mes);
                                    $nDia = date("d");

                                    $pMes = 0;
                                    $pAno = 0;
                                    if($nMes + 1 > 12){
                                        $pMes = 1;
                                        $pAno = $nAno + 1;
                                    }
                                    else{
                                        $pMes = $nMes + 1;
                                        $pAno = $nAno;
                                    }

                                    $aMes = 0;
                                    $aAno = 0;
                                    if($nMes - 1 < 1){
                                        $aMes = 12;
                                        $aAno = $nAno - 1;
                                    }
                                    else{
                                        $aMes = $nMes - 1;
                                        $aAno = $nAno;
                                    }
                                ?>
                                
                                <div class="fc-toolbar fc-header-toolbar">
                                    <div class="fc-left">
                                        <div class="btn-group">
                                            <a href="?mes=<?php echo $aMes;?>&ano=<?php echo $aAno;?>">
                                                <button type="button" class="fc-prev-button btn btn-light mr-1" aria-label="prev"><span class="fa fa-chevron-left"></span></button>
                                            </a>
                                            <a href="?hoje"><button type="button" class="fc-today-button btn btn-light mr-1">Hoje</button></a>
                                            <a href="?mes=<?php echo $pMes;?>&ano=<?php echo $pAno;?>">
                                                <button type="button" class="fc-next-button btn btn-light" aria-label="next"><span class="fa fa-chevron-right"></span></button>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="fc-center">
                                        <h2><?php echo $meses[$nMes-1].' '.date('Y',$mes)?></h2>
                                    </div>
                                </div>

                                <table class="table table-bordered text-center">
                                    <thead>
                                        <tr>
                                            <th>Domingo</th>
                                            <th>Segunda-feira</th>
                                            <th>Terça-feira</th>
                                            <th>Quarta-feira</th>
                                            <th>Quinta-feira</th>
                                            <th>Sexta-feira</th>
                                            <th>Sábado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $cont = 1;
                                            while($cont <= $dFim){
                                                echo "<tr>";
                                                    for($i = 0; $i < 7; $i++){
                                                        if(($cont == 1 && $sInicio % 7 != $i) || $cont > $dFim){
                                                            echo '<td></td>';
                                                        }
                                                        else{
                                                            $selecionar = isset($_GET['hoje']) && $cont == intval(date('d'))? 'bg-info text-light':'';
                                                            echo '<td class="data '.$selecionar.'" dia="'.$cont.'" mes="'.$nMes.'" ano="'.$nAno.'" onclick="selectData(this)">'.$cont++.'</td>';
                                                        }
                                                    }
                                                echo "<tr>";
                                            }
                                        
                                        ?>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    
                        <div class="col-4" id="jTblDia">
                            <?php require_once('core/ajax/agenda-dia.php');?>
                        </div>

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
    <div class="modal-dialog modal-xg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adicionar novo Contrato</h5>
                <button type="button" class="close" onclick="location.href='?'" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="frmEnviar">
                    <div class="row">
                        <div class="col-9">
                            <?php
                                if(isset($_GET['edt'])){
                                    $resp = $con->query('select * from tbl_contratos where id = '.$_GET['edt']);
                                    $contratos = $resp->fetch_assoc();
                                }
                            ?>

                            <input type="hidden" value="<?php echo isset($_GET['edt'])?'edt':'add';?>" name="cmd">
                            <input type="hidden" value="<?php echo $_GET['edt'];?>" name="id" id="id">
                            <input type="hidden" value="" name="servicos" id="servicos">


                            <h5 class="mt-2">Contrato</h5>
                            <div class="divider"></div>

                            <div class="row">

                                <div class="col">
                                    <label for="cliente">Cliente<span class="ml-2 text-danger">*</span></label>
                                    <select class="form-control mb-3" name="cliente" id="cliente" required onchange="carregaServicos(this)">
                                        <option <?php echo isset($_GET['edt'])? '':'selected';?> disabled>Selecione o cliente</option>
                                        <?php
                                            $resp = $con->query('select id, razaoSocial_nome from tbl_clientes where tipoCliente="on"');
                                            while($row = $resp->fetch_assoc()){
                                                $selected = $contratos['cliente'] == $row['id']? 'selected':'';
                                                var_dump($contratos['cliente'], $row['id'],$contratos['cliente'] == $row['id']);
                                                echo '<option value="'.$row['id'].'" '.$selected.'>'.$row['razaoSocial_nome'].'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                                    
                            </div>

                            <div class="row">

                                <div class="col">
                                    <label for="dataInicial">Data inicial<span class="ml-2 text-danger">*</span></label>
                                    <input type="date" class="form-control mb-3" name="dataInicial" id="dataInicial" value="<?php echo @$contratos['dataInicial'];?>" required>
                                </div>

                                <div class="col">
                                    <label for="dataFinal">Data final<span class="ml-2 text-danger">*</span></label>
                                    <input type="date" class="form-control mb-3" name="dataFinal" id="dataFinal" value="<?php echo @$contratos['dataFinal'];?>" required onchange="calcDuracao()">
                                </div>

                                <div class="col">
                                    <label for="primeiroVencimento">Primeiro vencimento<span class="ml-2 text-danger">*</span></label>
                                    <input type="date" class="form-control mb-3" name="primeiroVencimento" id="primeiroVencimento" value="<?php echo @$contratos['primeiroVencimento'];?>" onchange="primeiroPagamento(this)" required>
                                </div>         
                                
                            </div>

                            <div class="row">

                                <div class="col">
                                    <label for="diaVencimento">Dia do vencimento<span class="ml-2 text-danger">*</span></label>
                                    <input type="number" min="0" max="30" class="form-control mb-3" name="diaVencimento" id="diaVencimento" value="<?php echo @$contratos['diaVencimento'];?>" required>
                                </div>

                                <div class="col">
                                    <label for="duracao">Duração (meses)</label>
                                    <input type="number" min="1" class="form-control mb-3" name="duracao" id="duracao" value="<?php echo @$contratos['duracao'];?>" required>
                                </div>

                                <?php if(isset($_GET['edt'])):?>
                                <div class="col-4">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="1" <?php echo !isset($_GET['edt']) || $contratos['status'] == 1? 'selected':'';?>>Assinar</option>
                                        <option value="2" <?php echo $contratos['status'] == 2? 'selected':'';?>>Em vigência</option>
                                        <option value="3" <?php echo $contratos['status'] == 3? 'selected':'';?>>Encerrado</option>
                                    </select>
                                </div>
                                <?php endif;?>

                            </div>

                            <h5 class="mt-3">Serviços</h5>
                            <div class="divider"></div>

                            <div class="row">
                            
                                <div class="col">
                                    <label for="servico">Serviço<span class="ml-2 text-danger">*</span></label>
                                    <select class="form-control mb-3" id="servico" onchange="valorServico()">
                                        <option selected disabled>Selecione o serviço</option>
                                        <?php
                                            $resp = $con->query('select * from tbl_servicos');
                                            while($row = $resp->fetch_assoc()){
                                                echo '<option value="'.$row['id'].'" valor="'.$row['valor'].'">'.$row['nome'].'</option>';
                                            }

                                        ?>
                                    </select>
                                </div>

                                <div class="col-3">
                                    <label for="valor">Valor<span class="ml-2 text-danger">*</span></label>
                                    <input type="number" min="0" step="0.01" class="form-control mb-3" id="valor" value="<?php echo @$contratos['valor'];?>" required>
                                </div>

                                <div class="col-2">
                                    <div class="btn btn-success mt-4 w-100" onclick="inserirServico()">Inserir</div>
                                </div>

                            </div>

                            <input id="needs-validation" class="d-none" type="submit" value="enviar">
                        </div>

                        <div class="col border-left">
                            <div class="row">
                                <table id="tblServicos" class="table">
                                    <?php
                                        if(isset($contratos['id'])){
                                            $resp = $con->query('select * from tbl_contratosServicos where contrato = '.$contratos['id']);

                                            while($row = $resp->fetch_assoc()){
                                                $nome = $con->query('select nome from tbl_servicos where id = '.$row['servicos'])->fetch_assoc()['nome'];
                                                echo '
                                                    <tr servico="'.$row['servicos'].'" valor="'.$row['valor'].'" codigo="'.$row['id'].'" class="border-bottom">
                                                        <td>'.$nome.'</td>
                                                        <td style="width:14%" class="btn-danger text-center" onclick="removerServico(this)"><i class="fas fa-trash-alt"></i></td>
                                                    </tr>
                                                ';
                                            }
                                        }
                                    ?>
                                </table>
                            </div>
                        </div>

                    </div>       
                </form>

            </div>
            <div class="modal-footer">
                <p class="text-start"><span class="ml-2 text-danger">*</span> Campos obrigatórios</p>
                <button type="button" class="btn btn-secondary" onclick="location.href='?'">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="enviar()"><?php echo isset($_GET['edt'])? 'Atualizar':'Salvar';?></button>
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