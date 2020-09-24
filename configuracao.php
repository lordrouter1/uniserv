<?php include('header.php'); ?>
<?php
if(isset($_POST['cmd'])){
    switch($_POST['cmd']){
        case 'add':
            $con->query('INSERT INTO `tbl_configuracao`(`razao_social`,`cnpj`,`endereco`,`complemento`,`cidade`,`cep`,`telefone`,`im`,`cnae`,`crt`,`email`,`site`,`logo`,`msg_fiscal`,`ie`,`numero`,`bairro`,`estado`,`ibge`,`iss`,`aliq_sn`,`aliq_pis`,`aliq_cofins`,`nome_fantasia`) VALUES (
                "'.$_POST['razao_social'].'",
                "'.$_POST['cnpj'].'",
                "'.$_POST['endereco'].'",
                "'.$_POST['complemento'].'",
                "'.$_POST['cidade'].'",
                "'.$_POST['cep'].'",
                "'.$_POST['telefone'].'",
                "'.$_POST['im'].'",
                "'.$_POST['cnae'].'",
                "'.$_POST['crt'].'",
                "'.$_POST['email'].'",
                "'.$_POST['site'].'",
                "'.$_POST[''].'",
                "'.$_POST['msg_fiscal'].'",
                "'.$_POST['ie'].'",
                "'.$_POST['numero'].'",
                "'.$_POST['bairro'].'",
                "'.$_POST['estado'].'",
                "'.$_POST['ibge'].'",
                "'.$_POST['iss'].'",
                "'.$_POST['aliq_sn'].'",
                "'.$_POST['aliq_pis'].'",
                "'.$_POST['aliq_cofins'].'",
                "'.$_POST['nome_fantasia'].'"
            )');
            $con->query('INSERT into tbl_usuarioMeta(meta,valor,descricao,status,usuario) values("habilitar_empresa",'.$con->insert_id.',"",1,0)');
            redirect($con->error);
        break;

        case 'edt':
            $con->query('update tbl_configuracao set
            razao_social = "'.$_POST['razao_social'].'",
            cnpj = "'.$_POST['cnpj'].'",
            endereco = "'.$_POST['endereco'].'",
            complemento = "'.$_POST['complemento'].'",
            cidade = "'.$_POST['cidade'].'",
            cep = "'.$_POST['cep'].'",
            telefone = "'.$_POST['telefone'].'",
            im = "'.$_POST['im'].'",
            cnae = "'.$_POST['cnae'].'",
            crt = "'.$_POST['crt'].'",
            email = "'.$_POST['email'].'",
            site = "'.$_POST['site'].'",
            logo = "'.$_POST[''].'",
            msg_fiscal = "'.$_POST['msg_fiscal'].'",
            ie = "'.$_POST['ie'].'",
            numero = "'.$_POST['numero'].'",
            bairro = "'.$_POST['bairro'].'",
            estado = "'.$_POST['estado'].'",
            ibge = "'.$_POST['ibge'].'",
            iss = "'.$_POST['iss'].'",
            aliq_sn = "'.$_POST['aliq_sn'].'",
            aliq_pis = "'.$_POST['aliq_pis'].'",
            aliq_cofins = "'.$_POST['aliq_cofins'].'",
            nome_fantasia = "'.$_POST['nome_fantasia'].'"
            where id = '.$_POST['id'].'
        ');
        redirect($con->error);
        break;

        case 'impressora':
            for($i = 0; $i < 4; $i++){
                $v = $_POST['larg'];
                $con->query('update tbl_confImp set codigo = '.$v['codigo'][$i].', peso = '.$v['peso'][$i].', preco = '.$v['preco'][$i].', tamanho = '.$v['tamanho'][$i].', quantidade = '.$v['quantidade'][$i].', descricao = '.$v['descricao'][$i].', barras = '.$v['barras'][$i].' where direcao = "l" and coluna = '.($i+1));
                $v = $_POST['alt'];
                $con->query('update tbl_confImp set codigo = '.$v['codigo'][$i].', peso = '.$v['peso'][$i].', preco = '.$v['preco'][$i].', tamanho = '.$v['tamanho'][$i].', quantidade = '.$v['quantidade'][$i].', descricao = '.$v['descricao'][$i].', barras = '.$v['barras'][$i].' where direcao = "a" and coluna = '.($i+1));
            }
            $con->query('update tbl_confImp set 
                espacamento = '.$_POST['geral']['espacamento'].', 
                linha = '.$_POST['geral']['linha'].', 
                tColuna = '.$_POST['geral']['coluna'].',
                margem = '.$_POST['geral']['margem'].',
                tEspacamento = '.$_POST['geral']['tEspacamento'].'    
            ');
        break;
    }
}
elseif(isset($_GET['del'])){
    $con->query('DELETE FROM `tbl_configuracao` WHERE id = '.$_GET['del']);
    $con->query('DELETE from tbl_usuarioMeta where meta = "habilitar_empresa" and valor = '.$_GET['del']);
    redirect($con->error);
}

$resp = $con->query('select * from tbl_configuracao where id = 1');
$usuario = $resp->fetch_assoc();

?>

<div id="my_camera"></div>

<script src="assets/scripts/lib/webcam/webcam.min.js"></script>
<script>
    Webcam.set({
        width: 320,
        height: 240,
        image_format: 'jpeg',
        jpeg_quality: 90
    });

    function modalFoto(doc){
        $('#mdl-confPagamento').modal();
        $('#imgPhoto').attr('target',doc);
        window.Webcam.reset();
        window.Webcam.attach('#imgArea');
    }

    function baterFoto(){
        window.Webcam.snap(function(data_uri){
            $('#imgArea').toggle();
            $('#imgPhoto').attr('src',data_uri);
            $('#imgPhoto').addClass('show');
            $('#imgPhoto').toggle();
        });
    }
    
    function limparFoto(){
        $('#imgPhoto').attr('src','');
        if($('#imgPhoto').is('.show')){
            $('#imgPhoto').toggle();
            $('#imgArea').toggle();
            $('#imgPhoto').removeClass('show');    
        }
        else{
            $('#mdl-confPagamento').modal('hide');
            window.Webcam.reset();
        }
    }

    function salvarFoto(){
        if($('#imgPhoto').is('.show')){
            $('#imgPhoto').toggle();
            $('#imgArea').toggle();
            $('#imgPhoto').removeClass('show');
            $('#'+$('#imgPhoto').attr('target')).val($('#imgPhoto').attr('src'));
            window.Webcam.reset();
            $('#mdl-confPagamento').modal('hide');
            $('#check-'+$('#imgPhoto').attr('target')).toggle();
        }
    }

    function modal(target){
        $('.collapse:not("'+target+'")').hide('slow');
        $(target).toggle('slow');
    }
    
    function getEmpresa(self){
        $('#compEmpresaID').val($(self).val());
        $('#bancoEmpresaID').val($(self).val());
        let liberar = false;

        $('#compEmpresa').css('display','block');
        $('#bancoEmpresa').css('display','none');
        $('#docsEmpresa').css('display','none');
        $('#habilitarEmpresa').css('display','none');
        
        $.get('core/ajax/configuracao/compEmpresa.php?id='+$(self).val(),function(resp){
            if(resp != 'null'){
                resp = JSON.parse(resp);
                $('#area').val(resp['area']);
                $('#tipo').val(resp['tipo']);
                $('#descricao').val(resp['descricao']);
                $('#respLegal').val(resp['respLegal']);
                $('#docResp').val(resp['docResp']);
                $('#aniversarioResp').val(resp['dataResp']);
                $('#bancoEmpresa').css('display','block');
                liberar = true;
            }
            else{
                $('#area').val('');
                $('#tipo').val('');
                $('#descricao').val('');
                $('#respLegal').val('');
                $('#docResp').val('');
                $('#aniversarioResp').val('');
                liberar = false;
            }
        });

        $.get('core/ajax/configuracao/bancoEmpresa.php?id='+$(self).val(),function(resp){
            if(resp != 'null'){
                resp = JSON.parse(resp);
                $('#banco').val(resp['banco']);
                $('#agencia').val(resp['agencia']);
                $('#conta').val(resp['conta']);
                $('#responsavel').val(resp['responsavel']);
                $('#documento').val(resp['documento']);
                $('#docsEmpresa').css('display','block');
                $('#habilitarEmpresa').css('display','block');
            }
            else{
                $('#banco').val('');
                $('#agencia').val('');
                $('#conta').val('');
                $('#responsavel').val('');
                $('#documento').val('');
            }
        });

        $.get('core/ajax/configuracao/ativarJuno.php?id='+$(self).val(),function(resp){
            if(resp == 'null') return;
            
            resp = JSON.parse(resp);
            
            if(resp['pagamentoStatus'] == "1"){
                $('#habilitarPagamento').attr('checked',true);
                $('#habilitarPagamento').addClass(':checked');
                $('#habilitarPagamento').attr('checked');
            }
            else{
                $('#habilitarPagamento').removeAttr('checked');
                $('#habilitarPagamento').removeClass(':checked');
            } 
        });
        
    }
    
    $(document).ready(function(){
        $('.nav-link[data-target]').click(function(){
            $('.nav-link[data-target]').removeClass('active');
            $('.tab-pane').removeClass('active');
            $('.tab-pane').addClass('fade');
            $(this).addClass('active');
            $($(this).attr('data-target')).removeClass('fade');
            $($(this).attr('data-target')).addClass('active');

        });

        $("#compEmpresa").submit(function(e){
            const data = $(this).serializeArray();
            $.post('core/ajax/configuracao/compEmpresa.php',data,function(resp){
                loadToastNR(resp);
                $('#bancoEmpresa').css('display','block');
            });
            e.preventDefault();
        });

        $("#bancoEmpresa").submit(function(e){
            const data = $(this).serializeArray();
            $.post('core/ajax/configuracao/bancoEmpresa.php',data,function(resp){
                loadToastNR(resp);
                $('#habilitarEmpresa').css('display','block');
            });
            e.preventDefault();
        });

        $('#docsEmpresa').submit(function(e){
            const data = $(this).serializeArray();
            $.post('core/ajax/configuracao/enviarDoc.php',data,function(resp){
                console.log(resp);
                //loadToastNR(resp);
                //$('#habilitarEmpresa').css('display','block');
            });
            e.preventDefault();
        });

        $('#habilitarPagamento').click(function(){
            const idEmpresa = $('#habilitarPagamentoEmpresa').val();
            const status = $(this).is(':checked') || $(this).attr('checked') == 'checked'? true:false;
            $.post('core/ajax/configuracao/ativarJuno.php',{empresa:idEmpresa,habilitar:status},function(resp){
                console.log(resp);
                if(resp != 'true'){
                    $('#habilitarPagamento').click();
                }
                //loadToastNR(resp);
            });
        });
    });
</script>

<!-- cabeçalho da página -->
<div class="app-page-title">

    <div class="page-title-wrapper">

        <div class="page-title-heading">

            <div class="page-title-icon">
                <i class="fas fa-user-cog icon-gradient bg-happy-itmeo"></i>
            </div>
            <div>
                <span>Configuracao</span>
                <div class="page-title-subheading">
                    Campo para configurações do sistema
                </div>
            </div>

        </div>
        
    </div>
</div>
<!-- fim cabeçalho-->

<!-- conteúdo -->
<div class="content">

    <div class="nav nav-tabs mb-0">
        <li class="nav-item">
            <a class="nav-link" data-target="#geral">Geral</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active"  data-target="#pagamento">Pagamento</a>
        </li>
        <li class="nav-item">
            <a class="nav-link"  data-target="#impressao">Impressão</a>
        </li>
    </div>
    
    <div class="tab-content">
        <div class="tab-pane fade" id="geral">
            <?include('pag/configuracao/geral.php');?>
        </div>
        <div class="tab-pane active" id="pagamento">
            <?include('pag/configuracao/pagamento.php')?>
        </div>
        <div class="tab-pane fade" id="impressao">
            <?include('pag/configuracao/impressao.php');?>
        </div>
    </div>

</div>
<!-- fim conteúdo -->

<?php include('footer.php');?>

<div class="modal" tabindex="-1" role="dialog" id="mdl-confPagamento">
    <div class="modal-dialog">
        <div class="modal-content">
            
            <div class="modal-body">

                <div class="row">
                    <div class="col d-flex">
                        <span id="imgArea" class="m-auto"></span>
                        <img id="imgPhoto" src="" class="m-auto" style="display:none">
                    </div>
                </div>
                <div class="row">
                    <div class="col d-flex">
                        <div class="ml-auto mr-auto mt-4">
                            <i class="btn text-danger fas fa-times-circle" onclick="limparFoto();" style="font-size: 2rem"></i>
                            <i class="btn btn-outline-primary fas fa-camera" onclick="baterFoto()" style="font-size: 2rem"></i>
                            <i class="btn text-success fas fa-check-circle" onclick="salvarFoto()" style="font-size: 2rem"></i>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

<div id="toast-container" class="toast-top-center mt-3">
    <div id="toast-success" class="toast toast-success" aria-live="polite" style="opacity: 0.899999;display:none;">
        <div class="toast-title">Sucesso!</div>
    </div>
    <div id="toast-error" class="toast toast-error hidden" aria-live="polite" style="opacity: 0.899999;display:none;">
        <div class="toast-title">Erro!</div>
    </div>
</div>