<?php include('header.php'); ?>

<?php

if(isset($_POST['cmd'])){
    $cmd = $_POST['cmd'];

    if($cmd == "add"){
        $query = 'insert into tbl_cfop(cfop,descricao) values(
            "'.$_POST['codigo'].'",
            "'.$_POST['descricao'].'"
        )';
        $con->query($query);
        redirect($con->error);
    }
    elseif($cmd == "edt"){
        $query = 'update tbl_cfop set
            cfop = "'.$_POST['codigo'].'",
            descricao = "'.$_POST['descricao'].'"
            where id = '.$_POST['id'].'
        ';
        $con->query($query);
        redirect($con->error);
    }
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
                <i class="fas fa-dollar-sign icon-gradient bg-happy-itmeo"></i>
            </div>
            <div>
                <span>Cadastro de CFOP</span>
                <div class="page-title-subheading">
                    Campo para adição, remoção e edição de CFOP
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
                            <a class="nav-link text-dark" target="_blank" href="exp.php?tbl=cfop">
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

                    <h5 class="card-title">Ordens de serviços</h5>
                    <input type="text" class="mb-2 form-control w-25" placeholder="Pesquisar" id="campoPesquisa">

                    <table class="table mb-0 table-striped table-hover" id="tablePrint">
                        <thead >
                            <tr>
                                <th style="width:2%">ID</th>
                                <th style="width:12%">Código</th>
                                <th>Descrição</th>
                                <th class="noPrint" style="width:6%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $resp = $con->query('select * from tbl_cfop');

                                while($row = $resp->fetch_assoc()){
                                    echo '
                                        <tr>
                                            <td>'.$row['id'].'</td>
                                            <td>'.number_format($row['cfop'],0,'','.').'</td>
                                            <td>'.$row['descricao'].'</td>
                                            <td class="noPrint text-center"><a href="?edt='.$row['id'].'" class="btn"><i class="fas fa-user-edit icon-gradient bg-happy-itmeo"></i></a></td>
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
                            $resp = $con->query('select * from tbl_cfop where id = '.$_GET['edt']);
                            $un = $resp->fetch_assoc();
                        }
                    ?>

                    <input type="hidden" value="<?php echo isset($_GET['edt'])?'edt':'add';?>" name="cmd">
                    <input type="hidden" value="<?php echo $_GET['edt'];?>" name="id" id="id">

                    <div class="row">
                        <div class="col">
                            <label for="codigo">Código<span class="ml-2 text-danger">*</span></label>
                            <input type="text" value="<?php echo $un['cfop']; ?>" class="form-control mb-3" name="codigo" id="codigo" maxlength="4" required>
                        </div>
                    </div>

                    

                    <div class="row">
                        <div class="col">
                            <label for="descricao">Descrição<span class="ml-2 text-danger">*</span></label>
                            <textarea class="form-control mb-3" name="descricao" id="descricao" maxlength="200" style="resize:none" required><?php echo $un['descricao'];?></textarea>
                        </div>
                    </div>

                    <input id="needs-validation" class="d-none" type="submit" value="enviar">

                </form>

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