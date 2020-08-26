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

<script>
    function modal(target){
        $('.collapse:not("'+target+'")').hide('slow');
        $(target).toggle('slow');
    }
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

    <div class="row">
        <div class="col shadow p-2">

            <h3 class="mb-3 text-center">Empresas</h3>
            <div id="accordion" data-children=".card">
                
                <?
                $resp = $con->query('select * from tbl_configuracao');
                while($usuario = $resp->fetch_assoc()):
                ?>

                    <div class="card mb-2">
                        <div class="card-header btn d-flex" onclick="modal('#c-<?=$usuario['id']?>')">
                            <a class="card-link"><?=$usuario['razao_social']?> - <?=$usuario['cnpj']?></a><span class="btn ml-auto"><a class="btn text-danger" href="?del=<?=$usuario['id']?>"><i class="fa fa-trash"></i></a></span>
                        </div>
                        <div class="collapse" id="c-<?=$usuario['id']?>">
                            <div class="card-body">
                                
                                <form method="post">
                                    <input type="hidden" value="edt" name="cmd">
                                    <input type="hidden" value="<?=$usuario['id'];?>" name="id">
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

                <?endwhile;?>

                <div class="card mb-2">
                    <div class="card-header bg-success text-light text-center d-flex btn" onclick="modal('#c-novo')">
                        <h3 class="m-auto"><i class="fas fa-plus-circle"></i></h3>
                    </div>
                    <div class="collapse" id="c-novo">
                        <div class="card-body">
                            
                            <form method="post">
                                <input type="hidden" value="add" name="cmd">
                                <table class="table table-borderless" id="tbl_configuracao">
                                    
                                    <tr>
                                        <th class="text-right" style="width:14%">Razão social</th>
                                        <td><input type="text" name="razao_social" class="form-control w-50" value="" maxlength="120"></td>
                                    </tr>
                                    <tr>
                                        <th class="text-right" style="width:14%">Nome fantasia</th>
                                        <td><input type="text" name="nome_fantasia" class="form-control w-50" value="" maxlength="120"></td>
                                    </tr>
                                    <tr>
                                        <th class="text-right" style="width:14%">Cnpj</th>
                                        <td><input type="text" name="cnpj" class="form-control w-50" value="" maxlength="20"></td>
                                    </tr>
                                    <tr>
                                        <th class="text-right" style="width:14%">I.E.</th>
                                        <td><input type="text" name="ie" class="form-control w-25" value="" maxlength="20"></td>
                                    </tr>
                                    <tr>
                                        <th class="text-right" style="width:14%">I.M.</th>
                                        <td><input type="text" name="im" class="form-control w-25" value="" maxlength="20"></td>
                                    </tr>
                                    <tr>
                                        <th class="text-right" style="width:14%">Cep</th>
                                        <td><input type="text" name="cep" class="form-control w-25" value="" maxlength="9"></td>
                                    </tr>
                                    <tr>
                                        <th class="text-right" style="width:14%">Cidade</th>
                                        <td><input type="text" name="cidade" class="form-control w-50" value="" maxlength="60"></td>
                                    </tr>
                                    <tr>
                                        <th class="text-right" style="width:14%">IBGE</th>
                                        <td><input type="number" name="ibge" class="form-control w-25" value=""></td>
                                    </tr>
                                    <tr>
                                        <th class="text-right" style="width:14%">Estado</th>
                                        <td><input type="text" name="estado" class="form-control w-25" value="" maxlength="2"></td>
                                    </tr>
                                    <tr>
                                        <th class="text-right" style="width:14%">Bairro</th>
                                        <td><input type="text" name="bairro" class="form-control w-25" value="" maxlength="40"></td>
                                    </tr>
                                    <tr>
                                        <th class="text-right" style="width:14%">Endereco</th>
                                        <td><input type="text" name="endereco" class="form-control w-50" value="" maxlength="120"></td>
                                    </tr>
                                    <tr>
                                        <th class="text-right" style="width:14%">Complemento</th>
                                        <td><input type="text" name="complemento" class="form-control w-50" value="" maxlength="120"></td>
                                    </tr>
                                    <tr>
                                        <th class="text-right" style="width:14%">Número</th>
                                        <td><input type="text" name="numero" class="form-control w-25" value="" maxlength="10"></td>
                                    </tr>
                                    <tr>
                                        <th class="text-right" style="width:14%">Telefone</th>
                                        <td><input type="text" name="telefone" class="form-control w-50" value="" maxlength="15"></td>
                                    </tr>
                                    <tr>
                                        <th class="text-right" style="width:14%">CNAE</th>
                                        <td><input type="text" name="cnae" class="form-control w-50" value="" maxlength="20"></td>
                                    </tr>
                                    <tr>
                                        <th class="text-right" style="width:14%">CRT</th>
                                        <td>
                                            <select name="crt" class="form-control w-25">
                                                <option value="0" selected>Simples nacional</option>
                                                <option value="2" >Regime normal</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-right" style="width:14%">Email</th>
                                        <td><input type="text" name="email" class="form-control w-50" value="" maxlength="120"></td>
                                    </tr>
                                    <tr>
                                        <th class="text-right" style="width:14%">Site</th>
                                        <td><input type="text" name="site" class="form-control w-50" value="" maxlength="120"></td>
                                    </tr>
                                    <tr>
                                        <th class="text-right" style="width:14%">Logo</th>
                                        <td><input type="text" name="logo" class="form-control w-50" value="" maxlength="120"></td>
                                    </tr>
                                    <tr>
                                        <th class="text-right" style="width:14%">Msg. Fiscal</th>
                                        <td>
                                            <textarea style="resize:none;" name="msg_fiscal" class="form-control w-50"></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-right" style="width:14%">ISS %</th>
                                        <td><input type="number" step="0.01" name="iss" class="form-control w-25" value=""></td>
                                    </tr>
                                    <tr>
                                        <th class="text-right" style="width:14%">Aliq. S.N. %</th>
                                        <td><input type="number" step="0.01" name="aliq_sn" class="form-control w-25" value=""></td>
                                    </tr>
                                    <tr>
                                        <th class="text-right" style="width:14%">Aliq. PIS %</th>
                                        <td><input type="number" step="0.01" name="aliq_pis" class="form-control w-25" value=""></td>
                                    </tr>
                                    <tr>
                                        <th class="text-right" style="width:14%">Aliq. Cofins %</th>
                                        <td><input type="number" name="aliq_cofins" step="0.01" class="form-control w-25" value=""></td>
                                    </tr>

                                    <tr>
                                        <td></td>
                                        <td><button class="btn btn-primary">Adicionar</button></td>
                                    </tr>
                                </table>
                            </form>

                        </div>
                    </div>
                </div>

            </div>

        </div>

        <div class="col shadow p-2 ml-2">
            <h3 class="mb-3 text-center">Impressora Etiqueta</h3>

            <form method="POST">
                <?$confImp = $con->query('select * from tbl_confImp')->fetch_all();?>

                <input type="hidden" name="cmd" value="impressora">

                <div class="row mb-3">
                    <div class="col-4 d-flex">
                        <span class="mt-auto mb-auto">Configuração geral</span>
                    </div>
                    <div class="col">
                        <div class="row mb-3">
                            <div class="col">
                                <label>Alt. Etiqueta</label>
                                <input type="number" class="form-control" value="<?=$confImp[0][11]?>" name="geral[linha]">
                            </div>
                            <div class="col">
                                <label>Larg. Etiqueta</label>
                                <input type="number" class="form-control" value="<?=$confImp[0][12]?>" name="geral[coluna]">
                            </div>
                            <div class="col">
                                <label>Margens</label>
                                <input type="number" class="form-control" value="<?=$confImp[0][13]?>" name="geral[margem]">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label>Esp. linhas</label>
                                <input type="number" class="form-control" value="<?=$confImp[0][10]?>" name="geral[espacamento]">
                            </div>
                            <div class="col">
                                <label>Esp. etiqueta</label>
                                <input type="number" class="form-control" value="<?=$confImp[0][14]?>" name="geral[tEspacamento]">
                            </div>
                        </div>
                    </div>
                    
                </div>

                <div class="text-center">
                    <strong>Largura</strong>
                </div>
                <table class="table">
                    <tr>
                        <th style="width:30%"></th>
                        <th>1ª Coluna</th>
                        <th>2ª Coluna</th>
                        <th>3ª Coluna</th>
                        <th>4ª Coluna</th>
                    </tr>
                    <tr>
                        <td>Campo código:</td>
                        <td><input type="number" class="form-control" step="0.01" name="larg[codigo][]" value="<?=$confImp[0][3]?>"></td>
                        <td><input type="number" class="form-control" step="0.01" name="larg[codigo][]" value="<?=$confImp[1][3]?>"></td>
                        <td><input type="number" class="form-control" step="0.01" name="larg[codigo][]" value="<?=$confImp[2][3]?>"></td>
                        <td><input type="number" class="form-control" step="0.01" name="larg[codigo][]" value="<?=$confImp[3][3]?>"></td>
                    </tr>
                    <tr>
                        <td>Campo peso:</td>
                        <td><input type="number" class="form-control" step="0.01" name="larg[peso][]" value="<?=$confImp[0][4]?>"></td>
                        <td><input type="number" class="form-control" step="0.01" name="larg[peso][]" value="<?=$confImp[1][4]?>"></td>
                        <td><input type="number" class="form-control" step="0.01" name="larg[peso][]" value="<?=$confImp[2][4]?>"></td>
                        <td><input type="number" class="form-control" step="0.01" name="larg[peso][]" value="<?=$confImp[3][4]?>"></td>
                    </tr>
                    <tr>
                        <td>Campo preço:</td>
                        <td><input type="number" class="form-control" step="0.01" name="larg[preco][]" value="<?=$confImp[0][5]?>"></td>
                        <td><input type="number" class="form-control" step="0.01" name="larg[preco][]" value="<?=$confImp[1][5]?>"></td>
                        <td><input type="number" class="form-control" step="0.01" name="larg[preco][]" value="<?=$confImp[2][5]?>"></td>
                        <td><input type="number" class="form-control" step="0.01" name="larg[preco][]" value="<?=$confImp[3][5]?>"></td>
                    </tr>
                    <tr>
                        <td>Campo tamanho:</td>
                        <td><input type="number" class="form-control" step="0.01" name="larg[tamanho][]" value="<?=$confImp[0][6]?>"></td>
                        <td><input type="number" class="form-control" step="0.01" name="larg[tamanho][]" value="<?=$confImp[1][6]?>"></td>
                        <td><input type="number" class="form-control" step="0.01" name="larg[tamanho][]" value="<?=$confImp[2][6]?>"></td>
                        <td><input type="number" class="form-control" step="0.01" name="larg[tamanho][]" value="<?=$confImp[3][6]?>"></td>
                    </tr>
                    <tr>
                        <td>Campo quantidade:</td>
                        <td><input type="number" class="form-control" step="0.01" name="larg[quantidade][]" value="<?=$confImp[0][7]?>"></td>
                        <td><input type="number" class="form-control" step="0.01" name="larg[quantidade][]" value="<?=$confImp[1][7]?>"></td>
                        <td><input type="number" class="form-control" step="0.01" name="larg[quantidade][]" value="<?=$confImp[2][7]?>"></td>
                        <td><input type="number" class="form-control" step="0.01" name="larg[quantidade][]" value="<?=$confImp[3][7]?>"></td>
                    </tr>
                    <tr>
                        <td>Campo descrição:</td>
                        <td><input type="number" class="form-control" step="0.01" name="larg[descricao][]" value="<?=$confImp[0][8]?>"></td>
                        <td><input type="number" class="form-control" step="0.01" name="larg[descricao][]" value="<?=$confImp[1][8]?>"></td>
                        <td><input type="number" class="form-control" step="0.01" name="larg[descricao][]" value="<?=$confImp[2][8]?>"></td>
                        <td><input type="number" class="form-control" step="0.01" name="larg[descricao][]" value="<?=$confImp[3][8]?>"></td>
                    </tr>
                    <tr>
                        <td>Campo código de barras:</td>
                        <td><input type="number" class="form-control" step="0.01" name="larg[barras][]" value="<?=$confImp[0][9]?>"></td>
                        <td><input type="number" class="form-control" step="0.01" name="larg[barras][]" value="<?=$confImp[1][9]?>"></td>
                        <td><input type="number" class="form-control" step="0.01" name="larg[barras][]" value="<?=$confImp[2][9]?>"></td>
                        <td><input type="number" class="form-control" step="0.01" name="larg[barras][]" value="<?=$confImp[3][9]?>"></td>
                    </tr>
                </table>

                <div class="text-center">
                    <strong>Altura</strong>
                </div>
                <table class="table">
                    <tr>
                        <th style="width:30%"></th>
                        <th>1ª Coluna</th>
                        <th>2ª Coluna</th>
                        <th>3ª Coluna</th>
                        <th>4ª Coluna</th>
                    </tr>
                    <tr>
                        <td>Campo código:</td>
                        <td><input type="number" class="form-control" step="0.01" name="alt[codigo][]" value="<?=$confImp[4][3]?>"></td>
                        <td><input type="number" class="form-control" step="0.01" name="alt[codigo][]" value="<?=$confImp[5][3]?>"></td>
                        <td><input type="number" class="form-control" step="0.01" name="alt[codigo][]" value="<?=$confImp[6][3]?>"></td>
                        <td><input type="number" class="form-control" step="0.01" name="alt[codigo][]" value="<?=$confImp[7][3]?>"></td>
                    </tr>
                    <tr>
                        <td>Campo peso:</td>
                        <td><input type="number" class="form-control" step="0.01" name="alt[peso][]" value="<?=$confImp[4][4]?>"></td>
                        <td><input type="number" class="form-control" step="0.01" name="alt[peso][]" value="<?=$confImp[5][4]?>"></td>
                        <td><input type="number" class="form-control" step="0.01" name="alt[peso][]" value="<?=$confImp[6][4]?>"></td>
                        <td><input type="number" class="form-control" step="0.01" name="alt[peso][]" value="<?=$confImp[7][4]?>"></td>
                    </tr>
                    <tr>
                        <td>Campo preço:</td>
                        <td><input type="number" class="form-control" step="0.01" name="alt[preco][]" value="<?=$confImp[4][5]?>"></td>
                        <td><input type="number" class="form-control" step="0.01" name="alt[preco][]" value="<?=$confImp[5][5]?>"></td>
                        <td><input type="number" class="form-control" step="0.01" name="alt[preco][]" value="<?=$confImp[6][5]?>"></td>
                        <td><input type="number" class="form-control" step="0.01" name="alt[preco][]" value="<?=$confImp[7][5]?>"></td>
                    </tr>
                    <tr>
                        <td>Campo tamanho:</td>
                        <td><input type="number" class="form-control" step="0.01" name="alt[tamanho][]" value="<?=$confImp[4][6]?>"></td>
                        <td><input type="number" class="form-control" step="0.01" name="alt[tamanho][]" value="<?=$confImp[5][6]?>"></td>
                        <td><input type="number" class="form-control" step="0.01" name="alt[tamanho][]" value="<?=$confImp[6][6]?>"></td>
                        <td><input type="number" class="form-control" step="0.01" name="alt[tamanho][]" value="<?=$confImp[7][6]?>"></td>
                    </tr>
                    <tr>
                        <td>Campo quantidade:</td>
                        <td><input type="number" class="form-control" step="0.01" name="alt[quantidade][]" value="<?=$confImp[4][7]?>"></td>
                        <td><input type="number" class="form-control" step="0.01" name="alt[quantidade][]" value="<?=$confImp[5][7]?>"></td>
                        <td><input type="number" class="form-control" step="0.01" name="alt[quantidade][]" value="<?=$confImp[6][7]?>"></td>
                        <td><input type="number" class="form-control" step="0.01" name="alt[quantidade][]" value="<?=$confImp[7][7]?>"></td>
                    </tr>
                    <tr>
                        <td>Campo descrição:</td>
                        <td><input type="number" class="form-control" step="0.01" name="alt[descricao][]" value="<?=$confImp[4][8]?>"></td>
                        <td><input type="number" class="form-control" step="0.01" name="alt[descricao][]" value="<?=$confImp[5][8]?>"></td>
                        <td><input type="number" class="form-control" step="0.01" name="alt[descricao][]" value="<?=$confImp[6][8]?>"></td>
                        <td><input type="number" class="form-control" step="0.01" name="alt[descricao][]" value="<?=$confImp[7][8]?>"></td>
                    </tr>
                    <tr>
                        <td>Campo código de barras:</td>
                        <td><input type="number" class="form-control" step="0.01" name="alt[barras][]" value="<?=$confImp[4][9]?>"></td>
                        <td><input type="number" class="form-control" step="0.01" name="alt[barras][]" value="<?=$confImp[5][9]?>"></td>
                        <td><input type="number" class="form-control" step="0.01" name="alt[barras][]" value="<?=$confImp[6][9]?>"></td>
                        <td><input type="number" class="form-control" step="0.01" name="alt[barras][]" value="<?=$confImp[7][9]?>"></td>
                    </tr>
                </table>

                <input type="submit">
            </form>
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