<?php include('header.php'); ?>

<?php
if(isset($_POST['cmd'])){
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
        where id = 1
    ');
    redirect($con->error);
}

$resp = $con->query('select * from tbl_configuracao where id = 1');
$usuario = $resp->fetch_assoc();
?>

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

    <div class="row">
        <div class="col">
            
            <div class="card main-card mb-3">
                <div class="card-body">

                    <form method="post">
                        <input type="hidden" value="add" name="cmd">
                        <table class="table table-borderless" id="tbl_configuracao">
                            
                            <tr>
                                <th class="text-right" style="width:14%">Razão social</th>
                                <td><input type="text" name="razao_social" class="form-control w-50" value="<?php echo $usuario['razao_social'];?>" maxlength="120"></td>
                            </tr>
                            <tr>
                                <th class="text-right" style="width:14%">Nome fantasia</th>
                                <td><input type="text" name="nome_fantasia" class="form-control w-50" value="<?php echo $usuario['nome_fantasia'];?>" maxlength="120"></td>
                            </tr>
                            <tr>
                                <th class="text-right" style="width:14%">Cnpj</th>
                                <td><input type="text" name="cnpj" class="form-control w-50" value="<?php echo $usuario['cnpj'];?>" maxlength="20"></td>
                            </tr>
                            <tr>
                                <th class="text-right" style="width:14%">I.E.</th>
                                <td><input type="text" name="ie" class="form-control w-25" value="<?php echo $usuario['ie'];?>" maxlength="20"></td>
                            </tr>
                            <tr>
                                <th class="text-right" style="width:14%">I.M.</th>
                                <td><input type="text" name="im" class="form-control w-25" value="<?php echo $usuario['im'];?>" maxlength="20"></td>
                            </tr>
                            <tr>
                                <th class="text-right" style="width:14%">Cep</th>
                                <td><input type="text" name="cep" class="form-control w-25" value="<?php echo $usuario['cep'];?>" maxlength="9"></td>
                            </tr>
                            <tr>
                                <th class="text-right" style="width:14%">Cidade</th>
                                <td><input type="text" name="cidade" class="form-control w-50" value="<?php echo $usuario['cidade'];?>" maxlength="60"></td>
                            </tr>
                            <tr>
                                <th class="text-right" style="width:14%">IBGE</th>
                                <td><input type="number" name="ibge" class="form-control w-25" value="<?php echo $usuario['ibge'];?>"></td>
                            </tr>
                            <tr>
                                <th class="text-right" style="width:14%">Estado</th>
                                <td><input type="text" name="estado" class="form-control w-25" value="<?php echo $usuario['estado'];?>" maxlength="2"></td>
                            </tr>
                            <tr>
                                <th class="text-right" style="width:14%">Bairro</th>
                                <td><input type="text" name="bairro" class="form-control w-25" value="<?php echo $usuario['bairro'];?>" maxlength="40"></td>
                            </tr>
                            <tr>
                                <th class="text-right" style="width:14%">Endereco</th>
                                <td><input type="text" name="endereco" class="form-control w-50" value="<?php echo $usuario['endereco'];?>" maxlength="120"></td>
                            </tr>
                            <tr>
                                <th class="text-right" style="width:14%">Complemento</th>
                                <td><input type="text" name="complemento" class="form-control w-50" value="<?php echo $usuario['complemento'];?>" maxlength="120"></td>
                            </tr>
                            <tr>
                                <th class="text-right" style="width:14%">Número</th>
                                <td><input type="text" name="numero" class="form-control w-25" value="<?php echo $usuario['numero'];?>" maxlength="10"></td>
                            </tr>
                            <tr>
                                <th class="text-right" style="width:14%">Telefone</th>
                                <td><input type="text" name="telefone" class="form-control w-50" value="<?php echo $usuario['telefone'];?>" maxlength="15"></td>
                            </tr>
                            <tr>
                                <th class="text-right" style="width:14%">CNAE</th>
                                <td><input type="text" name="cnae" class="form-control w-50" value="<?php echo $usuario['cnae'];?>" maxlength="20"></td>
                            </tr>
                            <tr>
                                <th class="text-right" style="width:14%">CRT</th>
                                <td>
                                    <select name="crt" class="form-control w-25">
                                        <option value="0" <?php echo $usuario['crt'] == 0?'selected':'';?>>Simples nacional</option>
                                        <option value="2" <?php echo $usuario['crt'] == 2?'selected':'';?>>Regime normal</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-right" style="width:14%">Email</th>
                                <td><input type="text" name="email" class="form-control w-50" value="<?php echo $usuario['email'];?>" maxlength="120"></td>
                            </tr>
                            <tr>
                                <th class="text-right" style="width:14%">Site</th>
                                <td><input type="text" name="site" class="form-control w-50" value="<?php echo $usuario['site'];?>" maxlength="120"></td>
                            </tr>
                            <tr>
                                <th class="text-right" style="width:14%">Logo</th>
                                <td><input type="text" name="logo" class="form-control w-50" value="<?php echo $usuario['logo'];?>" maxlength="120"></td>
                            </tr>
                            <tr>
                                <th class="text-right" style="width:14%">Msg. Fiscal</th>
                                <td>
                                    <textarea style="resize:none;" name="msg_fiscal" class="form-control w-50"><?php echo $usuario['msg_fiscal'];?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-right" style="width:14%">ISS %</th>
                                <td><input type="number" step="0.01" name="iss" class="form-control w-25" value="<?php echo $usuario['iss'];?>"></td>
                            </tr>
                            <tr>
                                <th class="text-right" style="width:14%">Aliq. S.N. %</th>
                                <td><input type="number" step="0.01" name="aliq_sn" class="form-control w-25" value="<?php echo $usuario['aliq_sn'];?>"></td>
                            </tr>
                            <tr>
                                <th class="text-right" style="width:14%">Aliq. PIS %</th>
                                <td><input type="number" step="0.01" name="aliq_pis" class="form-control w-25" value="<?php echo $usuario['aliq_pis'];?>"></td>
                            </tr>
                            <tr>
                                <th class="text-right" style="width:14%">Aliq. Cofins %</th>
                                <td><input type="number" name="aliq_cofins" step="0.01" class="form-control w-25" value="<?php echo $usuario['aliq_cofins'];?>"></td>
                            </tr>

                            <tr>
                                <td></td>
                                <td><button class="btn btn-primary">Salvar</button></td>
                            </tr>
                        </table>
                    </form>        

                </div>
            </div>

        </div>
    </div>

</div>
<!-- fim conteúdo -->

<?php include('footer.php');?>

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